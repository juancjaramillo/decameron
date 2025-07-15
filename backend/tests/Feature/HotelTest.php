<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class HotelTest extends TestCase
{
    public function test_crea_y_lista_hoteles()
    {
        // 1) Creamos un usuario y autenticamos con Sanctum
        Sanctum::actingAs(
            User::factory()->create(),
            ['*'] // scopes si usas
        );

        // 2) Datos para crear
        $data = [
            'nombre'           => 'Prueba',
            'nit'              => '12345',
            'direccion'        => 'Calle X',
            'ciudad'           => 'X',
            'max_habitaciones' => 10,
        ];

        // 3) Crear hotel (ahora responde 201)
        $this->postJson('/api/v1/hoteles', $data)
             ->assertStatus(201)
             ->assertJsonFragment(['nombre' => 'Prueba']);

        // 4) Listar hoteles
        $this->getJson('/api/v1/hoteles')
             ->assertStatus(200)
             ->assertJsonCount(1, 'data');
    }
}
