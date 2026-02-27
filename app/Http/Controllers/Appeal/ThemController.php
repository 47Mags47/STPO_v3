<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appeal\ThemStoreRequest;
use App\Http\Requests\Appeal\ThemUpdateRequest;
use App\Models\Appeal\Them;
use App\Models\Appeal\ThemGroup;
use Inertia\Inertia;

class ThemController extends Controller
{
    public function index()
    {
        return Inertia::render('appeal/thems/index', [
            'thems' => fn() => Them::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('appeal/thems/create', [
            'groups' => fn() => ThemGroup::getResource(),
        ]);
    }

    public function store(ThemStoreRequest $request)
    {
        Them::create($request->validated());

        return redirect()->route('appeal.thems.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(Them $them)
    {
        return Inertia::render('appeal/thems/edit', [
            'groups' => fn() => ThemGroup::getResource(),
            'them' => fn() => $them->toResource(),
        ]);
    }

    public function update(ThemUpdateRequest $request, Them $them)
    {
        $them->update($request->validated());

        return redirect()->route('appeal.thems.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(Them $them)
    {
        $them->delete();

        return redirect()->route('appeal.thems.index')->with('succes', 'Запись удалена');
    }
}
