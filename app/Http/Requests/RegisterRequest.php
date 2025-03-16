<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => 'required|string|min:3|max:255',
            'second_name' => 'nullable|string|min:3|max:255',
            'lastname' => 'required|string|min:3|max:255',
            'second_lastname' => 'nullable|string|min:3|max:255',
            'email' => 'required|email|unique:user,email',
            'phone' => 'required|regex:/^\d{8}$/',
            'nationality' => 'required',
            'dui' => [
                'nullable',
                'required_if:nationality,1',
                'regex:/^\d{8}-\d{1}$/'
            ],
            'document' => 'nullable|required_if:nationality,2|string|max:50',
            'country_data' => 'nullable|required_if:nationality,2|string',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Campo obligatorio.',
            'first_name.min' => 'Mínimo 3 caracteres.',
            'first_name.max' => 'Máximo 255 caracteres.',

            'second_name.min' => 'Mínimo 3 caracteres.',
            'second_name.max' => 'Máximo 255 caracteres.',

            'lastname.required' => 'Campo obligatorio.',
            'lastname.min' => 'Mínimo 3 caracteres.',
            'lastname.max' => 'Máximo 255 caracteres.',

            'second_lastname.min' => 'Mínimo 3 caracteres.',
            'second_lastname.max' => 'Máximo 255 caracteres.',

            'email.required' => 'Campo obligatorio.',
            'email.email' => 'Debe ser un correo válido.',
            'email.unique' => 'Ya está registrado.',

            'phone.required' => 'Campo obligatorio.',
            'phone.regex' => 'Debe tener 8 dígitos.',

            'nationality.required' => 'Campo obligatorio.',

            'dui.required_if' => 'Campo obligatorio si es nacional.',
            'dui.regex' => 'Formato inválido.',

            'document.required_if' => 'Campo obligatorio.',
            'document.max' => 'Máximo 50 caracteres.',

            'country_data.required_if' => 'Campo obligatorio.',
            'country_data.string' => 'Debe ser un texto válido.',

            'password.required' => 'Campo obligatorio.',
            'password.min' => 'Mínimo 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
