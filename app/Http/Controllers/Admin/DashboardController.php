<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\MediaItem;
use App\Models\Partner;
use App\Models\Pillar;
use App\Models\Programme;
use App\Models\Report;
use App\Models\ResourceLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Overview of every content type, with the most recently edited items.
     */
    public function __invoke(): View
    {
        $sections = [
            ['label' => 'Pillars', 'route' => 'admin.pillars.index', 'model' => Pillar::class, 'title' => 'title'],
            ['label' => 'Programmes', 'route' => 'admin.programmes.index', 'model' => Programme::class, 'title' => 'title'],
            ['label' => 'Partners', 'route' => 'admin.partners.index', 'model' => Partner::class, 'title' => 'name'],
            ['label' => 'Events', 'route' => 'admin.events.index', 'model' => Event::class, 'title' => 'title'],
            ['label' => 'Media', 'route' => 'admin.media.index', 'model' => MediaItem::class, 'title' => 'title'],
            ['label' => 'Resources', 'route' => 'admin.resources.index', 'model' => ResourceLink::class, 'title' => 'title'],
            ['label' => 'Reports', 'route' => 'admin.reports.index', 'model' => Report::class, 'title' => 'title'],
        ];

        $recentlyEdited = collect($sections)
            ->flatMap(fn (array $section) => $section['model']::query()->latest('updated_at')->limit(5)->get()
                ->map(fn (Model $item): array => [
                    'section' => $section['label'],
                    'title' => $item->getAttribute($section['title']),
                    'url' => route(str_replace('.index', '.edit', $section['route']), $item),
                    'updated_at' => $item->updated_at,
                ]))
            ->sortByDesc('updated_at')
            ->take(8)
            ->values();

        return view('admin.dashboard', [
            'sections' => collect($sections)->map(fn (array $section): array => [...$section, 'count' => $section['model']::query()->count()]),
            'upcomingEvents' => Event::query()->whereDate('held_on', '>=', today())->orderBy('held_on')->limit(3)->get(),
            'recentlyEdited' => $recentlyEdited,
        ]);
    }
}
