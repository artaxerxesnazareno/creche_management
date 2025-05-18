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
}
