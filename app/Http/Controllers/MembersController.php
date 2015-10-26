<?php

namespace App\Http\Controllers;

use App\Models\AddRequest;
use App\Repositories\AddRequestRepo;
use App\Repositories\UserRepo;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class MembersController extends Controller
{
    function __construct(AddRequestRepo $addRequestRepo, UserRepo $userRepo) {
        $this->addRequestRepo = $addRequestRepo;
        $this->userRepo = $userRepo;
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

        if ( Auth::user()->id == $id) {
            return redirect("/profile");
        }

        $user = User::find($id);
        if ($user) {
            $data = ['member' => $user];

            $request = AddRequest::where('requested_by_user_id', Auth::user()->id)->where('recipient_user_id', $user->id)->first();
            if ($request) {
                $data['request'] = $request;
            }
            // check if a member available for the new team
            $xu = User::whereRaw('parent_user_id IS NULL')->where('id', $user->id)->get();
            if ($xu && count($xu) > 0) {
                $data['available'] = true;
            }
            // check if member is member of current user
            $cU = User::where('parent_user_id', Auth::user()->id)->get();
            if ($cU && count($cU) > 0) {
                $data['myMember'] = true;
            }

            return view('member.others-profile', $data);
        } else {
            return view('member.others-profile')->with('notFound', true);
        }
    }

    function requestAdd() {
        $userId = Input::get('userId');
        if ($userId) {
            $user = User::find($userId);
            if ($user) {

                if ($user->social_id == "" || is_null($user->social_id)) {  // not member via facebook, no approval required
                    $user->parent_user_id = Auth::user()->id;
                    $user->approved_at = date("Y-m-d H:i:s");
                    $added = $user->save();
                    if ($added) {
                        return ['success' => true, 'message' => 'New team member successfully added!', 'isFbMember' => false];
                    } else {

                        return ['success' => false, 'message' => 'Failed to add new team member!'];
                    }
                }

                $pr = AddRequest::where('requested_by_user_id', Auth::user()->id)->where('recipient_user_id', $userId)->first();
                if (!$pr) {
                    $request = AddRequest::create(
                        [
                            'requested_by_user_id' => Auth::user()->id,
                            'recipient_user_id' => $userId,
                        ]
                    );

                    if ($request) {
                        return ['success' => true, 'message' => 'Request successfully sent!', 'isFbMember' => true];
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
                // team members
                $team = $this->userRepo->findByParentUserId($user->id);
                return view('member.my-profile')->with('member', $user)->with('requests', $requests)->with('team', $team);
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
                    // check if request exist
                    $request = AddRequest::where('requested_by_user_id', $requesterUserId)->where('recipient_user_id', $me->id)->first();
                    if ($request) {
                        if ($command == 'Approve') {
                            $me->parent_user_id = $requester->id;
                            $me->approved_at = date("Y-m-d H:i:s");
                            $newMe = $me->save();
                            if ($newMe) {
                                if ($request) {
                                    $request->delete();
                                }

                                return ['success' => true, 'message' => 'Request successfully approved!'];

                            }
                        } else if ($command == 'Disapprove') {
                            $request = AddRequest::where('requested_by_user_id', $requesterUserId)->where('recipient_user_id', $me->id)->first();
                            if ($request) {
                                $deleted = $request->delete();
                                if ($deleted) {
                                    return ['success' => true, 'message' => 'Request successfully disapproved!'];
                                }
                            }
                        }
                    } else {
                        return ['success' => false, 'message' => 'Request has been cancelled!'];
                    }
                }
            }

        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

        return ['success' => false, 'message' => 'Something went wrong!'];
    }

    function requestCancel() {

        $userId = Input::get('userId');

        try {

            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    $pr = AddRequest::where('requested_by_user_id', Auth::user()->id)->where('recipient_user_id', $userId)->first();
                    if ($pr) {
                        $deleted = $pr->delete();
                        if ($deleted) {
                            return ['success' => true, 'message' => 'Request successfully cancelled!'];
                        }
                    } else {
                        // it actually does nothing
                        return ['success' => true, 'message' => 'Request successfully cancelled!'];
                    }
                }
            }

        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

        return ['success' => false, 'message' => 'Something went wrong!'];
    }

    function addToTeamView() {
        return view('member.add-to-team');
    }

    function addToTeam() {
        $name = Input::get('name');
        $email = Input::get('email');
        if($name) {
            $adderUserId = Auth::user()->id;

            $newUser = User::create([
                'name' => $name,
                'email' => $email,
                'parent_user_id' => $adderUserId,
                'approved_at' => date("Y-m-d H:i:s")
            ]);

            if ($newUser) {
                return ['success' => true, 'message' => 'New team member successfully added!'];
            }
        } else {
            return ['success' => false, 'message' => 'Please enter name'];
        }
        return ['success' => false, 'message' => 'Failed to add team member'];
    }

    function removeTeamMember() {
        $userId = Input::get('userId');

        try {

            if ($userId) {
                $user = User::find($userId);
                if ($user) {
                    $user->parent_user_id = null;
                    $user->approved_at = null;
                    $saved = $user->save();
                    if ($saved) {
                        return ['success' => true, 'message' => 'Member successfully removed!'];
                    }
                }
            }

        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

        return ['success' => false, 'message' => 'Something went wrong!'];
    }

    function downlines() {
        $parentUserId = Input::get('parentUserId');
        if($parentUserId) {
            return $this->userRepo->findByParentUserId($parentUserId, ["name", "email", "id", "social_id"]);
        } else {
            return [];
        }
    }
}
