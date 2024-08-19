<html>
<head>
<title>POSITIVO</title>
<script type="text/javascript" src="<?php echo asset('js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?php echo asset('js/bootstrap.min.js')?>"></script>
<link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css')?>" type="text/css">

<script language="javascript">
    $(document).ready(function(){
        $('#card_data').hide();
        $('#meio_pagamento').change(function(){
            if($('#meio_pagamento').val() == 'cc'){
                $('#card_data').show();
                $('#card_number').attr('required','required');
                $('#cvv').attr('required','required');
                $('#mes').attr('required','required');
                $('#ano').attr('required','required');
            }
            else{
                $('#card_data').hide();
                $('#card_number').removeAttr('required');
                $('#cvv').removeAttr('required');
                $('#mes').removeAttr('required');
                $('#ano').removeAttr('required');
            }
        });
    });
</script>
</head>

<body>
<form action="{{ Route('efetuarCobranca') }}" method="post">
    @csrf
	<div class="container">
		<div class="row alert alert-primary" role="alert"><div class="col-lg-12" align="center">Dados do Pagamento</div></div>
            <input type="hidden" name="customer" id="customer" value="$aact_YTU5YTE0M2M2N2I4MTliNzk0YTI5N2U5MzdjNWZmNDQ6OjAwMDAwMDAwMDAwMDAwODY5Nzc6OiRhYWNoXzE0ODc1ZTZmLWEyMmQtNGFhZi1hZGJiLThkMGZjYmM0YWM5Ng==">
            <input type="hidden" name="fine_value" id="fine_value" value="1">
            <input type="hidden" name="interest_value" id="interest_value" value="2">
            <input type="hidden" name="externalReference" id="externalReference"  value="056984">

            <div class="row">
                <div class="col-lg-3"><label>Valor</label></div><div class="col-lg-3"><input type="text" name="product_value" id="product_value" value="R$ 100,00" size="10"  readonly="readonly"></div>
                <div class="col-lg-3"><label>Data do Pagamento</label></div><div class="col-lg-3"><input type="text" name="dueDate" id="dueDate" value="<?php echo date('d/m/Y'); ?>" size="10" readonly="readonly"></div>
            </div>
            <div class="row">
                <div class="col-lg-3"><label>Descrição</label></div><div class="col-lg-3"><input type="text" name="description" id="description" value="Liquidificador" size="10"  readonly="readonly"></div>
                <div class="col-lg-3"><label>Dias para Cancelamento</label></div><div class="col-lg-3"><input type="text" name="daysAfterDueDateToRegistrationCancellation" id="daysAfterDueDateToRegistrationCancellation" value="1" size="10"  readonly="readonly"></div>
            </div>
            <div class="row" align="center">
                <label>Desconto</label>
            </div>
            <div class="row">
                <div class="col-lg-3"><label>Valor</label></div><div class="col-lg-3"><input type="text" name="discount_value" id="discount_value" value="10%" size="5" readonly="readonly"></div>
                <div class="col-lg-3"><label>Dia Limite </label></div><div class="col-lg-3"><input type="text" name="dueDateLimitDays" id="dueDateLimitDays" value="0"  size="1" readonly="readonly"></div>
            </div><br />
            <div class="row col-lg-12">
                <label>Meio de Pagamento</label>&nbsp;&nbsp;&nbsp;
                <select name="meio_pagamento" id="meio_pagamento">
                    <option value="BOLETO">Boleto</option>
                    <option value="CreditCard">Cartão de Crédito</option>
                    <option value="PIXx">PIX</option>
                </select>
            </div><br />
            <div class="row col-lg12"  id="card_data">
                <input type="text" id="card_number" name="card_number" placeholder="Número do Cartão" maxlength="16">&nbsp;&nbsp;&nbsp;<input type="text" id="cvv" name="cvv" placeholder="CVV" maxlength="3">&nbsp;&nbsp;&nbsp;Validade:&nbsp;&nbsp;<input type="text" id="mes" name="mes" size="1" placeholder="Mês" maxlength="2">&nbsp;&nbsp;<input type="text" id="ano" name="ano" size="1" placeholder="Ano" maxlength="4">
            </div><br /><br />
            <div class="row col-md-6">
                <input type="submit" class="btn btn-primary" value="Efetuar Cobrança">
            </div>
        </div>
    </div>
</form>
</body>
</html>