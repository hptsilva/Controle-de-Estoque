<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Middleware\Authentication;
use App\Http\Middleware\AuthenticationLogin;

Route::get('/', [IndexController::class, 'index'])->name('index')->middleware(Authentication::class);
Route::get('/produtos', [ProductsController::class, 'mostrarProdutos'])->middleware(Authentication::class)->name('produtos');
Route::get('/produtos/adicionar', [ProductsController::class, 'adicionarProduto'])->middleware(Authentication::class)->name('produtos.adicionar');
Route::get('/fornecedores', [SuppliersController::class, 'mostrarFornecedores'])->middleware(Authentication::class)->name('fornecedores');
Route::get('/configuracoes', [SettingsController::class, 'configuracoes'])->middleware(Authentication::class)->name('configuracoes');

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware(AuthenticationLogin::class);
Route::post('/autenticar', [LoginController::class, 'autenticar'])->name('autenticar');
Route::get('/logout', function(){
    session_start();
    session_destroy();
    session_abort();
    return redirect()->route('login');
})->name('logout');
