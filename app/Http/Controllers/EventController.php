<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Support\EventFilters;
use App\Support\SiteContent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Show the events page with the archive narrowed by the visitor's filters.
     */
    public function __invoke(Request $request, SiteContent $content): View
    {
        $events = $content->events();
        $filters = EventFilters::fromRequest($request);

        return view('pages.events', [
            'filters' => $filters,
            'filteredEvents' => $filters->apply($events),
            'totalEvents' => $events->count(),
            'eventProvinces' => $events->pluck('place')->unique()->sort()->values(),
            'eventYears' => $events->map(fn (Event $event): int => $event->held_on->year)->unique()->sortDesc()->values(),
        ]);
    }
}
