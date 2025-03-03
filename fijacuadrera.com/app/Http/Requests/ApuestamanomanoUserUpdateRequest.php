<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApuestamanomanoUserUpdateRequest extends FormRequest
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
            'apuestamanomano_id' => ['required', 'exists:apuestamanomanos,id'],
            'user_id' => ['required', 'exists:users,id'],
            'caballo_id' => ['required', 'exists:caballos,id'],
            'resultadoapuesta' => ['required', 'max:255', 'string'],
        ];
    }
}
