{{-- ─────────────── 04 · Programme list with hover card ─────────────── --}}
<section class="relative border-t border-white/10 bg-night" aria-labelledby="programme-list-title">
    <x-rail />
    <div class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr] lg:py-28">
        <x-eyebrow first="Your path">to opportunity</x-eyebrow>
        <h2 id="programme-list-title" class="max-w-2xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em]">Meet the programmes built for every rural learner, teacher and entrepreneur.</h2>
        @isset($moreLink)
            <x-button :href="$moreLink" variant="outline" class="lg:col-start-2 lg:justify-self-start">What we do</x-button>
        @endisset
    </div>

    <div data-programme-list class="relative lg:ml-[88px]">
        <ol>
            @foreach ($programmes as $programme)
                <li data-row data-title="{{ $programme['title'] }}" data-pillar="{{ $programme['pillar'] }}" data-number="{{ sprintf('%02d', $loop->iteration) }}" class="group grid grid-cols-[3rem_1fr] items-center gap-x-4 border-t border-white/10 px-4 py-6 transition-colors hover:bg-white/[0.04] sm:px-8 lg:grid-cols-[6rem_1fr_auto] lg:px-12">
                    <span class="font-mono text-[11px] text-green">{{ sprintf('%02d', $loop->iteration) }}</span>
                    <span class="text-[clamp(1.15rem,2vw,1.6rem)] tracking-[-0.02em] transition-transform duration-500 ease-out-expo group-hover:translate-x-2">{{ $programme['title'] }}</span>
                    <span class="col-start-2 mt-1 font-mono text-[10px] tracking-[0.08em] text-white/50 uppercase transition-colors group-hover:text-green lg:col-start-auto lg:mt-0 lg:text-[11px]">{{ $programme['pillar'] }} <span aria-hidden="true">↳</span></span>
                </li>
            @endforeach
        </ol>

        <div data-hover-card class="glass-card pointer-events-none absolute top-0 left-0 z-10 hidden w-[260px] scale-90 opacity-0 transition-[opacity,scale] duration-300 lg:block" aria-hidden="true">
            <div class="glass-inner p-4">
                <span class="inline-flex items-center gap-1.5 bg-white/20 px-1.5 py-1 font-mono text-[8px] tracking-[0.1em] uppercase"><i class="size-1 bg-white"></i>Programme</span>
                <p data-card-title class="mt-3 text-[15px] leading-tight"></p>
                <p data-card-pillar class="mt-1 font-mono text-[9px] tracking-[0.08em] text-white/70 uppercase"></p>
                <canvas data-dot-matrix data-text="01" data-dot="4" class="mt-3 h-11 w-24"></canvas>
                <div class="mt-3 flex items-center gap-3 bg-white/10 p-2 ring-1 ring-white/20">
                    <span class="h-5 flex-1 bg-[repeating-linear-gradient(90deg,rgb(255_255_255/0.7)_0_1px,transparent_1px_4px)]"></span>
                    <span class="font-mono text-[7px] leading-tight tracking-[0.1em] uppercase">R2R<br>Roadshow</span>
                </div>
            </div>
        </div>
    </div>
    <div class="border-t border-white/10"></div>
</section>
