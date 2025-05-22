<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    // Define o nome da tabela no banco de dados
    protected $table = 'turmas';

    // Define as colunas que podem ser preenchidas em massa
    protected $fillable = [
        'nome',
        'descricao',
        'idade_minima',
        'idade_maxima',
        'capacidade',
        'professor_id',
        'sala',
        'ano_letivo'
    ];

    /**
     * Relacionamento com as crianças da turma
     */
    public function criancas()
    {
        return $this->hasMany(Crianca::class);
    }

    /**
     * Retorna o número de crianças na turma
     */
    public function getNumCriancasAttribute()
    {
        return $this->criancas()->whereHas('matriculas', function ($query) {
            $query->where('status', 'Ativa');
        })->count();
    }

    /**
     * Retorna a porcentagem de ocupação da turma
     */
    public function getOcupacaoAttribute()
    {
        if (!$this->capacidade) {
            return 0;
        }

        return min(100, round(($this->num_criancas / $this->capacidade) * 100));
    }

    /**
     * Retorna a classe CSS para a barra de ocupação
     */
    public function getOcupacaoClassAttribute()
    {
        $ocupacao = $this->ocupacao;

        if ($ocupacao < 50) {
            return 'bg-green-500';
        } elseif ($ocupacao < 80) {
            return 'bg-yellow-500';
        } else {
            return 'bg-red-500';
        }
    }
}
