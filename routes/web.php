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
Route::prefix('produtos')->group( function(){
    Route::middleware([Authentication::class])->group(function(){
        Route::get('/', [ProductsController::class, 'mostrarProdutos'])->name('produtos');
        Route::get('/adicionar/{error?}', [ProductsController::class, 'adicionarProdutos'])->name('produtos.adicionar');
        Route::post('/adicionar', [ProductsController::class, 'processoAdicionarProdutos'])->name('produtos.adicionar.processar');
        Route::delete('/deletar/{id?}', [ProductsController::class, 'deletarProduto'])->name('produtos.deletar');
        Route::get('/editar/{id}', [ProductsController::class, 'editarProduto'])->name('produtos.editar');
        Route::put('/editar/processo/{id}', [ProductsController::class, 'processoEditarProduto'])->name('produtos.editar.processar');
        Route::get('/pesquisar', [ProductsController::class, 'pesquisarProduto'])->name('produtos.pesquisar');
    });
});
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
