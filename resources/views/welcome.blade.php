<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @php
            $pageTitle = config('app.name', 'Rural2Rural').' — Delivering Real Opportunities to Rural Communities';
            $pageDescription = 'Rural2Rural Skills, Jobs, Careers and Entrepreneurship Initiative travels across rural South Africa educating, training, exposing and advising youth, women, small businesses and people living with disabilities.';
            $shareImage = asset('images/og/rural2rural-og.png');
        @endphp
        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $pageDescription }}">
        <link rel="canonical" href="{{ route('home') }}">

        {{-- Open Graph (Facebook, WhatsApp, LinkedIn) --}}
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Rural2Rural">
        <meta property="og:locale" content="en_ZA">
        <meta property="og:url" content="{{ route('home') }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $pageDescription }}">
        <meta property="og:image" content="{{ $shareImage }}">
        <meta property="og:image:secure_url" content="{{ $shareImage }}">
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="Rural2Rural — Delivering real opportunities to rural communities across South Africa">

        {{-- X / Twitter --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@Rural2Rural">
        <meta name="twitter:title" content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $pageDescription }}">
        <meta name="twitter:image" content="{{ $shareImage }}">
        <meta name="twitter:image:alt" content="Rural2Rural — Delivering real opportunities to rural communities across South Africa">
        <meta name="theme-color" content="#0c1035">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/r2r/mark.png') }}">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    @php
        $contact = config('rural2rural.contact');
        $mailPartner = 'mailto:'.$contact['email'].'?subject='.rawurlencode('Partnering with Rural2Rural');
        $gutter = 'px-4 sm:px-8 lg:pr-12 lg:pl-[136px]';

        $navigation = [
            ['label' => 'Who We Are', 'href' => '#about', 'count' => null],
            ['label' => 'Programmes', 'href' => '#programmes', 'count' => count(config('rural2rural.programmes'))],
            ['label' => 'How We Work', 'href' => '#approach', 'count' => 3],
            ['label' => 'On the Road', 'href' => '#events', 'count' => null],
            ['label' => 'Partners', 'href' => '#partners', 'count' => count(config('rural2rural.partners'))],
            ['label' => 'Contact', 'href' => '#contact', 'count' => null],
        ];

        $pillars = config('rural2rural.pillars');
        $programmes = config('rural2rural.programmes');
        $events = config('rural2rural.events');
        $partners = config('rural2rural.partners');

        $searchIndex = [
            ['title' => 'Who we are', 'kind' => 'Section', 'href' => '#about', 'keywords' => 'about mission rural south africa youth women disabilities'],
            ['title' => 'Programme pillars', 'kind' => 'Section', 'href' => '#programmes', 'keywords' => 'careers skills entrepreneurship teachers'],
            ['title' => 'How we work', 'kind' => 'Section', 'href' => '#approach', 'keywords' => 'roadshows included opportunity'],
            ['title' => 'On the road', 'kind' => 'Section', 'href' => '#events', 'keywords' => 'events map expo past'],
            ['title' => 'Our partners', 'kind' => 'Section', 'href' => '#partners', 'keywords' => 'seta sponsors supporters funders'],
            ...collect($partners)->map(fn (array $partner): array => ['title' => $partner['name'], 'kind' => 'Partner', 'href' => '#partners', 'keywords' => $partner['description']])->all(),
            ['title' => 'Partner with us', 'kind' => 'Section', 'href' => '#partner', 'keywords' => 'sponsor host roadshow municipality partnership'],
            ['title' => 'Contact', 'kind' => 'Section', 'href' => '#contact', 'keywords' => 'address phone email office centurion'],
            ...collect($pillars)->map(fn (array $pillar): array => ['title' => $pillar['title'], 'kind' => 'Pillar', 'href' => '#programmes', 'keywords' => $pillar['body']])->all(),
            ...collect($programmes)->map(fn (array $programme): array => ['title' => $programme['title'], 'kind' => 'Programme', 'href' => '#programmes', 'keywords' => $programme['pillar']])->all(),
            ...collect($events)->map(fn (array $event): array => ['title' => $event['title'].' · '.$event['place'], 'kind' => 'Event', 'href' => '#events', 'keywords' => $event['date']])->all(),
            ['title' => 'Email '.$contact['email'], 'kind' => 'Contact', 'href' => 'mailto:'.$contact['email'], 'keywords' => 'email mail message'],
            ['title' => 'Call '.$contact['phone'], 'kind' => 'Contact', 'href' => 'tel:'.str_replace(' ', '', $contact['phone']), 'keywords' => 'phone call telephone office'],
            ['title' => 'Mobile '.$contact['mobile'], 'kind' => 'Contact', 'href' => 'tel:'.str_replace(' ', '', $contact['mobile']), 'keywords' => 'mobile cell whatsapp phone'],
        ];

        $fieldPhotos = [
            ['image' => 'learners.jpg', 'caption' => 'Career guidance session'],
            ['image' => 'volunteers.jpg', 'caption' => 'R2R roadshow team'],
            ['image' => 'leaders.jpg', 'caption' => 'Community & partners'],
            ['image' => 'village.jpg', 'caption' => 'Rural South Africa'],
        ];
    @endphp
    <body class="overflow-x-clip">
        {{-- ─────────────── Header ─────────────── --}}
        <header id="site-header" class="group/header fixed inset-x-0 top-0 z-50 border-b border-transparent transition-colors duration-500 [&.is-scrolled]:border-white/10 [&.is-scrolled]:bg-night/80 [&.is-scrolled]:backdrop-blur-md [&.is-light]:border-navy/10 [&.is-light]:bg-paper/85">
            <div class="flex h-16 items-center justify-between gap-6 px-4 sm:px-8">
                <a href="#top" class="flex items-center gap-2.5 text-white transition-colors group-[.is-light]/header:text-navy" aria-label="Rural2Rural home">
                    <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-9 rounded-full">
                    <span class="leading-none">
                        <span class="block text-[17px] font-medium tracking-[-0.02em]">Rural2Rural</span>
                        <span class="mt-1 block font-mono text-[8px] tracking-[0.3em] text-green uppercase">Initiative</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-6 lg:flex xl:gap-9" aria-label="Primary">
                    @foreach ($navigation as $item)
                        <a href="{{ $item['href'] }}" class="font-mono text-[11px] tracking-[0.08em] text-white/85 uppercase transition-colors group-[.is-light]/header:text-navy/80 hover:text-green">{{ $item['label'] }}</a>
                    @endforeach
                </nav>

                <div class="flex items-center gap-3">
                    <button type="button" data-search-open class="flex h-9 items-center gap-2 border border-white/25 px-2.5 text-white transition-colors group-[.is-light]/header:border-navy/30 group-[.is-light]/header:text-navy hover:border-green hover:text-green" aria-label="Search the site" aria-keyshortcuts="Control+K /">
                        <svg viewBox="0 0 16 16" class="size-4" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="7" cy="7" r="4.5" /><path d="m10.5 10.5 3.5 3.5" /></svg>
                        <kbd class="hidden font-mono text-[10px] tracking-[0.06em] opacity-60 xl:inline">Ctrl K</kbd>
                    </button>
                    <a href="{{ $mailPartner }}" class="hidden font-mono text-[11px] tracking-[0.08em] text-green uppercase underline decoration-green/60 underline-offset-4 hover:decoration-green sm:inline">Partner with us</a>
                    <button type="button" data-menu-toggle aria-expanded="false" aria-controls="mobile-menu" class="flex h-9 items-center gap-2 border border-white/25 px-3 font-mono text-[11px] tracking-[0.08em] text-white uppercase group-[.is-light]/header:border-navy/30 group-[.is-light]/header:text-navy lg:hidden">
                        <span data-menu-label>Menu</span>
                        <svg viewBox="0 0 16 16" class="size-3.5" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M2 5h12M2 11h12" /></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile menu: numbered panel with counts and "+" markers --}}
            <nav id="mobile-menu" data-menu class="mx-3 mb-3 hidden bg-white text-navy shadow-2xl lg:hidden" aria-label="Mobile">
                <ul class="px-5 pt-2">
                    @foreach ($navigation as $item)
                        <li class="border-b border-navy/10">
                            <a href="{{ $item['href'] }}" class="flex items-center justify-between py-4 text-[22px] tracking-[-0.02em]">
                                <span>{{ $item['label'] }}@if ($item['count'])<sup class="ml-1 font-mono text-[10px] text-navy/50">({{ $item['count'] }})</sup>@endif</span>
                                <span class="text-xl font-light text-navy/60" aria-hidden="true">+</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <ul class="flex items-center gap-2 px-5 pt-5" aria-label="Rural2Rural on social media">
                    @foreach (config('rural2rural.social') as $label => $href)
                        <li>
                            <a href="{{ $href }}" target="_blank" rel="noopener" aria-label="Rural2Rural on {{ $label }} (opens in a new tab)" class="grid size-10 place-items-center rounded-full bg-navy/[0.06] text-navy transition-colors hover:bg-navy hover:text-white">
                                <x-social-icon :platform="$label" class="size-[18px]" />
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="grid grid-cols-2 items-center gap-3 p-5">
                    <a href="tel:{{ str_replace(' ', '', $contact['phone']) }}" class="text-center font-mono text-[11px] tracking-[0.08em] uppercase">Call us</a>
                    <x-button :href="$mailPartner" variant="navy" class="justify-center">Partner with us</x-button>
                </div>
            </nav>
        </header>

        {{-- ─────────────── Social sidebar (left) ─────────────── --}}
        <nav data-social-sidebar aria-label="Rural2Rural on social media" class="fixed top-1/2 left-[44px] z-40 hidden -translate-x-1/2 -translate-y-1/2 flex-col items-center gap-4 transition-opacity duration-500 lg:flex [&.is-hidden]:pointer-events-none [&.is-hidden]:opacity-0">
            <span class="font-mono text-[9px] tracking-[0.3em] text-green uppercase [writing-mode:vertical-rl] rotate-180">Follow // R2R</span>
            <span class="h-10 w-px bg-gradient-to-b from-transparent to-green/70" aria-hidden="true"></span>
            <ul class="flex flex-col gap-2 rounded-full bg-night/85 p-1.5 shadow-lg ring-1 ring-white/15 backdrop-blur-md">
                @foreach (config('rural2rural.social') as $label => $href)
                    <li class="group relative">
                        <a href="{{ $href }}" target="_blank" rel="noopener" aria-label="Rural2Rural on {{ $label }} (opens in a new tab)" class="grid size-10 place-items-center rounded-full text-white/80 transition-colors duration-300 hover:bg-green hover:text-night focus-visible:bg-green focus-visible:text-night focus-visible:outline-none">
                            <x-social-icon :platform="$label" class="size-[18px]" />
                        </a>
                        <span class="pointer-events-none absolute top-1/2 left-full ml-3 -translate-x-1 -translate-y-1/2 bg-night px-2.5 py-1.5 font-mono text-[10px] tracking-[0.08em] whitespace-nowrap text-white uppercase opacity-0 ring-1 ring-white/15 transition duration-300 group-focus-within:translate-x-0 group-focus-within:opacity-100 group-hover:translate-x-0 group-hover:opacity-100" aria-hidden="true">{{ $label }}</span>
                    </li>
                @endforeach
            </ul>
            <span class="h-10 w-px bg-gradient-to-t from-transparent to-green/70" aria-hidden="true"></span>
        </nav>

        <main>
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
                                A programme that travels across rural South Africa — educating, training, exposing and advising youth, women, small businesses and people living with disabilities.
                            </p>
                            <div class="mt-7 flex flex-wrap gap-3">
                                <x-button href="#programmes">Explore programmes</x-button>
                                <x-button href="#about" variant="outline">Who we are</x-button>
                            </div>
                        </div>
                    </div>

                    {{-- Orbit: rotating logo-colour ring with the four pillars on its path --}}
                    <div class="fade-up relative flex flex-col items-center justify-center gap-10 delay-300 lg:items-end">
                        <div class="relative mx-auto aspect-square w-[min(78vw,360px)] lg:mr-[12%]">
                            <div class="absolute inset-[9%] rounded-full border border-white/20"></div>
                            <div class="animate-spin-slow absolute inset-[22%] rounded-full bg-[conic-gradient(from_0deg,var(--color-sky),var(--color-green),var(--color-navy),var(--color-blue),var(--color-sky))] blur-[2px] [mask:radial-gradient(circle,transparent_44%,#000_46%,#000_70%,transparent_72%)]"></div>
                            <div class="animate-spin-reverse scanlines absolute inset-[22%] rounded-full opacity-60 [mask:radial-gradient(circle,transparent_44%,#000_46%,#000_70%,transparent_72%)]"></div>
                            <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="absolute top-1/2 left-1/2 size-[17%] -translate-1/2 rounded-full">

                            @foreach ([
                                ['label' => "Careers<br>&amp; Jobs", 'position' => 'top-[9%] left-1/2', 'text' => 'bottom-4 left-1/2 -translate-x-1/2 text-center'],
                                ['label' => "Skills<br>Training", 'position' => 'top-1/2 left-[91%]', 'text' => 'left-4 top-1/2 -translate-y-1/2'],
                                ['label' => "Entre-<br>preneurship", 'position' => 'top-[91%] left-1/2', 'text' => 'top-4 left-1/2 -translate-x-1/2 text-center'],
                                ['label' => "Teacher<br>Development", 'position' => 'top-1/2 left-[9%]', 'text' => 'right-4 top-1/2 -translate-y-1/2 text-right'],
                            ] as $node)
                                <span class="absolute {{ $node['position'] }} -translate-1/2">
                                    <span class="animate-pulse-ring absolute inset-0 rounded-full bg-green" aria-hidden="true"></span>
                                    <span class="relative block size-1.5 rounded-full bg-green"></span>
                                    <span class="absolute {{ $node['text'] }} font-mono text-[9px] leading-tight tracking-[0.08em] whitespace-nowrap text-white/80 uppercase">{!! $node['label'] !!}</span>
                                </span>
                            @endforeach
                        </div>

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

            {{-- ─────────────── 02 · Who we are (scroll-lit statement) ─────────────── --}}
            <section id="about" class="relative border-t border-white/10 bg-night">
                <x-rail />
                <div class="{{ $gutter }} grid gap-8 py-28 lg:grid-cols-[1fr_2.4fr] lg:py-36">
                    <x-eyebrow first="Who we">are</x-eyebrow>
                    <p data-scrub class="max-w-3xl text-[clamp(1.5rem,2.7vw,2.4rem)] leading-[1.18] font-light tracking-[-0.02em]">
                        <span data-scrub-text>Rural2Rural travels across rural South Africa — educating, training, exposing and advising small businesses, youth, women and people living with disabilities to engage in further education, careers, skills development and entrepreneurship.</span>
                    </p>
                </div>
            </section>

            {{-- ─────────────── 03 · Programme pillars ─────────────── --}}
            <section id="programmes" data-reveal class="relative border-t border-white/10 bg-night">
                <x-rail />
                <div data-pillars class="grid sm:grid-cols-2 lg:ml-[88px] lg:grid-cols-4">
                    @foreach ($pillars as $pillar)
                        <article data-pillar tabindex="0" class="group relative flex min-h-[460px] flex-col border-white/10 p-6 outline-none max-lg:border-b sm:odd:border-r lg:border-r lg:last:border-r-0">
                            <div class="glass-card pointer-events-none absolute inset-0 -z-0 opacity-0 transition-opacity duration-700 group-[.is-active]:opacity-100" aria-hidden="true"></div>
                            <span class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-lime transition-transform duration-700 group-[.is-active]:scale-x-100" aria-hidden="true"></span>

                            <div class="relative flex justify-between font-mono text-[10px] tracking-[0.1em] uppercase">
                                <span class="text-white/55 group-[.is-active]:text-white/80">{{ $pillar['step'] }}</span>
                                <span class="text-green transition-colors group-[.is-active]:text-white">{{ $pillar['verb'] }}</span>
                            </div>

                            <div class="relative flex flex-1 items-center justify-center py-8">
                                <svg data-rosette="{{ $pillar['figure'] }}" class="rosette size-40 text-white/75 transition-[rotate,color] duration-[2000ms] ease-out-expo group-[.is-active]:rotate-45 group-[.is-active]:text-white" aria-hidden="true"></svg>
                            </div>

                            <div class="relative">
                                <h3 class="text-lg tracking-[-0.01em]">{{ $pillar['title'] }}</h3>
                                <p class="mt-2 text-[13px] leading-snug text-white/55 group-[.is-active]:text-white/85">{{ $pillar['body'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            {{-- ─────────────── 04 · Programme list with hover card ─────────────── --}}
            <section class="relative border-t border-white/10 bg-night" aria-labelledby="programme-list-title">
                <x-rail />
                <div class="{{ $gutter }} grid gap-8 py-24 lg:grid-cols-[1fr_2.4fr] lg:py-28">
                    <x-eyebrow first="Your path">to opportunity</x-eyebrow>
                    <h2 id="programme-list-title" class="max-w-2xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] font-light tracking-[-0.025em]">Meet the programmes built for every rural learner, teacher and entrepreneur.</h2>
                </div>

                <div data-programme-list class="relative lg:ml-[88px]">
                    <ol>
                        @foreach ($programmes as $programme)
                            <li data-row data-title="{{ $programme['title'] }}" data-pillar="{{ $programme['pillar'] }}" data-number="{{ sprintf('%02d', $loop->iteration) }}" class="group grid grid-cols-[3rem_1fr] items-center gap-x-4 border-t border-white/10 px-4 py-6 transition-colors hover:bg-white/[0.04] sm:px-8 lg:grid-cols-[6rem_1fr_auto] lg:px-12">
                                <span class="font-mono text-[11px] text-green">{{ sprintf('%02d', $loop->iteration) }}</span>
                                <span class="text-[clamp(1.15rem,2vw,1.6rem)] tracking-[-0.02em] transition-transform duration-500 ease-out-expo group-hover:translate-x-2">{{ $programme['title'] }}</span>
                                <span class="col-start-2 mt-1 font-mono text-[10px] tracking-[0.08em] text-white/50 uppercase transition-colors group-hover:text-green lg:col-start-auto lg:mt-0 lg:text-[11px]">{{ $programme['pillar'] }} <span aria-hidden="true">↳</span></span>
                            </li>
                        @endforeach
                    </ol>

                    <div data-hover-card class="glass-card pointer-events-none absolute top-0 left-0 z-10 hidden w-[260px] scale-90 opacity-0 transition-[opacity,scale] duration-300 lg:block" aria-hidden="true">
                        <div class="glass-inner p-4">
                            <span class="inline-flex items-center gap-1.5 bg-white/20 px-1.5 py-1 font-mono text-[8px] tracking-[0.1em] uppercase"><i class="size-1 bg-white"></i>Programme</span>
                            <p data-card-title class="mt-3 text-[15px] leading-tight"></p>
                            <p data-card-pillar class="mt-1 font-mono text-[9px] tracking-[0.08em] text-white/70 uppercase"></p>
                            <canvas data-dot-matrix data-text="01" data-dot="4" class="mt-3 h-11 w-24"></canvas>
                            <div class="mt-3 flex items-center gap-3 bg-white/10 p-2 ring-1 ring-white/20">
                                <span class="h-5 flex-1 bg-[repeating-linear-gradient(90deg,rgb(255_255_255/0.7)_0_1px,transparent_1px_4px)]"></span>
                                <span class="font-mono text-[7px] leading-tight tracking-[0.1em] uppercase">R2R<br>Roadshow</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-t border-white/10"></div>
            </section>

            {{-- ─────────────── 05 · Stripe band into light ─────────────── --}}
            <div data-reveal class="grid gap-2 bg-night py-6" aria-hidden="true">
                <span class="stripe h-3 bg-blue"></span>
                <span class="stripe h-2 bg-sky delay-150"></span>
                <span class="stripe h-1 bg-green delay-300"></span>
            </div>

            {{-- ─────────────── 06 · Mission (light) ─────────────── --}}
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
                            <div class="glass-inner overflow-hidden p-5">
                                <p class="text-lg">Roadshow Route</p>
                                <p class="mt-1 text-center font-mono text-[9px] tracking-[0.1em] uppercase">Pillars active</p>
                                <div class="absolute inset-x-[6%] top-[38%] bottom-[-30%]" aria-hidden="true">
                                    @foreach ([0, 1, 2, 3] as $ring)
                                        <span class="absolute top-0 aspect-square w-[38%] rounded-full border border-dashed border-white/50" style="left: {{ $ring * 20.5 }}%"></span>
                                    @endforeach
                                </div>
                                @foreach ([['Careers', 'left-[12%] top-[52%]'], ['Skills', 'left-[34%] top-[40%] text-lime'], ['Enterprise', 'left-[58%] top-[62%]'], ['Teachers', 'left-[78%] top-[46%]']] as [$label, $position])
                                    <span class="absolute {{ $position }} flex items-center gap-1.5 font-mono text-[9px] tracking-[0.08em] uppercase"><i class="animate-blink size-1.5 bg-current"></i>{{ $label }}</span>
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
                            <div class="glass-inner overflow-hidden p-5">
                                <p class="text-lg">Who We Serve</p>
                                <svg viewBox="0 0 400 200" class="absolute inset-x-[18%] top-[18%] h-[72%] w-[64%]" fill="none" aria-hidden="true">
                                    @foreach ([0, 1, 2, 3, 4, 5] as $track)
                                        <rect x="{{ 20 + $track * 14 }}" y="{{ 10 + $track * 12 }}" width="{{ 360 - $track * 28 }}" height="{{ 180 - $track * 24 }}" rx="{{ 90 - $track * 12 }}" stroke="white" stroke-opacity="{{ 0.55 - $track * 0.07 }}" />
                                    @endforeach
                                    <rect x="20" y="10" width="360" height="180" rx="90" stroke="#a6d77a" stroke-width="2" pathLength="100" stroke-dasharray="12 88">
                                        <animate attributeName="stroke-dashoffset" from="100" to="0" dur="6s" repeatCount="indefinite" />
                                    </rect>
                                </svg>
                                <p class="absolute top-1/2 left-1/2 -translate-1/2 text-center font-mono text-[9px] tracking-[0.1em] uppercase">Rural<br>Communities</p>
                                <ul class="absolute top-[34%] left-5 grid gap-1.5 font-mono text-[8px] tracking-[0.08em] uppercase sm:text-[9px]">
                                    @foreach (['Learners', 'Youth', 'Women', 'SMMEs', 'Disabilities'] as $group)
                                        <li class="flex items-center gap-1.5"><i class="size-1 bg-white"></i>{{ $group }}</li>
                                    @endforeach
                                </ul>
                                <ul class="absolute top-[34%] right-5 grid gap-1.5 text-right font-mono text-[8px] tracking-[0.08em] uppercase sm:text-[9px]">
                                    @foreach ([0, 1, 2, 3, 4] as $index)
                                        <li class="flex items-center justify-end gap-1.5 {{ $index === 0 ? 'text-lime' : 'text-white/80' }}">Reached <i class="animate-blink size-1 bg-current" style="animation-delay: {{ $index * 0.25 }}s"></i></li>
                                    @endforeach
                                </ul>
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
                            <div class="glass-inner flex flex-col overflow-hidden p-5">
                                <div class="flex items-start justify-between">
                                    <p class="text-lg">Opportunity Ready</p>
                                    <span class="flex items-center gap-1.5 bg-white/15 px-2 py-1 font-mono text-[8px] tracking-[0.1em] uppercase ring-1 ring-white/25"><i class="animate-blink size-1 bg-lime"></i>On the road</span>
                                </div>
                                <canvas data-dot-wave class="mt-3 h-[38%] w-full" aria-hidden="true"></canvas>
                                <div class="mt-auto grid grid-cols-3 items-end">
                                    <p class="font-mono text-[9px] tracking-[0.08em] uppercase"><span class="block text-sm text-lime">04</span>Pillars</p>
                                    <div class="flex flex-col items-center gap-1">
                                        <canvas data-dot-matrix data-text="10+" data-dot="4" class="h-10 w-[84px]" aria-label="10+"></canvas>
                                        <p class="font-mono text-[9px] tracking-[0.08em] uppercase">Years on the road</p>
                                    </div>
                                    <p class="text-right font-mono text-[9px] tracking-[0.08em] uppercase"><span class="block text-sm text-lime">Rural SA</span>Reach</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ─────────────── 08 · On the road (dot map) ─────────────── --}}
            <section id="events" class="relative border-t border-white/10 bg-night" aria-labelledby="events-title">
                <x-rail />
                <div class="{{ $gutter }} grid gap-14 py-24 lg:grid-cols-[1fr_1.6fr] lg:py-28">
                    <div class="flex flex-col">
                        <x-eyebrow first="On the">road</x-eyebrow>
                        <h2 id="events-title" class="mt-6 max-w-md text-[clamp(1.6rem,2.6vw,2.3rem)] leading-[1.12] font-light tracking-[-0.025em]">Bringing skills, jobs and careers to every corner of rural South Africa.</h2>

                        <p class="mt-12 font-mono text-[10px] tracking-[0.1em] text-white/45 uppercase">Past events</p>
                        <ul class="mt-3 border-t border-white/10">
                            @foreach ($events as $event)
                                <li class="flex items-baseline justify-between gap-4 border-b border-white/10 py-4">
                                    <span>
                                        <span class="block text-[15px]">{{ $event['title'] }}</span>
                                        <span class="font-mono text-[10px] tracking-[0.08em] text-green uppercase">{{ $event['place'] }}</span>
                                    </span>
                                    <span class="font-mono text-[10px] tracking-[0.08em] whitespace-nowrap text-white/50 uppercase">{{ $event['date'] }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-auto flex gap-10 pt-12">
                            <p class="font-mono text-[10px] tracking-[0.08em] text-white/50 uppercase"><span class="block text-xl text-green">10+</span>Years on the road</p>
                            <p class="font-mono text-[10px] tracking-[0.08em] text-white/50 uppercase"><span class="block text-xl text-green">04</span>Programme pillars</p>
                        </div>
                    </div>

                    <div class="relative aspect-[1.124] w-full">
                        <canvas data-dot-map data-routes="hq-ficksburg hq-jozini hq-ncape ficksburg-ncape jozini-ficksburg" class="absolute inset-0 size-full" aria-hidden="true"></canvas>
                        @foreach ([
                            ['id' => 'hq', 'lon' => 28.19, 'lat' => -25.86, 'label' => 'Centurion · HQ'],
                            ['id' => 'ficksburg', 'lon' => 27.88, 'lat' => -28.87, 'label' => 'Ficksburg'],
                            ['id' => 'jozini', 'lon' => 32.06, 'lat' => -27.43, 'label' => 'Jozini', 'side' => 'left'],
                            ['id' => 'ncape', 'lon' => 24.76, 'lat' => -28.74, 'label' => 'Northern Cape', 'side' => 'left'],
                        ] as $node)
                            <span data-map-node="{{ $node['id'] }}" data-lon="{{ $node['lon'] }}" data-lat="{{ $node['lat'] }}" class="absolute -translate-1/2">
                                <span class="animate-pulse-ring absolute inset-0 rounded-full bg-green" aria-hidden="true"></span>
                                <span class="relative grid size-6 place-items-center rounded-full bg-white shadow-lg">
                                    <span class="size-2 rounded-full {{ $node['id'] === 'hq' ? 'bg-green' : 'bg-navy' }}"></span>
                                </span>
                                <span class="absolute top-1/2 {{ ($node['side'] ?? 'right') === 'left' ? 'right-8' : 'left-8' }} -translate-y-1/2 font-mono text-[9px] tracking-[0.08em] whitespace-nowrap text-white uppercase">{{ $node['label'] }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- ─────────────── 09 · Partners ─────────────── --}}
            <section id="partners" data-header="light" class="overflow-hidden bg-paper text-navy" aria-labelledby="partners-title">
                <div data-reveal class="grid gap-8 px-4 pt-24 pb-14 sm:px-8 lg:grid-cols-[1fr_2.4fr] lg:pt-28 lg:pr-12 lg:pl-[136px]">
                    <p class="tag fade-up text-blue">Our<br>// partners</p>
                    <div class="grid gap-6 lg:grid-cols-[1.4fr_1fr] lg:items-end">
                        <h2 id="partners-title" class="fade-up max-w-xl text-[clamp(1.8rem,3.2vw,2.8rem)] leading-[1.1] tracking-[-0.025em] delay-100">Backed by partners who believe in rural talent.</h2>
                        <p class="fade-up max-w-sm text-[14px] leading-relaxed text-navy/70 delay-200">Sector education and training authorities, foundations and community media help us take skills, jobs and careers to rural South Africa.</p>
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
                                            <img src="{{ asset('images/partners/'.$partner['logo']) }}" alt="{{ $isDuplicate ? '' : $partner['name'].' logo' }}" loading="lazy" class="max-h-24 w-auto max-w-full object-contain">
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
                                <a href="#contact" class="font-mono text-[11px] tracking-[0.08em] text-white uppercase underline-offset-4 hover:underline">Get in touch</a>
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

            {{-- ─────────────── 11 · Closing glow ─────────────── --}}
            <section class="relative isolate overflow-hidden border-t border-white/10 bg-night" aria-labelledby="closing-title">
                <x-rail />
                <div class="pointer-events-none absolute inset-x-0 bottom-0 -z-10 h-[140%] bg-[radial-gradient(ellipse_at_50%_100%,var(--color-green)_0%,var(--color-blue)_35%,transparent_70%)] opacity-80" aria-hidden="true"></div>
                <div class="dot-screen pointer-events-none absolute inset-0 -z-10 [mask-image:linear-gradient(to_bottom,transparent,black)]" aria-hidden="true"></div>

                <div data-reveal class="{{ $gutter }} py-32 lg:py-40">
                    <x-eyebrow first="Ready" class="fade-up">to grow</x-eyebrow>
                    <h2 id="closing-title" class="fade-up mt-5 max-w-xl text-[clamp(2rem,3.6vw,3.2rem)] leading-[1.08] font-light tracking-[-0.03em] delay-100">Build the future rural South Africa needs next.</h2>
                    <p class="fade-up mt-5 max-w-md text-[14px] text-white/70 delay-200">Join the movement delivering real opportunities to rural communities.</p>
                    <x-button :href="$mailPartner" class="fade-up mt-8 delay-300">Join the movement</x-button>
                </div>

                {{-- ─────────────── Footer ─────────────── --}}
                <footer id="contact" class="relative border-t border-white/15">
                    <span class="rail-node" aria-hidden="true"></span>
                    @php
                        $linkClass = 'font-mono text-[11px] tracking-[0.06em] uppercase transition-colors hover:text-green';
                        $headingClass = 'mb-4 font-mono text-[11px] tracking-[0.08em] text-lime uppercase';
                    @endphp
                    <div class="{{ $gutter }} grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1.3fr_0.8fr]">
                        <div>
                            <a href="#top" class="flex items-center gap-3" aria-label="Back to top">
                                <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-11 rounded-full">
                                <span class="text-2xl tracking-[-0.02em]">Rural2Rural</span>
                            </a>
                            <p class="mt-4 max-w-[16rem] text-[13px] text-white/60">Skills, Jobs, Careers &amp; Entrepreneurship Initiative. Delivering real opportunities to rural communities.</p>
                        </div>

                        <nav aria-label="Programmes">
                            <h3 class="{{ $headingClass }}">// Programmes</h3>
                            <ul class="grid gap-2.5">
                                @foreach (['Careers & Jobs', 'Skills Training', 'Entrepreneurship', 'Teacher Development'] as $label)
                                    <li><a href="#programmes" class="{{ $linkClass }}">{{ $label }}</a></li>
                                @endforeach
                            </ul>
                        </nav>

                        <nav aria-label="Organisation">
                            <h3 class="{{ $headingClass }}">// Organisation</h3>
                            <ul class="grid gap-2.5">
                                @foreach (['Who We Are' => '#about', 'How We Work' => '#approach', 'On the Road' => '#events', 'Our Partners' => '#partners', 'Partner With Us' => '#partner'] as $label => $href)
                                    <li><a href="{{ $href }}" class="{{ $linkClass }}">{{ $label }}</a></li>
                                @endforeach
                            </ul>
                        </nav>

                        <div>
                            <h3 class="{{ $headingClass }}">// Contact</h3>
                            <address class="grid gap-2.5 not-italic">
                                <span class="font-mono text-[11px] leading-relaxed tracking-[0.06em] text-white/70 uppercase">{!! implode('<br>', array_map('e', $contact['address'])) !!}</span>
                                <a href="tel:{{ str_replace(' ', '', $contact['phone']) }}" class="{{ $linkClass }}">T {{ $contact['phone'] }}</a>
                                <a href="tel:{{ str_replace(' ', '', $contact['mobile']) }}" class="{{ $linkClass }}">M {{ $contact['mobile'] }}</a>
                                <a href="mailto:{{ $contact['email'] }}" class="font-mono text-[11px] tracking-[0.06em] transition-colors hover:text-green">{{ $contact['email'] }}</a>
                            </address>
                        </div>

                        <nav aria-label="Social">
                            <h3 class="{{ $headingClass }}">// Social</h3>
                            <ul class="grid gap-2.5">
                                @foreach (config('rural2rural.social') as $label => $href)
                                    <li><a href="{{ $href }}" target="_blank" rel="noopener" class="{{ $linkClass }} inline-flex items-center gap-2"><x-social-icon :platform="$label" class="size-3.5" />{{ $label }}</a></li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>

                    <div class="{{ $gutter }} flex flex-col gap-2 border-t border-white/15 py-5 font-mono text-[10px] tracking-[0.08em] uppercase sm:flex-row sm:justify-between">
                        <span class="text-lime">© {{ now()->year }} Rural2Rural</span>
                        <span class="text-white/60">Skills · Jobs · Careers · Entrepreneurship</span>
                    </div>
                </footer>
            </section>
        </main>
        {{-- ─────────────── Search ─────────────── --}}
        <script type="application/json" id="search-index">@json($searchIndex)</script>
        <dialog data-search-dialog aria-label="Search Rural2Rural" class="m-0 mx-auto mt-[12vh] w-[min(640px,calc(100vw-2rem))] max-w-none overflow-hidden bg-night p-0 text-white shadow-2xl ring-1 ring-white/15 backdrop:bg-night/70 backdrop:backdrop-blur-sm">
            <div class="flex items-center gap-3 border-b border-white/10 px-4">
                <svg viewBox="0 0 16 16" class="size-4 shrink-0 text-green" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="7" cy="7" r="4.5" /><path d="m10.5 10.5 3.5 3.5" /></svg>
                <input data-search-input type="search" placeholder="Search programmes, events, contact…" autocomplete="off" spellcheck="false" role="combobox" aria-expanded="true" aria-controls="search-results" aria-autocomplete="list" class="h-14 flex-1 bg-transparent text-[16px] outline-none placeholder:text-white/40">
                <button type="button" data-search-close class="font-mono text-[10px] tracking-[0.08em] text-white/50 uppercase hover:text-white">Esc</button>
            </div>
            <ul id="search-results" data-search-results role="listbox" class="max-h-[50vh] overflow-y-auto p-2"></ul>
            <div class="flex items-center justify-between border-t border-white/10 px-4 py-2.5 font-mono text-[9px] tracking-[0.08em] text-white/40 uppercase">
                <span>↑↓ navigate · ↵ open</span>
                <span class="text-green">// Ask r2rBot anything</span>
            </div>
        </dialog>

        {{-- ─────────────── Back to top ─────────────── --}}
        <button type="button" data-back-to-top aria-label="Back to top" class="pointer-events-none fixed bottom-5 left-4 z-40 grid size-11 lg:bottom-6 lg:left-[22px] translate-y-3 place-items-center rounded-full bg-night/90 text-white opacity-0 shadow-lg ring-1 ring-white/15 backdrop-blur transition duration-500 ease-out-expo hover:text-green [&.is-visible]:pointer-events-auto [&.is-visible]:translate-y-0 [&.is-visible]:opacity-100">
            <svg viewBox="0 0 44 44" class="absolute inset-0 size-full -rotate-90" aria-hidden="true">
                <circle cx="22" cy="22" r="20" fill="none" stroke="currentColor" stroke-opacity="0.15" stroke-width="2" />
                <circle data-back-to-top-progress cx="22" cy="22" r="20" fill="none" stroke="#7dbf45" stroke-width="2" pathLength="100" stroke-dasharray="100" stroke-dashoffset="100" />
            </svg>
            <svg viewBox="0 0 16 16" class="relative size-4" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M8 13V3M3.5 7.5 8 3l4.5 4.5" /></svg>
        </button>

        {{-- ─────────────── r2rBot ─────────────── --}}
        <div data-r2rbot data-endpoint="{{ route('r2rbot.chat') }}" class="fixed right-5 bottom-5 z-50 flex flex-col items-end gap-3">
            <section data-r2rbot-panel id="r2rbot-panel" aria-label="r2rBot chat" hidden class="flex h-[min(580px,calc(100svh-7rem))] w-[min(390px,calc(100vw-2.5rem))] flex-col overflow-hidden bg-night text-white shadow-2xl ring-1 ring-white/15 [&[hidden]]:hidden">
                <header class="glass-card shrink-0 p-0">
                    <div class="relative flex items-center gap-3 px-4 py-3">
                        <span class="relative">
                            <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-9 rounded-full ring-2 ring-white/40">
                            <span class="absolute -right-0.5 -bottom-0.5 size-2.5 rounded-full bg-lime ring-2 ring-navy"></span>
                        </span>
                        <span class="flex-1 leading-tight">
                            <span class="block text-[15px] font-medium">r2rBot</span>
                            <span class="block font-mono text-[9px] tracking-[0.1em] text-white/80 uppercase">Online // AI assistant</span>
                        </span>
                        <button type="button" data-r2rbot-reset class="grid size-8 place-items-center text-white/80 hover:text-white" aria-label="Start a new conversation" title="New conversation">
                            <svg viewBox="0 0 16 16" class="size-4" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M13 8a5 5 0 1 1-1.5-3.6M13 2.5v3h-3" /></svg>
                        </button>
                        <button type="button" data-r2rbot-close class="grid size-8 place-items-center text-white/80 hover:text-white" aria-label="Close r2rBot">
                            <svg viewBox="0 0 16 16" class="size-4" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="m4 4 8 8M12 4l-8 8" /></svg>
                        </button>
                    </div>
                </header>

                <div data-r2rbot-log role="log" aria-live="polite" class="flex flex-1 flex-col gap-3 overflow-y-auto px-4 py-5"></div>

                <div data-r2rbot-suggestions class="flex flex-wrap gap-2 px-4 pb-3">
                    @foreach (['What programmes do you run?', 'How can my school host a roadshow?', 'How do I contact R2R?'] as $suggestion)
                        <button type="button" data-r2rbot-suggestion class="border border-white/20 px-2.5 py-1.5 text-left text-[12px] text-white/80 transition-colors hover:border-green hover:text-green">{{ $suggestion }}</button>
                    @endforeach
                </div>

                <form data-r2rbot-form class="flex shrink-0 items-end gap-2 border-t border-white/10 p-3">
                    <label for="r2rbot-input" class="sr-only">Message r2rBot</label>
                    <textarea id="r2rbot-input" data-r2rbot-input rows="1" maxlength="{{ config('rural2rural.bot.max_message_length') }}" placeholder="Ask about programmes, events…" class="max-h-28 min-h-10 flex-1 resize-none bg-white/[0.06] px-3 py-2.5 text-[14px] ring-1 ring-white/10 outline-none placeholder:text-white/35 focus:ring-green"></textarea>
                    <button type="submit" data-r2rbot-send class="grid size-10 shrink-0 place-items-center bg-green text-night transition-colors hover:bg-lime disabled:opacity-40" aria-label="Send message">
                        <svg viewBox="0 0 16 16" class="size-4" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M2.5 8h11M9 3.5 13.5 8 9 12.5" /></svg>
                    </button>
                </form>
                <p class="shrink-0 px-4 pb-3 font-mono text-[8.5px] leading-snug tracking-[0.04em] text-white/35 uppercase">AI answers can be wrong. For official info contact {{ $contact['email'] }}</p>
            </section>

            <button type="button" data-r2rbot-toggle aria-expanded="false" aria-controls="r2rbot-panel" class="flex h-14 items-center gap-2.5 rounded-full bg-green pr-5 pl-2 text-night shadow-[0_10px_40px_-10px_rgba(125,191,69,0.7)] transition-transform duration-300 hover:-translate-y-0.5">
                <span class="relative">
                    <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-10 rounded-full">
                    <span class="animate-pulse-ring absolute inset-0 rounded-full bg-white/60" aria-hidden="true"></span>
                </span>
                <span data-r2rbot-toggle-label class="font-mono text-[12px] font-medium tracking-[0.06em]">Ask r2rBot</span>
            </button>
        </div>
    </body>
</html>
