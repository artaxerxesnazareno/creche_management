<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'matriculas';

    protected $fillable = [
        'crianca_id',
        'turma_id',
        'data_inicio',
        'data_fim',
        'periodo',
        'valor_mensalidade',
        'desconto',
        'taxa_matricula',
        'dia_vencimento',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'valor_mensalidade' => 'decimal:2',
        'desconto' => 'decimal:2',
        'taxa_matricula' => 'decimal:2',
    ];

    protected $appends = [
        'valor_com_desconto',
        'data_inicio_formatada',
        'data_fim_formatada',
        'codigo'
    ];

    /**
     * Relacionamento com a criança
     */
    public function crianca()
    {
        return $this->belongsTo(Crianca::class);
    }

    /**
     * Relacionamento com a turma
     */
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    /**
     * Calcula o valor da mensalidade com desconto
     */
    public function getValorComDescontoAttribute()
    {
        $desconto = ($this->valor_mensalidade * $this->desconto) / 100;
        return $this->valor_mensalidade - $desconto;
    }

    /**
     * Formata a data de início
     */
    public function getDataInicioFormatadaAttribute()
    {
        return $this->data_inicio ? $this->data_inicio->format('d/m/Y') : null;
    }

    /**
     * Formata a data de fim
     */
    public function getDataFimFormatadaAttribute()
    {
        return $this->data_fim ? $this->data_fim->format('d/m/Y') : null;
    }

    /**
     * Gera um código de matrícula no formato MAT-AAAA-XXXXX
     */
    public function getCodigoAttribute()
    {
        $ano = $this->created_at ? $this->created_at->format('Y') : date('Y');
        return 'MAT-' . $ano . '-' . str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }
}
