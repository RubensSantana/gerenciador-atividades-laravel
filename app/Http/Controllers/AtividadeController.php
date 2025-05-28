<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Atividade;
use App\Http\Requests\AtividadeRequest;

class AtividadeController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $atividades = Atividade::where('user_id', $userId)
            ->orderBy('inicio')
            ->get()
            ->groupBy('status');

        return view('atividades.index', compact('atividades'));
    }

    public function create()
    {
        return view('atividades.create');
    }

    public function store(AtividadeRequest $request)
    {
        Atividade::create([
            'user_id'   => Auth::id(),
            'titulo'    => $request->titulo,
            'descricao' => $request->descricao,
            'urgencia'  => $request->urgencia,
            'status'    => $request->status,
            'inicio'    => $request->inicio,
            'fim'       => $request->status === 'finalizada' ? now() : $request->fim,
        ]);

        return redirect()->route('atividades.index')->with('success', 'Atividade criada com sucesso!');
    }

    public function show(string $id)
    {
        $atividade = Atividade::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('atividades.show', compact('atividade'));
    }

    public function edit(string $id)
    {
        $atividade = Atividade::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('atividades.edit', compact('atividade'));
    }

    public function update(AtividadeRequest $request, string $id)
    {
        $atividade = Atividade::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $dados = $request->only(['titulo', 'descricao', 'urgencia', 'status', 'inicio']);

        // Define a data de fim automaticamente se for finalizada
        $dados['fim'] = $request->status === 'finalizada' ? now() : $request->fim;

        $atividade->update($dados);

        return redirect()->route('atividades.index')->with('success', 'Atividade atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $atividade = Atividade::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $atividade->delete();

        return redirect()->route('atividades.index')->with('success', 'Atividade excluída com sucesso!');
    }

    public function finalizadas(Request $request)
    {
        $hoje = now()->toDateString();
        $data = $request->input('data') ?? $hoje;

        // Impedir visualização de datas anteriores a hoje
        if ($data < $hoje) {
            return redirect()->route('atividades.finalizadas')->with('error', 'Não é possível consultar datas anteriores.');
        }

        $atividades = Atividade::where('user_id', Auth::id())
            ->where('status', 'finalizada')
            ->whereDate('fim', $data)
            ->get();

        return view('atividades.finalizadas', compact('atividades', 'data'));
    }
}
