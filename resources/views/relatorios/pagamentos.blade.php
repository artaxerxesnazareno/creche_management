@extends('layouts.app')

@section('title', 'Relatório de Pagamentos')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('relatorios.index') }}" class="text-blue-600 hover:text-blue-900 mr-2">
                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Voltar
            </a>
            <h1 class="text-2xl font-semibold text-gray-800">Relatório de Pagamentos</h1>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('relatorios.pagamentos') }}" method="GET" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="mes" class="block text-sm font-medium text-gray-700 mb-1">Mês</label>
                            <select name="mes" id="mes" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                @foreach($mesesPtBr as $key => $nomeMes)
                                    <option value="{{ $key }}" {{ $mes == $key ? 'selected' : '' }}>{{ $nomeMes }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="ano" class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
                            <select name="ano" id="ano" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                @for($i = date('Y') - 2; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $ano == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status do Pagamento</label>
                            <select name="status" id="status" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <option value="">Todos</option>
                                <option value="pago" {{ $status == 'pago' ? 'selected' : '' }}>Pagos</option>
                                <option value="pendente" {{ $status == 'pendente' ? 'selected' : '' }}>Pendentes</option>
                                <option value="atrasado" {{ $status == 'atrasado' ? 'selected' : '' }}>Atrasados</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Estatísticas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">Valores</h3>
                        <div class="text-sm">
                            <div class="flex justify-between mb-1">
                                <span>Total:</span>
                                <span class="font-semibold">R$ {{ number_format($valorTotal, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span>Pagos:</span>
                                <span class="font-semibold text-green-700">R$ {{ number_format($valorPago, 2, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pendentes:</span>
                                <span class="font-semibold text-red-700">R$ {{ number_format($valorPendente, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-green-800 mb-2">Quantidade de Pagamentos</h3>
                        <div class="text-sm">
                            <div class="flex justify-between mb-1">
                                <span>Total:</span>
                                <span class="font-semibold">{{ $totalPagamentos }}</span>
                            </div>
                            <div class="flex justify-between mb-1">
                                <span>Pagos:</span>
                                <span class="font-semibold text-green-700">{{ $totalPagos }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pendentes:</span>
                                <span class="font-semibold text-yellow-700">{{ $totalPendentes }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-red-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-red-800 mb-2">Situação</h3>
                        <div class="text-sm">
                            <div class="flex justify-between mb-1">
                                <span>Pagamentos em dia:</span>
                                <span class="font-semibold">{{ $totalPagos }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pagamentos atrasados:</span>
                                <span class="font-semibold text-red-700">{{ $totalAtrasados }}</span>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-red-200">
                            <div class="text-xs text-red-700">
                                {{ $totalAtrasados > 0 ? 'Existem pagamentos atrasados que precisam de atenção.' : 'Não há pagamentos atrasados.' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabela de Pagamentos -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Criança</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turma</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vencimento</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Pagamento</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Método</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($matriculas as $matricula)
                                @foreach($matricula->pagamentos as $pagamento)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    @if($matricula->crianca->foto)
                                                        <img class="h-8 w-8 rounded-full" src="{{ asset('storage/' . $matricula->crianca->foto) }}" alt="{{ $matricula->crianca->nome }}">
                                                    @else
                                                        <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                            <span class="text-xs text-gray-600">{{ substr($matricula->crianca->nome, 0, 1) }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $matricula->crianca->nome }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $matricula->turma->nome ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($pagamento->data_vencimento)->format('d/m/Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($pagamento->data_pagamento)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Pago
                                                </span>
                                            @elseif($pagamento->data_vencimento < now())
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Atrasado
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pendente
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($pagamento->data_pagamento)
                                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}</div>
                                            @else
                                                <span class="text-sm text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $pagamento->metodo_pagamento ?: '-' }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                        Nenhum pagamento encontrado para o período selecionado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
