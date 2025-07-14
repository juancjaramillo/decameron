<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRoomConfigRequest;
use App\Services\HotelRoomConfigServiceInterface;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

/**
 * @OA\PathItem(
 *     path="/api/v1/hoteles/{hotel}/configuraciones",
 *     @OA\Server(url=L5_SWAGGER_CONST_HOST)
 * )
 * @OA\Tag(
 *     name="Configuraciones de Habitaciones",
 *     description="Endpoints para gestionar configuraciones de habitaciones"
 * )
 */
class HotelRoomConfigController extends Controller
{
    public function __construct(
        protected HotelRoomConfigServiceInterface $svc
    ) {}

    /**
     * @OA\Get(
     *   path="/api/v1/hoteles/{hotelId}/configuraciones",
     *   tags={"Configuraciones"},
     *   summary="Listar configuraciones de un hotel",
     *   @OA\Parameter(name="hotelId", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(
     *     response=200,
     *     description="Listado de configuraciones",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/HotelRoomConfig"))
     *   )
     * )
     */
    public function index(int $hotelId)
    {
        return response()->json($this->svc->listar($hotelId));
    }

    /**
     * @OA\Post(
     *   path="/api/v1/hoteles/{hotelId}/configuraciones",
     *   tags={"Configuraciones"},
     *   summary="Crear configuración de habitación",
     *   @OA\Parameter(name="hotelId", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/StoreHotelRoomConfigRequest")
     *   ),
     *   @OA\Response(response=201, description="Configuración creada")
     * )
     */
    public function store(StoreHotelRoomConfigRequest $req, int $hotelId)
    {
        $created = $this->svc->crear($hotelId, $req->validated());
        return response()->json($created, Response::HTTP_CREATED);
    }

    /**
     * @OA\Delete(
     *   path="/api/v1/configuraciones/{id}",
     *   tags={"Configuraciones"},
     *   summary="Eliminar configuración",
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *   @OA\Response(response=204, description="Configuración eliminada")
     * )
     */
    public function destroy(int $id)
    {
        $this->svc->eliminar($id);
        return response()->noContent();
    }
}
