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
            $table->string('tipo'); // entrada, saida, falta
            $table->time('hora')->nullable();
            $table->string('responsavel')->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();

            // Índices para melhorar a performance
            $table->index(['crianca_id', 'data']);
            $table->index('data');
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
