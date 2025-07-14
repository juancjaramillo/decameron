<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\HotelRoomConfig;
use App\Models\Hotel;

class HotelRoomConfigFactory extends Factory
{
    protected $model = HotelRoomConfig::class;

    public function definition(): array
    {
        static $hotelIds;

        // Cacheamos los IDs existentes en la BD para no hacer query repetido
        if (is_null($hotelIds)) {
            $hotelIds = Hotel::pluck('id')->all();
        }

        // Si no hay hoteles aún, creamos uno
        $hotelId = $hotelIds[array_rand($hotelIds)] ?? Hotel::factory()->create()->id;

        $tipos = ['ESTANDAR', 'JUNIOR', 'SUITE'];
        $tipo = $this->faker->randomElement($tipos);

        $acomodacionesMap = [
            'ESTANDAR' => ['SENCILLA', 'DOBLE'],
            'JUNIOR'   => ['TRIPLE', 'CUADRUPLE'],
            'SUITE'    => ['SENCILLA', 'DOBLE', 'TRIPLE'],
        ];
        $acomodacion = $this->faker->randomElement($acomodacionesMap[$tipo]);

        return [
            'hotel_id'        => $hotelId,
            'tipo_habitacion' => $tipo,
            'acomodacion'     => $acomodacion,
            'cantidad'        => $this->faker->numberBetween(1, 5),
        ];
    }
}
