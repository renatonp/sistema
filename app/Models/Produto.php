<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
	public static function listagemProdutos(){
		$produtos = Produto::get();
		return $produtos;
	}

    public static function cadastrarProduto($dados){
        $nome_foto = explode('\\',$dados->foto);
        $produto = new Produto();
        $produto->nome = $dados->nome;
        $produto->valor =  number_format($dados->valor,2,'.',',');
        $produto->estoque = $dados->estoque;
        $produto->foto = $nome_foto[2];
        $produto->save();
    }

    public static function edicaoProduto($dados){
		return Produto::find($dados->id);
    }

    public static function editarProduto($dados){
        $nome_foto = explode('\\',$dados->foto);
        $produto = Produto::find($dados['id']);
        $produto->nome = $dados->nome;
        $produto->valor = $dados->valor;
        $produto->estoque = $dados->estoque;
        if(isset($nome_foto[2])){
            $produto->foto = $nome_foto[2];
        }
        $produto->save();
  }

  public static function removerProduto($dados){
		$produto = Produto::find($dados->id);
		$produto->delete();
  }
}
