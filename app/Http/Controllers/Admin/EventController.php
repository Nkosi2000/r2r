<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));

        return view('admin.events.index', [
            'search' => $search,
            'events' => Event::query()
                ->when($search !== '', fn ($query) => $query->whereLike('title', "%{$search}%")->orWhereLike('place', "%{$search}%"))
                ->orderByDesc('held_on')
                ->paginate(25)
                ->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.form', ['event' => new Event]);
    }

    public function store(EventRequest $request): RedirectResponse
    {
        Event::query()->create($request->eventAttributes());

        return to_route('admin.events.index')->with('status', 'Event added.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.form', ['event' => $event]);
    }

    public function update(EventRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->eventAttributes());

        return to_route('admin.events.index')->with('status', 'Event updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return to_route('admin.events.index')->with('status', 'Event deleted.');
    }
}
