<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Relatório de Presenças') }}
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
                    <div class="mb-6">
                        <form action="{{ route('presencas.relatorio') }}" method="GET" class="flex items-end space-x-4">
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
                                <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
                                <select name="turma_id" id="turma_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Todas as turmas</option>
                                    @foreach($turmas as $turma)
                                        <option value="{{ $turma->id }}" {{ $turmaId == $turma->id ? 'selected' : '' }}>{{ $turma->nome }}</option>
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

                    <div class="mb-6 bg-gray-50 p-4 rounded">
                        <div class="text-lg font-medium text-gray-900 mb-2">Informações do Período</div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Período:</span>
                                <span class="text-sm text-gray-900 ml-1">{{ date('F', mktime(0, 0, 0, $mes, 1)) }} de {{ $ano }}</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Dias Úteis:</span>
                                <span class="text-sm text-gray-900 ml-1">{{ $diasUteis }} dias</span>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-500">Turma:</span>
                                <span class="text-sm text-gray-900 ml-1">{{ $turmaId ? $turmas->find($turmaId)->nome : 'Todas as turmas' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        @if ($criancas->count() > 0)
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nome
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Turma
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Dias Presente
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Faltas
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Taxa de Presença
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ações
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($criancas as $crianca)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if ($crianca->foto)
                                                        <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $crianca->foto) }}" alt="{{ $crianca->nome }}">
                                                        </div>
                                                    @else
                                                        <div class="flex-shrink-0 h-10 w-10 mr-3 bg-gray-200 rounded-full flex items-center justify-center">
                                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $crianca->nome }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $crianca->idade }} anos
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $crianca->turma->nome ?? 'Sem turma' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $crianca->dias_presente }} / {{ $diasUteis }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $diasUteis - $crianca->dias_presente }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="mr-2 w-16 bg-gray-200 rounded-full h-2.5">
                                                        <div class="h-2.5 rounded-full {{ $crianca->percentual_presenca >= 75 ? 'bg-green-500' : ($crianca->percentual_presenca >= 50 ? 'bg-yellow-500' : 'bg-red-500') }}" style="width: {{ $crianca->percentual_presenca }}%"></div>
                                                    </div>
                                                    <span class="text-sm text-gray-900">{{ $crianca->percentual_presenca }}%</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('presencas.historico', ['crianca' => $crianca, 'mes' => $mes, 'ano' => $ano]) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    Ver Detalhes
                                                </a>
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
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma criança encontrada</h3>
                                <p class="mt-1 text-sm text-gray-500">Não há crianças registradas ou matriculadas na turma selecionada.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
