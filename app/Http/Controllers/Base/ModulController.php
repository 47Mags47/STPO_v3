<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Base\ModulStoreRequest;
use App\Http\Requests\Base\ModulUpdateRequest;
use App\Models\Modul;
use App\Models\ModulGroup;
use Inertia\Inertia;

class ModulController extends Controller
{
    public function index()
    {
        return Inertia::render('base/moduls/index', [
            'moduls' => fn() => Modul::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('base/moduls/create', [
            'modulGroups' => ModulGroup::getResource(),
        ]);
    }

    public function store(ModulStoreRequest $request)
    {
        Modul::create($request->validated());

        return redirect()->route('moduls.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(Modul $modul)
    {
        return Inertia::render('base/moduls/edit', [
            'modul' => fn() => $modul->toResource(),
            'modulGroups' => ModulGroup::getResource(),
        ]);
    }

    public function update(ModulUpdateRequest $request, Modul $modul)
    {
        $modul->update($request->validated());

        return redirect()->route('moduls.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(Modul $modul)
    {
        $modul->delete();

        return redirect()->route('moduls.index')->with('succes', 'Запись удалена');
    }
}
