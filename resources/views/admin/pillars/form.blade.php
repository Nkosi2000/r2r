@php($isEditing = $pillar->exists)

<x-layouts.admin :title="$isEditing ? 'Edit pillar' : 'Add pillar'">
    <x-admin.page-header :title="$isEditing ? 'Edit pillar' : 'Add pillar'" :back="route('admin.pillars.index')" />

    <x-admin.form :action="$isEditing ? route('admin.pillars.update', $pillar) : route('admin.pillars.store')" :method="$isEditing ? 'PUT' : 'POST'" :submit="$isEditing ? 'Save changes' : 'Add pillar'" :cancel="route('admin.pillars.index')">
        <div class="grid gap-6 sm:grid-cols-2">
            <x-admin.input name="step" label="Step" :value="$pillar->step" hint="Shown above the card, e.g. “First” or “Last”." required />
            <x-admin.input name="verb" label="Label" :value="$pillar->verb" hint="One word, e.g. “Careers”. Also groups programmes." required />
        </div>
        <x-admin.input name="title" label="Title" :value="$pillar->title" required />
        <x-admin.textarea name="body" label="Description" :value="$pillar->body" rows="4" required />
        <x-admin.select name="figure" label="Drawing" :options="App\Models\Pillar::FIGURES" :value="$pillar->figure" hint="The line drawing shown on the pillar card." required />
    </x-admin.form>
</x-layouts.admin>
