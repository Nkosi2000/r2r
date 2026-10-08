<x-layouts.admin title="Resources">
    <x-admin.page-header title="Resources" description="Useful links on the Resources page, listed under their headings in this order.">
        <x-button :href="route('admin.resources.create')" variant="navy">Add resource</x-button>
    </x-admin.page-header>

    <x-admin.search :value="$search" placeholder="Search resources" />

    @forelse ($groups as $group => $links)
        <section class="mb-8" aria-labelledby="group-{{ $loop->index }}">
            <h2 id="group-{{ $loop->index }}" class="mb-2 font-mono text-[10px] tracking-[0.1em] text-navy/55 uppercase">{{ $group }}</h2>
            <div class="overflow-x-auto border border-navy/10">
                <table class="admin-table">
                    <thead class="sr-only">
                        <tr><th>Resource</th><th>Link</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($links as $link)
                            <tr>
                                <td>
                                    <span class="block font-medium">{{ $link->title }}</span>
                                    <span class="line-clamp-1 text-[13px] text-navy/60">{{ $link->description }}</span>
                                </td>
                                <td class="text-[13px]"><a href="{{ $link->url }}" target="_blank" rel="noopener" class="text-blue hover:underline">{{ Str::of($link->url)->after('://')->rtrim('/')->limit(34) }}</a></td>
                                <td class="w-px"><x-admin.row-actions :edit="route('admin.resources.edit', $link)" :destroy="route('admin.resources.destroy', $link)" :name="$link->title" :reorder="$search === '' ? ['resources', $link->id] : null" :is-first="$loop->first" :is-last="$loop->last" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @empty
        <x-admin.empty :message="$search === '' ? 'No resources yet.' : 'No resources match your search.'" />
    @endforelse
</x-layouts.admin>
