<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerifController extends Controller
{
    public function notice()
    {
        return to_route('browse.index')
            ->with('error', __('messages.error_require_verification'));
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return to_route('browse.index')
            ->with('success', __('messages.success_email_verified'));
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', __('messages.success_link_sent'));
    }
}
