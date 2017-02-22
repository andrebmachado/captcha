<?php
header('Content-Type: text/html; charset=UTF-8');
@session_name("sccboletos");
@session_start();
//require('../conecta.php');;
//require('../conecta2.php');
//ini_set('display_errors',1);
//$sql = mysql_query("SELECT V_RECEITAJSON, V_SOCIOS FROM NOVOCLIENTE WHERE I_NOVOCLIENTE_ID = '".$_REQUEST['idnovocliente']."' ",$novo);
//$row = mysql_fetch_object($sql);

function CapitalizaFrase($frase){
	
	$divide = explode(' ',$frase);
	if(sizeof($divide)>1){

		unset($frasenova);
		foreach($divide as $palavra){
			
			if($palavra=='LTDA' || $palavra=='EPP' || $palavra=='EIRELI' || $palavra=='R' || $palavra=='ME'){
				$frasenova .= ' '.strtoupper($palavra);	
			}elseif(strlen($palavra)>3){
				$frasenova .= ' '.ucfirst(strtolower($palavra));
			}else{
				$frasenova .= ' '.strtolower($palavra);	
			}
		}
		
		return trim($frasenova);
	}else{
		return ucfirst(strtolower($frase));
	}	
		
}

$dadosReceita = json_decode($row->V_RECEITAJSON); 
//print aki.sizeof(get_object_vars($dadosReceita[5]));
/*print "<pre>";
print_r($dadosReceita);
print "</pre>";*/
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2" bgcolor="#f4f4f4">
  <tr>
    <td colspan="3" class="titulo_pesquisa" style="font-size:11px;"><img src="img/icones/noticias.png" height="15">&nbsp;Dados da Receita Federal</td>
  </tr>
    <tr>
    <td></td>
    <td colspan="2" class="titulo_pesquisa" style="font-size:11px; font-weight:normal">&nbsp;Marque apenas o que deseja substituir</td>
  </tr>
  <tr>
    <td width="120">Razão Social</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="razaosocial2"></td>
    <td>
      <input name="razaosocial2" type="text" id="razaosocial2"  class="textbox" style="width:400px" value="<?=CapitalizaFrase($dadosReceita[2]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">Nome Fantasia</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="nomefantasia2"></td>
    <td>
      <input name="nomefantasia2" type="text" id="nomefantasia2"  class="textbox" style="width:400px" value="<?=CapitalizaFrase($dadosReceita[3]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">Data Abertura</td>
    <td width="1"></td>
    <td>
      <input name="dataabertura2" type="text" id="dataabertura2"  class="textbox" style="width:120px" value="<?=CapitalizaFrase($dadosReceita[1]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">Atividade Principal</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="atividade2" checked style="display:none"></td>
    <td>
      <input name="atividade2" type="text" id="atividade2"  class="textbox" style="width:80%" value="<?=CapitalizaFrase(utf8_decode($dadosReceita[4]));?>"/>
    </td>
  </tr>
  <tr>
    <td width="120" valign="top">Atividade Secudária</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="atividade22" checked style="display:none"></td>
    <td>
      <textarea name="atividade22" type="text" id="atividade22"  class="textbox" style="width:80%; height:70px; white-space: nowrap;"><? if(sizeof(@get_object_vars($dadosReceita[5]))>1){ foreach($dadosReceita[5] as $atividade){	print trim($atividade)."\n"; } }else{  print $dadosReceita[5]; } ?></textarea>
    </td>
  </tr>
  <tr>
    <td width="120">Natureza Jurídica</td>
    <td width="1"></td>
    <td>
      <input name="natureza2" type="text" id="natureza2"  class="textbox" style="width:80%" value="<?=CapitalizaFrase($dadosReceita[6]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">Endereço</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="endereco2"></td>
    <td>
      <input name="endereco2" type="text" id="endereco2"  class="textbox" style="width:400px" value="<?=CapitalizaFrase($dadosReceita[7]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">Número</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="numero2"></td>
    <td>
      <input name="numero2" type="text" id="numero2"  class="textbox" style="width:100px" value="<?=($dadosReceita[8]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">Complemento</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="complemento2"></td>
    <td>
      <input name="complemento2" type="text" id="complemento2"  class="textbox" style="width:400px" value="<?=CapitalizaFrase($dadosReceita[9]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">Bairro</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="bairro2"></td>
    <td>
      <input name="bairro2" type="text" id="bairro2"  class="textbox" style="width:400px" value="<?=CapitalizaFrase($dadosReceita[11]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">Cidade</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="cidade2"></td>
    <td>
      <input name="cidade2" type="text" id="cidade2"  class="textbox" style="width:400px" value="<?=CapitalizaFrase($dadosReceita[12]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">CEP</td>
    <td width="1"><input type="checkbox" class="dadoreceita" value="cep2"></td>
    <td>
      <input name="cep2" type="text" id="cep2"  class="textbox" style="width:120px" value="<?=str_replace('.','',$dadosReceita[10]);?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">E-mail</td>
    <td width="1"></td>
    <td>
      <input name="email2" type="text" id="email2"  class="textbox" style="width:400px" value="<?=$dadosReceita[14];?>"/>
    </td>
  </tr>
  <tr>
    <td width="120">Telefone</td>
    <td width="1"></td>
    <td>
      <input name="telefone2" type="text" id="telefone2"  class="textbox tel" style="width:400px" value="<?=$dadosReceita[15];?>"/>
    </td>
  </tr>
