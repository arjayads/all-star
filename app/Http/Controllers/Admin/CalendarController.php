<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MyFileHelper;
use App\Helpers\MyHelper;
use App\Models\Calendar;
use App\Models\Event;
use App\Models\File;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CalendarController extends Controller
{
    public function index() {
        return view('calendar.admin.index');
    }

    public function store(Requests\SetupCalendarRequest $request)
    {
        $params = $request->except(['_token']);

        $cal= Calendar::create($params);
        if ($cal) {
            return ['error' => false, 'message' => "Calendar entry successfully added"];
        }

        return ['error' => true, 'message' => "Something went wrong!"];

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
