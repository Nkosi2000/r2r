<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContent;
use Database\Factories\ProgrammeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A programme, labelled with the pillar or subjects it belongs to.
 */
#[Fillable(['position', 'title', 'pillar'])]
class Programme extends Model
{
    /** @use HasFactory<ProgrammeFactory> */
    use FlushesSiteContent, HasFactory;
}
