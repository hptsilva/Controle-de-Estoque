<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController
{
    public function mostrarProdutos(){

        return view('produtos.products');

    }

    public function adicionarProduto(){

        echo("Adicionar produto");

    }
}
