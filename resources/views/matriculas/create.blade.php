@extends('layouts.app')

@section('title', 'Nova Matrícula')

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
            <h1 class="text-2xl font-semibold text-gray-800">Nova Matrícula</h1>
        </div>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('matriculas.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Dados da Matrícula</h2>
                        </div>
                        
                        <div>
                            <label for="crianca_id" class="block text-sm font-medium text-gray-700">Criança</label>
                            <select name="crianca_id" id="crianca_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Selecione uma criança</option>
                                @foreach($criancas ?? [] as $crianca)
                                    <option value="{{ $crianca->id }}" {{ old('crianca_id') == $crianca->id ? 'selected' : '' }}>{{ $crianca->nome }}</option>
                                @endforeach
                            </select>
                            @error('crianca_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
                            <select name="turma_id" id="turma_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Selecione uma turma</option>
                                @foreach($turmas ?? [] as $turma)
                                    <option value="{{ $turma->id }}" {{ old('turma_id') == $turma->id ? 'selected' : '' }}>{{ $turma->nome }}</option>
                                @endforeach
                            </select>
                            @error('turma_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('data_inicio') ?? date('Y-m-d') }}" required>
                            @error('data_inicio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="periodo" class="block text-sm font-medium text-gray-700">Período</label>
                            <select name="periodo" id="periodo" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Selecione um período</option>
                                <option value="Integral" {{ old('periodo') == 'Integral' ? 'selected' : '' }}>Integral</option>
                                <option value="Manhã" {{ old('periodo') == 'Manhã' ? 'selected' : '' }}>Manhã</option>
                                <option value="Tarde" {{ old('periodo') == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                            </select>
                            @error('periodo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-lg font-medium text-gray-900 mb-4 mt-4">Dados Financeiros</h2>
                        </div>
                        
                        <div>
                            <label for="valor_mensalidade" class="block text-sm font-medium text-gray-700">Valor da Mensalidade (R$)</label>
                            <input type="number" step="0.01" name="valor_mensalidade" id="valor_mensalidade" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('valor_mensalidade') }}" required>
                            @error('valor_mensalidade')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="dia_vencimento" class="block text-sm font-medium text-gray-700">Dia de Vencimento</label>
                            <select name="dia_vencimento" id="dia_vencimento" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Selecione</option>
                                @for($i = 1; $i <= 28; $i++)
                                    <option value="{{ $i }}" {{ old('dia_vencimento') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('dia_vencimento')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="desconto" class="block text-sm font-medium text-gray-700">Desconto (%)</label>
                            <input type="number" step="0.01" name="desconto" id="desconto" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('desconto') ?? 0 }}">
                            @error('desconto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="taxa_matricula" class="block text-sm font-medium text-gray-700">Taxa de Matrícula (R$)</label>
                            <input type="number" step="0.01" name="taxa_matricula" id="taxa_matricula" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('taxa_matricula') ?? 0 }}">
                            @error('taxa_matricula')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-lg font-medium text-gray-900 mb-4 mt-4">Informações Adicionais</h2>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="Pendente" {{ old('status') == 'Pendente' ? 'selected' : '' }}>Pendente</option>
                                <option value="Ativa" {{ old('status') == 'Ativa' ? 'selected' : '' }}>Ativa</option>
                                <option value="Cancelada" {{ old('status') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="gerar_contrato" class="flex items-center">
                                <input type="checkbox" name="gerar_contrato" id="gerar_contrato" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('gerar_contrato') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Gerar contrato automaticamente</span>
                            </label>
                        </div>
                        
                        <div class="col-span-1 md:col-span-2">
                            <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea name="observacoes" id="observacoes" rows="4" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('observacoes') }}</textarea>
                            @error('observacoes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button type="button" onclick="window.history.back()" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-3">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
