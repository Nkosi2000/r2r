<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContent;
use Database\Factories\PillarFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * One of the four programme pillars. "figure" names the line-art drawing in resources/js/effects/rosette.js.
 */
#[Fillable(['position', 'step', 'verb', 'figure', 'title', 'body'])]
class Pillar extends Model
{
    /** @use HasFactory<PillarFactory> */
    use FlushesSiteContent, HasFactory;

    /**
     * Line-art drawings available in resources/js/effects/rosette.js.
     *
     * @var array<string, string> figure key => label
     */
    public const FIGURES = [
        'signpost' => 'Signpost',
        'gears' => 'Gears',
        'stall' => 'Market stall',
        'chalkboard' => 'Chalkboard',
    ];
}
