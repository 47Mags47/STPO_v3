<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\ModulGroupStoreRequest;
use App\Http\Requests\Administrate\ModulGroupUpdateRequest;
use App\Models\Administrate\ModulGroup;
use Inertia\Inertia;

class ModulGroupController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/modul-groups/index', [
            'modulGroups' => fn() => ModulGroup::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/modul-groups/create');
    }

    public function store(ModulGroupStoreRequest $request)
    {
        ModulGroup::create($request->validated());

        return redirect()->route('administrate.modul-groups.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(ModulGroup $modulGroup)
    {
        return Inertia::render('administrate/modul-groups/edit', [
            'modulGroup' => fn() => $modulGroup->toResource(),
        ]);
    }

    public function update(ModulGroupUpdateRequest $request, ModulGroup $modulGroup)
    {
        $modulGroup->update($request->validated());

        return redirect()->route('administrate.modul-groups.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(ModulGroup $modulGroup)
    {
        $modulGroup->delete();

        return redirect()->route('administrate.modul-groups.index')->with('succes', 'Запись удалена');
    }
}
