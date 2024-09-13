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
        Schema::create('produtos', function (Blueprint $table) {
            $table->uuid('id_produto')->primary();
            $table->string('nome_produto', length: 50);
            $table->enum('categoria', ['alimentos', 'eletrônicos', 'vestuários']);
            $table->string('marca', length: 50);
            $table->enum('unidade', ['unitario', 'tonelada', 'kilograma', 'grama', 'litros', 'mililitros']);
            $table->double('preco_custo');
            $table->double('preco_venda');
            $table->double('estoque_atual');
            $table->double('estoque_minimo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
