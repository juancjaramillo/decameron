<?php
namespace App\Services;

use App\Contracts\HotelRoomConfigRepositoryInterface;
use App\Contracts\HotelRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HotelRoomConfigService implements HotelRoomConfigServiceInterface
{
    public function __construct(
        protected HotelRoomConfigRepositoryInterface $repo,
        protected HotelRepositoryInterface           $hotelRepo,
    ) {}

    public function listar(int $hotelId): array
    {
        if (! $this->hotelRepo->find($hotelId)) {
            throw new NotFoundHttpException('Hotel no encontrado');
        }
        return $this->repo->allByHotel($hotelId)->toArray();
    }

    public function crear(int $hotelId, array $data): array
    {
        $hotel = $this->hotelRepo->find($hotelId);
        if (! $hotel) {
            throw new NotFoundHttpException('Hotel no encontrado');
        }

        $usadas = collect($this->repo->allByHotel($hotelId))->sum('cantidad');
        if ($usadas + $data['cantidad'] > $hotel->max_habitaciones) {
            throw new BadRequestHttpException('Supera máximo de habitaciones permitidas');
        }

        $config = $this->repo->create($hotelId, $data);
        return $config->toArray();
    }

    public function eliminar(int $id): void
    {
        if (! $this->repo->delete($id)) {
            throw new NotFoundHttpException('Configuración no encontrada');
        }
    }
}
