<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Services\HotelServiceInterface;
use App\Services\HotelService;
use App\Services\HotelRoomConfigServiceInterface;
use App\Services\HotelRoomConfigService;

// Repositorios
use App\Contracts\HotelRepositoryInterface;
use App\Repositories\HotelRepository;
use App\Contracts\HotelRoomConfigRepositoryInterface;
use App\Repositories\HotelRoomConfigRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repositorios
        $this->app->bind(
            \App\Contracts\HotelRepositoryInterface::class,
            \App\Repositories\HotelRepository::class
        );
        $this->app->bind(
            \App\Contracts\HotelRoomConfigRepositoryInterface::class,
            \App\Repositories\HotelRoomConfigRepository::class
        );

        // Servicios
        $this->app->bind(
            \App\Services\HotelServiceInterface::class,
            \App\Services\HotelService::class
        );
        $this->app->bind(
            \App\Services\HotelRoomConfigServiceInterface::class,
            \App\Services\HotelRoomConfigService::class
        );
    }


    public function boot(): void
    {
        //
    }
}
