<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Minhas Atividades</h2>
    </x-slot>

    <div class="py-4 px-6">
        {{-- Mensagem de sucesso --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Botão Nova Atividade --}}
        <div class="mb-6">
            <a href="{{ route('atividades.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Nova Atividade
            </a>
        </div>

        {{-- Quadro Kanban --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach (['a_fazer' => 'A Fazer', 'fazendo' => 'Fazendo', 'finalizada' => 'Finalizadas (Hoje)'] as $status => $label)
                <div class="bg-white shadow rounded p-4">
                    <h3 class="font-bold text-lg mb-4">{{ $label }}</h3>

                    @forelse ($atividades[$status] ?? [] as $atividade)
                        @if($status != 'finalizada' || \Carbon\Carbon::parse($atividade->fim)->isToday())
                            <div class="p-3 mb-3 rounded border-l-4
                                @if($atividade->urgencia == 'urgente') border-red-600
                                @elseif($atividade->urgencia == 'merece_atencao') border-yellow-500
                                @else border-green-500 @endif
                                bg-gray-50 hover:bg-gray-100 transition">

                                <a href="{{ route('atividades.show', $atividade) }}" class="block">
                                    <div class="flex items-center gap-2 mb-1">
                                        {{-- Badge de urgência --}}
                                        @switch($atividade->urgencia)
                                            @case('urgente')
                                                <span class="text-xs bg-red-600 text-white px-2 py-1 rounded-full uppercase">Urgente</span>
                                                @break
                                            @case('merece_atencao')
                                                <span class="text-xs bg-yellow-400 text-black px-2 py-1 rounded-full uppercase">Merece atenção</span>
                                                @break
                                            @case('sob_controle')
                                                <span class="text-xs bg-green-600 text-white px-2 py-1 rounded-full uppercase">Sob controle</span>
                                                @break
                                        @endswitch

                                        {{-- Título --}}
                                        <strong class="text-sm">{{ $atividade->titulo }}</strong>
                                    </div>

                                    {{-- Data/hora --}}
                                    <p class="text-xs text-gray-600">
                                        {{ \Carbon\Carbon::parse($atividade->inicio)->format('d/m/Y H:i') }}
                                    </p>
                                </a>
                            </div>
                        @endif
                    @empty
                        <p class="text-sm text-gray-500">Nenhuma atividade</p>
                    @endforelse
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
