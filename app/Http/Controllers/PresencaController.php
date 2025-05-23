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
            return $crianca->presencas->whereNotNull('hora_entrada')->count() > 0;
        })->count();

        $ausentes = $totalCriancas - $presentes;

        return view('presenca.index', compact('criancas', 'turmas', 'data', 'turmaId', 'presentes', 'ausentes', 'totalCriancas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criancas = Crianca::with(['responsavelPrincipal', 'turma'])
            ->whereHas('matriculas', function ($q) {
                $q->where('status', 'Ativa');
            })
            ->orderBy('nome')
            ->get();

        $responsaveis = Responsavel::orderBy('nome')->get();
        $turmas = Turma::orderBy('nome')->get();
        $data = date('Y-m-d');

        return view('presenca.registrar', compact('criancas', 'responsaveis', 'turmas', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|date',
            'crianca_id' => 'required|exists:criancas,id',
            'hora_entrada' => 'required|date_format:H:i',
            'responsavel_entrada_id' => 'required|exists:responsaveis,id',
            'hora_saida' => 'nullable|date_format:H:i',
            'responsavel_saida_id' => 'nullable|exists:responsaveis,id|required_with:hora_saida',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $data = $validated['data'];

            // Verificar se já existe um registro para esta data e criança
            $presenca = Presenca::firstOrNew([
                'crianca_id' => $validated['crianca_id'],
                'data' => $data,
            ]);

            $presenca->hora_entrada = $validated['hora_entrada'];
            $presenca->responsavel_entrada_id = $validated['responsavel_entrada_id'];

            if (!empty($validated['hora_saida'])) {
                $presenca->hora_saida = $validated['hora_saida'];
                $presenca->responsavel_saida_id = $validated['responsavel_saida_id'];
            }

            $presenca->observacoes = $validated['observacoes'] ?? null;
            $presenca->save();

            DB::commit();

            return redirect()->route('presenca.index', ['data' => $data])
                ->with('success', 'Presença registrada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'Erro ao registrar presença: ' . $e->getMessage());
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
            ->whereNotNull('hora_entrada')
            ->first();

        if ($presenca) {
            return redirect()->route('presenca.index')
                ->with('info', 'Entrada já registrada para hoje.');
        }

        $responsaveis = Responsavel::orderBy('nome')->get();

        return view('presenca.registrar-entrada', compact('crianca', 'responsaveis'));
    }

    /**
     * Processa o registro de entrada da criança
     */
    public function salvarEntrada(Request $request, Crianca $crianca)
    {
        $validated = $request->validate([
            'observacao' => 'nullable|string',
            'responsavel_entrada_id' => 'required|exists:responsaveis,id',
        ]);

        try {
            // Verificar se já existe um registro para hoje
            $presenca = Presenca::firstOrNew([
                'crianca_id' => $crianca->id,
                'data' => today(),
            ]);

            $presenca->hora_entrada = now()->format('H:i:s');
            $presenca->responsavel_entrada_id = $validated['responsavel_entrada_id'];
            $presenca->observacoes = $validated['observacao'] ?? null;
            $presenca->save();

            return redirect()->route('presenca.index')
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
            ->whereNotNull('hora_entrada')
            ->first();

        if (!$entrada) {
            return redirect()->route('presenca.index')
                ->with('error', 'Não há registro de entrada para hoje.');
        }

        if ($entrada->hora_saida) {
            return redirect()->route('presenca.index')
                ->with('info', 'Saída já registrada para hoje.');
        }

        $responsaveis = Responsavel::orderBy('nome')->get();

        return view('presenca.registrar-saida', compact('crianca', 'entrada', 'responsaveis'));
    }

    /**
     * Processa o registro de saída da criança
     */
    public function salvarSaida(Request $request, Crianca $crianca)
    {
        $validated = $request->validate([
            'observacao' => 'nullable|string',
            'responsavel_saida_id' => 'required|exists:responsaveis,id',
        ]);

        try {
            // Buscar o registro de entrada de hoje
            $presenca = Presenca::whereDate('data', today())
                ->where('crianca_id', $crianca->id)
                ->whereNotNull('hora_entrada')
                ->first();

            if (!$presenca) {
                return back()->with('error', 'Não há registro de entrada para hoje.');
            }

            // Atualizar com os dados de saída
            $presenca->hora_saida = now()->format('H:i:s');
            $presenca->responsavel_saida_id = $validated['responsavel_saida_id'];

            // Se houver uma nova observação, anexá-la às observações existentes
            if (!empty($validated['observacao'])) {
                $observacoes = $presenca->observacoes ? $presenca->observacoes . "\n\nSaída: " : "Saída: ";
                $presenca->observacoes = $observacoes . $validated['observacao'];
            }

            $presenca->save();

            return redirect()->route('presenca.index')
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
            ->get()
            ->groupBy(function ($item) {
                return $item->data->format('Y-m-d');
            });

        $diasUteis = $this->calcularDiasUteis($dataInicio, $dataFim);
        $diasPresente = $presencas->filter(function ($grupo) {
            // Considera presente se tiver hora_entrada registrada
            return $grupo->first() && $grupo->first()->hora_entrada;
        })->count();

        $percentualPresenca = $diasUteis > 0 ? round(($diasPresente / $diasUteis) * 100, 1) : 0;

        return view('presenca.historico', compact('crianca', 'presencas', 'mes', 'ano', 'diasUteis', 'diasPresente', 'percentualPresenca'));
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
            $diasPresente = $crianca->presencas
                ->groupBy(function ($item) {
                    return $item->data->format('Y-m-d');
                })
                ->filter(function ($grupo) {
                    return $grupo->first() && $grupo->first()->hora_entrada;
                })->count();

            $crianca->dias_presente = $diasPresente;
            $crianca->percentual_presenca = $diasUteis > 0 ? round(($diasPresente / $diasUteis) * 100, 1) : 0;
        }

        return view('presenca.relatorio', compact('criancas', 'turmas', 'mes', 'ano', 'turmaId', 'diasUteis'));
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

    /**
     * Processa o registro de entrada via AJAX
     */
    public function processarEntrada(Request $request, Crianca $crianca)
    {
        try {
            $validated = $request->validate([
                'responsavel_entrada_id' => 'required|exists:responsaveis,id',
                'observacao' => 'nullable|string',
            ]);

            // Verificar se já existe um registro para hoje
            $presenca = Presenca::firstOrNew([
                'crianca_id' => $crianca->id,
                'data' => today(),
            ]);

            if ($presenca->hora_entrada) {
                return response()->json([
                    'success' => false,
                    'message' => 'Entrada já registrada para esta criança hoje.'
                ]);
            }

            // Registrar entrada
            $presenca->hora_entrada = now()->format('H:i:s');
            $presenca->responsavel_entrada_id = $validated['responsavel_entrada_id'];
            $presenca->observacoes = $validated['observacao'] ?? null;
            $presenca->save();

            return response()->json([
                'success' => true,
                'message' => 'Entrada registrada com sucesso!'
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao registrar entrada: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao registrar entrada: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Processa o registro de saída via AJAX
     */
    public function processarSaida(Request $request, Crianca $crianca)
    {
        try {
            $validated = $request->validate([
                'responsavel_saida_id' => 'required|exists:responsaveis,id',
                'observacao' => 'nullable|string',
            ]);

            // Buscar o registro de entrada de hoje
            $presenca = Presenca::where('crianca_id', $crianca->id)
                ->whereDate('data', today())
                ->whereNotNull('hora_entrada')
                ->first();

            if (!$presenca) {
                return response()->json([
                    'success' => false,
                    'message' => 'Não há registro de entrada para hoje.'
                ]);
            }

            if ($presenca->hora_saida) {
                return response()->json([
                    'success' => false,
                    'message' => 'Saída já registrada para esta criança hoje.'
                ]);
            }

            // Registrar saída
            $presenca->hora_saida = now()->format('H:i:s');
            $presenca->responsavel_saida_id = $validated['responsavel_saida_id'];

            // Se houver uma nova observação, anexá-la às observações existentes
            if (!empty($validated['observacao'])) {
                $observacoes = $presenca->observacoes ? $presenca->observacoes . "\n\nSaída: " : "Saída: ";
                $presenca->observacoes = $observacoes . $validated['observacao'];
            }

            $presenca->save();

            return response()->json([
                'success' => true,
                'message' => 'Saída registrada com sucesso!'
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao registrar saída: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erro ao registrar saída: ' . $e->getMessage()
            ], 500);
        }
    }
}
