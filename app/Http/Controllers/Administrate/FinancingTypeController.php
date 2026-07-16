<?php

namespace App\Http\Controllers\Administrate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrate\FinancingTypeStoreRequest;
use App\Http\Requests\Administrate\FinancingTypeUpdateRequest;
use App\Models\Administrate\FinancingType;
use Inertia\Inertia;

class FinancingTypeController extends Controller
{
    public function index()
    {
        return Inertia::render('administrate/financing-types/index', [
            'types' => fn() => FinancingType::getResource(),
        ]);
    }

    public function create()
    {
        return Inertia::render('administrate/financing-types/create');
    }

    public function store(FinancingTypeStoreRequest $request) {
        FinancingType::create($request->validated());

        return redirect()->route('administrate.financing-types.index')->with('success', 'Запись успешно создана');
    }

    public function edit(FinancingType $financingType) {
        return Inertia::render('administrate/financing-types/edit', [
            'type' => fn() => $financingType->toResource(),
        ]);
    }

    public function update(FinancingTypeUpdateRequest $request, FinancingType $financingType) {
        $financingType->update($request->validated());

        return redirect()->route('administrate.financing-types.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(FinancingType $financingType) {
        $financingType->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
