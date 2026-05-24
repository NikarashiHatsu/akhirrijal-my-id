<?php

namespace App\Providers;

use App\Models\Photo;
use App\Observers\PhotoObserver;
use App\View\Composers\PublicLayoutComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Photo::observe(PhotoObserver::class);

        View::composer([
            'home',
            'about',
            'portfolio.index',
            'portfolio.show',
            'contact',
            'components.layouts.public',
            'components.nav',
            'components.footer',
        ], PublicLayoutComposer::class);
    }
}
