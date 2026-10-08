@props(['name', 'label', 'value' => null, 'type' => 'text', 'hint' => null, 'options' => null])

{{--
    Labelled text input with its validation error. "name" may be nested (postal[locality]);
    old input and errors are looked up by its dot form (postal.locality).
    "options" adds a list of suggestions the user can pick from or ignore.
--}}
@php
    $key = str_replace(['[', ']'], ['.', ''], $name);
    $id = 'field-'.str_replace('.', '-', $key);
    $listId = $options ? $id.'-options' : null;
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'grid content-start gap-1.5']) }}>
    <label for="{{ $id }}" class="text-[13px] font-medium">{{ $label }}@if ($attributes->get('required'))<span class="text-red-600" aria-hidden="true"> *</span>@endif</label>
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ $type === 'password' ? '' : old($key, $value instanceof BackedEnum ? $value->value : $value) }}"
        @if ($listId) list="{{ $listId }}" @endif
        @if ($hint) aria-describedby="{{ $id }}-hint" @endif
        @error($key) aria-invalid="true" @enderror
        {{ $attributes->except('class')->merge(['class' => 'h-10 w-full border bg-white px-3 text-[14px] text-navy outline-none placeholder:text-navy/35 focus-visible:border-blue focus-visible:ring-2 focus-visible:ring-blue/25 '.($errors->has($key) ? 'border-red-500' : 'border-navy/20')]) }}
    >
    @if ($listId)
        <datalist id="{{ $listId }}">
            @foreach ($options as $option)
                <option value="{{ $option }}"></option>
            @endforeach
        </datalist>
    @endif
    @if ($hint)
        <p id="{{ $id }}-hint" class="text-[12px] text-navy/55">{{ $hint }}</p>
    @endif
    @error($key)
        <p class="text-[12px] text-red-600">{{ $message }}</p>
    @enderror
</div>
