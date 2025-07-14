<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\HotelRepository;
use App\Services\HotelService;

class HotelServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_listar_hoteles_vacios(): void
    {
        $service = new HotelService(new HotelRepository());
        $this->assertEmpty($service->listar());
    }

    public function test_crea_y_obtiene_hotel(): void
    {
        $data = [
            'nombre'           => 'Prueba Hotel',
            'direccion'        => 'Calle Falsa 123',
            'ciudad'           => 'Bogotá',
            'nit'              => '900123456-7',
            'max_habitaciones' => 10,
        ];

        $service = new HotelService(new HotelRepository());
        $hotel   = $service->crear($data);

        $this->assertEquals('Prueba Hotel', $hotel['nombre']);
        $this->assertDatabaseHas('hoteles', ['nombre' => 'Prueba Hotel']);

        $fetched = $service->obtener($hotel['id']);
        $this->assertEquals('Bogotá', $fetched['ciudad']);
    }

    public function test_actualiza_hotel(): void
    {
        $service = new HotelService(new HotelRepository());
        $hotel   = $service->crear([
            'nombre'           => 'X',
            'direccion'        => 'Y',
            'ciudad'           => 'Z',
            'nit'              => '111',
            'max_habitaciones' => 5,
        ]);

        $updated = $service->actualizar($hotel['id'], ['ciudad' => 'Cartagena']);
        $this->assertEquals('Cartagena', $updated['ciudad']);
    }

    public function test_elimina_hotel(): void
    {
        $service = new HotelService(new HotelRepository());
        $hotel   = $service->crear([
            'nombre'           => 'Para Eliminar',
            'direccion'        => 'X',
            'ciudad'           => 'Y',
            'nit'              => '222',
            'max_habitaciones' => 1,
        ]);

        $service->eliminar($hotel['id']);
        $this->assertDatabaseMissing('hoteles', ['id' => $hotel['id']]);
    }
}
