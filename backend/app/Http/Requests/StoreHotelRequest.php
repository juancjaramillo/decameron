<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(schema="StoreHotelRequest",
 *   @OA\Property(property="nombre",           type="string"),
 *   @OA\Property(property="nit",              type="string"),
 *   @OA\Property(property="direccion",        type="string"),
 *   @OA\Property(property="ciudad",           type="string"),
 *   @OA\Property(property="max_habitaciones", type="integer")
 * )
 */
class StoreHotelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre'           => 'required|string|unique:hoteles',
            'nit'              => 'required|string|unique:hoteles',
            'direccion'        => 'required|string',
            'ciudad'           => 'required|string',
            'max_habitaciones' => 'required|integer|min:1',
        ];
    }
}
