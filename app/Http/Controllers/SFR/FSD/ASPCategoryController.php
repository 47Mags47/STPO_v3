<?php

namespace App\Http\Controllers\SFR\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\SFR\FSD\ASPPaymentCategoryStoreRequest;
use App\Http\Requests\SFR\FSD\ASPPaymentCategoryUpdateRequest;
use App\Models\SFR\FSD\ASPPaymentCategory;
use App\Models\SFR\FSD\SFRPaymentCategory;
use Inertia\Inertia;

class ASPCategoryController extends Controller
{
    public function index(){
        return Inertia::render('sfr/fsd/asp-payment-categories/index', [
            'categories' => fn() => ASPPaymentCategory::getResource()
        ]);
    }

    public function create(){
        return Inertia::render('sfr/fsd/asp-payment-categories/create', [
            'sfr_categories' => fn() => SFRPaymentCategory::getResource('name'),
        ]);
    }

    public function store(ASPPaymentCategoryStoreRequest $request){
        ASPPaymentCategory::create($request->validated());

        return redirect()->route('sfr.fsd.asp-payment-categories.index')->with('success', 'Запись успешно создана');
    }

    public function edit(ASPPaymentCategory $aspPaymentCategory){
        return Inertia::render('sfr/fsd/asp-payment-categories/edit', [
            'category' => fn() => $aspPaymentCategory->toResource(),
            'sfr_categories' => fn() => SFRPaymentCategory::getResource('name'),
        ]);
    }

    public function update(ASPPaymentCategoryUpdateRequest $request, ASPPaymentCategory $aspPaymentCategory){
        $aspPaymentCategory->update($request->validated());

        return redirect()->route('sfr.fsd.asp-payment-categories.index')->with('success', 'Запись успешно обновлена');
    }

    public function destroy(ASPPaymentCategory $aspPaymentCategory){
        $aspPaymentCategory->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
