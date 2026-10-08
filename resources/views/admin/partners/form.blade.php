@php($isEditing = $partner->exists)

<x-layouts.admin :title="$isEditing ? 'Edit partner' : 'Add partner'">
    <x-admin.page-header :title="$isEditing ? 'Edit partner' : 'Add partner'" :back="route('admin.partners.index')" />

    <x-admin.form :action="$isEditing ? route('admin.partners.update', $partner) : route('admin.partners.store')" :method="$isEditing ? 'PUT' : 'POST'" :submit="$isEditing ? 'Save changes' : 'Add partner'" :cancel="route('admin.partners.index')" files>
        <x-admin.input name="name" label="Name" :value="$partner->name" required />
        <x-admin.input name="description" label="Short description" :value="$partner->description" hint="Shown under the logo, e.g. “Transport Education Training Authority”." required />
        <x-admin.input name="website" label="Website" type="url" :value="$partner->website" placeholder="https://" />
        <x-admin.file name="logo" label="Logo" :current-url="$isEditing ? $partner->logo_url : null" accept="image/png,image/jpeg,image/webp" hint="PNG, JPG or WebP, up to 2 MB. A transparent PNG looks best." :required="! $isEditing" />
    </x-admin.form>
</x-layouts.admin>
