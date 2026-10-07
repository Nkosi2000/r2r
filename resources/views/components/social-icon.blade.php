@props(['platform'])

{{-- Brand glyph for a social platform, matched on the platform label stored in the "social" site setting. --}}
@php
    $platformKey = str($platform)->lower();
@endphp

<svg {{ $attributes->merge(['viewBox' => '0 0 24 24', 'fill' => 'currentColor', 'aria-hidden' => 'true']) }}>
    @if ($platformKey->contains('facebook'))
        <path d="M13.5 21v-7.5h2.6l.4-3h-3V8.6c0-.9.3-1.5 1.5-1.5h1.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.3H7.9v3h2.6V21h3Z" />
    @elseif ($platformKey->contains('instagram'))
        <path d="M12 7.4a4.6 4.6 0 1 0 0 9.2 4.6 4.6 0 0 0 0-9.2Zm0 7.6a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm4.8-8.9a1.1 1.1 0 1 0 0 2.2 1.1 1.1 0 0 0 0-2.2ZM12 3c-2.4 0-2.7 0-3.7.1-3.3.1-5.1 2-5.2 5.2C3 9.3 3 9.6 3 12s0 2.7.1 3.7c.1 3.2 2 5.1 5.2 5.2 1 .1 1.3.1 3.7.1s2.7 0 3.7-.1c3.2-.1 5.1-2 5.2-5.2.1-1 .1-1.3.1-3.7s0-2.7-.1-3.7c-.1-3.2-2-5.1-5.2-5.2C14.7 3 14.4 3 12 3Zm0 1.6c2.4 0 2.7 0 3.6.1 2.4.1 3.6 1.3 3.7 3.7.1.9.1 1.2.1 3.6s0 2.7-.1 3.6c-.1 2.4-1.3 3.6-3.7 3.7-.9.1-1.2.1-3.6.1s-2.7 0-3.6-.1c-2.5-.1-3.6-1.3-3.7-3.7C4.6 14.7 4.6 14.4 4.6 12s0-2.7.1-3.6c.1-2.5 1.3-3.6 3.7-3.7.9-.1 1.2-.1 3.6-.1Z" />
    @elseif ($platformKey->contains('twitter') || $platformKey->exactly('x'))
        <path d="M17.2 3.5h2.9l-6.4 7.3 7.5 9.7h-5.9l-4.6-6-5.3 6H2.5l6.8-7.8L2.1 3.5h6l4.2 5.5 4.9-5.5Zm-1 15.3h1.6L7.9 5.1H6.1l10.1 13.7Z" />
    @else
        <circle cx="12" cy="12" r="8" fill="none" stroke="currentColor" stroke-width="1.6" />
    @endif
</svg>
