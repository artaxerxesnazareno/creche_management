<?php

namespace App\Http\Controllers;

use App\Models\Crianca;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{
    /**
     * Exibe o formulário para criar um novo documento
     */
    public function create(Crianca $crianca)
    {
        return view('documentos.create', compact('crianca'));
    }

    /**
     * Armazena um novo documento no banco de dados
     */
    public function store(Request $request, Crianca $crianca)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'titulo' => 'required|string|max:255',
                'tipo' => 'required|string|max:100',
                'arquivo' => 'required|file|max:10240', // 10MB max
                'observacoes' => 'nullable|string',
            ], [
                'titulo.required' => 'O título do documento é obrigatório',
                'tipo.required' => 'O tipo de documento é obrigatório',
                'arquivo.required' => 'É necessário enviar um arquivo',
                'arquivo.file' => 'O arquivo enviado é inválido',
                'arquivo.max' => 'O arquivo não pode ter mais que 10MB'
            ]);

            // Upload do arquivo
            if ($request->hasFile('arquivo')) {
                $path = $request->file('arquivo')->store('documentos_criancas/' . $crianca->id, 'public');
                $validated['arquivo'] = $path;
            }

            // Adiciona o ID da criança
            $validated['crianca_id'] = $crianca->id;

            // Cria o documento
            $documento = Documento::create($validated);

            DB::commit();

            return redirect()->route('criancas.show', $crianca)
                ->with('success', 'Documento cadastrado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao cadastrar documento: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'Erro ao cadastrar documento: ' . $e->getMessage());
        }
    }

    /**
     * Faz o download de um documento
     */
    public function download(Documento $documento)
    {
        // Verificar se o arquivo existe
        if (!Storage::disk('public')->exists($documento->arquivo)) {
            return redirect()->back()->with('error', 'O arquivo não foi encontrado.');
        }

        // Incrementar contador de downloads
        $documento->update(['downloads' => $documento->downloads + 1]);

        // Log de download
        Log::info('Documento baixado: ID ' . $documento->id . ', Título: ' . $documento->titulo);

        // Retornar arquivo para download
        return Storage::disk('public')->download($documento->arquivo, $documento->titulo . '.' . pathinfo($documento->arquivo, PATHINFO_EXTENSION));
    }

    /**
     * Remove um documento do banco de dados
     */
    public function destroy(Documento $documento)
    {
        try {
            DB::beginTransaction();

            $crianca = $documento->crianca;

            // Exclui o arquivo
            if (Storage::disk('public')->exists($documento->arquivo)) {
                Storage::disk('public')->delete($documento->arquivo);
            }

            // Exclui o registro
            $documento->delete();

            DB::commit();

            return redirect()->route('criancas.show', $crianca)
                ->with('success', 'Documento excluído com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao excluir documento: ' . $e->getMessage());

            return back()->with('error', 'Erro ao excluir documento: ' . $e->getMessage());
        }
    }
}
