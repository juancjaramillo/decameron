<?php
namespace App\Services;

interface HotelRoomConfigServiceInterface
{
    public function listar(int $hotelId): array;
    public function crear(int $hotelId, array $data): array;
    public function eliminar(int $id): void;
}
