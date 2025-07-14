<?php
namespace App\Services;

use App\Contracts\HotelRepositoryInterface;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HotelService implements HotelServiceInterface
{
    public function __construct(protected HotelRepositoryInterface $repo) {}

    public function listar(): Collection
    {
        return $this->repo->all();
    }

    public function obtener(int $id): array
    {
        $hotel = $this->repo->find($id);
        if (!$hotel) throw new NotFoundHttpException('Hotel no encontrado');
        return $hotel->toArray();
    }

    public function crear(array $data): array
    {
        $hotel = $this->repo->create($data);
        return $hotel->toArray();
    }

    public function actualizar(int $id, array $data): array
    {
        if (!$this->repo->update($id, $data)) throw new NotFoundHttpException('Hotel no encontrado');
        return $this->repo->find($id)->toArray();
    }

    public function eliminar(int $id): void
    {
        if (!$this->repo->delete($id)) throw new NotFoundHttpException('Hotel no encontrado');
    }
}
