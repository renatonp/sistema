<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagamentoController;

Route::get('/listarDadosPagamento', [PagamentoController::class, 'listarDadosPagamento'])->name('listarDadosPagamento');
Route::post('/efetuarCobranca', [PagamentoController::class, 'efetuarCobranca'])->name('efetuarCobranca');
