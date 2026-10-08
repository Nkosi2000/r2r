<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerRequest;
use App\Models\Partner;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnerController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        return view('admin.partners.index', [
            'search' => $search,
            'partners' => Partner::query()
                ->when($search !== '', fn ($query) => $query->whereLike('name', "%{$search}%")->orWhereLike('description', "%{$search}%"))
                ->orderBy('position')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.partners.form', ['partner' => new Partner]);
    }

    public function store(PartnerRequest $request): RedirectResponse
    {
        Partner::query()->create([
            ...$request->safe()->except('logo'),
            'logo' => Uploads::store($request->file('logo'), 'partners'),
            'position' => (Partner::query()->max('position') ?? 0) + 1,
        ]);

        return to_route('admin.partners.index')->with('status', 'Partner added.');
    }

    public function edit(Partner $partner): View
    {
        return view('admin.partners.form', ['partner' => $partner]);
    }

    public function update(PartnerRequest $request, Partner $partner): RedirectResponse
    {
        $partner->update([
            ...$request->safe()->except('logo'),
            'logo' => Uploads::replace($request->file('logo'), $partner->logo, 'partners'),
        ]);

        return to_route('admin.partners.index')->with('status', 'Partner updated.');
    }

    public function destroy(Partner $partner): RedirectResponse
    {
        $partner->delete();
        Uploads::delete($partner->logo);

        return to_route('admin.partners.index')->with('status', 'Partner deleted.');
    }
}
