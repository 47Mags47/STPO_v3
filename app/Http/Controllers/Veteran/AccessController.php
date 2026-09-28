<?php

namespace App\Http\Controllers\Veteran;

use App\Http\Controllers\Controller;
use App\Http\Requests\veteran\AccessDestroyRequest;
use App\Http\Requests\veteran\AccessStoreRequest;
use App\Models\Auth\Permission;
use App\Models\Auth\PermissionGroup;
use App\Models\Base\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccessController extends Controller
{
    public function index()
    {
        return Inertia::render('veteran/access/index', [
            'users' => User::whereHas('permissions', fn($query) => $query->where('group_id', PermissionGroup::byCode('veteran_work')->id)),
        ]);
    }

    public function create()
    {
        return Inertia::render('veteran/access/create', [
            // HACK Добавить частичную загрузку (как по скролу) select
            // HACK Добавить отдельный ресурс с пользователем и его permissions
            'users' => fn() => User::all(),
            'permissions' => fn() => PermissionGroup::byCode('veteran_work')->permissions
        ]);
    }

    public function store(AccessStoreRequest $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $permission = Permission::findOrFail($request->input('permission_id'));

        $user->permissions()->attach($permission->id);

        return redirect()->route('veteran-work.access.index')->with('success', 'Запись успешно сохранена');
    }

    public function destroy(AccessDestroyRequest $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $permission = Permission::findOrFail($request->input('permission_id'));

        $user->permissions()->detach($permission->id);

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
