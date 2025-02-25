<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuppliersController
{
    public function mostrarFornecedores(){

        return view('fornecedores.suppliers');

    }
}
