<x-layouts.app title="Who We Are" description="Rural2Rural (R2R) has spent over 10 years taking career guidance, skills training, entrepreneurship support and teacher development to rural communities across South Africa.">
    <x-page-header title="Who We Are" eyebrow="About<br>// Rural2Rural">
        Over 10 years on the road, taking career guidance, skills training, entrepreneurship support and teacher development to the rural communities that need them most.
    </x-page-header>

    @include('sections.about-statement')

    {{-- ─────────────── What drives us ─────────────── --}}
    <section class="relative border-t border-white/10 bg-night" aria-labelledby="drives-title">
        <x-rail />
        <div data-reveal class="{{ $gutter }} py-24 lg:py-28">
            <div class="grid gap-8 lg:grid-cols-[1fr_2.4fr]">
                <x-eyebrow first="What" class="fade-up">drives us</x-eyebrow>
                <h2 id="drives-title" class="fade-up max-w-2xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em] delay-100">Our mission, in four commitments.</h2>
            </div>
            <ol class="mt-14 grid gap-px bg-white/10 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (config('rural2rural.mission') as $commitment)
                    <li class="fade-up flex min-h-56 flex-col gap-8 bg-night p-6" style="transition-delay: {{ 150 + $loop->index * 100 }}ms">
                        <span class="font-mono text-[11px] text-green">{{ sprintf('%02d', $loop->iteration) }} //</span>
                        <p class="mt-auto text-[15px] leading-relaxed text-white/80">{{ $commitment }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    @include('sections.stripe-band')
    @include('sections.mission')
    @include('sections.how-we-work')
    @include('sections.work-with-us')
</x-layouts.app>
