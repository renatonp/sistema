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
        Schema::create('atendimento_produtos', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->foreignId('atendimentoId')->constrained( table: 'atendimentos', indexName: 'atendimento_atendimentos_id' );
            $table->foreignId('produtoId')->constrained( table: 'produtos', indexName: 'atendimento_produtos_id' );
            $table->integer('quantidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('atendimento_produtos');
    }
};
