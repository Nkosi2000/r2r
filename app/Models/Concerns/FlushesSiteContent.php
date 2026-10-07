<?php

namespace App\Models\Concerns;

use App\Support\SiteContent;

/**
 * Clears the cached site content whenever a content record changes, so edits show up immediately.
 */
trait FlushesSiteContent
{
    public static function bootFlushesSiteContent(): void
    {
        static::saved(fn () => SiteContent::flush());
        static::deleted(fn () => SiteContent::flush());
    }
}
