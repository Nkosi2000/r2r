<x-layouts.admin title="Pillars">
    <x-admin.page-header title="Pillars" description="The programme pillars on the home and What We Do pages, shown in this order.">
        <x-button :href="route('admin.pillars.create')" variant="navy">Add pillar</x-button>
    </x-admin.page-header>

    @if ($pillars->isNotEmpty())
        <div class="overflow-x-auto border border-navy/10">
            <table class="admin-table">
                <thead>
                    <tr><th>Step</th><th>Label</th><th>Title</th><th>Description</th><th><span class="sr-only">Actions</span></th></tr>
                </thead>
                <tbody>
                    @foreach ($pillars as $pillar)
                        <tr>
                            <td class="font-mono text-[11px] text-navy/60 uppercase">{{ $pillar->step }}</td>
                            <td class="font-mono text-[11px] text-green uppercase">{{ $pillar->verb }}</td>
                            <td class="font-medium">{{ $pillar->title }}</td>
                            <td class="max-w-md text-navy/70"><span class="line-clamp-2">{{ $pillar->body }}</span></td>
                            <td><x-admin.row-actions :edit="route('admin.pillars.edit', $pillar)" :destroy="route('admin.pillars.destroy', $pillar)" :name="$pillar->title" :reorder="['pillars', $pillar->id]" :is-first="$loop->first" :is-last="$loop->last" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-admin.empty message="No pillars yet.">
            <x-button :href="route('admin.pillars.create')" variant="navy">Add pillar</x-button>
        </x-admin.empty>
    @endif
</x-layouts.admin>
