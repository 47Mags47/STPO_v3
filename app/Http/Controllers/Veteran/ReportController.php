<?php

namespace App\Http\Controllers\Veteran;

use App\Http\Controllers\Controller;
use App\Http\Requests\Veteran\ReportStoreRequest;
use App\Models\Veteran\Date;
use App\Models\Veteran\Report;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Report::class);
    }

    public function report()
    {
        if(!user()->can('report', Report::class))
            abort(403);

        return redirect()->route('veteran.reports.create', ['date' => Date::getActive()->id]);
    }

    public function index(Date $date, Report $report)
    {
        return Inertia::render('veteran/reports/index', [
            'date'      => $date->toResource(),
            'reports'   => $date->reports->toResourceCollection()
        ]);
    }

    public function create(Date $date)
    {
        return Inertia::render('veteran/reports/create', [
            'date' => fn() => $date->toResource(),
        ]);
    }

    public function store(ReportStoreRequest $request, Date $date)
    {
        $report = Report::create(array_merge($request->validated(), [
            'user_id' => user()->id,
            'division_id' => user()->getCurrentDivision()->id,
            'date_id' => $date->id,
        ]));

        return redirect()->route('veteran.reports.show', [
            'date' => $date->id,
            'report' => $report->id,
        ])->with('success', 'Запись успешно создана');
    }

    public function show(Date $date, Report $report)
    {
        return Inertia::render('veteran/reports/show', [
            'date' => fn() => $date->toResource(),
            'report' => fn() => $report->toResource(),
        ]);
    }

    public function destroy(Date $date, Report $report)
    {
        $report->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }
}
