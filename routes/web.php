<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtendimentoController;
use App\Http\Controllers\ProdutoController;

Route::get('/listagemAtendimentos', [AtendimentoController::class, 'listagemAtendimento'])->name('listagemAtendimento');
Route::get('/novoAtendimento', [AtendimentoController::class, 'novoAtendimento'])->name('novoAtendimento');
Route::post('/efetuarPagamento', [AtendimentoController::class, 'efetuarPagamento'])->name('efetuarPagamento');
Route::get('/edicaoAtendimento/{id}', [AtendimentoController::class, 'edicaoAtendimento'])->name('edicaoAtendimento');
Route::post('/editarAtendimento', [AtendimentoController::class, 'editarAtendimento'])->name('editarAtendimento');
Route::post('/removerAtendimento', [AtendimentoController::class, 'removerAtendimento'])->name('removerAtendimento');

Route::get('/listagemProdutos', [ProdutoController::class, 'listagemProdutos'])->name('listagemProdutos');
Route::get('/cadastroProduto', [ProdutoController::class, 'cadastroProduto'])->name('cadastroProduto');
Route::post('/cadastrarProduto', [ProdutoController::class, 'cadastrarProduto'])->name('cadastrarProduto');
Route::get('/edicaoProduto/{id}', [ProdutoController::class, 'edicaoProduto'])->name('edicaoProduto');
Route::post('/editarProduto', [ProdutoController::class, 'editarProduto'])->name('editarProduto');
Route::post('/removerProduto', [ProdutoController::class, 'removerProduto'])->name('removerProduto');