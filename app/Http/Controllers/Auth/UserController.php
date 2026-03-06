<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\UserUpdateRequest;
use App\Http\Requests\Auth\UserStoreRequest;
use App\Models\Administrate\Division;
use App\Models\Base\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function create()
    {
        return Inertia::render('auth/registration', [
            'divisions' => fn() => Division::getResource(),
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        User::create($request->validated());

        return redirect()->route('dashboard');
    }

    public function edit(User $user)
    {
        return Inertia::render('base/users/edit', [
            'division' => fn() => $user->toResource(),
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()->route('dashboard')->with('succes', 'Запись успешно обновлена');
    }
}
