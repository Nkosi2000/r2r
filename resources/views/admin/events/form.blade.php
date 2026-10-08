@php($isEditing = $event->exists)

<x-layouts.admin :title="$isEditing ? 'Edit event' : 'Add event'">
    <x-admin.page-header :title="$isEditing ? 'Edit event' : 'Add event'" :back="route('admin.events.index')" />

    <x-admin.form :action="$isEditing ? route('admin.events.update', $event) : route('admin.events.store')" :method="$isEditing ? 'PUT' : 'POST'" :submit="$isEditing ? 'Save changes' : 'Add event'" :cancel="route('admin.events.index')">
        <x-admin.input name="title" label="Event name" :value="$event->title" placeholder="e.g. Careers & Skills Expo" required />
        <div class="grid gap-6 sm:grid-cols-2">
            <x-admin.select name="place" label="Province" :options="array_combine(array_keys(App\Models\Event::PROVINCES), array_keys(App\Models\Event::PROVINCES))" :value="$event->place" placeholder="Choose a province" required />
            <x-admin.input name="held_on" label="Date" type="date" :value="$event->held_on?->toDateString()" required />
        </div>

        <fieldset class="grid gap-4 border-t border-navy/10 pt-6">
            <legend class="text-[13px] font-medium">Map pin <span class="font-normal text-navy/55">(optional)</span></legend>
            <p class="-mt-2 text-[12px] text-navy/55">Leave empty to pin the event in the middle of its province. For an exact spot, right-click the place in Google Maps and copy the two numbers shown.</p>
            <div class="grid gap-6 sm:grid-cols-2">
                <x-admin.input name="latitude" label="Latitude" type="number" step="any" :value="$event->latitude" placeholder="e.g. -28.87" />
                <x-admin.input name="longitude" label="Longitude" type="number" step="any" :value="$event->longitude" placeholder="e.g. 27.88" />
            </div>
        </fieldset>
    </x-admin.form>
</x-layouts.admin>
