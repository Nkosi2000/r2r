@props(['edit', 'destroy', 'name', 'reorder' => null, 'isFirst' => false, 'isLast' => false])

{{--
    Edit / delete links for a table row, plus move up / down when the content has a staff-chosen order.
    "reorder" is [type, id] for the admin.reorder route.
--}}
<div class="flex items-center justify-end gap-1">
    @if ($reorder)
        @foreach (['up' => ['↑', $isFirst], 'down' => ['↓', $isLast]] as $direction => [$arrow, $isDisabled])
            <form method="POST" action="{{ route('admin.reorder', [...$reorder, $direction]) }}">
                @csrf
                <button type="submit" @disabled($isDisabled) aria-label="Move {{ $name }} {{ $direction }}" class="grid size-8 cursor-pointer place-items-center text-navy/60 hover:bg-paper hover:text-navy disabled:cursor-default disabled:opacity-25 disabled:hover:bg-transparent">{{ $arrow }}</button>
            </form>
        @endforeach
    @endif
    <a href="{{ $edit }}" class="px-2.5 py-1.5 text-[13px] text-blue hover:underline">Edit<span class="sr-only"> {{ $name }}</span></a>
    <form method="POST" action="{{ $destroy }}" data-confirm="Delete “{{ $name }}”? This can't be undone.">
        @csrf
        @method('DELETE')
        <button type="submit" class="cursor-pointer px-2.5 py-1.5 text-[13px] text-red-600 hover:underline">Delete<span class="sr-only"> {{ $name }}</span></button>
    </form>
</div>
