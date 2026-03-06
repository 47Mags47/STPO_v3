<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\ModulStoreRequest;
use App\Http\Requests\Administrate\ModulUpdateRequest;
use App\Models\Administrate\Modul;
use App\Models\Administrate\ModulGroup;
use Inertia\Inertia;

class ModulController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/moduls/index', [
            'moduls' => fn() => Modul::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/moduls/create', [
            'modulGroups' => ModulGroup::getResource(),
        ]);
    }

    public function store(ModulStoreRequest $request)
    {
        Modul::create($request->validated());

        return redirect()->route('administrate.moduls.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(Modul $modul)
    {
        return Inertia::render('administrate/moduls/edit', [
            'modul' => fn() => $modul->toResource(),
            'modulGroups' => ModulGroup::getResource(),
        ]);
    }

    public function update(ModulUpdateRequest $request, Modul $modul)
    {
        $modul->update($request->validated());

        return redirect()->route('administrate.moduls.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(Modul $modul)
    {
        $modul->delete();

        return redirect()->route('administrate.moduls.index')->with('succes', 'Запись удалена');
    }
}
