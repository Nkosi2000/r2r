@props(['message'])

{{-- Empty state for an index page, with an optional action in the slot. --}}
<div class="flex flex-col items-start gap-4 border border-dashed border-navy/25 bg-white p-8">
    <p class="text-[14px] text-navy/70">{{ $message }}</p>
    {{ $slot }}
</div>
