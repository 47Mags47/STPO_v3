<?php

namespace App\Http\Controllers\SFR\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\SFR\FSD\SFRPaymentCategoryStoreRequest;
use App\Http\Requests\SFR\FSD\SFRPaymentCategoryUpdateRequest;
use App\Models\SFR\FSD\SFRPaymentCategory;
use Inertia\Inertia;

class SFRCategoryController extends Controller
{
    public function index(){
        return Inertia::render('sfr/fsd/sfr-payment-categories/index', [
            'categories' => fn() => SFRPaymentCategory::getResource()
        ]);
    }

    public function create(){
        return Inertia::render('sfr/fsd/sfr-payment-categories/create');
    }

    public function store(SFRPaymentCategoryStoreRequest $request){
        SFRPaymentCategory::create($request->validated());

        return redirect()->route('sfr.fsd.sfr-payment-categories.index')->with('success', 'Запись успешно создана');
    }

    public function edit(SFRPaymentCategory $sfrPaymentCategory){
        return Inertia::render('sfr/fsd/sfr-payment-categories/edit', [
            'category' => fn() => $sfrPaymentCategory->toResource()
        ]);
    }

    public function update(SFRPaymentCategoryUpdateRequest $request, SFRPaymentCategory $sfrPaymentCategory){
        $sfrPaymentCategory->update($request->validated());

        return redirect()->route('sfr.fsd.sfr-payment-categories.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(SFRPaymentCategory $sfrPaymentCategory){
        $sfrPaymentCategory->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
