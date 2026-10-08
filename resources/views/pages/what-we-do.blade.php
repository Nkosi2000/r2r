<x-layouts.app title="What We Do" description="Rural2Rural's four programme pillars — careers & jobs, skills training, entrepreneurship and teacher development — delivered through roadshows across rural South Africa.">
    <x-page-header title="What We Do" eyebrow="Programmes<br>// Four pillars">
        Four programme pillars and {{ count($programmes) }} programmes, delivered where people live: in rural schools, towns and municipalities.
    </x-page-header>

    {{-- ─────────────── We are Rural 2 Rural ─────────────── --}}
    <section class="relative border-t border-white/10 bg-night" aria-labelledby="we-are-title">
        <x-rail />
        <div data-reveal class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr] lg:py-28">
            <x-eyebrow first="We are" class="fade-up">Rural 2 Rural</x-eyebrow>
            <div class="max-w-3xl">
                <h2 id="we-are-title" class="fade-up text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em] delay-100">We are Rural 2 Rural</h2>
                <div class="fade-up mt-10 grid gap-6 text-[15px] leading-relaxed text-white/75 delay-200 sm:grid-cols-2 sm:gap-10">
                    <p>The Rural2Rural initiative presents an advantage to offer specific developmental solutions in accordance with different rural needs at different areas. Each group is developed &amp; capacitated in accordance to their area of need or a combination therein.</p>
                    <p>The initiative was designed to contribute to the National Development Plan 2030 vision of eradicating poverty &amp; improving the quality of the South African education system through various forms of interventions.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─────────────── Integrated implementation model: the four opportunity hubs ─────────────── --}}
    @php
        $hubs = [
            'R2R Careers Opportunities Hub' => ['Career Development programme and RoadShow', 'R2R Tutor Programme (Maths, Science and Accounting Extra Classes)', 'Teachers Capacitation Programme', 'Rural Teachers Summit'],
            'R2R Entrepreneurship Opportunities Hub' => ['R2R Entrepreneurship Opportunities Roadshow', 'R2R Entrepreneurship trainings and workshops', 'R2R Business Idea Pitch Competition', 'Rural SMME Coaching/Mentoring Programme'],
            'R2R Skills Training and Job Opportunities Hub' => ['R2R Skills and Job Opportunities Roadshow', 'Soft Skills training programme', 'Employability/Work readiness skills programme', 'Job Readiness Programme', 'R2R Skills and Job Application Centre'],
            'R2R Opportunities Magazine' => ['Distributed Across SA rural communities and Municipalities'],
        ];
    @endphp
    <section data-header="light" class="bg-paper text-navy" aria-labelledby="model-title">
        <div data-reveal class="{{ $gutter }} py-24 lg:py-28">
            <div class="grid gap-8 lg:grid-cols-[1fr_2.4fr]">
                <p class="tag fade-up text-blue">Integrated<br>// implementation model</p>
                <div>
                    <h2 id="model-title" class="fade-up max-w-3xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] tracking-[-0.025em] delay-100">To ensure efficiency &amp; sustainability of this programme, an integrated implementation model is critical.</h2>
                    <p class="fade-up mt-6 max-w-2xl text-[15px] leading-relaxed text-navy/75 delay-200">Within the past 10 years, our programmes have integrated skills development consisting of:</p>
                </div>
            </div>

            <ol class="mt-14 grid gap-px bg-navy/10 sm:grid-cols-2 lg:ml-[calc((100%-2rem)/3.4+2rem)] lg:grid-cols-2 xl:grid-cols-4">
                @foreach ($hubs as $hub => $items)
                    <li class="fade-up flex flex-col gap-6 bg-paper p-6" style="transition-delay: {{ 150 + $loop->index * 100 }}ms">
                        <span class="font-mono text-[11px] text-green">{{ sprintf('%02d', $loop->iteration) }} //</span>
                        <h3 class="text-lg leading-snug tracking-[-0.01em]">{{ $hub }}</h3>
                        <ul class="grid gap-2.5 text-[14px] leading-snug text-navy/75">
                            @foreach ($items as $item)
                                <li class="flex gap-2.5"><span class="mt-[0.45em] size-1.5 shrink-0 bg-green" aria-hidden="true"></span>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ol>

            <p class="fade-up mt-14 max-w-3xl text-[15px] leading-relaxed text-navy/75 lg:ml-[calc((100%-2rem)/3.4+2rem)]">These interventions may be implemented individually or in combinations of two, three, four or even five, according to the identified requirements in a specific area. Government departments, SETAs, universities, colleges, private sector companies and high schools will be invited to participate in the programme according to the requirements in a specific rural area.</p>
        </div>
    </section>

    @include('sections.pillars')
    @include('sections.programme-list')
    @include('sections.how-we-work')
    @include('sections.work-with-us')
</x-layouts.app>
