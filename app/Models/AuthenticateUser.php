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
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Contracts\Auth\Guard as Authenticator;

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

        $user = $this->users->findByUsernameOrCreate($this->getSocialUser(), $this->provider);
        $this->auth->login($user, true);
        return $listener->userHasLoggedIn($user);
    }
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function getAuthorizationFirst()
    {
        return $this->socialite->driver($this->provider)->redirect();
    }
    /**
     * @return \Laravel\Socialite\Contracts\User
     */
    private function getSocialUser()
    {
        return $this->socialite->driver($this->provider)->user();
    }
}