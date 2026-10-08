<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResourceLinkRequest;
use App\Models\ResourceLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResourceLinkController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        return view('admin.resources.index', [
            'search' => $search,
            'groups' => ResourceLink::query()
                ->when($search !== '', fn ($query) => $query->whereLike('title', "%{$search}%")->orWhereLike('group', "%{$search}%")->orWhereLike('description', "%{$search}%"))
                ->orderBy('position')
                ->orderBy('id')
                ->get()
                ->groupBy('group'),
        ]);
    }

    public function create(): View
    {
        return view('admin.resources.form', ['resourceLink' => new ResourceLink, 'groupNames' => $this->groupNames()]);
    }

    public function store(ResourceLinkRequest $request): RedirectResponse
    {
        ResourceLink::query()->create([...$request->validated(), 'position' => (ResourceLink::query()->max('position') ?? 0) + 1]);

        return to_route('admin.resources.index')->with('status', 'Resource added.');
    }

    public function edit(ResourceLink $resourceLink): View
    {
        return view('admin.resources.form', ['resourceLink' => $resourceLink, 'groupNames' => $this->groupNames()]);
    }

    public function update(ResourceLinkRequest $request, ResourceLink $resourceLink): RedirectResponse
    {
        $resourceLink->update($request->validated());

        return to_route('admin.resources.index')->with('status', 'Resource updated.');
    }

    public function destroy(ResourceLink $resourceLink): RedirectResponse
    {
        $resourceLink->delete();

        return to_route('admin.resources.index')->with('status', 'Resource deleted.');
    }

    /**
     * Existing headings, offered as suggestions so links land under the right group.
     *
     * @return array<int, string>
     */
    private function groupNames(): array
    {
        return ResourceLink::query()->distinct()->orderBy('group')->pluck('group')->all();
    }
}
