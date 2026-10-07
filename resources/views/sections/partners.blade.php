{{-- ─────────────── 09 · Partners ─────────────── --}}
<section id="partners" data-header="light" class="overflow-hidden bg-paper text-navy" aria-labelledby="partners-title">
    <div data-reveal class="grid gap-8 px-4 pt-24 pb-14 sm:px-8 lg:grid-cols-[1fr_2.4fr] lg:pt-28 lg:pr-12 lg:pl-[136px]">
        <p class="tag fade-up text-blue">Our<br>// partners</p>
        <div class="grid gap-6 lg:grid-cols-[1.4fr_1fr] lg:items-end">
            <h2 id="partners-title" class="fade-up max-w-xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] tracking-[-0.025em] delay-100">Backed by partners who believe in rural talent.</h2>
            <div class="fade-up max-w-sm delay-200">
                <p class="text-[14px] leading-relaxed text-navy/70">Sector education and training authorities, foundations, youth networks, community media and creative partners help us take skills, jobs and careers to rural South Africa.</p>
                @isset($moreLink)
                    <x-button :href="$moreLink" variant="navy" class="mt-6">Meet our partners</x-button>
                @endisset
            </div>
        </div>
    </div>

    {{-- Logo strip: two copies loop seamlessly; pauses on hover --}}
    <div class="relative pb-24 [mask-image:linear-gradient(to_right,transparent,black_8%,black_92%,transparent)]">
        <ul class="animate-marquee flex w-max gap-4 motion-reduce:w-auto motion-reduce:flex-wrap motion-reduce:justify-center motion-reduce:px-4">
            @foreach ([false, true] as $isDuplicate)
                @foreach ($partners as $partner)
                    <li @if ($isDuplicate) aria-hidden="true" class="motion-reduce:hidden" @endif>
                        <figure class="group flex h-44 w-64 flex-col bg-white ring-1 ring-navy/10 transition duration-500 ease-out-expo hover:-translate-y-1 hover:shadow-[0_24px_50px_-28px_rgba(41,49,121,0.45)] hover:ring-blue/40">
                            <div class="flex flex-1 items-center justify-center p-6">
                                <img src="{{ asset($partner['logo']) }}" alt="{{ $isDuplicate ? '' : $partner['name'].' logo' }}" loading="lazy" class="max-h-24 w-auto max-w-full object-contain">
                            </div>
                            <figcaption class="flex items-center justify-between gap-3 border-t border-navy/10 px-4 py-2.5">
                                <span class="truncate font-mono text-[9px] tracking-[0.08em] text-navy/60 uppercase">{{ $partner['description'] }}</span>
                                <span class="size-1.5 shrink-0 bg-green transition-transform duration-500 group-hover:scale-150" aria-hidden="true"></span>
                            </figcaption>
                        </figure>
                    </li>
                @endforeach
            @endforeach
        </ul>
    </div>
</section>
