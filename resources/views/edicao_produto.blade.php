<html>
<head>
<title>SISTEMA DE CONTROLE EMPRESARIAL</title>
<script type="text/javascript" src="<?php echo asset('js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/jquery.mask.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/bootstrap.min.js')?>"></script>
<link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css')?>" type="text/css">

<script language="javascript">
function listagemProdutos(){
    window.location.replace("{{ Route('listagemProdutos') }}")
}

$(document).ready(function(){
	
	$('#botao_edicao').click(function(){
		$.post("{{ Route('editarProduto') }}",{ 
			'_token':'{{ csrf_token() }}',
            'id':$('#id').val(),
			'nome':$('#nome').val(),
			'valor':$('#valor').val(),
			'estoque':$('#estoque').val(),
			'foto':$('#foto').val()
		 },function(data){
			console.log(data);
			$('#msgRetorno').html('Pedido editado com sucesso.');
			$('#msgRetorno').attr('display','block');
			$('#msgRetorno').fadeIn('slow');
            setTimeout("$('#msgRetorno').fadeOut('slow')",1500);
            setTimeout("$('#msgRetorno').attr('display','none')",1500);
            setTimeout("window.location.reload()",2000);
		});
	});
	
});
</script>
</head>
<body>
<form>
    <input type="hidden" name="id" id="id" value="<?= $dados_produto['id'] ?>">
	<div class="container">
		<div class="row alert alert-primary" role="alert"><div class="col-lg-12" align="center">Editar Produto</div></div>
        <div class="col-lg-12" align="right"><input type="button" class="btn btn-success" value="Listagem de Produtos" onclick="listagemProdutos()"></div><br>
		<div class="row">
        <div class="col-lg-12" align="center"><input type="text" name="nome" id="nome" placeholder="Nome do Produto" size="70" value="<?= $dados_produto['nome'] ?>" required="required"></div>
        </div><br />
		<div class="row">
			<div class="col-lg-12" align="center">
				<input type="text" name="valor" id="valor" placeholder="Valor" size="10" value="<?= $dados_produto['valor'] ?>" required="required">
				&nbsp;&nbsp;&nbsp;
				<input type="text" name="estoque" id="estoque" placeholder="Estoque" size="3" maxlength="5" value="<?= $dados_produto['estoque'] ?>" required="required">
				&nbsp;&nbsp;&nbsp;
				<input type="file" name="foto" id="foto"  required="required">
			</div>
		</div>
		<br>
		<div class="col-lg-12" align="center">
			<input type="button" class="btn btn-primary" id="botao_edicao" value="Editar Produto">
		</div>
		<br>
		<div align="center" class="alert alert-success col-lg-12" role="alert" id="msgRetorno" style="display: none"></div>
	</div>
</form>
</body>
</html>