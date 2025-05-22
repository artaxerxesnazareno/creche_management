<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Histórico de Presenças') }}
            </h2>
            <a href="{{ route('presencas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Voltar') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        @if ($crianca->foto)
                            <div class="flex-shrink-0 h-20 w-20 mr-4">
                                <img class="h-20 w-20 rounded-full object-cover" src="{{ asset('storage/' . $crianca->foto) }}" alt="{{ $crianca->nome }}">
                            </div>
                        @else
                            <div class="flex-shrink-0 h-20 w-20 mr-4 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $crianca->nome }}</h3>
                            <p class="text-sm text-gray-500">{{ $crianca->idade }} anos | {{ $crianca->turma->nome ?? 'Sem turma' }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <form action="{{ route('presencas.historico', $crianca) }}" method="GET" class="flex items-end space-x-4">
                            <div>
                                <label for="mes" class="block text-sm font-medium text-gray-700">Mês</label>
                                <select name="mes" id="mes" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ $m == $mes ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="ano" class="block text-sm font-medium text-gray-700">Ano</label>
                                <select name="ano" id="ano" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    @foreach(range(date('Y')-2, date('Y')) as $a)
                                        <option value="{{ $a }}" {{ $a == $ano ? 'selected' : '' }}>{{ $a }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    {{ __('Filtrar') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Dias Úteis no Mês</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $diasUteis }}</dd>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Dias Presente</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $diasPresente }}</dd>
                            </div>
                        </div>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Taxa de Presença</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $percentualPresenca }}%</dd>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        @if ($presencas->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Data
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Entrada
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Saída
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Observações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($presencas as $data => $registros)
                                        @php
                                            $entrada = $registros->where('tipo', 'entrada')->first();
                                            $saida = $registros->where('tipo', 'saida')->first();
                                            $falta = $registros->where('tipo', 'falta')->first();
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($data)->format('l') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($entrada)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Presente
                                                    </span>
                                                @elseif ($falta)
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Ausente
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Não registrado
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($entrada)
                                                    <div class="text-sm text-gray-900">{{ $entrada->hora_formatada }}</div>
                                                    @if ($entrada->responsavel)
                                                        <div class="text-xs text-gray-500">{{ $entrada->responsavel }}</div>
                                                    @endif
                                                @else
                                                    <span class="text-sm text-gray-500">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($saida)
                                                    <div class="text-sm text-gray-900">{{ $saida->hora_formatada }}</div>
                                                    @if ($saida->responsavel)
                                                        <div class="text-xs text-gray-500">{{ $saida->responsavel }}</div>
                                                    @endif
                                                @else
                                                    <span class="text-sm text-gray-500">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @foreach ($registros as $registro)
                                                    @if ($registro->observacao)
                                                        <div class="text-xs {{ $registro->status_class }} px-2 py-1 rounded mb-1">
                                                            <span class="font-semibold">{{ $registro->status }}:</span> {{ $registro->observacao }}
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-10">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum registro encontrado</h3>
                                <p class="mt-1 text-sm text-gray-500">Não há registros de presenças para o período selecionado.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
