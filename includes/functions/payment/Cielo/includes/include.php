<?php



//require_once  "includes/errorHandling.php";
//require_once "includes/pedido.php";
//require_once "includes/logger.php";


require 'errorHandling.php';
require_once 'pedido.php';
require_once 'logger.php';

define('VERSAO', "1.1.0");

session_start();

if(!isset($_SESSION["pedidos"]))
{
	$_SESSION["pedidos"] = new ArrayObject();
}

// CONSTANTES
//define("ENDERECO_BASE", "https://qasecommerce.cielo.com.br");
define("ENDERECO_BASE", "https://ecommerce.cielo.com.br");
define("ENDERECO", ENDERECO_BASE."/servicos/ecommwsec.do");
 

 /*
 
define("LOJA", "1006993069");
define("LOJA_CHAVE", "25fbb99741c739dd84d7b06ec78c9bac718838630f30b112d033ce2e621b34f3");

*/

//define("CIELO", "");
//define("CIELO_CHAVE", "");

 
 $filiacaoCielo=  get_option('filiacaoCielo'); 
 $chaveCielo=  get_option('chaveCielo');
 
 
define("CIELO", "$filiacaoCielo");
define("CIELO_CHAVE", "$chaveCielo");



 



// Envia requisi��o
function httprequest($paEndereco, $paPost){

	$sessao_curl = curl_init();
	

	
	curl_setopt($sessao_curl, CURLOPT_URL, $paEndereco);
	
	curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);

	//  CURLOPT_SSL_VERIFYPEER
	//  verifica a validade do certificado
	curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, true);
	//  CURLOPPT_SSL_VERIFYHOST
	//  verifica se a identidade do servidor bate com aquela informada no certificado
	curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 2);
	
 
	$urlCURL =  str_replace('ajax/','functions/payment/Cielo/pages/',getcwd() .
	 		"/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt");
	
	$urlCURLA = explode("public_html/",$urlCURL);
	
	$urlCURL = $urlCURLA[0].'public_html/wp-content/plugins/wpstore/includes/functions/payment/Cielo/pages/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt';
	
	 
		///home/storage/9/a6/a6/cfcarehospitalar/public_html/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crtYYYYYY
 
	 
	
	 //echo $urlCURL;
	//  CURLOPT_SSL_CAINFO
	//  informa a localiza��o do certificado para verifica��o com o peer
	curl_setopt($sessao_curl, CURLOPT_CAINFO, $urlCURL);
	
    /*
	
	curl_setopt($sessao_curl, CURLOPT_CAINFO, getcwd() ."/ssl/meu_cerfificado.crt"); 
	*/		
				
	curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 4);
	
		
			

	//  CURLOPT_CONNECTTIMEOUT
	//  o tempo em segundos de espera para obter uma conex�o
	curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 10);

	//  CURLOPT_TIMEOUT
	//  o tempo m�ximo em segundos de espera para a execu��o da requisi��o (curl_exec)
	curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 40);

	//  CURLOPT_RETURNTRANSFER
	//  TRUE para curl_exec retornar uma string de resultado em caso de sucesso, ao
	//  inv�s de imprimir o resultado na tela. Retorna FALSE se h� problemas na requisi��o
	curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($sessao_curl, CURLOPT_POST, true);
	curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, $paPost );
	
	
	//print_r($sessao_curl);
	
	//echo "HHHHHHHHH<br/>";

	$resultado = curl_exec($sessao_curl);
	
	curl_close($sessao_curl);

	if ($resultado)
	{ //echo "RES:"; print_r($resultado);echo "<br/>"; echo "<br/><br/>";
		return $resultado;
	}
	else
	 {// echo "CURLLLLL:".curl_error($sessao_curl)."<br/><br/>"; 	
	     return curl_error($sessao_curl);
	}
}

// Monta URL de retorno
function ReturnURL()
{
	$pageURL = 'http';

	if ($_SERVER["SERVER_PORT"] == 443) // protocolo https
	{
		$pageURL .= 's';
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80")
	{
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"]. substr($_SERVER["REQUEST_URI"], 0);
	}
	// ALTERNATIVA PARA SERVER_NAME -> HOST_HTTP

	$file = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

	$ReturnURL = str_replace($file, "retorno.php", $pageURL);
	
    $ReturnURL = str_replace('?order', "?orderCIELO",  $pageURL);
	

	return $ReturnURL;
}

?>