@extends('layouts.app')

@section('title', 'Relatório de Crianças')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('relatorios.index') }}" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Relatório de Crianças</h1>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('relatorios.criancas') }}" method="GET" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="turma_id" class="block text-sm font-medium text-gray-700 mb-1">Turma</label>
                            <select name="turma_id" id="turma_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="">Todas as turmas</option>
                                @foreach($turmas ?? [] as $turma)
                                    <option value="{{ $turma->id }}" {{ request('turma_id') == $turma->id ? 'selected' : '' }}>{{ $turma->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="idade_min" class="block text-sm font-medium text-gray-700 mb-1">Idade Mínima</label>
                            <input type="number" name="idade_min" id="idade_min" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ request('idade_min') }}" min="0" max="10">
                        </div>
                        
                        <div>
                            <label for="idade_max" class="block text-sm font-medium text-gray-700 mb-1">Idade Máxima</label>
                            <input type="number" name="idade_max" id="idade_max" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ request('idade_max') }}" min="0" max="10">
                        </div>
                        
                        <div>
                            <label for="genero" class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
                            <select name="genero" id="genero" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="">Todos</option>
                                <option value="Masculino" {{ request('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Feminino" {{ request('genero') == 'Feminino' ? 'selected' : '' }}>Feminino</option>
                                <option value="Outro" {{ request('genero') == 'Outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-4 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Filtrar
                            </button>
                            <a href="{{ route('relatorios.criancas.exportar', request()->all()) }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Exportar para Excel
                            </a>
                        </div>
                    </div>
                </form>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Nascimento</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Idade</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gênero</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turma</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsáveis</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($criancas ?? [] as $crianca)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ $crianca->foto_url ?? '/img/placeholder.png' }}" alt="{{ $crianca->nome }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $crianca->nome }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->data_nascimento_formatada }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->idade }} anos</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->genero }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->turma->nome ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->periodo }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->responsaveis_count ?? 0 }}</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Nenhuma criança encontrada com os filtros selecionados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $criancas->links() }}
                </div>
                
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Resumo</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Total de crianças:</p>
                            <p class="text-lg font-semibold">{{ $total ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Distribuição por gênero:</p>
                            <p class="text-sm">Masculino: {{ $totalMasculino ?? 0 }} ({{ $percentualMasculino ?? '0%' }})</p>
                            <p class="text-sm">Feminino: {{ $totalFeminino ?? 0 }} ({{ $percentualFeminino ?? '0%' }})</p>
                            <p class="text-sm">Outro: {{ $totalOutro ?? 0 }} ({{ $percentualOutro ?? '0%' }})</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Média de idade:</p>
                            <p class="text-lg font-semibold">{{ $mediaIdade ?? '0' }} anos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
