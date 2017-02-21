<?php

//$ch = curl_init();
//curl_setopt($ch, CURLOPT_COOKIEFILE, realpath("RF_cookie_cpf.txt"));
//curl_setopt($ch, CURLOPT_COOKIEJAR, realpath("RF_cookie_cpf.txt"));
//curl_setopt($ch, CURLOPT_URL, "http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao2.asp");    

//curl_setopt($ch, CURLOPT_URL, "http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/captcha/gerarCaptcha.asp");    
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_COOKIE, "flag=0");
//echo $retorno = curl_exec($ch);
//curl_close($ch);
    
    
$ch = curl_init();
curl_setopt($ch, CURLOPT_COOKIEFILE, realpath("RF_cookie_cpf.txt"));
curl_setopt($ch, CURLOPT_COOKIEJAR, realpath("RF_cookie_cpf.txt"));
curl_setopt($ch, CURLOPT_URL, "http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/captcha/gerarCaptcha.asp");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_COOKIE, "flag=0");
$retorno = curl_exec($ch);
curl_close($ch);

$dom = new DomDocument();
@$dom->loadHTML($retorno);

$xpath = new DOMXPath($dom);
//$qry = $xpath->query("//img[@id='RadCaptcha1_CaptchaImage']");
$qry = $xpath->query("/html/body/img");
var_dump($qry);


//$imagem = "http://www.receita.fazenda.gov.br/scripts/captcha/" . utf8_decode(trim($qry->item(0)->getAttribute('src')));
//			print_r($imagem);
//$qry = $xpath->query("//input[@id='__VIEWSTATE']");
//$_SESSION["viewstate"] = utf8_decode(trim($qry->item(0)->getAttribute('value')));
//			echo $_SESSION["viewstate"];    
    

//http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao2.asp?cnpj=08300713000182