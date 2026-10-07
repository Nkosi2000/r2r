@php
    $media = config('rural2rural.media');
@endphp

<x-layouts.app title="Media" description="Photos, videos and publications from Rural2Rural roadshows, expos and programmes across rural South Africa.">
    <x-page-header title="Media" eyebrow="Gallery<br>// From the road">
        Photos, video and publications from our roadshows, expos and programmes across rural South Africa.
    </x-page-header>

    {{-- ─────────────── Photo gallery ─────────────── --}}
    <section data-header="light" class="bg-paper text-navy" aria-labelledby="gallery-title">
        <div data-reveal class="px-4 py-24 sm:px-8 lg:pr-12 lg:pl-[136px] lg:py-28">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <h2 id="gallery-title" class="fade-up text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] tracking-[-0.025em]">Photo gallery</h2>
                <p class="fade-up font-mono text-[10px] tracking-[0.1em] text-navy/50 uppercase delay-100">( {{ sprintf('%02d', count($media['photos'])) }} photos )</p>
            </div>

            <ul class="mt-12 columns-1 gap-4 sm:columns-2 lg:columns-3">
                @foreach ($media['photos'] as $photo)
                    <li class="group fade-up mb-4 break-inside-avoid" style="transition-delay: {{ min($loop->index, 5) * 80 }}ms">
                        <figure>
                            <div class="overflow-hidden">
                                <img src="{{ asset('images/'.$photo['image']) }}" alt="{{ $photo['caption'] }}" loading="lazy" class="w-full object-cover grayscale-[60%] transition duration-700 ease-out-expo group-hover:scale-105 group-hover:grayscale-0">
                            </div>
                            <figcaption class="mt-2 flex items-center gap-2 font-mono text-[10px] tracking-[0.08em] text-navy/70 uppercase"><i class="size-1.5 bg-green"></i>{{ $photo['caption'] }}</figcaption>
                        </figure>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ─────────────── Video ─────────────── --}}
    @if (count($media['videos']))
        <section class="relative border-t border-white/10 bg-night" aria-labelledby="video-title">
            <x-rail />
            <div data-reveal class="{{ $gutter }} py-24 lg:py-28">
                <div class="grid gap-8 lg:grid-cols-[1fr_2.4fr]">
                    <x-eyebrow first="On" class="fade-up">camera</x-eyebrow>
                    <h2 id="video-title" class="fade-up text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em] delay-100">Watch R2R on the road.</h2>
                </div>
                <div class="mt-12 grid gap-8 lg:grid-cols-2">
                    @foreach ($media['videos'] as $video)
                        <figure class="glass-card fade-up delay-150">
                            <div class="glass-inner">
                                <video controls preload="metadata" playsinline class="aspect-video w-full bg-night">
                                    <source src="{{ asset('images/'.$video['file']) }}" type="video/mp4">
                                </video>
                            </div>
                            <figcaption class="relative mt-3 flex items-center justify-between font-mono text-[10px] tracking-[0.08em] uppercase">
                                <span>{{ $video['title'] }}</span>
                                <span class="text-lime">{{ $video['place'] }}</span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ─────────────── Publications ─────────────── --}}
    @if (count($media['publications']))
        <section class="relative border-t border-white/10 bg-night" aria-labelledby="publications-title">
            <x-rail />
            <div data-reveal class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr] lg:py-28">
                <x-eyebrow first="In" class="fade-up">print</x-eyebrow>
                <div>
                    <h2 id="publications-title" class="fade-up text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em] delay-100">Publications</h2>
                    <ul class="mt-10 grid gap-6 md:grid-cols-2">
                        @foreach ($media['publications'] as $publication)
                            <li class="fade-up flex flex-col gap-4 border border-white/10 p-4 delay-150 sm:flex-row sm:items-center">
                                <img src="{{ asset('images/'.$publication['image']) }}" alt="Cover of {{ $publication['title'] }}" loading="lazy" class="aspect-[4/3] w-full object-cover sm:w-40">
                                <div>
                                    <p class="font-mono text-[10px] tracking-[0.1em] text-green uppercase">Magazine</p>
                                    <h3 class="mt-2 text-lg leading-snug">{{ $publication['title'] }}</h3>
                                    <p class="mt-1 text-[13px] text-white/55">{{ $publication['edition'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @endif

    {{-- ─────────────── Follow ─────────────── --}}
    <section class="relative border-t border-white/10 bg-night" aria-labelledby="follow-title">
        <x-rail />
        <div data-reveal class="{{ $gutter }} flex flex-wrap items-center justify-between gap-8 py-20">
            <h2 id="follow-title" class="fade-up max-w-md text-[clamp(1.5rem,2.4vw,2rem)] leading-[1.15] font-light tracking-[-0.02em]">See the latest from the road on our social channels.</h2>
            <ul class="fade-up flex flex-wrap gap-3 delay-100">
                @foreach (config('rural2rural.social') as $label => $href)
                    <li>
                        <a href="{{ $href }}" target="_blank" rel="noopener" class="inline-flex h-10 items-center gap-2 border border-white/30 px-4 font-mono text-[11px] tracking-[0.08em] uppercase transition-colors hover:border-green hover:text-green">
                            <x-social-icon :platform="$label" class="size-4" />{{ $label }}<span class="sr-only"> (opens in a new tab)</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
</x-layouts.app>
