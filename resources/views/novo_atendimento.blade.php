<html>
<head>
<title>SISTEMA DE CONTROLE EMPRESARIAL</title>
<script type="text/javascript" src="<?php echo asset('js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/datatables.min.js')?>"></script>
<link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css')?>" type="text/css">
<link rel="stylesheet" href="<?php echo asset('css/datatables.min.css')?>" type="text/css">

<script language="javascript">
function listagemAtendimentos(){
    window.location.replace("{{ Route('listagemAtendimento') }}")
}

function adicionarProduto(id,valor){
	var id_achado=0;
	var quantidade = $('#quantidade'+id).val();
	quantidade++;
	$('#quantidade'+id).val(quantidade);
	valor_total=parseFloat($('#valor_total').val())+parseFloat(valor);
	$('#valor_total').val(valor_total.toFixed(2));
	$('#valor_total_span').html("R$ "+valor_total.toFixed(2));

	produtos_adicionados_bckp="";
	dados = produtos_adicionados.split(';');
	for(var i=0;i < dados.length; i++){
		dados2 = dados[i].split(',');
		if(dados2[0] == id){
			dados2[1] = quantidade;
			produtos_adicionados_bckp+=dados2[0]+','+dados2[1]+';';
			id_achado=1;
		}
		else{
			produtos_adicionados_bckp+=dados2[0]+','+dados2[1]+';';
			produtos_adicionados=produtos_adicionados_bckp;
		}
	}
	if(id_achado==0){
		produtos_adicionados+=id+','+quantidade+';';
		$('#produtos_adicionados').val(produtos_adicionados);
	}
	else{
		produtos_adicionados_bckp2="";
		dados = produtos_adicionados.split(';');
		for(var i=0;i < dados.length; i++){
			dados2 = dados[i].split(',');
			if(dados2[0] == 'undefined'){
				dados2[0]='';
				produtos_adicionados_bckp2+=dados2[0]+',';
			}
			if(dados2[1] == 'undefined'){
				dados2[1]='';
				produtos_adicionados_bckp2+=dados2[1]+';';
			}
		}
		$('#produtos_adicionados').val(produtos_adicionados_bckp);
	}
}

function removerProduto(id,valor){
	var quantidade = $('#quantidade'+id).val();
	if(quantidade > 0){
		quantidade--;
		$('#quantidade'+id).val(quantidade);
		valor_total=parseFloat($('#valor_total').val())-parseFloat(valor);
		$('#valor_total').val(valor_total.toFixed(2));
		$('#valor_total_span').html("R$ "+valor_total.toFixed(2));

		produtos_adicionados_bckp="";

		dados = produtos_adicionados.split(';');
		for(var i=0;i < dados.length; i++){
			dados2 = dados[i].split(',');
			if(dados2[0] == id){
				dados2[1] = quantidade;
				produtos_adicionados_bckp+=dados2[0]+','+dados2[1]+';';
				id_achado=1;
			}
			else{
				produtos_adicionados_bckp+=dados2[0]+','+dados2[1]+';';
				produtos_adicionados=produtos_adicionados_bckp;
			}
		}
		if(id_achado==0){
			produtos_adicionados+=id+','+quantidade+';';
			$('#produtos_adicionados').val(produtos_adicionados);
		}
		else{
			produtos_adicionados_bckp2="";
			dados = produtos_adicionados.split(';');
			for(var i=0;i < dados.length; i++){
				dados2 = dados[i].split(',');
				if(dados2[0] == 'undefined'){
					dados2[0]='';
					produtos_adicionados_bckp2+=dados2[0]+',';
				}
				if(dados2[1] == 'undefined'){
					dados2[1]='';
					produtos_adicionados_bckp2+=dados2[1]+';';
				}
			}
			$('#produtos_adicionados').val(produtos_adicionados_bckp);
		}
	}
}

