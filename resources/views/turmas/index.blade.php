@extends('layouts.app')

@section('title', 'Gerenciar Turmas')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Turmas</h1>
            <a href="{{ route('turmas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nova Turma
            </a>
        </div>

        @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('turmas.index') }}" method="GET" class="mb-6">
                    <div class="flex items-center">
                        <div class="flex-grow">
                            <input type="text" name="search" placeholder="Buscar por nome ou descrição..." class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ request('search') }}">
                        </div>
                        <div class="ml-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                Buscar
                            </button>
                        </div>
                    </div>
                </form>

                @if($turmas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faixa Etária</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ano Letivo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Crianças</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacidade</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($turmas as $turma)
                            <tr class="hover:bg-gray-50 cursor-pointer turma-row" data-href="{{ route('turmas.show', $turma) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $turma->nome }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($turma->idade_minima !== null && $turma->idade_maxima !== null)
                                            {{ $turma->idade_minima }} a {{ $turma->idade_maxima }} anos
                                        @else
                                            Não definida
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $turma->ano_letivo ?? 'Não definido' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $turma->criancas_count ?? 0 }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($turma->capacidade)
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                @php
                                                    $percentual = min(100, ($turma->criancas_count / $turma->capacidade) * 100);
                                                    $corBarra = $percentual > 90 ? 'bg-red-600' : ($percentual > 70 ? 'bg-yellow-400' : 'bg-green-600');
                                                @endphp
                                                <div class="{{ $corBarra }} h-2.5 rounded-full" style="width: {{ $percentual }}%"></div>
                                            </div>
                                            <span class="text-xs">{{ $turma->criancas_count }}/{{ $turma->capacidade }}</span>
                                        @else
                                            Não definida
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('turmas.show', $turma) }}" class="text-blue-600 hover:text-blue-900" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('turmas.edit', $turma) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('turmas.destroy', $turma) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta turma?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $turmas->links() }}
                </div>
                @else
                <div class="text-center py-10">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma turma encontrada</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Comece criando uma nova turma para sua creche.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('turmas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nova Turma
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Tornar as linhas da tabela clicáveis
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.turma-row');
        rows.forEach(row => {
            row.addEventListener('click', function(e) {
                // Evitar que o clique nos botões de ação leve à página de detalhes
                if (!e.target.closest('a') && !e.target.closest('button') && !e.target.closest('form')) {
                    window.location.href = this.dataset.href;
                }
            });
        });
    });
</script>
@endsection
