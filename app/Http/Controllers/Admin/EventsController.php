<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\File;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        $filePath = env('FILE_UPLOAD_PATH');
        $limit = 5 * 1024 * 1024; // 5MB

        $params = $request->except(['_token']);
        $date = \DateTime::createFromFormat('m/d/Y', $params['date']);
        $params['date'] = $date->format('Y-m-d');

        $event= Event::create($params);
        if ($event) {
            $hasAttachment = $request->hasFile('files');
            if ($hasAttachment) {
                $images = $request->file('files');
                foreach($images as $image) {
                    if ($image->getClientSize() <= $limit) {
                        $f = new File();
                        $f->original_filename = $image->getClientOriginalName();
                        $f->new_filename = md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
                        $f->mime_type = $image->getClientMimeType();
                        $f->save();
                        
                        DB::table('event_files')->insert([
                            [
                                'event_id' => $event->id,
                                'file_id' => $f->id
                            ]
                        ]);

                        // handle upload files
                        try {
                            $finalFn = $event->id . '~' . $f->new_filename;
                            \Illuminate\Support\Facades\File::delete($filePath . '/' . $finalFn);
                            $image->move($filePath, $finalFn);
                        } catch (\Exception $x) {
                            throw new \RuntimeException($x);
                        }
                    }
                }
            }
            $request->session()->flash("notif", "Event successfully added");
            return redirect('/admin/events');
        }

        return  redirect()->back()->withInput($request->all());

    }

}
