<x-layouts.app title="Our Partners" description="The SETAs, foundations, youth networks, community media and creative partners who help Rural2Rural take skills, jobs and careers to rural South Africa.">
    <x-page-header title="Our Partners" eyebrow="Together<br>// we go further">
        Every roadshow, workshop and summit is made possible by organisations who believe in rural talent.
    </x-page-header>

    {{-- ─────────────── Partner directory ─────────────── --}}
    <section data-header="light" class="bg-paper text-navy" aria-labelledby="partner-directory-title">
        <div data-reveal class="px-4 py-24 sm:px-8 lg:pr-12 lg:pl-[136px] lg:py-28">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <h2 id="partner-directory-title" class="fade-up max-w-xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] tracking-[-0.025em]">Backed by partners who believe in rural talent.</h2>
                <p class="fade-up font-mono text-[10px] tracking-[0.1em] text-navy/50 uppercase delay-100">( {{ sprintf('%02d', count($partners)) }} partners )</p>
            </div>

            <ul class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($partners as $partner)
                    <li class="fade-up" style="transition-delay: {{ 100 + $loop->index * 80 }}ms">
                        <figure class="group flex h-full flex-col bg-white ring-1 ring-navy/10 transition duration-500 ease-out-expo hover:-translate-y-1 hover:shadow-[0_24px_50px_-28px_rgba(41,49,121,0.45)] hover:ring-blue/40">
                            <div class="flex h-48 items-center justify-center p-8">
                                <img src="{{ $partner->logo_url }}" alt="{{ $partner['name'] }} logo" loading="lazy" class="max-h-28 w-auto max-w-full object-contain">
                            </div>
                            <figcaption class="flex flex-1 flex-col border-t border-navy/10 p-5">
                                <span class="font-mono text-[10px] tracking-[0.1em] text-blue">{{ sprintf('%02d', $loop->iteration) }} //</span>
                                <span class="mt-2 text-lg tracking-[-0.01em]">{{ $partner['name'] }}</span>
                                <span class="mt-1 text-[13px] leading-snug text-navy/60">{{ $partner['description'] }}</span>
                            </figcaption>
                        </figure>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ─────────────── Ways to partner ─────────────── --}}
    <section class="relative border-t border-white/10 bg-night" aria-labelledby="ways-title">
        <x-rail />
        <div data-reveal class="{{ $gutter }} py-24 lg:py-28">
            <div class="grid gap-8 lg:grid-cols-[1fr_2.4fr]">
                <x-eyebrow first="Ways to" class="fade-up">partner</x-eyebrow>
                <h2 id="ways-title" class="fade-up max-w-2xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em] delay-100">Bring real opportunity to a rural community.</h2>
            </div>
            <ul class="mt-14 grid gap-px bg-white/10 md:grid-cols-3">
                @foreach ([
                    ['title' => 'Host a roadshow', 'body' => 'Bring a careers, skills or entrepreneurship roadshow to schools and young people in your municipality.'],
                    ['title' => 'Sponsor a programme', 'body' => 'Fund tutoring, work-readiness training, pitch competitions or SMME coaching and mentoring.'],
                    ['title' => 'Capacitate teachers', 'body' => 'Support capacitation workshops and the Rural Teachers Summit for teachers in rural schools.'],
                ] as $way)
                    <li class="fade-up flex flex-col gap-6 bg-night p-6" style="transition-delay: {{ 150 + $loop->index * 100 }}ms">
                        <span class="font-mono text-[11px] text-green">{{ sprintf('%02d', $loop->iteration) }} //</span>
                        <h3 class="text-xl tracking-[-0.02em]">{{ $way['title'] }}</h3>
                        <p class="text-[14px] leading-relaxed text-white/60">{{ $way['body'] }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    @include('sections.work-with-us')
</x-layouts.app>
