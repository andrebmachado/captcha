<?php
//header("Content-Type: text/html; charset=UTF-8");
header('Content-Type: text/html; charset=');
session_start();
require_once '../conecta.php'; 
require_once '../conecta2.php'; 
require_once '../funcoes.php';

$pasta_cookies = 'cookies_cnpj/';
define('COOKIELOCAL', str_replace('\\', '/', realpath('./')).'/'.$pasta_cookies);
define('HTTPCOOKIELOCAL', 'http://'.$_SERVER['SERVER_NAME'].str_replace(pathinfo($_SERVER['SCRIPT_FILENAME'],PATHINFO_BASENAME),'',$_SERVER['SCRIPT_NAME']).$pasta_cookies);
 
// inicia sessão
@session_start();
 
function tirarAcentos($string){
   return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U n N c C"),$string);
}

 
// função para pegar o que interessa
function pega_o_que_interessa($inicio,$fim,$total)
{
    $interesse = str_replace($inicio,'',str_replace(strstr(strstr($total,$inicio),$fim),'',strstr($total,$inicio)));
    return($interesse);
}
 
// função para pegar a resposta html da consulta pelo CPF na página da receita
function getHtmlCNPJ($cnpj, $captcha)
{
    $cookieFile = COOKIELOCAL.session_id();
    $cookieFile_fopen = HTTPCOOKIELOCAL.session_id();
    if(!file_exists($cookieFile))
    {
        return false;      
    }
    else
    {
        // pega os dados de sessão gerados na visualização do captcha dentro do cookie
        $file = fopen($cookieFile_fopen, 'r');
        while (!feof($file))
        {$conteudo .= fread($file, 1024);}
        fclose ($file);
 
        $explodir = explode(chr(9),$conteudo);
         
        $sessionName = trim($explodir[count($explodir)-2]);
        $sessionId = trim($explodir[count($explodir)-1]);
         
        // constroe o parâmetro de sessão que será passado no próximo curl
        $cookie = $sessionName.'='.$sessionId.';flag=1';    
    }
     
    // dados que serão submetidos a consulta por post
    $post = array
    (
        'submit1'                       => 'Consultar',
        'origem'                        => 'comprovante',
        'cnpj'                          => $cnpj, 
        'txtTexto_captcha_serpro_gov_br'=> $captcha,
        'search_type'                   => 'cnpj'
         
    );
     
    $post = http_build_query($post, NULL, '&');
 
    $ch = curl_init('http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/valida.asp');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);        // aqui estão os campos de formulário
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);  // dados do arquivo de cookie
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);   // dados do arquivo de cookie
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);      // dados de sessão e flag=1
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
    curl_setopt($ch, CURLOPT_REFERER, 'http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/Cnpjreva_Solicitacao2.asp');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,15); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);	
    $html = curl_exec($ch);
	curl_close($ch);
	//print teste;
	
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);  // dados do arquivo de cookie
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);   // dados do arquivo de cookie
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);      // dados de sessão e flag=1
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
	curl_setopt($ch, CURLOPT_URL, 'http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_qsa.asp');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,15); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);	
	$content123 = curl_exec ($ch);

	curl_close($ch); 
	
	//print $html;
	qdSocio($content123);
   
    return $html;
}

function qdSocio($htmlQdSocio){
	global $novo;
	$sql2 = mysql_query("UPDATE NOVOCLIENTE SET V_SOCIOS = '".addslashes($htmlQdSocio)."' WHERE I_NOVOCLIENTE_ID = '".$_REQUEST['idnovocliente']."'  ",$novo);
}
 
