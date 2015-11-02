<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\DB;

class UserRepo {

    function findDefaultUrl($userId)
    {
        $q = DB::table('users')
            ->join('user_groups', 'users.id', '=', 'user_groups.user_id')
            ->join('groups', 'user_groups.group_id', '=', 'groups.id');
        return $q->where('user_groups.user_id', '=', $userId)->lists('default_url');
    }

    /**
     * @param $userData
     * @return static
     */
    public function findByUsernameOrCreate($userData, $provider)
    {
        if ($authUser = User::where('social_id', $userData->id)->where('provider', $provider)->first()) {
            $authUser->email =  $userData->email;
            $authUser->name =  $userData->name;
            $authUser->avatar =  $userData->avatar;            
            $authUser->provider = $provider;
            $authUser->save();

            return $authUser;
        }

        $user = User::create([
            'email' => $userData->email,
            'name' => $userData->name,
            'social_id' => $userData->id,
            'avatar' => $userData->avatar,
            'provider' => $provider
        ]);

        if ($user) {
            DB::table('user_groups')->insert([
                [
                    'user_id' => $user->id,
                    'group_id' => 2 // Member
                ]
            ]);
        }


        return $user;
    }

    public function findByParentUserId($parentUserId, array $cols = []) {
        if ($cols) {
            return User::where('parent_user_id', $parentUserId)->select($cols)->get();
        }
        return User::where('parent_user_id', $parentUserId)->get();
    }


    function findGroups($userId)
    {
        $q = DB::table('users')
            ->join('user_groups', 'users.id', '=', 'user_groups.user_id')
            ->join('groups', 'user_groups.group_id', '=', 'groups.id');
        return $q->where('user_groups.user_id', '=', $userId)
                ->select('groups.name')
                ->lists('name');
    }
}