<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TurmaController extends Controller
{
    /**
     * Exibe uma lista de todas as turmas
     */
    public function index(Request $request)
    {
        $query = Turma::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
        }

        $turmas = $query->withCount('criancas')->latest()->paginate(10);

        return view('turmas.index', compact('turmas'));
    }

    /**
     * Mostra o formulário para criar uma nova turma
     */
    public function create()
    {
        return view('turmas.create');
    }

    /**
     * Armazena uma nova turma no banco de dados
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'idade_minima' => 'nullable|integer|min:0',
            'idade_maxima' => 'nullable|integer|min:0',
            'capacidade' => 'nullable|integer|min:1',
            'professor_id' => 'nullable|integer',
            'sala' => 'nullable|string|max:50',
            'ano_letivo' => 'nullable|string|max:20',
        ]);

        try {
            $turma = Turma::create($validated);

            return redirect()->route('turmas.show', $turma)
                ->with('success', 'Turma criada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao criar turma: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Erro ao criar turma. Por favor, tente novamente.');
        }
    }

    /**
     * Exibe os detalhes de uma turma específica
     */
    public function show(Turma $turma)
    {
        $turma->load(['criancas']);

        return view('turmas.show', compact('turma'));
    }

    /**
     * Mostra o formulário para editar uma turma específica
     */
    public function edit(Turma $turma)
    {
        return view('turmas.edit', compact('turma'));
    }

    /**
     * Atualiza uma turma específica no banco de dados
     */
    public function update(Request $request, Turma $turma)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'idade_minima' => 'nullable|integer|min:0',
            'idade_maxima' => 'nullable|integer|min:0',
            'capacidade' => 'nullable|integer|min:1',
            'professor_id' => 'nullable|integer',
            'sala' => 'nullable|string|max:50',
            'ano_letivo' => 'nullable|string|max:20',
        ]);

        try {
            $turma->update($validated);

            return redirect()->route('turmas.show', $turma)
                ->with('success', 'Turma atualizada com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao atualizar turma: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Erro ao atualizar turma. Por favor, tente novamente.');
        }
    }

    /**
     * Remove uma turma específica do banco de dados
     */
    public function destroy(Turma $turma)
    {
        try {
            // Verificar se existem crianças associadas a esta turma
            if ($turma->criancas()->count() > 0) {
                return back()->with('error', 'Não é possível excluir esta turma pois existem crianças associadas a ela.');
            }

            $turma->delete();

            return redirect()->route('turmas.index')
                ->with('success', 'Turma excluída com sucesso!');
        } catch (\Exception $e) {
            Log::error('Erro ao excluir turma: ' . $e->getMessage());

            return back()->with('error', 'Erro ao excluir turma. Por favor, tente novamente.');
        }
    }
}
