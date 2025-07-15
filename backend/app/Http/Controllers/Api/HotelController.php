<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRequest;
use App\Services\HotelServiceInterface;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

/**
 * @OA\PathItem(
 *     path="/api/v1/hoteles",
 *     @OA\Server(url=L5_SWAGGER_CONST_HOST)
 * )
 * @OA\Tag(
 *     name="Hoteles",
 *     description="Endpoints para gestionar hoteles"
 * )
 */
class HotelController extends Controller
{
    public function __construct(protected HotelServiceInterface $svc) {}

    /**
     * Listar todos los hoteles
     *
     * @OA\Get(
     *   path="/api/v1/hoteles",
     *   tags={"Hoteles"},
     *   summary="Listar todos los hoteles",
     *   @OA\Response(
     *     response=200,
     *     description="Listado de hoteles",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Hotel")
     *       )
     *     )
     *   )
     * )
     */
    public function index()
    {
        // Envolvemos la lista en "data" para que assertJsonCount('data') funcione
        return response()->json([
            'data' => $this->svc->listar(),
        ], Response::HTTP_OK);
    }

    /**
     * Obtener detalle de un hotel
     *
     * @OA\Get(
     *  path="/api/v1/hoteles/{id}",
     *   tags={"Hoteles"},
     *   summary="Obtiene un hotel por ID",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID del hotel",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Detalle del hotel",
     *     @OA\JsonContent(ref="#/components/schemas/Hotel")
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Hotel no encontrado"
     *   )
     * )
     */
    public function show(int $id)
    {
        return response()->json(
            $this->svc->obtener($id),
            Response::HTTP_OK
        );
    }

    /**
     * Crear un nuevo hotel
     *
     * @OA\Post(
     *   path="/api/v1/hoteles",
     *   tags={"Hoteles"},
     *   summary="Crea un hotel",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/StoreHotelRequest")
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Hotel creado",
     *     @OA\JsonContent(ref="#/components/schemas/Hotel")
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Validación fallida"
     *   )
     * )
     */
    public function store(StoreHotelRequest $req)
    {
        $hotel = $this->svc->crear($req->validated());
        return response()->json(
            $hotel,
            Response::HTTP_CREATED
        );
    }

    /**
     * Actualizar un hotel existente
     *
     * @OA\Put(
     *  path="/api/v1/hoteles/{id}",
     *   tags={"Hoteles"},
     *   summary="Actualiza un hotel",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID del hotel",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/StoreHotelRequest")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Hotel actualizado",
     *     @OA\JsonContent(ref="#/components/schemas/Hotel")
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Hotel no encontrado"
     *   )
     * )
     */
    public function update(StoreHotelRequest $req, int $id)
    {
        return response()->json(
            $this->svc->actualizar($id, $req->validated()),
            Response::HTTP_OK
        );
    }

    /**
     * Eliminar un hotel
     *
     * @OA\Delete(
     * path="/api/v1/hoteles/{id}",
     *   tags={"Hoteles"},
     *   summary="Elimina un hotel",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="ID del hotel",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=204,
     *     description="Hotel eliminado"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Hotel no encontrado"
     *   )
     * )
     */
    public function destroy(int $id)
    {
        $this->svc->eliminar($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
