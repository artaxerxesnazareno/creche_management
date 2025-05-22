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
        'tipo',
        'hora',
        'observacao',
        'responsavel',
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
     * Formata a data para exibição
     */
    public function getDataFormatadaAttribute()
    {
        return $this->data->format('d/m/Y');
    }

    /**
     * Formata a hora para exibição
     */
    public function getHoraFormatadaAttribute()
    {
        return $this->hora ? Carbon::createFromFormat('H:i:s', $this->hora)->format('H:i') : '';
    }

    /**
     * Retorna o status da presença
     */
    public function getStatusAttribute()
    {
        switch ($this->tipo) {
            case 'entrada':
                return 'Presente';
            case 'saida':
                return 'Saída';
            case 'falta':
                return 'Ausente';
            default:
                return 'Desconhecido';
        }
    }

    /**
     * Retorna a classe CSS para o status
     */
    public function getStatusClassAttribute()
    {
        switch ($this->tipo) {
            case 'entrada':
                return 'bg-green-100 text-green-800';
            case 'saida':
                return 'bg-blue-100 text-blue-800';
            case 'falta':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }
}
