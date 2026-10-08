<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaItem;
use App\Models\Partner;
use App\Models\Pillar;
use App\Models\Programme;
use App\Models\ResourceLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ReorderController extends Controller
{
    /**
     * Content that is shown in a staff-chosen order, keyed by the URL segment.
     * "scope" keeps items ordered within their own section (a media type, a resource group).
     *
     * @var array<string, array{model: class-string<Model>, scope: string|null}>
     */
    public const MODELS = [
        'pillars' => ['model' => Pillar::class, 'scope' => null],
        'programmes' => ['model' => Programme::class, 'scope' => null],
        'partners' => ['model' => Partner::class, 'scope' => null],
        'media' => ['model' => MediaItem::class, 'scope' => 'type'],
        'resources' => ['model' => ResourceLink::class, 'scope' => 'group'],
    ];

    /**
     * Move an item one place up or down among its siblings.
     */
    public function __invoke(string $type, int $id, string $direction): RedirectResponse
    {
        ['model' => $modelClass, 'scope' => $scope] = self::MODELS[$type];

        $item = $modelClass::query()->findOrFail($id);

        DB::transaction(function () use ($modelClass, $scope, $item, $direction): void {
            $siblings = $modelClass::query()
                ->when($scope !== null, fn ($query) => $query->where($scope, $item->getRawOriginal($scope)))
                ->orderBy('position')
                ->orderBy('id')
                ->get()
                ->values();

            $from = $siblings->search(fn (Model $sibling): bool => $sibling->is($item));
            $to = $direction === 'up' ? $from - 1 : $from + 1;

            if ($to < 0 || $to >= $siblings->count()) {
                return;
            }

            $ordered = $siblings->all();
            [$ordered[$from], $ordered[$to]] = [$ordered[$to], $ordered[$from]];

            foreach ($ordered as $index => $sibling) {
                if ((int) $sibling->position !== $index + 1) {
                    $sibling->update(['position' => $index + 1]);
                }
            }
        });

        return back()->with('status', 'Order updated.');
    }
}
