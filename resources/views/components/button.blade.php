@props([
    'href' => '#',
    'variant' => 'primary',
])

{{--
    Mono uppercase button with a "↳" lead.
    variant "primary" → logo-green plate.
    variant "outline" → hairline border for dark backgrounds.
    variant "navy"    → navy plate for light backgrounds.
--}}
@php
    $classes = match ($variant) {
        'outline' => 'border border-white/30 text-white hover:border-green hover:text-green',
        'navy' => 'bg-navy text-white hover:bg-blue',
        default => 'bg-green text-night hover:bg-lime',
    };
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => "group inline-flex h-10 items-center gap-2.5 px-4 font-mono text-[11px] font-medium tracking-[0.08em] uppercase transition-colors duration-300 {$classes}"]) }}>
    <span class="transition-transform duration-300 group-hover:translate-x-0.5" aria-hidden="true">↳</span>
    {{ $slot }}
</a>
