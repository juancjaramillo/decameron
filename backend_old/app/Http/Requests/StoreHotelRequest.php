<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
