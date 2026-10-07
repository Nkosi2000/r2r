<?php

namespace App\Models;

use App\Enums\MediaType;
use App\Models\Concerns\FlushesSiteContent;
use Database\Factories\MediaItemFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A photo, video or publication on the Media page. "path" is relative to public/.
 * "subtitle" holds a video's province or a publication's edition.
 */
#[Fillable(['position', 'type', 'title', 'subtitle', 'path'])]
class MediaItem extends Model
{
    /** @use HasFactory<MediaItemFactory> */
    use FlushesSiteContent, HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => MediaType::class,
        ];
    }
}
