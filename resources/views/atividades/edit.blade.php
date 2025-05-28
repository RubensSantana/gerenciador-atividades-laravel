<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">Editar Atividade</h2>
  </x-slot>

  <div class="py-4 px-6 max-w-3xl mx-auto">
    <form method="POST" action="{{ route('atividades.update', $atividade->id) }}" class="bg-white p-6 rounded shadow">
      @csrf
      @method('PUT')

      <!-- Título -->
      <div class="mb-4">
        <label for="titulo" class="block font-semibold">Título</label>
        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $atividade->titulo) }}"
               class="w-full border-gray-300 rounded mt-1" required>
        @error('titulo')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Descrição -->
      <div class="mb-4">
        <label for="descricao" class="block font-semibold">Descrição</label>
        <textarea name="descricao" id="descricao" rows="4"
                  class="w-full border-gray-300 rounded mt-1" required>{{ old('descricao', $atividade->descricao) }}</textarea>
        @error('descricao')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Urgência -->
      <div class="mb-4">
        <label for="urgencia" class="block font-semibold">Urgência</label>
        <select name="urgencia" id="urgencia" class="w-full border-gray-300 rounded mt-1" required>
          <option value="">Selecione...</option>
          <option value="sob_controle" {{ old('urgencia', $atividade->urgencia) == 'sob_controle' ? 'selected' : '' }}>Sob controle</option>
          <option value="merece_atencao" {{ old('urgencia', $atividade->urgencia) == 'merece_atencao' ? 'selected' : '' }}>Merece atenção</option>
          <option value="urgente" {{ old('urgencia', $atividade->urgencia) == 'urgente' ? 'selected' : '' }}>Urgente</option>
        </select>
        @error('urgencia')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Status -->
      <div class="mb-4">
        <label for="status" class="block font-semibold">Status</label>
        <select name="status" id="status" class="w-full border-gray-300 rounded mt-1" required onchange="verificaStatus()">
          <option value="a_fazer" {{ old('status', $atividade->status) == 'a_fazer' ? 'selected' : '' }}>A Fazer</option>
          <option value="fazendo" {{ old('status', $atividade->status) == 'fazendo' ? 'selected' : '' }}>Fazendo</option>
          <option value="finalizada" {{ old('status', $atividade->status) == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
        </select>
        @error('status')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Início -->
      <div class="mb-4">
        <label for="inicio" class="block font-semibold">Data e Hora de Início</label>
        <input type="datetime-local" name="inicio" id="inicio" value="{{ old('inicio', $atividade->inicio) }}"
               class="w-full border-gray-300 rounded mt-1" required>
        @error('inicio')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Fim -->
      <div class="mb-4" id="campo-fim">
        <label for="fim" class="block font-semibold">Data e Hora de Fim</label>
        <input type="datetime-local" name="fim" id="fim" value="{{ old('fim', $atividade->fim) }}"
               class="w-full border-gray-300 rounded mt-1">
        <p id="mensagem-fim" class="text-sm text-gray-500 mt-1 hidden">
          Este campo será preenchido automaticamente ao finalizar a atividade.
        </p>
        @error('fim')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Botões -->
      <div class="flex justify-between mt-6">
        <a href="{{ route('atividades.index') }}" class="text-gray-600 hover:underline">← Voltar</a>
        <button
            type="submit"
            onclick="this.disabled=true; this.innerText='Atualizando...'; this.form.submit();"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Atualizar Atividade
        </button>
      </div>
    </form>
  </div>

  <!-- Script para ocultar ou mostrar o campo de fim -->
  <script>
    function verificaStatus() {
      const status = document.getElementById('status').value;
      const campoFim = document.getElementById('campo-fim');
      const inputFim = document.getElementById('fim');
      const mensagem = document.getElementById('mensagem-fim');

      if (status === 'finalizada') {
        inputFim.disabled = true;
        mensagem.classList.remove('hidden');
      } else {
        inputFim.disabled = false;
        mensagem.classList.add('hidden');
      }
    }

    // Executa ao carregar a página
    window.onload = verificaStatus;
  </script>
</x-app-layout>
