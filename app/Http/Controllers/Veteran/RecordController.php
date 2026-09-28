<?php

namespace App\Http\Controllers\Veteran;

use App\Http\Controllers\Controller;
use App\Http\Requests\Veteran\RecordStoreRequest;
use App\Http\Requests\Veteran\RecordUpdateRequest;
use App\Models\Base\User;
use App\Models\Veteran\Record;
use App\Models\Veteran\Report;
use Inertia\Inertia;

class RecordController extends Controller
{
    public function index(Report $report)
    {
        return Inertia::render('veteran/records/index', [
            'report_id' => fn() => $report->id,
            'records' => fn() => $report->records->toResourceCollection(),
        ]);
    }

    public function create(Report $report)
    {
        return Inertia::render('veteran/records/create', [
            'report' => fn() => $report->toResource(),
        ]);
    }

    public function store(RecordStoreRequest $request, Report $report)
    {
        $record = Record::create(array_merge($request->validated(), [
            'user_id' => user()->id,
            'division_id' => user()->getCurrentDivision()->id,
            'report_id' => $report->id,
        ]));

        return redirect()->route('veteran-work.records.show', [
            'report' => $report->id,
            'record' => $record->id,
        ])->with('success', 'Запись успешно создана');
    }

    public function show(Report $report, Record $record){
        return Inertia::render('veteran/records/show', [
            'report' => fn() => $report->toResource(),
            'record' => fn() => $record->toResource(),
        ]);
    }

    public function edit(Report $report, Record $record){
        return Inertia::render('veteran/records/edit', [
            'report' => fn() => $report->toResource(),
            'record' => fn() => $record->toResource(),
        ]);
    }

    public function update(RecordUpdateRequest $request, Report $report, Record $record)
    {
        $record->update($request->validated());

        return redirect()->route('veteran-work.records.show', [
            'report' => $report->id,
            'record' => $record->id,
        ])->with('success', 'Запись успешно обновлена');
    }
}
