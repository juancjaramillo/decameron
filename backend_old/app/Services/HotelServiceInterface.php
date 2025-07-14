<?php
namespace App\Services;

use Illuminate\Support\Collection;

interface HotelServiceInterface
{
    public function listar(): Collection;
    public function obtener(int $id): array;
    public function crear(array $data): array;
    public function actualizar(int $id, array $data): array;
    public function eliminar(int $id): void;
}
