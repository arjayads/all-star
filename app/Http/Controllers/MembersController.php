<?php

namespace App\Http\Controllers;

use App\Models\AddRequest;
use App\Repositories\AddRequestRepo;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class MembersController extends Controller
{
    function __construct(AddRequestRepo $addRequestRepo) {
        $this->addRequestRepo = $addRequestRepo;
    }

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

    function requestAdd() {
        $userId = Input::get('userId');
        if ($userId) {
            $user = User::find($userId);
            if ($user) {
                $pr = AddRequest::where('requested_by_user_id', Auth::user()->id)->where('recipient_user_id', $userId)->first();
                if (!$pr) {
                    $request = AddRequest::create(
                        [
                            'requested_by_user_id' => Auth::user()->id,
                            'recipient_user_id' => $userId,
                        ]
                    );

                    if ($request) {
                        return ['success' => true, 'message' => 'Request successfully sent!'];
                    }
                } else {
                    // it actually does nothing
                    return ['success' => true, 'message' => 'Request successfully sent!'];
                }
            }
        }

        return ['success' => false, 'message' => 'Something went wrong!'];
    }

    function myProfile() {

        if (Auth::check()) {
            $user = User::find(Auth::user()->id);
            if ($user) {
                // get pending request
                $requests = $this->addRequestRepo->findByRecipientUserId($user->id);
                return view('member.my-profile')->with('member', $user)->with('requests', $requests);
            } else {
                return redirect('/');
            }
        }

    }

    function requestProcess() {

        try {

            $command = Input::get('command');
            $requesterUserId = Input::get('userId');

            if ($command && $requesterUserId) {
                $requester = User::find($requesterUserId);
                $me = User::find(Auth::user()->id);
                if ($requester && $me) {
                    if ($command == 'Approve') {
                        $me->parent_user_id = $requester->id;
                        $me->approved_at = date("Y-m-d H:i:s");
                        $newMe = $me->save();
                        if ($newMe) {
                            $pr = AddRequest::where('requested_by_user_id', $requesterUserId)->where('recipient_user_id', $me->id)->first();
                            if ($pr) {
                                $pr->delete();
                            }

                            return ['success' => true, 'message' => 'Request successfully approved!'];

                        }
                    } else if ($command == 'Disapprove') {
                        $pr = AddRequest::where('requested_by_user_id', $requesterUserId)->where('recipient_user_id', $me->id)->first();
                        if ($pr) {
                            $deleted = $pr->delete();
                            if ($deleted) {
                                return ['success' => true, 'message' => 'Request successfully disapproved!'];
                            }
                        }
                    }
                }
            }

        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

        return ['success' => false, 'message' => 'Something went wrong!'];
    }
}
