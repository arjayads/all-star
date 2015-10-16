<?php
/**
 * Created by PhpStorm.
 * User: gwdev1
 * Date: 10/13/15
 * Time: 11:50 PM
 */

namespace App\Models;


use App\Listeners\AuthenticateUserListener;
use App\Repositories\UserRepo;
use Facebook\Facebook;
use Facebook\FacebookApp;
use Facebook\FacebookRequest;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Contracts\Auth\Guard as Authenticator;
use Laravel\Socialite\Two\FacebookProvider;

class AuthenticateUser {
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var Socialite
     */
    private $socialite;
    /**
     * @var Authenticator
     */
    private $auth;
    /**
     * @param UserRepo $users
     * @param Socialite $socialite
     * @param Authenticator $auth
     */
    public function __construct(UserRepo $users, Socialite $socialite, Authenticator $auth)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;
    }
    /**
     * @param boolean $hasCode
     * @param AuthenticateUserListener $listener
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function execute($hasCode, $provider, AuthenticateUserListener $listener)
    {
        $this->provider = $provider;
        if ( ! $hasCode) return $this->getAuthorizationFirst();

        $result = $this->getSocialUser();
        if ($result['success']) {
            $user = $this->users->findByUsernameOrCreate($result['user'], $this->provider);
            $this->auth->login($user, true);
            return $listener->userHasLoggedIn($user);
        } else {
            return $listener->userLoggedInFailed($result);
        }
    }
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst()
    {
        if ($this->provider == 'facebook') {
            return $this->socialite->driver($this->provider)->scopes(['user_friends', 'public_profile', 'email'])->redirect();
        }
        return $this->socialite->driver($this->provider)->redirect();
    }
    /**
     * @return \Laravel\Socialite\Contracts\User
     */
    private function getSocialUser()
    {
        $user = $this->socialite->driver($this->provider)->user();

        // check how many fb friends
        if ($this->provider == 'facebook') {
            $friendCount = 0;
            try {
                $data = file_get_contents("https://graph.facebook.com/v2.5/me/friends?access_token=" . $user->token);
                if ($data) {
                    $dataArr = json_decode($data);
                    if(isset($dataArr->summary)) {
                        $friendCount = $dataArr->summary->total_count;
                    }
                }
            } catch (\Exception $e) {
                throw new \RuntimeException($e->getMessage());
            }

            if ($friendCount <= 0) {
                return ['user' => $user, 'success' => false, 'message' => 'Facebook account must have at least 10 friends!'];
            }
        }

        return ['user' => $user, 'success' => true];
    }
}