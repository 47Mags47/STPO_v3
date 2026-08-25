<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\LawStoreRequest;
use App\Http\Requests\Administrate\LawUpdateRequest;
use App\Models\Administrate\Law;
use Inertia\Inertia;

class LawController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/laws/index', [
            'laws' => fn() => Law::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/laws/create');
    }

    public function store(LawStoreRequest $request)
    {
        Law::create($request->validated());

        return redirect()->route('administrate.laws.index')->with('success', 'Запись успешно создана');
    }

    public function edit(Law $law)
    {
        return Inertia::render('administrate/financing-types/edit', [
            'law' => fn() => $law->toResource(),
        ]);
    }

    public function update(LawUpdateRequest $request, Law $law)
    {
        $law->update($request->validated());

        return redirect()->route('administrate.laws.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(Law $law)
    {
        $law->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
