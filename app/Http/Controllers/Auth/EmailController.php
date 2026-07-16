<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use Inertia\Inertia;

class EmailController extends Controller
{
    public function notice(){
        return Inertia::render('email/index');
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();
        return redirect()->route('home')->with('success', 'Email адрес подтвержден');
    }

    public function send(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return Inertia::render('email/create');
    }
}
