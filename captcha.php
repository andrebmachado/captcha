<?php
/**
 * Description TCPF
 * @version    1.0
 * @package    TReceita
 * @author     Ademilson Nunes 
 * @license    http://www.gnu.org/licenses/gpl.html
 */
class TCPF 
{
    private  $cookieFile;
    private  $token;
    private  $imgCaptcha;
    /**
      * Class constructor
      */
    public function __construct() 
    {
        require_once('lib/Simple_html_dom.php');
	require_once('lib/Simple_html_dom_node.php');
        
        session_start();               
        $this->cookieFile = 'cookie/'.session_id();
        	if(!file_exists($this->cookieFile))
	{
		$file = fopen($this->cookieFile, 'w');
		fclose($file);
	}
		
	$ch = curl_init('http://www.receita.fazenda.gov.br/aplicacoes/atcta/cpf/consultapublica.asp');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
	$html = curl_exec($ch);
	
	if(!$html)
        {
          return false;  
        }

	$html = new Simple_html_dom($html);
	$url_imagem = $tokenValue = '';
	$imgcaptcha = $html->find('img[id=imgcaptcha]');

	if(count($imgcaptcha))
	{
		
		foreach($imgcaptcha as $imgAttr)
			$url_imagem = $imgAttr->src;
		
		if(preg_match('#guid=(.*)$#', $url_imagem, $arr))
		{
			$idCaptcha = $arr[1];	
			$viewstate = $html->find('input[id=viewstate]');
			if(count($viewstate))
			{
				foreach($viewstate as $inputViewstate) 
					$tokenValue = $inputViewstate->value;
			}
			if(!empty($idCaptcha) && !empty($tokenValue))
                        {
                               $this->token = array($idCaptcha, $tokenValue);
			
                        }
			else
                        {
                               $this->token = false;
                        }
				
		}
	}
        $this->imgCaptcha = $this->getCaptcha($idCaptcha);
    }
    
    
    
    /**
     * _getToken()
     */
    public function _getToken()
    {
        return $this->token;
    }
    
    /**
     * getCPF()
     * @param string $cpf CPF
     * @param string $captcha
     * @param string $token
     * @return array
     * 
     */
    private function getCPF($cpf, $captcha, $token)
    {	
	if(!file_exists($this->cookieFile))
        {
		return false;
        }
		
	$post = array
	(
		'txtCPF'    	=> $cpf,
		'captcha'       => $captcha,
		'captchaAudio'	=> '',
		'Enviar'    	=> 'Consultar',
		'viewstate'     => $token
	);	
	
	$data = http_build_query($post, NULL, '&');
	$cookie = array('flag' => 1);
	$ch = curl_init('http://www.receita.fazenda.gov.br/aplicacoes/atcta/cpf/ConsultaPublicaExibir.asp');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
	curl_setopt($ch, CURLOPT_COOKIE, http_build_query($cookie, NULL, '&'));
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
	curl_setopt($ch, CURLOPT_REFERER, 'http://www.receita.fazenda.gov.br/aplicacoes/atcta/cpf/consultapublica.asp');	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$html = curl_exec($ch);
	curl_close($ch);
	return $html;
}

    /**
     * parseHtmlCPF()
     * @param string $html
     * @return array Resultado
     */
    private function parseHtmlCPF($html)
    {
            $dom = new DomDocument();
            $dom->loadHTML($html);
            $nodes = $dom->getElementsByTagName('span');
            //$len = $nodes->length;
            $campos = array();
            for($i = 5; $i < 10; $i++)
            {
                    if(!isset($nodes->item(($i+1))->nodeValue))
                    {
                            break;
                    }

                    $current = trim($nodes->item($i)->nodeValue);
                    $prox = trim($nodes->item(($i+1))->nodeValue);

                    if(strpos($current, 'o Cadastral') !== false)
                    {
                            $campos['situacao'] = explode(':', $current);
                            if(count($campos['situacao']) == 2)
                                    $campos['situacao'] = trim($campos['situacao'][1]);
                    }

                    if(strpos($current, 'Nome da Pessoa F') !== false)
                    {
                            $campos['nome'] = explode(':', $current);
                            if(count($campos['nome']) == 2)
                                    $campos['nome'] = trim($campos['nome'][1]);
                    }
            }

            return $campos;
    }

    /**
     * getCaptha()
     * @return image Captha
     */
    private function getCaptcha()
    {
       $idCaptcha = $_REQUEST['id'];
        if(preg_match('#^[a-z0-9-]{36}$#', $idCaptcha))
        {
                $url = 'http://www.receita.fazenda.gov.br/scripts/captcha/Telerik.Web.UI.WebResource.axd?type=rca&guid='.$idCaptcha;      
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
                $imgsource = curl_exec($ch);
                curl_close($ch);
                if(!empty($imgsource))
                {
                       $img = imagecreatefromstring($imgsource);
                       header('Content-type: image/jpg');
                       return imagejpeg($img);
                }
        }
    }
    
    /**
     * showResult()
     * @param string $cpf
     * @param string $captcha
     * @param string $token
     * @return array $campos
     */
    public function showResult($cpf, $captcha, $token)
    {       	
	$getHtmlCPF = $this->getCPF($cpf, $captcha, $token);
	if($getHtmlCPF)
	{
		$campos = $this->parseHtmlCPF($getHtmlCPF);
                var_dump($campos);
	}
    }

}

// cria um objeto TCPF
$getCPF = new TCPF;
// recebe o token 
$token   = $getCPF->_getToken();

// Se post
if ($_POST['cpf']) 
{
        $cpf     = $_REQUEST['cpf'];
	$captcha = $_REQUEST['captcha'];
	$token   = $_REQUEST['viewstate'];
    
    // executa consulta    
    $getCPF->showResult($cpf, $captcha, $token);
}

?>

<html>
	<head>
		<title>Teste CPF</title>
	</head>
	<body>
		<form method="post" action="TCPF.class.php?showResult">
			<span class="titleCats">CPF</span>
			<br />
			<input name="cpf" type="text" maxlength="14" required />
			<br />
			<img src="TCPF.class.php?getCaptcha&id=<?php echo "$token[0]"; ?>" border="0">
			<br />
			<input name="captcha" type="text" maxlength="6" required />
			<br />
			<input type="hidden" name="viewstate" value="<?php echo $token[1]; ?>" />
			<br/>
			<input type="submit" value="Enviar"/>
		</form>
	</body>
</html>