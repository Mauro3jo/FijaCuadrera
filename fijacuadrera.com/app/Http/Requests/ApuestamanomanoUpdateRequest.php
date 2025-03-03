<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApuestamanomanoUpdateRequest extends FormRequest
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
            'carrera_id' => ['required', 'exists:carreras,id'],
            'Ganancia' => ['required', 'numeric'],
            'Caballo1' => ['required', 'max:255', 'string'],
            'Caballo2' => ['required', 'max:255', 'string'],
            'Tipo' => ['required', 'max:255', 'string'],
            'Estado' => ['required', 'boolean'],
        ];
    }
}
