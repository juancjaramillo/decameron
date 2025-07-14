<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *   schema="Hotel",
 *   @OA\Property(property="id",   type="integer", description="ID del hotel"),
 *   @OA\Property(property="nombre",           type="string",  description="Nombre del hotel"),
 *   @OA\Property(property="direccion",        type="string",  description="Dirección"),
 *   @OA\Property(property="ciudad",           type="string",  description="Ciudad"),
 *   @OA\Property(property="nit",              type="string",  description="NIT o registro fiscal"),
 *   @OA\Property(property="max_habitaciones", type="integer", description="Máximo de habitaciones"),
 *   @OA\Property(property="created_at",       type="string",  format="date-time"),
 *   @OA\Property(property="updated_at",       type="string",  format="date-time"),
 * )
 */

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hoteles';

    // Campos que puedes asignar masivamente
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'nit',
        'max_habitaciones',
    ];

    // Relación con configuraciones
    public function roomConfigs()
    {
        return $this->hasMany(HotelRoomConfig::class, 'hotel_id');
    }
}
