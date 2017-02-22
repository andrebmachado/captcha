<?php

header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Pragma: no-cache' );// define caminho absoluto e relativo para arquivo cookie

$pasta_cookies = 'cookies_cnpj/';
define('COOKIELOCAL', str_replace('\\', '/', realpath('./')).'/'.$pasta_cookies);
define('HTTPCOOKIELOCAL', 'http://'.$_SERVER['SERVER_NAME'].str_replace(pathinfo($_SERVER['SCRIPT_FILENAME'],PATHINFO_BASENAME),'',$_SERVER['SCRIPT_NAME']).$pasta_cookies);
 
 
// inicia sessão
@session_start();
$cookieFile_fopen = HTTPCOOKIELOCAL.session_id();
$cookieFile = COOKIELOCAL.session_id();

var_dump($cookieFile);
exit;

// cria arquivo onde será salva a sessão com a receita, caso ele não exista
if(!file_exists($cookieFile)){
    $file = fopen($cookieFile, 'w');
    fclose($file);
}
 
// faz a chamaa para a receita que exibe o captcha
$url = 'http://localhost/Captcha/t2.php';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);   // salva os dados de sessão
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);  // atualiza os dados de sessão se estiverem desatualizados
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,15); 
curl_setopt($ch, CURLOPT_TIMEOUT, 15);

// não utilizar returntransfer , este script replica imagem captcha da receita sem necessidade de gravar a imagem
$imgsource = curl_exec($ch);

curl_close($ch);
 
// se tiver imagem , mostra
if(!empty($imgsource)){
    $img = imagecreatefromstring(($imgsource));
    header('Content-type: image/jpg');
    imagejpeg($img);
}

var_dump($GLOBALS['_SESSION']);
exit;
