<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MembersController extends Controller
{
    function find() {
        $query = Input::get('term');
        if($query) {
            return User::where('name', 'LIKE', '%'.$query.'%')->take(5)->select('id', 'name as label', 'name as value')->get();
        } else {
            return User::take(5)->select('id', 'name')->get();
        }
    }

    function profile() {

        $id = Input::get('id');
        $user = User::find($id);
        if ($user) {
            return view('member.others-profile')->with('member', $user);
        } else {
            return view('member.others-profile')->with('notFound', true);
        }
    }
}
