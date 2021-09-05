<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        if (Auth::attempt(Arr::where(request()->all(), function($value, $key){ return !in_array($key, ['_token', 'remember']);}))) {
            return $this->ajaxSuccess('Вы успешно авторизировались!');
        } else {
            return $this->ajaxError('Не верный логин или пароль!');
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        
        return $this->ajaxSuccess('Вы успешно вышли!');
    }

}
