<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace('App\\Http\\Controllers') // 👈 Make sure this is added!
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace('App\\Http\\Controllers')
                ->group(base_path('routes/web.php'));
        });
    }
}