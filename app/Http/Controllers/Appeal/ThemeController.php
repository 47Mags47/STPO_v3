<?php

namespace App\Http\Controllers\Appeal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appeal\ThemeStoreRequest;
use App\Http\Requests\Appeal\ThemeUpdateRequest;
use App\Models\Appeal\Theme;
use App\Models\Appeal\ThemeGroup;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class ThemeController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Theme::class);
    }

    public function index()
    {
        return Inertia::render('appeal/themes/index', [
            'themes' => fn() => Theme::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('appeal/themes/create', [
            'groups' => fn() => ThemeGroup::getResource(),
        ]);
    }

    public function store(ThemeStoreRequest $request)
    {
        Theme::create($request->validated());

        return redirect()->route('appeal.themes.index')->with('success', 'Запись успешно создана');
    }

    public function edit(Theme $theme)
    {
        return Inertia::render('appeal/themes/edit', [
            'groups' => fn() => ThemeGroup::getResource(),
            'theme' => fn() => $theme->toResource(),
        ]);
    }

    public function update(ThemeUpdateRequest $request, Theme $theme)
    {
        $theme->update($request->validated());

        return redirect()->route('appeal.themes.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(Theme $theme)
    {
        $theme->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
