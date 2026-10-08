<x-layouts.app title="Who We Are" description="Rural2Rural (R2R) has spent over 10 years taking career guidance, skills training, entrepreneurship support and teacher development to rural communities across South Africa.">
    <x-page-header title="Who We Are" eyebrow="About<br>// Rural2Rural">
        Over 10 years on the road, taking career guidance, skills training, entrepreneurship support and teacher development to the rural communities that need them most.
    </x-page-header>

    @include('sections.about-statement')

    {{-- ─────────────── Our story ─────────────── --}}
    <section class="relative border-t border-white/10 bg-night" aria-labelledby="story-title">
        <x-rail />
        <div data-reveal class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr] lg:py-28">
            <x-eyebrow first="Our" class="fade-up">story</x-eyebrow>
            <div class="max-w-3xl">
                <h2 id="story-title" class="sr-only">Our story</h2>
                <p class="fade-up text-[clamp(1.15rem,1.8vw,1.45rem)] leading-[1.45] font-light text-white delay-100">
                    Rural2Rural Skills, Jobs, Careers &amp; Entrepreneurship Initiative is a programme that travels across rural South African communities aimed at educating, training, exposing and advising small businesses, youth, women &amp; people living with disabilities to engage in further education and career opportunities, skills development, entrepreneurship, training and employment opportunities.
                </p>
                <p class="fade-up mt-10 border-l-2 border-green pl-5 text-[clamp(1.05rem,1.5vw,1.25rem)] leading-[1.5] text-white delay-200">
                    Our aim is to be South Africa’s leading &amp; largest skills, jobs, careers and entrepreneurship initiative that enables individuals from rural communities to explore real job opportunities, tertiary and TVET course options, learnerships, bursaries, business opportunities &amp; plan new career pathways.
                </p>
                <div class="fade-up mt-10 grid gap-6 text-[15px] leading-relaxed text-white/75 delay-300 sm:grid-cols-2 sm:gap-10">
                    <p>With over ten years experience in career development programmes, R2R was established to promote &amp; expose real opportunities to youth, women &amp; people living with disabilities as well as to establish sustainable partnerships between all rural development catalysts.</p>
                    <p>Through its knowledge management and research department, the R2R initiative is able to provide its partners with in-depth knowledge, platforms &amp; networks about the developments of rural communities as well as understanding the challenges and realities facing youth, small businesses &amp; people living with disabilities.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─────────────── R2R solutions approach ─────────────── --}}
    <section data-header="light" class="bg-paper text-navy" aria-labelledby="approach-title">
        <div data-reveal class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr] lg:py-28">
            <p class="tag fade-up text-blue">R2R solutions<br>// approach</p>
            <div>
                <h2 id="approach-title" class="fade-up max-w-2xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] tracking-[-0.025em] delay-100">R2R Solutions Approach</h2>
                <div class="fade-up mt-10 grid max-w-4xl gap-6 text-[15px] leading-relaxed text-navy/75 delay-200 lg:grid-cols-2 lg:gap-10">
                    <p>Rural2Rural Skills, Jobs, Careers and Entrepreneurship Initiative was born out of research and engagement with some rural communities and was formulated to help overcome some of the many challenges rural areas are faced with. The programme is a broad combination of soft skills, career guidance, entrepreneurial, jobs &amp; skills opportunities presented for rural communities focusing on youth, women &amp; people living with disabilities.</p>
                    <p>The main objective of the initiative is to empower rural-based individuals to navigate their intended career paths, be exposed to entrepreneurial opportunities &amp; business support, access skills and job opportunities as well as manage themselves through the ever changing day to day world of work. At the centre of these development programmes are the entrepreneurial skills to assist the youth to convert their technical skills &amp; qualifications into products and services, start, manage and grow their businesses.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─────────────── What drives us ─────────────── --}}
    <section class="relative border-t border-white/10 bg-night" aria-labelledby="drives-title">
        <x-rail />
        <div data-reveal class="{{ $gutter }} py-24 lg:py-28">
            <div class="grid gap-8 lg:grid-cols-[1fr_2.4fr]">
                <x-eyebrow first="What" class="fade-up">drives us</x-eyebrow>
                <h2 id="drives-title" class="fade-up max-w-2xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em] delay-100">Our mission and commitments.</h2>
            </div>
            <ol class="mt-14 grid gap-px bg-white/10 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($mission as $commitment)
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
