<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Disable2FARequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'password' => ['required', 'current_password'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Debes ingresar tu contraseña actual.',
            'password.current_password' => 'La contraseña actual es incorrecta.',
        ];
    }
}
