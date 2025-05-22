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
}
