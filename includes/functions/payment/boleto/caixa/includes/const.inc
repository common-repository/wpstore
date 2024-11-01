<?

/*
 * const.inc
 * Contém valores constantes usadas em todo o sistema.
 * @author      wlung
 * @since       18/06/2003
 * @version     1.0
 * (C) Opus Comunicação de Dados, 2003.
 */
 

$BANCO = "104";
$BANCO_DV = "0";

$CARTEIRA = "SR";
$COD_CARTEIRA = 1;

$MOEDA = "R$";
$COD_MOEDA = 9;

//diretorio default onde registra o log do sistema
$LOG_PATH_DEFAULT = "./WEB-INF/log/";

//nome default para arquivo de log
$LOG_FILE_DEFAULT = "BoletoWebCaixa.log";

//Constante 1
$TITULO_REGISTRADO = 1;
$TITULO_SEM_REGISTRO = 2;

//Constante 2
$EMISSAO_CLIENTE = 4;

//sigla do estado
$SIGLA_ESTADO = array ("SP", "AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES", "GO",
	   "MA", "MG", "MS", "MT", "PA", "PB", "PE", "PI", "PR", "RJ",
	   "RN", "RO", "RR", "RS", "SC", "SE", "SP", "TO");


?>