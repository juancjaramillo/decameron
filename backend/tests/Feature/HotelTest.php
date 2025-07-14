<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HotelTest extends TestCase
{
    use RefreshDatabase;

    public function test_crea_y_lista_hoteles(): void
    {
        // 1. Crear un hotel vía API
        $data = [
            'nombre'           => 'Prueba',
            'nit'              => '1-1',
            'direccion'        => 'Calle',
            'ciudad'           => 'X',
            'max_habitaciones' => 10,
        ];
        $this->postJson('/api/v1/hoteles', $data)
             ->assertStatus(201)
             ->assertJsonFragment(['nombre' => 'Prueba']);

        // 2. Listar hoteles vía API
        $this->getJson('/api/v1/hoteles')
             ->assertStatus(200)
             ->assertJsonCount(1);
    }
}
