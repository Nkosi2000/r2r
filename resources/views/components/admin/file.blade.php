@props(['name', 'label', 'currentUrl' => null, 'kind' => 'image', 'accept' => null, 'hint' => null])

{{--
    File upload with a preview of the current file. "kind" (image, video or document) decides the preview.
    Choosing a new image shows it immediately (see resources/js/admin.js).
--}}
@php
    $id = 'field-'.$name;
    $previewId = $id.'-preview';
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'grid content-start gap-1.5']) }}>
    <label for="{{ $id }}" class="text-[13px] font-medium">{{ $label }}@if ($attributes->get('required'))<span class="text-red-600" aria-hidden="true"> *</span>@endif</label>

    @if ($kind === 'image')
        <img id="{{ $previewId }}" src="{{ $currentUrl }}" alt="" @if (! $currentUrl) hidden @endif class="max-h-40 w-auto max-w-full border border-navy/10 bg-white object-contain p-2">
    @elseif ($currentUrl && $kind === 'video')
        <video src="{{ $currentUrl }}" controls preload="metadata" class="max-h-48 w-full max-w-md bg-night"></video>
    @elseif ($currentUrl)
        <a href="{{ $currentUrl }}" target="_blank" rel="noopener" class="text-[13px] text-blue underline underline-offset-4">View current file <span aria-hidden="true">↗</span></a>
    @endif

    <input
        id="{{ $id }}"
        name="{{ $name }}"
        type="file"
        @if ($accept) accept="{{ $accept }}" @endif
        @if ($kind === 'image') data-preview="{{ $previewId }}" @endif
        @if ($hint) aria-describedby="{{ $id }}-hint" @endif
        @error($name) aria-invalid="true" @enderror
        {{ $attributes->except('class')->merge(['class' => 'block w-full cursor-pointer border border-dashed bg-white p-3 text-[13px] text-navy/70 file:mr-4 file:cursor-pointer file:border-0 file:bg-navy file:px-4 file:py-2 file:font-mono file:text-[10px] file:tracking-[0.08em] file:text-white file:uppercase '.($errors->has($name) ? 'border-red-500' : 'border-navy/25')]) }}
    >
    @if ($hint)
        <p id="{{ $id }}-hint" class="text-[12px] text-navy/55">{{ $hint }}@if ($currentUrl) Leave empty to keep the current file.@endif</p>
    @endif
    @error($name)
        <p class="text-[12px] text-red-600">{{ $message }}</p>
    @enderror
</div>
