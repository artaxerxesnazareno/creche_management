<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Presenca extends Model
{
    use HasFactory;

    protected $table = 'presencas';

    protected $fillable = [
        'crianca_id',
        'data',
        'hora_entrada',
        'hora_saida',
        'responsavel_entrada_id',
        'responsavel_saida_id',
        'observacoes',
    ];

    protected $casts = [
        'data' => 'date',
    ];

    /**
     * Relação com a criança
     */
    public function crianca()
    {
        return $this->belongsTo(Crianca::class);
    }

    /**
     * Relação com o responsável pela entrada
     */
    public function responsavelEntrada()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_entrada_id');
    }

    /**
     * Relação com o responsável pela saída
     */
    public function responsavelSaida()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_saida_id');
    }

    /**
     * Formata a data para exibição
     */
    public function getDataFormatadaAttribute()
    {
        return $this->data->format('d/m/Y');
    }

    /**
     * Formata a hora para exibição
     */
    public function getHoraEntradaFormatadaAttribute()
    {
        return $this->hora_entrada ? Carbon::createFromFormat('H:i:s', $this->hora_entrada)->format('H:i') : '';
    }

    /**
     * Formata a hora para exibição
     */
    public function getHoraSaidaFormatadaAttribute()
    {
        return $this->hora_saida ? Carbon::createFromFormat('H:i:s', $this->hora_saida)->format('H:i') : '';
    }
}
