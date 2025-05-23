@extends('layouts.app')

@section('title', 'Controle de Presença')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Controle de Presença</h1>
            <a href="{{ route('presenca.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Registrar Presença
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between mb-4">
                    <div class="w-1/3">
                        <form action="{{ route('presenca.index') }}" method="GET">
                            <div class="flex">
                                <input type="text" name="search" placeholder="Buscar por nome da criança..." class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" value="{{ request('search') }}">
                                <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Buscar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="flex space-x-2">
                        <form action="{{ route('presenca.index') }}" method="GET" class="flex items-center space-x-4">
                            <input type="date" name="data" id="data" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block sm:text-sm border-gray-300 rounded-md" value="{{ $data ?? date('Y-m-d') }}" onchange="this.form.submit()">
                            <select name="turma_id" id="turma_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block sm:text-sm border-gray-300 rounded-md" onchange="this.form.submit()">
                                <option value="">Todas as turmas</option>
                                @foreach($turmas ?? [] as $turma)
                                    <option value="{{ $turma->id }}" {{ ($turmaId ?? '') == $turma->id ? 'selected' : '' }}>{{ $turma->nome }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>

                <div class="flex justify-end mb-4">
                    <div class="flex space-x-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $presentes ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Presentes</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $ausentes ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Ausentes</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $totalCriancas ?? 0 }}</div>
                            <div class="text-sm text-gray-500">Total</div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criança</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turma</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entrada</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saída</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($criancas ?? [] as $crianca)
                                @php
                                    $presenca = $crianca->presencas->first();
                                    $entrada = $presenca ? $presenca->hora_entrada : null;
                                    $saida = $presenca ? $presenca->hora_saida : null;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($crianca->foto)
                                                    <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $crianca->foto) }}" alt="{{ $crianca->nome ?? 'Criança' }}">
                                                @else
                                                    <img class="h-10 w-10 rounded-full" src="{{ asset('img/placeholder.png') }}" alt="{{ $crianca->nome ?? 'Criança' }}">
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $crianca->nome }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $crianca->turma->nome ?? 'Sem turma' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($entrada)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Presente
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Ausente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($entrada)
                                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($entrada)->format('H:i') }}</div>
                                            @if ($presenca->responsavel_entrada_id)
                                                <div class="text-xs text-gray-500">{{ $presenca->responsavelEntrada->nome ?? 'N/A' }}</div>
                                            @endif
                                        @else
                                            <span class="text-sm text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($saida)
                                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($saida)->format('H:i') }}</div>
                                            @if ($presenca->responsavel_saida_id)
                                                <div class="text-xs text-gray-500">{{ $presenca->responsavelSaida->nome ?? 'N/A' }}</div>
                                            @endif
                                        @else
                                            <span class="text-sm text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('presenca.historico', $crianca) }}" class="text-indigo-600 hover:text-indigo-900" title="Histórico">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </a>

                                            @if (!$entrada)
                                                <button type="button"
                                                        onclick="abrirModalEntrada('{{ $crianca->id }}', '{{ $crianca->nome }}')"
                                                        class="text-green-600 hover:text-green-900"
                                                        title="Registrar entrada">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                                    </svg>
                                                </button>
                                            @elseif (!$saida)
                                                <button type="button"
                                                        onclick="abrirModalSaida('{{ $crianca->id }}', '{{ $crianca->nome }}')"
                                                        class="text-blue-600 hover:text-blue-900"
                                                        title="Registrar saída">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        Nenhuma criança encontrada para a data e turma selecionadas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(isset($criancas) && method_exists($criancas, 'links'))
                <div class="mt-4">
                    {{ $criancas->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de Entrada -->
<div id="modalEntrada" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-entrada-title">
                            Registrar Entrada
                        </h3>

                        <div id="entrada-loading" class="hidden flex justify-center items-center py-4">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Processando...</span>
                        </div>

                        <div id="entrada-error" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                            <p id="entrada-error-message"></p>
                        </div>

                        <form id="formEntrada" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" id="entrada_crianca_id" name="crianca_id">

                            <div>
                                <label for="responsavel_entrada_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Responsável pela Entrada:
                                </label>
                                <select id="responsavel_entrada_id" name="responsavel_entrada_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Selecione um responsável</option>
                                    @foreach(\App\Models\Responsavel::orderBy('nome')->get() as $responsavel)
                                        <option value="{{ $responsavel->id }}">{{ $responsavel->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="observacao_entrada" class="block text-sm font-medium text-gray-700 mb-1">
                                    Observações (opcional):
                                </label>
                                <textarea id="observacao_entrada" name="observacao" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmarEntrada" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Confirmar Entrada
                </button>
                <button type="button" onclick="fecharModalEntrada()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Saída -->
<div id="modalSaida" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-saida-title">
                            Registrar Saída
                        </h3>

                        <div id="saida-loading" class="hidden flex justify-center items-center py-4">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Processando...</span>
                        </div>

                        <div id="saida-error" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                            <p id="saida-error-message"></p>
                        </div>

                        <form id="formSaida" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" id="saida_crianca_id" name="crianca_id">

                            <div>
                                <label for="responsavel_saida_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Responsável pela Saída:
                                </label>
                                <select id="responsavel_saida_id" name="responsavel_saida_id" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Selecione um responsável</option>
                                    @foreach(\App\Models\Responsavel::orderBy('nome')->get() as $responsavel)
                                        <option value="{{ $responsavel->id }}">{{ $responsavel->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="observacao_saida" class="block text-sm font-medium text-gray-700 mb-1">
                                    Observações (opcional):
                                </label>
                                <textarea id="observacao_saida" name="observacao" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmarSaida" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Confirmar Saída
                </button>
                <button type="button" onclick="fecharModalSaida()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function abrirModalEntrada(criancaId, criancaNome) {
        document.getElementById('entrada_crianca_id').value = criancaId;
        document.getElementById('modal-entrada-title').textContent = `Registrar Entrada: ${criancaNome}`;
        document.getElementById('modalEntrada').classList.remove('hidden');
        document.getElementById('entrada-error').classList.add('hidden');
    }

    function fecharModalEntrada() {
        document.getElementById('modalEntrada').classList.add('hidden');
        document.getElementById('formEntrada').reset();
    }

    function abrirModalSaida(criancaId, criancaNome) {
        document.getElementById('saida_crianca_id').value = criancaId;
        document.getElementById('modal-saida-title').textContent = `Registrar Saída: ${criancaNome}`;
        document.getElementById('modalSaida').classList.remove('hidden');
        document.getElementById('saida-error').classList.add('hidden');
    }

    function fecharModalSaida() {
        document.getElementById('modalSaida').classList.add('hidden');
        document.getElementById('formSaida').reset();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Configuração do envio do formulário de entrada
        document.getElementById('confirmarEntrada').addEventListener('click', function() {
            const form = document.getElementById('formEntrada');
            const criancaId = document.getElementById('entrada_crianca_id').value;

            // Mostrar loading
            document.getElementById('entrada-loading').classList.remove('hidden');

            // Coletar os dados do formulário
            const formData = new FormData(form);

            // Enviar requisição AJAX
            fetch(`/presenca/${criancaId}/entrada`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('entrada-loading').classList.add('hidden');

                if (data.success) {
                    // Recarregar a página após sucesso
                    window.location.reload();
                } else {
                    // Mostrar erro
                    document.getElementById('entrada-error').classList.remove('hidden');
                    document.getElementById('entrada-error-message').textContent = data.message || 'Ocorreu um erro ao registrar entrada.';
                }
            })
            .catch(error => {
                document.getElementById('entrada-loading').classList.add('hidden');
                document.getElementById('entrada-error').classList.remove('hidden');
                document.getElementById('entrada-error-message').textContent = 'Erro ao processar requisição. Tente novamente.';
            });
        });

        // Configuração do envio do formulário de saída
        document.getElementById('confirmarSaida').addEventListener('click', function() {
            const form = document.getElementById('formSaida');
            const criancaId = document.getElementById('saida_crianca_id').value;

            // Mostrar loading
            document.getElementById('saida-loading').classList.remove('hidden');

            // Coletar os dados do formulário
            const formData = new FormData(form);

            // Enviar requisição AJAX
            fetch(`/presenca/${criancaId}/saida`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('saida-loading').classList.add('hidden');

                if (data.success) {
                    // Recarregar a página após sucesso
                    window.location.reload();
                } else {
                    // Mostrar erro
                    document.getElementById('saida-error').classList.remove('hidden');
                    document.getElementById('saida-error-message').textContent = data.message || 'Ocorreu um erro ao registrar saída.';
                }
            })
            .catch(error => {
                document.getElementById('saida-loading').classList.add('hidden');
                document.getElementById('saida-error').classList.remove('hidden');
                document.getElementById('saida-error-message').textContent = 'Erro ao processar requisição. Tente novamente.';
            });
        });
    });
</script>
@endsection
