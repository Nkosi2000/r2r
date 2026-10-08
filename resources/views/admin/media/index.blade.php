@php
    $typeLabels = ['photo' => 'Photos', 'video' => 'Videos', 'publication' => 'Publications'];
    $singular = ['photo' => 'photo', 'video' => 'video', 'publication' => 'publication'][$type->value];
@endphp

<x-layouts.admin title="Media">
    <x-admin.page-header title="Media" description="Photos, videos and publications on the Media page, shown in this order.">
        <x-button :href="route('admin.media.create', ['type' => $type])" variant="navy">Add {{ $singular }}</x-button>
    </x-admin.page-header>

    <nav aria-label="Media type" class="mb-6 flex flex-wrap gap-px bg-navy/10 p-px sm:inline-flex">
        @foreach ($typeLabels as $value => $label)
            <a href="{{ route('admin.media.index', ['type' => $value]) }}" @if ($type->value === $value) aria-current="page" @endif class="flex items-center gap-2 px-4 py-2 text-[13px] {{ $type->value === $value ? 'bg-navy text-white' : 'bg-white hover:bg-paper' }}">
                {{ $label }}<span class="font-mono text-[10px] opacity-60">{{ $counts[$value] ?? 0 }}</span>
            </a>
        @endforeach
    </nav>

    @if ($items->isNotEmpty())
        <div class="overflow-x-auto border border-navy/10">
            <table class="admin-table">
                <thead>
                    <tr><th>Preview</th><th>Title</th><th>{{ $type->value === 'publication' ? 'Edition' : ($type->value === 'video' ? 'Place' : 'Subtitle') }}</th><th><span class="sr-only">Actions</span></th></tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>
                                @if ($type->value === 'video')
                                    <span class="grid h-12 w-20 place-items-center bg-night font-mono text-[9px] tracking-[0.1em] text-white uppercase">Video</span>
                                @else
                                    <img src="{{ $item->url }}" alt="" loading="lazy" class="h-12 w-20 object-cover">
                                @endif
                            </td>
                            <td class="font-medium">{{ $item->title }}</td>
                            <td class="text-[13px] text-navy/65">{{ $item->subtitle ?: '—' }}</td>
                            <td><x-admin.row-actions :edit="route('admin.media.edit', $item)" :destroy="route('admin.media.destroy', $item)" :name="$item->title" :reorder="['media', $item->id]" :is-first="$loop->first" :is-last="$loop->last" /></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-admin.empty message="No {{ strtolower($typeLabels[$type->value]) }} yet.">
            <x-button :href="route('admin.media.create', ['type' => $type])" variant="navy">Add {{ $singular }}</x-button>
        </x-admin.empty>
    @endif
</x-layouts.admin>
