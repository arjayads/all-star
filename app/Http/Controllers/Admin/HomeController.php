<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Repositories\UserRepo;
use Illuminate\Support\Facades\Input;

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

    public function changePassword() {
        $params = Input::all();

        dd($params);
        return view('admin.change-password');
    }
}
