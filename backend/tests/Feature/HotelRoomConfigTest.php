<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\HotelRoomConfigRepository;
use App\Repositories\HotelRepository;
use App\Services\HotelRoomConfigService;
use App\Models\Hotel;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HotelRoomConfigTest extends TestCase
{
    use RefreshDatabase;

    protected HotelRoomConfigService $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Preparamos el servicio inyectando ambos repositorios
        $this->service = new HotelRoomConfigService(
            new HotelRoomConfigRepository(),
            new HotelRepository(),
        );
    }

    public function test_lista_configuraciones_al_inicio_esta_vacia(): void
    {
        $hotel = Hotel::factory()->create(['max_habitaciones' => 3]);

        $configs = $this->service->listar($hotel->id);
        $this->assertIsArray($configs);
        $this->assertCount(0, $configs);
    }

    public function test_puede_crear_configuracion_valida(): void
    {
        $hotel = Hotel::factory()->create(['max_habitaciones' => 5]);

        $data = [
            'tipo_habitacion' => 'ESTANDAR',
            'acomodacion'     => 'DOBLE',
            'cantidad'        => 2,
        ];

        $config = $this->service->crear($hotel->id, $data);

        $this->assertDatabaseHas('hotel_room_configs', [
            'hotel_id'        => $hotel->id,
            'tipo_habitacion' => 'ESTANDAR',
            'acomodacion'     => 'DOBLE',
            'cantidad'        => 2,
        ]);

        $this->assertEquals(1, count($this->service->listar($hotel->id)));
    }

    public function test_no_permite_superar_maximo_habitaciones(): void
    {
        $hotel = Hotel::factory()->create(['max_habitaciones' => 3]);

        // Ya hay 2 configuradas
        $this->service->crear($hotel->id, [
            'tipo_habitacion' => 'ESTANDAR',
            'acomodacion'     => 'DOBLE',
            'cantidad'        => 2,
        ]);

        $this->expectException(BadRequestHttpException::class);

        // Intentamos agregar 2 más — supera el total de 3
        $this->service->crear($hotel->id, [
            'tipo_habitacion' => 'SUITE',
            'acomodacion'     => 'SENCILLA',
            'cantidad'        => 2,
        ]);
    }

    public function test_error_al_listar_o_crear_para_hotel_inexistente(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $this->service->listar(999);

        // y también al crear sobre un hotel que no existe:
        $this->expectException(NotFoundHttpException::class);
        $this->service->crear(999, [
            'tipo_habitacion' => 'ESTANDAR',
            'acomodacion'     => 'SENCILLA',
            'cantidad'        => 1,
        ]);
    }

    public function test_puede_eliminar_configuracion(): void
    {
        $hotel = Hotel::factory()->create(['max_habitaciones' => 5]);
        $config = $this->service->crear($hotel->id, [
            'tipo_habitacion' => 'JUNIOR',
            'acomodacion'     => 'TRIPLE',
            'cantidad'        => 3,
        ]);

        // eliminar y verificar que ya no exista
        $this->service->eliminar($config['id']);

        $this->assertDatabaseMissing('hotel_room_configs', [
            'id' => $config['id'],
        ]);
    }

    public function test_error_al_eliminar_configuracion_inexistente(): void
    {
        $this->expectException(NotFoundHttpException::class);
        $this->service->eliminar(999);
    }
}
