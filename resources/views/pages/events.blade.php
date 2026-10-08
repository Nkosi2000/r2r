@php
    $mailHostRoadshow = 'mailto:'.$contact['email'].'?subject='.rawurlencode('Hosting an R2R roadshow');
@endphp

<x-layouts.app title="Events" description="Rural2Rural careers & skills expos and roadshows across South Africa's provinces — upcoming dates, past events and how to host a roadshow in your community.">
    <x-page-header title="Events" eyebrow="Roadshows<br>// &amp; expos">
        Careers &amp; skills expos and roadshows that bring guidance and opportunity to rural provinces across South Africa.
    </x-page-header>

    {{-- ─────────────── Upcoming ─────────────── --}}
    <section class="relative border-t border-white/10 bg-night" aria-labelledby="upcoming-title">
        <x-rail />
        <div data-reveal class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr] lg:py-28">
            <x-eyebrow first="Coming" class="fade-up">up next</x-eyebrow>
            <div>
                <h2 id="upcoming-title" class="fade-up text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em] delay-100">Upcoming events</h2>

                @if ($upcomingEvents->isNotEmpty())
                    <ul class="mt-10 border-t border-white/10">
                        @foreach ($upcomingEvents as $event)
                            <li class="flex items-baseline justify-between gap-4 border-b border-white/10 py-5">
                                <span>
                                    <span class="block text-lg">{{ $event['title'] }}</span>
                                    <span class="font-mono text-[10px] tracking-[0.08em] text-green uppercase">{{ $event['place'] }}</span>
                                </span>
                                <span class="font-mono text-[11px] tracking-[0.08em] whitespace-nowrap text-white/60 uppercase">{{ $event['date'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="fade-up mt-10 flex flex-col gap-6 border border-dashed border-white/20 p-8 delay-150 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="flex items-center gap-2 font-mono text-[10px] tracking-[0.1em] text-lime uppercase"><i class="animate-blink size-1.5 bg-lime"></i>Route being planned</p>
                            <p class="mt-3 max-w-md text-[15px] leading-relaxed text-white/70">New roadshow dates will be announced here. Want the next one in your province?</p>
                        </div>
                        <x-button :href="$mailHostRoadshow" class="shrink-0">Host a roadshow</x-button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ─────────────── All events: filterable archive ─────────────── --}}
    @php
        $filterUrl = fn (array $overrides = []): string => route('events', $filters->query($overrides)).'#all-events';
        $selectClasses = 'h-11 w-full appearance-none border border-navy/20 bg-white bg-[length:10px] bg-[right_0.9rem_center] bg-no-repeat pr-9 pl-3 text-[14px] text-navy outline-none focus-visible:border-blue focus-visible:ring-2 focus-visible:ring-blue/30';
        $selectArrow = "background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' fill='none' stroke='%23293179' stroke-width='1.5'/%3E%3C/svg%3E\")";
    @endphp
    <section id="all-events" data-header="light" class="scroll-mt-16 bg-paper text-navy" aria-labelledby="all-events-title">
        <div class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr] lg:py-28">
            <p class="tag text-blue">Find an<br>// event</p>
            <div>
                <h2 id="all-events-title" class="text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] tracking-[-0.025em]">All events</h2>
                <p class="mt-4 max-w-xl text-[15px] leading-relaxed text-navy/70">Search every roadshow and expo by name, province, date and status.</p>

                <form data-event-filters method="GET" action="{{ route('events') }}#all-events" class="mt-10 grid gap-6 border border-navy/10 bg-white p-5 sm:p-6" role="search" aria-label="Filter events">
                    <div class="grid gap-6 md:grid-cols-[1fr_auto]">
                        <label class="grid gap-2">
                            <span class="font-mono text-[10px] tracking-[0.1em] text-navy/60 uppercase">Keyword</span>
                            <input type="search" name="q" value="{{ $filters->keyword }}" maxlength="100" placeholder="e.g. careers expo" class="h-11 w-full border border-navy/20 bg-white px-3 text-[14px] text-navy outline-none placeholder:text-navy/40 focus-visible:border-blue focus-visible:ring-2 focus-visible:ring-blue/30">
                        </label>

                        <fieldset class="grid gap-2">
                            <legend class="mb-2 font-mono text-[10px] tracking-[0.1em] text-navy/60 uppercase">Status</legend>
                            <div class="flex h-11 border border-navy/20">
                                @foreach (['' => 'All', ...collect(App\Enums\EventStatus::cases())->mapWithKeys(fn ($status) => [$status->value => $status->label()])] as $value => $label)
                                    <label class="flex flex-1 cursor-pointer items-center justify-center px-4 text-[13px] transition-colors not-last:border-r not-last:border-navy/20 has-checked:bg-navy has-checked:text-white has-focus-visible:ring-2 has-focus-visible:ring-blue/40 has-focus-visible:ring-inset">
                                        <input type="radio" name="status" value="{{ $value }}" class="sr-only" @checked(($filters->status?->value ?? '') === $value)>
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>

                    @if ($eventProvinces->isNotEmpty())
                        <fieldset>
                            <legend class="mb-2 font-mono text-[10px] tracking-[0.1em] text-navy/60 uppercase">Province</legend>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($eventProvinces as $province)
                                    <label class="flex cursor-pointer items-center gap-2 border border-navy/20 px-3 py-2 text-[13px] transition-colors hover:border-navy/50 has-checked:border-navy has-checked:bg-navy has-checked:text-white has-focus-visible:ring-2 has-focus-visible:ring-blue/40">
                                        <input type="checkbox" name="province[]" value="{{ $province }}" class="sr-only" @checked(in_array($province, $filters->provinces, true))>
                                        <span class="size-1.5 bg-green" aria-hidden="true"></span>{{ $province }}
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    @endif

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        @foreach (['from' => ['From year', $filters->fromYear, 'Any'], 'to' => ['To year', $filters->toYear, 'Any']] as $name => [$label, $selected, $placeholder])
                            <label class="grid gap-2">
                                <span class="font-mono text-[10px] tracking-[0.1em] text-navy/60 uppercase">{{ $label }}</span>
                                <select name="{{ $name }}" class="{{ $selectClasses }}" style="{{ $selectArrow }}">
                                    <option value="">{{ $placeholder }}</option>
                                    @foreach ($eventYears as $year)
                                        <option value="{{ $year }}" @selected($selected === $year)>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </label>
                        @endforeach
                        <label class="col-span-2 grid gap-2 sm:col-span-1">
                            <span class="font-mono text-[10px] tracking-[0.1em] text-navy/60 uppercase">Sort by</span>
                            <select name="sort" class="{{ $selectClasses }}" style="{{ $selectArrow }}">
                                @foreach (App\Enums\EventSort::cases() as $sort)
                                    <option value="{{ $sort->value }}" @selected($filters->sort === $sort)>{{ $sort->label() }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 border-t border-navy/10 pt-5">
                        <x-button type="submit" variant="navy">Apply filters</x-button>
                        @if ($filters->isActive())
                            <a href="{{ route('events') }}#all-events" class="text-[13px] text-navy/70 underline underline-offset-4 hover:text-navy">Clear all filters</a>
                        @endif
                    </div>
                </form>

                {{-- Active filters, each removable on its own --}}
                @if ($filters->isActive())
                    <ul class="mt-6 flex flex-wrap gap-2" aria-label="Active filters">
                        @php
                            $chips = collect()
                                ->when($filters->keyword !== '', fn ($chips) => $chips->push(['“'.$filters->keyword.'”', $filterUrl(['q' => null])]))
                                ->merge(collect($filters->provinces)->map(fn ($province) => [$province, $filterUrl(['province' => array_values(array_diff($filters->provinces, [$province]))])]))
                                ->when($filters->status, fn ($chips) => $chips->push([$filters->status->label(), $filterUrl(['status' => null])]))
                                ->when($filters->fromYear, fn ($chips) => $chips->push(['From '.$filters->fromYear, $filterUrl(['from' => null])]))
                                ->when($filters->toYear, fn ($chips) => $chips->push(['To '.$filters->toYear, $filterUrl(['to' => null])]));
                        @endphp
                        @foreach ($chips as [$label, $url])
                            <li>
                                <a href="{{ $url }}" class="flex items-center gap-2 bg-navy px-3 py-1.5 text-[12px] text-white transition-colors hover:bg-blue" aria-label="Remove filter: {{ $label }}">
                                    {{ $label }}<span aria-hidden="true">✕</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <p class="mt-10 font-mono text-[10px] tracking-[0.1em] text-navy/60 uppercase" aria-live="polite">
                    Showing {{ $filteredEvents->count() }} of {{ $totalEvents }} {{ Str::plural('event', $totalEvents) }}
                </p>

                @if ($filteredEvents->isNotEmpty())
                    <ul class="mt-3 border-t border-navy/15">
                        @foreach ($filteredEvents as $event)
                            @php($isUpcoming = $event->held_on->gte(today()))
                            <li class="grid grid-cols-[auto_1fr] items-baseline gap-x-5 gap-y-1 border-b border-navy/15 py-5 sm:grid-cols-[7.5rem_1fr_auto]">
                                <time datetime="{{ $event->held_on->toDateString() }}" class="font-mono text-[11px] tracking-[0.08em] whitespace-nowrap text-navy/60 uppercase">{{ $event->date }}</time>
                                <span class="min-w-0">
                                    <span class="block text-lg leading-snug">{{ $event->title }}</span>
                                    <span class="font-mono text-[10px] tracking-[0.08em] text-blue uppercase">{{ $event->place }}</span>
                                </span>
                                <span class="col-start-2 justify-self-start font-mono text-[9px] tracking-[0.1em] uppercase sm:col-start-auto sm:justify-self-end {{ $isUpcoming ? 'bg-green px-2 py-1 text-night' : 'px-2 py-1 text-navy/50 ring-1 ring-navy/15' }}">
                                    {{ $isUpcoming ? App\Enums\EventStatus::Upcoming->label() : App\Enums\EventStatus::Past->label() }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="mt-3 flex flex-col gap-4 border border-dashed border-navy/25 p-8 sm:flex-row sm:items-center sm:justify-between">
                        <p class="max-w-md text-[15px] leading-relaxed text-navy/70">No events match these filters. Try removing a filter or widening the year range.</p>
                        <x-button :href="route('events').'#all-events'" variant="navy" class="shrink-0">Show all events</x-button>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @include('sections.on-the-road')
    @include('sections.work-with-us')
</x-layouts.app>
