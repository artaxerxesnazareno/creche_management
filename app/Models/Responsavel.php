<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Responsavel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'responsaveis';

    protected $fillable = [
        'nome',
        'telefone',
        'celular',
        'email',
        'bi',
        'endereco',
        'bairro',
        'municipio',
        'provincia',
        'profissao',
        'local_trabalho',
        'parentesco',
        'autorizado_buscar',
        'mora_crianca',
        'contato_emergencia'
    ];

    protected $casts = [
        'autorizado_buscar' => 'boolean',
        'mora_crianca' => 'boolean',
        'contato_emergencia' => 'boolean',
    ];

    /**
     * Relacionamento com as crianças onde este é o responsável principal
     */
    public function criancasPrincipal()
    {
        return $this->hasMany(Crianca::class, 'responsavel_principal_id');
    }

    /**
     * Relacionamento com as crianças onde este é o responsável secundário
     */
    public function criancasSecundario()
    {
        return $this->hasMany(Crianca::class, 'responsavel_secundario_id');
    }
}
