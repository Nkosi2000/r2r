@props([
    'href' => '#',
    'variant' => 'primary',
])

{{--
    Mono uppercase button with a "↳" lead.
    variant "primary" → logo-green plate.
    variant "outline" → hairline border for dark backgrounds.
    variant "navy"    → navy plate for light backgrounds.
    Passing a type (e.g. type="submit") renders a <button> instead of a link.
--}}
@php
    $classes = match ($variant) {
        'outline' => 'border border-white/30 text-white hover:border-green hover:text-green',
        'navy' => 'bg-navy text-white hover:bg-blue',
        default => 'bg-green text-night hover:bg-lime',
    };
    $attributes = $attributes->merge(['class' => "group inline-flex h-10 cursor-pointer items-center gap-2.5 px-4 font-mono text-[11px] font-medium tracking-[0.08em] uppercase transition-colors duration-300 {$classes}"]);
@endphp

@if ($attributes->has('type'))
    <button {{ $attributes }}>
        <span class="transition-transform duration-300 group-hover:translate-x-0.5" aria-hidden="true">↳</span>
        {{ $slot }}
    </button>
@else
    <a href="{{ $href }}" {{ $attributes }}>
        <span class="transition-transform duration-300 group-hover:translate-x-0.5" aria-hidden="true">↳</span>
        {{ $slot }}
    </a>
@endif
