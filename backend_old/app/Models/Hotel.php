<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
