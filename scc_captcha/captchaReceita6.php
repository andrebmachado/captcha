<?php

//ini_set('display_errors','1');
session_start();
 include '../conecta.php'; 
 include '../conecta2.php'; 
 include 'funcoes.php'; 
 
//$_REQUEST['clientenovo2'] = json_decode($_REQUEST['clientenovo']);
parse_str($_REQUEST['clientenovo'], $cliente);
///print_r($cliente);
//print_r($_REQUEST[info]);

if($_REQUEST[info][razaosocial2]!=''){
	$cliente[razaosocial] = $_REQUEST[info][razaosocial2];
}
if($_REQUEST[info][nomefantasia2]!=''){
	$cliente[nomefantasia] = $_REQUEST[info][nomefantasia2];
}
if($_REQUEST[info][cep2]!=''){
	$cliente[cep] = $_REQUEST[info][cep2];
}
if($_REQUEST[info][endereco2]!=''){
	$cliente[endereco] = $_REQUEST[info][endereco2];
}
if($_REQUEST[info][numero2]!=''){
	$cliente[numero] = $_REQUEST[info][numero2];
}
if($_REQUEST[info][complemento2]!=''){
	$cliente[complemento] = $_REQUEST[info][complemento2];
}
if($_REQUEST[info][bairro2]!=''){
	$cliente[bairro] = $_REQUEST[info][bairro2];
}
if($_REQUEST[info][cidade2]!=''){
	$cliente[cidade] = $_REQUEST[info][cidade2];
}
if($_REQUEST[info][cep2]!=''){
	$cliente[cep] = $_REQUEST[info][cep2];
}

//print_r($cliente);
if($cliente[negativacao]!=1){
	$cliente[negativacao]=0;
}
if($cliente[garantido]!=1){
	$cliente[garantido]=0;
}
//FAZ UPDATE NA BASE DO REPRESENATNE
if($cliente['credito']=='on'){ $cliente['credito']=1; }else{ $cliente['credito']=0; }
if($cliente['negaticavaor']=='on'){ $cliente['negativacaor']=1; }else{ $cliente['negativacaor']=0; }
if($cliente['autolist']=='on'){ $cliente['autolist']=1; }else{ $cliente['autolist']=0; }
$sql = mysql_query(" UPDATE SCC.NOVOCLIENTE 
						SET I_USUARIO = '".$_SESSION[ID]."',
							V_NOMEFANTASIA = '".utf8_decode($cliente[nomefantasia])."',
							V_RAZAOSOCIAL = '".utf8_decode($cliente[razaosocial])."',
							V_CNPJ = '".$cliente[cnpj]."',
							V_REPRESENTANTE = '".utf8_decode($cliente[representante])."',
							V_CPF = '".$cliente[cpf]."',
							V_TELEFONE = '".$cliente[telefone]."',
							V_TELEFONE2 = '".$cliente[telefone2]."',
							V_TELEFONE3 = '".$cliente[telefone3]."',
							V_EMAIL = '".$cliente[email]."',
							V_EMAIL2 = '".$cliente[email2]."',
							V_EMAIL3 = '".$cliente[email3]."',
							V_CEP = '".$cliente[cep]."',
							V_ENDERECO = '".utf8_decode($cliente[endereco])."',
							V_NUMERO = '".$cliente[numero]."',
							V_COMPLEMENTO = '".utf8_decode($cliente[complemento])."',
							V_BAIRRO = '".utf8_decode($cliente[bairro])."',
							V_CIDADE = '".utf8_decode($cliente[cidade])."',
							V_UF = '".$cliente[estado]."',
							V_PLANO = '".$cliente[plano]."',
							V_PLANOREAL = '".$cliente[planoreal]."',
							V_OBS = '".utf8_decode($cliente[obs])."',
							V_OBS2 = '".utf8_decode($cliente[obs2])."',
							V_OBS3 = '".utf8_decode($cliente[obs3])."',
							V_OBS4 = '".utf8_decode($cliente[obs4])."',
							I_NEGATIVACAO = '".$cliente[negativacao]."',
							I_GARANTIDO = '".$cliente[garantido]."',
							V_STATUS = '".$cliente[acao]."',
							V_ATIVIDADEP = '".utf8_decode($_REQUEST[info][atividade2])."',
							V_ATIVIDADES = '".utf8_decode($_REQUEST[info][atividade22])."',
							I_CREDITO = '".($cliente[credito])."',
							I_NEGATIVACAOR = '".($cliente[negativacaor])."',
							I_AUTOLIST = '".($cliente[autolist])."',
							D_DATASCC = NOW()
							WHERE I_NOVOCLIENTE_ID = '".$cliente[atucli]."'
 						 ",$novo)or die("erro".mysql_error($novo));
if($cliente[acao]=='1'){
	print $cliente[atucli];						 
}
?>