<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtividadeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $today = now()->toDateString();
        $maxDate = now()->addMonths(12)->toDateString();

        return [
            'titulo' => ['required', 'string', 'max:100', 'regex:/^[A-Za-zÀ-ú\s]+$/'],
            'descricao' => ['required', 'string', 'max:1000'],
            'urgencia' => ['required', 'in:sob_controle,merece_atencao,urgente'],
            'status' => ['nullable', 'in:a_fazer,fazendo,finalizada'],
            'inicio' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:' . $maxDate],
            'fim' => ['nullable', 'date', 'after_or_equal:inicio', 'before_or_equal:' . $maxDate],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.regex' => 'O título deve conter apenas letras e espaços.',
            'titulo.max' => 'O título não pode ter mais de 100 caracteres.',

            'descricao.required' => 'A descrição é obrigatória.',
            'descricao.max' => 'A descrição não pode ultrapassar 1000 caracteres.',

            'urgencia.required' => 'Selecione o nível de urgência.',
            'urgencia.in' => 'Urgência inválida.',

            'status.in' => 'Status inválido.',

            'inicio.required' => 'A data e hora de início são obrigatórias.',
            'inicio.after_or_equal' => 'A data de início não pode ser anterior a hoje.',
            'inicio.before_or_equal' => 'A data de início deve estar dentro dos próximos 12 meses.',

            'fim.after_or_equal' => 'A data de término deve ser posterior ou igual à data de início.',
            'fim.before_or_equal' => 'A data de término deve estar dentro dos próximos 12 meses.',
        ];
    }
}
