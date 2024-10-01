<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function listagemProdutos(){
        $produtos = Produto::listagemProdutos();
        return View::make('listagem_Produtos',compact('produtos'));
    }

    public function cadastroProduto(){
        return View::make('cadastro_produto');
    }

    public function cadastrarProduto(Request $request){
//        dd($request);
//        $nome_foto = explode('\\',$request->foto);
//        Storage::disk('local')->put($nome_foto[2]);
        Produto::cadastrarProduto($request);
    }

    public function edicaoProduto(Request $request){
        $dados_produto = Produto::edicaoProduto($request);
        return View::make('edicao_produto',compact('dados_produto'));
    }

    public function editarProduto(Request $request){
        Produto::editarProduto($request);
    }

    public function removerProduto(Request $request){
        Produto::removerProduto($request);
        $produtos = Produto::listagemProdutos();
        return View::make('listagem_produtos',compact('produtos'));
    }
}
