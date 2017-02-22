function proxima(link){
   location.replace(link);
   return false;
}

function carrega(vobjeto) {
	 for (var va = 0 ; va < document.forms[0].elements.length; va++) {
		if (document.forms[0].elements[va].name == vobjeto) {
			document.forms[0].elements[va].focus();
		}
	 }    
	 return false;
}

function volta(vvolta) {
 history.go(vvolta*-1);
 return false;
}

function SaltaCampo (campo, prox, tammax, teclapres){
	var tecla = teclapres.keyCode;
	vr = campo.value;
	tam = vr.length;
	if (tecla != 0 && tecla != 10 && tecla != 24)
	  if (tam == tammax)
		  prox.focus();
}

/* -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- */
function proxima(link){
location.replace(link);
return false;
}

function carrega(vobjeto){
 for (var va = 0 ; va < document.forms[0].elements.length; va++) {
	if (document.forms[0].elements[va].name == vobjeto) {
		document.forms[0].elements[va].focus();
	}
 }    
 return false;
}

function volta(vvolta) {
 history.go(vvolta*-1);
 return false;
}

function SaltaCampo (campo, prox, tammax, teclapres){
var tecla = teclapres.keyCode;
vr = campo.value;
tam = vr.length;
if (tecla != 0 && tecla != 10 && tecla != 24)
  if (tam == tammax)
	  prox.focus();
}

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------------- */

function validaCaracteresCaptcha(nomeForm, idLetra, paginaDestino) {
	var form = document.getElementById(nomeForm);
        
	if (document.getElementById(idLetra).value == ""){
		 AlertaCaptcha("Favor preencher algum o campo de validação");
		 form.action= "";
		 return false;
	}
	//if (document.getElementById(idLetra).value != "" && document.getElementById(idSom).value != "")
	//{
	//	 AlertaCaptcha("Favor preencher apenas um dos campos de validação");
	//	 form.action="";
	//	 return false;
	//}
			
	if (document.getElementById("cnpj").value == ""){
		 AlertaCaptcha("Favor preencher o campo de CNPJ");
		 form.action="";
		 return false;
	}
	
	form.action=paginaDestino;
	return true;
}
	
/*
function FRMOnLoad(){
	var ck 
	ck = getCookie('flag');
							
	if (theForm.txtTexto_captcha_serpro_gov_br.value != "" || ck == null || ck == 1)
	{
		theForm.txtTexto_captcha_serpro_gov_br.value = "";  // para o firefox nao ficar recarregando em loop
		document.cookie = 'flag=0';
		location.reload();												
	}
	theForm.cnpj.focus();		    
}
*/
	
function Submeter(){	
    document.cookie = 'flag=1';
    if (validaCaracteresCaptcha('theForm', 'txtTexto_captcha_serpro_gov_br', 'valida.asp')==false){
        return false;
    }
}
	
function deleteCookie(nome){
	var exdate = new Date();
	exdate.setTime(exdate.getTime() + (-1 * 24 * 3600 * 1000));
	document.cookie = nome + '=' + escape('')+ ((-1 == null) ? '' : '; expires=' + exdate);
}

function getCookie( check_name ) {
// first we'll split this cookie up into name/value pairs
// note: document.cookie only returns name=value, not the other components
var a_all_cookies = document.cookie.split( ';' );
var a_temp_cookie = '';
var cookie_name = '';
var cookie_value = '';
var b_cookie_found = false; // set boolean t/f default f

for ( i = 0; i < a_all_cookies.length; i++ ){
	// now we'll split apart each name=value pair
	a_temp_cookie = a_all_cookies[i].split( '=' );
	
	// and trim left/right whitespace while we're at it
	cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

	// if the extracted name matches passed check_name
	if ( cookie_name == check_name ){
		b_cookie_found = true;
		// we need to handle case where cookie has no value but exists (no = sign, that is):
		if ( a_temp_cookie.length > 1 ){
			cookie_value = unescape( a_temp_cookie[1].replace(/^\s+|\s+$/g, '') );
		}
		// note that in cases where cookie is initialized but no value, null is returned
		return cookie_value;
		break;
	}
	a_temp_cookie = null;
	cookie_name = '';
}

if ( !b_cookie_found ){
	return null;
}
}

/* 06-02-2015 - Captcha Corporativo *******/
// Exibe caixa de alerta com a mensagem passada através do parâmetro
function AlertaCaptcha(strMsg){
	window.alert(strMsg)
}

function recarregarCaptcha(){
	document.getElementById("imgCaptcha").src = "http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/captcha/gerarCaptcha.asp?" + new Date().getTime();
}    

function html5_audio(){
  var a = document.createElement('audio');
  return !!(a.canPlayType && a.canPlayType('audio/wav;').replace(/no/, ''));
}
 
var play_html5_audio = false;
if(html5_audio()) play_html5_audio = true;

function play_sound(url) {
  if(play_html5_audio){
	var snd = new Audio(url);
	snd.load();
	snd.play();
  }else{
	try {
	  var soundEmbed = document.createElement("embed");
	  soundEmbed.setAttribute("src", url);
	  soundEmbed.setAttribute("hidden", true);
	  soundEmbed.setAttribute("autostart", false);
	  soundEmbed.setAttribute("width", 0);
	  soundEmbed.setAttribute("height", 0);
	  soundEmbed.setAttribute("enablejavascript", true);
	  soundEmbed.setAttribute("autostart", true);
	  document.body.appendChild(soundEmbed);
	}
	catch (e) {
	 document.getElementById("captchaLink").setAttribute("href",url);
	}
  }
}
/******************************************/

//document.writeln(new Date().getTime());