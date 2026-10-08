<?php

namespace App\Support;

use App\Enums\EventSort;
use App\Enums\EventStatus;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Filters for the events archive, read from the query string (?q=&province[]=&status=&from=&to=&sort=)
 * so a filtered view can be bookmarked or shared and works without JavaScript.
 */
final readonly class EventFilters
{
    /**
     * @param  array<int, string>  $provinces
     */
    public function __construct(
        public string $keyword = '',
        public array $provinces = [],
        public ?EventStatus $status = null,
        public ?int $fromYear = null,
        public ?int $toYear = null,
        public EventSort $sort = EventSort::Newest,
    ) {}

    /**
     * Malformed values are ignored rather than rejected, so an edited or outdated link still shows events.
     */
    public static function fromRequest(Request $request): self
    {
        $text = fn (mixed $value): string => is_string($value) ? Str::limit(trim($value), 100, '') : '';
        $year = fn (mixed $value): ?int => is_string($value) && preg_match('/^\d{4}$/', $value) === 1 ? (int) $value : null;

        $provinces = collect(Arr::wrap($request->query('province')))
            ->map($text)
            ->filter()
            ->unique()
            ->take(20)
            ->values()
            ->all();

        $fromYear = $year($request->query('from'));
        $toYear = $year($request->query('to'));

        if ($fromYear !== null && $toYear !== null && $fromYear > $toYear) {
            [$fromYear, $toYear] = [$toYear, $fromYear];
        }

        return new self(
            keyword: $text($request->query('q')),
            provinces: $provinces,
            status: EventStatus::tryFrom($text($request->query('status'))),
            fromYear: $fromYear,
            toYear: $toYear,
            sort: EventSort::tryFrom($text($request->query('sort'))) ?? EventSort::Newest,
        );
    }

    /**
     * @param  Collection<int, Event>  $events
     * @return Collection<int, Event>
     */
    public function apply(Collection $events): Collection
    {
        $keywords = Str::of($this->keyword)->lower()->explode(' ')->filter();

        $filtered = $events
            ->filter(fn (Event $event): bool => $keywords->every(
                fn (string $keyword): bool => Str::contains(Str::lower($event->title.' '.$event->place), $keyword),
            ))
            ->when($this->provinces !== [], fn (Collection $events): Collection => $events->whereIn('place', $this->provinces))
            ->when($this->status === EventStatus::Upcoming, fn (Collection $events): Collection => $events->filter(fn (Event $event): bool => $event->held_on->gte(today())))
            ->when($this->status === EventStatus::Past, fn (Collection $events): Collection => $events->filter(fn (Event $event): bool => $event->held_on->lt(today())))
            ->when($this->fromYear !== null, fn (Collection $events): Collection => $events->filter(fn (Event $event): bool => $event->held_on->year >= $this->fromYear))
            ->when($this->toYear !== null, fn (Collection $events): Collection => $events->filter(fn (Event $event): bool => $event->held_on->year <= $this->toYear));

        return $filtered
            ->sortBy(fn (Event $event): int => $event->held_on->getTimestamp(), descending: $this->sort === EventSort::Newest)
            ->values();
    }

    /**
     * Number of filters narrowing the results (sorting is not counted).
     */
    public function activeCount(): int
    {
        return count(array_filter([
            $this->keyword !== '',
            $this->provinces !== [],
            $this->status !== null,
            $this->fromYear !== null,
            $this->toYear !== null,
        ]));
    }

    public function isActive(): bool
    {
        return $this->activeCount() > 0;
    }

    /**
     * Query string for these filters, with any overrides applied (null removes a filter).
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public function query(array $overrides = []): array
    {
        $query = [
            'q' => $this->keyword,
            'province' => $this->provinces,
            'status' => $this->status?->value,
            'from' => $this->fromYear,
            'to' => $this->toYear,
            'sort' => $this->sort === EventSort::Newest ? null : $this->sort->value,
            ...$overrides,
        ];

        return array_filter($query, fn (mixed $value): bool => $value !== null && $value !== '' && $value !== []);
    }
}
