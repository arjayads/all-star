<?php

namespace App\Repositories;

use App\User;

class UserRepo {

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

        return User::create([
            'email' => $userData->email,
            'name' => $userData->name,
            'social_id' => $userData->id,
            'avatar' => $userData->avatar,
            'provider' => $provider
        ]);
    }

    public function findByParentUserId($parentUserId) {
        return User::where('parent_user_id', $parentUserId)->get();
    }

}