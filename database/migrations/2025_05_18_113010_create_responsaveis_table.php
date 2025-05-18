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
        Schema::create('responsaveis', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20);
            $table->string('email')->nullable();
            $table->string('bi', 20)->nullable();
            $table->string('endereco')->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('municipio', 100)->nullable();
            $table->string('provincia', 100)->nullable();
            $table->string('profissao')->nullable();
            $table->string('local_trabalho')->nullable();
            $table->string('parentesco', 50);
            $table->boolean('autorizado_buscar')->default(true);
            $table->boolean('mora_crianca')->default(false);
            $table->boolean('contato_emergencia')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsaveis');
    }
};
