<?php

namespace App\Http\Controllers;

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
        $image = File::find($imageId);

        if ($image) {
            try {

                $path = $this->imgPath($eventId, $image->new_filename);
                $file = \Illuminate\Support\Facades\File::get($path);

                return response($file, 200)->header('Content-Type', $image->mime_type);
            }catch (\Exception $e) {
                return new \RuntimeException($e);
            }
        }
    }

    private function imgPath($eventId, $filename) {
        return env('FILE_UPLOAD_PATH') . '/' . $eventId . '~' . $filename;
    }
}
