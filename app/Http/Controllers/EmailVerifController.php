<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EmailVerifController extends Controller
{

    public function notice()
    {
        return redirect()->route('browse.index')
            ->with('error' , __('messages.error_require_verification'));
    }


    public function verify(EmailVerificationRequest $request, $id, $hash)
    {
        $request->fulfill();
        return redirect()->route('browse.index')
            ->with('success' , __('messages.success_email_verified'));
    }


    public function send(Request $request)
    {
        request()->user()->sendEmailVerificationNotification();
        return back()->with('success', __('messages.success_link_sent'));
    }

}
