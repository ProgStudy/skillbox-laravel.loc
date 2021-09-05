<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request, PasswordBroker $passwordBroker)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = $passwordBroker->sendResetLink($request->only('email'));
    
        switch ($response) {
            case PasswordBroker::RESET_LINK_SENT:
                return $this->ajaxSuccess('Ссылка для пароля была отправлена на ваш адрес электронной почты');
    
            case PasswordBroker::INVALID_USER:
                return $this->ajaxError('Мы не можем найти пользователя с таким адресом электронной почты');
        }

        return $this->ajaxSuccess();
    }
}
