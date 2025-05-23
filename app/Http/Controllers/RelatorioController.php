<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Matricula;
use App\Models\Presenca;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    /**
     * Exibe a página principal de relatórios
     */
    public function index()
    {
        return view('relatorios.index');
    }

    /**
     * Exibe o relatório financeiro
     */
    public function financeiro(Request $request)
    {
        $mes = $request->input('mes', date('m'));
        $ano = $request->input('ano', date('Y'));

        $matriculas = Matricula::where('status', 'Ativa')
            ->whereYear('data_inicio', '<=', $ano)
            ->whereMonth('data_inicio', '<=', $mes)
            ->whereHas('crianca')
            ->with('crianca')
            ->get();

        $totalMensalidades = $matriculas->sum('valor_com_desconto');
        $totalPorTurma = $matriculas->groupBy('turma_id')
            ->map(function ($grupo) {
                return [
                    'turma' => $grupo->first()->turma->nome ?? 'Sem turma',
                    'total' => $grupo->sum('valor_com_desconto'),
                    'quantidade' => $grupo->count()
                ];
            });

        return view('relatorios.financeiro', compact('matriculas', 'totalMensalidades', 'totalPorTurma', 'mes', 'ano'));
    }

    /**
     * Exibe o relatório de presenças
     */
    public function presenca(Request $request)
    {
        $dataInicio = $request->input('data_inicio', date('Y-m-01'));
        $dataFim = $request->input('data_fim', date('Y-m-d'));
        $turmaId = $request->input('turma_id');

        $query = Presenca::whereBetween('data', [$dataInicio, $dataFim])
            ->with(['crianca', 'crianca.turma']);

        if ($turmaId) {
            $query->whereHas('crianca', function ($q) use ($turmaId) {
                $q->where('turma_id', $turmaId);
            });
        }

        $presencas = $query->get();
        $turmas = Turma::orderBy('nome')->get();

        $estatisticas = [
            'total' => $presencas->count(),
            'presentes' => $presencas->where('tipo', 'entrada')->count(),
            'ausentes' => $presencas->where('tipo', 'falta')->count(),
            'por_turma' => $presencas->groupBy('crianca.turma.nome')
                ->map(function ($grupo) {
                    return [
                        'total' => $grupo->count(),
                        'presentes' => $grupo->where('tipo', 'entrada')->count(),
                        'ausentes' => $grupo->where('tipo', 'falta')->count(),
                    ];
                })
        ];

        return view('relatorios.presenca', compact('presencas', 'turmas', 'estatisticas', 'dataInicio', 'dataFim', 'turmaId'));
    }

    /**
     * Exibe o relatório de matrículas
     */
    public function matriculas(Request $request)
    {
        $status = $request->input('status');
        $periodoInicio = $request->input('periodo_inicio', date('Y-01-01'));
        $periodoFim = $request->input('periodo_fim', date('Y-m-d'));

        $query = Matricula::whereBetween('data_inicio', [$periodoInicio, $periodoFim])
            ->with(['crianca', 'turma']);

        if ($status) {
            $query->where('status', $status);
        }

        $matriculas = $query->get();

        $estatisticas = [
            'total' => $matriculas->count(),
            'ativas' => $matriculas->where('status', 'Ativa')->count(),
            'pendentes' => $matriculas->where('status', 'Pendente')->count(),
            'canceladas' => $matriculas->where('status', 'Cancelada')->count(),
            'concluidas' => $matriculas->where('status', 'Concluída')->count(),
            'por_turma' => $matriculas->groupBy('turma.nome')
                ->map(function ($grupo) {
                    return [
                        'total' => $grupo->count(),
                        'ativas' => $grupo->where('status', 'Ativa')->count()
                    ];
                })
        ];

        return view('relatorios.matriculas', compact('matriculas', 'estatisticas', 'status', 'periodoInicio', 'periodoFim'));
    }

    /**
     * Exibe o relatório de turmas
     */
    public function turmas()
    {
        $turmas = Turma::withCount('criancas')->get();

        $estatisticas = [
            'total_turmas' => $turmas->count(),
            'total_criancas' => $turmas->sum('criancas_count'),
            'media_por_turma' => $turmas->count() > 0 ? round($turmas->sum('criancas_count') / $turmas->count(), 1) : 0,
            'ocupacao' => $turmas->map(function ($turma) {
                return [
                    'nome' => $turma->nome,
                    'capacidade' => $turma->capacidade ?? 0,
                    'ocupadas' => $turma->criancas_count,
                    'percentual' => $turma->capacidade ? round(($turma->criancas_count / $turma->capacidade) * 100, 1) : 0
                ];
            })
        ];

        return view('relatorios.turmas', compact('turmas', 'estatisticas'));
    }

    /**
     * Exibe o relatório de crianças
     */
    public function criancas(Request $request)
    {
        $turma_id = $request->input('turma_id');
        $idade_min = $request->input('idade_min');
        $idade_max = $request->input('idade_max');
        $genero = $request->input('genero');

        $query = Crianca::with(['turma', 'responsaveis'])
            ->withCount('responsaveis');

        if ($turma_id) {
            $query->where('turma_id', $turma_id);
        }

        if ($idade_min) {
            $query->where(DB::raw('TIMESTAMPDIFF(YEAR, data_nascimento, CURDATE())'), '>=', $idade_min);
        }

        if ($idade_max) {
            $query->where(DB::raw('TIMESTAMPDIFF(YEAR, data_nascimento, CURDATE())'), '<=', $idade_max);
        }

        if ($genero) {
            $query->where('genero', $genero);
        }

        $criancas = $query->paginate(15);

        // Adiciona campos formatados para a visualização
        $criancas->getCollection()->transform(function ($crianca) {
            $crianca->data_nascimento_formatada = \Carbon\Carbon::parse($crianca->data_nascimento)->format('d/m/Y');
            $crianca->idade = \Carbon\Carbon::parse($crianca->data_nascimento)->age;
            $crianca->foto_url = $crianca->foto ? asset('storage/' . $crianca->foto) : asset('img/placeholder.png');
            return $crianca;
        });

        // Estatísticas para o relatório
        $total = $criancas->total();
        $totalMasculino = Crianca::where('genero', 'Masculino')->count();
        $totalFeminino = Crianca::where('genero', 'Feminino')->count();
        $totalOutro = Crianca::where('genero', 'Outro')->count();

        $percentualMasculino = $total > 0 ? number_format(($totalMasculino / $total) * 100, 1) . '%' : '0%';
        $percentualFeminino = $total > 0 ? number_format(($totalFeminino / $total) * 100, 1) . '%' : '0%';
        $percentualOutro = $total > 0 ? number_format(($totalOutro / $total) * 100, 1) . '%' : '0%';

        // Idade média
        $mediaIdade = Crianca::avg(DB::raw('TIMESTAMPDIFF(YEAR, data_nascimento, CURDATE())'));
        $mediaIdade = number_format($mediaIdade, 1);

        $turmas = Turma::orderBy('nome')->get();

        return view('relatorios.criancas', compact(
            'criancas',
            'turmas',
            'total',
            'totalMasculino',
            'totalFeminino',
            'totalOutro',
            'percentualMasculino',
            'percentualFeminino',
            'percentualOutro',
            'mediaIdade'
        ));
    }

    /**
     * Gera um relatório específico
     */
    public function gerar(Request $request)
    {
        $tipo = $request->input('tipo');
        $formato = $request->input('formato', 'html');

        switch ($tipo) {
            case 'financeiro':
                return $this->financeiro($request);
            case 'presenca':
                return $this->presenca($request);
            case 'matriculas':
                return $this->matriculas($request);
            case 'turmas':
                return $this->turmas();
            case 'criancas':
                return $this->criancas($request);
            case 'pagamentos':
                return $this->pagamentos($request);
            case 'frequencia':
                return $this->frequencia($request);
            case 'responsaveis':
                return $this->responsaveis($request);
            default:
                return redirect()->route('relatorios.index')
                    ->with('error', 'Tipo de relatório inválido');
        }
    }

    /**
     * Exporta um relatório para PDF ou Excel
     */
    public function exportar($tipo)
    {
        // Implementação da exportação de relatórios
        return redirect()->back()->with('info', 'Funcionalidade de exportação em desenvolvimento');
    }

    /**
     * Exporta o relatório de crianças para Excel
     */
    public function exportarCriancas(Request $request)
    {
        // Por enquanto, apenas retorna uma mensagem
        // Em uma implementação real, aqui seria usado um pacote como Maatwebsite/Laravel-Excel
        return redirect()->back()->with('info', 'Exportação de relatório de crianças em desenvolvimento');
    }

    /**
     * Exibe o relatório de pagamentos
     */
    public function pagamentos(Request $request)
    {
        $mes = $request->input('mes', date('m'));
        $ano = $request->input('ano', date('Y'));
        $status = $request->input('status');

        // Construção da query base
        $query = Matricula::whereHas('crianca')
            ->with(['crianca', 'turma', 'pagamentos' => function($q) use ($mes, $ano) {
                $q->whereYear('data_pagamento', $ano)
                  ->whereMonth('data_pagamento', $mes)
                  ->orWhere(function($q) use ($mes, $ano) {
                      $q->whereYear('data_vencimento', $ano)
                        ->whereMonth('data_vencimento', $mes)
                        ->whereNull('data_pagamento');
                  });
            }]);

        // Filtro por status se fornecido
        if ($status) {
            if ($status === 'pago') {
                $query->whereHas('pagamentos', function($q) use ($mes, $ano) {
                    $q->whereYear('data_pagamento', $ano)
                      ->whereMonth('data_pagamento', $mes);
                });
            } elseif ($status === 'pendente') {
                $query->whereHas('pagamentos', function($q) use ($mes, $ano) {
                    $q->whereYear('data_vencimento', $ano)
                      ->whereMonth('data_vencimento', $mes)
                      ->whereNull('data_pagamento');
                });
            } elseif ($status === 'atrasado') {
                $query->whereHas('pagamentos', function($q) use ($mes, $ano) {
                    $q->whereYear('data_vencimento', $ano)
                      ->whereMonth('data_vencimento', $mes)
                      ->whereNull('data_pagamento')
                      ->where('data_vencimento', '<', now());
                });
            }
        }

        $matriculas = $query->get();

        // Estatísticas de pagamentos
        $totalPagamentos = $matriculas->flatMap->pagamentos->count();
        $totalPagos = $matriculas->flatMap->pagamentos->whereNotNull('data_pagamento')->count();
        $totalPendentes = $matriculas->flatMap->pagamentos->whereNull('data_pagamento')->count();
        $totalAtrasados = $matriculas->flatMap->pagamentos->filter(function($pagamento) {
            return $pagamento->data_vencimento < now() && !$pagamento->data_pagamento;
        })->count();

        $valorTotal = $matriculas->flatMap->pagamentos->sum('valor');
        $valorPago = $matriculas->flatMap->pagamentos->whereNotNull('data_pagamento')->sum('valor');
        $valorPendente = $matriculas->flatMap->pagamentos->whereNull('data_pagamento')->sum('valor');

        // Listar meses para o filtro
        $mesesPtBr = [
            1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março',
            4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
            7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro',
            10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
        ];

        return view('relatorios.pagamentos', compact(
            'matriculas',
            'mes',
            'ano',
            'status',
            'mesesPtBr',
            'totalPagamentos',
            'totalPagos',
            'totalPendentes',
            'totalAtrasados',
            'valorTotal',
            'valorPago',
            'valorPendente'
        ));
    }

    /**
     * Exibe o relatório de frequência
     */
    public function frequencia(Request $request)
    {
        // Este método é similar ao de presença, mas com foco em estatísticas de frequência
        $dataInicio = $request->input('data_inicio', date('Y-m-01'));
        $dataFim = $request->input('data_fim', date('Y-m-d'));
        $turmaId = $request->input('turma_id');
        $criancaId = $request->input('crianca_id');

        $query = Presenca::whereBetween('data', [$dataInicio, $dataFim])
            ->with(['crianca', 'crianca.turma']);

        if ($turmaId) {
            $query->whereHas('crianca', function ($q) use ($turmaId) {
                $q->where('turma_id', $turmaId);
            });
        }

        if ($criancaId) {
            $query->where('crianca_id', $criancaId);
        }

        $presencas = $query->get();
        $turmas = Turma::orderBy('nome')->get();
        $criancas = Crianca::orderBy('nome')->get();

        // Agrupamento por criança para calcular a frequência individual
        $frequenciaPorCrianca = $presencas->groupBy('crianca_id')->map(function($grupo) use ($dataInicio, $dataFim) {
            $crianca = $grupo->first()->crianca;
            $diasUteis = $this->calcularDiasUteis($dataInicio, $dataFim);
            $presencasDias = $grupo->where('tipo', 'entrada')->count();
            $percentualFrequencia = $diasUteis > 0 ? round(($presencasDias / $diasUteis) * 100, 1) : 0;

            return [
                'id' => $crianca->id,
                'nome' => $crianca->nome,
                'turma' => $crianca->turma->nome ?? 'Não atribuída',
                'dias_uteis' => $diasUteis,
                'dias_presentes' => $presencasDias,
                'percentual_frequencia' => $percentualFrequencia,
                'faltas' => $diasUteis - $presencasDias
            ];
        });

        // Estatísticas gerais
        $estatisticas = [
            'total_criancas' => $frequenciaPorCrianca->count(),
            'media_frequencia' => $frequenciaPorCrianca->avg('percentual_frequencia'),
            'criancas_100_porcento' => $frequenciaPorCrianca->where('percentual_frequencia', 100)->count(),
            'criancas_abaixo_70_porcento' => $frequenciaPorCrianca->where('percentual_frequencia', '<', 70)->count()
        ];

        return view('relatorios.frequencia', compact(
            'frequenciaPorCrianca',
            'turmas',
            'criancas',
            'estatisticas',
            'dataInicio',
            'dataFim',
            'turmaId',
            'criancaId'
        ));
    }

    /**
     * Calcula dias úteis entre duas datas (excluindo fins de semana)
     */
    private function calcularDiasUteis($dataInicio, $dataFim)
    {
        $inicio = \Carbon\Carbon::parse($dataInicio);
        $fim = \Carbon\Carbon::parse($dataFim);
        $diasUteis = 0;

        for ($data = $inicio; $data->lte($fim); $data->addDay()) {
            // 0 = domingo, 6 = sábado
            if (!in_array($data->dayOfWeek, [0, 6])) {
                $diasUteis++;
            }
        }

        return $diasUteis;
    }

    /**
     * Exibe o relatório de responsáveis
     */
    public function responsaveis(Request $request)
    {
        // Implementação básica do relatório de responsáveis
        $query = \App\Models\Responsavel::with('criancas');

        // Filtros possíveis
        if ($request->has('tipo_responsavel')) {
            $query->where('tipo_responsavel', $request->input('tipo_responsavel'));
        }

        if ($request->has('com_criancas_apenas') && $request->input('com_criancas_apenas')) {
            $query->has('criancas');
        }

        $responsaveis = $query->paginate(15);

        // Estatísticas
        $estatisticas = [
            'total' => \App\Models\Responsavel::count(),
            'pais' => \App\Models\Responsavel::where('tipo_responsavel', 'Pai')->count(),
            'maes' => \App\Models\Responsavel::where('tipo_responsavel', 'Mãe')->count(),
            'outros' => \App\Models\Responsavel::whereNotIn('tipo_responsavel', ['Pai', 'Mãe'])->count(),
            'media_criancas' => \App\Models\Responsavel::has('criancas')->withCount('criancas')->avg('criancas_count') ?: 0
        ];

        return view('relatorios.responsaveis', compact('responsaveis', 'estatisticas'));
    }

    /**
     * Página de exportação de dados do sistema
     */
    public function exportarDados()
    {
        $opcoesExportacao = [
            'criancas' => 'Crianças',
            'responsaveis' => 'Responsáveis',
            'matriculas' => 'Matrículas',
            'pagamentos' => 'Pagamentos',
            'presencas' => 'Registros de Presença',
            'turmas' => 'Turmas',
        ];

        return view('relatorios.exportar', compact('opcoesExportacao'));
    }
}
