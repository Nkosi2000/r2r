@props([
    'title' => null,
    'description' => null,
    'preloader' => false,
])

@php
    $navigation = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'Who We Are', 'route' => 'about'],
        ['label' => 'What We Do', 'route' => 'what-we-do'],
        ['label' => 'Our Partners', 'route' => 'partners'],
        ['label' => 'Media', 'route' => 'media'],
        ['label' => 'Events', 'route' => 'events'],
        ['label' => 'Resources', 'route' => 'resources'],
        ['label' => 'Reports', 'route' => 'reports'],
        ['label' => 'Contact Us', 'route' => 'contact'],
    ];

    $searchIndex = [
        ['title' => 'Home', 'kind' => 'Page', 'href' => route('home'), 'keywords' => 'start landing rural2rural r2r'],
        ['title' => 'Who we are', 'kind' => 'Page', 'href' => route('about'), 'keywords' => 'about mission vision rural south africa youth women disabilities'],
        ['title' => 'What we do', 'kind' => 'Page', 'href' => route('what-we-do'), 'keywords' => 'programmes pillars careers skills entrepreneurship teachers how we work'],
        ['title' => 'Our partners', 'kind' => 'Page', 'href' => route('partners'), 'keywords' => 'seta sponsors supporters funders partner with us'],
        ['title' => 'Media', 'kind' => 'Page', 'href' => route('media'), 'keywords' => 'gallery photos videos magazine connect'],
        ['title' => 'Events', 'kind' => 'Page', 'href' => route('events'), 'keywords' => 'events expo roadshow map provinces upcoming past'],
        ['title' => 'Resources', 'kind' => 'Page', 'href' => route('resources'), 'keywords' => 'bursaries nsfas jobs learnerships links'],
        ['title' => 'Reports', 'kind' => 'Page', 'href' => route('reports'), 'keywords' => 'annual impact reports documents'],
        ['title' => 'Contact us', 'kind' => 'Page', 'href' => route('contact'), 'keywords' => 'address phone email office centurion directions'],
        ...$partners->map(fn (App\Models\Partner $partner): array => ['title' => $partner->name, 'kind' => 'Partner', 'href' => route('partners'), 'keywords' => $partner->description])->all(),
        ...$pillars->map(fn (App\Models\Pillar $pillar): array => ['title' => $pillar->title, 'kind' => 'Pillar', 'href' => route('what-we-do'), 'keywords' => $pillar->body])->all(),
        ...$programmes->map(fn (App\Models\Programme $programme): array => ['title' => $programme->title, 'kind' => 'Programme', 'href' => route('what-we-do'), 'keywords' => $programme->pillar])->all(),
        ...$upcomingEvents->concat($pastEvents)->map(fn (App\Models\Event $event): array => ['title' => $event->title.' · '.$event->place, 'kind' => 'Event', 'href' => route('events'), 'keywords' => $event->date])->all(),
        ['title' => 'Email '.$contact['email'], 'kind' => 'Contact', 'href' => 'mailto:'.$contact['email'], 'keywords' => 'email mail message'],
        ['title' => 'Call '.$contact['phone'], 'kind' => 'Contact', 'href' => 'tel:'.str_replace(' ', '', $contact['phone']), 'keywords' => 'phone call telephone office'],
        ['title' => 'Mobile '.$contact['mobile'], 'kind' => 'Contact', 'href' => 'tel:'.str_replace(' ', '', $contact['mobile']), 'keywords' => 'mobile cell whatsapp phone'],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <x-seo :title="$title" :description="$description" />
        <meta name="theme-color" content="#0c1035">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/r2r/favicon.png') }}">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if ($preloader)
            {{-- The intro plays once per browser session; skip it before first paint after that --}}
            <script>try { if (sessionStorage.getItem('r2r-intro-seen')) { document.documentElement.classList.add('intro-seen'); } } catch (error) {}</script>
        @endif
    </head>
    <body class="overflow-x-clip">
        @if ($preloader)
            {{-- ─────────────── Preloader: a neural brain assembles while the page loads ─────────────── --}}
            <noscript><style>[data-preloader] { display: none; }</style></noscript>
            <div data-preloader role="status" aria-label="Loading Rural2Rural" class="fixed inset-0 z-[100] flex flex-col overflow-hidden bg-night">
                <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                    <div class="absolute top-1/4 left-1/4 h-1/2 w-1/3 rounded-full bg-sky/25 blur-[120px]"></div>
                    <div class="absolute top-1/3 left-1/2 h-1/3 w-1/4 rounded-full bg-green/20 blur-[120px]"></div>
                </div>
                <div class="scanlines pointer-events-none absolute inset-0" aria-hidden="true"></div>

                <div class="preloader-ui relative flex h-16 items-center justify-between px-4 sm:px-8">
                    <span class="flex items-center gap-2.5">
                        <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-9 rounded-full bg-white">
                        <span class="text-[17px] font-medium tracking-[-0.02em]">Rural2Rural</span>
                    </span>
                    <span class="flex items-center gap-2 font-mono text-[10px] tracking-[0.1em] text-white/60 uppercase"><i class="animate-blink size-1.5 bg-lime"></i>Initialising</span>
                </div>

                <div class="relative flex-1" aria-hidden="true">
                    <canvas data-neural-brain class="absolute inset-0 size-full"></canvas>
                    <div class="preloader-ui absolute inset-0">
                        @foreach ($pillars->take(4)->values()->zip([
                            'top-[22%] left-[8%] sm:left-[16%]',
                            'top-[26%] right-[8%] text-right sm:right-[16%]',
                            'bottom-[20%] left-[8%] sm:left-[18%]',
                            'bottom-[16%] right-[8%] text-right sm:right-[18%]',
                        ]) as [$pillar, $position])
                            <span class="preloader-label absolute {{ $position }} font-mono text-[9px] leading-tight tracking-[0.1em] text-white/70 uppercase" style="animation-delay: {{ 900 + $loop->index * 400 }}ms">
                                <span class="block text-green">{{ sprintf('%02d', $loop->iteration) }} //</span>{{ $pillar->verb }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="preloader-ui relative flex items-end justify-between gap-6 px-4 pb-6 sm:px-8">
                    <p class="tag">Growing rural minds<br>// Skills · Jobs · Careers</p>
                    <p class="text-[clamp(3rem,9vw,6.5rem)] leading-none font-light tracking-[-0.04em] tabular-nums"><span data-preloader-count>000</span><span class="text-green">%</span></p>
                </div>
                <div class="preloader-ui relative h-px bg-white/10">
                    <span data-preloader-bar class="absolute inset-0 origin-left bg-green" style="scale: 0 1"></span>
                </div>
            </div>
        @endif

        {{-- ─────────────── Header ─────────────── --}}
        <header id="site-header" class="group/header fixed inset-x-0 top-0 z-50 border-b border-transparent transition-colors duration-500 [&.is-scrolled]:border-white/10 [&.is-scrolled]:bg-night/80 [&.is-scrolled]:backdrop-blur-md [&.is-light]:border-navy/10 [&.is-light]:bg-paper/85">
            <div class="flex h-16 items-center justify-between gap-6 px-4 sm:px-8">
                <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5 text-white transition-colors group-[.is-light]/header:text-navy" aria-label="Rural2Rural home">
                    <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-9 rounded-full bg-white">
                    <span class="leading-none">
                        <span class="block text-[17px] font-medium tracking-[-0.02em]">Rural2Rural</span>
                        <span class="mt-1 block font-mono text-[8px] tracking-[0.3em] text-green uppercase">Initiative</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-5 xl:flex 2xl:gap-8" aria-label="Primary">
                    @foreach ($navigation as $item)
                        <a href="{{ route($item['route']) }}" @if (request()->routeIs($item['route'])) aria-current="page" @endif class="font-mono text-[11px] tracking-[0.08em] whitespace-nowrap uppercase transition-colors hover:text-green aria-[current=page]:text-green {{ request()->routeIs($item['route']) ? '' : 'text-white/85 group-[.is-light]/header:text-navy/80' }}">{{ $item['label'] }}</a>
                    @endforeach
                </nav>

                <div class="flex items-center gap-3">
                    <button type="button" data-search-open class="flex h-9 items-center gap-2 border border-white/25 px-2.5 text-white transition-colors group-[.is-light]/header:border-navy/30 group-[.is-light]/header:text-navy hover:border-green hover:text-green" aria-label="Search the site" aria-keyshortcuts="Control+K /">
                        <svg viewBox="0 0 16 16" class="size-4" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="7" cy="7" r="4.5" /><path d="m10.5 10.5 3.5 3.5" /></svg>
                        <kbd class="hidden font-mono text-[10px] tracking-[0.06em] opacity-60 2xl:inline">Ctrl K</kbd>
                    </button>
                    <a href="{{ $mailPartner }}" class="hidden font-mono text-[11px] tracking-[0.08em] whitespace-nowrap text-green uppercase underline decoration-green/60 underline-offset-4 hover:decoration-green sm:inline xl:hidden 2xl:inline">Partner with us</a>
                    <button type="button" data-menu-toggle aria-expanded="false" aria-controls="mobile-menu" class="flex h-9 items-center gap-2 border border-white/25 px-3 font-mono text-[11px] tracking-[0.08em] text-white uppercase group-[.is-light]/header:border-navy/30 group-[.is-light]/header:text-navy xl:hidden">
                        <span data-menu-label>Menu</span>
                        <svg viewBox="0 0 16 16" class="size-3.5" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M2 5h12M2 11h12" /></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile menu: numbered panel with "+" markers --}}
            <nav id="mobile-menu" data-menu class="mx-3 mb-3 hidden max-h-[calc(100svh-5rem)] overflow-y-auto bg-white text-navy shadow-2xl xl:hidden" aria-label="Mobile">
                <ul class="px-5 pt-2">
                    @foreach ($navigation as $item)
                        <li class="border-b border-navy/10">
                            <a href="{{ route($item['route']) }}" @if (request()->routeIs($item['route'])) aria-current="page" @endif class="flex items-center justify-between py-3 text-[20px] tracking-[-0.02em] aria-[current=page]:text-blue">
                                <span><sup class="mr-2 font-mono text-[10px] text-navy/50">{{ sprintf('%02d', $loop->iteration) }}</sup>{{ $item['label'] }}</span>
                                <span class="text-xl font-light text-navy/60" aria-hidden="true">+</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <ul class="flex items-center gap-2 px-5 pt-5" aria-label="Rural2Rural on social media">
                    @foreach ($social as $label => $href)
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
                @foreach ($social as $label => $href)
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
            {{ $slot }}

            {{-- ─────────────── Closing glow ─────────────── --}}
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
                <footer class="relative border-t border-white/15">
                    <span class="rail-node" aria-hidden="true"></span>
                    @php
                        $linkClass = 'font-mono text-[11px] tracking-[0.06em] uppercase transition-colors hover:text-green';
                        $headingClass = 'mb-4 font-mono text-[11px] tracking-[0.08em] text-lime uppercase';
                    @endphp
                    <div class="{{ $gutter }} grid gap-10 py-14 sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1.3fr_0.8fr]">
                        <div>
                            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="Rural2Rural home">
                                <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-11 rounded-full bg-white">
                                <span class="text-2xl tracking-[-0.02em]">Rural2Rural</span>
                            </a>
                            <p class="mt-4 max-w-[16rem] text-[13px] text-white/60">Skills, Jobs, Careers &amp; Entrepreneurship Initiative. Delivering real opportunities to rural communities.</p>
                        </div>

                        <nav aria-label="Programmes">
                            <h3 class="{{ $headingClass }}">// Programmes</h3>
                            <ul class="grid gap-2.5">
                                @foreach ($pillars as $pillar)
                                    <li><a href="{{ route('what-we-do') }}" class="{{ $linkClass }}">{{ $pillar->title }}</a></li>
                                @endforeach
                            </ul>
                        </nav>

                        <nav aria-label="Organisation">
                            <h3 class="{{ $headingClass }}">// Organisation</h3>
                            <ul class="grid gap-2.5">
                                @foreach (array_slice($navigation, 1) as $item)
                                    <li><a href="{{ route($item['route']) }}" class="{{ $linkClass }}">{{ $item['label'] }}</a></li>
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
                                @foreach ($social as $label => $href)
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

            <button type="button" data-r2rbot-toggle aria-expanded="false" aria-controls="r2rbot-panel" class="flex h-10 items-center gap-2 rounded-full bg-green pr-3.5 pl-1 text-night shadow-[0_8px_28px_-10px_rgba(125,191,69,0.7)] transition-transform duration-300 hover:-translate-y-0.5">
                <span class="relative">
                    <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-8 rounded-full">
                    <span class="animate-pulse-ring absolute inset-0 rounded-full bg-white/60" aria-hidden="true"></span>
                </span>
                <span data-r2rbot-toggle-label class="font-mono text-[11px] font-medium tracking-[0.06em]">Ask r2rBot</span>
            </button>
        </div>
    </body>
</html>
