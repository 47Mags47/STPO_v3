<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\DivisionStoreRequest;
use App\Http\Requests\Administrate\DivisionUpdateRequest;
use App\Models\Administrate\Division;
use Inertia\Inertia;

class DivisionController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/divisions/index', [
            'divisions' => fn() => Division::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/divisions/create');
    }

    public function store(DivisionStoreRequest $request)
    {
        Division::create($request->validated());

        return redirect()->route('administrate.divisions.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(Division $division)
    {
        return Inertia::render('administrate/divisions/edit', [
            'division' => fn() => $division->toResource(),
        ]);
    }

    public function update(DivisionUpdateRequest $request, Division $division)
    {
        $division->update($request->validated());

        return redirect()->route('administrate.divisions.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(Division $division) {
        $division->delete();

        return redirect()->route('administrate.divisions.index')->with('succes', 'Запись удалена');
    }
}
