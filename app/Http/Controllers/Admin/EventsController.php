<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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

        $video= Event::create($params);
        if ($video) {
            $request->session()->flash("notif", "Event successfully added");
            return redirect('/admin/events');
        }

        return  redirect()->back()->withInput($request->all());

    }

}
