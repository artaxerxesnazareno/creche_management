@extends('layouts.app')

@section('title', 'Histórico de Presenças')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800 flex items-center">
                    @if($crianca->foto)
                        <img src="{{ asset('storage/' . $crianca->foto) }}" alt="{{ $crianca->nome }}" class="h-10 w-10 rounded-full mr-3">
                    @else
                        <img src="{{ asset('img/placeholder.png') }}" alt="{{ $crianca->nome }}" class="h-10 w-10 rounded-full mr-3">
                    @endif
                    Histórico de Presenças: {{ $crianca->nome }}
                </h1>
                <p class="text-gray-600 mt-1">Turma: {{ $crianca->turma->nome ?? 'Não atribuída' }}</p>
            </div>
            <a href="{{ route('presenca.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                Voltar
            </a>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Filtro de mês/ano -->
                <div class="mb-6">
                    <form action="{{ route('presenca.historico', $crianca) }}" method="GET" class="flex items-center space-x-4">
                        <div>
                            <label for="mes" class="block text-sm font-medium text-gray-700 mb-1">Mês</label>
                            <select name="mes" id="mes" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block sm:text-sm border-gray-300 rounded-md" onchange="this.form.submit()">
                                @php
                                    $mesesPtBr = [
                                        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março',
                                        4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
                                        7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro',
                                        10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
                                    ];
                                @endphp
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $mes == $i ? 'selected' : '' }}>
                                        {{ $mesesPtBr[$i] }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="ano" class="block text-sm font-medium text-gray-700 mb-1">Ano</label>
                            <select name="ano" id="ano" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block sm:text-sm border-gray-300 rounded-md" onchange="this.form.submit()">
                                @for($i = date('Y') - 2; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $ano == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Estatísticas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <h3 class="text-sm font-medium text-blue-800">Dias Úteis</h3>
                        <p class="text-2xl font-bold text-blue-900">{{ $diasUteis }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg text-center">
                        <h3 class="text-sm font-medium text-green-800">Dias Presente</h3>
                        <p class="text-2xl font-bold text-green-900">{{ $diasPresente }}</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg text-center">
                        <h3 class="text-sm font-medium text-purple-800">Frequência</h3>
                        <p class="text-2xl font-bold text-purple-900">{{ $percentualPresenca }}%</p>
                    </div>
                </div>

                <!-- Calendário mensal (exibição horizontal com scroll) -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Calendário de Presenças - {{ $mesesPtBr[(int)$mes] }}/{{ $ano }}</h3>

                    @php
                        $daysInMonth = \Carbon\Carbon::createFromDate($ano, $mes, 1)->daysInMonth;
                        $diasSemana = [
                            0 => 'Dom', 1 => 'Seg',
                            2 => 'Ter', 3 => 'Qua',
                            4 => 'Qui', 5 => 'Sex',
                            6 => 'Sáb'
                        ];
                    @endphp

                    <div class="overflow-x-auto pb-2">
                        <div class="flex space-x-1 min-w-max">
                            <!-- Dias do mês atual -->
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $formattedMonth = sprintf('%02d', $mes);
                                    $formattedDay = sprintf('%02d', $day);
                                    $currentDate = "{$ano}-{$formattedMonth}-{$formattedDay}";
                                    $hasPresenca = isset($presencas[$currentDate]) && $presencas[$currentDate]->first()->hora_entrada;
                                    $isWeekend = \Carbon\Carbon::parse($currentDate)->isWeekend();
                                    $presentClass = $hasPresenca ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300';
                                    $todayClass = date('Y-m-d') === $currentDate ? 'ring-2 ring-blue-500' : '';

                                    // Para finais de semana, sempre mostrar em cinza
                                    if ($isWeekend) {
                                        $presentClass = 'bg-gray-100 text-gray-600 border-gray-300';
                                    }

                                    $dayOfWeek = \Carbon\Carbon::parse($currentDate)->dayOfWeek;
                                @endphp

                                <div class="flex-shrink-0 w-16 border rounded-lg overflow-hidden {{ $presentClass }} {{ $todayClass }} cursor-pointer"
                                     onclick="mostrarDetalhesPresenca('{{ $currentDate }}', {{ json_encode($presencas[$currentDate] ?? null) }})">
                                    <div class="text-center py-1 font-medium text-xs border-b border-current bg-opacity-50">
                                        {{ $diasSemana[$dayOfWeek] }}
                                    </div>
                                    <div class="text-center py-2">
                                        <div class="text-lg font-bold">{{ $day }}</div>
                                        @if ($hasPresenca)
                                            <div class="text-xs mt-1">
                                                {{ \Carbon\Carbon::parse($presencas[$currentDate]->first()->hora_entrada)->format('H:i') }}
                                            </div>
                                            @if ($presencas[$currentDate]->first()->hora_saida)
                                                <div class="text-xs">
                                                    {{ \Carbon\Carbon::parse($presencas[$currentDate]->first()->hora_saida)->format('H:i') }}
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="flex items-center justify-center mt-2 text-sm text-gray-500">
                        <div class="flex items-center mr-3">
                            <div class="w-3 h-3 bg-green-100 border border-green-300 rounded-full mr-1"></div>
                            <span>Presente</span>
                        </div>
                        <div class="flex items-center mr-3">
                            <div class="w-3 h-3 bg-red-100 border border-red-300 rounded-full mr-1"></div>
                            <span>Ausente</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-gray-100 border border-gray-300 rounded-full mr-1"></div>
                            <span>Fim de Semana</span>
                        </div>
                    </div>
                </div>

                <!-- Tabela de presenças detalhadas -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Detalhes de Presenças</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora Entrada</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável Entrada</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hora Saída</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Responsável Saída</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Observações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($presencas as $data => $grupo)
                                    @foreach($grupo as $presenca)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($data)->format('d/m/Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                @php
                                                    $diasSemana = [
                                                        0 => 'Domingo', 1 => 'Segunda-feira',
                                                        2 => 'Terça-feira', 3 => 'Quarta-feira',
                                                        4 => 'Quinta-feira', 5 => 'Sexta-feira',
                                                        6 => 'Sábado'
                                                    ];
                                                    $diaSemana = \Carbon\Carbon::parse($data)->dayOfWeek;
                                                @endphp
                                                {{ $diasSemana[$diaSemana] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($presenca->hora_entrada)
                                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($presenca->hora_entrada)->format('H:i') }}</div>
                                            @else
                                                <span class="text-sm text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $presenca->responsavelEntrada->nome ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($presenca->hora_saida)
                                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($presenca->hora_saida)->format('H:i') }}</div>
                                            @else
                                                <span class="text-sm text-gray-500">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $presenca->responsavelSaida->nome ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($presenca->observacoes)
                                                <div class="text-sm text-gray-900 max-w-xs whitespace-pre-wrap">{{ $presenca->observacoes }}</div>
                                            @else
                                                <span class="text-sm text-gray-500">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                            Nenhum registro de presença encontrado para este mês.
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
</div>

<!-- Modal de Detalhes de Presença -->
<div id="modalDetalhesPresenca" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-detalhe-data">
                            Detalhes da Presença
                        </h3>
                        <div class="mt-4" id="modal-detalhe-conteudo">
                            <div class="text-center text-gray-500">
                                Carregando...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="fecharModalDetalhes()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarDetalhesPresenca(data, presenca) {
        const modal = document.getElementById('modalDetalhesPresenca');
        const titulo = document.getElementById('modal-detalhe-data');
        const conteudo = document.getElementById('modal-detalhe-conteudo');

        // Formatar a data em português brasileiro
        const dataObj = new Date(data);
        const dia = dataObj.getDate().toString().padStart(2, '0');
        const mes = (dataObj.getMonth() + 1).toString().padStart(2, '0');
        const ano = dataObj.getFullYear();

        // Array com os nomes dos dias da semana em português
        const diasSemana = [
            'Domingo', 'Segunda-feira', 'Terça-feira',
            'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'
        ];

        // Array com os nomes dos meses em português
        const meses = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        const diaSemana = diasSemana[dataObj.getDay()];
        const nomeMes = meses[dataObj.getMonth()];

        const dataFormatada = `${diaSemana}, ${dia} de ${nomeMes} de ${ano}`;
        titulo.textContent = `Detalhes: ${dataFormatada}`;

        if (!presenca || presenca.length === 0) {
            // Dia sem presença registrada
            const weekend = dataObj.getDay() === 0 || dataObj.getDay() === 6;

            if (weekend) {
                conteudo.innerHTML = `
                    <div class="bg-gray-50 p-4 rounded">
                        <p class="text-gray-600">Final de semana - sem registro de presença.</p>
                    </div>
                `;
            } else {
                conteudo.innerHTML = `
                    <div class="bg-red-50 p-4 rounded">
                        <p class="text-red-600">Ausente neste dia.</p>
                    </div>
                `;
            }
        } else {
            // Tem presença registrada
            const p = presenca[0];

            // Formatar hora de entrada
            let horaEntrada = '-';
            if (p.hora_entrada) {
                const horaEntradaObj = new Date(`${data}T${p.hora_entrada}`);
                const horas = horaEntradaObj.getHours().toString().padStart(2, '0');
                const minutos = horaEntradaObj.getMinutes().toString().padStart(2, '0');
                horaEntrada = `${horas}:${minutos}`;
            }

            // Formatar hora de saída
            let horaSaida = '-';
            if (p.hora_saida) {
                const horaSaidaObj = new Date(`${data}T${p.hora_saida}`);
                const horas = horaSaidaObj.getHours().toString().padStart(2, '0');
                const minutos = horaSaidaObj.getMinutes().toString().padStart(2, '0');
                horaSaida = `${horas}:${minutos}`;
            }

            const responsavelEntrada = p.responsavelEntrada ? p.responsavelEntrada.nome : 'Não registrado';
            const responsavelSaida = p.responsavelSaida ? p.responsavelSaida.nome : 'Não registrado';
            const observacoes = p.observacoes || 'Nenhuma observação registrada';

            conteudo.innerHTML = `
                <div class="bg-green-50 p-4 rounded mb-4">
                    <p class="text-green-600 font-medium">Presente</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Entrada:</p>
                        <p class="text-lg font-semibold">${horaEntrada}</p>
                        <p class="text-sm text-gray-500">Por: ${responsavelEntrada}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700">Saída:</p>
                        <p class="text-lg font-semibold">${horaSaida}</p>
                        <p class="text-sm text-gray-500">Por: ${responsavelSaida}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700">Observações:</p>
                    <p class="text-sm text-gray-800 whitespace-pre-wrap mt-1 p-2 bg-gray-50 rounded">${observacoes}</p>
                </div>
            `;
        }

        modal.classList.remove('hidden');
    }

    function fecharModalDetalhes() {
        document.getElementById('modalDetalhesPresenca').classList.add('hidden');
    }
</script>
@endsection
