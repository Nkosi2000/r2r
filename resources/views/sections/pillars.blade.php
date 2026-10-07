{{-- ─────────────── 03 · Programme pillars ─────────────── --}}
<section id="programmes" data-reveal class="relative border-t border-white/10 bg-night">
    <x-rail />
    <div data-pillars class="grid sm:grid-cols-2 lg:ml-[88px] lg:grid-cols-4">
        @foreach ($pillars as $pillar)
            <article data-pillar tabindex="0" class="group relative flex min-h-[460px] flex-col border-white/10 p-6 outline-none max-lg:border-b sm:odd:border-r lg:border-r lg:last:border-r-0">
                <div class="glass-card pointer-events-none absolute inset-0 -z-0 opacity-0 transition-opacity duration-700 group-[.is-active]:opacity-100" aria-hidden="true"></div>
                <span class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-lime transition-transform duration-700 group-[.is-active]:scale-x-100" aria-hidden="true"></span>

                <div class="relative flex justify-between font-mono text-[10px] tracking-[0.1em] uppercase">
                    <span class="text-white/55 group-[.is-active]:text-white/80">{{ $pillar['step'] }}</span>
                    <span class="text-green transition-colors group-[.is-active]:text-white">{{ $pillar['verb'] }}</span>
                </div>

                <div class="relative flex flex-1 items-center justify-center py-8">
                    <svg data-rosette="{{ $pillar['figure'] }}" class="rosette size-40 text-white/75 transition-[scale,color] duration-[2000ms] ease-out-expo group-[.is-active]:scale-110 group-[.is-active]:text-white" aria-hidden="true"></svg>
                </div>

                <div class="relative">
                    <h3 class="text-lg tracking-[-0.01em]">{{ $pillar['title'] }}</h3>
                    <p class="mt-2 text-[13px] leading-snug text-white/55 group-[.is-active]:text-white/85">{{ $pillar['body'] }}</p>
                </div>
            </article>
        @endforeach
    </div>
</section>
