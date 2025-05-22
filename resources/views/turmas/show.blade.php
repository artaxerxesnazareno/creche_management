@extends('layouts.app')

@section('title', 'Detalhes da Turma')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('turmas.index') }}" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Detalhes da Turma</h1>
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
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $turma->nome }}</h2>
                        <p class="text-sm text-gray-600 mt-1">Ano Letivo: {{ $turma->ano_letivo ?? 'Não definido' }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('turmas.edit', $turma) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                            Editar
                        </a>
                        <form action="{{ route('turmas.destroy', $turma) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150" onclick="return confirm('Tem certeza que deseja excluir esta turma?')">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Informações da Turma</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Faixa Etária</p>
                                <p class="text-base text-gray-900">
                                    @if($turma->idade_minima !== null && $turma->idade_maxima !== null)
                                        {{ $turma->idade_minima }} a {{ $turma->idade_maxima }} anos
                                    @else
                                        Não definida
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Capacidade</p>
                                <p class="text-base text-gray-900">{{ $turma->capacidade ?? 'Não definida' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Sala</p>
                                <p class="text-base text-gray-900">{{ $turma->sala ?? 'Não definida' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total de Crianças</p>
                                <p class="text-base text-gray-900">{{ $turma->criancas->count() }}</p>
                            </div>
                        </div>

                        @if($turma->descricao)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500">Descrição</p>
                            <p class="text-base text-gray-900">{{ $turma->descricao }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Estatísticas</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Vagas Ocupadas</p>
                                <p class="text-base text-gray-900">
                                    {{ $turma->criancas->count() }} / {{ $turma->capacidade ?? '-' }}
                                    @if($turma->capacidade)
                                        ({{ round(($turma->criancas->count() / $turma->capacidade) * 100) }}%)
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Vagas Disponíveis</p>
                                <p class="text-base text-gray-900">
                                    @if($turma->capacidade)
                                        {{ max(0, $turma->capacidade - $turma->criancas->count()) }}
                                    @else
                                        Não definido
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Crianças Matriculadas</h3>

                    @if($turma->criancas->count() > 0)
                        <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Idade</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($turma->criancas as $crianca)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($crianca->foto)
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $crianca->foto) }}" alt="{{ $crianca->nome }}">
                                                    @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span class="text-gray-500 text-xs">Sem foto</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $crianca->nome }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $crianca->idade_formatada }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $crianca->periodo ?? 'Não definido' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $crianca->responsavelPrincipal->nome ?? 'Não definido' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('criancas.show', $crianca) }}" class="text-indigo-600 hover:text-indigo-900">Ver</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-gray-500">Nenhuma criança matriculada nesta turma.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
