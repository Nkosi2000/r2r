{{-- ─────────────── 01 · Hero ─────────────── --}}
<section id="top" tabindex="-1" data-hero data-reveal class="relative isolate overflow-hidden bg-night">
    <x-rail />
    {{-- Logo-colour glow, scanlines and orbit lines --}}
    <div data-hero-glow class="pointer-events-none absolute inset-0 -z-10 transition-[translate] duration-[1600ms] ease-out-expo" aria-hidden="true">
        <div class="absolute -top-1/4 left-1/4 h-[80%] w-[80%] rounded-full bg-sky/45 blur-[120px]"></div>
        <div class="absolute top-1/4 left-[45%] h-[60%] w-[50%] rounded-full bg-green/40 blur-[120px]"></div>
        <div class="absolute top-[40%] -left-[10%] h-[60%] w-[50%] rounded-full bg-navy/70 blur-[100px]"></div>
    </div>
    <div class="scanlines pointer-events-none absolute inset-0 -z-10" aria-hidden="true"></div>
    <div class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 h-1/3 bg-gradient-to-b from-transparent to-night" aria-hidden="true"></div>
    <div class="pointer-events-none absolute top-[58%] left-[88px] -z-10 hidden h-px w-full bg-white/10 lg:block" aria-hidden="true"></div>
    <div class="pointer-events-none absolute top-[14%] left-[-6%] -z-10 hidden aspect-square w-[46%] rounded-full border border-white/10 lg:block" aria-hidden="true"></div>

    <div class="{{ $gutter }} grid min-h-svh gap-12 pt-32 pb-16 lg:grid-cols-[1.25fr_1fr] lg:pt-40">
        <div class="flex flex-col justify-between gap-12">
            <h1 class="text-[clamp(2.6rem,6vw,5.6rem)] leading-[0.98] font-light tracking-[-0.035em]">
                <span class="reveal-line"><span>Delivering Real</span></span>
                <span class="flex items-end gap-5 lg:pl-[8%]">
                    <span class="tag fade-up mb-3 hidden shrink-0 delay-300 sm:block">Skills &amp; jobs<br>// Careers</span>
                    <span class="reveal-line"><span class="delay-150">Opportunities</span></span>
                </span>
                <span class="reveal-line"><span class="delay-300">to Rural Communities</span></span>
            </h1>

            <div class="fade-up max-w-sm delay-500">
                <p class="text-[15px] leading-relaxed text-white/75">
                    Rural2Rural is a Skills, Jobs, Careers and Entrepreneurship initiative programme that travels across rural South Africa aimed at educating, training, exposing and advising (Small Businesses, Youth, Women and people living with Disabilities) in rural areas to engage in further education and career opportunities, skills development, entrepreneurship opportunities, training and employment opportunities.
                </p>
                <div class="mt-7 flex flex-wrap gap-3">
                    <x-button href="#programmes">Explore programmes</x-button>
                    <x-button href="#about" variant="outline">Who we are</x-button>
                </div>
            </div>
        </div>

        {{-- Roadshow route: a rural road winding to the next village, with the four pillars as stops along the way --}}
        @php
            $roadCentre = 'M170 460 C190 380 330 330 280 260 C230 190 231 190 250 152';
            $roadshowRoute = $pastEvents->pluck('place')->unique()->prepend('Gauteng')->implode(' → ');
        @endphp
        <div class="fade-up relative flex flex-col items-center justify-center gap-14 delay-300 lg:items-end">
            <figure class="relative mx-auto aspect-[420/460] w-[min(86vw,400px)] lg:mr-[8%]">
                @foreach (['top-0 left-0 border-t border-l', 'top-0 right-0 border-t border-r', 'bottom-0 left-0 border-b border-l', 'bottom-0 right-0 border-b border-r'] as $corner)
                    <span class="absolute size-4 border-white/40 {{ $corner }}" aria-hidden="true"></span>
                @endforeach

                <svg viewBox="0 0 420 460" class="absolute inset-0 size-full overflow-hidden" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <defs>
                        <linearGradient id="hero-ground-fade" x1="0" y1="150" x2="0" y2="460" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="white" stop-opacity="0.15" />
                            <stop offset="1" stop-color="white" />
                        </linearGradient>
                        <linearGradient id="hero-road-fill" x1="0" y1="150" x2="0" y2="460" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#3ea4d8" stop-opacity="0.05" />
                            <stop offset="1" stop-color="#3ea4d8" stop-opacity="0.22" />
                        </linearGradient>
                        <mask id="hero-ground-mask">
                            <rect y="150" width="420" height="310" fill="url(#hero-ground-fade)" />
                        </mask>
                    </defs>

                    {{-- Night sky --}}
                    @foreach ([[48, 40], [112, 78], [176, 26], [236, 64], [318, 34], [372, 82], [396, 22], [150, 104]] as [$starX, $starY])
                        <circle cx="{{ $starX }}" cy="{{ $starY }}" r="1" fill="white" fill-opacity="{{ $loop->even ? 0.35 : 0.6 }}" />
                    @endforeach

                    {{-- Hills and horizon --}}
                    <path d="M0 132 C50 118 90 112 140 124 S230 108 290 122 S380 104 420 116" stroke="white" stroke-opacity="0.14" />
                    <path d="M0 146 C40 136 80 130 120 140 S190 150 230 144 S300 128 350 138 S400 146 420 142" stroke="white" stroke-opacity="0.3" />
                    <path d="M0 150 H420" stroke="white" stroke-opacity="0.35" />

                    {{-- Homesteads (rondavels) and acacia trees on the horizon --}}
                    @foreach ([[160, 146, 0.8], [318, 134, 1], [334, 136, 0.8], [380, 300, 2.2]] as [$hutX, $hutY, $hutScale])
                        <g transform="translate({{ $hutX }} {{ $hutY }}) scale({{ $hutScale }})" stroke="white" stroke-opacity="0.6">
                            <path d="M-5 0 V-6 H5 V0 M-1 0 V-3 H1 V0" vector-effect="non-scaling-stroke" />
                            <path d="M-7 -6 L0 -13 L7 -6 Z" fill="#7dbf45" fill-opacity="0.25" vector-effect="non-scaling-stroke" />
                        </g>
                    @endforeach
                    @foreach ([[82, 134, 1.3], [392, 142, 1], [52, 322, 3]] as [$treeX, $treeY, $treeScale])
                        <g transform="translate({{ $treeX }} {{ $treeY }}) scale({{ $treeScale }})" stroke="white" stroke-opacity="0.55">
                            <path d="M0 0 V-8 M0 -6 L-4 -11 M0 -6 L5 -12" vector-effect="non-scaling-stroke" />
                            <path d="M-12 -11 Q0 -18 12 -11 Q0 -9 -12 -11 Z" fill="#7dbf45" fill-opacity="0.3" vector-effect="non-scaling-stroke" />
                        </g>
                    @endforeach

                    {{-- Ploughed fields running to the horizon --}}
                    <g mask="url(#hero-ground-mask)" stroke="white" stroke-opacity="0.16">
                        @foreach ([-260, -150, -50, 20, 470, 560, 680, 820] as $fieldX)
                            <path d="M250 152 L{{ $fieldX }} 460" />
                        @endforeach
                        @foreach ([172, 200, 240, 300, 380] as $furrowY)
                            <path d="M0 {{ $furrowY }} H420" stroke-opacity="0.5" />
                        @endforeach
                    </g>

                    {{-- The road --}}
                    <g mask="url(#hero-ground-mask)">
                        <path d="M60 460 C110 380 270 330 240 262 C210 194 214 190 246 152 L254 152 C248 190 250 186 320 258 C390 330 270 380 280 460 Z" fill="url(#hero-road-fill)" />
                        <path d="M60 460 C110 380 270 330 240 262 C210 194 214 190 246 152" stroke="white" stroke-opacity="0.7" />
                        <path d="M280 460 C270 380 390 330 320 258 C250 186 248 190 254 152" stroke="white" stroke-opacity="0.7" />
                        <path d="{{ $roadCentre }}" stroke="#a6d77a" stroke-width="1.5" stroke-dasharray="8 6" class="road-dash" />
                    </g>

                    {{-- The roadshow on its way to the next village --}}
                    <g class="motion-reduce:hidden">
                        @foreach (['0s', '-5s'] as $begin)
                            <circle r="4" fill="#7dbf45">
                                <animateMotion dur="10s" begin="{{ $begin }}" repeatCount="indefinite" path="{{ $roadCentre }}" />
                                <animate attributeName="r" values="5;1.5" dur="10s" begin="{{ $begin }}" repeatCount="indefinite" />
                                <animate attributeName="opacity" values="0;1;1;0" keyTimes="0;0.08;0.85;1" dur="10s" begin="{{ $begin }}" repeatCount="indefinite" />
                            </circle>
                        @endforeach
                    </g>
                </svg>

                {{-- Frame labels --}}
                <p class="tag absolute top-4 left-5">R2R Roadshow<br>// Rural to rural</p>
                <p class="absolute top-4 right-5 flex items-center gap-1.5 bg-white/10 px-2 py-1 font-mono text-[8px] tracking-[0.1em] uppercase ring-1 ring-white/20"><i class="animate-blink size-1 bg-lime"></i>On the road</p>
                <p class="absolute top-[25%] left-[59.5%] -translate-x-1/2 font-mono text-[8px] tracking-[0.1em] whitespace-nowrap text-white/60 uppercase">Next village ↓</p>

                {{-- Pillar stops, nearest first: positions follow the road, labels come from the pillars --}}
                @foreach ($pillars->take(4)->values()->zip([
                    ['position' => 'left-[46.2%] top-[90.3%]', 'size' => 'size-2.5', 'side' => 'left'],
                    ['position' => 'left-[59.8%] top-[77.4%]', 'size' => 'size-2', 'side' => 'right'],
                    ['position' => 'left-[68.3%] top-[67.3%]', 'size' => 'size-2', 'side' => 'right'],
                    ['position' => 'left-[59%] top-[46.3%]', 'size' => 'size-1.5', 'side' => 'left'],
                ]) as [$pillar, $stop])
                    <span class="absolute {{ $stop['position'] }} -translate-1/2">
                        <span class="animate-pulse-ring absolute inset-0 rounded-full bg-green" style="animation-delay: {{ $loop->index * 0.6 }}s" aria-hidden="true"></span>
                        <span class="relative block {{ $stop['size'] }} rounded-full bg-green ring-2 ring-night"></span>
                        <span class="absolute top-1/2 {{ $stop['side'] === 'left' ? 'right-5 text-right' : 'left-5' }} -translate-y-1/2 font-mono text-[9px] leading-tight tracking-[0.08em] whitespace-nowrap text-white/85 uppercase">
                            <span class="block text-green">Stop {{ sprintf('%02d', $loop->iteration) }}</span>{{ $pillar->verb }}
                        </span>
                    </span>
                @endforeach

                <figcaption class="absolute inset-x-0 -bottom-7 truncate font-mono text-[9px] tracking-[0.08em] text-white/50 uppercase">
                    <span class="text-green">Route //</span> {{ $roadshowRoute }}
                </figcaption>
            </figure>

            <ul class="grid w-full max-w-xs gap-5 sm:grid-cols-2 lg:grid-cols-1 lg:justify-self-end">
                @foreach ([['Rural Youth', 'Exposed to real opportunity'], ['Rural Teachers', 'Capacitated to lead']] as [$title, $subtitle])
                    <li class="flex gap-3">
                        <span class="mt-1 grid size-3 shrink-0 grid-cols-2 gap-px" aria-hidden="true"><i class="bg-green"></i><i class="bg-green/40"></i><i class="bg-green/40"></i><i class="bg-green"></i></span>
                        <span>
                            <span class="block text-[15px]">{{ $title }}</span>
                            <span class="block text-xs text-white/50">{{ $subtitle }}</span>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
