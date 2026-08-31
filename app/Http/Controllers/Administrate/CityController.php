<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

use App\Http\Requests\Administrate\CityStoreRequest;
use App\Http\Requests\Administrate\CityUpdateRequest;

use App\Models\Administrate\City;

class CityController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/cities/index', [
            'cities' => fn() => City::getResource()
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/cities/create', []);
    }

    public function store(CityStoreRequest $request)
    {
        City::create($request->validated());

        return redirect()->route('administrate.cities.index')->with('success', 'Запись успешно создана');
    }

    public function edit(City $city)
    {
        return Inertia::render('administrate/cities/edit', [
            'city' => fn() => $city->toResource(),
        ]);
    }

    public function update(CityUpdateRequest $request, City $city)
    {
        $city->update($request->validated());

        return redirect()->route('administrate.cities.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
