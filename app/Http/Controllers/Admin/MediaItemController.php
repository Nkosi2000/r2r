<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MediaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaItemRequest;
use App\Models\MediaItem;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaItemController extends Controller
{
    /**
     * Media is managed one type at a time, matching the sections on the Media page.
     */
    public function index(Request $request): View
    {
        $type = MediaType::tryFrom((string) $request->query('type')) ?? MediaType::Photo;

        return view('admin.media.index', [
            'type' => $type,
            'counts' => MediaItem::query()->toBase()->selectRaw('type, count(*) as total')->groupBy('type')->pluck('total', 'type'),
            'items' => MediaItem::query()->where('type', $type)->orderBy('position')->orderBy('id')->get(),
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.media.form', [
            'mediaItem' => new MediaItem(['type' => MediaType::tryFrom((string) $request->query('type')) ?? MediaType::Photo]),
        ]);
    }

    public function store(MediaItemRequest $request): RedirectResponse
    {
        $type = MediaType::from($request->validated('type'));

        MediaItem::query()->create([
            ...$request->safe()->except('file'),
            'path' => Uploads::store($request->file('file'), 'media/'.$type->value),
            'position' => (MediaItem::query()->where('type', $type)->max('position') ?? 0) + 1,
        ]);

        return to_route('admin.media.index', ['type' => $type])->with('status', 'Media added.');
    }

    public function edit(MediaItem $mediaItem): View
    {
        return view('admin.media.form', ['mediaItem' => $mediaItem]);
    }

    public function update(MediaItemRequest $request, MediaItem $mediaItem): RedirectResponse
    {
        $mediaItem->update([
            ...$request->safe()->except(['file', 'type']),
            'path' => Uploads::replace($request->file('file'), $mediaItem->path, 'media/'.$mediaItem->type->value),
        ]);

        return to_route('admin.media.index', ['type' => $mediaItem->type])->with('status', 'Media updated.');
    }

    public function destroy(MediaItem $mediaItem): RedirectResponse
    {
        $mediaItem->delete();
        Uploads::delete($mediaItem->path);

        return to_route('admin.media.index', ['type' => $mediaItem->type])->with('status', 'Media deleted.');
    }
}
