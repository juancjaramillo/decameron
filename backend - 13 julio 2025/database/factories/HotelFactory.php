<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hotel;

class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'nombre'           => $this->faker->company,
            'nit'              => $this->faker->unique()->numerify('#########-#'),
            'direccion'        => $this->faker->streetAddress,
            'ciudad'           => $this->faker->city,
            'max_habitaciones' => $this->faker->numberBetween(1, 50),
        ];
    }
}
