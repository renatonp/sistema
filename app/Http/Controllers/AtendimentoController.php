<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Models\Atendimento;
use App\Models\AtendimentoProduto;
use App\Models\Produto;
use App\Models\TipoPagamento;

class AtendimentoController extends Controller
{
    public function listagemAtendimento(){
        $atendimentos = Atendimento::listagemAtendimento();
        return View::make('listagem_atendimentos',compact('atendimentos'));
    }

    public function novoAtendimento(){
        $produtos = Produto::listagemProdutos();
        $tipo_pagamento = TipoPagamento::orderBy('id','desc')->get();
        return View::make('novo_atendimento',compact('produtos','tipo_pagamento'));
    }

    public function efetuarPagamento(Request $request){
        $produtos_adicionados=explode(';',$request['produtos_adicionados']);
        $produtos_adicionados_ok=array();
        $i=0;
        foreach($produtos_adicionados as $pa){
            if($pa!=",undefined" && $pa!=""){
                $produtos_adicionados_ok[$i] = $pa;
                $i++;
            }
        }
        $j=0;
        foreach($produtos_adicionados_ok as $paok){
            $vet_paok = explode(',',$paok);
            if($vet_paok[1] > 0){
                $ids_produtos_adicionados[$j] = $vet_paok[0];
                $qtds_produtos_adicionados[$j] = $vet_paok[1];
                $j++;
            }
        }
        Atendimento::efetuarPagamento($request);
        AtendimentoProduto::efetuarPagamento($ids_produtos_adicionados,$qtds_produtos_adicionados);
        return redirect()->route('novoAtendimento');
    }

    public function edicaoAtendimento(Request $request){
        $dados_atendimento_produto = AtendimentoProduto::edicaoAtendimento($request);
        $dados_atendimento = Atendimento::edicaoAtendimento($request);
        $tipos_pagamento = TipoPagamento::listagem();
        return View::make('edicao_atendimento',compact('dados_atendimento','dados_atendimento_produto','tipos_pagamento'));
    }

    public function editarAtendimento(Request $request){
        Atendimento::editarAtendimento($request);
        AtendimentoProduto::editarAtendimento($request);
    }

    public function removerAtendimento(Request $request){
        AtendimentoProduto::removerAtendimento($request);
        Atendimento::removerAtendimento($request);
        $atendimentos = Atendimento::listagemAtendimento();
        return View::make('listagem_atendimentos',compact('atendimentos'));
    }
}