// Função para extrair o que interessa da HTML e colocar em array
function parseHtmlCNPJ($html)
{
    // respostas que interessam
    $campos = array(
    'NÚMERO DE INSCRIÇÃO',
    'DATA DE ABERTURA',
    'NOME EMPRESARIAL',
    'TÍTULO DO ESTABELECIMENTO (NOME DE FANTASIA)',
    'CÓDIGO E DESCRIÇÃO DA ATIVIDADE ECONÔMICA PRINCIPAL',
    'CÓDIGO E DESCRIÇÃO DAS ATIVIDADES ECONÔMICAS SECUNDÁRIAS',
    'CÓDIGO E DESCRIÇÃO DA NATUREZA JURÍDICA',
    'LOGRADOURO',
    'NÚMERO',
    'COMPLEMENTO',
    'CEP',
    'BAIRRO/DISTRITO',
    'MUNICÍPIO',
    'UF',
    'ENDEREÇO ELETRÔNICO',
    'TELEFONE',
    'ENTE FEDERATIVO RESPONSÁVEL (EFR)',
    'SITUAÇÃO CADASTRAL',
    'DATA DA SITUAÇÃO CADASTRAL',
    'MOTIVO DE SITUAÇÃO CADASTRAL',
    'SITUAÇÃO ESPECIAL',
    'DATA DA SITUAÇÃO ESPECIAL');
 
    // caracteres que devem ser eliminados da resposta
    $caract_especiais = array(
    chr(9),
    chr(10),
    chr(13),
    '&nbsp;',
    '</b>',
    '  ',
    '<b>MATRIZ<br>',
    '<b>FILIAL<br>'
     );
 
    // prepara a resposta para extrair os dados
    $html = str_replace('<br><b>','<b>',str_replace($caract_especiais,'',strip_tags(($html),'<b><br>')));
     
    $html3 = $html;
 
    // faz a extração
    for($i=0;$i<count($campos);$i++)
    {       
        $html2 = strstr($html,utf8_decode($campos[$i]));
        $resultado[] = trim(pega_o_que_interessa(utf8_decode($campos[$i]).'<b>','<br>',$html2));
        $html=$html2;
    }
 
 	$resultado[4] = (utf8_encode($resultado[4]));
    // extrai os CNAEs secundarios , quando forem mais de um
	$resultado[5] = (utf8_encode($resultado[5])); //tira acentuacao porconta do json
    if(strstr($resultado[5],'<b>'))
    {
        $cnae_secundarios = explode('<b>',$resultado[5]);
        $resultado[5] = $cnae_secundarios;
        unset($cnae_secundarios);
    }
 
    // devolve STATUS da consulta correto
    if(!$resultado[0])
    {
        if(strstr($html3,utf8_decode('O número do CNPJ não é válido')))
        {$resultado['status'] = 'CNPJ incorreto ou não existe';}
        else
        {$resultado['status'] = 'Imagem digitada incorretamente';}
    }
    else
    {$resultado['status'] = 'OK';}
     
    return $resultado;
}
 
 
//print "<pre>"; print_r($_REQUEST); print "</pre>";
$cnpj = str_replace('.','',$_POST['CNPJ']);
$cnpj = str_replace('/','',$cnpj);
$cnpj = str_replace('-','',$cnpj);
$captcha = $_POST['CAPTCHA'];
 
// pega html resposta da receita
$getHtmlCNPJ = getHtmlCNPJ($cnpj, $captcha);
//$getHtmlCNPJ = (string)$getHtmlCNPJ[0];
//$getHtmlCNPJ = $getHtmlCNPJ[0]; 
$atualiza = str_replace('images/brasao2.gif','http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/images/brasao2.gif', $getHtmlCNPJ);
 
if($getHtmlCNPJ)
{
	 
	$campos = parseHtmlCNPJ(($getHtmlCNPJ));
	foreach($campos as $campo){
		if(sizeof($campo)>1){
			$i=1;
			foreach($campo as $camp){
				$campos2[5][$i] = htmlentities($camp);
				$i++;
			}
		}else{
			$campos2[] = htmlentities($campo);
		}
	}
    // volova os dados em um array	
    //var_dump($campos);
	if($campos2[22]=='OK'){
		//$htmlQdSocio = qdSocio();
		$sql2 = mysql_query("UPDATE NOVOCLIENTE SET V_RECEITA = '".addslashes($atualiza)."', V_RECEITAJSON = '".addslashes(json_encode($campos2))."' WHERE I_NOVOCLIENTE_ID = '".$_REQUEST['idnovocliente']."'  ",$novo);
		if($sql2){
			print '1';
		}else{
			print '0';	
		}
	}else{
		print '0';	
	}
	
}else{
	print '0';	
}
?>