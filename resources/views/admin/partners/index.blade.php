<x-layouts.admin title="Partners">
    <x-admin.page-header title="Partners" description="Partner logos on the home and Our Partners pages, shown in this order.">
        <x-button :href="route('admin.partners.create')" variant="navy">Add partner</x-button>
    </x-admin.page-header>

    <x-admin.search :value="$search" placeholder="Search partners" />

    @if ($partners->isNotEmpty())
        <div class="overflow-x-auto border border-navy/10">
            <table class="admin-table">
                <thead>
                    <tr><th>Logo</th><th>Partner</th><th>Website</th><th><span class="sr-only">Actions</span></th></tr>
                </thead>
                <tbody>
                    @foreach ($partners as $partner)
                        <tr>
                            <td><img src="{{ $partner->logo_url }}" alt="" loading="lazy" class="h-10 w-20 object-contain"></td>
                            <td>
                                <span class="block font-medium">{{ $partner->name }}</span>
                                <span class="text-[13px] text-navy/60">{{ $partner->description }}</span>
                            </td>
                            <td class="text-[13px]">
                                @if ($partner->website)
                                    <a href="{{ $partner->website }}" target="_blank" rel="noopener" class="text-blue hover:underline">{{ Str::of($partner->website)->after('://')->rtrim('/')->limit(30) }}</a>
                                @else
                                    <span class="text-navy/40">—</span>
                                @endif
                            </td>
                            <td><x-admin.row-actions :edit="route('admin.partners.edit', $partner)" :destroy="route('admin.partners.destroy', $partner)" :name="$partner->name" :reorder="$search === '' ? ['partners', $partner->id] : null" :is-first="$loop->first" :is-last="$loop->last" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-admin.empty :message="$search === '' ? 'No partners yet.' : 'No partners match your search.'" />
    @endif
</x-layouts.admin>
