<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;

class ResetPassController extends Controller
{

    public function forgotPage()
    {
        // get params
        $intended = request()->input('intended');
        $bookId = request()->input('bid');

        // open view
        return view('auth/forgot' , ['intended' => $intended , 'bid' => $bookId]);
    }

    public function email(Request $request)
    {
        request()->validate(['email' => 'required|email']);
        $status = Password::sendResetLink( request()->only('email') );
        return $status === Password::RESET_LINK_SENT
                    ? redirect()->route('browse.index')->with('success' , __('messages.success_reset_link_sent'))
                    : redirect()->route('password.reset')->with('error' , __('messages.error_unexpected'));
    }

    public function reset(string $token)
    {
        // open reset password view
        return view('user/reset', ['token' => $token ]);
    }


    public function update(Request $request)
    {
        // validate data
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // reset password
        $status = Password::reset(
            request()->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password) ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('auth.loginPage')->with('success', __('messages.success_password_updated'))
                    : redirect()->route('password.reset', ['token' => request()->input('token')])->with('error', __('messages.error_unexpected'));
    }

}
