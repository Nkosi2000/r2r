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
}
