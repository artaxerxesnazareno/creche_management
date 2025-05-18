@extends('layouts.app')

@section('title', 'Detalhes do Responsável')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('responsaveis.index') }}" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Detalhes do Responsável</h1>
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
                <div class="flex justify-between items-start mb-6">
                    <h2 class="text-xl font-bold text-gray-800">{{ $responsavel->nome }}</h2>
                    <div class="flex space-x-2">
                        <a href="{{ route('responsaveis.edit', $responsavel) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                            Editar
                        </a>
                        <form action="{{ route('responsaveis.destroy', $responsavel) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150" onclick="return confirm('Tem certeza que deseja excluir este responsável?')">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Informações Pessoais</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Parentesco</p>
                            <p class="text-base text-gray-900">{{ $responsavel->parentesco ?: 'Não informado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Bilhete de Identidade (BI)</p>
                            <p class="text-base text-gray-900">{{ $responsavel->bi ?: 'Não informado' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Contato</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Telefone</p>
                            <p class="text-base text-gray-900">{{ $responsavel->telefone ?: 'Não informado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Celular</p>
                            <p class="text-base text-gray-900">{{ $responsavel->celular }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-base text-gray-900">{{ $responsavel->email ?: 'Não informado' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Endereço</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Endereço Completo</p>
                            <p class="text-base text-gray-900">{{ $responsavel->endereco ?: 'Não informado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Bairro</p>
                            <p class="text-base text-gray-900">{{ $responsavel->bairro ?: 'Não informado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Município</p>
                            <p class="text-base text-gray-900">{{ $responsavel->municipio ?: 'Não informado' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Província</p>
                            <p class="text-base text-gray-900">{{ $responsavel->provincia ?: 'Não informado' }}</p>
                        </div>
                    </div>
                </div>

                @if($responsavel->obs)
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Observações</h3>
                    <p class="text-base text-gray-900 whitespace-pre-line">{{ $responsavel->obs }}</p>
                </div>
                @endif

                <div class="mt-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Crianças Vinculadas</h3>

                    @if($criancasPrincipais->isEmpty() && $criancasSecundarias->isEmpty())
                    <p class="text-gray-500">Este responsável não está vinculado a nenhuma criança.</p>
                    @else

                    @if($criancasPrincipais->isNotEmpty())
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-2">Como Responsável Principal</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($criancasPrincipais as $crianca)
                            <div class="border rounded-lg overflow-hidden">
                                <div class="p-4">
                                    <div class="flex items-center">
                                        <div class="mr-3">
                                            @if($crianca->foto)
                                            <img src="{{ Storage::url($crianca->foto) }}" alt="{{ $crianca->nome }}" class="h-10 w-10 rounded-full object-cover">
                                            @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">Sem foto</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h5 class="text-base font-medium text-gray-900">{{ $crianca->nome }}</h5>
                                            <p class="text-sm text-gray-500">{{ $crianca->idade_formatada }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('criancas.show', $crianca) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                            Ver detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($criancasSecundarias->isNotEmpty())
                    <div>
                        <h4 class="text-md font-medium text-gray-700 mb-2">Como Responsável Secundário</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($criancasSecundarias as $crianca)
                            <div class="border rounded-lg overflow-hidden">
                                <div class="p-4">
                                    <div class="flex items-center">
                                        <div class="mr-3">
                                            @if($crianca->foto)
                                            <img src="{{ Storage::url($crianca->foto) }}" alt="{{ $crianca->nome }}" class="h-10 w-10 rounded-full object-cover">
                                            @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">Sem foto</span>
                                            </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h5 class="text-base font-medium text-gray-900">{{ $crianca->nome }}</h5>
                                            <p class="text-sm text-gray-500">{{ $crianca->idade_formatada }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <a href="{{ route('criancas.show', $crianca) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                            Ver detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
