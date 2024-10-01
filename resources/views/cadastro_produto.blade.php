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
	
	$('#botao_cadastro').click(function(){
		$.post("{{ Route('cadastrarProduto') }}",{ 
			'_token':'{{ csrf_token() }}',
			'nome':$('#nome').val(),
			'valor':$('#valor').val(),
			'estoque':$('#estoque').val(),
			'foto':$('#foto').val()
		 },function(data){
			console.log(data);
			document.forms[0].reset();
			$('#msgRetorno').html('Produto cadastrado com sucesso.');
			$('#msgRetorno').attr('display','block');
			$('#msgRetorno').fadeIn('slow');
			setTimeout("$('#msgRetorno').fadeOut('slow')",3750);
			setTimeout("$('#msgRetorno').attr('display','none')",5000);
		});
	});
	
});
</script>
</head>
<body>
<form action="{{ Route('cadastrarProduto') }}" method="post" enctype="multipart/form-data">
	@csrf
	<div class="container">
		<div class="row alert alert-primary" role="alert"><div class="col-lg-12" align="center">Novo Produto</div></div>
        <div class="col-lg-12" align="right"><input type="button" class="btn btn-success" value="Listagem de Produtos" onclick="listagemProdutos()"></div><br>
		<div class="row">
            <div class="col-lg-12" align="center"><input type="text" name="nome" id="nome" placeholder="Nome do Produto" size="70" maxlength="50" required="required"></div>
        </div><br />
		<div class="row">
			<div class="col-lg-12" align="center">
				<input type="text" name="valor" id="valor" placeholder="Valor" size="10" required="required">
				&nbsp;&nbsp;&nbsp;
				<input type="text" name="estoque" id="estoque" placeholder="Estoque" size="3" maxlength="5" required="required">
				&nbsp;&nbsp;&nbsp;
				<input type="file" name="foto" id="foto"  required="required">
			</div>
        </div>
		<br />
		<div class="col-lg-12" align="center">
			<input type="button" class="btn btn-primary" id="botao_cadastro" value="Cadastrar Produto">
		</div>
		<br>
		<div align="center" class="alert alert-success col-lg-12" role="alert" id="msgRetorno" style="display: none"></div>
	</div>
</form>
</body>
</html>