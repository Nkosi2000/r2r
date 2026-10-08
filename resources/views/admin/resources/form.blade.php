@php($isEditing = $resourceLink->exists)

<x-layouts.admin :title="$isEditing ? 'Edit resource' : 'Add resource'">
    <x-admin.page-header :title="$isEditing ? 'Edit resource' : 'Add resource'" :back="route('admin.resources.index')" />

    <x-admin.form :action="$isEditing ? route('admin.resources.update', $resourceLink) : route('admin.resources.store')" :method="$isEditing ? 'PUT' : 'POST'" :submit="$isEditing ? 'Save changes' : 'Add resource'" :cancel="route('admin.resources.index')">
        <x-admin.input name="group" label="Heading" :value="$resourceLink->group" :options="$groupNames" hint="Pick an existing heading or type a new one." required />
        <x-admin.input name="title" label="Title" :value="$resourceLink->title" required />
        <x-admin.textarea name="description" label="Description" :value="$resourceLink->description" rows="3" required />
        <x-admin.input name="url" label="Link" type="url" :value="$resourceLink->url" placeholder="https://" required />
    </x-admin.form>
</x-layouts.admin>
