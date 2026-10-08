<x-layouts.admin title="Programmes">
    <x-admin.page-header title="Programmes" description="The programme list on the home and What We Do pages, shown in this order.">
        <x-button :href="route('admin.programmes.create')" variant="navy">Add programme</x-button>
    </x-admin.page-header>

    <x-admin.search :value="$search" placeholder="Search programmes" />

    @if ($programmes->isNotEmpty())
        <div class="overflow-x-auto border border-navy/10">
            <table class="admin-table">
                <thead>
                    <tr><th>#</th><th>Programme</th><th>Pillar / subjects</th><th><span class="sr-only">Actions</span></th></tr>
                </thead>
                <tbody>
                    @foreach ($programmes as $programme)
                        <tr>
                            <td class="font-mono text-[11px] text-navy/50">{{ sprintf('%02d', $loop->iteration) }}</td>
                            <td class="font-medium">{{ $programme->title }}</td>
                            <td class="font-mono text-[11px] text-blue uppercase">{{ $programme->pillar }}</td>
                            <td><x-admin.row-actions :edit="route('admin.programmes.edit', $programme)" :destroy="route('admin.programmes.destroy', $programme)" :name="$programme->title" :reorder="$search === '' ? ['programmes', $programme->id] : null" :is-first="$loop->first" :is-last="$loop->last" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-admin.empty :message="$search === '' ? 'No programmes yet.' : 'No programmes match your search.'" />
    @endif
</x-layouts.admin>
