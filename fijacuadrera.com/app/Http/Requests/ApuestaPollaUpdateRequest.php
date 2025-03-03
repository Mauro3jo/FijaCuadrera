<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApuestaPollaUpdateRequest extends FormRequest
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
            'Monto1' => ['required', 'numeric'],
            'Caballo2' => ['required', 'max:255', 'string'],
            'Monto2' => ['required', 'numeric'],
            'Caballo3' => ['required', 'max:255', 'string'],
            'Monto3' => ['required', 'numeric'],
            'Caballo4' => ['required', 'max:255', 'string'],
            'Monto4' => ['required', 'numeric'],
            'Caballo5' => ['required', 'max:255', 'string'],
            'Monto5' => ['required', 'numeric'],
            'Estado' => ['required', 'boolean'],
        ];
    }
}
