@props(['name', 'label', 'value' => null, 'hint' => null, 'rows' => 4])

{{-- Labelled multi-line input with its validation error (see x-admin.input for nested names). A list value is shown one item per line. --}}
@php
    $key = str_replace(['[', ']'], ['.', ''], $name);
    $id = 'field-'.str_replace('.', '-', $key);
    $hasError = $errors->has($key) || $errors->has($key.'.*');
    $current = old($key, $value);
    $current = is_array($current) ? implode("\n", $current) : $current;
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'grid content-start gap-1.5']) }}>
    <label for="{{ $id }}" class="text-[13px] font-medium">{{ $label }}@if ($attributes->get('required'))<span class="text-red-600" aria-hidden="true"> *</span>@endif</label>
    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        @if ($hint) aria-describedby="{{ $id }}-hint" @endif
        @if ($hasError) aria-invalid="true" @endif
        {{ $attributes->except('class')->merge(['class' => 'w-full border bg-white px-3 py-2.5 text-[14px] leading-relaxed text-navy outline-none focus-visible:border-blue focus-visible:ring-2 focus-visible:ring-blue/25 '.($hasError ? 'border-red-500' : 'border-navy/20')]) }}
    >{{ $current }}</textarea>
    @if ($hint)
        <p id="{{ $id }}-hint" class="text-[12px] text-navy/55">{{ $hint }}</p>
    @endif
    @foreach ($errors->get($key) + $errors->get($key.'.*') as $messages)
        @foreach ((array) $messages as $message)
            <p class="text-[12px] text-red-600">{{ $message }}</p>
        @endforeach
    @endforeach
</div>
