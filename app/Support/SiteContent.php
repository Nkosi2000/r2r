<?php

namespace App\Support;

use App\Enums\MediaType;
use App\Models\Event;
use App\Models\MediaItem;
use App\Models\Partner;
use App\Models\Pillar;
use App\Models\Programme;
use App\Models\Report;
use App\Models\ResourceLink;
use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * All of the site's editable content, read from the database once and cached
 * until any content record changes (see FlushesSiteContent).
 */
class SiteContent
{
    private const CACHE_KEY = 'site-content';

    /**
     * @var array{settings: array<string, mixed>, pillars: Collection<int, Pillar>, programmes: Collection<int, Programme>, partners: Collection<int, Partner>, events: Collection<int, Event>, media: Collection<int, MediaItem>, resources: Collection<int, ResourceLink>, reports: Collection<int, Report>}|null
     */
    private ?array $content = null;

    /**
     * @var array<string, mixed>|null
     */
    private ?array $viewData = null;

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);

        $instance = app(self::class);
        $instance->content = null;
        $instance->viewData = null;
    }

    /**
     * Variables every view can use, e.g. $contact, $partners, $pastEvents.
     *
     * @return array<string, mixed>
     */
    public function viewData(): array
    {
        return $this->viewData ??= [
            'about' => $this->about(),
            'mission' => $this->mission(),
            'contact' => $this->contact(),
            'mailPartner' => 'mailto:'.($this->contact()['email'] ?? '').'?subject='.rawurlencode('Partnering with Rural2Rural'),
            'seo' => $this->seo(),
            'social' => $this->social(),
            'pillars' => $this->pillars(),
            'programmes' => $this->programmes(),
            'partners' => $this->partners(),
            'pastEvents' => $this->pastEvents(),
            'upcomingEvents' => $this->upcomingEvents(),
        ];
    }

    public function setting(string $key, mixed $default = null): mixed
    {
        return $this->content()['settings'][$key] ?? $default;
    }

    public function about(): string
    {
        return $this->setting('about', '');
    }

    /**
     * @return array<int, string>
     */
    public function mission(): array
    {
        return $this->setting('mission', []);
    }

    /**
     * @return array{email: string, phone: string, mobile: string, address: array<int, string>, postal: array<string, string>, map: array{latitude: float, longitude: float}}
     */
    public function contact(): array
    {
        return $this->setting('contact', []);
    }

    /**
     * @return array{title: string, share_title: string, description: string, slogan: string, keywords: string}
     */
    public function seo(): array
    {
        return $this->setting('seo', []);
    }

    /**
     * @return Collection<string, string> platform label => profile URL
     */
    public function social(): Collection
    {
        return collect($this->setting('social', []))->pluck('url', 'platform');
    }

    /**
     * @return Collection<int, Pillar>
     */
    public function pillars(): Collection
    {
        return $this->content()['pillars'];
    }

    /**
     * @return Collection<int, Programme>
     */
    public function programmes(): Collection
    {
        return $this->content()['programmes'];
    }

    /**
     * @return Collection<int, Partner>
     */
    public function partners(): Collection
    {
        return $this->content()['partners'];
    }

    /**
     * @return Collection<int, Event>
     */
    public function upcomingEvents(): Collection
    {
        return $this->content()['events']
            ->filter(fn (Event $event): bool => $event->held_on->gte(today()))
            ->sortBy('held_on')
            ->values();
    }

    /**
     * @return Collection<int, Event>
     */
    public function pastEvents(): Collection
    {
        return $this->content()['events']
            ->filter(fn (Event $event): bool => $event->held_on->lt(today()))
            ->values();
    }

    /**
     * @return Collection<int, MediaItem>
     */
    public function media(MediaType $type): Collection
    {
        return $this->content()['media']->where('type', $type)->values();
    }

    /**
     * @return Collection<string, Collection<int, ResourceLink>> links grouped under their heading
     */
    public function resourceGroups(): Collection
    {
        return $this->content()['resources']->groupBy('group');
    }

    /**
     * @return Collection<int, Report>
     */
    public function reports(): Collection
    {
        return $this->content()['reports'];
    }

    /**
     * @return array{settings: array<string, mixed>, pillars: Collection<int, Pillar>, programmes: Collection<int, Programme>, partners: Collection<int, Partner>, events: Collection<int, Event>, media: Collection<int, MediaItem>, resources: Collection<int, ResourceLink>, reports: Collection<int, Report>}
     */
    private function content(): array
    {
        if ($this->content !== null) {
            return $this->content;
        }

        // The cache only holds plain rows (it refuses to unserialize objects), so models are rebuilt from them.
        $rows = Cache::rememberForever(self::CACHE_KEY, fn (): array => [
            'settings' => SiteSetting::query()->toBase()->pluck('value', 'key')->all(),
            'pillars' => $this->rows(Pillar::query()->orderBy('position')),
            'programmes' => $this->rows(Programme::query()->orderBy('position')),
            'partners' => $this->rows(Partner::query()->orderBy('position')),
            'events' => $this->rows(Event::query()->orderByDesc('held_on')),
            'media' => $this->rows(MediaItem::query()->orderBy('position')),
            'resources' => $this->rows(ResourceLink::query()->orderBy('position')),
            'reports' => $this->rows(Report::query()->orderByDesc('year')),
        ]);

        return $this->content = [
            'settings' => array_map(fn (string $json): mixed => json_decode($json, true), $rows['settings']),
            'pillars' => Pillar::hydrate($rows['pillars'])->toBase(),
            'programmes' => Programme::hydrate($rows['programmes'])->toBase(),
            'partners' => Partner::hydrate($rows['partners'])->toBase(),
            'events' => Event::hydrate($rows['events'])->toBase(),
            'media' => MediaItem::hydrate($rows['media'])->toBase(),
            'resources' => ResourceLink::hydrate($rows['resources'])->toBase(),
            'reports' => Report::hydrate($rows['reports'])->toBase(),
        ];
    }

    /**
     * @param  Builder<covariant Model>  $query
     * @return array<int, array<string, mixed>>
     */
    private function rows(Builder $query): array
    {
        return $query->toBase()->get()->map(fn (object $row): array => (array) $row)->all();
    }
}
