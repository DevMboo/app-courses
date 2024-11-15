<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',

            'email.required' => 'O campo e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser um texto válido.',
            'email.min' => 'O e-mail deve ter pelo menos 10 caracteres.',

            'password.required' => 'O campo senha é obrigatório.',
            'password.string' => 'A senha deve ser um texto.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'password.max' => 'A senha não pode ter mais que 255 caracteres.',

            'confirm_password.required' => 'O campo de confirmação de senha é obrigatório.',
            'confirm_password.string' => 'A confirmação de senha deve ser um texto.',
            'confirm_password.min' => 'A confirmação de senha deve ter pelo menos 8 caracteres.',
            'confirm_password.max' => 'A confirmação de senha não pode ter mais que 255 caracteres.',
            'confirm_password.same' => 'A confirmação de senha deve corresponder à senha.',

            'avatar.mimes' => 'O avatar deve ser um arquivo do tipo: jpeg, png ou jpg.',
            'avatar.max' => 'O avatar não pode ter mais que 8 MB.',
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|min:10',
            'password' => 'required|string|min:8|max:255',
            'confirm_password' => 'required|string|min:8|max:255|same:password',
            'avatar' => 'nullable|mimes:jpeg,png,jpg|max:10048'
        ];
    }
}
