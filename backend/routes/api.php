<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthTokenController;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\HotelRoomConfigController;

Route::prefix('v1')->group(function () {
    // Login stateless: excluimos CSRF y EnsureFrontendRequestsAreStateful
    Route::post('login',      [AuthTokenController::class, 'login'])
         ->withoutMiddleware([
             \App\Http\Middleware\VerifyCsrfToken::class,
             \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
         ]);

    Route::post('auth/token', [AuthTokenController::class, 'login'])
         ->withoutMiddleware([
             \App\Http\Middleware\VerifyCsrfToken::class,
             \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
         ]);

    // Rutas protegidas (llevan auth:sanctum normal)
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('hoteles', HotelController::class);
        Route::apiResource('hoteles.configuraciones', HotelRoomConfigController::class)
             ->shallow()
             ->only(['index','store','destroy']);
    });
});
