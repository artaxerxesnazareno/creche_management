<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'documentos';

    protected $fillable = [
        'titulo',
        'tipo',
        'arquivo',
        'crianca_id',
        'observacoes',
    ];

    /**
     * Relacionamento com a criança
     */
    public function crianca()
    {
        return $this->belongsTo(Crianca::class);
    }

    /**
     * Retorna a data de criação formatada
     */
    public function getCreatedAtFormatadaAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}
