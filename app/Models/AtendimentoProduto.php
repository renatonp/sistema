<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtendimentoProduto extends Model
{
	public function Atendimento(){
		return $this->belongsTo('App\Models\Atendimento','atendimentoId','id');
	}

	public function Produto(){
		return $this->belongsTo('App\Models\Produto','produtoId','id');
	}

    public static function efetuarPagamento($ids,$qtds){
        $atendimento = Atendimento::select('id')->orderBy('id','desc')->take(1)->get();
        foreach($atendimento as $atend){
          $atendimentoId = $atend->id;
            for($i=0;$i<count($ids);$i++){
                $atendimento = new AtendimentoProduto();
                $atendimento->atendimentoId = $atendimentoId;
                $atendimento->produtoId = $ids[$i];
                $atendimento->quantidade = $qtds[$i];
                $atendimento->save();
                $produto = Produto::find($ids[$i]);
                $produto->estoque = $produto->estoque-$qtds[$i];
                $produto->save();
            }
        }
    }

    public static function edicaoAtendimento($dados){
        return AtendimentoProduto::where('atendimentoId','=',$dados->id)->get();
    }

    public static function editarAtendimento($dados){
        $atendimento_produto = AtendimentoProduto::select('id')->where('atendimentoId','=',$dados['id'])->where('produtoId','=',$dados['produto_id'])->get();
        foreach($atendimento_produto as $ap){
            $ap_save = AtendimentoProduto::find($ap->id);
            $ap_save->quantidade = $dados['quantidade'];
            $ap_save->save();
            $produto = Produto::find($dados['produto_id']);
            if($dados['operacao'] == "adicionar"){
                $produto->estoque = $produto->estoque-1;
            }
            if($dados['operacao'] == "remover"){
                $produto->estoque = $produto->estoque+1;
            }
            $produto->save();
        }
        exit;
    }

    public static function removerAtendimento($dados){
        $atendimento_produto = AtendimentoProduto::select('id')->where('atendimentoId','=',$dados->id)->get();
        foreach($atendimento_produto as $ap){
            $ap_delete = AtendimentoProduto::find($ap->id);
            $ap_delete->delete();
        }
    }
}