<x-layouts.admin title="Dashboard">
    <x-admin.page-header :title="'Welcome, '.auth()->user()->name" description="Manage everything on the Rural2Rural website. Changes go live as soon as you save.">
        <x-button :href="route('home')" target="_blank" rel="noopener" variant="navy">View website</x-button>
    </x-admin.page-header>

    <ul class="grid gap-px border border-navy/10 bg-navy/10 sm:grid-cols-2 xl:grid-cols-4 xl:[&>li:last-child]:col-span-2">
        @foreach ($sections as $section)
            <li>
                <a href="{{ route($section['route']) }}" class="group flex h-full flex-col gap-6 bg-white p-5 transition-colors hover:bg-paper">
                    <span class="font-mono text-[10px] tracking-[0.1em] text-navy/55 uppercase">{{ $section['label'] }}</span>
                    <span class="flex items-end justify-between">
                        <span class="text-4xl font-light tracking-[-0.03em] tabular-nums">{{ $section['count'] }}</span>
                        <span class="font-mono text-[10px] tracking-[0.08em] text-blue uppercase group-hover:underline">Manage <span aria-hidden="true">→</span></span>
                    </span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="mt-10 grid gap-8 xl:grid-cols-[1.4fr_1fr]">
        <section aria-labelledby="recent-title">
            <h2 id="recent-title" class="mb-3 font-mono text-[10px] tracking-[0.1em] text-navy/55 uppercase">Recently edited</h2>
            @if ($recentlyEdited->isNotEmpty())
                <ul class="border-t border-navy/10 bg-white">
                    @foreach ($recentlyEdited as $item)
                        <li class="border-b border-navy/10">
                            <a href="{{ $item['url'] }}" class="flex items-baseline justify-between gap-4 px-4 py-3 hover:bg-paper">
                                <span class="min-w-0">
                                    <span class="block truncate text-[14px]">{{ $item['title'] }}</span>
                                    <span class="font-mono text-[10px] tracking-[0.08em] text-blue uppercase">{{ $item['section'] }}</span>
                                </span>
                                <time datetime="{{ $item['updated_at']?->toIso8601String() }}" class="shrink-0 text-[12px] text-navy/50">{{ $item['updated_at']?->diffForHumans() }}</time>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-admin.empty message="Nothing has been edited yet." />
            @endif
        </section>

        <section aria-labelledby="upcoming-title">
            <h2 id="upcoming-title" class="mb-3 font-mono text-[10px] tracking-[0.1em] text-navy/55 uppercase">Upcoming events</h2>
            @if ($upcomingEvents->isNotEmpty())
                <ul class="border-t border-navy/10 bg-white">
                    @foreach ($upcomingEvents as $event)
                        <li class="border-b border-navy/10">
                            <a href="{{ route('admin.events.edit', $event) }}" class="flex items-baseline justify-between gap-4 px-4 py-3 hover:bg-paper">
                                <span class="min-w-0">
                                    <span class="block truncate text-[14px]">{{ $event->title }}</span>
                                    <span class="font-mono text-[10px] tracking-[0.08em] text-blue uppercase">{{ $event->place }}</span>
                                </span>
                                <span class="shrink-0 font-mono text-[11px] text-navy/60">{{ $event->date }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-admin.empty message="No upcoming events. The Events page is asking visitors to host a roadshow.">
                    <x-button :href="route('admin.events.create')" variant="navy">Add an event</x-button>
                </x-admin.empty>
            @endif

            <h2 class="mt-8 mb-3 font-mono text-[10px] tracking-[0.1em] text-navy/55 uppercase">Quick links</h2>
            <ul class="grid gap-2 text-[14px]">
                <li><a href="{{ route('admin.media.create', ['type' => 'photo']) }}" class="text-blue hover:underline">Upload a photo</a></li>
                <li><a href="{{ route('admin.reports.create') }}" class="text-blue hover:underline">Publish a report</a></li>
                <li><a href="{{ route('admin.partners.create') }}" class="text-blue hover:underline">Add a partner</a></li>
                @can('manage-settings')
                    <li><a href="{{ route('admin.settings.edit') }}" class="text-blue hover:underline">Edit contact details &amp; SEO</a></li>
                @endcan
            </ul>
        </section>
    </div>
</x-layouts.admin>
