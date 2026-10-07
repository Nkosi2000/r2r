@php
    $upcomingEvents = config('rural2rural.upcoming_events');
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

                @if (count($upcomingEvents))
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

    @include('sections.on-the-road')
    @include('sections.work-with-us')
</x-layouts.app>
