<?php

namespace App\Repositories;

use App\User;

class UserRepo {

    /**
     * @param $userData
     * @return static
     */
    public function findByUsernameOrCreate($userData)
    {
        if ($authUser = User::where('social_id', $userData->id)->first()) {
            $authUser->email =  $userData->email;
            $authUser->name =  $userData->name;
            $authUser->avatar =  $userData->avatar;
            $authUser->save();

            return $authUser;
        }

        return User::create([
            'email' => $userData->email,
            'name' => $userData->name,
            'social_id' => $userData->id,
            'avatar' => $userData->avatar
        ]);
    }

}