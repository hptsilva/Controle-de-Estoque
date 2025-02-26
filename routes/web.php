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
        Route::get('/adicionar/{error?}', [ProductsController::class, 'adicionarProduto'])->name('produtos.adicionar');
        Route::post('/adicionar', [ProductsController::class, 'processarProdutos'])->name('produtos.adicionar.processar');
        Route::delete('/deletar', [ProductsController::class, 'deletarProduto'])->name('produtos.deletar');
        Route::put('/editar', [ProductsController::class, 'editarProduto'])->name('produtos.editar');
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
