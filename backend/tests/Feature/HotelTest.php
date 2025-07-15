<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;


class HotelTest extends TestCase
{
    use RefreshDatabase;    

    public function test_crea_y_lista_hoteles()
    {
        // 1) Autenticamos un usuario con Sanctum
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        // 2) Datos para crear el hotel
        $data = [
            'nombre'           => 'Prueba',
            'nit'              => '12345',
            'direccion'        => 'Calle X',
            'ciudad'           => 'X',
            'max_habitaciones' => 10,
        ];

        // 3) Creamos el hotel y comprobamos 201
        $this->postJson('/api/v1/hoteles', $data)
             ->assertStatus(201)
             ->assertJsonFragment(['nombre' => 'Prueba']);

        // 4) Listamos hoteles y comprobamos que hay al menos uno
        $this->getJson('/api/v1/hoteles')
             ->assertStatus(200)
             ->assertJsonCount(1, 'data');
    }
}
