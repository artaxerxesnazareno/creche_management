@extends('layouts.app')

@section('title', 'Editar Criança')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <a href="{{ route('criancas.show', $crianca) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-arrow-left mr-2"></i> Voltar
                    </a>
                </div>

                <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Criança</h1>

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

                <form action="{{ route('criancas.update', $crianca) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b-2 border-gray-200">Dados Pessoais</h2>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="nome" class="block text-sm font-bold text-gray-700 mb-2">Nome Completo</label>
                            <input type="text" name="nome" id="nome" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md" value="{{ old('nome', $crianca->nome) }}" required>
                            @error('nome')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="data_nascimento" class="block text-sm font-bold text-gray-700 mb-2">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" id="data_nascimento" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md" value="{{ old('data_nascimento', $crianca->data_nascimento ? $crianca->data_nascimento->format('Y-m-d') : '') }}" required>
                            @error('data_nascimento')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="genero" class="block text-sm font-bold text-gray-700 mb-2">Gênero</label>
                            <select name="genero" id="genero" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md" required>
                                <option value="">Selecione</option>
                                <option value="Masculino" {{ old('genero', $crianca->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Feminino" {{ old('genero', $crianca->genero) == 'Feminino' ? 'selected' : '' }}>Feminino</option>
                                <option value="Outro" {{ old('genero', $crianca->genero) == 'Outro' ? 'selected' : '' }}>Outro</option>
                            </select>
                            @error('genero')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="foto" class="block text-sm font-bold text-gray-700 mb-2">Foto</label>
                            @if($crianca->foto)
                                <div class="mt-2 mb-4">
                                    <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-lg">
                                        <img src="{{ asset('storage/' . $crianca->foto) }}" alt="Foto de {{ $crianca->nome }}" class="w-full h-full object-cover">
                                    </div>
                                    <p class="text-sm text-gray-600 mt-2 font-medium">Foto atual</p>
                                </div>
                            @endif
                            <input type="file" name="foto" id="foto" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md p-2 bg-white" accept="image/*">
                            <p class="text-sm text-gray-600 mt-2">Deixe em branco para manter a foto atual (tamanho máximo: 2MB)</p>
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 mt-6 pb-2 border-b-2 border-gray-200">Responsáveis</h2>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="responsavel_principal_id" class="block text-sm font-bold text-gray-700 mb-2">Responsável Principal <span class="text-red-500">*</span></label>
                            <select id="responsavel_principal_id" name="responsavel_principal_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md" required>
                                <option value="">Selecione o responsável principal</option>
                                @foreach(App\Models\Responsavel::orderBy('nome')->get() as $responsavel)
                                <option value="{{ $responsavel->id }}" {{ old('responsavel_principal_id', $crianca->responsavel_principal_id) == $responsavel->id ? 'selected' : '' }}>
                                    {{ $responsavel->nome }} @if($responsavel->parentesco) ({{ $responsavel->parentesco }}) @endif
                                </option>
                                @endforeach
                            </select>
                            @error('responsavel_principal_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-2 flex justify-between items-center">
                                <p class="text-sm text-gray-600">O responsável principal é o contato principal da criança.</p>
                                <a href="{{ route('responsaveis.create') }}" class="text-sm text-blue-600 hover:text-blue-900 font-semibold" target="_blank">
                                    Cadastrar novo responsável
                                </a>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="responsavel_secundario_id" class="block text-sm font-bold text-gray-700 mb-2">Responsável Secundário</label>
                            <select id="responsavel_secundario_id" name="responsavel_secundario_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                <option value="">Selecione o responsável secundário (opcional)</option>
                                @foreach(App\Models\Responsavel::orderBy('nome')->get() as $responsavel)
                                <option value="{{ $responsavel->id }}" {{ old('responsavel_secundario_id', $crianca->responsavel_secundario_id) == $responsavel->id ? 'selected' : '' }}>
                                    {{ $responsavel->nome }} @if($responsavel->parentesco) ({{ $responsavel->parentesco }}) @endif
                                </option>
                                @endforeach
                            </select>
                            @error('responsavel_secundario_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-gray-600 mt-2">O responsável secundário é um contato alternativo.</p>
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 mt-6 pb-2 border-b-2 border-gray-200">Dados de Saúde</h2>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="alergias" class="block text-sm font-bold text-gray-700 mb-2">Alergias</label>
                            <textarea name="alergias" id="alergias" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md">{{ old('alergias', $crianca->alergias) }}</textarea>
                            @error('alergias')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="medicacoes" class="block text-sm font-bold text-gray-700 mb-2">Medicações</label>
                            <textarea name="medicacoes" id="medicacoes" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md">{{ old('medicacoes', $crianca->medicacoes) }}</textarea>
                            @error('medicacoes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="necessidades_especiais" class="block text-sm font-bold text-gray-700 mb-2">Necessidades Especiais</label>
                            <textarea name="necessidades_especiais" id="necessidades_especiais" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md">{{ old('necessidades_especiais', $crianca->necessidades_especiais) }}</textarea>
                            @error('necessidades_especiais')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="restricoes_alimentares" class="block text-sm font-bold text-gray-700 mb-2">Restrições Alimentares</label>
                            <textarea name="restricoes_alimentares" id="restricoes_alimentares" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md">{{ old('restricoes_alimentares', $crianca->restricoes_alimentares) }}</textarea>
                            @error('restricoes_alimentares')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 mt-6 pb-2 border-b-2 border-gray-200">Dados Escolares</h2>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="turma_id" class="block text-sm font-bold text-gray-700 mb-2">Turma</label>
                            <select name="turma_id" id="turma_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md">
                                <option value="">Selecione uma turma</option>
                                @foreach($turmas as $turma)
                                <option value="{{ $turma->id }}" {{ old('turma_id', $crianca->turma_id) == $turma->id ? 'selected' : '' }}>
                                    {{ $turma->nome }}
                                </option>
                                @endforeach
                            </select>
                            @error('turma_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label for="periodo" class="block text-sm font-bold text-gray-700 mb-2">Período</label>
                            <select name="periodo" id="periodo" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md">
                                <option value="">Selecione</option>
                                <option value="Integral" {{ old('periodo', $crianca->periodo) == 'Integral' ? 'selected' : '' }}>Integral</option>
                                <option value="Manhã" {{ old('periodo', $crianca->periodo) == 'Manhã' ? 'selected' : '' }}>Manhã</option>
                                <option value="Tarde" {{ old('periodo', $crianca->periodo) == 'Tarde' ? 'selected' : '' }}>Tarde</option>
                            </select>
                            @error('periodo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2 bg-gray-50 p-4 rounded-lg">
                            <label for="observacoes" class="block text-sm font-bold text-gray-700 mb-2">Observações Adicionais</label>
                            <textarea name="observacoes" id="observacoes" rows="4" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md">{{ old('observacoes', $crianca->observacoes) }}</textarea>
                            @error('observacoes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="button" onclick="window.history.back()" class="bg-white py-2 px-6 border border-gray-300 rounded-md shadow-sm text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-4">
                            Cancelar
                        </button>
                        <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Impedir que o mesmo responsável seja selecionado como principal e secundário
        const responsavelPrincipal = document.getElementById('responsavel_principal_id');
        const responsavelSecundario = document.getElementById('responsavel_secundario_id');

        function atualizarOpcoes() {
            const principalId = responsavelPrincipal.value;
            const secundarioId = responsavelSecundario.value;

            // Habilitar todas as opções primeiro
            Array.from(responsavelPrincipal.options).forEach(option => {
                option.disabled = option.value && option.value === secundarioId;
            });

            Array.from(responsavelSecundario.options).forEach(option => {
                option.disabled = option.value && option.value === principalId;
            });
        }

        responsavelPrincipal.addEventListener('change', atualizarOpcoes);
        responsavelSecundario.addEventListener('change', atualizarOpcoes);

        // Executar na inicialização
        atualizarOpcoes();
    });
</script>
@endpush
@endsection
