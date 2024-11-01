<?php

if(function_exists('get_header') ){}else{
	require("../../../../../../../../wp-load.php");
};

global $wpdb;
/////////////////////INFOS DO PEDIDO///////////////////////


$order = trim($idPedido);

 
$arrOrder = explode('.',$order);
$idUser = 	$arrOrder[0];
        	

$dataPedido = $arrOrder[2].'-'.$arrOrder[3].'-'.$arrOrder[4];
$dataVencimento =  date('d/m/Y', strtotime($dataPedido. ' + 15 days'));
 
	  
$user_info = get_userdata($idUser);

$userLogin =  $user_info->user_login;
$userEmail =  $user_info->user_email;


$displayNameUser="$user_info->user_firstname  $user_info->user_lastname"; 

 

$plugin_directory = str_replace('layout/','payment/',plugin_dir_url( __FILE__ ));



$tabela = $wpdb->prefix."";
$tabela .=  "wpstore_orders";

$fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_pedido`='$order'  AND `id_usuario`='$idUser' ORDER BY `id`  DESC LIMIT 0,1" ,1,'') );
 
$tipo_pagto = ""; 
$status_pagto = "";
$comentario_admin ="";
$valor_total = 0.00;
$frete  = "";



$pct = "";
$desconto = "";
$valorDeconto = "";

$extras = "";
$freteV  = "";
foreach ( $fivesdrafts as $fivesdraft ){
	
    $idPedido = $fivesdraft->id_pedido;
	$valor_total = $fivesdraft->valor_total;    
  
	$frete = $fivesdraft->frete;

	
    $tipo_pagto = $fivesdraft->tipo_pagto;
    $status_pagto = $fivesdraft->status_pagto;
    $comentario_cliente = $fivesdraft->comentario_cliente ;
    $comentario_admin = $fivesdraft->comentario_admin;
    $extras = $fivesdraft->extras;

	
};

$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
}

$freteValor  =  explode($moedaCorrente,$frete);
$freteValor  =  floatval(str_replace(')','',$freteValor[1]));


$valorTotalFloat =$valor_total;
$valorDesconto = "";

if(strlen($valorTotalFloat)>6){
 $valorTotalFloat= str_replace('.','',$valorTotalFloat);
};  
$valorTotalFloat= str_replace(',','.',$valorTotalFloat);//CENTAVOS CIELO

$valorTotalFloat +=$freteValor;


$extraInfo= $extras;
$pos = strpos($extraInfo,"DESC-");
if($pos === false) {
    $extras = floatval( $extraInfo);
	 $valorDesconto = 0;
}else{
	$extras = "";
    $pct = intval(str_replace('DESC-','', $extraInfo));

      $precoSoma =$valorTotalFloat;   
      $desconto =   floatval(number_format($precoSoma *$pct / 100,2,'.',''));
      $valorDesconto =  $precoSoma - $desconto;
};
 
 
 
//$valor_total = number_format($valorTotalFloat ,2,',','.');	
$valor_total =  number_format($valorDesconto ,2,',','.');	 
 
  
	 
 
 
$userCep = "";
$userEndereco = "";
$userEnderecoNumero ="";
//$address->complemento 
$userBairro = "";
$userCidade = "";
$userEstado = "";

$idCob = get_id_addr_cobranca($idUser,$order); 

$userAddress = get_user_address_by_id($idCob);  


if( empty($userAddress) ){
 //pegar endereco de entrega
 $tabela = $wpdb->prefix."";
 $tabela .=  "wpstore_orders_address";
 $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$order' ORDER BY `id`  ASC  ",1,'' ) );
  // Adicionando PRODUTOS
  foreach ( $fivesdrafts as $item=>$fivesdraft ){
  $userEndereco = $fivesdraft->endereco;
  $userEnderecoNumero = $fivesdraft->numero;
  $userComplemento = $fivesdraft->complemento;
  $userCidade = $fivesdraft->cidade;
  $userBairro = $fivesdraft->bairro;
  $userEstado = $fivesdraft->estado;
  $userCep = $fivesdraft->cep;
  };
}else{
	

	foreach ( $userAddress as $address ){  
    
	      $userCep = $address->cep;
		  $userEndereco = $address->endereco;
		  $userEnderecoNumero =$address->numero;
		  //$address->complemento 
		  $userBairro = $address->bairro;
		  $userCidade = $address->cidade;
		  $userEstado = $address->estado;
	  
	};  
	
	
}







$log_path= "";
# campo opcional - URL do logomarca da empresa
$url_logomarca="";



$caixaCedenteNome= get_option('caixaCedenteNome'); 
$caixaCedenteCodigo= get_option('caixaCedenteCodigo'); 
$caixaCedenteAgencia= get_option('caixaCedenteAgencia'); 

# codigo de cedente (tamanho 6 - numerico)
$cod_cedente= $caixaCedenteCodigo;
# agencia de vinculacao (tamanho 4 - numerico)
$agencia_vinculacao= $caixaCedenteAgencia;
# nome do cedente (tamanho 40 - alfanumerico)
$nome_cedente= $caixaCedenteNome;


# campo opcional - multa padrao (valor em forma de porcentagem)
$multa="";
# campo opcional - juros ao dia (valor em forma de porcentagem)
$juros_dia="";
# campo opcional - mensagem padrao recibo do sacado (10 campos de 70 caracteres cada)
$msg_sacado1 = get_bloginfo('url')."";
$msg_sacado2 ="Pagamento de Boleto bancário";
$msg_sacado3 ="Pedido:".$order;
$msg_sacado4 ="";
$msg_sacado5 ="";
$msg_sacado6 ="";
$msg_sacado7 ="";
$msg_sacado8 ="";
$msg_sacado9 ="";
$msg_sacado10="";

 
$sNome      = trim($displayNameUser); //$displayNameUser; //alfanumerico até 40 digitos
$sEndereco  = $userEndereco;//alfanumerico até 40 digitos
//$userEnderecoNumero
$sCEP       =  $userCep; //alfanumerico até 40 digitos - 99999-999
$sCidade    =   $userCidade; //texto 25 caracteres
$sEstado    =   $userEstado; //UF

 
 
$vencimento =  $dataVencimento; // 15 dias corridos após a data de emissão.


$orderN = str_replace('.','',$order);

$nosso_num  =  substr($orderN,0, 15); //numerico até 15 digitos

$num_doc    = substr($orderN,  -8);  //numerico até 15 digitos


 
$valor      =  $valor_total; //Campo numérico com até 10 dígitos no formato “##.###.##9,99”

$msg_compensacao = array(
	'Sr. Caixa, Não receber após o vencimento',
	"Pedido Ref : $order",
	'Obrigado por comprar em nossa loja',
	'https://cfcrehospitalar.com.br');
			 
			 
			 
			 
			 


//////////////////////////////////////////////////
 

include('includes/barcode.inc');


include('includes/dados.inc');


include('includes/log.inc');



// obter data da emissao do boleto ou data de hoje
$todayDate = date("d/m/Y", time());

$fatorVenc_Valor = fillWithCharLeft(fatorVencimento($vencimento),'0',4) . fillWithCharLeft(stripNotNumber($valor), '0', 10);

$impressao_agencia_cod_cedente = $agencia_vinculacao . "/" . $cod_cedente . "-" . DVCampoLivre($cod_cedente);

/** montar composicao do codigo de barra **/

$nosso_num_seq1 = substr($nosso_num, 0, 3);
$nosso_num_seq2 = substr($nosso_num, 3, 3);
$nosso_num_seq3 = substr($nosso_num, 6);

$nosso_numero_formatado = $nosso_num_seq1.$TITULO_SEM_REGISTRO.$nosso_num_seq2.$EMISSAO_CLIENTE.$nosso_num_seq3;
$impressao_nossoNum = $TITULO_SEM_REGISTRO.$EMISSAO_CLIENTE.$nosso_num_seq1.$nosso_num_seq2.$nosso_num_seq3 . "-" . 
DVCodigoCedente($TITULO_SEM_REGISTRO.$EMISSAO_CLIENTE.$nosso_num_seq1.$nosso_num_seq2.$nosso_num_seq3);
$dv_cod_cedente = DVCodigoCedente($cod_cedente);


$nosso_numero_formatado .= DVCampoLivre($cod_cedente.$dv_cod_cedente.$nosso_numero_formatado);

$barcodeComp = $BANCO.$COD_MOEDA.$fatorVenc_Valor.$cod_cedente.$dv_cod_cedente.$nosso_numero_formatado;

if (!isNUM($barcodeComp)) {
    die("ERRO: 1602".$barcodeComp);
}

$DVGeral = DVGeral($barcodeComp);
$barcodeComp = substr($barcodeComp,0,4).$DVGeral.substr($barcodeComp,4);
/** fim da montagem da composicao do codigo de barra **/

/** montar codigo de barra em representacao numerico  **/
$barcodeNum = "";

$campo_livre = $cod_cedente.$dv_cod_cedente.$nosso_numero_formatado;

// campo1
$campo = $BANCO . $COD_MOEDA . substr($campo_livre,0,5);
$campo .= DVCampo($campo);   // digito verificador
$barcodeNum .= substr($campo,0,5) . "." . substr($campo,5) . " ";

// campo2
$campo = substr($campo_livre,5,10);
$campo .= DVCampo($campo);    // digito verificador
$barcodeNum .= substr($campo,0,5) . "." . substr($campo,5) . " ";


//campo3
$campo = substr($campo_livre,15);
$campo .= DVCampo($campo);
$barcodeNum .= substr($campo,0,5) . "." . substr($campo,5) . " ";

// campo4
$barcodeNum .= $DVGeral . " ";

//campo5
$barcodeNum .= $fatorVenc_Valor;
/** fim da montagem de codigo de barra numerico**/

//se chegou ate aqui, quer dizer que foi sucesso. Registrar no arquivo de LOG
printLog();


$pathCaixa = get_bloginfo('url')."/wp-content/plugins/wpstore/includes/functions/payment/boleto/caixa/";
 
 
?>
<HTML>
<HEAD>
<TITLE>Boleto Web Caixa</TITLE>
	<!--<meta http-equiv=Content-Type content="text/html; charset=iso-8859-1">-->

	<meta charset="UTF-8" />
	<!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> -->
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	
<script>var todayDateServidor = "<?=todayDate?>";</script>
<script language=JavaScript type=text/javascript src='<?php echo  $pathCaixa; ?>js/janela.js'></script>
<script language=JavaScript type=text/javascript src='<?php echo  $pathCaixa; ?>js/barcode.js'></script>
<link rel=stylesheet href="<?php echo  $pathCaixa; ?>/css/boleto.css">
<link rel=stylesheet href="<?php echo  $pathCaixa; ?>/css/barcode.css">
<script language="JavaScript">
	var BARCODE_IMG=showBarcodeImage("<?=getBinaryCode($barcodeComp)?>");
</script>
</HEAD>

<?php
$pathCaixaB = get_bloginfo('url')."/wp-content/plugins/wpstore/includes/functions/payment/boleto/caixa";
?>

<body topmargin=3 rightmargin=10 bgcolor='#FFFFFF' text='#000000' onLoad="javascript:abrirJanela('<?php echo get_permalink(get_idPaginaBoleto()); ?>/?aviso=true','500','520','0')">
<?

echo "<img src='$url_logomarca' width='50' />";
if (isset($url_logomarca) && trim($url_logomarca)!="")
	$strExt = strtolower(substr($url_logomarca, strrpos($url_logomarca, ".")));

	if ( $strExt == ".jpg" || $strExt == ".jpeg" || $strExt == ".gif")
	    print "<img src=\"".$url_logomarca."\">\n";

?>
<table border=0 cellPadding=0 cellSpacing=0 width='100%'>
<?
	for ($i=0; $i<sizeof($msg_sacado); $i++)
		if (isset($msg_sacado[$i])) print "<tr><td nowrap class=cellBody>".$msg_sacado[$i]."</td></tr>\n";
?>
</table><BR>
<center>
<table border=0 cellPadding=0 cellSpacing=0 width='100%'>
	<tr>
		<td class=numBanco><img border=0 src=<?php echo  $pathCaixa; ?>images/cef.gif> | <?=$BANCO?>-<?=$BANCO_DV?> |</td>
		<td class=ipte width='*'>Recibo do Sacado</td>
	</tr>
</table>
<table border=1 cellPadding=0 cellSpacing=0 width='100%'>
	<tr class=cellTitle>
		<td width='25%'>Vencimento<br><div align=center><span class=cellBodyD><? if ($vencimento!="00/00/0000") print $vencimento; ?></span></div></td>
		<td colspan=3>Cedente<br><span class=cellBody>&nbsp;<?=$nome_cedente?></span></td>
	</tr>
	<tr class=cellTitle>
		<td width='25%'>(=) Valor do Documento<br><div align=center><span class=cellBodyD><?=$valor?></span></div></td>
		<td width='25%'>Ag&ecirc;ncia/C&oacute;digo do Cedente<br><span class=cellBody>&nbsp;<?=$impressao_agencia_cod_cedente?></span></td>
		<td width='25%'>N&uacute;mero do Documento<br><span class=cellBody>&nbsp;<?=$num_doc?></span></td>
		<td width='25%'>Nosso N&uacute;mero/C&oacute;digo Documento<br><span class=cellBody>&nbsp;<?=$impressao_nossoNum?></span></td>
	</tr>
</table>
<table border=0 cellPadding=0 cellSpacing=0 width='100%'>
	<tr class=cellTitle>

      <td width=30 height="19">Sacado</td>
      <td class=cellBody><?=$sNome?></td>
		<td align=right nowrap>------------------------ Autentica&ccedil;&atilde;o Mec&acirc;nica ------------------------</td>
	</tr>
	<tr class=cellBody><td>&nbsp;</td><td colSpan=2><?=$sEndereco?></td></tr>
	<tr class=cellBody><td>&nbsp;</td><td colSpan=2><?=$sCEP?>&nbsp;<?=$sCidade?> - <?=$sEstado?></td></tr>
	<tr class=cellTitle><td colspan=3  valign="bottom" height="19">Sacador/Avalista</td></tr>
</table>

<hr class=divisor noshade size=1>

<table border=0 cellPadding=0 cellSpacing=0 width='100%'>
	<tr>
		<td class=numBanco nowrap><img border=0 src=<?php echo  $pathCaixa; ?>images/cef.gif> | <?=$BANCO?>-<?=$BANCO_DV?> |</td>
		<td class=ipte nowrap><?=$barcodeNum?></td>
	</tr>
</table>
<table border=1 cellPadding=0 cellSpacing=0 width='100%'>
	<tr class=cellTitle>
		<td colSpan=5 width=500>Local de Pagamento<br><span class=cellBody>&nbsp;Preferencialmente nas Casas Lot&eacute;ricas at&eacute; o valor limite</span></td>
		<td width=170>Vencimento<br><div align=right><span class=cellBodyD><?=($vencimento==("00/00/0000")?"":$vencimento)?></span></div></td>
	</tr>
	<tr class=cellTitle>
		<td colspan=5 width=500>Cedente<br><span class=cellBody>&nbsp;<?=$nome_cedente?></span></td>
		<td width=170>Ag&ecirc;ncia/C&oacute;digo do Cedente<br><div align=right><span class=cellBody><?=$impressao_agencia_cod_cedente?></span></div></td>
	</tr>
	<tr class=cellTitle>
		<td width=85>Data de Emiss&atilde;o<br><span class=cellBody>&nbsp;<?=$todayDate?></span></td>
		<td width=115>N&uacute;mero do Documento<br><span class=cellBody>&nbsp;<?=$num_doc?></span></td>
		<td width=110>Esp&eacute;cie Doc<br><span class=cellBody>&nbsp;&nbsp;</span></td>
		<td width=70>Aceite<br><span class=cellBody>&nbsp;</span></td>
		<td width=120>Data do Processamento<br><span class=cellBody>&nbsp;<?=$todayDate?></span></td>
		<td width=170 nowrap>Nosso N&uacute;mero/C&oacute;digo Documento<br><div align=right><span class=cellBody><?=$impressao_nossoNum?></span></div></td>
	</tr>
	<tr class=cellTitle>
		<td width=85>Uso do Banco<br><span class=cellBody>&nbsp;&nbsp;</span></td>
		<td width=115>Carteira<br><span class=cellBody>&nbsp;<?=$CARTEIRA?></span></td>
		<td width=110>Esp&eacute;cie<br><span class=cellBody>&nbsp;<?=$MOEDA?><br></span></td>
		<td width=70>Quantidade<br><span class=cellBody>&nbsp;&nbsp;</span></td>
		<td width=110>Valor<br><span class=cellBody>&nbsp;</span></td>
		<td width=170>(=) Valor do Documento<br><div align=right><span class=cellBodyD><?=$valor?></span></div></td>
	</tr>
	<tr class=cellTitle>
		<td colSpan=5 rowSpan=5>Instru&ccedil;&otilde;es - Texto de responsabilidade do cedente<br>
        <span class=cellBody>
        <?  $BR_TAG="";
			for ($i=0; $i<sizeof($msg_compensacao); $i++) {
				if (!trim($msg_compensacao[$i])=="")
						print "&nbsp;".trim($msg_compensacao[$i])."<br>";
				else $BR_TAG .= "<BR>";
			}
            print $BR_TAG;
	?>
        <br>
        <? $msg_multa_juros = "";
            if (!trim($multa)=="")
                    $msg_multa_juros .= "multa de ".$multa."%";
            if (!trim($juros_dia)=="") {
                    $msg_multa_juros .= ((trim($msg_multa_juros)=="")? "":" e ") . "juros de " . $juros_dia . "%";
            }
            if (!trim($msg_multa_juros=="")) {
                    print "&nbsp;Após o vencimento cobrar ".$msg_multa_juros." ao dia.";
            } else print "&nbsp;";
	?>
        </span>
        <p><span class=cellTitleB>Unidade Cedente: <?=$agencia_vinculacao?></span>
		</td>
      <td width=170>(-) Desconto/Abatimento<br>&nbsp;</td>
	</tr>
	<tr><td class=cellTitle width=170>(-) Outras Dedu&ccedil;&otilde;es<br>&nbsp;</td></tr>
	<tr><td class=cellTitle width=170>(+) Mora/Multa<br>&nbsp;</td></tr>
	<tr><td class=cellTitle width=170>(+) Outros Acr&eacute;cimos<br>&nbsp;</td></tr>
	<tr><td class=cellTitle width=170>(=) Valor Cobrado<br>&nbsp;</td></tr>
	<tr>
		<td colspan=7 width='100%'>
			<table border=0 cellPadding=0 cellSpacing=0 width='100%'>
				<tr><td class=cellTitle width=20 height=19>Sacado</td><td class=cellBody><?=$sNome?></td></tr>
				<tr class=cellBody><td>&nbsp;</td><td ><?=$sEndereco?></td></tr>
				<tr class=cellBody><td>&nbsp;</td><td ><?=$sCEP?>&nbsp;<?=$sCidade?> - <?=$sEstado?></td></tr>
			</table>
			<table border=0 cellPadding=0 cellSpacing=0 width='100%'>
				<tr class=cellTitleB>
					<td height="19" valign="bottom">Sacador/Avalista</td>
					<td align="left" width=170>C&oacute;digo de Baixa&nbsp;&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</center>
<table border=0 cellPadding=0 cellSpacing=0 width='100%'>
	<tr><td class=cellTitle><div align=right>Autentica&ccedil;&atilde;o Mec&acirc;nica&nbsp; - Ficha de Compensa&ccedil;&atilde;o</div></td></tr>
</table>
<table width='100%' border=0>
	<tr>
		<td width=20>&nbsp;</td>
		<td><script>document.write(BARCODE_IMG);</script></td>
	</tr>
</table>
<hr class=divisor noshade size=1>
</body>
</html>
