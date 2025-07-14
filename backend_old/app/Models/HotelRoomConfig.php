<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
