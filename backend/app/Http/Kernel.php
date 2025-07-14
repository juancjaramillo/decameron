<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,               // nuestro middleware
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

       /* 'api' => [
            // Aunque nuestro flujo es stateless, mantenemos este middleware para otras rutas si lo necesitaras.
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
*/

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

    ];

    protected $routeMiddleware = [
        'auth'     => \Illuminate\Auth\Middleware\Authenticate::class,
        'guest'    => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
        'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'signed'   => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ];
}
