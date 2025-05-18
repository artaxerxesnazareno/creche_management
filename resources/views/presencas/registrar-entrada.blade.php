@extends('layouts.app')

@section('title', 'Registrar Entrada')

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
            <h1 class="text-2xl font-semibold text-gray-800">Registrar Entrada</h1>
        </div>

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Erro!</strong> Por favor, corrija os seguintes erros:
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

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

                <form action="{{ route('presenca.salvar-entrada', $crianca) }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="data_atual" class="block text-sm font-medium text-gray-700">Data</label>
                            <input type="text" id="data_atual" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-700 bg-gray-100" value="{{ now()->format('d/m/Y') }}" disabled>
                        </div>

                        <div>
                            <label for="hora_atual" class="block text-sm font-medium text-gray-700">Hora de Entrada</label>
                            <input type="text" id="hora_atual" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-700 bg-gray-100" value="{{ now()->format('H:i') }}" disabled>
                        </div>

                        <div class="md:col-span-2">
                            <label for="responsavel_entrada_id" class="block text-sm font-medium text-gray-700">Responsável pela Entrada <span class="text-red-500">*</span></label>
                            <select id="responsavel_entrada_id" name="responsavel_entrada_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('responsavel_entrada_id') border-red-500 @enderror" required>
                                <option value="">Selecione um responsável</option>
                                @foreach($responsaveis as $responsavel)
                                <option value="{{ $responsavel->id }}" @if(old('responsavel_entrada_id') == $responsavel->id) selected @endif>
                                    {{ $responsavel->nome }}
                                </option>
                                @endforeach
                            </select>
                            @error('responsavel_entrada_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea id="observacoes" name="observacoes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('observacoes') border-red-500 @enderror">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Opcional. Informe qualquer observação relevante sobre a entrada da criança.</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('criancas.show', $crianca) }}#presenca" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Registrar Entrada
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
