<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Presenca;
use App\Models\Responsavel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PresencaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        // Verificar se já existe registro de entrada para hoje
        $hoje = now()->format('Y-m-d');
        $presencaHoje = Presenca::where('crianca_id', $crianca->id)
            ->where('data', $hoje)
            ->first();

        if ($presencaHoje && $presencaHoje->hora_entrada) {
            return redirect()->route('criancas.show', $crianca)
                ->with('error', 'A entrada desta criança já foi registrada hoje.');
        }

        // Buscar responsáveis para preencher o select
        $responsaveis = Responsavel::orderBy('nome')->get();

        return view('presencas.registrar-entrada', compact('crianca', 'responsaveis'));
    }

    /**
     * Processa o registro de entrada da criança
     */
    public function salvarEntrada(Request $request, Crianca $crianca)
    {
        $validated = $request->validate([
            'responsavel_entrada_id' => 'required|exists:responsaveis,id',
            'observacoes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $hoje = now()->format('Y-m-d');
            $horaAtual = now()->format('H:i:s');

            // Verificar se já existe registro de presença para hoje
            $presenca = Presenca::firstOrNew([
                'crianca_id' => $crianca->id,
                'data' => $hoje,
            ]);

            if ($presenca->hora_entrada) {
                return redirect()->route('criancas.show', $crianca)
                    ->with('error', 'A entrada desta criança já foi registrada hoje.');
            }

            $presenca->hora_entrada = $horaAtual;
            $presenca->responsavel_entrada_id = $validated['responsavel_entrada_id'];
            $presenca->observacoes = $validated['observacoes'] ?? null;
            $presenca->save();

            DB::commit();

            return redirect()->route('criancas.show', $crianca)
                ->with('success', 'Entrada registrada com sucesso às ' . $horaAtual);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao registrar entrada da criança: ' . $e->getMessage());

            return redirect()->route('criancas.show', $crianca)
                ->with('error', 'Erro ao registrar entrada. Por favor, tente novamente.');
        }
    }

    /**
     * Exibe o formulário para registrar a saída da criança
     */
    public function registrarSaida(Crianca $crianca)
    {
        // Verificar se existe registro de entrada sem saída para hoje
        $hoje = now()->format('Y-m-d');
        $presencaHoje = Presenca::where('crianca_id', $crianca->id)
            ->where('data', $hoje)
            ->first();

        if (!$presencaHoje || !$presencaHoje->hora_entrada) {
            return redirect()->route('criancas.show', $crianca)
                ->with('error', 'A entrada desta criança não foi registrada hoje.');
        }

        if ($presencaHoje->hora_saida) {
            return redirect()->route('criancas.show', $crianca)
                ->with('error', 'A saída desta criança já foi registrada hoje.');
        }

        // Buscar responsáveis para preencher o select
        $responsaveis = Responsavel::orderBy('nome')->get();

        return view('presencas.registrar-saida', compact('crianca', 'responsaveis', 'presencaHoje'));
    }

    /**
     * Processa o registro de saída da criança
     */
    public function salvarSaida(Request $request, Crianca $crianca)
    {
        $validated = $request->validate([
            'responsavel_saida_id' => 'required|exists:responsaveis,id',
            'observacoes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $hoje = now()->format('Y-m-d');
            $horaAtual = now()->format('H:i:s');

            // Buscar o registro de presença para hoje
            $presenca = Presenca::where('crianca_id', $crianca->id)
                ->where('data', $hoje)
                ->first();

            if (!$presenca || !$presenca->hora_entrada) {
                return redirect()->route('criancas.show', $crianca)
                    ->with('error', 'A entrada desta criança não foi registrada hoje.');
            }

            if ($presenca->hora_saida) {
                return redirect()->route('criancas.show', $crianca)
                    ->with('error', 'A saída desta criança já foi registrada hoje.');
            }

            // Atualizar os dados de saída
            $presenca->hora_saida = $horaAtual;
            $presenca->responsavel_saida_id = $validated['responsavel_saida_id'];

            // Adicionar observações ou manter as existentes
            if (!empty($validated['observacoes'])) {
                $presenca->observacoes = $presenca->observacoes
                    ? $presenca->observacoes . "\n\nSaída: " . $validated['observacoes']
                    : "Saída: " . $validated['observacoes'];
            }

            $presenca->save();

            DB::commit();

            return redirect()->route('criancas.show', $crianca)
                ->with('success', 'Saída registrada com sucesso às ' . $horaAtual);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao registrar saída da criança: ' . $e->getMessage());

            return redirect()->route('criancas.show', $crianca)
                ->with('error', 'Erro ao registrar saída. Por favor, tente novamente.');
        }
    }

    /**
     * Exibe o histórico de presenças de uma criança
     */
    public function historico(Crianca $crianca)
    {
        $presencas = $crianca->presencas()->paginate(20);

        return view('presencas.historico', compact('crianca', 'presencas'));
    }
}
