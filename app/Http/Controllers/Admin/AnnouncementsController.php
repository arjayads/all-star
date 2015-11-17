<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MyFileHelper;
use App\Helpers\MyHelper;
use App\Models\Announcement;
use App\Models\File;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class AnnouncementsController extends Controller
{
    public function index() {
        $announcements = Announcement::where('created_at', '>=', date("Y-m-d"))->orderBy('created_at', 'asc')->get();
        return view('announcements.admin.index', ['announcements' => $announcements]);
    }

    function add() {
        return view('announcements.admin.add');
    }

    public function store(Requests\CreateAnnouncementRequest $request)
    {
        $params = $request->except(['_token']);
        $params['user_id'] = Auth::user()->id;
        $announcement = Announcement::create($params);
        if ($announcement) {
            $hasAttachment = $request->hasFile('files');
            if ($hasAttachment) {
                $images = $request->file('files');
                $this->handleAttachedImages($images, $announcement->id);
            }
            $request->session()->flash("notif", "Announcement successfully added");
            return redirect('/announcements');
        }

        return  redirect()->back()->withInput($request->all());

    }

    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        $images = DB::table('files')
            ->join('announcement_files', 'files.id', '=', 'announcement_files.file_id')
            ->where('announcement_files.announcement_id', $announcement->id)
            ->get();

        return view('announcements.admin.detail', ['announcement' => $announcement, 'images' => $images]);
    }

    public function image($announcementId, $imageId)
    {
        return MyHelper::getImageAsResponse($announcementId, $imageId);
    }

    public function imageThumb($announcementId, $imageId)
    {
        return MyHelper::getImageAsResponse($announcementId, $imageId, 240);
    }

    public function edit(Request $request, $id)
    {
        $announcement = Announcement::find($id);
        if ($announcement) {
            $images = DB::table('files')
                ->join('announcement_files', 'files.id', '=', 'announcement_files.file_id')
                ->where('announcement_files.announcement_id', $announcement->id)
                ->select(['files.id', 'original_filename'])
                ->get();
            return view('announcements.admin.edit', ['announcement' => $announcement, 'images' => $images]);
        }

        $request->session()->flash("notif", "The requested announcement is not available");

        return redirect('/announcements');
    }

    public function update(Requests\CreateAnnouncementRequest $request, $id)
    {
        $params = $request->except(['_token']);

        $existingAnnouncement = Announcement::find($id);

        if ($existingAnnouncement) {
            $existingAnnouncement->update($params);

            // managed removed images
            if (isset($params['rem_files'])) {
                $remainingImgIds = $params['rem_files'];
                foreach($remainingImgIds as $fileId) {
                    $imgFile = File::find($fileId);
                    if ($imgFile) {
                        try {
                            // delete from db
                            $imgFile->delete();
                            // delete from local storage
                            \Illuminate\Support\Facades\File::delete(MyHelper::getImageFromStorage($existingAnnouncement->id, $imgFile->new_filename));
                            // unbind from announcement
                            DB::table('announcement_files')->where('announcement_id', $existingAnnouncement->id)->where('file_id', $fileId)->delete();

                        }catch (\Exception $e) {
                            Log::info($e->getMessage());
                        }
                    }
                }
            }

            $hasAttachment = $request->hasFile('files');
            if ($hasAttachment) {
                $images = $request->file('files');
                $this->handleAttachedImages($images, $existingAnnouncement->id);
            }

            $request->session()->flash("notif", "Announcement successfully updated");
        } else {
            $request->session()->flash("notif", "The requested announcement is not available");
        }
        return redirect('/announcements');
    }

    public function destroy(Request $request, $id)
    {
        $v = Announcement::find($id);
        if ($v) {
            // retrieve image detail prior to deletion
            $images = DB::table('files')
                ->join('announcement_files', 'files.id', '=', 'announcement_files.file_id')
                ->where('announcement_files.announcement_id', $id)
                ->get();

            $res = Announcement::where("id", $id)
                ->where('user_id', Auth::user()->id)
                ->delete();
            if ($res) {
                // delete also the images from db and local storage
                if (count($images) > 0) {
                    foreach($images as $image) {
                        try {
                            $imgFile = File::find($image->file_id);
                            if ($imgFile) {
                                $imgFile->delete();
                                \Illuminate\Support\Facades\File::delete(MyHelper::getImageFromStorage($id, $imgFile->new_filename));
                            }
                        }catch (\Exception $e) {
                            Log::info($e->getMessage());
                        }
                    }
                }

                $request->session()->flash("notif", "Announcement successfully deleted");
                return ['error' => false];
            } else {
                return ['error' => true, 'message' => 'Failed to delete announcement!'];
            }
        } else {
            $request->session()->flash("notif", "announcement not available!");
            return ['error' => true];
        }
    }

    private function handleAttachedImages($images, $announcementId) {

        $filePath = env('FILE_UPLOAD_PATH');
        $limit = 5 * 1024 * 1024; // 5MB

        foreach($images as $image) {
            if ($image->getClientSize() <= $limit) {
                $f = new File();
                $f->original_filename = $image->getClientOriginalName();
                $f->new_filename = md5($announcementId . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
                $f->mime_type = $image->getClientMimeType();
                $f->save();

                DB::table('announcement_files')->insert([
                    [
                        'announcement_id' => $announcementId,
                        'file_id' => $f->id
                    ]
                ]);

                // handle upload files
                try {
                    $finalFn = MyHelper::getImageFromStorage($announcementId, $f->new_filename);
                    $image->move($filePath, $finalFn);
                } catch (\Exception $x) {
                    throw new \RuntimeException($x);
                }
            }
        }
    }
}
