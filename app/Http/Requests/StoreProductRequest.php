<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:productos,name'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'decimal:2', 'numeric', 'min:0'],
            'currency_id' => ['required', 'integer', 'exists:divisas,id'],
            'tax_cost' => ['required', 'decimal:2', 'numeric', 'min:0'],
            'manufacturing_cost' => ['required', 'decimal:2', 'numeric', 'min:0']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto',
            'name.max' => 'El nombre es demasiado largo (max: 255 letras)',
            'name.unique' => 'Este producto ya está registrado',

            'description.required' => 'La descripción es obligatoria',
            'description.string' => 'La descripción debe ser texto válido',
            'description.max' => 'La descripción es demasiado larga (max: 255 letras)',

            'price.required' => 'El precio es obligatorio.',
            'price.decimal' => 'El precio debe tener hasta dos decimales',
            'price.numeric' => 'El precio debe ser un número válido',
            'price.min' => 'El precio no puede ser menor que 0.',

            'currency_id.required' => 'La divisa es obligatoria.',
            'currency_id.integer' => 'La divisa especificada debe ser un entero.',
            'currency_id.exists' => 'La divisa especificada no existe.',

            'tax_cost.required' => 'El costo de impuesto es obligatorio',
            'tax_cost.decimal' => 'El costo de impuesto debe tener hasta dos decimales',
            'tax_cost.numeric' => 'El costo de impuesto debe ser un número válido',
            'tax_cost.min' => 'El costo de impuesto no puede ser menor que 0.',

            'manufacturing_cost.required' => 'El costo de fabricación es obligatorio',
            'manufacturing_cost.decimal' => 'El costo de fabricación debe tener hasta dos decimales',
            'manufacturing_cost.numeric' => 'El costo de fabricación debe ser un número válido.',
            'manufacturing_cost.min' => 'El costo de fabricación no puede ser menor que 0.',
        ];
    }
}
