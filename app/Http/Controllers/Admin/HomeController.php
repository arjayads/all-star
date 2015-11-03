<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Repositories\UserRepo;

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
}
