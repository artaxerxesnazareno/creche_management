@extends('layouts.app')

@section('title', 'Lista de Crianças')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Lista de Crianças</h1>
            <a href="{{ route('criancas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> Nova Criança
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <strong>Sucesso!</strong> {{ session('success') }}
        </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($criancas->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500 text-lg mb-4">Nenhuma criança cadastrada ainda.</p>
                    <a href="{{ route('criancas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Cadastrar primeira criança
                    </a>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Foto
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nome
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Idade
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Gênero
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Turma
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Período
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($criancas as $crianca)
                            <tr class="hover:bg-gray-50 cursor-pointer crianca-row" data-href="{{ route('criancas.show', $crianca) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('criancas.show', $crianca) }}" class="block">
                                        @if($crianca->foto)
                                        <img src="{{ Storage::url($crianca->foto) }}" alt="{{ $crianca->nome }}" class="h-10 w-10 rounded-full object-cover hover:opacity-80 transition">
                                        @else
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center hover:bg-gray-300 transition">
                                            <span class="text-gray-500 text-xs">Sem foto</span>
                                        </div>
                                        @endif
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('criancas.show', $crianca) }}" class="text-sm font-medium text-blue-600 hover:text-blue-900">{{ $crianca->nome }}</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->idade_formatada }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->genero }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->turma->nome ?? 'Não atribuída' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $crianca->periodo ?? 'Não definido' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('criancas.show', $crianca) }}" class="text-blue-600 hover:text-blue-900" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('criancas.edit', $crianca) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('criancas.destroy', $crianca) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta criança?');">
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
                    {{ $criancas->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Tornar as linhas da tabela clicáveis
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.crianca-row');
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
