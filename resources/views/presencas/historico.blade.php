@extends('layouts.app')

@section('title', 'Histórico de Presenças')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('criancas.show', $crianca) }}#presenca" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Histórico de Presenças</h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex items-center mb-6">
                    <div class="mr-4">
                        @if($crianca->foto)
                        <img src="{{ Storage::url($crianca->foto) }}" alt="{{ $crianca->nome }}" class="h-16 w-16 rounded-full object-cover">
                        @else
                        <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500 text-xs">Sem foto</span>
                        </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $crianca->nome }}</h2>
                        <p class="text-gray-600">{{ $crianca->idade_formatada }} • {{ $crianca->turma->nome ?? 'Sem turma' }}</p>
                    </div>
                </div>

                @if($presencas->isEmpty())
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Sem registros de presença</h3>
                    <p class="mt-1 text-sm text-gray-500">Esta criança ainda não possui nenhum registro de presença.</p>
                    <div class="mt-6">
                        <a href="{{ route('presenca.registrar-entrada', $crianca) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Registrar Entrada
                        </a>
                    </div>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrada</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saída</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável Entrada</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável Saída</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($presencas as $presenca)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->data_formatada }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->hora_entrada_formatada }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->hora_saida_formatada ?: '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->responsavelEntrada->nome ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->responsavelSaida->nome ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if($presenca->observacoes)
                                    <button type="button" class="text-blue-600 hover:text-blue-900" onclick="toggleObservacoes('obs-{{ $presenca->id }}')">
                                        Ver observações
                                    </button>
                                    <div id="obs-{{ $presenca->id }}" class="hidden mt-2 p-2 bg-gray-50 rounded text-sm">
                                        {!! nl2br(e($presenca->observacoes)) !!}
                                    </div>
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $presencas->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function toggleObservacoes(id) {
        const element = document.getElementById(id);
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
        } else {
            element.classList.add('hidden');
        }
    }
</script>
@endsection
