<?php

namespace App\Http\Controllers\FSD;

use App\Http\Controllers\Controller;
use App\Http\Requests\FSD\TransitEquivalentStoreRequest;
use App\Models\FSD\TransitCategory;
use App\Models\FSD\TransitEquivalent;
use Inertia\Inertia;

class TransitEquivalentController extends Controller
{
    public function index() {
        return Inertia::render('fsd/transit-equivalents/index', [
            'equivalents' => fn() => TransitEquivalent::getResource(),
        ]);
    }

    public function create() {
        return Inertia::render('fsd/transit-equivalents/create', [
            'categories' => fn() => TransitCategory::getResource(),
        ]);
    }

    public function store(TransitEquivalentStoreRequest $request) {
        TransitEquivalent::create($request->validated());

        return redirect()->route('fsd.transit-equivalents.index')->with('succes', 'Запись успешно создана');
    }
}
