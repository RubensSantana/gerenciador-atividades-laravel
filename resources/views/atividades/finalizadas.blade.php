<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">Atividades Finalizadas</h2>
  </x-slot>

  <div class="py-4 px-6 max-w-4xl mx-auto">

    <!-- Mensagem de erro (ex: tentativa de buscar data anterior a hoje) -->
    @if (session('error'))
      <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
        {{ session('error') }}
      </div>
    @endif

    <!-- Filtro por data -->
    <form method="GET" class="flex items-center gap-2 mb-6">
      <label for="data" class="font-semibold">Selecionar data:</label>
      <input
        type="date"
        name="data"
        id="data"
        value="{{ $data }}"
        min="{{ \Carbon\Carbon::today()->format('Y-m-d') }}"
        class="border rounded px-2 py-1"
      >
      <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
        Filtrar
      </button>
      <a href="{{ route('atividades.index') }}" class="text-gray-600 hover:underline ml-auto">← Voltar</a>
    </form>

    <!-- Lista de atividades -->
    @forelse ($atividades as $atividade)
      <div class="bg-white rounded shadow p-4 mb-4 border-l-4
        @if($atividade->urgencia == 'urgente') border-red-600
        @elseif($atividade->urgencia == 'merece_atencao') border-yellow-500
        @else border-green-500 @endif">
        <h3 class="text-lg font-semibold">{{ $atividade->titulo }}</h3>
        <p class="text-gray-600 text-sm">{{ $atividade->descricao }}</p>
        <p class="text-sm text-gray-500 mt-2">
          Finalizada em: {{ \Carbon\Carbon::parse($atividade->fim)->format('d/m/Y H:i') }}
        </p>
        <a href="{{ route('atividades.show', $atividade) }}" class="text-blue-600 text-sm hover:underline mt-1 block">
          Ver detalhes
        </a>
      </div>
    @empty
      <p class="text-gray-500">Nenhuma atividade finalizada nessa data.</p>
    @endforelse
  </div>
</x-app-layout>
