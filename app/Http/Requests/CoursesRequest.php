<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursesRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'category' => 'required',
            'price' => 'required|numeric|min:1',
            'vacancies' => 'required|integer|min:1',
            'date_ini' => 'required|date|before_or_equal:date_end',
            'date_end' => 'required|date|after_or_equal:date_ini',
            'status' => 'required|boolean',
            'avatar' => 'nullable|mimes:jpeg,png,jpg|max:8048',
        ];
    }

    /**
     * Custom messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'O campo nome é obrigatório.',
            'title.string' => 'O campo nome deve ser um texto.',
            'title.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            
            'description.required' => 'O campo descrição é obrigatório.',
            'description.string' => 'O campo descrição deve ser um texto.',
            'description.min' => 'A descrição deve ter no mínimo 10 caracteres.',
            
            'category.required' => 'O campo categoria é obrigatório.',
            
            'price.required' => 'O campo valor é obrigatório.',
            'price.min' => 'O valor deve ser maior ou igual a 1.',
            'price.regex' => 'O valor do preço deve ser numérico e utilizar ponto como separador decimal.',
            
            'vacancies.required' => 'O campo vagas é obrigatório.',
            'vacancies.integer' => 'O campo vagas deve ser um número inteiro.',
            'vacancies.min' => 'O campo vagas deve ter no mínimo 1 vaga.',
            
            'date_ini.required' => 'O campo data de início é obrigatório.',
            'date_ini.date' => 'O campo data de início deve ser uma data válida.',
            'date_ini.before_or_equal' => 'A data de início deve ser antes ou igual à data de término.',
            
            'date_end.required' => 'O campo data de término é obrigatório.',
            'date_end.date' => 'O campo data de término deve ser uma data válida.',
            'date_end.after_or_equal' => 'A data de término deve ser depois ou igual à data de início.',
            
            'status.required' => 'O campo status é obrigatório.',
            'status.boolean' => 'O campo status deve ser verdadeiro ou falso.',

            'avatar.image' => 'O avatar deve ser uma imagem.',
            'avatar.mimes' => 'O avatar deve ser um arquivo do tipo: jpeg, png, jpg, gif.',
            'avatar.max' => 'O avatar não pode ter mais de 2MB.',
        ];
    }
}
