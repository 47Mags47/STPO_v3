<?php

namespace App\Http\Controllers\SFR\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\SFR\FSD\TransitEquivalentStoreRequest;
use App\Models\SFR\FSD\TransitCategory;
use App\Models\SFR\FSD\TransitEquivalent;
use Inertia\Inertia;

class TransitEquivalentController extends Controller
{
    // HACK добавить изменение эквивалентов по проезду
    // HACK добавить удаление эквивалентов по проезду
    public function index() {
        return Inertia::render('sfr/fsd/transit-equivalents/index', [
            'equivalents' => fn() => TransitEquivalent::getResource(),
        ]);
    }

    public function create() {
        return Inertia::render('sfr/fsd/transit-equivalents/create', [
            'categories' => fn() => TransitCategory::getResource(),
        ]);
    }

    public function store(TransitEquivalentStoreRequest $request) {
        // HACK добавить закрытие старых эквивалентов по проезду пр добовлении нового с этой категорией
        TransitEquivalent::create($request->validated());

        return redirect()->route('sfr.fsd.transit-equivalents.index')->with('success', 'Запись успешно создана');
    }
}
