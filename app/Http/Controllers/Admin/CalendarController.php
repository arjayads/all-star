<?php

namespace App\Http\Controllers\Admin;

use App\Models\Calendar;
use App\Models\Event;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class CalendarController extends Controller
{
    public function index() {
        return view('calendar.admin.index');
    }

    public function data() {
        $year = Input::get('year');
        $month = Input::get('month');

        return Calendar::where('year', $year)->where('month', $month)->select(['id', 'date', 'title', 'description'])->get()->toArray();
    }

    public function store(Request $request)
    {
        $params = $request->except(['_token']);
        $v = Validator::make($params, [
            'title' => 'required|min:3|max:255',
            'description'  => 'required|min:10',
            'date'  => 'required'
        ]);

        if ($v->fails()) {
            return ['error' => true, 'messages' => (array)$v->errors()->getMessages()];
        } else {
            $dateElements = explode('-', $params['date']);
            $params['year'] = $dateElements[0];
            $params['month'] = $dateElements[1];

            $cal= Calendar::create($params);
            if ($cal) {
                return ['error' => false, 'message' => "Calendar entry successfully added"];
            }
        }
    }

    public function update(Requests\CreateEventRequest $request, $id)
    {

        $params = $request->except(['_token']);
        $existingEvent = Event::find($id);

        if ($existingEvent) {
            $existingEvent->update($params);

            $request->session()->flash("notif", "Event successfully updated");
        } else {
            $request->session()->flash("notif", "The requested event is not available");
        }
        return redirect('admin/events');
    }

    public function destroy(Request $request, $id)
    {
        $v = Event::find($id);
        if ($v) {
            $request->session()->flash("notif", "Event successfully deleted");
            return ['error' => false];
        } else {
            $request->session()->flash("notif", "Event not available!");
            return ['error' => true];
        }
    }
}
