@php($isEditing = $programme->exists)

<x-layouts.admin :title="$isEditing ? 'Edit programme' : 'Add programme'">
    <x-admin.page-header :title="$isEditing ? 'Edit programme' : 'Add programme'" :back="route('admin.programmes.index')" />

    <x-admin.form :action="$isEditing ? route('admin.programmes.update', $programme) : route('admin.programmes.store')" :method="$isEditing ? 'PUT' : 'POST'" :submit="$isEditing ? 'Save changes' : 'Add programme'" :cancel="route('admin.programmes.index')">
        <x-admin.input name="title" label="Programme name" :value="$programme->title" required />
        <x-admin.input name="pillar" label="Pillar or subjects" :value="$programme->pillar" :options="$pillarLabels" hint="Pick an existing label or type a new one, e.g. “Maths · Science · Accounting”." required />
    </x-admin.form>
</x-layouts.admin>
