<?php

namespace App\Http\Controllers\Veteran;

use App\Http\Controllers\Controller;
use App\Http\Requests\Veteran\AccessDestroyRequest;
use App\Http\Requests\Veteran\AccessStoreRequest;
use App\Http\Resources\Veteran\UserAccessResource;
use App\Models\Auth\PermissionGroup;
use App\Models\Auth\UserPermission;
use App\Models\Base\User;
use Inertia\Inertia;

class AccessController extends Controller
{
    public function index()
    {
        $this->authorize('manage-veteran-accesses');

        return Inertia::render('veteran/accesses/index', [
            'users' => User::whereHasPermissionGroup('veteran')->getResource(resource: UserAccessResource::class),
        ]);
    }

    public function create()
    {
        $this->authorize('manage-veteran-accesses');

        return Inertia::render('veteran/accesses/create', [
            'permissions'   => fn() => PermissionGroup::byCode('veteran')->permissions->toResourceCollection()
        ]);
    }

    public function store(AccessStoreRequest $request)
    {
        $this->authorize('manage-veteran-accesses');

        UserPermission::create($request->validated());

        return redirect()->route('veteran.accesses.index')->with('success', 'Запись успешно сохранена');
    }

    public function destroy(AccessDestroyRequest $request)
    {
        $this->authorize('manage-veteran-accesses');

        UserPermission::query()
            ->where('permission_id', $request->validated('permission_id'))
            ->where('user_id', $request->validated('user_id'))
            ->where('division_id', $request->validated('division_id'))
            ->get()
            ->each(fn($permission) => $permission->delete());

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
