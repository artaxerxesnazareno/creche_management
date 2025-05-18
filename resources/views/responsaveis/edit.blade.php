@extends('layouts.app')

@section('title', 'Editar Responsável')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('responsaveis.show', $responsavel) }}" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Editar Responsável</h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('responsaveis.update', $responsavel) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome Completo <span class="text-red-500">*</span></label>
                            <input type="text" id="nome" name="nome" value="{{ old('nome', $responsavel->nome) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('nome') border-red-500 @enderror" required>
                            @error('nome')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="parentesco" class="block text-sm font-medium text-gray-700">Parentesco</label>
                            <select id="parentesco" name="parentesco" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md @error('parentesco') border-red-500 @enderror">
                                <option value="">Selecione o parentesco</option>
                                <option value="Mãe" @if(old('parentesco', $responsavel->parentesco) == 'Mãe') selected @endif>Mãe</option>
                                <option value="Pai" @if(old('parentesco', $responsavel->parentesco) == 'Pai') selected @endif>Pai</option>
                                <option value="Avó" @if(old('parentesco', $responsavel->parentesco) == 'Avó') selected @endif>Avó</option>
                                <option value="Avô" @if(old('parentesco', $responsavel->parentesco) == 'Avô') selected @endif>Avô</option>
                                <option value="Tio(a)" @if(old('parentesco', $responsavel->parentesco) == 'Tio(a)') selected @endif>Tio(a)</option>
                                <option value="Irmão(ã)" @if(old('parentesco', $responsavel->parentesco) == 'Irmão(ã)') selected @endif>Irmão(ã)</option>
                                <option value="Responsável Legal" @if(old('parentesco', $responsavel->parentesco) == 'Responsável Legal') selected @endif>Responsável Legal</option>
                                <option value="Outro" @if(old('parentesco', $responsavel->parentesco) == 'Outro') selected @endif>Outro</option>
                            </select>
                            @error('parentesco')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bi" class="block text-sm font-medium text-gray-700">Bilhete de Identidade (BI)</label>
                            <input type="text" id="bi" name="bi" value="{{ old('bi', $responsavel->bi) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('bi') border-red-500 @enderror">
                            @error('bi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone Fixo</label>
                            <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $responsavel->telefone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('telefone') border-red-500 @enderror">
                            @error('telefone')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="celular" class="block text-sm font-medium text-gray-700">Celular <span class="text-red-500">*</span></label>
                            <input type="text" id="celular" name="celular" value="{{ old('celular', $responsavel->celular) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('celular') border-red-500 @enderror" required>
                            @error('celular')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $responsavel->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('email') border-red-500 @enderror">
                            @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="endereco" class="block text-sm font-medium text-gray-700">Endereço</label>
                            <input type="text" id="endereco" name="endereco" value="{{ old('endereco', $responsavel->endereco) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('endereco') border-red-500 @enderror">
                            @error('endereco')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bairro" class="block text-sm font-medium text-gray-700">Bairro</label>
                            <input type="text" id="bairro" name="bairro" value="{{ old('bairro', $responsavel->bairro) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('bairro') border-red-500 @enderror">
                            @error('bairro')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="municipio" class="block text-sm font-medium text-gray-700">Município</label>
                            <input type="text" id="municipio" name="municipio" value="{{ old('municipio', $responsavel->municipio) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('municipio') border-red-500 @enderror">
                            @error('municipio')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="provincia" class="block text-sm font-medium text-gray-700">Província</label>
                            <input type="text" id="provincia" name="provincia" value="{{ old('provincia', $responsavel->provincia) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('provincia') border-red-500 @enderror">
                            @error('provincia')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="obs" class="block text-sm font-medium text-gray-700">Observações</label>
                            <textarea id="obs" name="obs" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('obs') border-red-500 @enderror">{{ old('obs', $responsavel->obs) }}</textarea>
                            @error('obs')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('responsaveis.show', $responsavel) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Atualizar Responsável
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
