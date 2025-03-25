<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z]).+$/', Password::min(8)->numbers()->symbols()->uncompromised()],
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'Debes ingresar tu contraseña actual.',
            'old_password.current_password' => 'La contraseña actual es incorrecta.',

            'password.required' => 'Campo obligatorio.',
            'password.min' => 'Mínimo 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',

            'password.regex' => 'Debe incluir mayúsculas y minúsculas.',
            'password.numbers' => 'Debe incluir al menos 1 número.',
            'password.symbols' => 'Debe incluir al menos 1 símbolo.',
            'password.uncompromised' => 'Contraseña comprometida, intenta otra.',
        ];
    }
}
