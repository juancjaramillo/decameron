<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HotelController;
use App\Http\Controllers\Api\HotelRoomConfigController;

Route::prefix('v1')->group(function () {
    Route::apiResource('hoteles', HotelController::class);
    Route::apiResource('hoteles.configuraciones', HotelRoomConfigController::class)
        ->shallow()->only(['index', 'store', 'destroy']);
});
