<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_pode_atualizar_perfil_com_dados_validos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $resposta = $this->patch('/profile', [
            'name' => 'Joao da Silva',
            'email' => 'joao@example.com',
        ]);

        $resposta->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Joao da Silva',
            'email' => 'joao@example.com',
        ]);
    }

    public function test_nao_deve_salvar_nome_invalido()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $resposta = $this->patch('/profile', [
            'name' => '123456',
            'email' => 'joao@example.com',
        ]);

        $resposta->assertSessionHasErrors(['name']);
    }

    public function test_nao_deve_salvar_email_invalido()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $resposta = $this->patch('/profile', [
            'name' => 'Joao',
            'email' => 'a@a.a',
        ]);

        $resposta->assertSessionHasErrors(['email']);
    }
}
