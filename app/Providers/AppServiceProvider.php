<?php

namespace App\Providers;

use Anthropic\Client;
use App\Models\User;
use App\Support\SiteContent;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, fn (): Client => new Client(
            apiKey: (string) config('services.anthropic.key'),
        ));

        $this->app->scoped(SiteContent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('gutter', 'px-4 sm:px-8 lg:pr-12 lg:pl-[136px]');

        // Content comes from the database, so it is only loaded once one of the site's own views renders.
        // Error pages are deliberately left out so they still render when the database is unreachable.
        View::composer(
            ['components.layouts.app', 'components.seo', 'components.page-header', 'pages.*', 'sections.*'],
            fn (ViewContract $view) => $view->with(app(SiteContent::class)->viewData()),
        );

        // CMS: every signed-in staff member edits content; only admins manage staff and site settings.
        Gate::define('manage-staff', fn (User $user): bool => $user->isAdmin());
        Gate::define('manage-settings', fn (User $user): bool => $user->isAdmin());

        RateLimiter::for('cms-login', fn (Request $request): Limit => Limit::perMinute(5)->by(Str::lower((string) $request->input('email')).'|'.$request->ip()));

        RateLimiter::for('r2rbot', function (Request $request): array {
            $tooManyRequests = fn (): JsonResponse => response()->json([
                'message' => 'You\'re sending messages quickly. Please wait a moment and try again.',
            ], 429);

            return [
                Limit::perMinute(config('rural2rural.bot.per_minute'))->by('minute:'.$request->ip())->response($tooManyRequests),
                Limit::perDay(config('rural2rural.bot.per_day'))->by('day:'.$request->ip())->response($tooManyRequests),
            ];
        });
    }
}
