<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\Authentication;
use App\Http\Middleware\AuthenticationLogin;

Route::get('/', [IndexController::class, 'index'])->name('index')->middleware(Authentication::class);

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware(AuthenticationLogin::class);
Route::get('/logout', function(){
    session_start();
    session_destroy();
    session_abort();
    return redirect()->route('login');
})->name('logout');
Route::post('/autenticar', [LoginController::class, 'autenticar'])->name('autenticar');
