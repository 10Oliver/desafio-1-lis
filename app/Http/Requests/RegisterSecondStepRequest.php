<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;

class RegisterSecondStepRequest extends FormRequest
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
            'email' => 'required|email|unique:user,email',
            'phone' => 'required|string|max:250',
            'password' => ['required', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z]).+$/', Password::min(8)->numbers()->symbols()->uncompromised()],
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
            'phone.regex' => 'Formato incorrecto (0000-0000)',
            'phone.max' => 'Máximo 250 caracteres',

            'nationality.required' => 'Campo obligatorio.',

            'dui.required_if' => 'Campo obligatorio si es nacional.',
            'dui.regex' => 'Formato inválido. (00000000-0)',

            'document.required_if' => 'Campo obligatorio.',
            'document.max' => 'Máximo 50 caracteres.',

            'country_data.required_if' => 'Campo obligatorio.',
            'country_data.string' => 'Debe ser un texto válido.',

            'password.required' => 'Campo obligatorio.',
            'password.min' => 'Mínimo 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',

            'password.regex' => 'Debe incluir mayúsculas y minúsculas.',
            'password.numbers' => 'Debe incluir al menos 1 número.',
            'password.symbols' => 'Debe incluir al menos 1 símbolo.',
            'password.uncompromised' => 'Contraseña comprometida, intenta otra.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('phone', ['regex:/^\d{4}-\d{4}$/'], function ($input) {
            return $input->nationality == 1;
        });
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'step' => 1,
            'errors'  => $validator->errors()
        ], 422));
    }
}
