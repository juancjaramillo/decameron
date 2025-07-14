<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="HotelRoomConfig",
 *   description="Configuración de tipo de habitación de un hotel",
 *   required={"id","hotel_id","tipo_habitacion","acomodacion","cantidad"},
 *   @OA\Property(property="id",               type="integer", format="int64"),
 *   @OA\Property(property="hotel_id",         type="integer", format="int64"),
 *   @OA\Property(property="tipo_habitacion",  type="string", enum={"ESTANDAR","JUNIOR","SUITE"}),
 *   @OA\Property(property="acomodacion",      type="string", enum={"SENCILLA","DOBLE","TRIPLE","CUADRUPLE"}),
 *   @OA\Property(property="cantidad",         type="integer")
 * )
 */

class HotelRoomConfig extends Model
{
    use HasFactory;

    protected $table = 'hotel_room_configs';

    protected $fillable = [
        'hotel_id',
        'tipo_habitacion',
        'acomodacion',
        'cantidad',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
