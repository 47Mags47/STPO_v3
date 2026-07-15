<?php

namespace App\Http\Controllers\SFR\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\SFR\FSD\TransitCategoryStoreRequest;
use App\Http\Requests\SFR\FSD\TransitCategoryUpdateRequest;
use App\Models\SFR\FSD\TransitCategory;
use Inertia\Inertia;

class TransitCategoryController extends Controller
{
    public function index(){
        return Inertia::render('sfr/fsd/transit-cateries/index', [
            'categories' => fn() => TransitCategory::getResource()
        ]);
    }

    public function create(){
        return Inertia::render('sfr/fsd/transit-cateries/create');
    }

    public function store(TransitCategoryStoreRequest $request){
        TransitCategory::create($request->validated());

        return redirect()->route('sfr.fsd.transit-categories.index')->with('success', 'Запись успешно создана');
    }

    public function edit(TransitCategory $transitCategory){
        return Inertia::render('sfr/fsd/transit-cateries/edit', [
            'category' => fn() => $transitCategory->toResource()
        ]);
    }

    public function update(TransitCategoryUpdateRequest $request, TransitCategory $transitCategory){
        $transitCategory->update($request->validated());

        return redirect()->route('sfr.fsd.transit-categories.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(TransitCategory $transitCategory){
        $transitCategory->delete();

        return redirect()->route('sfr.fsd.transit-categories.index')->with('success', 'Запись удалена');
    }
}
