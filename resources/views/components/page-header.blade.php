@props([
    'eyebrow',
    'title',
])

{{-- Inner-page banner: breadcrumb, two-line tag, headline and intro (slot). --}}
<section id="top" tabindex="-1" data-hero data-reveal class="relative isolate overflow-hidden bg-night">
    <x-rail />
    <div data-hero-glow class="pointer-events-none absolute inset-0 -z-10 transition-[translate] duration-[1600ms] ease-out-expo" aria-hidden="true">
        <div class="absolute -top-1/3 left-1/3 h-[90%] w-[60%] rounded-full bg-sky/35 blur-[120px]"></div>
        <div class="absolute top-1/4 left-[60%] h-[70%] w-[40%] rounded-full bg-green/30 blur-[120px]"></div>
    </div>
    <div class="scanlines pointer-events-none absolute inset-0 -z-10" aria-hidden="true"></div>
    <div class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 h-1/2 bg-gradient-to-b from-transparent to-night" aria-hidden="true"></div>

    <div class="px-4 pt-32 pb-20 sm:px-8 lg:pt-40 lg:pr-12 lg:pb-28 lg:pl-[136px]">
        <nav aria-label="Breadcrumb" class="fade-up font-mono text-[10px] tracking-[0.1em] text-white/50 uppercase">
            <a href="{{ route('home') }}" class="transition-colors hover:text-green">Home</a>
            <span class="mx-2 text-green" aria-hidden="true">//</span>
            <span aria-current="page" class="text-white/80">{{ $title }}</span>
        </nav>

        <div class="mt-10 grid gap-8 lg:grid-cols-[1fr_2.4fr]">
            <p class="tag fade-up delay-100">{!! $eyebrow !!}</p>
            <div>
                <h1 class="text-[clamp(2.4rem,5.4vw,5rem)] leading-[1] font-light tracking-[-0.035em]">
                    <span class="reveal-line"><span>{{ $title }}</span></span>
                </h1>
                @if ($slot->isNotEmpty())
                    <div class="fade-up mt-8 max-w-2xl text-[16px] leading-relaxed text-white/70 delay-300">{{ $slot }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
