<?

/**
 * Manipula rotinas para salvar as mensagens em arquivos de log.
 * @author      wlung
 * @since       18/06/2003
 * @version     1.0
 * (C) Opus Comunicaзгo de Dados, 2003.
 */

/**
 * Funcao que cria diretorios de forma recursiva
 */
function mkdirs($strPath, $mode)
{
 if (is_dir($strPath)) return true;

 $pStrPath = dirname($strPath);
 if (!mkdirs($pStrPath, $mode)) return false;
return mkdir($strPath, $mode);
}


/**
 * funcao que append o a mensagem de log para arquivo de Log
 */
function printLog() {
   global $nosso_num,$num_doc,$valor,$juros_dia,$multa,$vencimento,$todayDate,$sNome,$sEndereco,
   	$sCidade,$sEstado,$sCEP,$msg_compensacao,$msg_sacado,$log_path,$LOG_FILE_DEFAULT;
     
   //se chegou ate aqui, quer dizer que foi sucesso. Registrar no arquivo de LOG
   $logMessage = $nosso_num . $num_doc . fillWithCharLeft($valor,' ', 13) 
	. fillWithCharLeft($juros_dia."%",' ',10) . fillWithCharLeft($multa."%",' ',10) 
	. $vencimento . $todayDate . fillWithCharRight($sNome,' ',40)
	. fillWithCharRight($sEndereco,' ',40) . fillWithCharRight($sCidade,' ',25)
	. $sEstado . str_replace ("-", "", $sCEP);

   for ($i=0; $i<sizeof($msg_compensacao); $i++)
   	$logMessage .= fillWithCharRight($msg_compensacao[$i]," ",60);
   for ($i=0; $i<sizeof($msg_sacado); $i++)
   	$logMessage .= fillWithCharRight($msg_sacado[$i]," ",70);


//diretorio default onde registra o log do sistema
 $log_path = $_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/wpstore/includes/functions/payment/boleto/caixa/WEB-INF/log/";

//nome default para arquivo de log
$LOG_FILE_DEFAULT = "BoletoWebCaixa.log";




   $fp = fopen ( $log_path.$LOG_FILE_DEFAULT, "a" );
   if (!$fp) error( "Erro: Nгo foi possнvel abrir arquivo de log!" );
   flock ($fp, 2); // lock exclusive
   fputs ($fp, $logMessage."\n");
   flock ($fp, 3); // unlock
   fclose($fp);
}


//criar diretorio de log
if (isset($log_path) && trim($log_path)!="") {
	if (!mkdirs($log_path,0700))
		die ("Erro: Nгo foi possнvel criar diretуrio de log (".$log_path.")");
}
else {
	if (!mkdirs($LOG_PATH_DEFAULT,0700))
		die ("Erro: Nгo foi possнvel criar diretуrio de log (".$LOG_PATH_DEFAULT.")");
	$log_path=$LOG_PATH_DEFAULT;
}

//concatenar "/" no final do nome de diretorio
if ($log_path[strlen($log_path)-1]!="/")
	$log_path .= "/";


?>