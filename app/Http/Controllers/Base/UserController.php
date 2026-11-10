<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\UserUpdateRequest;
use App\Models\Base\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function edit(User $user)
    {
        return Inertia::render('base/users/edit');
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        unset($data['division'], $data['email']);

        $user->update($data);

        return redirect()->route('dashboard')->with('success', 'Запись успешно обновлена');
    }

    public function show(User $user)
    {
        return Inertia::render('base/users/show', [
            'user' => fn() => $user->toResource(),
        ]);
    }
}
