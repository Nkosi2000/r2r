@props(['action', 'method' => 'POST', 'submit' => 'Save', 'cancel' => null, 'files' => false, 'fields' => null])

{{--
    Content form card with CSRF, method spoofing and Save / Cancel actions.
    When several forms share a page, "fields" lists the field names this form owns so only it shows the error summary.
--}}
@php
    $hasErrors = collect($errors->keys())
        ->reject(fn (string $key): bool => $key === 'user')
        ->contains(fn (string $key): bool => $fields === null || Str::startsWith($key, $fields));
@endphp

<form method="POST" action="{{ $action }}" @if ($files) enctype="multipart/form-data" @endif {{ $attributes->merge(['class' => 'max-w-3xl border border-navy/10 bg-white']) }}>
    @csrf
    @if (strtoupper($method) !== 'POST')
        @method($method)
    @endif

    @if ($hasErrors)
        <p role="alert" class="border-b border-red-200 bg-red-50 px-6 py-3 text-[13px] text-red-700">Please fix the highlighted fields and save again.</p>
    @endif

    <div class="grid gap-6 p-6 sm:p-8">
        {{ $slot }}
    </div>

    <div class="flex flex-wrap items-center gap-4 border-t border-navy/10 bg-paper/60 px-6 py-4 sm:px-8">
        <x-button type="submit" variant="navy">{{ $submit }}</x-button>
        @if ($cancel)
            <a href="{{ $cancel }}" class="text-[13px] text-navy/65 underline underline-offset-4 hover:text-navy">Cancel</a>
        @endif
    </div>
</form>
