<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StaticPageController extends Controller
{
    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
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
        return view('login');
    }
}
