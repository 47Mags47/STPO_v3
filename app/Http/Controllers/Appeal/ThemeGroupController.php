<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appeal\ThemeGroupStoreRequest;
use App\Http\Requests\Appeal\ThemeGroupUpdateRequest;
use App\Models\Appeal\ThemeGroup;
use Inertia\Inertia;

class ThemeGroupController extends Controller
{
    public function index()
    {
        return Inertia::render('appeal/theme-groups/index', [
            'theme_groups' => fn() => ThemeGroup::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('appeal/theme-groups/create');
    }

    public function store(ThemeGroupStoreRequest $request)
    {
        ThemeGroup::create($request->validated());

        return redirect()->route('appeal.theme-groups.index')->with('success', 'Запись успешно создана');
    }

    public function edit(ThemeGroup $themeGroup)
    {
        return Inertia::render('appeal/theme-groups/edit', [
            'theme_group' => fn() => $themeGroup->toResource(),
        ]);
    }

    public function update(ThemeGroupUpdateRequest $request, ThemeGroup $themeGroup)
    {
        $themeGroup->update($request->validated());

        return redirect()->route('appeal.theme-groups.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(ThemeGroup $themeGroup) {
        $themeGroup->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
