<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">Nova Atividade</h2>
  </x-slot>

  <div class="py-4 px-6 max-w-3xl mx-auto">
    <form method="POST" action="{{ route('atividades.store') }}" class="bg-white p-6 rounded shadow">
      @csrf

      <!-- Título -->
      <div class="mb-4">
        <label for="titulo" class="block font-semibold">Título</label>
        <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}"
               class="w-full border-gray-300 rounded mt-1" required>
        @error('titulo')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Descrição -->
      <div class="mb-4">
        <label for="descricao" class="block font-semibold">Descrição</label>
        <textarea name="descricao" id="descricao" rows="4"
                  class="w-full border-gray-300 rounded mt-1" required>{{ old('descricao') }}</textarea>
        @error('descricao')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Urgência -->
      <div class="mb-4">
        <label for="urgencia" class="block font-semibold">Urgência</label>
        <select name="urgencia" id="urgencia" class="w-full border-gray-300 rounded mt-1" required>
          <option value="">Selecione...</option>
          <option value="sob_controle" {{ old('urgencia') == 'sob_controle' ? 'selected' : '' }}>Sob controle</option>
          <option value="merece_atencao" {{ old('urgencia') == 'merece_atencao' ? 'selected' : '' }}>Merece atenção</option>
          <option value="urgente" {{ old('urgencia') == 'urgente' ? 'selected' : '' }}>Urgente</option>
        </select>
        @error('urgencia')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Status -->
      <div class="mb-4">
        <label for="status" class="block font-semibold">Status</label>
        <select name="status" id="status" class="w-full border-gray-300 rounded mt-1" required>
          <option value="a_fazer" {{ old('status') == 'a_fazer' ? 'selected' : '' }}>A Fazer</option>
          <option value="fazendo" {{ old('status') == 'fazendo' ? 'selected' : '' }}>Fazendo</option>
          <option value="finalizada" {{ old('status') == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
        </select>
        @error('status')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Início -->
      <div class="mb-4">
        <label for="inicio" class="block font-semibold">Data e Hora de Início</label>
        <input type="datetime-local" name="inicio" id="inicio" value="{{ old('inicio') }}"
               class="w-full border-gray-300 rounded mt-1" required>
        @error('inicio')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Fim -->
      <div class="mb-4">
        <label for="fim" class="block font-semibold">Data e Hora de Fim</label>
        <input type="datetime-local" name="fim" id="fim" value="{{ old('fim') }}"
               class="w-full border-gray-300 rounded mt-1" required>
        @error('fim')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Botões -->
      <div class="flex justify-between mt-6">
        <a href="{{ route('atividades.index') }}" class="text-gray-600 hover:underline">← Voltar</a>
        <button type="submit"
            onclick="this.disabled=true; this.innerText='Salvando...'; this.form.submit();"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Salvar Atividade
        </button>
      </div>
    </form>
  </div>
</x-app-layout>
