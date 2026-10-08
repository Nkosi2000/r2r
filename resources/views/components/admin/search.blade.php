@props(['value' => '', 'placeholder' => 'Search'])

{{-- GET search box for an index page; keeps the results shareable via the URL. --}}
<form method="GET" role="search" class="mb-5 flex max-w-md gap-2">
    <label for="admin-search" class="sr-only">{{ $placeholder }}</label>
    <input id="admin-search" type="search" name="q" value="{{ $value }}" placeholder="{{ $placeholder }}" class="h-10 min-w-0 flex-1 border border-navy/20 bg-white px-3 text-[14px] outline-none placeholder:text-navy/40 focus-visible:border-blue focus-visible:ring-2 focus-visible:ring-blue/25">
    <button type="submit" class="h-10 cursor-pointer bg-navy px-4 font-mono text-[10px] tracking-[0.08em] text-white uppercase hover:bg-blue">Search</button>
    @if ($value !== '')
        <a href="{{ url()->current() }}" class="flex h-10 items-center px-2 text-[13px] text-navy/65 underline underline-offset-4">Clear</a>
    @endif
</form>
