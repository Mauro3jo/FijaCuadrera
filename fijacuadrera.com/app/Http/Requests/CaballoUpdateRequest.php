<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaballoUpdateRequest extends FormRequest
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
            'nombre' => ['required', 'max:255'],
            'edad' => ['required', 'numeric'],
            'Raza' => ['required', 'max:255'],
        ];
    }
}
