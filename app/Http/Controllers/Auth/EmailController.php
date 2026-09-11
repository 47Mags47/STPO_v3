<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Email\EmailUpdateRequest;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Models\Base\User;
use Inertia\Inertia;

class EmailController extends Controller
{
    public function edit() {
        return Inertia::render('email/edit');
    }

    public function update(EmailUpdateRequest $request, User $user) {
        $data = $request->validated();
        $user->update($data);

        return redirect()->route('auth.users.edit', $user)->with('success', 'Email адрес изменён');
    }

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
