@extends('layouts.app')

@section('title', 'Gestão de Matrículas')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Gestão de Matrículas</h1>
            <a href="{{ route('matriculas.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nova Matrícula
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between mb-4">
                    <div class="w-1/3">
                        <form action="{{ route('matriculas.index') }}" method="GET">
                            <div class="flex">
                                <input type="text" name="search" placeholder="Buscar por nome da criança..." class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ request('search') }}">
                                <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Buscar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div>
                        <form action="{{ route('matriculas.index') }}" method="GET">
                            @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select name="filter" id="filter" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" onchange="this.form.submit()">
                                <option value="">Filtrar por status</option>
                                <option value="ativa" {{ request('filter') == 'ativa' ? 'selected' : '' }}>Ativa</option>
                                <option value="pendente" {{ request('filter') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="cancelada" {{ request('filter') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                <option value="concluída" {{ request('filter') == 'concluída' ? 'selected' : '' }}>Concluída</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criança</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turma</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Início</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($matriculas ?? [] as $matricula)
                            <tr class="hover:bg-gray-50 cursor-pointer matricula-row" data-href="{{ route('matriculas.show', $matricula->id) }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $matricula->codigo }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($matricula->crianca && $matricula->crianca->foto)
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $matricula->crianca->foto) }}" alt="{{ $matricula->crianca->nome ?? 'Criança' }}">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-500 text-xs">Sem foto</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $matricula->crianca->nome ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $matricula->turma->nome ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $matricula->data_inicio_formatada }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $matricula->status == 'Ativa' ? 'bg-green-100 text-green-800' :
                                           ($matricula->status == 'Pendente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $matricula->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('matriculas.show', $matricula->id) }}" class="text-blue-600 hover:text-blue-900" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('matriculas.edit', $matricula->id) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('matriculas.destroy', $matricula->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta matrícula?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Nenhuma matrícula encontrada.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $matriculas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tornar as linhas da tabela clicáveis
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('.matricula-row');
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
