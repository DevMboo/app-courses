<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'email.required' => 'O campo email é obrigatório.',
            'email.min' => 'O campo email deve ter pelo menos 8 caracteres.',
            'email.max' => 'O campo email não pode exceder 244 caracteres.',
            
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve ter pelo menos 8 caracteres.',
            'password.max' => 'O campo senha não pode exceder 244 caracteres.',
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
            //
            'email' => 'required|min:8|max:244',
            'password' => 'required|min:8|max:244',
        ];
    }
}
