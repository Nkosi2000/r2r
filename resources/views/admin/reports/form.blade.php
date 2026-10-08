@php($isEditing = $report->exists)

<x-layouts.admin :title="$isEditing ? 'Edit report' : 'Add report'">
    <x-admin.page-header :title="$isEditing ? 'Edit report' : 'Add report'" :back="route('admin.reports.index')" />

    <x-admin.form :action="$isEditing ? route('admin.reports.update', $report) : route('admin.reports.store')" :method="$isEditing ? 'PUT' : 'POST'" :submit="$isEditing ? 'Save changes' : 'Publish report'" :cancel="route('admin.reports.index')" files>
        <x-admin.input name="title" label="Title" :value="$report->title" placeholder="e.g. Annual Report" required />
        <x-admin.input name="year" label="Year" type="number" :value="$report->year" min="2000" :max="now()->year + 1" class="sm:max-w-40" required />
        <x-admin.file name="file" label="PDF" kind="document" :current-url="$isEditing ? $report->file_url : null" accept="application/pdf" hint="PDF, up to 20 MB." :required="! $isEditing" />
    </x-admin.form>
</x-layouts.admin>
