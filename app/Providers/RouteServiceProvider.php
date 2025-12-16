<?php

namespace App\Providers;

use App\Http\Middleware\ContentSecurityPolicy;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register your middleware group properly
        Route::middlewareGroup('web', [
            ContentSecurityPolicy::class,
        ]);

        // Define your route files
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }
}