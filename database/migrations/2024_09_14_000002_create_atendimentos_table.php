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
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->foreignId('tipoPagamentoId')->constrained( table: 'tipo_pagamentos', indexName: 'atendimento_tipo_pagamentos' );
            $table->string('descricao',50);
            $table->date('data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('atendimentos');
    }
};
