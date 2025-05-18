@extends('layouts.app')

@section('title', 'Atribuir Responsáveis')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('criancas.show', $crianca) }}#responsaveis" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Atribuir Responsáveis</h1>
        </div>

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

                @if($responsaveis->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500 text-lg mb-4">Nenhum responsável cadastrado ainda.</p>
                    <p class="text-gray-500 mb-4">É necessário cadastrar responsáveis antes de atribuí-los a uma criança.</p>
                    <a href="{{ route('responsaveis.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Cadastrar um responsável
                    </a>
                </div>
                @else
                <form action="{{ route('criancas.responsaveis.salvar', $crianca) }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="responsavel_principal_id" class="block text-sm font-medium text-gray-700">Responsável Principal <span class="text-red-500">*</span></label>
                            <select id="responsavel_principal_id" name="responsavel_principal_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('responsavel_principal_id') border-red-500 @enderror" required>
                                <option value="">Selecione o responsável principal</option>
                                @foreach($responsaveis as $responsavel)
                                <option value="{{ $responsavel->id }}" @if(old('responsavel_principal_id', $crianca->responsavel_principal_id) == $responsavel->id) selected @endif>
                                    {{ $responsavel->nome }} @if($responsavel->parentesco) ({{ $responsavel->parentesco }}) @endif
                                </option>
                                @endforeach
                            </select>
                            @error('responsavel_principal_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <div class="mt-2 flex justify-between items-center">
                                <p class="text-xs text-gray-500">O responsável principal é o contato principal da criança.</p>
                                <a href="{{ route('responsaveis.create') }}" class="text-sm text-blue-600 hover:text-blue-900">
                                    Cadastrar novo responsável
                                </a>
                            </div>
                        </div>

                        <div>
                            <label for="responsavel_secundario_id" class="block text-sm font-medium text-gray-700">Responsável Secundário</label>
                            <select id="responsavel_secundario_id" name="responsavel_secundario_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('responsavel_secundario_id') border-red-500 @enderror">
                                <option value="">Selecione o responsável secundário (opcional)</option>
                                @foreach($responsaveis as $responsavel)
                                <option value="{{ $responsavel->id }}" @if(old('responsavel_secundario_id', $crianca->responsavel_secundario_id) == $responsavel->id) selected @endif>
                                    {{ $responsavel->nome }} @if($responsavel->parentesco) ({{ $responsavel->parentesco }}) @endif
                                </option>
                                @endforeach
                            </select>
                            @error('responsavel_secundario_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500">O responsável secundário é o contato alternativo da criança.</p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('criancas.show', $crianca) }}#responsaveis" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Salvar Responsáveis
                        </button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const respPrincipal = document.getElementById('responsavel_principal_id');
        const respSecundario = document.getElementById('responsavel_secundario_id');

        // Evitar que o mesmo responsável seja selecionado como principal e secundário
        respPrincipal.addEventListener('change', function() {
            const selectedValue = this.value;

            // Habilitar todas as opções no responsável secundário
            Array.from(respSecundario.options).forEach(option => {
                option.disabled = false;
            });

            // Desabilitar a opção selecionada no responsável principal
            if (selectedValue) {
                const option = respSecundario.querySelector(`option[value="${selectedValue}"]`);
                if (option) {
                    option.disabled = true;
                }

                // Se o responsável secundário tem o mesmo valor que o principal, limpar a seleção
                if (respSecundario.value === selectedValue) {
                    respSecundario.value = '';
                }
            }
        });

        // Disparar o evento change para aplicar as regras ao carregar a página
        respPrincipal.dispatchEvent(new Event('change'));
    });
</script>
@endsection
