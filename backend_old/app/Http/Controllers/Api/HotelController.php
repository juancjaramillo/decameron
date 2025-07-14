<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRequest;
use App\Services\HotelServiceInterface;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   title="API Decameron - Hoteles",
 *   version="1.0.0",
 *   description="API REST para gestionar hoteles de Decameron",
 *   @OA\Contact(
 *     name="Soporte Decameron",
 *     email="soporte@decameron.com"
 *   )
 * )
 *
 * @OA\Server(
 *   url=L5_SWAGGER_CONST_HOST,
 *   description="Servidor local"
 * )
 *
 * @OA\Tag(
 *   name="Hoteles",
 *   description="Operaciones relacionadas con hoteles"
 * )
 */
class HotelController extends Controller
{
    public function __construct(protected HotelServiceInterface $svc) {}

    /**
     * Listar todos los hoteles
     *
     * @OA\Get(
     *   path="/api/hoteles",
     *   tags={"Hoteles"},
     *   summary="Obtiene la lista de hoteles",
     *   @OA\Response(
     *     response=200,
     *     description="Lista de hoteles",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Hotel"))
     *   )
     * )
     */
    public function index()
    {
        return response()->json($this->svc->listar());
    }

    /**
     * Obtener detalle de un hotel
     *
     * @OA\Get(
     *   path="/api/hoteles/{id}",
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
    public function show($id)
    {
        return response()->json($this->svc->obtener((int)$id));
    }

    /**
     * Crear un nuevo hotel
     *
     * @OA\Post(
     *   path="/api/hoteles",
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
        return response()
            ->json($this->svc->crear($req->validated()), Response::HTTP_CREATED);
    }

    /**
     * Actualizar un hotel existente
     *
     * @OA\Put(
     *   path="/api/hoteles/{id}",
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
    public function update(StoreHotelRequest $req, $id)
    {
        return response()->json($this->svc->actualizar((int)$id, $req->validated()));
    }

    /**
     * Eliminar un hotel
     *
     * @OA\Delete(
     *   path="/api/hoteles/{id}",
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
    public function destroy($id)
    {
        $this->svc->eliminar((int)$id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
