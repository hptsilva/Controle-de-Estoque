<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Middleware\AutenticacaoMiddleware;
use App\Http\Controllers\EntradaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::post('/autenticacao', [IndexController::class, 'autenticacao'])->name('autenticacao');
Route::get('/sair', [IndexController::class, 'sair'])->name('sair');
Route::get('/produtos', [ProdutosController::class, 'mostrarProdutos'])->name('produtos')->middleware(AutenticacaoMiddleware::class);
Route::get('/produtos/adicionar/{error?}', [ProdutosController::class, 'adicionarProdutos'])->name('produtos.adicionar')->middleware(AutenticacaoMiddleware::class);
Route::post('produtos/adicionar', [ProdutosController::class, 'processarProdutos'])->name('produtos.processar')->middleware(AutenticacaoMiddleware::class);
Route::get('/fornecedores', [FornecedoresController::class, 'mostrarFornecedores'])->name('fornecedores')->middleware(AutenticacaoMiddleware::class);
Route::get('/fornecedores/adicionar/{error?}', [FornecedoresController::class, 'adicionarFornecedores'])->name('fornecedores.adicionar')->middleware(AutenticacaoMiddleware::class);
Route::post('/fornecedores/adicionar', [FornecedoresController::class, 'processarFornecedores'])->name('fornecedores.processar')->middleware(AutenticacaoMiddleware::class);
Route::get('/entrada/{error?}', [EntradaController::class, 'entrada'])->name('entrada')->middleware(AutenticacaoMiddleware::class);
Route::post('/entrada', [EntradaController::class, 'entradaProcessar'])->name('entrada.processar')->middleware(AutenticacaoMiddleware::class);
Route::get('/entrada/dados/produto', [EntradaController::class, 'dadosProduto'])->name('entrada.dados')->middleware(AutenticacaoMiddleware::class);
Route::post('/entrada/produto/enviar', [EntradaController::class, 'enviarEntrada'])->name('entrada.enviar')->middleware(AutenticacaoMiddleware::class);
Route::delete('/entrada/{id_produto}/{id_fornecedor}', [EntradaController::class, 'excluirEntrada'])->name("entrada.excluir");