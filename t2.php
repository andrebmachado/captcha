<?php

$url = file_get_contents('http://www.bcb.gov.br/');
preg_match_all('/ORES-->(.+)<!--/s', $url, $conteudo);
//$exibir = $conteudo[0][0];
var_dump($conteudo);
exit;

session_start();

$_SESSION["xTest"] = "testando_sessao";
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div id="conteudo">Teste</div>
</body>
</html>