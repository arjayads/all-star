<?php

namespace App\Http\Controllers\Auth;

use App\Listeners\AuthenticateUserListener;
use App\Models\AuthenticateUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller implements AuthenticateUserListener
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(AuthenticateUser $authenticateUser)
    {
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->authenticateUser = $authenticateUser;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }


    /**
     * @param AuthenticateUser $authenticateUser
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function login(Request $request, $provider = null)
    {
        if ($provider == null) {
            return redirect('/');
        }
        $hasCode = $request->has('code');
        return $this->authenticateUser->execute($hasCode, $provider, $this);
    }

    /**
     * @param $user
     * @return mixed
     */
    public function userHasLoggedIn($user)
    {
        return redirect('/');
    }

    public function userLoggedInFailed($data)
    {
        $message = $data['message'] . " You may go to https://www.facebook.com/settings?tab=applications and remove allstarinnovators.";
        throw new \RuntimeException($message);
    }
}
