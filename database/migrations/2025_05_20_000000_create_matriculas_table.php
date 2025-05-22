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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('crianca_id');
            $table->unsignedBigInteger('turma_id');
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->string('periodo'); // Integral, Manhã, Tarde
            $table->decimal('valor_mensalidade', 10, 2);
            $table->decimal('desconto', 5, 2)->default(0);
            $table->decimal('taxa_matricula', 10, 2)->default(0);
            $table->integer('dia_vencimento');
            $table->string('status'); // Pendente, Ativa, Cancelada, Concluída
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('crianca_id')->references('id')->on('criancas')->onDelete('cascade');
            $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
