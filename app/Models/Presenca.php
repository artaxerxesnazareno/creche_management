<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'observacoes'
    ];

    protected $casts = [
        'data' => 'date',
        'hora_entrada' => 'datetime',
        'hora_saida' => 'datetime',
    ];

    protected $appends = [
        'data_formatada'
    ];

    // Accessors
    public function getDataFormatadaAttribute()
    {
        return $this->data ? $this->data->format('d/m/Y') : null;
    }

    public function getHoraEntradaFormatadaAttribute()
    {
        return $this->hora_entrada ? $this->hora_entrada->format('H:i') : null;
    }

    public function getHoraSaidaFormatadaAttribute()
    {
        return $this->hora_saida ? $this->hora_saida->format('H:i') : null;
    }

    // Relacionamentos
    public function crianca()
    {
        return $this->belongsTo(Crianca::class);
    }

    public function responsavelEntrada()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_entrada_id');
    }

    public function responsavelSaida()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_saida_id');
    }
}
