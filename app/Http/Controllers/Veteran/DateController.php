<?php

namespace App\Http\Controllers\Veteran;

use App\Http\Controllers\Controller;
use App\Http\Requests\Veteran\DateStoreRequest;
use App\Http\Requests\Veteran\DateUpdateRequest;
use App\Models\Veteran\Date;
use Inertia\Inertia;

class DateController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Date::class);
    }

    public function index()
    {
        return Inertia::render('veteran/dates/index', [
            'dates' => fn() => Date::getResource(order: ['in_date' => 'desc']),
        ]);
    }

    public function create()
    {
        return Inertia::render('veteran/dates/create');
    }

    public function store(DateStoreRequest $request)
    {
        Date::create($request->validated());

        return redirect()->route('veteran.dates.index')->with('success', 'Запись успешно создана');
    }

    public function update(DateUpdateRequest $request, Date $date)
    {
        if($request->validated('is_active'))
            Date::query()->update(['is_active' => false]);

        $date->update($request->validated());

        return redirect()->route('veteran.dates.index')->with('success', 'Запись успешно обновлена');
    }

    public function show(Date $date)
    {
        return redirect()->route('veteran.reports.index', ['date' => $date]);
    }

    public function destroy(Date $date)
    {
        $date->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
