@php
    $isEditing = $mediaItem->exists;
    $type = $mediaItem->type;
    $file = match ($type) {
        App\Enums\MediaType::Video => ['label' => 'Video file', 'kind' => 'video', 'accept' => 'video/mp4,video/webm', 'hint' => 'MP4 or WebM, up to 100 MB.'],
        App\Enums\MediaType::Publication => ['label' => 'Cover image', 'kind' => 'image', 'accept' => 'image/png,image/jpeg,image/webp', 'hint' => 'JPG, PNG or WebP, up to 5 MB.'],
        default => ['label' => 'Photo', 'kind' => 'image', 'accept' => 'image/png,image/jpeg,image/webp', 'hint' => 'JPG, PNG or WebP, up to 5 MB. Landscape photos around 1600px wide work best.'],
    };
    $subtitleLabel = match ($type) {
        App\Enums\MediaType::Video => 'Place',
        App\Enums\MediaType::Publication => 'Edition',
        default => 'Subtitle',
    };
    $pageTitle = ($isEditing ? 'Edit ' : 'Add ').strtolower($type->name);
@endphp

<x-layouts.admin :title="$pageTitle">
    <x-admin.page-header :title="$pageTitle" :back="route('admin.media.index', ['type' => $type])" />

    <x-admin.form :action="$isEditing ? route('admin.media.update', $mediaItem) : route('admin.media.store')" :method="$isEditing ? 'PUT' : 'POST'" :submit="$isEditing ? 'Save changes' : 'Upload'" :cancel="route('admin.media.index', ['type' => $type])" files>
        @unless ($isEditing)
            <input type="hidden" name="type" value="{{ $type->value }}">
        @endunless
        <x-admin.input name="title" label="Title" :value="$mediaItem->title" :hint="$type === App\Enums\MediaType::Photo ? 'Also used as the image description for screen readers.' : null" required />
        <x-admin.input name="subtitle" :label="$subtitleLabel" :value="$mediaItem->subtitle" />
        <x-admin.file name="file" :label="$file['label']" :kind="$file['kind']" :current-url="$isEditing ? $mediaItem->url : null" :accept="$file['accept']" :hint="$file['hint']" :required="! $isEditing" />
    </x-admin.form>
</x-layouts.admin>
