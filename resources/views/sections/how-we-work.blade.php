{{-- ─────────────── 07 · How we work ─────────────── --}}
<section id="approach" class="relative bg-night" aria-labelledby="approach-title">
    <div data-reveal class="grid gap-2 py-6" aria-hidden="true">
        <span class="stripe h-1 bg-green"></span>
        <span class="stripe h-2 bg-sky delay-150"></span>
        <span class="stripe h-3 bg-blue delay-300"></span>
    </div>

    <div class="relative border-t border-white/10">
        <x-rail />
        <div class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr]">
            <x-eyebrow first="How we">work</x-eyebrow>
            <h2 id="approach-title" class="max-w-2xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em]">Many communities. One coordinated movement.</h2>
        </div>
    </div>

    {{-- Step 1 --}}
    <div class="relative border-t border-white/10">
        <x-rail />
        <div data-reveal class="{{ $gutter }} grid items-center gap-10 py-16 lg:grid-cols-[1fr_1.5fr]">
            <div class="fade-up max-w-xs">
                <h3 class="text-lg">We go to the community.</h3>
                <p class="tag mt-3">Roadshows. Real exposure<br>// where people live.</p>
                <p class="mt-5 text-[13px] leading-relaxed text-white/55">Career, skills and entrepreneurship roadshows travel across rural South Africa, bringing guidance and opportunity to schools and municipalities.</p>
            </div>
            <div class="glass-card fade-up aspect-[16/9] delay-150">
                {{-- The R2R roadshow van drives village to village; each stop lights up as it arrives --}}
                <div class="glass-inner overflow-hidden p-5">
                    <svg viewBox="0 0 480 270" class="absolute inset-0 size-full" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <defs>
                            <g id="roadshow-van" stroke="white">
                                <path d="M0 -12 V-34 Q0 -38 4 -38 H46 L60 -24 H64 V-12 Z" fill="#161c4f" />
                                <path d="M48 -35 L57 -26 H48 Z" stroke-opacity="0.7" />
                                <path d="M4 -17 H44" stroke="#7dbf45" stroke-width="2" />
                                <text x="8" y="-24" fill="white" stroke="none" font-family="ui-monospace, monospace" font-size="9" letter-spacing="1">R2R</text>
                                <path d="M22 -38 V-43 M15 -50 H29 L25 -43 H19 Z" fill="#161c4f" />
                                <path d="M32 -51 Q35 -47 32 -43 M36 -53 Q40 -47 36 -41" stroke="#a6d77a" class="animate-blink" />
                                <circle cx="14" cy="-6" r="6" fill="#0c1035" />
                                <circle cx="50" cy="-6" r="6" fill="#0c1035" />
                            </g>
                        </defs>

                        <path d="M0 160 C80 132 150 128 230 144 S380 120 480 138" stroke="white" stroke-opacity="0.15" />
                        <path d="M0 176 C60 150 120 146 180 162 S300 140 360 156 S440 150 480 160" stroke="white" stroke-opacity="0.3" />
                        <path d="M0 200 H480 M0 232 H480" stroke="white" stroke-opacity="0.6" />
                        <path d="M0 216 H480" stroke="#a6d77a" stroke-width="1.5" stroke-dasharray="8 6" class="road-dash" />

                        @foreach ([70 => 0.183, 175 => 0.364, 280 => 0.545, 385 => 0.726] as $stopX => $arrival)
                            <g transform="translate({{ $stopX }} 198) scale(2.4)" stroke="white" stroke-opacity="0.75">
                                <path d="M-5 0 V-6 H5 V0 M-1 0 V-3 H1 V0" vector-effect="non-scaling-stroke" />
                                <path d="M-7 -6 L0 -13 L7 -6 Z" fill="#7dbf45" fill-opacity="0.3" vector-effect="non-scaling-stroke" />
                            </g>
                            <path d="M{{ $stopX + 20 }} 198 V170" stroke="white" stroke-opacity="0.6" />
                            <circle cx="{{ $stopX + 20 }}" cy="165" r="5" fill="#a6d77a" fill-opacity="0.15" stroke="white">
                                <animate attributeName="fill-opacity" values="0.15;0.15;1;1;0.15;0.15" keyTimes="0;{{ round($arrival - 0.01, 3) }};{{ round($arrival, 3) }};{{ round($arrival + 0.18, 3) }};{{ round($arrival + 0.24, 3) }};1" dur="14s" repeatCount="indefinite" />
                            </circle>
                        @endforeach

                        <use href="#roadshow-van" class="motion-reduce:hidden">
                            <animateTransform attributeName="transform" type="translate" values="-80 224;500 224" dur="14s" repeatCount="indefinite" />
                        </use>
                        <use href="#roadshow-van" transform="translate(206 224)" class="hidden motion-reduce:inline" />
                    </svg>

                    <div class="relative flex items-start justify-between">
                        <p class="text-lg">Roadshow Route</p>
                        <span class="flex items-center gap-1.5 bg-white/15 px-2 py-1 font-mono text-[8px] tracking-[0.1em] uppercase ring-1 ring-white/25"><i class="animate-blink size-1 bg-lime"></i>Village to village</span>
                    </div>
                    @foreach ($pillars->take(4)->values()->zip([14.6, 36.5, 58.3, 80.2]) as [$pillar, $left])
                        <span class="absolute top-[90%] -translate-x-1/2 -translate-y-1/2 font-mono text-[8px] tracking-[0.08em] uppercase sm:text-[9px]" style="left: {{ $left }}%">{{ $pillar->verb }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Step 2 --}}
    <div class="relative border-t border-white/10">
        <x-rail />
        <div data-reveal class="{{ $gutter }} grid items-center gap-10 py-16 lg:grid-cols-[1fr_1.5fr]">
            <div class="fade-up max-w-xs">
                <h3 class="text-lg">Everyone is included.</h3>
                <p class="tag mt-3">Youth. Women. SMMEs.<br>// No one left behind.</p>
                <p class="mt-5 text-[13px] leading-relaxed text-white/55">Programmes are designed for learners, youth, women, small businesses and people living with disabilities in rural areas.</p>
            </div>
            <div class="glass-card fade-up aspect-[16/9] delay-150">
                {{-- A community gathering under the tree: everyone the programmes are built for --}}
                <div class="glass-inner overflow-hidden p-5">
                    <svg viewBox="0 0 480 270" class="absolute inset-0 size-full" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M262 228 V160 M262 176 L232 128 M262 166 L296 124 M262 160 V118" stroke-opacity="0.7" />
                        <path d="M150 128 Q200 92 262 98 Q330 90 380 126 Q262 140 150 128 Z" fill="#7dbf45" fill-opacity="0.3" stroke-opacity="0.7" />
                        <path d="M20 228 H460" stroke-opacity="0.6" />
                        @foreach ([40, 120, 190, 345, 440] as $tuftX)
                            <path d="M{{ $tuftX - 4 }} 228 L{{ $tuftX }} 220 L{{ $tuftX + 4 }} 228" stroke-opacity="0.4" />
                        @endforeach

                        {{-- Learner with a school bag --}}
                        <g transform="translate(70 228)">
                            <circle cy="-52" r="7" />
                            <path d="M0 -44 V-20 M0 -20 L-6 0 M0 -20 L6 0 M0 -38 L-9 -24 M0 -38 L9 -24" />
                            <rect x="-11" y="-42" width="7" height="15" rx="2" fill="#7dbf45" fill-opacity="0.35" />
                        </g>
                        {{-- Young person waving --}}
                        <g transform="translate(145 228)">
                            <circle cy="-52" r="7" />
                            <path d="M-7 -55 Q0 -64 7 -55 Z M7 -55 H13" fill="#7dbf45" fill-opacity="0.35" />
                            <path d="M0 -44 V-20 M0 -20 L-6 0 M0 -20 L6 0 M0 -38 L-9 -24 M0 -38 L10 -54" />
                        </g>
                        {{-- Woman in a doek --}}
                        <g transform="translate(220 228)">
                            <circle cy="-52" r="7" />
                            <path d="M-8 -53 Q-6 -66 0 -62 Q6 -66 8 -53" fill="#7dbf45" fill-opacity="0.35" />
                            <path d="M-2 -44 L-12 -12 H12 L2 -44 Z" fill="#7dbf45" fill-opacity="0.25" />
                            <path d="M-4 -12 V0 M4 -12 V0 M-2 -40 L-11 -26 M2 -40 L11 -26" />
                        </g>
                        {{-- Small business owner with a briefcase --}}
                        <g transform="translate(310 228)">
                            <circle cy="-52" r="7" />
                            <path d="M0 -44 V-20 M0 -20 L-6 0 M0 -20 L6 0 M0 -38 L-9 -24 M0 -38 L9 -24" />
                            <rect x="6" y="-24" width="14" height="10" rx="1.5" fill="#7dbf45" fill-opacity="0.35" />
                            <path d="M10 -24 V-27 H16 V-24" />
                        </g>
                        {{-- Wheelchair user --}}
                        <g transform="translate(392 228)">
                            <circle cy="-13" r="13" />
                            <circle cx="20" cy="-3" r="3" />
                            <path d="M-8 -46 V-22 H14 L20 -6 M-8 -46 H-14" stroke-opacity="0.7" />
                            <circle cy="-58" r="7" />
                            <path d="M0 -50 L-2 -26 H14 L18 -8 M0 -44 L7 -32 L4 -24" />
                        </g>

                        @foreach ([[70, -72], [145, -72], [220, -76], [310, -72], [392, -78]] as [$personX, $dotY])
                            <circle cx="{{ $personX }}" cy="{{ 228 + $dotY }}" r="2.5" fill="#a6d77a" stroke="none" class="animate-blink" style="animation-delay: {{ $loop->index * 0.28 }}s" />
                        @endforeach
                    </svg>

                    <div class="relative flex items-start justify-between">
                        <p class="text-lg">Who We Serve</p>
                        <span class="flex items-center gap-1.5 bg-white/15 px-2 py-1 font-mono text-[8px] tracking-[0.1em] uppercase ring-1 ring-white/25"><i class="animate-blink size-1 bg-lime"></i>No one left behind</span>
                    </div>
                    @foreach (['Learners' => 14.6, 'Youth' => 30.2, 'Teachers' => 45.8, 'SMMEs' => 64.6, 'Disabilities' => 82.5] as $label => $left)
                        <span class="absolute top-[90%] -translate-x-1/2 -translate-y-1/2 font-mono text-[8px] tracking-[0.08em] uppercase sm:text-[9px]" style="left: {{ $left }}%">{{ $label }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Step 3 --}}
    <div class="relative border-t border-white/10">
        <x-rail />
        <div data-reveal class="{{ $gutter }} grid items-center gap-10 py-16 lg:grid-cols-[1fr_1.5fr]">
            <div class="fade-up max-w-xs">
                <h3 class="text-lg">Opportunity, ready to take.</h3>
                <p class="tag mt-3">Skills in hand.<br>// Doors open.</p>
                <p class="mt-5 text-[13px] leading-relaxed text-white/55">Learners leave with career guidance, job-readiness skills and the confidence to pursue further education, employment or their own business.</p>
            </div>
            <div class="glass-card fade-up aspect-[16/9] delay-150">
                {{-- A learner with three doors swinging open: further study, a job or their own business --}}
                <div class="glass-inner overflow-hidden p-5">
                    <svg viewBox="0 0 480 270" class="absolute inset-0 size-full" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 222 H460" stroke-opacity="0.6" />

                        {{-- Learner --}}
                        <g transform="translate(70 222)">
                            <circle cy="-52" r="7" />
                            <path d="M0 -44 V-20 M0 -20 L-6 0 M0 -20 L6 0 M0 -38 L-9 -24 M0 -38 L12 -34" />
                            <rect x="-11" y="-42" width="7" height="15" rx="2" fill="#7dbf45" fill-opacity="0.35" />
                        </g>

                        @foreach ([170, 270, 370] as $doorX)
                            <path d="M84 188 Q{{ 90 + $loop->iteration * 40 }} {{ 140 - $loop->iteration * 45 }} {{ $doorX + 24 }} 160" stroke="#a6d77a" stroke-dasharray="8 6" class="road-dash" />
                            <path d="M{{ $doorX }} 222 H{{ $doorX + 48 }} L{{ $doorX + 66 }} 252 H{{ $doorX - 18 }} Z" fill="#a6d77a" fill-opacity="0.15" stroke="none" />
                            <rect x="{{ $doorX }}" y="98" width="48" height="124" fill="#a6d77a" fill-opacity="0.4" stroke="none">
                                <animate attributeName="fill-opacity" values="0.25;0.5;0.25" dur="3s" begin="{{ $loop->index * 0.6 }}s" repeatCount="indefinite" />
                            </rect>
                            <g class="door-leaf" style="transition-delay: {{ 300 + $loop->index * 250 }}ms">
                                <rect x="{{ $doorX }}" y="98" width="48" height="124" fill="#161c4f" />
                                <circle cx="{{ $doorX + 40 }}" cy="162" r="2.5" fill="white" stroke="none" />
                            </g>
                            <path d="M{{ $doorX }} 222 V98 H{{ $doorX + 48 }} V222" stroke-width="2.5" />
                        @endforeach

                        {{-- Door signs: graduation cap, briefcase, market stall --}}
                        <path d="M182 80 L194 74 L206 80 L194 86 Z M206 80 V88" fill="#7dbf45" fill-opacity="0.35" />
                        <rect x="285" y="74" width="18" height="12" rx="1.5" fill="#7dbf45" fill-opacity="0.35" />
                        <path d="M291 74 V71 H297 V74" />
                        <path d="M382 82 L385 74 H403 L406 82 Z M384 82 V90 H404 V82" fill="#7dbf45" fill-opacity="0.35" />
                    </svg>

                    <div class="relative flex items-start justify-between">
                        <p class="text-lg">Opportunity Ready</p>
                        <span class="flex items-center gap-1.5 bg-white/15 px-2 py-1 font-mono text-[8px] tracking-[0.1em] uppercase ring-1 ring-white/25"><i class="animate-blink size-1 bg-lime"></i>Doors open</span>
                    </div>
                    @foreach (['Learner' => 14.6, 'Further study' => 40.4, 'Employment' => 61.3, 'Own business' => 82.1] as $label => $left)
                        <span class="absolute top-[90%] -translate-x-1/2 -translate-y-1/2 font-mono text-[8px] tracking-[0.08em] whitespace-nowrap uppercase sm:text-[9px] {{ $loop->first ? '' : 'text-lime' }}" style="left: {{ $left }}%">{{ $label }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
