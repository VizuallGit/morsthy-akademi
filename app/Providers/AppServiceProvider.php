<?php

namespace App\Providers;

use App\Listeners\RemovePlayerBackground;
use App\Widgets\GettingStartedWidget;
use App\Modifiers\MinifyCss;
use App\Tags\StylePush;
use App\Tags\YieldMinified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Statamic\Events\AssetUploaded;
use Statamic\Statamic;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(AssetUploaded::class, RemovePlayerBackground::class);
        GettingStartedWidget::register();

        MinifyCss::register();
        StylePush::register();
        YieldMinified::register();

        Statamic::vite('app', [
            'input' => [
                'resources/css/cp.css',
            ],
            'buildDirectory' => 'vendor/app',
            'hotFile' => 'cp.hot',
        ]);
    }
}
