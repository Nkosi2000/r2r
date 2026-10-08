@props(['name', 'label', 'options', 'value' => null, 'hint' => null, 'placeholder' => null])

{{-- Labelled dropdown. "options" maps each value to its label. --}}
@php
    $key = str_replace(['[', ']'], ['.', ''], $name);
    $id = 'field-'.str_replace('.', '-', $key);
    $selected = (string) old($key, $value instanceof BackedEnum ? $value->value : $value);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'grid content-start gap-1.5']) }}>
    <label for="{{ $id }}" class="text-[13px] font-medium">{{ $label }}@if ($attributes->get('required'))<span class="text-red-600" aria-hidden="true"> *</span>@endif</label>
    <select
        id="{{ $id }}"
        name="{{ $name }}"
        @if ($hint) aria-describedby="{{ $id }}-hint" @endif
        @error($key) aria-invalid="true" @enderror
        {{ $attributes->except('class')->merge(['class' => 'h-10 w-full border bg-white px-3 text-[14px] text-navy outline-none focus-visible:border-blue focus-visible:ring-2 focus-visible:ring-blue/25 '.($errors->has($key) ? 'border-red-500' : 'border-navy/20')]) }}
    >
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @selected($selected === (string) $optionValue)>{{ $optionLabel }}</option>
        @endforeach
    </select>
    @if ($hint)
        <p id="{{ $id }}-hint" class="text-[12px] text-navy/55">{{ $hint }}</p>
    @endif
    @error($key)
        <p class="text-[12px] text-red-600">{{ $message }}</p>
    @enderror
</div>
