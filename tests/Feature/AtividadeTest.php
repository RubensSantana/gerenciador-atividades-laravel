<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Atividade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtividadeTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_autenticado_pode_criar_atividade()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $resposta = $this->post('/atividades', [
            'titulo' => 'Teste',
            'descricao' => 'Descrição da atividade de teste',
            'urgencia' => 'sob_controle',
            'status' => 'a_fazer',
            'inicio' => now()->addHour()->toDateTimeString(),
            'fim' => now()->addDays(2)->toDateTimeString(),
        ]);

        $resposta->assertRedirect('/atividades');
        $this->assertDatabaseHas('atividades', [
            'titulo' => 'Teste',
            'user_id' => $user->id,
        ]);
    }

    public function test_nao_autenticado_nao_pode_criar_atividade()
    {
        $resposta = $this->post('/atividades', [
            'titulo' => 'Sem login',
            'descricao' => 'Tentativa sem login',
            'urgencia' => 'sob_controle',
            'status' => 'a_fazer',
            'inicio' => now()->addHour()->toDateTimeString(),
            'fim' => now()->addDays(2)->toDateTimeString(),
        ]);

        $resposta->assertRedirect('/login');
    }

    public function test_usuario_pode_editar_atividade()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $atividade = Atividade::create([
            'user_id' => $user->id,
            'titulo' => 'Original',
            'descricao' => 'Texto inicial',
            'urgencia' => 'sob_controle',
            'status' => 'a_fazer',
            'inicio' => now()->addDay(),
            'fim' => now()->addDays(2),
        ]);

        $resposta = $this->put("/atividades/{$atividade->id}", [
            'titulo' => 'Atualizado',
            'descricao' => 'Texto atualizado',
            'urgencia' => 'urgente',
            'status' => 'fazendo',
            'inicio' => now()->addDay(),
            'fim' => now()->addDays(3),
        ]);

        $resposta->assertRedirect('/atividades');
        $this->assertDatabaseHas('atividades', [
            'id' => $atividade->id,
            'titulo' => 'Atualizado',
            'descricao' => 'Texto atualizado',
            'urgencia' => 'urgente',
            'status' => 'fazendo',
        ]);
    }

    public function test_usuario_pode_excluir_atividade()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $atividade = Atividade::create([
            'user_id' => $user->id,
            'titulo' => 'Excluir',
            'descricao' => 'Texto',
            'urgencia' => 'sob_controle',
            'status' => 'a_fazer',
            'inicio' => now()->addDay(),
            'fim' => now()->addDays(2),
        ]);

        $resposta = $this->delete("/atividades/{$atividade->id}");

        $resposta->assertRedirect('/atividades');
        $this->assertDatabaseMissing('atividades', [
            'id' => $atividade->id,
        ]);
    }

    public function test_usuario_pode_ver_lista_de_atividades()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Atividade::factory()->count(2)->create([
            'user_id' => $user->id,
        ]);

        $resposta = $this->get('/atividades');
        $resposta->assertStatus(200);
        $resposta->assertSee('Atividades');
    }

    public function test_validacao_falha_quando_campos_sao_invalidos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $resposta = $this->post('/atividades', [
            'titulo' => '',
            'descricao' => '',
            'urgencia' => 'errado',
            'status' => 'desconhecido',
            'inicio' => 'ontem',
            'fim' => '2000-01-01 00:00',
        ]);

        $resposta->assertSessionHasErrors([
            'titulo',
            'descricao',
            'urgencia',
            'status',
            'inicio',
            'fim',
        ]);
    }
}
