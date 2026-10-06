@props(['first'])

{{-- Two-line mono tag, e.g. "HOW IT" / "// WORKS". --}}
<p {{ $attributes->merge(['class' => 'tag']) }}>
    <span class="block">{{ $first }}</span>
    <span class="block">// {{ $slot }}</span>
</p>
