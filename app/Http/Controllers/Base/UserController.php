<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\UserUpdateRequest;
use App\Models\Base\File;
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
        if ($request->hasFile('avatar')) {
            $avatar = File::factory()->create([
                'path' => 'avatars'
            ]);

            $request->file('avatar')->storeAs($avatar->path, $avatar->name);

            $avatar->setStatus('ok');
        }

        $user->update(array_merge($request->validated(), ['avatar_id' => $avatar?->id]));

        return redirect()->route('dashboard')->with('success', 'Запись успешно обновлена');
    }

    public function show(User $user)
    {
        return Inertia::render('base/users/show', [
            'user' => fn() => $user->toResource(),
        ]);
    }
}
