<x-layouts.admin title="Reports">
    <x-admin.page-header title="Reports" description="Annual and impact reports on the Reports page, newest year first. With no reports, the page shows a “Coming soon” message.">
        <x-button :href="route('admin.reports.create')" variant="navy">Add report</x-button>
    </x-admin.page-header>

    @if ($reports->isNotEmpty())
        <div class="overflow-x-auto border border-navy/10">
            <table class="admin-table">
                <thead>
                    <tr><th>Year</th><th>Report</th><th>File</th><th><span class="sr-only">Actions</span></th></tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr>
                            <td class="font-mono text-[11px] text-green">{{ $report->year }}</td>
                            <td class="font-medium">{{ $report->title }}</td>
                            <td class="text-[13px]"><a href="{{ $report->file_url }}" target="_blank" rel="noopener" class="text-blue hover:underline">Open PDF <span aria-hidden="true">↗</span></a></td>
                            <td><x-admin.row-actions :edit="route('admin.reports.edit', $report)" :destroy="route('admin.reports.destroy', $report)" :name="$report->title" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-admin.empty message="No reports published yet.">
            <x-button :href="route('admin.reports.create')" variant="navy">Add report</x-button>
        </x-admin.empty>
    @endif
</x-layouts.admin>
