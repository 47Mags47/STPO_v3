<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function notice(){
        return 1;
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();

        return redirect()->route('home')->with('succes', 'Email адрес подтвержден');
    }

    public function send(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Письмо с подтверждением отправлено!');
    }
}
