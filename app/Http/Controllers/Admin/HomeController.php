<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Repositories\UserRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function __construct(UserRepo $userRepo) {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $vcnt = Video::count();
        $mcnt = $this->userRepo->countMembers();

        return view('admin.index', ['noOfVideos' => $vcnt, 'noOfMembers' => $mcnt]);
    }

    public function changePasswordPage() {
        return view('admin.change-password');
    }

    public function changePassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('/admin/changePassword')->with('errors', $validator->errors()->all());
        }
        return redirect('/profile');
    }
}
