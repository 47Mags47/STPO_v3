<?php

namespace App\Http\Controllers\Veteran;

use App\Http\Controllers\Controller;
use App\Http\Requests\Veteran\AccessStoreRequest;
use App\Http\Resources\Veteran\UserAccessResource;
use App\Models\Auth\Permission;
use App\Models\Auth\PermissionGroup;
use App\Models\Base\User;
use Inertia\Inertia;

class AccessController extends Controller
{
    public function index()
    {
        return Inertia::render('veteran/accesses/index', [
            'users' => User::whereHasPermissionGroup('veteran')->getResource(resource: UserAccessResource::class),
        ]);
    }

    public function create()
    {
        return Inertia::render('veteran/accesses/create', [
            // HACK Добавить частичную загрузку (как по скролу) select
            // HACK Добавить отдельный ресурс с пользователем и его permissions
            'users' => fn() => User::all(),
            'permissions' => fn() => PermissionGroup::byCode('veteran')->permissions->toResourceCollection()
        ]);
    }

    public function store(AccessStoreRequest $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $permission = Permission::findOrFail($request->input('permission_id'));

        $user->permissions()->attach($permission->id);

        return redirect()->route('veteran.accesses.index')->with('success', 'Запись успешно сохранена');
    }

    public function destroy($request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $permission = Permission::findOrFail($request->input('permission_id'));

        $user->permissions()->detach($permission->id);

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
