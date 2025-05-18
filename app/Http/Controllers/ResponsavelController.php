<?php

namespace App\Http\Controllers;

use App\Models\Responsavel;
use App\Models\Crianca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ResponsavelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $responsaveis = Responsavel::orderBy('nome')->paginate(15);
        return view('responsaveis.index', compact('responsaveis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('responsaveis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'endereco' => 'nullable|string|max:200',
            'bairro' => 'nullable|string|max:100',
            'municipio' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'bi' => 'nullable|string|max:14',
            'parentesco' => 'nullable|string|max:50',
            'obs' => 'nullable|string|max:500',
        ], [
            'nome.required' => 'O nome do responsável é obrigatório',
            'celular.required' => 'O número de celular é obrigatório',
        ]);

        try {
            DB::beginTransaction();

            $responsavel = Responsavel::create($validated);

            DB::commit();

            return redirect()->route('responsaveis.show', $responsavel)
                ->with('success', 'Responsável cadastrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cadastrar responsável: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar responsável. Por favor, tente novamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Responsavel $responsavel)
    {
        $criancasPrincipais = Crianca::where('responsavel_principal_id', $responsavel->id)->get();
        $criancasSecundarias = Crianca::where('responsavel_secundario_id', $responsavel->id)->get();

        return view('responsaveis.show', compact('responsavel', 'criancasPrincipais', 'criancasSecundarias'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Responsavel $responsavel)
    {
        return view('responsaveis.edit', compact('responsavel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Responsavel $responsavel)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'endereco' => 'nullable|string|max:200',
            'bairro' => 'nullable|string|max:100',
            'municipio' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'bi' => 'nullable|string|max:14',
            'parentesco' => 'nullable|string|max:50',
            'obs' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $responsavel->update($validated);

            DB::commit();

            return redirect()->route('responsaveis.show', $responsavel)
                ->with('success', 'Responsável atualizado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atualizar responsável: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar responsável. Por favor, tente novamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Responsavel $responsavel)
    {
        // Verificar se o responsável está vinculado a alguma criança
        $criancasVinculadas = Crianca::where('responsavel_principal_id', $responsavel->id)
            ->orWhere('responsavel_secundario_id', $responsavel->id)
            ->count();

        if ($criancasVinculadas > 0) {
            return redirect()->back()
                ->with('error', 'Este responsável não pode ser excluído pois está vinculado a ' . $criancasVinculadas . ' criança(s).');
        }

        try {
            DB::beginTransaction();

            $responsavel->delete();

            DB::commit();

            return redirect()->route('responsaveis.index')
                ->with('success', 'Responsável excluído com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir responsável: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Erro ao excluir responsável. Por favor, tente novamente.');
        }
    }

    /**
     * Mostra a lista de responsáveis para atribuir a uma criança
     */
    public function atribuirForm(Crianca $crianca)
    {
        $responsaveis = Responsavel::orderBy('nome')->get();
        return view('responsaveis.atribuir', compact('crianca', 'responsaveis'));
    }

    /**
     * Salva a atribuição de responsáveis a uma criança
     */
    public function atribuir(Request $request, Crianca $crianca)
    {
        $validated = $request->validate([
            'responsavel_principal_id' => 'required|exists:responsaveis,id',
            'responsavel_secundario_id' => 'nullable|exists:responsaveis,id|different:responsavel_principal_id',
        ]);

        try {
            DB::beginTransaction();

            $crianca->update($validated);

            DB::commit();

            return redirect()->route('criancas.show', $crianca)
                ->with('success', 'Responsáveis atribuídos com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao atribuir responsáveis: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao atribuir responsáveis. Por favor, tente novamente.');
        }
    }
}