</table>
<BR>
<?php

$divide = explode('seguinte:',$row->V_SOCIOS);
if(sizeof($divide)>1){
	$divide = explode('Para informa',$divide[1]);
}else{
	$divide = explode('<html>',$row->V_SOCIOS);
	$divide = explode('<!-- Corpo -->',$divide[1]);
	$divide = explode('<br/>',$divide[1]);
}

print utf8_encode(strip_tags($divide[0],'<table><tr><td><b><br><fieldset>'));
//print "<pre>";print htmlentities(utf8_encode($divide[0]));

//print sizeof($explode);
$sotexto = (strip_tags($divide[0],"<tr>"));

$empresarial = explode('Nome/Nome Empresarial:',$sotexto);
if(sizeof($empresarial)>1){
	foreach($empresarial as $emp){
		//print "<hr>";
		$emp = str_replace('&nbsp;','',$emp);
		$emp = strip_tags($emp); 
		//print "<bR>".htmlentities($emp)."<br>";
		$separa = explode('Qualifica',$emp);
		if(trim($separa[0])!=''){
			$opcoes1[] = trim($separa[0]);	
		}
	
	}
}

$empresarial2 = explode('EMPRESARIAL:',$sotexto);
if(sizeof($empresarial2)>1){
	foreach($empresarial2 as $emp){
		//print "<hr>";
		$emp = str_replace('&nbsp;','',$emp);
		$emp = strip_tags($emp); 
		//print "<bR><bR><bR>a".htmlentities($emp)."b<br><bR><bR>";
		$separa = explode('CAPITAL SOCIAL:',$emp);
		//print "<bR><bR><bR>a".print_r($separa)."b<br><bR><bR>";
		if(trim($separa[0])!=''){
			$opcoes3[] = trim($separa[0]);	
		}
	}
}
unset($opcoes3[0]);

$resplegal = explode('Nome do Repres. Legal:',$sotexto);
foreach($resplegal as $emp){
	$emp = str_replace('&nbsp;','',$emp);
	$emp = strip_tags($emp); 
	//print "<bR>".htmlentities($emp)."<br>";
	$separa = explode(utf8_decode('País de Origem'),$emp);
	if(trim($separa[0])!=''){
		$opcoes2[] = trim($separa[0]);	
	}

}
unset($opcoes2[0]);

//print "<pre>"; print_r($opcoes1);
//print "<pre>"; print_r($opcoes2);

print "<div style='padding:10px; padding-bottom:40px; background-color:'>Opçoes para representante legal<br><br>";
if(sizeof($opcoes1)>0){
	foreach($opcoes1 as $op){
		?><div style="padding-right:10px; padding-bottom:10px; float:left"><input type="button" value="<?=CapitalizaFrase($op);?>" onClick="mudarreprelegal(this.value)"></div><?
	}
}
if(sizeof($opcoes2)>0){
	foreach($opcoes2 as $op){
		?><div style="padding-right:10px; padding-bottom:10px; float:left"><input type="button" value="<?=CapitalizaFrase($op);?>" onClick="mudarreprelegal(this.value)"></div><?
	}
}
if(sizeof($opcoes3)>0){
	foreach($opcoes3 as $op){
		?><div style="padding-right:10px; padding-bottom:10px; float:left"><input type="button" value="<?=CapitalizaFrase($op);?>" onClick="mudarreprelegal(this.value)"></div><?
	}
}
print "</div>";


//print_r($empresarial);

//print "<pre>"; print_r($empre);



?>