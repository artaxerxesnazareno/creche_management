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
        Schema::table('responsaveis', function (Blueprint $table) {
            // Verificar se as colunas existem antes de tentar removê-las
            if (Schema::hasColumn('responsaveis', 'cpf')) {
                $table->dropColumn('cpf');
            }

            if (Schema::hasColumn('responsaveis', 'rg')) {
                $table->dropColumn('rg');
            }

            // Garantir que a coluna BI exista
            if (!Schema::hasColumn('responsaveis', 'bi')) {
                $table->string('bi', 20)->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('responsaveis', function (Blueprint $table) {
            // Não restauramos CPF e RG no rollback pois estamos migrando para o contexto angolano
        });
    }
};
