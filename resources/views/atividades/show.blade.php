<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">Detalhes da Atividade</h2>
  </x-slot>

  <div class="py-4 px-6 max-w-3xl mx-auto">
    <div class="bg-white p-6 rounded shadow">
      <h3 class="text-2xl font-bold mb-4">{{ $atividade->titulo }}</h3>

      <div class="space-y-2 text-gray-700">
        <p><strong>Descrição:</strong> {{ $atividade->descricao }}</p>

        <p>
          <strong>Urgência:</strong>
          @switch($atividade->urgencia)
            @case('sob_controle') <span class="text-green-600">Sob controle</span> @break
            @case('merece_atencao') <span class="text-yellow-600">Merece atenção</span> @break
            @case('urgente') <span class="text-red-600">Urgente</span> @break
          @endswitch
        </p>

        <p><strong>Início:</strong> {{ \Carbon\Carbon::parse($atividade->inicio)->format('d/m/Y H:i') }}</p>
        <p><strong>Fim:</strong> {{ \Carbon\Carbon::parse($atividade->fim)->format('d/m/Y H:i') }}</p>

        <p><strong>Status:</strong>
          @switch($atividade->status)
            @case('a_fazer') A Fazer @break
            @case('fazendo') Fazendo @break
            @case('finalizada') Finalizada @break
          @endswitch
        </p>
      </div>

      <!-- Botões -->
      <div class="flex justify-between mt-6">
        <a href="{{ route('atividades.index') }}" class="text-gray-600 hover:underline">← Voltar</a>

        <div class="flex gap-4">
          <a href="{{ route('atividades.edit', $atividade) }}"
             class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Editar
          </a>

          <form action="{{ route('atividades.destroy', $atividade) }}" method="POST"
                onsubmit="return confirm('Deseja mesmo excluir esta atividade?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
              Excluir
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
