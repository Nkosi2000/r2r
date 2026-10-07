{{-- ─────────────── 08 · On the road (dot map) ─────────────── --}}
<section id="events" class="relative border-t border-white/10 bg-night" aria-labelledby="events-title">
    <x-rail />
    <div class="{{ $gutter }} grid gap-14 py-24 lg:grid-cols-[1fr_1.6fr] lg:py-28">
        <div class="flex flex-col">
            <x-eyebrow first="On the">road</x-eyebrow>
            <h2 id="events-title" class="mt-6 max-w-md text-[clamp(1.6rem,2.6vw,2.3rem)] leading-[1.12] font-light tracking-[-0.025em]">Bringing skills, jobs and careers to every corner of rural South Africa.</h2>

            <p class="mt-12 font-mono text-[10px] tracking-[0.1em] text-white/45 uppercase">Past events</p>
            <ul class="mt-3 border-t border-white/10">
                @foreach ($pastEvents as $event)
                    <li class="flex items-baseline justify-between gap-4 border-b border-white/10 py-4">
                        <span>
                            <span class="block text-[15px]">{{ $event['title'] }}</span>
                            <span class="font-mono text-[10px] tracking-[0.08em] text-green uppercase">{{ $event['place'] }}</span>
                        </span>
                        <span class="font-mono text-[10px] tracking-[0.08em] whitespace-nowrap text-white/50 uppercase">{{ $event['date'] }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="mt-auto flex gap-10 pt-12">
                <p class="font-mono text-[10px] tracking-[0.08em] text-white/50 uppercase"><span class="block text-xl text-green">10+</span>Years on the road</p>
                <p class="font-mono text-[10px] tracking-[0.08em] text-white/50 uppercase"><span class="block text-xl text-green">{{ sprintf('%02d', $pillars->count()) }}</span>Programme pillars</p>
            </div>
            @isset($moreLink)
                <x-button :href="$moreLink" variant="outline" class="mt-10 self-start">All events</x-button>
            @endisset
        </div>

        {{-- Map pins: head office plus every province an event has a location for; routes run from HQ to each stop and between stops --}}
        @php
            $stops = $pastEvents->concat($upcomingEvents)
                ->filter(fn (App\Models\Event $event): bool => $event->latitude !== null && $event->longitude !== null)
                ->unique('place')
                ->map(fn (App\Models\Event $event): array => ['id' => Illuminate\Support\Str::slug($event->place, '_'), 'lat' => $event->latitude, 'lon' => $event->longitude, 'label' => $event->place])
                ->values();
            $mapNodes = collect([['id' => 'hq', 'lat' => $contact['map']['latitude'], 'lon' => $contact['map']['longitude'], 'label' => $contact['map']['label']]])->concat($stops);
            $mapRoutes = $stops->map(fn (array $stop): string => 'hq-'.$stop['id'])
                ->concat($stops->sliding(2)->map(fn (Illuminate\Support\Collection $pair): string => $pair->first()['id'].'-'.$pair->last()['id']));
        @endphp
        <div class="relative aspect-[1.124] w-full">
            <canvas data-dot-map data-routes="{{ $mapRoutes->implode(' ') }}" class="absolute inset-0 size-full" aria-hidden="true"></canvas>
            @foreach ($mapNodes as $node)
                <span data-map-node="{{ $node['id'] }}" data-lon="{{ $node['lon'] }}" data-lat="{{ $node['lat'] }}" class="absolute -translate-1/2">
                    <span class="animate-pulse-ring absolute inset-0 rounded-full bg-green" aria-hidden="true"></span>
                    <span class="relative grid size-6 place-items-center rounded-full bg-white shadow-lg">
                        <span class="size-2 rounded-full {{ $node['id'] === 'hq' ? 'bg-green' : 'bg-navy' }}"></span>
                    </span>
                    {{-- Pins near the east or west coast label inwards so the text stays on the map --}}
                    <span class="absolute top-1/2 {{ $node['lon'] > 30.5 || $node['lon'] < 26 ? 'right-8' : 'left-8' }} -translate-y-1/2 font-mono text-[9px] tracking-[0.08em] whitespace-nowrap text-white uppercase">{{ $node['label'] }}</span>
                </span>
            @endforeach
        </div>
    </div>
</section>
