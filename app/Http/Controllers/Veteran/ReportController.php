<?php

namespace App\Http\Controllers\Veteran;

use App\Http\Controllers\Controller;
use App\Http\Requests\Veteran\ReportStoreRequest;
use App\Http\Requests\Veteran\ReportUpdateRequest;
use App\Http\Resources\Base\UserResource;
use App\Http\Resources\Veteran\ReportResource;
use App\Models\Base\User;
use App\Models\Veteran\Record;
use App\Models\Veteran\Report;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    // use AuthorizesRequests;
    public function __construct()
    {
        // $this->authorizeResource(Report::class);
    }
    public function index()
    {
        if (user()->hasPermission('veteran_work_admin')) {
            return Inertia::render('veteran/reports/index', [
                'reports' => fn() => Report::getResource(withTrashed: true, order: 'start_at', orderDesc: 'desc'),
            ]);
        }

        return redirect()->route('veteran-work.records.create', ['report' => Report::getActive()]);
    }

    public function create()
    {
        return Inertia::render('veteran/reports/create');
    }
    public function store(ReportStoreRequest $request)
    {
        if ($request->input('activate')) {
            Report::where('is_active', true)->update(['is_activate', false]);
        }

        Report::create(array_merge($request->validated(), [
            'is_active' => $request->input('activate'),
        ]));

        return redirect()->route('veteran-work.reports.index')->with('success', 'Запись успешно создана');
    }

    public function update(ReportUpdateRequest $request, Report $report)
    {
        if($report->deleted_at !== null)
            abort(404);

        $data = $request->validated();

        if ($data['is_active'])
            Report::where('id', '!=', $report->id)->update(['is_active' => false]);

        $report->update($data);

        return redirect()->route('veteran-work.reports.index')->with('success', 'Запись успешно обновлена');
    }

    public function show(Report $report)
    {
        if($report->deleted_at !== null)
            abort(404);

        dd('show');
    }

    public function destroy(Report $report)
    {
        if($report->deleted_at !== null)
            abort(404);

        if($report->is_active)
            return redirect()->back()->with('error', 'Удаление невозможно: отчёт активен');

        $report->delete();

        return redirect()->back()->with('success', 'Запись удалена');
    }

    public function restore(Report $report) {
        $report->restore();

        return redirect()->back()->with('success', 'Запись успешно восстановлена');
    }
}
