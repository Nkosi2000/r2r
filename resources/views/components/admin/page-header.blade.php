@props(['title', 'description' => null, 'back' => null])

{{-- Page title with an optional back link and actions (e.g. an "Add" button) in the slot. --}}
<header class="mb-8 flex flex-wrap items-end justify-between gap-4">
    <div>
        @if ($back)
            <a href="{{ $back }}" class="font-mono text-[10px] tracking-[0.1em] text-navy/55 uppercase hover:text-blue"><span aria-hidden="true">←</span> Back</a>
        @endif
        <h1 class="mt-1 text-[clamp(1.6rem,2.6vw,2.2rem)] leading-tight tracking-[-0.025em]">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1.5 max-w-2xl text-[14px] text-navy/65">{{ $description }}</p>
        @endif
    </div>
    @if ($slot->isNotEmpty())
        <div class="flex flex-wrap items-center gap-3">{{ $slot }}</div>
    @endif
</header>
