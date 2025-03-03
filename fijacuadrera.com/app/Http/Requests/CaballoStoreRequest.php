<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaballoStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'max:255', 'string'],
            'edad' => ['required', 'numeric'],
            'raza' => ['required', 'max:255', 'string'],
          //  'imagen' => ['required', 'image'], // Agrega la validación del campo imagen
        ];
    }
}
