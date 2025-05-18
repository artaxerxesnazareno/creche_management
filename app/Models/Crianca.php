<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crianca extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'criancas';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'genero',
        'foto',
        'alergias',
        'medicacoes',
        'necessidades_especiais',
        'restricoes_alimentares',
        'turma_id',
        'periodo',
        'observacoes',
        'endereco',
        'bairro',
        'municipio',
        'provincia',
        'tipo_sanguineo',
        'convenio_medico',
        'responsavel_principal_id',
        'responsavel_secundario_id',
        'autorizados',
        'certidao',
        'carteira_vacinacao',
        'laudo_medico'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    protected $appends = [
        'idade_formatada',
        'idade_em_meses'
    ];

    // Accessors
    public function getDataNascimentoFormatadaAttribute()
    {
        return $this->data_nascimento ? $this->data_nascimento->format('d/m/Y') : null;
    }

    /**
     * Retorna a idade em meses para crianças com menos de 1 ano
     *
     * @return int
     */
    public function getIdadeEmMesesAttribute()
    {
        if (!$this->data_nascimento) {
            return 0;
        }

        return (int) $this->data_nascimento->diffInMonths(now());
    }

    /**
     * Retorna a idade formatada de acordo com a idade da criança
     *
     * @return string
     */
    public function getIdadeFormatadaAttribute()
    {
        if (!$this->data_nascimento) {
            return 'Idade não informada';
        }

        $anos = $this->idade;

        if ($anos >= 1) {
            return $anos == 1 ? '1 ano' : $anos . ' anos';
        }

        $meses = $this->idade_em_meses;

        if ($meses == 0) {
            return 'Recém-nascido';
        }

        return $meses == 1 ? '1 mês' : $meses . ' meses';
    }

    // Relacionamentos
    public function responsavelPrincipal()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_principal_id');
    }

    public function responsavelSecundario()
    {
        return $this->belongsTo(Responsavel::class, 'responsavel_secundario_id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    public function presencas()
    {
        return $this->hasMany(Presenca::class)->orderBy('data', 'desc');
    }

    /**
     * Calcula a idade da criança em anos
     *
     * @return int
     */
    public function getIdadeAttribute()
    {
        if (!$this->data_nascimento) {
            return 0;
        }

        // Calcula a diferença em anos e arredonda para baixo
        return (int) $this->data_nascimento->diffInYears(now());
    }
}
