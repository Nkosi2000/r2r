<x-layouts.admin title="Events">
    <x-admin.page-header title="Events" description="Roadshows and expos. Events dated today or later appear as upcoming; every event is pinned on the “On the road” map.">
        <x-button :href="route('admin.events.create')" variant="navy">Add event</x-button>
    </x-admin.page-header>

    <x-admin.search :value="$search" placeholder="Search by name or province" />

    @if ($events->isNotEmpty())
        <div class="overflow-x-auto border border-navy/10">
            <table class="admin-table">
                <thead>
                    <tr><th>Date</th><th>Event</th><th>Province</th><th>Status</th><th><span class="sr-only">Actions</span></th></tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        @php($isUpcoming = $event->held_on->gte(today()))
                        <tr>
                            <td class="font-mono text-[11px] whitespace-nowrap text-navy/60 uppercase">{{ $event->date }}</td>
                            <td class="font-medium">{{ $event->title }}</td>
                            <td class="font-mono text-[11px] text-blue uppercase">{{ $event->place }}</td>
                            <td><span class="px-2 py-1 font-mono text-[9px] tracking-[0.1em] uppercase {{ $isUpcoming ? 'bg-green text-night' : 'text-navy/50 ring-1 ring-navy/15' }}">{{ $isUpcoming ? 'Upcoming' : 'Past' }}</span></td>
                            <td><x-admin.row-actions :edit="route('admin.events.edit', $event)" :destroy="route('admin.events.destroy', $event)" :name="$event->title" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $events->links() }}</div>
    @else
        <x-admin.empty :message="$search === '' ? 'No events yet.' : 'No events match your search.'" />
    @endif
</x-layouts.admin>
