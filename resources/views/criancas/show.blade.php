@extends('layouts.app')

@section('title', 'Detalhes da Criança')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('criancas.index') }}" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Detalhes da Criança</h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/4 flex justify-center mb-6 md:mb-0">
                        <div class="w-48 h-48 rounded-full overflow-hidden">
                            @if($crianca->foto)
                            <img src="{{ Storage::url($crianca->foto) }}" alt="{{ $crianca->nome }}" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500 text-lg">Sem foto</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="md:w-3/4 md:pl-8">
                        <div class="flex justify-between items-start">
                            <h2 class="text-xl font-bold text-gray-800">{{ $crianca->nome }}</h2>
                            <div class="flex space-x-2">
                                <a href="{{ route('criancas.edit', $crianca) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                                    Editar
                                </a>
                                <form action="{{ route('criancas.destroy', $crianca) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition ease-in-out duration-150" onclick="return confirm('Tem certeza que deseja excluir esta criança?')">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Data de Nascimento</p>
                                <p class="text-base text-gray-900">{{ $crianca->data_nascimento_formatada }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Idade</p>
                                <p class="text-base text-gray-900">{{ $crianca->idade_formatada }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Gênero</p>
                                <p class="text-base text-gray-900">{{ $crianca->genero }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Turma</p>
                                <p class="text-base text-gray-900">{{ $crianca->turma->nome ?? 'Não atribuída' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Período</p>
                                <p class="text-base text-gray-900">{{ $crianca->periodo ?? 'Não definido' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <div x-data="{ activeTab: 'saude' }">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <button @click="activeTab = 'saude'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'saude', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'saude' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Saúde
                                </button>
                                <button @click="activeTab = 'responsaveis'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'responsaveis', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'responsaveis' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Responsáveis
                                </button>
                                <button @click="activeTab = 'presenca'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'presenca', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'presenca' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Histórico de Presença
                                </button>
                                <button @click="activeTab = 'documentos'" :class="{ 'border-blue-500 text-blue-600': activeTab === 'documentos', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'documentos' }" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                    Documentos
                                </button>
                            </nav>
                        </div>

                        <div class="mt-6">
                            <div x-show="activeTab === 'saude'">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Alergias</h3>
                                        <p class="text-gray-700">{{ $crianca->alergias ?: 'Nenhuma alergia registrada' }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Medicações</h3>
                                        <p class="text-gray-700">{{ $crianca->medicacoes ?: 'Nenhuma medicação registrada' }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Necessidades Especiais</h3>
                                        <p class="text-gray-700">{{ $crianca->necessidades_especiais ?: 'Nenhuma necessidade especial registrada' }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Restrições Alimentares</h3>
                                        <p class="text-gray-700">{{ $crianca->restricoes_alimentares ?: 'Nenhuma restrição alimentar registrada' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div x-show="activeTab === 'responsaveis'" class="space-y-6">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900">Responsáveis</h3>
                                    <a href="{{ route('criancas.responsaveis.atribuir', $crianca) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Atribuir Responsáveis
                                    </a>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($crianca->responsavelPrincipal)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div>
                                            <h4 class="text-base font-medium text-gray-900">Responsável Principal</h4>
                                            <p class="text-sm text-gray-700 mt-2">Nome: {{ $crianca->responsavelPrincipal->nome }}</p>
                                            <p class="text-sm text-gray-700">Telefone: {{ $crianca->responsavelPrincipal->telefone ?? 'Não informado' }}</p>
                                            <p class="text-sm text-gray-700">Celular: {{ $crianca->responsavelPrincipal->celular ?? 'Não informado' }}</p>
                                            <p class="text-sm text-gray-700">Email: {{ $crianca->responsavelPrincipal->email ?? 'Não informado' }}</p>
                                            <div class="mt-3">
                                                <a href="{{ route('responsaveis.show', $crianca->responsavelPrincipal) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                                    Ver detalhes
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-gray-500">Responsável principal não cadastrado.</p>
                                        <div class="mt-2">
                                            <a href="{{ route('criancas.responsaveis.atribuir', $crianca) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                                Atribuir responsável principal
                                            </a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($crianca->responsavelSecundario)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div>
                                            <h4 class="text-base font-medium text-gray-900">Responsável Secundário</h4>
                                            <p class="text-sm text-gray-700 mt-2">Nome: {{ $crianca->responsavelSecundario->nome }}</p>
                                            <p class="text-sm text-gray-700">Telefone: {{ $crianca->responsavelSecundario->telefone ?? 'Não informado' }}</p>
                                            <p class="text-sm text-gray-700">Celular: {{ $crianca->responsavelSecundario->celular ?? 'Não informado' }}</p>
                                            <p class="text-sm text-gray-700">Email: {{ $crianca->responsavelSecundario->email ?? 'Não informado' }}</p>
                                            <div class="mt-3">
                                                <a href="{{ route('responsaveis.show', $crianca->responsavelSecundario) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                                    Ver detalhes
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <p class="text-gray-500">Responsável secundário não cadastrado.</p>
                                        <div class="mt-2">
                                            <a href="{{ route('criancas.responsaveis.atribuir', $crianca) }}" class="text-blue-600 hover:text-blue-900 text-sm">
                                                Atribuir responsável secundário
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div x-show="activeTab === 'presenca'">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Histórico de Presença</h3>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('presenca.registrar-entrada', $crianca) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-700 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                            </svg>
                                            Registrar Entrada
                                        </a>
                                        <a href="{{ route('presenca.registrar-saida', $crianca) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Registrar Saída
                                        </a>
                                        <a href="{{ route('presenca.historico', $crianca) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 transition ease-in-out duration-150">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            Ver Histórico Completo
                                        </a>
                                    </div>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrada</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saída</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável Entrada</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável Saída</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse($crianca->presencas->take(5) as $presenca)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->data_formatada }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->hora_entrada_formatada }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->hora_saida_formatada ?: '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->responsavelEntrada->nome ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $presenca->responsavelSaida->nome ?? '-' }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                    Nenhum registro de presença encontrado.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if($crianca->presencas->count() > 5)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('presenca.historico', $crianca) }}" class="text-blue-600 hover:text-blue-900">
                                        Ver todos os registros de presença
                                    </a>
                                </div>
                                @endif
                            </div>

                            <div x-show="activeTab === 'documentos'">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">Documentos</h3>
                                    <a href="{{ route('criancas.documentos.create', $crianca) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150">
                                        Adicionar Documento
                                    </a>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @forelse($crianca->documentos as $documento)
                                    <div class="border rounded-lg overflow-hidden">
                                        <div class="p-4">
                                            <div class="flex justify-between items-start">
                                                <h4 class="text-base font-medium text-gray-900">{{ $documento->titulo }}</h4>
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('documentos.download', $documento) }}" class="text-blue-600 hover:text-blue-900" title="Download">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('documentos.destroy', $documento) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este documento?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                            <p class="text-sm text-gray-500 mt-1">{{ $documento->tipo }}</p>
                                            @if($documento->observacoes)
                                            <p class="text-sm text-gray-600 mt-2">{{ $documento->observacoes }}</p>
                                            @endif
                                            <p class="text-xs text-gray-400 mt-2">Adicionado em: {{ $documento->created_at_formatada }}</p>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-8">
                                        <p class="text-gray-500 text-lg mb-4">Nenhum documento cadastrado ainda.</p>
                                        <a href="{{ route('criancas.documentos.create', $crianca) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500">
                                            Adicionar primeiro documento
                                        </a>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adicionar Alpine.js para suporte às abas (tabs) -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
