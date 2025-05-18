<?php

namespace App\Livewire;

use App\Models\Responsavel;
use Livewire\Component;

class BuscaResponsavel extends Component
{
    public $bi;
    public $responsavel;
    public $showForm = false;
    public $nome;
    public $telefone;
    public $email;
    public $parentesco;
    public $endereco;
    public $bairro;
    public $municipio;
    public $provincia;

    public function buscarPorBi()
    {
        $this->responsavel = Responsavel::where('bi', $this->bi)->first();

        if ($this->responsavel) {
            $this->nome = $this->responsavel->nome;
            $this->telefone = $this->responsavel->telefone;
            $this->email = $this->responsavel->email;
            $this->parentesco = $this->responsavel->parentesco;
            $this->endereco = $this->responsavel->endereco;
            $this->bairro = $this->responsavel->bairro;
            $this->municipio = $this->responsavel->municipio;
            $this->provincia = $this->responsavel->provincia;
            $this->showForm = false;
        } else {
            $this->showForm = true;
            $this->reset(['nome', 'telefone', 'email', 'parentesco', 'endereco', 'bairro', 'municipio', 'provincia']);
        }
    }

    public function salvarResponsavel()
    {
        $this->validate([
            'nome' => 'required|string|max:255',
            'bi' => 'required|string|unique:responsaveis,bi',
            'telefone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'parentesco' => 'required|string|max:50',
            'endereco' => 'required|string|max:255',
            'bairro' => 'required|string|max:100',
            'municipio' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
        ]);

        $this->responsavel = Responsavel::create([
            'nome' => $this->nome,
            'bi' => $this->bi,
            'telefone' => $this->telefone,
            'email' => $this->email,
            'parentesco' => $this->parentesco,
            'endereco' => $this->endereco,
            'bairro' => $this->bairro,
            'municipio' => $this->municipio,
            'provincia' => $this->provincia,
        ]);

        $this->showForm = false;
        $this->dispatch('responsavelSelecionado', $this->responsavel->id);
    }

    public function render()
    {
        return view('livewire.busca-responsavel');
    }
}
