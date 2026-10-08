@props(['title'])

@php
    $navigation = [
        'Overview' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ],
        'Content' => [
            ['label' => 'Pillars', 'route' => 'admin.pillars.index', 'active' => 'admin.pillars.*'],
            ['label' => 'Programmes', 'route' => 'admin.programmes.index', 'active' => 'admin.programmes.*'],
            ['label' => 'Partners', 'route' => 'admin.partners.index', 'active' => 'admin.partners.*'],
            ['label' => 'Events', 'route' => 'admin.events.index', 'active' => 'admin.events.*'],
            ['label' => 'Media', 'route' => 'admin.media.index', 'active' => 'admin.media.*'],
            ['label' => 'Resources', 'route' => 'admin.resources.index', 'active' => 'admin.resources.*'],
            ['label' => 'Reports', 'route' => 'admin.reports.index', 'active' => 'admin.reports.*'],
        ],
    ];

    if (auth()->user()->can('manage-staff') || auth()->user()->can('manage-settings')) {
        $navigation['Administration'] = array_values(array_filter([
            auth()->user()->can('manage-settings') ? ['label' => 'Site settings', 'route' => 'admin.settings.edit', 'active' => 'admin.settings.*'] : null,
            auth()->user()->can('manage-staff') ? ['label' => 'Staff', 'route' => 'admin.users.index', 'active' => 'admin.users.*'] : null,
        ]));
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }} · Rural2Rural CMS</title>
        <link rel="icon" type="image/png" href="{{ asset('images/r2r/favicon.png') }}">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/admin.js'])
    </head>
    <body class="min-h-screen bg-paper text-navy">
        <a href="#admin-main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:bg-white focus:px-4 focus:py-2">Skip to content</a>

        <div class="lg:grid lg:min-h-screen lg:grid-cols-[248px_1fr]">
            {{-- ─────────────── Sidebar ─────────────── --}}
            <aside class="bg-night text-white lg:sticky lg:top-0 lg:flex lg:h-screen lg:flex-col">
                <div class="flex h-16 items-center justify-between gap-3 px-5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                        <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-8 rounded-full bg-white">
                        <span class="leading-none">
                            <span class="block text-[15px] font-medium tracking-[-0.02em]">Rural2Rural</span>
                            <span class="font-mono text-[9px] tracking-[0.12em] text-green uppercase">Content manager</span>
                        </span>
                    </a>
                    <button type="button" data-admin-nav-toggle aria-expanded="false" aria-controls="admin-nav" class="flex h-9 items-center gap-2 border border-white/25 px-3 font-mono text-[10px] tracking-[0.1em] uppercase lg:hidden">
                        <span data-admin-nav-label>Menu</span>
                    </button>
                </div>

                <nav id="admin-nav" data-admin-nav aria-label="CMS" class="hidden border-t border-white/10 px-3 pb-4 lg:flex lg:flex-1 lg:flex-col lg:overflow-y-auto">
                    @foreach ($navigation as $group => $links)
                        <p class="mt-5 mb-1.5 px-3 font-mono text-[9px] tracking-[0.14em] text-white/40 uppercase">{{ $group }}</p>
                        <ul>
                            @foreach ($links as $link)
                                @php($isActive = request()->routeIs($link['active']))
                                <li>
                                    <a href="{{ route($link['route']) }}" @if ($isActive) aria-current="page" @endif class="flex items-center gap-2.5 px-3 py-2 text-[14px] transition-colors {{ $isActive ? 'bg-white/10 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                                        <span class="size-1.5 {{ $isActive ? 'bg-green' : 'bg-white/20' }}" aria-hidden="true"></span>{{ $link['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endforeach

                    <div class="mt-8 border-t border-white/10 pt-4 lg:mt-auto">
                        <p class="px-3 text-[13px] text-white">{{ auth()->user()->name }}</p>
                        <p class="px-3 font-mono text-[9px] tracking-[0.12em] text-green uppercase">{{ auth()->user()->role->label() }}</p>
                        <ul class="mt-3 text-[13px]">
                            <li><a href="{{ route('admin.profile.edit') }}" class="block px-3 py-1.5 text-white/70 hover:text-white">Your account</a></li>
                            <li><a href="{{ route('home') }}" target="_blank" rel="noopener" class="block px-3 py-1.5 text-white/70 hover:text-white">View website <span aria-hidden="true">↗</span></a></li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full cursor-pointer px-3 py-1.5 text-left text-white/70 hover:text-white">Sign out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </nav>
            </aside>

            {{-- ─────────────── Page ─────────────── --}}
            <main id="admin-main" tabindex="-1" class="min-w-0 px-4 py-8 outline-none sm:px-8 lg:px-12 lg:py-10">
                @if (session('status'))
                    <div role="status" class="mb-6 flex items-center gap-3 border-l-4 border-green bg-white px-4 py-3 text-[14px] shadow-sm">
                        <span class="size-1.5 shrink-0 bg-green" aria-hidden="true"></span>{{ session('status') }}
                    </div>
                @endif

                @error('user')
                    <div role="alert" class="mb-6 border-l-4 border-red-600 bg-white px-4 py-3 text-[14px] text-red-700 shadow-sm">{{ $message }}</div>
                @enderror

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
