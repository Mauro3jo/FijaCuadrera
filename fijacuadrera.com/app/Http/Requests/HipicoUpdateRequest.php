<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HipicoUpdateRequest extends FormRequest
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
            'direccion' => ['required', 'max:255'],
            'imagen' => ['required', 'image'],
        ];
    }
}
