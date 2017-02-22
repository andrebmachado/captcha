<?php
header('Content-Type: text/html; charset=UTF-8');
@session_name("sccboletos");
@session_start();
require('../conecta.php');
require('../conecta2.php');

$sql = mysql_query("SELECT V_RECEITA FROM NOVOCLIENTE WHERE I_NOVOCLIENTE_ID = '".$_REQUEST['idnovocliente']."' ",$novo);
$row = mysql_fetch_object($sql);

print stripslashes(utf8_encode($row->V_RECEITA));

?>