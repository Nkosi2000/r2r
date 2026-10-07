{{-- ─────────────── 10 · Work with us (blue block) ─────────────── --}}
<section id="partner" class="bg-paper" aria-labelledby="partner-title" data-header="light">
    <div data-reveal class="grid gap-2 py-6" aria-hidden="true">
        <span class="stripe h-3 bg-blue"></span>
        <span class="stripe h-2 bg-blue delay-150"></span>
    </div>
    <div class="plus-grid bg-blue px-4 py-20 sm:px-8 lg:pr-12 lg:pl-[136px] lg:py-28">
        <div data-reveal class="fade-up grid gap-10 bg-night p-8 sm:p-12 lg:grid-cols-[1.4fr_1fr]">
            <div>
                <p class="flex items-center gap-2 font-mono text-[10px] tracking-[0.1em] text-white/70 uppercase"><i class="size-1.5 rounded-full bg-green"></i>Work with R2R</p>
                <h2 id="partner-title" class="mt-6 max-w-md text-[clamp(2rem,3.4vw,3rem)] leading-[1.05] tracking-[-0.03em]">Want to bring R2R to your community?</h2>
                <p class="mt-5 max-w-md text-[14px] leading-relaxed text-white/60">Partner with us to host a roadshow, sponsor a programme or capacitate teachers in your municipality.</p>
                <div class="mt-8 flex flex-wrap items-center gap-6">
                    <x-button :href="$mailPartner">Partner with us</x-button>
                    <a href="{{ route('contact') }}" class="font-mono text-[11px] tracking-[0.08em] text-white uppercase underline-offset-4 hover:underline">Get in touch</a>
                </div>
            </div>
            <div data-pixel-blocks="4" class="grid aspect-[2/3] w-40 grid-cols-4 grid-rows-6 lg:w-48 lg:justify-self-end" aria-hidden="true">
                @foreach (range(1, 24) as $cell)
                    <span class="opacity-0 transition-opacity duration-500 {{ $cell % 5 === 0 ? 'bg-green' : 'bg-sky' }}"></span>
                @endforeach
            </div>
        </div>
    </div>
</section>
