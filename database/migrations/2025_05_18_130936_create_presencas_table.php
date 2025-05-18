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
        Schema::create('presencas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crianca_id')->constrained()->onDelete('cascade');
            $table->date('data');
            $table->time('hora_entrada')->nullable();
            $table->time('hora_saida')->nullable();
            $table->foreignId('responsavel_entrada_id')->nullable()->constrained('responsaveis');
            $table->foreignId('responsavel_saida_id')->nullable()->constrained('responsaveis');
            $table->text('observacoes')->nullable();
            $table->timestamps();

            // Índice composto para garantir apenas uma entrada por criança por dia
            $table->unique(['crianca_id', 'data']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presencas');
    }
};
