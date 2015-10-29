<?php

namespace App\Http\Controllers\Admin;

use App\FileUploader\FileUploaderPublisher;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Http\Requests;
use App\Models\VideoCategories;
use Illuminate\Support\Facades\File;
use \Illuminate\Http\Response;

class VideosController extends Controller
{
    /**
     * @var FileUploaderPublisher
     */
    private $uploader;

    /**
     * @param FileUploaderPublisher $uploader
     */
    public function __construct(FileUploaderPublisher $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $vids = Video::all();
        return view('admin.videos')->with('videos', $vids);
    }

    public function create()
    {
        $cats = VideoCategories::all()->lists('name','id');
        return view('admin.create')->with('categories', $cats);
    }

    public function store(Requests\CreateVideoRequest $request)
    {
        $params = $request->except(['video', '_token']);
        $vid = $request->file('video');

        $params = $this->setVideoParams($params, $vid);
        $video= Video::create($params);
        $this->uploader->pushFile($vid, $video, $params['original_filename'], $params['upload_filename']);

        $request->session()->flash("notif", "Video successfully uploaded");

        return redirect('admin/videos');
    }

    public function destroy($id)
    {
        $v = Video::find($id);
        if ($v) {
            $res = $v->delete();
            if ($res) {
                return ['error' => false, 'message' => 'Video successfully deleted!'];
            } else {
                return ['error' => true, 'message' => 'Failed to delete!'];
            }
        } else {
            return ['error' => true, 'message' => 'Video not available!'];
        }
    }


    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $cats = VideoCategories::all()->lists('name','id');

        return view('admin.edit', ['video' => $video, 'categories' => $cats]);
    }

    public function update(Requests\CreateVideoRequest $request, $id)
    {
        $params = $request->except(['video', '_token']);
        $newVideo = $request->file('video');

        if ($newVideo) {
            $params = $this->setVideoParams($params, $newVideo);
        }
        $existingVideo = Video::findOrFail($id);

        if ($existingVideo) {
            if ($newVideo) {
                $formerFile = $existingVideo->upload_filename; //to be deleted
            }
            $existingVideo->update($params);

            if ($newVideo) {
                $this->uploader->pushFile($newVideo, $existingVideo, $params['original_filename'], $params['upload_filename'], $formerFile);
            }
        }
        $request->session()->flash("notif", "Video successfully updated");

        return redirect('admin/videos');
    }


    public function show($id)
    {
        $vid = Video::findOrFail($id);
        $path = env('FILE_UPLOAD_PATH') . '/' . $vid->id . '~' . $vid->upload_filename;
        $file = File::get($path);

        return (new Response($file, 200))->header('Content-Type', File::mimeType($path));
    }


    private function setVideoParams($params, $vid) {
        $params['mime_type'] = $vid->getClientMimeType();
        $params['original_filename'] = $vid->getClientOriginalName();
        $params['upload_filename'] = md5($vid->getClientOriginalName()) . '.' . $vid->getClientOriginalExtension();

        return $params;
    }
}
