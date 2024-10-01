<html>
<head>
<title>SISTEMA DE CONTROLE EMPRESARIAL</title>
<script type="text/javascript" src="<?php echo asset('js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/datatables.min.js')?>"></script>
<link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css')?>" type="text/css">
<link rel="stylesheet" href="<?php echo asset('css/datatables.min.css')?>" type="text/css">

<script language="javascript">
function removerProduto(id){
    if(window.confirm("Tem certeza que deseja remover este produto?")){
        $.post("{{ Route('removerProduto') }}",{
            '_token':'{{ csrf_token() }}', 
            'id' : id
        },function(data){
            if(data){
                $('#msgRetorno').html('O produto está sendo removido...');
                $('#msgRetorno').attr('display','block');
                $('#msgRetorno').fadeIn('slow');
                setTimeout("$('#msgRetorno').fadeOut('slow')",1500);
                setTimeout("$('#msgRetorno').attr('display','none')",1500);
                setTimeout("window.location.reload()",2000);
                ;
            }
        });
    }
}

function edicaoProduto(id){
    window.location.replace("/sistema/public/edicaoProduto/"+id);
}

function cadastrarProduto(){
    window.location.replace("{{ Route('cadastroProduto') }}");
}
$(document).ready(function(){
    $('#listagem_produtos').DataTable();
});
</script>
</head>

<body>
<form>
    @csrf
	<div class="container">
		<div class="row alert alert-primary" role="alert"><div class="col-lg-12" align="center">Lista de Produtos</div></div>
        <p><div class="col-lg-12" align="right"><input type="button" class="btn btn-success" value="Novo Produto" onclick="cadastrarProduto()"></p>
		<div align="center" class="alert alert-danger col-lg-12" role="alert" id="msgRetorno" style="display: none"></div>
        <table id="listagem_produtos" class="table table-bordered table-striped">
        	<thead>
    			<tr>
                	<th> Produto </th>
                	<th> Valor </th>
                	<th> Estoque </th>
                	<th> Foto </th>
                	<th>Ações</th>
            	</tr>
            </thead>

            <tbody>
            	@foreach($produtos as $produto)
            		<tr id="{{ $produto->id }}">
            			<td>{{ $produto->nome }}</td>
            			<td> R$ {{ number_format($produto->valor,2,',','.') }}</td>
            			<td>{{ $produto->estoque }}</td>
            			<td> {{ $produto->foto }}</td>
            			<td>
                            <input type="button" class="btn btn-success" value="Editar" onclick="edicaoProduto(<?= $produto->id ?>)">
                            &nbsp;&nbsp;&nbsp;
                            <input type="button" class="btn btn-danger" value="Remover" onclick="removerProduto(<?= $produto->id ?>)">
                        </td>
            		</tr>
            	@endforeach
            </tbody>
    	</table>
    </div>
</form>
</body>
</html>