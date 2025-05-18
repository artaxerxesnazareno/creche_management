@extends('layouts.app')

@section('title', 'Adicionar Documento')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('criancas.show', $crianca) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Adicionar Documento para {{ $crianca->nome }}</h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Erro!</strong> Houve problemas com os dados enviados.<br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('criancas.documentos.store', $crianca) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="titulo" class="block text-sm font-medium text-gray-700">Título do Documento</label>
                            <input type="text" name="titulo" id="titulo" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo do Documento</label>
                            <select name="tipo" id="tipo" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                <option value="">Selecione</option>
                                <option value="Certidão de Nascimento" {{ old('tipo') == 'Certidão de Nascimento' ? 'selected' : '' }}>Certidão de Nascimento</option>
                                <option value="Carteira de Vacinação" {{ old('tipo') == 'Carteira de Vacinação' ? 'selected' : '' }}>Carteira de Vacinação</option>
                                <option value="Laudo Médico" {{ old('tipo') == 'Laudo Médico' ? 'selected' : '' }}>Laudo Médico</option>
                                <option value="Relatório Escolar" {{ old('tipo') == 'Relatório Escolar' ? 'selected' : '' }}>Relatório Escolar</option>
                                <option value="Autorização" {{ old('tipo') == 'Autorização' ? 'selected' : '' }}>Autorização</option>
                                <option value="Outro" {{ old('tipo') == 'Outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('tipo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="arquivo" class="block text-sm font-medium text-gray-700">Arquivo</label>
                            <input type="file" name="arquivo" id="arquivo" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                            <p class="mt-1 text-sm text-gray-500">Formatos aceitos: PDF, JPG, JPEG, PNG, DOC, DOCX, XLS, XLSX. Tamanho máximo: 10MB.</p>
                            @error('arquivo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea name="observacoes" id="observacoes" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('observacoes') }}</textarea>
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
