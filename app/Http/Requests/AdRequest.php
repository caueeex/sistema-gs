<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'preco_venda' => ['required', 'numeric', 'min:0'],
            'produtos' => ['required', 'array', 'min:1'],
            'produtos.*.product_id' => ['required', 'exists:products,id'],
            'produtos.*.quantidade' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título do anúncio é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'preco_venda.required' => 'O preço de venda é obrigatório.',
            'preco_venda.numeric' => 'O preço de venda deve ser um valor numérico.',
            'preco_venda.min' => 'O preço de venda não pode ser negativo.',
            'produtos.required' => 'Selecione ao menos um produto para o anúncio.',
            'produtos.min' => 'Selecione ao menos um produto para o anúncio.',
        ];
    }
}