$(document).ready(function(){
	valor_total=0;
	produtos_adicionados="";
	$('#botao_pagamento').click(function(){
		$.post("{{ Route('efetuarPagamento') }}",{ 
			'_token':'{{ csrf_token() }}',
			'id':$('#produto_id').val(),
			'pedido':$('#produto_nome').val(),
			'valor':$('#produto_valor').val(),
			'data':$('#data').val(),
			'tipo_pagamento':$('#tipo_pagamento').val(),
			'valor':$('#valor_total').val(),
			'produtos_adicionados':$('#produtos_adicionados').val()
		 },function(data){
			console.log(data);
			document.forms[0].reset();
			$('#msgRetorno').html('Atendimento realizado com sucesso.');
			$('#msgRetorno').attr('display','block');
			$('#msgRetorno').fadeIn('slow');
			setTimeout("$('#msgRetorno').fadeOut('slow')",3750);
			setTimeout("$('#msgRetorno').attr('display','none')",5000);
		});
	});
    $('#listagem_produtos').DataTable();	
});
</script>
</head>
<body>
<form action="{{ Route('efetuarPagamento') }}" method="post">
	@csrf
	<input type="hidden" name="produtos_adicionados" id="produtos_adicionados">
	<div class="container">
		<div class="row alert alert-primary" role="alert"><div class="col-lg-12" align="center">Novo Atendimento</div></div>
        <div class="col-lg-12" align="right"><input type="button" class="btn btn-success" value="Listagem de Atendimentos" onclick="listagemAtendimentos()"></div><br />
		<div class="col-lg-12" align="center">
			<input type="text" name="data" id="data"  value="<?= date('d/m/Y') ?>" readonly="readonly" size="7">
		</div>
		<br />
        <table id="listagem_produtos" class="table table-bordered table-striped">
        	<thead>
    			<tr>
					<th> Foto </th>
					<th> Produto </th>
                	<th> Valor </th>
                	<th> Quantidade </th>
                	<th>Ações</th>
            	</tr>
            </thead>
            <tbody>
            	@foreach($produtos as $produto)
            		<tr id="{{ $produto->id }}"><input type="hidden" name="produto_id" id="produto_id" value="{{ $produto->id }}">
						<td> {{ $produto->foto }}</td>
						<td>{{ $produto->nome }}<input type="hidden" name="produto_nome" id="produto_nome" value="{{ $produto->nome }}"></td>
            			<td> R$ {{ number_format($produto->valor,2,',','.') }}<input type="hidden" name="produto_valor" id="produto_valor" value="{{ $produto->valor }}"></td>
            			<td> <input type="text" size="1" name="quantidade" id="quantidade{{ $produto->id }}" value=0 readonly="readonly"></td>
            			<td>
                            <input type="button" class="btn btn-success" value="Adicionar" onclick="adicionarProduto(<?= $produto->id ?>,<?= $produto->valor ?>)">
                            &nbsp;&nbsp;&nbsp;
                            <input type="button" class="btn btn-danger" value="Remover" onclick="removerProduto(<?= $produto->id ?>,<?= $produto->valor ?>)">
                        </td>
            		</tr>
            	@endforeach
				<tr><td align="center" colspan="5"><input type="hidden" name="valor_total" id="valor_total" value="0"><strong><font color="#009933">VALOR TOTAL: <span id="valor_total_span"></span></font></strong></td></tr>
            </tbody>
    	</table>
		<br>
		<div class="col-lg-12" align="center">
			<strong>Tipo de Pagamento:</strong><br>
			<select name="tipo_pagamento" id="tipo_pagamento">
				@foreach($tipo_pagamento as $pagamentos)
					<option value="{{ $pagamentos->id }}">{{ $pagamentos->pagamento }}</option>
				@endforeach
			</select>
		</div>
		<br>
		<div class="col-lg-12" align="center">
			<input type="button" class="btn btn-primary" id="botao_pagamento" value="Efetuar Pagamento">
		</div>
		<br>
		<div align="center" class="alert alert-success col-lg-12" role="alert" id="msgRetorno" style="display: none"></div>
	</div>
</form>
</body>
</html>