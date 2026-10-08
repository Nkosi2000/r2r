<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProgrammeRequest;
use App\Models\Pillar;
use App\Models\Programme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgrammeController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        return view('admin.programmes.index', [
            'search' => $search,
            'programmes' => Programme::query()
                ->when($search !== '', fn ($query) => $query->whereLike('title', "%{$search}%")->orWhereLike('pillar', "%{$search}%"))
                ->orderBy('position')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.programmes.form', ['programme' => new Programme, 'pillarLabels' => $this->pillarLabels()]);
    }

    public function store(ProgrammeRequest $request): RedirectResponse
    {
        Programme::query()->create([...$request->validated(), 'position' => (Programme::query()->max('position') ?? 0) + 1]);

        return to_route('admin.programmes.index')->with('status', 'Programme added.');
    }

    public function edit(Programme $programme): View
    {
        return view('admin.programmes.form', ['programme' => $programme, 'pillarLabels' => $this->pillarLabels()]);
    }

    public function update(ProgrammeRequest $request, Programme $programme): RedirectResponse
    {
        $programme->update($request->validated());

        return to_route('admin.programmes.index')->with('status', 'Programme updated.');
    }

    public function destroy(Programme $programme): RedirectResponse
    {
        $programme->delete();

        return to_route('admin.programmes.index')->with('status', 'Programme deleted.');
    }

    /**
     * Labels already in use, offered as suggestions so programmes stay consistently grouped.
     *
     * @return array<int, string>
     */
    private function pillarLabels(): array
    {
        return Pillar::query()->pluck('verb')
            ->merge(Programme::query()->pluck('pillar'))
            ->unique()
            ->sort()
            ->values()
            ->all();
    }
}
