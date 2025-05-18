@extends('layouts.app')

@section('title', 'Registrar Presença')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('presenca.index') }}" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Registrar Presença</h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('presenca.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Dados da Presença</h2>
                        </div>

                        <div>
                            <label for="crianca_id" class="block text-sm font-medium text-gray-700">Criança</label>
                            <select name="crianca_id" id="crianca_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Selecione uma criança</option>
                                @foreach($criancas ?? [] as $crianca)
                                    <option value="{{ $crianca->id }}" {{ old('crianca_id') == $crianca->id ? 'selected' : '' }}>{{ $crianca->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="data" class="block text-sm font-medium text-gray-700">Data</label>
                            <input type="date" name="data" id="data" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('data') ?? date('Y-m-d') }}" required>
                        </div>

                        <div>
                            <label for="hora_entrada" class="block text-sm font-medium text-gray-700">Hora de Entrada</label>
                            <input type="time" name="hora_entrada" id="hora_entrada" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('hora_entrada') ?? date('H:i') }}" required>
                        </div>

                        <div>
                            <label for="responsavel_entrada_id" class="block text-sm font-medium text-gray-700">Responsável pela Entrada</label>
                            <select name="responsavel_entrada_id" id="responsavel_entrada_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Selecione um responsável</option>
                                @foreach($responsaveis ?? [] as $responsavel)
                                    <option value="{{ $responsavel->id }}" {{ old('responsavel_entrada_id') == $responsavel->id ? 'selected' : '' }}>{{ $responsavel->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="hora_saida" class="block text-sm font-medium text-gray-700">Hora de Saída (opcional)</label>
                            <input type="time" name="hora_saida" id="hora_saida" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('hora_saida') }}">
                        </div>

                        <div>
                            <label for="responsavel_saida_id" class="block text-sm font-medium text-gray-700">Responsável pela Saída (opcional)</label>
                            <select name="responsavel_saida_id" id="responsavel_saida_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <option value="">Selecione um responsável</option>
                                @foreach($responsaveis ?? [] as $responsavel)
                                    <option value="{{ $responsavel->id }}" {{ old('responsavel_saida_id') == $responsavel->id ? 'selected' : '' }}>{{ $responsavel->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea name="observacoes" id="observacoes" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('observacoes') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" onclick="window.history.back()" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
