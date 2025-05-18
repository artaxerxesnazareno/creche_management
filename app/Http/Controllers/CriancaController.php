<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use Illuminate\Http\Request;
use App\Models\Turma;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CriancaController extends Controller
{
    /**
     * Exibe uma lista de todas as crianças.
     */
    public function index(Request $request)
    {
        $query = Crianca::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhereHas('responsavelPrincipal', function($q) use ($search) {
                      $q->where('nome', 'like', "%{$search}%")
                        ->orWhere('bi', 'like', "%{$search}%");
                  });
            });
        }

        $criancas = $query->with(['responsavelPrincipal', 'responsavelSecundario'])
                         ->latest()
                         ->paginate(10);

        return view('criancas.index', compact('criancas'));
    }

    /**
     * Mostra o formulário para criar uma nova criança.
     */
    public function create()
    {
        $turmas = Turma::orderBy('nome')->get();
        return view('criancas.create', compact('turmas'));
    }

    /**
     * Armazena uma nova criança no banco de dados.
     */
    public function store(Request $request)
    {
        try {
            // Usar DB transaction para garantir consistência
            DB::beginTransaction();

            // Simplificar validação para campos essenciais
            $validated = $request->validate([
                'nome' => 'required|string|max:255',
                'data_nascimento' => 'required|date',
                'genero' => 'required|string|in:Masculino,Feminino,Outro',
            ]);

            // Campos opcionais
            $validated['turma_id'] = $request->turma_id;
            $validated['periodo'] = $request->periodo;
            $validated['observacoes'] = $request->observacoes;
            $validated['alergias'] = $request->alergias;
            $validated['medicacoes'] = $request->medicacoes;
            $validated['necessidades_especiais'] = $request->necessidades_especiais;
            $validated['restricoes_alimentares'] = $request->restricoes_alimentares;

            // Salvar foto se enviada
            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('fotos_criancas', 'public');
                $validated['foto'] = $path;
            }

            // Registrar os dados validados
            Log::info('Dados validados:', $validated);

            // Criar criança
            $crianca = Crianca::create($validated);

            // Registrar ID da criança criada
            Log::info('Criança criada com ID: ' . $crianca->id);

            // Confirmar transação
            DB::commit();

            return redirect()->route('criancas.index')
                ->with('success', 'Criança cadastrada com sucesso!');

        } catch (\Exception $e) {
            // Reverter transação em caso de erro
            DB::rollBack();

            // Registrar exceção
            Log::error('Erro ao criar criança: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return back()->withInput()->withErrors(['error' => 'Erro ao cadastrar criança: ' . $e->getMessage()]);
        }
    }

    /**
     * Exibe os detalhes de uma criança específica.
     */
    public function show(Crianca $crianca)
    {
        try {
            // Carrega os relacionamentos necessários
            $crianca->load(['turma', 'responsavelPrincipal', 'responsavelSecundario']);

            // Registra o acesso à visualização da criança
            Log::info('Visualizando detalhes da criança: ' . $crianca->id);

            return view('criancas.show', compact('crianca'));
        } catch (\Exception $e) {
            Log::error('Erro ao exibir detalhes da criança: ' . $e->getMessage());
            return redirect()->route('criancas.index')
                ->with('error', 'Erro ao exibir detalhes da criança: ' . $e->getMessage());
        }
    }

    /**
     * Mostra o formulário para editar uma criança específica.
     */
    public function edit(Crianca $crianca)
    {
        $turmas = Turma::orderBy('nome')->get();
        $crianca->load(['responsavelPrincipal', 'responsavelSecundario']);
        return view('criancas.edit', compact('crianca', 'turmas'));
    }

    /**
     * Atualiza uma criança específica no banco de dados.
     */
    public function update(Request $request, Crianca $crianca)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'genero' => 'required|string|in:Masculino,Feminino,Outro',
            'turma_id' => 'nullable|exists:turmas,id',
            'periodo' => 'nullable|string|in:Integral,Manhã,Tarde',
            'observacoes' => 'nullable|string',
            'endereco' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:100',
            'municipio' => 'nullable|string|max:100',
            'provincia' => 'nullable|string|max:100',
            'alergias' => 'nullable|string',
            'medicacoes' => 'nullable|string',
            'restricoes_alimentares' => 'nullable|string',
            'necessidades_especiais' => 'nullable|string',
            'tipo_sanguineo' => 'nullable|string|max:5',
            'convenio_medico' => 'nullable|string|max:100',
            'responsavel_principal_id' => 'required|exists:responsaveis,id',
            'responsavel_secundario_id' => 'nullable|exists:responsaveis,id',
            'autorizados' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'certidao' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'carteira_vacinacao' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'laudo_medico' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($crianca->foto) {
                Storage::disk('public')->delete($crianca->foto);
            }
            $path = $request->file('foto')->store('fotos_criancas', 'public');
            $validated['foto'] = $path;
        }

        if ($request->hasFile('certidao')) {
            if ($crianca->certidao) {
                Storage::disk('public')->delete($crianca->certidao);
            }
            $validated['certidao'] = $request->file('certidao')->store('criancas/documentos', 'public');
        }
        if ($request->hasFile('carteira_vacinacao')) {
            if ($crianca->carteira_vacinacao) {
                Storage::disk('public')->delete($crianca->carteira_vacinacao);
            }
            $validated['carteira_vacinacao'] = $request->file('carteira_vacinacao')->store('criancas/documentos', 'public');
        }
        if ($request->hasFile('laudo_medico')) {
            if ($crianca->laudo_medico) {
                Storage::disk('public')->delete($crianca->laudo_medico);
            }
            $validated['laudo_medico'] = $request->file('laudo_medico')->store('criancas/documentos', 'public');
        }

        $crianca->update($validated);

        return redirect()->route('criancas.index')
            ->with('success', 'Dados da criança atualizados com sucesso!');
    }

    /**
     * Remove uma criança específica do banco de dados.
     */
    public function destroy(Crianca $crianca)
    {
        // Deletar arquivos
        if ($crianca->foto) {
            Storage::disk('public')->delete($crianca->foto);
        }
        if ($crianca->certidao) {
            Storage::disk('public')->delete($crianca->certidao);
        }
        if ($crianca->carteira_vacinacao) {
            Storage::disk('public')->delete($crianca->carteira_vacinacao);
        }
        if ($crianca->laudo_medico) {
            Storage::disk('public')->delete($crianca->laudo_medico);
        }

        $crianca->delete();

        return redirect()->route('criancas.index')
            ->with('success', 'Criança excluída com sucesso!');
    }
}
