<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductPriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'currency_id' => 'required|integer|exists:divisas,id',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'currency_id.required' => 'La divisa es obligatoria.',
            'currency_id.integer' => 'La divisa especificada debe ser un entero.',
            'currency_id.exists' => 'La divisa especificada no existe.',

            'price.required' => 'El precio es obligatorio',
            'price.numeric' => 'El precio debe ser un número válido',
            'price.min' => 'El precio no puede ser menor que 0.',
        ];
    }
}