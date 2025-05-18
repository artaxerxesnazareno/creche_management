@extends('layouts.app')

@section('title', 'Lista de Responsáveis')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Lista de Responsáveis</h1>
            <a href="{{ route('responsaveis.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Novo Responsável
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <strong>Sucesso!</strong> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Erro!</strong> {{ session('error') }}
        </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($responsaveis->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500 text-lg mb-4">Nenhum responsável cadastrado ainda.</p>
                    <a href="{{ route('responsaveis.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Cadastrar primeiro responsável
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Telefone
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Celular
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Parentesco
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($responsaveis as $responsavel)
                            <tr class="hover:bg-gray-50 cursor-pointer responsavel-row" data-href="{{ route('responsaveis.show', $responsavel) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('responsaveis.show', $responsavel) }}" class="text-sm font-medium text-blue-600 hover:text-blue-900">{{ $responsavel->nome }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $responsavel->telefone ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $responsavel->celular }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $responsavel->email ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $responsavel->parentesco ?: '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('responsaveis.show', $responsavel) }}" class="text-blue-600 hover:text-blue-900" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('responsaveis.edit', $responsavel) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('responsaveis.destroy', $responsavel) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este responsável?');">
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
                    {{ $responsaveis->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Tornar as linhas da tabela clicáveis
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.responsavel-row');
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
