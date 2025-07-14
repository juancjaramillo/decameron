<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHotelRoomConfigRequest;
use App\Services\HotelRoomConfigServiceInterface;
use Illuminate\Http\Response;

class HotelRoomConfigController extends Controller
{
    public function __construct(protected HotelRoomConfigServiceInterface $svc) {}

    public function index($hotelId)
    {
        return response()->json($this->svc->listar((int)$hotelId));
    }

    public function store(StoreHotelRoomConfigRequest $req, $hotelId)
    {
        return response()->json(
            $this->svc->crear((int)$hotelId, $req->validated()),
            Response::HTTP_CREATED
        );
    }

    public function destroy($hotelId, $id)
    {
        $this->svc->eliminar((int)$id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
