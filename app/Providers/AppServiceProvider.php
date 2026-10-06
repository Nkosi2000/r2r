<?php

namespace App\Providers;

use Anthropic\Client;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
