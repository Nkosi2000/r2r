<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContent;
use Database\Factories\PartnerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A partner organisation. "logo" is a path relative to public/, e.g. images/partners/teta.png.
 */
#[Fillable(['position', 'name', 'description', 'logo', 'website'])]
class Partner extends Model
{
    /** @use HasFactory<PartnerFactory> */
    use FlushesSiteContent, HasFactory;
}
