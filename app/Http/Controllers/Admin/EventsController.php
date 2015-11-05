<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\File;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Response;

class EventsController extends Controller
{
    public function index() {
        $events = Event::where('date', '>=', date("Y-m-d"))->orderBy('date', 'asc')->get();
        return view('events.index', ['events' => $events]);
    }

    function add() {
        return view('events.add');
    }

    public function store(Requests\CreateEventRequest $request)
    {
        $params = $request->except(['_token']);
        $date = \DateTime::createFromFormat('m/d/Y', $params['date']);
        $params['date'] = $date->format('Y-m-d');

        $event= Event::create($params);
        if ($event) {
            $hasAttachment = $request->hasFile('files');
            if ($hasAttachment) {
                $images = $request->file('files');
                $this->handleAttachedImages($images, $event->id);
            }
            $request->session()->flash("notif", "Event successfully added");
            return redirect('/admin/events');
        }

        return  redirect()->back()->withInput($request->all());

    }

    public function show($id)
    {
        $event = Event::findOrFail($id);
        $images = DB::table('files')
            ->join('event_files', 'files.id', '=', 'event_files.file_id')
            ->where('event_files.event_id', $event->id)
            ->get();

        return view('events.detail', ['event' => $event, 'images' => $images]);
    }


    public function image(Request $request, $eventId, $image)
    {
        $image = File::find($image);
        if ($image) {

            $path = env('FILE_UPLOAD_PATH') . '/' . $eventId . '~' . $image->new_filename;
            $file = \Illuminate\Support\Facades\File::get($path);

            return (new Response($file, 200))->header('Content-Type', \Illuminate\Support\Facades\File::mimeType($path));
        }
        $request->session()->flash("notif", "The requested image is not available");
        return redirect('admin/events');
    }


    public function edit(Request $request, $id)
    {
        $event = Event::find($id);
        if ($event) {
            $images = DB::table('files')
                ->join('event_files', 'files.id', '=', 'event_files.file_id')
                ->where('event_files.event_id', $event->id)
                ->get();
            return view('events.edit', ['event' => $event, 'images' => $images]);
        }

        $request->session()->flash("notif", "The requested event is not available");

        return redirect('admin/events');
    }


    public function update(Requests\CreateEventRequest $request, $id)
    {
        $params = $request->except(['_token']);
        $date = \DateTime::createFromFormat('m/d/Y', $params['date']);
        $params['date'] = $date->format('Y-m-d');

        $existingEvent = Event::find($id);

        if ($existingEvent) {
            $existingEvent->update($params);

            $hasAttachment = $request->hasFile('files');
            if ($hasAttachment) {
                $images = $request->file('files');
                $this->handleAttachedImages($images, $existingEvent->id);
            }

            $request->session()->flash("notif", "Event successfully updated");
        } else {
            $request->session()->flash("notif", "The requested event is not available");
        }
        return redirect('admin/events');
    }

    private function handleAttachedImages($images, $eventId) {

        $filePath = env('FILE_UPLOAD_PATH');
        $limit = 5 * 1024 * 1024; // 5MB

        foreach($images as $image) {
            if ($image->getClientSize() <= $limit) {
                $f = new File();
                $f->original_filename = $image->getClientOriginalName();
                $f->new_filename = md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
                $f->mime_type = $image->getClientMimeType();
                $f->save();

                DB::table('event_files')->insert([
                    [
                        'event_id' => $eventId,
                        'file_id' => $f->id
                    ]
                ]);

                // handle upload files
                try {
                    $finalFn = $eventId . '~' . $f->new_filename;
                    $image->move($filePath, $finalFn);
                } catch (\Exception $x) {
                    throw new \RuntimeException($x);
                }
            }
        }
    }
}
