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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->uuid('id_fornecedor')->primary();
            $table->string('nome_fornecedor', length: 50);
            $table->string('cnpj', length: 18);
            $table->string('endereco', length: 500);
            $table->string('telefone', length: 13);
            $table->string('email', length: 100);
            $table->string('contato', length: 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
