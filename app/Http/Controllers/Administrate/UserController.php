<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Models\Base\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('base/users/index', [
            'users' => fn() => User::getResource(),
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('login')->with('succes', 'Запись удалена');
    }
}
