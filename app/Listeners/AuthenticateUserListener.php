<?php
/**
 * Created by PhpStorm.
 * User: gwdev1
 * Date: 10/13/15
 * Time: 11:55 PM
 */

namespace App\Listeners;

interface AuthenticateUserListener {
    /**
     * @param $user
     * @return mixed
     */
    public function userHasLoggedIn($user);
    public function userLoggedInFailed($data);
}