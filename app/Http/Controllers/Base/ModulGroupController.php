<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Base\ModulGroupStoreRequest;
use App\Http\Requests\Base\ModulGroupUpdateRequest;
use App\Models\ModulGroup;
use Inertia\Inertia;

class ModulGroupController extends Controller
{
    public function index()
    {
        return Inertia::render('base/modul-groups/index', [
            'modulGroups' => fn() => ModulGroup::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('base/modul-groups/create');
    }

    public function store(ModulGroupStoreRequest $request)
    {
        ModulGroup::create($request->validated());

        return redirect()->route('modul-groups.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(ModulGroup $modulGroup)
    {
        return Inertia::render('base/modul-groups/edit', [
            'modulGroup' => fn() => $modulGroup->toResource(),
        ]);
    }

    public function update(ModulGroupUpdateRequest $request, ModulGroup $modulGroup)
    {
        $modulGroup->update($request->validated());

        return redirect()->route('modul-groups.index')->with('succes', 'Запись успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModulGroup $modulGroup)
    {
        $modulGroup->delete();

        return redirect()->route('modul-groups.index')->with('succes', 'Запись удалена');
    }
}
