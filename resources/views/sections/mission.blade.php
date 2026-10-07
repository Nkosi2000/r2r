{{-- ─────────────── 06 · Mission (light) ─────────────── --}}
@php
    $fieldPhotos = [
        ['image' => 'learners.jpg', 'caption' => 'Career guidance session'],
        ['image' => 'volunteers.jpg', 'caption' => 'R2R roadshow team'],
        ['image' => 'leaders.jpg', 'caption' => 'Community & partners'],
        ['image' => 'village.jpg', 'caption' => 'Rural South Africa'],
    ];
@endphp
<section data-header="light" class="bg-paper text-navy" aria-labelledby="mission-title">
    <div class="grid gap-10 px-4 py-24 sm:px-8 lg:grid-cols-[1.6fr_1fr] lg:pr-12 lg:pl-[136px] lg:py-32" data-reveal>
        <div>
            <img src="{{ asset('images/rural2rural.png') }}" alt="Rural2Rural Skills, Jobs, Careers &amp; Entrepreneurship Initiative" class="fade-up h-auto w-[min(100%,420px)]">
            <h2 id="mission-title" class="fade-up mt-14 max-w-3xl text-[clamp(1.9rem,3.6vw,3.2rem)] leading-[1.06] tracking-[-0.03em] delay-150">
                Tackling the national crisis of poverty and unemployment. Restoring the dignity of rural communities.
            </h2>
        </div>
        <div class="fade-up relative self-end overflow-hidden delay-300">
            <img src="{{ asset('images/r2r/learners.jpg') }}" alt="Learners attending an R2R career guidance session" class="aspect-[4/3] w-full object-cover grayscale">
            <div class="absolute inset-0 bg-blue mix-blend-multiply" aria-hidden="true"></div>
            <div class="absolute inset-x-0 bottom-0 flex gap-1 p-3" aria-hidden="true">
                <span class="h-1 flex-[3] bg-white"></span><span class="h-1 flex-1 bg-green"></span><span class="h-1 flex-1 bg-sky"></span>
            </div>
        </div>
    </div>

    <div class="grid gap-10 border-t border-navy/10 px-4 py-16 sm:px-8 lg:grid-cols-[1fr_1fr_1fr] lg:pr-12 lg:pl-[136px]">
        <p class="font-mono text-[10px] tracking-[0.1em] text-navy/50 uppercase">( Our mission )</p>
        <p class="text-[14px] leading-relaxed text-navy/80">
            Celebrating over 10 years of organising career guidance development programmes in rural communities, we promote and expose real opportunities to youth where they live — in schools, towns and municipalities.
        </p>
        <p class="text-[14px] leading-relaxed text-navy/80">
            We host capacitation workshops and programmes aimed at school teacher development, and connect small businesses, women and people living with disabilities to training, skills and employment opportunities.
        </p>
    </div>

    <div class="px-4 pb-24 sm:px-8 lg:pr-12 lg:pl-[136px]">
        <p class="mb-6 text-xl tracking-[-0.02em]">From the field</p>
        <ul class="grid grid-cols-2 gap-3 lg:grid-cols-4">
            @foreach ($fieldPhotos as $photo)
                <li class="group">
                    <div class="overflow-hidden">
                        <img src="{{ asset('images/r2r/'.$photo['image']) }}" alt="{{ $photo['caption'] }}" loading="lazy" class="aspect-[4/3] w-full object-cover grayscale transition duration-700 ease-out-expo group-hover:scale-105 group-hover:grayscale-0">
                    </div>
                    <p class="mt-2 font-mono text-[10px] tracking-[0.08em] text-navy/70 uppercase">{{ $photo['caption'] }}</p>
                </li>
            @endforeach
        </ul>
    </div>
</section>
