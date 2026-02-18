<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Base\DivisionStoreRequest;
use App\Http\Requests\Base\DivisionUpdateRequest;
use App\Models\Division;
use Inertia\Inertia;

class DivisionController extends Controller
{
    public function index()
    {
        return Inertia::render('base/divisions/index', [
            'divisions' => fn() => Division::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('base/divisions/create');
    }

    public function store(DivisionStoreRequest $request)
    {
        Division::create($request->validated());

        return redirect()->route('divisions.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(Division $division)
    {
        return Inertia::render('base/divisions/edit', [
            'division' => fn() => $division->toResource(),
        ]);
    }

    public function update(DivisionUpdateRequest $request, Division $division)
    {
        $division->update($request->validated());

        return redirect()->route('divisions.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(Division $division) {
        $division->delete();

        return redirect()->route('divisions.index')->with('succes', 'Запись удалена');
    }
}
