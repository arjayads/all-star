<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelper;
use App\Models\Event;
use App\Models\File;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    public function index() {
        $events = Event::where('date', '>=', date("Y-m-d"))->orderBy('date', 'asc')->get();
        return view('events.index', ['events' => $events]);
    }

    public function images($eventId) {
        $images = DB::table('files')
            ->join('event_files', 'files.id', '=', 'event_files.file_id')
            ->where('event_files.event_id', $eventId)
            ->select('file_id', 'original_filename')
            ->get();

        return $images;
    }


    public function image($eventId, $imageId)
    {
        return MyHelper::getImageAsResponse($eventId, $imageId);
    }

    public function imageThumb($eventId, $imageId)
    {
        return MyHelper::getImageAsResponse($eventId, $imageId, 240);
    }
}
