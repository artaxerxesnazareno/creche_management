<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Presenca;
use App\Models\Responsavel;
use App\Models\Turma;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PresencaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->input('data', date('Y-m-d'));
        $turmaId = $request->input('turma_id');

        $query = Crianca::with(['presencas' => function ($query) use ($data) {
            $query->whereDate('data', $data);
        }, 'turma'])
        ->whereHas('matriculas', function ($query) {
            $query->where('status', 'Ativa');
        });

        if ($turmaId) {
            $query->where('turma_id', $turmaId);
        }

        $criancas = $query->get();
        $turmas = Turma::orderBy('nome')->get();

        // Estatísticas do dia
        $totalCriancas = $criancas->count();
        $presentes = $criancas->filter(function ($crianca) {
            return $crianca->presencas->where('tipo', 'entrada')->count() > 0;
        })->count();

        $ausentes = $totalCriancas - $presentes;

        return view('presencas.index', compact('criancas', 'turmas', 'data', 'turmaId', 'presentes', 'ausentes', 'totalCriancas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $turmas = Turma::with(['criancas' => function ($query) {
            $query->whereHas('matriculas', function ($q) {
                $q->where('status', 'Ativa');
            });
        }])->get();

        $data = date('Y-m-d');

        return view('presencas.create', compact('turmas', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|date',
            'presencas' => 'required|array',
            'presencas.*' => 'required|in:presente,ausente',
            'observacoes' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $data = $validated['data'];

            // Remover presenças existentes para esta data
            Presenca::whereDate('data', $data)->delete();

            // Registrar novas presenças
            foreach ($validated['presencas'] as $criancaId => $status) {
                Presenca::create([
                    'crianca_id' => $criancaId,
                    'data' => $data,
                    'tipo' => $status === 'presente' ? 'entrada' : 'falta',
                    'hora' => $status === 'presente' ? now()->format('H:i:s') : null,
                    'observacao' => $validated['observacoes'][$criancaId] ?? null,
                ]);
            }

            DB::commit();

            return redirect()->route('presencas.index', ['data' => $data])
                ->with('success', 'Presenças registradas com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Erro ao registrar presenças: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Exibe o formulário para registrar a entrada da criança
     */
    public function registrarEntrada(Crianca $crianca)
    {
        $presenca = Presenca::whereDate('data', today())
            ->where('crianca_id', $crianca->id)
            ->where('tipo', 'entrada')
            ->first();

        if ($presenca) {
            return redirect()->route('criancas.show', $crianca)
                ->with('info', 'Entrada já registrada para hoje.');
        }

        return view('presencas.registrar-entrada', compact('crianca'));
    }

    /**
     * Processa o registro de entrada da criança
     */
    public function salvarEntrada(Request $request, Crianca $crianca)
    {
        $validated = $request->validate([
            'observacao' => 'nullable|string',
            'responsavel' => 'nullable|string',
        ]);

        try {
            Presenca::create([
                'crianca_id' => $crianca->id,
                'data' => today(),
                'tipo' => 'entrada',
                'hora' => now()->format('H:i:s'),
                'observacao' => $validated['observacao'] ?? null,
                'responsavel' => $validated['responsavel'] ?? null,
            ]);

            return redirect()->route('criancas.show', $crianca)
                ->with('success', 'Entrada registrada com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao registrar entrada: ' . $e->getMessage());
        }
    }

    /**
     * Exibe o formulário para registrar a saída da criança
     */
    public function registrarSaida(Crianca $crianca)
    {
        $entrada = Presenca::whereDate('data', today())
            ->where('crianca_id', $crianca->id)
            ->where('tipo', 'entrada')
            ->first();

        if (!$entrada) {
            return redirect()->route('criancas.show', $crianca)
                ->with('error', 'Não há registro de entrada para hoje.');
        }

        $saida = Presenca::whereDate('data', today())
            ->where('crianca_id', $crianca->id)
            ->where('tipo', 'saida')
            ->first();

        if ($saida) {
            return redirect()->route('criancas.show', $crianca)
                ->with('info', 'Saída já registrada para hoje.');
        }

        return view('presencas.registrar-saida', compact('crianca', 'entrada'));
    }

    /**
     * Processa o registro de saída da criança
     */
    public function salvarSaida(Request $request, Crianca $crianca)
    {
        $validated = $request->validate([
            'observacao' => 'nullable|string',
            'responsavel' => 'nullable|string',
        ]);

        try {
            Presenca::create([
                'crianca_id' => $crianca->id,
                'data' => today(),
                'tipo' => 'saida',
                'hora' => now()->format('H:i:s'),
                'observacao' => $validated['observacao'] ?? null,
                'responsavel' => $validated['responsavel'] ?? null,
            ]);

            return redirect()->route('criancas.show', $crianca)
                ->with('success', 'Saída registrada com sucesso!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erro ao registrar saída: ' . $e->getMessage());
        }
    }

    /**
     * Exibe o histórico de presenças de uma criança
     */
    public function historico(Crianca $crianca, Request $request)
    {
        $mes = $request->input('mes', date('m'));
        $ano = $request->input('ano', date('Y'));

        $dataInicio = Carbon::createFromDate($ano, $mes, 1)->startOfMonth();
        $dataFim = Carbon::createFromDate($ano, $mes, 1)->endOfMonth();

        $presencas = Presenca::where('crianca_id', $crianca->id)
            ->whereBetween('data', [$dataInicio, $dataFim])
            ->orderBy('data')
            ->orderBy('hora')
            ->get()
            ->groupBy(function ($item) {
                return $item->data->format('Y-m-d');
            });

        $diasUteis = $this->calcularDiasUteis($dataInicio, $dataFim);
        $diasPresente = $presencas->filter(function ($grupo) {
            return $grupo->where('tipo', 'entrada')->count() > 0;
        })->count();

        $percentualPresenca = $diasUteis > 0 ? round(($diasPresente / $diasUteis) * 100, 1) : 0;

        return view('presencas.historico', compact('crianca', 'presencas', 'mes', 'ano', 'diasUteis', 'diasPresente', 'percentualPresenca'));
    }

    /**
     * Exibe o relatório de presenças
     */
    public function relatorio(Request $request)
    {
        $mes = $request->input('mes', date('m'));
        $ano = $request->input('ano', date('Y'));
        $turmaId = $request->input('turma_id');

        $dataInicio = Carbon::createFromDate($ano, $mes, 1)->startOfMonth();
        $dataFim = Carbon::createFromDate($ano, $mes, 1)->endOfMonth();

        $query = Crianca::with(['presencas' => function ($query) use ($dataInicio, $dataFim) {
            $query->whereBetween('data', [$dataInicio, $dataFim]);
        }, 'turma'])
        ->whereHas('matriculas', function ($query) {
            $query->where('status', 'Ativa');
        });

        if ($turmaId) {
            $query->where('turma_id', $turmaId);
        }

        $criancas = $query->get();
        $turmas = Turma::orderBy('nome')->get();

        $diasUteis = $this->calcularDiasUteis($dataInicio, $dataFim);

        // Calcular estatísticas para cada criança
        foreach ($criancas as $crianca) {
            $diasPresente = $crianca->presencas->groupBy(function ($item) {
                return $item->data->format('Y-m-d');
            })->filter(function ($grupo) {
                return $grupo->where('tipo', 'entrada')->count() > 0;
            })->count();

            $crianca->dias_presente = $diasPresente;
            $crianca->percentual_presenca = $diasUteis > 0 ? round(($diasPresente / $diasUteis) * 100, 1) : 0;
        }

        return view('presencas.relatorio', compact('criancas', 'turmas', 'mes', 'ano', 'turmaId', 'diasUteis'));
    }

    /**
     * Calcula os dias úteis em um período (excluindo sábados e domingos)
     */
    private function calcularDiasUteis($dataInicio, $dataFim)
    {
        $diasUteis = 0;
        $data = clone $dataInicio;

        while ($data <= $dataFim) {
            // 6 = sábado, 0 = domingo
            if ($data->dayOfWeek !== 0 && $data->dayOfWeek !== 6) {
                $diasUteis++;
            }
            $data->addDay();
        }

        return $diasUteis;
    }
}
