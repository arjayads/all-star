<?php

namespace App\Http\Controllers\Admin;

use App\Models\Calendar;
use App\Models\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Illuminate\Support\Facades\Auth;

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

        return Calendar::where('year', $year)->where('month', $month)->select(['date', 'title'])->get()->toArray();
    }

    public function get() {
        $date = Input::get('date');
        return Calendar::where('date', $date)->get()->toArray();
    }

    public function entries(Request $request) {
        $date = Input::get('date');

        $request->session()->put('date', $date);

        $entries = Calendar::join('users', 'users.id', '=', 'calendars.user_id')            
                            ->where('date', $date)
                            ->select('calendars.*', 'users.name')
                            ->get()->toArray();
        if(count($entries) > 0){
            return array('status' => 1, 'entries' => $entries);
        }
        
        return array('status' => 0);
    }

    public function store(Request $request)
    {
        $params['date'] = $request->session()->get('date');
        
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
            $params['user_id'] = Auth::user()->id;
            
            $cal= Calendar::create($params);
            if ($cal) {
                return ['error' => false, 'message' => "Calendar entry successfully added"];
            }
        }
    }

    public function update(Requests\CreateEventRequest $request, $id)
    {

        $params = $request->except(['_token']);
        $existingEvent = Calendar::find($id);

        if ($existingEvent) {
            $existingEvent->update($params);

            $request->session()->flash("notif", "schedule successfully updated");
        } else {
            $request->session()->flash("notif", "The requested schedule is not available");
        }
        return redirect('admin/events');
    }

    public function destroy(Request $request, $id)
    {
        $v = Calendar::find($id);
        if ($v) {
            $v->delete();
            Calendar::where("id", $id)
                ->where('user_id', Auth::user()->id)
                ->delete();
            $request->session()->flash("notif", "schedule successfully deleted");
            return ['error' => false];
        } else {
            $request->session()->flash("notif", "schedule not available!");
            return ['error' => true];
        }
    }
}
