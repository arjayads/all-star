<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelper;
use App\Models\Announcement;
use App\Models\File;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AnnouncementsController extends Controller
{
     public function index() {
        $announcements = Announcement::where('date', '>=', date("Y-m-d"))->orderBy('date', 'asc')->get();
        return view('announcements.index', ['announcements' => $announcements]);
    }

    public function images($announcementId) {
        $images = DB::table('files')
            ->join('announcement_files', 'files.id', '=', 'announcement_files.file_id')
            ->where('announcement_files.announcement_id', $announcementId)
            ->select('file_id', 'original_filename')
            ->get();

        return $images;
    }


    public function image($announcementId, $imageId)
    {
        return MyHelper::getImageAsResponse($announcementId, $imageId);
    }

    public function imageThumb($announcementId, $imageId)
    {
        return MyHelper::getImageAsResponse($announcementId, $imageId, 240);
    }
}
