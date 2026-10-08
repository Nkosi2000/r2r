<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContent;
use App\Support\Uploads;
use Database\Factories\PartnerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * A partner organisation. "logo" is a CMS upload or a file bundled in public/ (e.g. images/partners/teta.png).
 */
#[Fillable(['position', 'name', 'description', 'logo', 'website'])]
class Partner extends Model
{
    /** @use HasFactory<PartnerFactory> */
    use FlushesSiteContent, HasFactory;

    /**
     * Public URL of the logo, wherever it is stored.
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::get(fn (): string => Uploads::url($this->logo));
    }
}
