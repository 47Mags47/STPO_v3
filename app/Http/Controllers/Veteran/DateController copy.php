<?php

namespace App\Http\Controllers\Veteran;

use App\Http\Controllers\Controller;
use App\Http\Requests\Veteran\ReportStoreRequest;
use App\Http\Requests\Veteran\ReportUpdateRequest;
use App\Models\Veteran\Report;
use Inertia\Inertia;

class DateController extends Controller
{
    public function index()
    {
        if (user()->hasPermission('veteran_admin')) {
            return Inertia::render('veteran/reports/index', [
                'reports' => fn() => Report::getResource(orderColumn: 'start_at', orderDesc: 'desc', withTrashed: true),
            ]);
        }

        return redirect()->route('veteran-work.records.create', ['report' => Report::getActive()]);
    }

    // public function create()
    // {
    //     return Inertia::render('veteran/reports/create');
    // }
    // public function store(ReportStoreRequest $request)
    // {
    //     if ($request->input('activate')) {
    //         Report::where('is_active', true)->update(['is_activate', false]);
    //     }

    //     Report::create(array_merge($request->validated(), [
    //         'is_active' => $request->input('activate'),
    //     ]));

    //     return redirect()->route('veteran-work.reports.index')->with('success', 'Запись успешно создана');
    // }

    // public function update(ReportUpdateRequest $request, Report $report)
    // {
    //     if($report->deleted_at !== null)
    //         abort(404);

    //     $data = $request->validated();

    //     if ($data['is_active'])
    //         Report::where('id', '!=', $report->id)->update(['is_active' => false]);

    //     $report->update($data);

    //     return redirect()->route('veteran-work.reports.index')->with('success', 'Запись успешно обновлена');
    // }

    // public function show(Report $report)
    // {
    //     if($report->deleted_at !== null)
    //         abort(404);

    //     dd('show');
    // }

    // public function destroy(Report $report)
    // {
    //     if($report->deleted_at !== null)
    //         abort(404);

    //     if($report->is_active)
    //         return redirect()->back()->with('error', 'Удаление невозможно: отчёт активен');

    //     $report->delete();

    //     return redirect()->back()->with('success', 'Запись удалена');
    // }

    // public function restore(Report $report) {
    //     $report->restore();

    //     return redirect()->back()->with('success', 'Запись успешно восстановлена');
    // }
}
