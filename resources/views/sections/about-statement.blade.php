{{-- ─────────────── 02 · Who we are (scroll-lit statement) ─────────────── --}}
<section id="about" class="relative border-t border-white/10 bg-night">
    <x-rail />
    <div class="{{ $gutter }} grid gap-8 py-28 lg:grid-cols-[1fr_2.4fr] lg:py-36">
        <x-eyebrow first="Who we">are</x-eyebrow>
        <p data-scrub class="max-w-3xl text-[clamp(1.5rem,2.7vw,2.4rem)] leading-[1.18] font-light tracking-[-0.02em]">
            <span data-scrub-text>Rural2Rural travels across rural South Africa, educating, training, exposing and advising small businesses, youth, women and people living with disabilities to engage in further education, careers, skills development and entrepreneurship.</span>
        </p>
        @isset($moreLink)
            <x-button :href="$moreLink" variant="outline" class="lg:col-start-2 lg:justify-self-start">More about us</x-button>
        @endisset
    </div>
</section>
