<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atendimento extends Model
{
  public static function listagemAtendimento(){
        $atendimentos = Atendimento::get();
	    return $atendimentos;
    }

    public static function listagemAtendimentoPedidos($id){
        $atendimentos = Atendimento::where('id','=',$id)->get();
        return $atendimentos;
    }

    public static function efetuarPagamento($dados){
        $atendimento = new Atendimento();
        $atendimento->tipoPagamentoId = $dados['tipo_pagamento'];
        $atendimento->descricao = "Novo atendimento do dia ".date("d/m/Y");
        $atendimento->valor = $dados['valor'];
        $atendimento->data = date('Y-m-d');
        $atendimento->save();
    }

    public static function edicaoAtendimento($dados){
        return Atendimento::where('id','=',$dados->id)->get();
    }
    
    public static function editarAtendimento($dados){
  		$atendimento = Atendimento::find($dados->id);
        $atendimento->tipoPagamentoId = $dados['tipo_pagamento'];
        $atendimento->valor = $dados['valor'];
	  	$atendimento->save();
    }

    public static function removerAtendimento($dados){
        $atendimento = Atendimento::find($dados->id);
        $atendimento->delete();
    }
}