<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script language="javascript" src="cnpj_receita.js"></script>

<title>Untitled Document</title>
</head>

<body>

<form id="theForm" action="http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/cnpjreva_solicitacao2.asp" onsubmit="javascript:return Submeter();" method="post" name="frmConsulta">
<input type="hidden" name="origem" value="comprovante">

<div style="float: left;">
	<input tabindex="1" name="cnpj" id="cnpj" maxlength="14" size="16" onkeyup="SaltaCampo(document.frmConsulta.cnpj, document.frmConsulta.txtTexto_captcha_serpro_gov_br, 14, event)" value="08300713000182"> 
</div>

<div style="float: left;">
    <img id="imgCaptcha" src="http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/captcha/gerarCaptcha.asp">
    <input type="text" id="txtTexto_captcha_serpro_gov_br" name="txtTexto_captcha_serpro_gov_br" maxlength="6" size="16">
</div>

<div style="float: left;">
    <input type="submit" value="Consultar" id="submit1" name="submit1">
    <input type="button" value="reload capt" onClick="javascript: recarregarCaptcha();">
    
    <input type="hidden" name="search_type" value="cnpj">    
</div>

</form>

</body>
</html>
<br>
<?php 

var_dump($GLOBALS);

?>