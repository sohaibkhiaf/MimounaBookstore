<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPassController extends Controller
{
    public function forgotPage(Request $request)
    {
        return view('auth/forgot', [
            'intended' => $request->input('intended'),
            'bid' => $request->input('bid'),
        ]);
    }

    public function email(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? to_route('browse.index')->with('success', __('messages.success_reset_link_sent'))
            : to_route('password.reset')->with('error', __('messages.error_unexpected'));
    }

    public function reset(string $token)
    {
        return view('user/reset', ['token' => $token]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill(['password' => Hash::make($password)])
                    ->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? to_route('auth.loginPage')->with('success', __('messages.success_password_updated'))
            : to_route('password.reset', ['token' => $request->input('token')])->with('error', __('messages.error_unexpected'));
    }
}
