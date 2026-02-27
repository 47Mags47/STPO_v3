<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appeal\ThemGroupStoreRequest;
use App\Http\Requests\Appeal\ThemGroupUpdateRequest;
use App\Models\Appeal\ThemGroup;
use Inertia\Inertia;

class ThemGroupController extends Controller
{
    public function index()
    {
        return Inertia::render('appeal/them-groups/index', [
            'them_groups' => fn() => ThemGroup::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('appeal/them-groups/create');
    }

    public function store(ThemGroupStoreRequest $request)
    {
        ThemGroup::create($request->validated());

        return redirect()->route('appeal.them-groups.index')->with('succes', 'Запись успешно создана');
    }

    public function edit(ThemGroup $themGroup)
    {
        return Inertia::render('appeal/them-groups/edit', [
            'them_group' => fn() => $themGroup->toResource(),
        ]);
    }

    public function update(ThemGroupUpdateRequest $request, ThemGroup $themGroup)
    {
        $themGroup->update($request->validated());

        return redirect()->route('appeal.them-groups.index')->with('succes', 'Запись успешно обновлена');
    }

    public function destroy(ThemGroup $themGroup) {
        $themGroup->delete();

        return redirect()->route('appeal.them-groups.index')->with('succes', 'Запись удалена');
    }
}
