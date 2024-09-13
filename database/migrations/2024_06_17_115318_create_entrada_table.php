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
        Schema::create('entradas', function (Blueprint $table) {
            $table->uuid('id_entrada')->primary();
            $table->uuid('fk_id_produto');
            $table->double('quantidade');
            $table->uuid('fk_id_fornecedor');
            $table->foreign('fk_id_produto')->references('id_produto')->on('produtos');
            $table->foreign('fk_id_fornecedor')->references('id_fornecedor')->on('fornecedores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrada');
    }
};
