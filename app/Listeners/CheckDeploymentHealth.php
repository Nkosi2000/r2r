<?php

namespace App\Listeners;

use App\Support\SiteContent;
use Illuminate\Foundation\Events\DiagnosingHealth;
use Illuminate\Routing\Route as RouteDefinition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use RuntimeException;

/**
 * Runs on GET /up, Railway's deploy health check. Railway only switches traffic
 * to a new deployment once this passes, so any exception here keeps the current
 * deployment live: the database must answer, the site content must be there and
 * every page must render.
 */
class CheckDeploymentHealth
{
    public function handle(DiagnosingHealth $event): void
    {
        DB::select('select 1');

        if (blank(app(SiteContent::class)->contact())) {
            throw new RuntimeException('Site content is missing. Run `php artisan db:seed --force`.');
        }

        collect(Route::getRoutes()->getRoutes())
            ->map(fn (RouteDefinition $route): ?string => $route->defaults['view'] ?? null)
            ->filter()
            ->each(fn (string $page) => view($page)->render());
    }
}
