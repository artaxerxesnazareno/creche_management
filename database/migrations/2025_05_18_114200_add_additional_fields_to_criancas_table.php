<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('criancas', function (Blueprint $table) {
            // Campos de endereço
            $table->string('endereco')->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('provincia', 100)->nullable();

            // Campos de saúde adicionais
            $table->string('tipo_sanguineo', 5)->nullable();
            $table->string('convenio_medico', 100)->nullable();

            // Campos de responsáveis
            $table->unsignedBigInteger('responsavel_principal_id')->nullable();
            $table->unsignedBigInteger('responsavel_secundario_id')->nullable();
            $table->text('autorizados')->nullable();

            // Campos de documentos
            $table->string('certidao')->nullable();
            $table->string('carteira_vacinacao')->nullable();
            $table->string('laudo_medico')->nullable();

            // Chaves estrangeiras
            $table->foreign('responsavel_principal_id')->references('id')->on('responsaveis')->onDelete('set null');
            $table->foreign('responsavel_secundario_id')->references('id')->on('responsaveis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('criancas', function (Blueprint $table) {
            // Remover chaves estrangeiras
            $table->dropForeign(['responsavel_principal_id']);
            $table->dropForeign(['responsavel_secundario_id']);

            // Remover colunas
            $table->dropColumn([
                'endereco', 'bairro', 'municipio', 'provincia',
                'tipo_sanguineo', 'convenio_medico',
                'responsavel_principal_id', 'responsavel_secundario_id', 'autorizados',
                'certidao', 'carteira_vacinacao', 'laudo_medico'
            ]);
        });
    }
};
