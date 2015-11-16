<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Event;
use App\Repositories\UserRepo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function __construct(UserRepo $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $videoCount     = Video::count();
        $memberCount    = $this->userRepo->countMembers();
        $eventCount     = Event::count();

        return view('admin.index', ['noOfVideos' => $videoCount, 'noOfMembers' => $memberCount, 'noOfEvents' => $eventCount]);
    }

    public function changePasswordPage() {
        return view('admin.change-password');
    }

    public function changePassword(Request $request) {

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);


        if ($validator->fails()) {
            return redirect('/admin/changePassword')->with('errors', $validator->errors()->all());
        } else {
            $user = Auth::user();
            $credentials = [
                'email' => $user->email,
                'password' => $request->get('current_password')
            ];
            $valid = Auth::validate($credentials);
            if ($valid) {
                $user->password = bcrypt($request->get('password'));
                $user->save();

                $request->session()->flash("notif", "Password successfully changed!");

                return redirect('/profile');
            }
            return redirect('/admin/changePassword')->with('errors', ['Input correct current password']);
        }
    }
}
