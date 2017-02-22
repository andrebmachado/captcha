<?php

session_start();
header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Pragma: no-cache' );

?>
<form id="formReceita" name="formReceta" action="#" method="post" target="_blank">
<div style="position:relative">
<div style="position:absolute; right:0px; top:0px; cursor:pointer"><strong>X</strong></div>
        <table cellspacing="4" cellpadding="4">
            <tr>
                <td>Cliente</td>
                <td><strong>Razao</strong></td>
            </tr>
            <tr>
                <td>CNPJ</td>
                <td><strong>cnpj</strong></td>
            </tr>
            <tr>
                <td></td>
                <td>
                	<img src="captchaReceita.php?<?=date('h:i:s');?>" border="0">
                </td>
            </tr>
            <tr>
                <td>
                <input type="hidden" name="CNPJ" id="CNPJ" value="08300713000182">
                <input type="hidden" name="idnovocliente" id="idnovocliente" value="32132"></td>
                <td>
                <input type="text" id="CAPTCHA" name="CAPTCHA" style="width:100px">
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input class="bottom" type="submit" value="Consulta"></td>
            </tr>
        </table>
</div>
</form>