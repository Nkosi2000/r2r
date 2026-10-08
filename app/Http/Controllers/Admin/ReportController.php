<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReportRequest;
use App\Models\Report;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports.index', [
            'reports' => Report::query()->orderByDesc('year')->orderBy('title')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.reports.form', ['report' => new Report(['year' => now()->year])]);
    }

    public function store(ReportRequest $request): RedirectResponse
    {
        Report::query()->create([
            ...$request->safe()->except('file'),
            'file' => Uploads::store($request->file('file'), 'reports'),
        ]);

        return to_route('admin.reports.index')->with('status', 'Report added.');
    }

    public function edit(Report $report): View
    {
        return view('admin.reports.form', ['report' => $report]);
    }

    public function update(ReportRequest $request, Report $report): RedirectResponse
    {
        $report->update([
            ...$request->safe()->except('file'),
            'file' => Uploads::replace($request->file('file'), $report->file, 'reports'),
        ]);

        return to_route('admin.reports.index')->with('status', 'Report updated.');
    }

    public function destroy(Report $report): RedirectResponse
    {
        $report->delete();
        Uploads::delete($report->file);

        return to_route('admin.reports.index')->with('status', 'Report deleted.');
    }
}
