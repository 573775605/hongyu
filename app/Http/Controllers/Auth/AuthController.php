<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;

class AuthController extends Controller
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

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * AuthController constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        //        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->_request = $request;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name'     => 'required|max:255',
                'email'    => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create(
            [
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]
        );
    }

    public function manager()
    {
        if ($this->_request->isMethod('post')) {
            $param = [
                'username' => $this->_request->input('username'),
                'password' => $this->_request->input('password'),
            ];
            if (Auth::guard('manager')->attempt($param, $this->_request->has('remember_token'))) {
                return $this->returnJson(1);
            }

            return $this->returnJson(-1, '账号或密码错误');
        }

        return view('auth.manager');
    }
}
