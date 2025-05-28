<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Atividade extends Model
{
    use HasFactory;

    // Permitir atribuição em massa para esses campos
    protected $fillable = [
        'user_id',
        'titulo',
        'descricao',
        'urgencia',
        'status',
        'inicio',
        'fim',
    ];

    // Relacionamento com User (cada atividade pertence a um usuário)
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
