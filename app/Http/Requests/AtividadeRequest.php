<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtividadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Já usamos middleware auth nas rotas
        return true;
    }

    public function rules(): array
    {
        $status = $this->input('status');

        return [
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'urgencia' => 'required|in:sob_controle,merece_atencao,urgente',
            'status' => 'required|in:a_fazer,fazendo,finalizada',
            'inicio' => 'required|date',
            'fim' => $status !== 'finalizada'
                ? 'required|date|after_or_equal:inicio'
                : 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'urgencia.required' => 'Selecione o nível de urgência.',
            'urgencia.in' => 'Urgência inválida.',
            'status.required' => 'Selecione o status da atividade.',
            'status.in' => 'Status inválido.',
            'inicio.required' => 'A data de início é obrigatória.',
            'inicio.date' => 'A data de início deve ser uma data válida.',
            'fim.required' => 'A data de fim é obrigatória para atividades não finalizadas.',
            'fim.date' => 'A data de fim deve ser uma data válida.',
            'fim.after_or_equal' => 'A data de término deve ser posterior ou igual à data de início.',
        ];
    }
}
