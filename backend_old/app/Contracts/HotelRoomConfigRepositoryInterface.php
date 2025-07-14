<?php
namespace App\Contracts;

use App\Models\HotelRoomConfig;
use Illuminate\Support\Collection;

interface HotelRoomConfigRepositoryInterface
{
    public function allByHotel(int $hotelId): Collection;
    public function create(int $hotelId, array $data): HotelRoomConfig;
    public function delete(int $id): bool;
}
