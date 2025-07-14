<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            // Todas las rutas de API
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            // Todas las rutas web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
