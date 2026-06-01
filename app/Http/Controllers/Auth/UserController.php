<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\UserUpdateRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserStoreRequest;
use App\Models\Administrate\Division;
use App\Models\Base\User;
use Inertia\Inertia;


use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function login(UserLoginRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->only(['login', 'password']), $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'login' => 'Неверный логин или пароль.',
        ]);
    }
    public function create()
    {
        return Inertia::render('auth/registration', [
            'divisions' => fn() => Division::all()->toResourceCollection(),
        ]);
    }

    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());

        event(new Registered($user));

        Auth::login($user);

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

    public function show(User $user)
    {
        return Inertia::render('base/users/show', [
            'user' => fn() => $user->toResource(),
        ]);
    }
}
