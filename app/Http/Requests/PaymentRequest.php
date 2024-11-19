<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Permita a autorização por padrão
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
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:10|max:15',
            'cpfCnpj' => 'required|string|min:11|max:14',
            'price' => 'required|numeric|min:0',
            'course_id' => 'required|integer|exists:courses,id',
            'user_id' => 'nullable|integer|exists:users,id',
            'status' => 'nullable|string|in:pending,paid,failed,canceled,payment_created,reprocess_payment',
        ];
    }

    /**
     * Customize the validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'Insira um endereço de e-mail válido.',

            'phone.required' => 'O número de telefone é obrigatório.',

            'cpfCnpj.required' => 'O CPF ou CNPJ é obrigatório.',
            'cpfCnpj.min' => 'O CPF ou CNPJ deve ter :min caracteres.',
            'cpfCnpj.max' => 'O CPF ou CNPJ deve ter no máximo :max caracteres.',

            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um valor numérico.',

            'course_id.required' => 'O curso é obrigatório.',
            'course_id.exists' => 'O curso selecionado não existe.',

            'user_id.exists' => 'O usuário selecionado não existe.',

            'status.in' => 'O status deve ser um dos valores permitidos: Pendente, Confirmado, Falho, Reprocessar Pagamento.',
        ];
    }
}
