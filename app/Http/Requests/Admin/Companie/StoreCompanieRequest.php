<?php

namespace App\Http\Requests\Admin\Companie;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanieRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'max:18', 'unique:companies,cnpj'],
            'email' => ['required', 'email', 'max:255', 'unique:companies,email'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'active' => ['boolean'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'O nome da empresa é obrigatório.',
            'name.max' => 'O nome não pode ter mais que 255 caracteres.',

            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'cnpj.max' => 'O CNPJ não pode ter mais que 18 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'email.max' => 'O e-mail não pode ter mais que 255 caracteres.',

            'phone.required' => 'O telefone é obrigatório.',
            'phone.max' => 'O telefone não pode ter mais que 20 caracteres.',

            'address.required' => 'O endereço é obrigatório.',
            'address.max' => 'O endereço não pode ter mais que 255 caracteres.',

            'active.required' => 'O status ativo/inativo é obrigatório.',
            'active.boolean' => 'O campo ativo deve ser verdadeiro ou falso.',
        ];
    }
}
