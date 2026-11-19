<?php

namespace App\Providers;

use App\Support\PageCache;
use Carbon\CarbonImmutable;
use Illuminate\Cache\Events\CacheCleared;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\OpenAIService::class, function ($app) {
            return new \App\Services\OpenAIService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        // Saved public pages carry titles, descriptions and links from these models
        foreach ([
            \App\Models\Setting::class, \App\Models\Blog::class, \App\Models\Service::class,
            \App\Models\Product::class, \App\Models\Package::class, \App\Models\Bundle::class,
            \App\Models\Industry::class, \App\Models\CaseStudy::class,
        ] as $model) {
            foreach (['saved', 'deleted'] as $event) {
                Event::listen("eloquent.{$event}: {$model}", fn () => PageCache::flush());
            }
        }
        Event::listen(CacheFlushed::class, fn () => PageCache::flush());
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
