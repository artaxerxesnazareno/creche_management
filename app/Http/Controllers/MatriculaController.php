<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Matricula;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MatriculaController extends Controller
{
    /**
     * Exibe uma lista de todas as matrículas
     */
    public function index(Request $request)
    {
        $query = Matricula::query()->with(['crianca', 'turma']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('crianca', function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%");
            });
        }

        if ($request->has('filter') && $request->filter) {
            $status = ucfirst(strtolower($request->filter));
            $query->where('status', $status);
        }

        $matriculas = $query->latest()->paginate(10);

        // Garantir que cada matrícula tenha um código
        foreach ($matriculas as $matricula) {
            $matricula->codigo;
        }

        return view('matriculas.index', compact('matriculas'));
    }

    /**
     * Mostra o formulário para criar uma nova matrícula
     */
    public function create()
    {
        $criancas = Crianca::orderBy('nome')->get();
        $turmas = Turma::orderBy('nome')->get();

        return view('matriculas.create', compact('criancas', 'turmas'));
    }

    /**
     * Armazena uma nova matrícula no banco de dados
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'crianca_id' => 'required|exists:criancas,id',
            'turma_id' => 'required|exists:turmas,id',
            'data_inicio' => 'required|date',
            'periodo' => 'required|string|in:Integral,Manhã,Tarde',
            'valor_mensalidade' => 'required|numeric|min:0',
            'desconto' => 'nullable|numeric|min:0|max:100',
            'taxa_matricula' => 'nullable|numeric|min:0',
            'dia_vencimento' => 'required|integer|min:1|max:28',
            'status' => 'required|string|in:Pendente,Ativa,Cancelada',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Verificar se já existe matrícula ativa para esta criança
            $matriculaAtiva = Matricula::where('crianca_id', $validated['crianca_id'])
                ->where('status', 'Ativa')
                ->first();

            if ($matriculaAtiva && $validated['status'] === 'Ativa') {
                return back()->withInput()->with('error', 'Esta criança já possui uma matrícula ativa.');
            }

            // Criar a matrícula
            $matricula = Matricula::create($validated);

            // Atualizar a turma da criança se a matrícula estiver ativa
            if ($validated['status'] === 'Ativa') {
                $crianca = Crianca::find($validated['crianca_id']);
                $crianca->update([
                    'turma_id' => $validated['turma_id'],
                    'periodo' => $validated['periodo']
                ]);
            }

            DB::commit();

            return redirect()->route('matriculas.show', $matricula)
                ->with('success', 'Matrícula criada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao criar matrícula: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Erro ao criar matrícula. Por favor, tente novamente.');
        }
    }

    /**
     * Exibe os detalhes de uma matrícula específica
     */
    public function show(Matricula $matricula)
    {
        $matricula->load(['crianca', 'turma']);

        return view('matriculas.show', compact('matricula'));
    }

    /**
     * Mostra o formulário para editar uma matrícula específica
     */
    public function edit(Matricula $matricula)
    {
        $criancas = Crianca::orderBy('nome')->get();
        $turmas = Turma::orderBy('nome')->get();

        return view('matriculas.edit', compact('matricula', 'criancas', 'turmas'));
    }

    /**
     * Atualiza uma matrícula específica no banco de dados
     */
    public function update(Request $request, Matricula $matricula)
    {
        $validated = $request->validate([
            'crianca_id' => 'required|exists:criancas,id',
            'turma_id' => 'required|exists:turmas,id',
            'data_inicio' => 'required|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'periodo' => 'required|string|in:Integral,Manhã,Tarde',
            'valor_mensalidade' => 'required|numeric|min:0',
            'desconto' => 'nullable|numeric|min:0|max:100',
            'taxa_matricula' => 'nullable|numeric|min:0',
            'dia_vencimento' => 'required|integer|min:1|max:28',
            'status' => 'required|string|in:Pendente,Ativa,Cancelada,Concluída',
            'observacoes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Verificar se já existe matrícula ativa para esta criança (que não seja esta)
            if ($validated['status'] === 'Ativa') {
                $matriculaAtiva = Matricula::where('crianca_id', $validated['crianca_id'])
                    ->where('status', 'Ativa')
                    ->where('id', '!=', $matricula->id)
                    ->first();

                if ($matriculaAtiva) {
                    return back()->withInput()->with('error', 'Esta criança já possui outra matrícula ativa.');
                }
            }

            // Atualizar a matrícula
            $matricula->update($validated);

            // Atualizar a turma da criança se a matrícula estiver ativa
            if ($validated['status'] === 'Ativa') {
                $crianca = Crianca::find($validated['crianca_id']);
                $crianca->update([
                    'turma_id' => $validated['turma_id'],
                    'periodo' => $validated['periodo']
                ]);
            }

            DB::commit();

            return redirect()->route('matriculas.show', $matricula)
                ->with('success', 'Matrícula atualizada com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar matrícula: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Erro ao atualizar matrícula. Por favor, tente novamente.');
        }
    }

    /**
     * Remove uma matrícula específica do banco de dados
     */
    public function destroy(Matricula $matricula)
    {
        try {
            DB::beginTransaction();

            $matricula->delete();

            DB::commit();

            return redirect()->route('matriculas.index')
                ->with('success', 'Matrícula excluída com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir matrícula: ' . $e->getMessage());

            return back()->with('error', 'Erro ao excluir matrícula. Por favor, tente novamente.');
        }
    }
}
