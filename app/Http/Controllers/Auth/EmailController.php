<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

use Inertia\Inertia;

class EmailController extends Controller
{
    public function notice(){
        return Inertia::render('httpErrors/403_NoEmail');
    }

    public function verify(EmailVerificationRequest $request){
        $request->fulfill();
        dd('1412');
        return redirect()->route('home')->with('succes', 'Email адрес подтвержден');
    }

    public function send(Request $request){
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Письмо с подтверждением отправлено!');
    }
}
