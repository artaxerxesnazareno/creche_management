@extends('layouts.app')

@section('title', 'Detalhes da Matrícula')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('matriculas.index') }}" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Detalhes da Matrícula</h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            Matrícula #{{ $matricula->id }} - {{ $matricula->crianca->nome }}
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $matricula->status == 'Ativa' ? 'bg-green-100 text-green-800' :
                                   ($matricula->status == 'Pendente' ? 'bg-yellow-100 text-yellow-800' :
                                   ($matricula->status == 'Concluída' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $matricula->status }}
                            </span>
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('matriculas.edit', $matricula) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                            Editar
                        </a>
                        <form action="{{ route('matriculas.destroy', $matricula) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150" onclick="return confirm('Tem certeza que deseja excluir esta matrícula?')">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Dados da Matrícula</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Turma</p>
                                <p class="text-base text-gray-900">{{ $matricula->turma->nome }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Período</p>
                                <p class="text-base text-gray-900">{{ $matricula->periodo }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Data de Início</p>
                                <p class="text-base text-gray-900">{{ $matricula->data_inicio_formatada }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Data de Término</p>
                                <p class="text-base text-gray-900">{{ $matricula->data_fim_formatada ?? 'Não definida' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Dados Financeiros</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Valor da Mensalidade</p>
                                <p class="text-base text-gray-900">Kz {{ number_format($matricula->valor_mensalidade, 2, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Desconto</p>
                                <p class="text-base text-gray-900">{{ $matricula->desconto }}%</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Valor com Desconto</p>
                                <p class="text-base text-gray-900 font-semibold">Kz {{ number_format($matricula->valor_com_desconto, 2, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Taxa de Matrícula</p>
                                <p class="text-base text-gray-900">Kz {{ number_format($matricula->taxa_matricula, 2, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Dia de Vencimento</p>
                                <p class="text-base text-gray-900">{{ $matricula->dia_vencimento }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Dados da Criança</h3>
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/4 flex justify-center mb-4 md:mb-0">
                            @if($matricula->crianca->foto)
                            <div class="w-32 h-32 rounded-full overflow-hidden">
                                <img src="{{ asset('storage/' . $matricula->crianca->foto) }}" alt="{{ $matricula->crianca->nome }}" class="w-full h-full object-cover">
                            </div>
                            @else
                            <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-gray-500 text-lg">Sem foto</span>
                            </div>
                            @endif
                        </div>
                        <div class="md:w-3/4 md:pl-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Nome</p>
                                    <p class="text-base text-gray-900">{{ $matricula->crianca->nome }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Idade</p>
                                    <p class="text-base text-gray-900">{{ $matricula->crianca->idade_formatada }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Gênero</p>
                                    <p class="text-base text-gray-900">{{ $matricula->crianca->genero }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Responsável Principal</p>
                                    <p class="text-base text-gray-900">{{ $matricula->crianca->responsavelPrincipal->nome ?? 'Não definido' }}</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('criancas.show', $matricula->crianca) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                    Ver perfil completo da criança
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if($matricula->observacoes)
                <div class="mt-6 bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Observações</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $matricula->observacoes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
