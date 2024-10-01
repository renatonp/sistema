<html>
<head>
<title>SISTEMA DE CONTROLE EMPRESARIAL</title>
<script type="text/javascript" src="<?php echo asset('js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/datatables.min.js')?>"></script>
<link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css')?>" type="text/css">
<link rel="stylesheet" href="<?php echo asset('css/datatables.min.css')?>" type="text/css">

<script language="javascript">
function removerPedido(id){
    if(window.confirm("Tem certeza que deseja remover este pedido?")){
        $.post("{{ Route('removerAtendimento') }}",{
            '_token':'{{ csrf_token() }}', 
            'id' : id
        },function(data){
            if(data){
                $('#msgRetorno').html('O pedido está sendo removido...');
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

function detalhePedido(id){
    window.location.replace("/sistema/public/detalheAtendimento/"+id);
}

function edicaoPedido(id){
    window.location.replace("/sistema/public/edicaoAtendimento/"+id);
}

function cadastrarAtendimento(){
    window.location.replace("{{ Route('novoAtendimento') }}");
}
$(document).ready(function(){
    $('#listagem_pedidos').DataTable();
});
</script>
</head>

<body>
<form>
    @csrf
	<div class="container">
		<div class="row alert alert-primary" role="alert"><div class="col-lg-12" align="center">Lista de Atendimentos</div></div>
        <p><div class="col-lg-12" align="right"><input type="button" class="btn btn-success" value="Novo Atendimento" onclick="cadastrarAtendimento()"></p>
		<div align="center" class="alert alert-danger col-lg-12" role="alert" id="msgRetorno" style="display: none"></div>
        <table id="listagem_pedidos" class="table table-bordered table-striped">
        	<thead>
    			<tr>
                	<th> Atendimento </th>
                	<th>Ações</th>
            	</tr>
            </thead>

            <tbody>
            	@foreach($atendimentos as $ids)
                        <tr>
                            <td> Atendimento {{ $ids->id }}</td>
                            <td>
                                <input type="button" class="btn btn-success" value="Editar" onclick="edicaoPedido(<?= $ids->id ?>)">
                                &nbsp;&nbsp;&nbsp;
                                <input type="button" class="btn btn-danger" value="Remover" onclick="removerPedido(<?= $ids->id ?>)">
                            </td>
                        </tr>
            	@endforeach
            </tbody>
    	</table>
    </div>
</form>
</body>
</html>