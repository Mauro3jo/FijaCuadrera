<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApuestaPollaUserUpdateRequest extends FormRequest
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
            'apuesta_polla_id' => ['required', 'exists:apuesta_pollas,id'],
            'user_id' => ['required', 'exists:users,id'],
            'caballo_id' => ['required', 'exists:caballos,id'],
            'Resultadoapuesta' => ['required', 'max:255', 'string'],
        ];
    }
}
