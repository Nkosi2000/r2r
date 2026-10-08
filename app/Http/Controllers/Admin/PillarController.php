<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PillarRequest;
use App\Models\Pillar;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PillarController extends Controller
{
    public function index(): View
    {
        return view('admin.pillars.index', [
            'pillars' => Pillar::query()->orderBy('position')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.pillars.form', ['pillar' => new Pillar]);
    }

    public function store(PillarRequest $request): RedirectResponse
    {
        Pillar::query()->create([...$request->validated(), 'position' => (Pillar::query()->max('position') ?? 0) + 1]);

        return to_route('admin.pillars.index')->with('status', 'Pillar added.');
    }

    public function edit(Pillar $pillar): View
    {
        return view('admin.pillars.form', ['pillar' => $pillar]);
    }

    public function update(PillarRequest $request, Pillar $pillar): RedirectResponse
    {
        $pillar->update($request->validated());

        return to_route('admin.pillars.index')->with('status', 'Pillar updated.');
    }

    public function destroy(Pillar $pillar): RedirectResponse
    {
        $pillar->delete();

        return to_route('admin.pillars.index')->with('status', 'Pillar deleted.');
    }
}
