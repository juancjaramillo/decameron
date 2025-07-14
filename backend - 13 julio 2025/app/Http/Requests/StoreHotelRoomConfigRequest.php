<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(schema="StoreHotelRoomConfigRequest",
 *   @OA\Property(property="tipo_habitacion", type="string", enum={"ESTANDAR","JUNIOR","SUITE"}),
 *   @OA\Property(property="acomodacion",     type="string", enum={"SENCILLA","DOBLE","TRIPLE","CUADRUPLE"}),
 *   @OA\Property(property="cantidad",        type="integer")
 * )
 */
class StoreHotelRoomConfigRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tipo_habitacion' => ['required', Rule::in(['ESTANDAR','JUNIOR','SUITE'])],
            'acomodacion'     => ['required', Rule::in(match($this->tipo_habitacion) {
                'ESTANDAR' => ['SENCILLA','DOBLE'],
                'JUNIOR'   => ['TRIPLE','CUADRUPLE'],
                'SUITE'    => ['SENCILLA','DOBLE','TRIPLE'],
            })],
            'cantidad'        => 'required|integer|min:1',
        ];
    }
}
