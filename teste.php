<?php
session_start();

class cpf_receita{	
        function monta_form(){
                if(isset($_POST["enviar"])){
                        $this->valida_cpf($_POST["CPF"], $_POST["CAPTCHA"]);
                        echo $_POST["CAPTCHA"];
                } else {
                        if(!file_exists("RF_cookie_cpf.txt")){
                                $fp = fopen("RF_cookie_cpf.txt","w");
                                fwrite($fp, "");
                                fclose($fp); 
                        }

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_COOKIEFILE, realpath("RF_cookie_cpf.txt"));
                        curl_setopt($ch, CURLOPT_COOKIEJAR, realpath("RF_cookie_cpf.txt"));
                        //curl_setopt($ch, CURLOPT_URL, "http://www.receita.fazenda.gov.br/scripts/captcha/");
                        curl_setopt($ch, CURLOPT_URL, "http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/captcha/gerarCaptcha.asp");
                        
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_COOKIE, "flag=0");

                        $retorno = curl_exec($ch);

                        curl_close($ch);

                        $dom = new DomDocument();
                        @$dom->loadHTML($retorno);

                        $xpath = new DOMXPath($dom);
                        $q = $xpath->query("//img[@id='RadCaptcha1_CaptchaImage']");
                        $imagem = "http://www.receita.fazenda.gov.br/scripts/captcha/" . utf8_decode(trim($q->item(0)->getAttribute('src')));
//			print_r($imagem);
                        $q = $xpath->query("//input[@id='__VIEWSTATE']");
                        $_SESSION["viewstate"] = utf8_decode(trim($q->item(0)->getAttribute('value')));
//			echo $_SESSION["viewstate"];
                        ?>
                        <form method="post" action="">
                                CPF: <input type="text" name="CPF"/> <br />
                                Captcha: <input type="text" name="CAPTCHA"/> <br />
                                <img src="<?php echo($imagem); ?>" /> <br/>
                                <input id="id_submit" name="enviar" type="submit" value="Consultar"/>
                        </form>
                        <?php
                }
        }

        function valida_cpf($cpf, $captha)
        {
                $ch = curl_init();
/*
                curl_setopt($ch, CURLOPT_COOKIEFILE, realpath("RF_cookie_cpf.txt"));
                curl_setopt($ch, CURLOPT_COOKIEJAR, realpath("RF_cookie_cpf.txt"));
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
                curl_setopt($ch, CURLOPT_URL, "http://www.receita.fazenda.gov.br/aplicacoes/atcta/cpf/ConsultaPublicaExibir.asp");
                curl_setopt($ch, CURLOPT_COOKIE, "flag=1");
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'txtCPF=' . $cpf . '&captcha=' . $captha . '&captchaAudio=&viewstate=' . urlencode($_SESSION["viewstate"]) . '&id_submit=Consultar');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FILETIME, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
*/


                $post = array
                (
                        'txtCPF'    	=> $cpf, 
                        'txtTexto_captcha_serpro_gov_br'       => $captha,
                        'captchaAudio'	=> '',
                        'Enviar'    	=> 'Consultar',
                        'viewstate'     => urlencode($_SESSION["viewstate"])
                );	




                $data = http_build_query($post, NULL, '&');
                $cookie = array('flag' => 1);
//		$ch = curl_init('http://www.receita.fazenda.gov.br/aplicacoes/atcta/cpf/ConsultaPublicaExibir.asp');
//		$ch = curl_init('http://127.0.0.1/includes/bibliotecas/receita_federal_cpf_v1/recebe.php');


                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

                curl_setopt($ch, CURLOPT_COOKIEFILE, realpath("RF_cookie_cpf.txt"));
                curl_setopt($ch, CURLOPT_COOKIEJAR, realpath("RF_cookie_cpf.txt"));
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
//		curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1/includes/bibliotecas/opa/recebe.php");
                curl_setopt($ch, CURLOPT_URL, "http://www.receita.fazenda.gov.br/aplicacoes/atcta/cpf/ConsultaPublicaExibir.asp");
                curl_setopt($ch, CURLOPT_COOKIE, "flag=1");



//		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
//		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile);
//		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:8.0) Gecko/20100101 Firefox/8.0');
//		curl_setopt($ch, CURLOPT_COOKIE, http_build_query($cookie, NULL, '&'));
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
                curl_setopt($ch, CURLOPT_REFERER, 'http://www.receita.fazenda.gov.br/aplicacoes/atcta/cpf/consultapublica.asp');	
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);



                $resultado = curl_exec($ch);
//print_r($resultado);		
                curl_close($ch);

                $dom = new DomDocument();
                @$dom->loadHTML($resultado);

                $xpath = new DOMXPath($dom);
                $q = $xpath->query('//div[@class="clConteudoCentro"]');
                $q2 = $xpath->query('//span[@class="clConteudoDados"]');	
                $nome = trim(utf8_decode(@$q2->item(1)->nodeValue));	
                $nome = explode(":", $nome);
                print_r($resultado."<br><br>");
                if(@$nome[1] == "")
                echo "Captha ou CPF incorreto(s).";	
                else
                echo $nome[1];
        }
}

$cpf = new cpf_receita;
$cpf->monta_form();

//?>