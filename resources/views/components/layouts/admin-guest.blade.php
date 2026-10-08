@props(['title'])

{{-- Signed-out CMS pages: sign in, forgot password, reset password. --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <title>{{ $title }} · Rural2Rural CMS</title>
        <link rel="icon" type="image/png" href="{{ asset('images/r2r/favicon.png') }}">

        @fonts

        @vite(['resources/css/app.css'])
    </head>
    <body class="grid min-h-screen place-items-center bg-night px-4 py-12 text-white">
        <div class="scanlines pointer-events-none fixed inset-0" aria-hidden="true"></div>
        <main class="relative w-full max-w-sm">
            <a href="{{ route('home') }}" class="mb-8 flex items-center gap-3">
                <img src="{{ asset('images/r2r/mark.png') }}" alt="" class="size-11 rounded-full bg-white">
                <span class="leading-none">
                    <span class="block text-xl tracking-[-0.02em]">Rural2Rural</span>
                    <span class="font-mono text-[10px] tracking-[0.12em] text-green uppercase">Content manager</span>
                </span>
            </a>

            <div class="bg-white p-6 text-navy shadow-2xl sm:p-8">
                <h1 class="text-2xl tracking-[-0.02em]">{{ $title }}</h1>

                @if (session('status'))
                    <p role="status" class="mt-4 border-l-4 border-green bg-paper px-3 py-2 text-[13px]">{{ session('status') }}</p>
                @endif

                <div class="mt-6">{{ $slot }}</div>
            </div>
        </main>
    </body>
</html>
