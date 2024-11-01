<?

/*
 * barcode.inc
 * Manipula as rotinas para geracao de codigo de barra
 * @author      wlung
 * @since       18/06/2003
 * @version     1.0
 * (C) Opus Comunicação de Dados, 2003.
 */


// valor DATA_BASE para calculo de fator de vencimento
$DATA_BASE_DIA = 7;
$DATA_BASE_MES = 10;
$DATA_BASE_ANO = 1997;

$DATA_BASE_NUM           = 19971007;	//07/10/1997
$DATA_MAX_PERMITIDA_NUM  = 20250221; 	//21/02/2025


// vetor estatico com valores "2" e "1" utilizado para calculo de MODULO 10
$DOIS_UM = array(2,1);

//vetor estatico com valores "2" a "9" utilizado para calculo de MODULO 11
$DOIS_NOVE = array(2,3,4,5,6,7,8,9);

//tabela binario que representa "0" a "9" para codigo de barra
$BINARY_TABLE = array("00110","10001","01001","11000","00101","10100","01100","00011","10010","01010");


/**
 * calcular o digito verificador de campo 1, 2 e 3 utilizando "MODULO 10" e "2 e 1 alternados"<P>
 * Se o resto da divisao for zero o DV sera SERO, caso contrario sera o resultado da subtracao de 10.
 */
function DVCampo ($campo) {
	global $DOIS_UM;
        $soma = 0;
        $tam = strlen($campo);
		$campo = strrev($campo);
	
        for ($i=0; $i<$tam; $i++) {
            $aux = $DOIS_UM[$i%2] * $campo[$i];
            $soma += ($aux>=10)? (floor($aux/10)+$aux%10) : $aux;
        }

		$soma %= 10;
		return ($soma>0)? (10-$soma):0;
}


/**
 * calcular o digito verificador de campo utilizando "MODULO 11" e "2 a 9 alternados"
 */    
function DV_Modulo11($campo) {
        global $DOIS_NOVE;
        $soma = 0;
        $tam = strlen($campo);
        $campo = strrev($campo);

        for ($i=0; $i<$tam; $i++) {
            $soma += $DOIS_NOVE[$i%8] * $campo[$i];
        }
        return (11 - $soma%11);
}


/**
 * Calcular o digito verificador Geral utilizando "MODULO 11" e "2 a 9 alternados"<P>
 * Se o resultado da subtracao for igual a 0, 1 ou maior que 9, deverao assumir o digito igual a 1, 
 * senao, o resultado da subtracao sera o proprio digito.
 */
function DVGeral($campo) {
	$dv = DV_Modulo11($campo);
	return ($dv>9 || $dv <2)? 1:$dv;
}

/**
 * Calcular o digito verificador do código do cedente utilizando "MODULO 11" e "2 a 9 alternados"
 * Se o resultado da subtracao for maior que 9, o DV será '0', caso contrário o resultado será o
 * próprio DV, podendo ser de 1 a 9
 */
function DVCodigoCedente($campo) {
	$dv = DV_Modulo11($campo);
	return ($dv>9)? 0:$dv;
}


/**
 * Calcular o digito verificador do Campo Livre utilizando "MODULO 11" e "2 a 9 alternados"<P>
 * Se o resultado da subtracao for maior que 9, o DV sera ZERO, caso contrario o resultado sera o DV.
 */
function DVCampoLivre($campo) {
	$dv = DV_Modulo11($campo);
	return ($dv>9)?0:$dv;
}


/**
 * Caluclo de fator de vencimento obtido atraves do resultado da subtracao entre data do vencimento
 * do titulo e a DATA BASE, fixado em "07/10/1997).
 */
function fatorVencimento($venc) {
	global $DATA_BASE_MES, $DATA_BASE_DIA, $DATA_BASE_ANO;

	if ($venc=="00/00/0000")
		return "0000";

	$dataBase = mktime(0, 0, 0, $DATA_BASE_MES, $DATA_BASE_DIA, $DATA_BASE_ANO);
	settype($dataBase, "integer");
	$dataBase = ceil ($dataBase/(60*60*24));

	$dataVenc = explode ("/", $venc);
	$diaVenc = mktime(0, 0, 0, $dataVenc[1], $dataVenc[0], $dataVenc[2]);
	settype($diaVenc, "integer");
	$diaVenc = ceil($diaVenc/(60*60*24));

	//return ceil( ($diaVenc - $dataBase)/(60*60*24) );
	return $diaVenc - $dataBase;
}


/**
 * Metodo que retorna um String binario da intercalacao de dois numeros baseando a tabela binario para codigo de barra.
 */
function intercalaCode($code1, $code2) {
	global $BINARY_TABLE;
	$codeBin1 = $BINARY_TABLE[(int)$code1];
	$codeBin2 = $BINARY_TABLE[(int)$code2];

	$codeIntercala = "";

	for ($i=0; $i<strlen($codeBin1); $i++) {
		$codeIntercala .= $codeBin1[$i].$codeBin2[$i];
	}
	return $codeIntercala;
}


/**
 * Obter o codigo de barra em valores binarios.
 */
function getBinaryCode($barcodeFull) {
	$code = (strlen($barcodeFull)%2!=0)? ("0".$barcodeFull):$barcodeFull;
	$binaryCode = "";

	for ($i=0; $i<strlen($code); $i+=2) {
		$binaryCode .= intercalaCode($code[$i], $code[$i+1]);
	}
	return $binaryCode;
}



/** Testar functions **/
//echo "<BR>DVCampo: ".DVCampo("7189000000");
//echo "<BR>Fator Vencimento: ".fatorVencimento("17/06/2002");
//echo "<BR>Modulo 11: ".DV_Modulo11("12345678901234567890");
//echo "<BR>DVGeral: ".DVGeral("12345678901234567890");
//echo "<BR>DVCampoLivre: ".DVCampoLivre("12345678901234567890");
//echo "<BR>IntercalaCode: ".intercalaCode("0","1");
//echo "<BR>getBinaryCode: ".getBinaryCode("0123");


?>