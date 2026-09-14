<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordUpdateRequest;
use App\Models\Base\User;
use Inertia\Inertia;

class PasswordController extends Controller
{
    public function edit()
    {
        return Inertia::render('password/edit');
    }

    public function update(PasswordUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        $user->update([
            'password' => $data['new_password'],
        ]);

        return redirect()->route('auth.users.edit', $user)->with('success', 'Пароль успешно изменён');
    }
}
