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
        Schema::create('criancas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('data_nascimento');
            $table->string('genero');
            $table->string('foto')->nullable();
            $table->text('alergias')->nullable();
            $table->text('medicacoes')->nullable();
            $table->text('necessidades_especiais')->nullable();
            $table->text('restricoes_alimentares')->nullable();
            $table->unsignedBigInteger('turma_id')->nullable();
            $table->string('periodo')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criancas');
    }
};
