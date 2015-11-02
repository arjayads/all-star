<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;

class StaticPageController extends Controller
{
    public function __construct(UserRepo $userRepo, Guard $auth)
    {
        $this->userRepo = $userRepo;
        $this->auth = $auth;
    }

    function index()
    {
        try {
            $url = $this->userRepo->findDefaultUrl(Auth::user()->id);
            return redirect($url[0]);
        } catch (\Exception $e) {
        }
        return view('main');
    }

    public function login()
    {
        $this->auth->logout();
        return view('login');
    }
}
