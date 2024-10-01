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

function adicionarProduto(id,atendimento_id,quantidade){
	$.post("{{ Route('editarAtendimento') }}",{ 
		'_token':'{{ csrf_token() }}',
		'id':atendimento_id,
		'produto_id':id,
		'tipo_pagamento':$('#tipo_pagamento').val(),
		'valor':$('#valor_total').val(),
		'quantidade':quantidade,
		'operacao':'adicionar'
	},function(data){
		window.location.reload();
	});

	var id_achado=0;
	var quantidade = $('#quantidade'+id).val();
	quantidade++;
	$('#quantidade'+id).val(quantidade);

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

function removerProduto(id,atendimento_id,quantidade){
	$.post("{{ Route('editarAtendimento') }}",{ 
		'_token':'{{ csrf_token() }}',
		'id':atendimento_id,
		'produto_id':id,
		'tipo_pagamento':$('#tipo_pagamento').val(),
		'valor':$('#valor_total').val(),
		'quantidade':quantidade,
		'operacao':'remover'
	},function(data){
		window.location.reload();
	});


	var quantidade = $('#quantidade'+id).val();
	if(quantidade > 0){
		quantidade--;
		$('#quantidade'+id).val(quantidade);
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
	produtos_adicionados="";
	$('#botao_pagamento').click(function(){
		$.post("{{ Route('editarAtendimento') }}",{ 
			'_token':'{{ csrf_token() }}',
			'id':$('#atendimento_id').val(),
			'pedido':$('#produto_nome').val(),
			'data':$('#data').val(),
			'tipo_pagamento':$('#tipo_pagamento').val(),
			'valor':$('#valor_total').val(),
			'produtos_adicionados':$('#produtos_adicionados').val()
		 },function(data){
			console.log(data);
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
<form action="{{ Route('editarAtendimento') }}" method="post">
	@csrf
	<input type="hidden" name="produtos_adicionados" id="produtos_adicionados">
	<div class="container">
		<div class="row alert alert-primary" role="alert"><div class="col-lg-12" align="center">Editar Atendimento</div></div>
        <div class="col-lg-12" align="right"><input type="button" class="btn btn-success" value="Listagem de Atendimentos" onclick="listagemAtendimentos()"></div><br />
		<div class="col-lg-12" align="center">
			@foreach($dados_atendimento as $atendimentos)
				<input type="text" name="data" id="data" value="<?= substr($atendimentos->data,8,2) ?>/<?= substr($atendimentos->data,5,2) ?><?= substr($atendimentos->data,0,4) ?>" readonly="readonly" size="7">
			@endforeach
		</div>
		<br />
        <table id="listagem_produtos" class="table table-bordered table-striped">
        	<thead>
    			<tr>
                	<th> Produto </th>
                	<th> Valor </th>
                	<th> Foto </th>
                	<th> Quantidade </th>
                	<th>Ações</th>
            	</tr>
            </thead>
            <tbody>
				<?php $valor_total=0; ?>
				@foreach($dados_atendimento_produto as $atendimento)
					<input type="hidden" name="atendimento_id" id="atendimento_id" value="{{ $atendimento->Atendimento->id }}">
					<tr id="{{ $atendimento->Produto->id }}"><input type="hidden" name="produto_id" id="produto_id" value="{{ $atendimento->Produto->id }}">
            			<td>{{ $atendimento->Produto->nome }}<input type="hidden" name="produto_nome" id="produto_nome" value="{{ $atendimento->Produto->nome }}"></td>
            			<td> R$ {{ number_format($atendimento->Produto->valor,2,',','.') }}<input type="hidden" name="produto_valor" id="produto_valor" value="{{ $atendimento->Produto->valor }}"></td>
            			<td> {{ $atendimento->Produto->foto }}</td>
	            			<td><input type="text" size="1" name="quantidade" id="quantidade{{ $atendimento->Produto->id }}" readonly="readonly" value="{{ $atendimento->quantidade }}"></td>
            			<td>
                            <input type="button" class="btn btn-success" value="Adicionar" onclick="adicionarProduto(<?= $atendimento->Produto->id ?>,<?= $atendimento->Atendimento->id ?>,<?= $atendimento->quantidade+1 ?>)">
                            &nbsp;&nbsp;&nbsp;
                            <input type="button" class="btn btn-danger" value="Remover" onclick="removerProduto(<?= $atendimento->Produto->id ?>,<?= $atendimento->Atendimento->id ?>,<?php if($atendimento->quantidade > 0) { echo $atendimento->quantidade-1; } ?>)">
                        </td>
            		</tr>
					<?php $valor_total+=($atendimento->quantidade*$atendimento->Produto->valor) ?>
            	@endforeach
				<tr><td align="center" colspan="5"><strong><font color="#009933">VALOR TOTAL: <input type="hidden" name="valor_total" id="valor_total" value="<?= $valor_total ?>"><?=number_format($valor_total,2,',','.')?></font></strong></td></tr>
			</tbody>
    	</table>
		<br>
		<div class="col-lg-12" align="center">
			<strong>Tipo de Pagamento:</strong><br>
			@foreach($dados_atendimento as $atendimentos)
				<select name="tipo_pagamento" id="tipo_pagamento">
					@foreach($tipos_pagamento as $pagamentos)
						<option value="{{ $pagamentos->id }}" <?php if($pagamentos->id==$atendimentos->tipoPagamentoId) echo"selected"; ?>>{{ $pagamentos->pagamento }}</option>
					@endforeach
				</select>
			@endforeach
		</div>
		<br>
		<div class="col-lg-12" align="center">
			<input type="button" class="btn btn-primary" id="botao_pagamento" value="Editar Atendimento">
		</div>
		<br>
		<div align="center" class="alert alert-success col-lg-12" role="alert" id="msgRetorno" style="display: none"></div>
	</div>
</form>
</body>
</html>