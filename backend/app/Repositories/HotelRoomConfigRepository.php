<?php

namespace App\Repositories;

use App\Contracts\HotelRoomConfigRepositoryInterface;
use App\Models\HotelRoomConfig;
use Illuminate\Support\Collection;

class HotelRoomConfigRepository implements HotelRoomConfigRepositoryInterface
{
    public function allByHotel(int $hotelId): Collection
    {
        return HotelRoomConfig::where('hotel_id', $hotelId)->get();
    }

    public function create(int $hotelId, array $data): HotelRoomConfig
    {
        return HotelRoomConfig::create(array_merge($data, ['hotel_id' => $hotelId]));
    }

    public function delete(int $id): bool
    {
        $config = HotelRoomConfig::find($id);
        return $config ? $config->delete() : false;
    }
}
