<?php

namespace App\Models;

use App\Models\Concerns\FlushesSiteContent;
use Database\Factories\ResourceLinkFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * An external link on the Resources page, listed under its "group" heading.
 */
#[Fillable(['position', 'group', 'title', 'description', 'url'])]
class ResourceLink extends Model
{
    /** @use HasFactory<ResourceLinkFactory> */
    use FlushesSiteContent, HasFactory;
}
