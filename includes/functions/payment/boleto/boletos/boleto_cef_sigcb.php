<?php

 
if(function_exists('get_header') ){}else{
	require("../../../../../../../../wp-load.php");
};




 
$plugin_directory = str_replace('include/','',plugin_dir_url( __FILE__ ));


 
 
global $wpdb;
/////////////////////INFOS DO PEDIDO///////////////////////


$order = trim($idPedido);
 
$arrOrder = explode('.',$order);
$idUser = 	$arrOrder[0];
        	

$dataPedidoO = $arrOrder[4].'/'.$arrOrder[3].'/'.$arrOrder[2];
$dataPedido = $arrOrder[2].'-'.$arrOrder[3].'-'.$arrOrder[4];
$dataVencimento =  date('d/m/Y', strtotime($dataPedido. ' + 15 days'));
 
	  
$user_info = get_userdata($idUser);

$userLogin =  $user_info->user_login;
$userEmail =  $user_info->user_email;


$displayNameUser="$user_info->user_firstname  $user_info->user_lastname"; 



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
 
$extras = "";
$freteV  = "";
$valorDesconto = "";

$contagemPedido = 0;
foreach ( $fivesdrafts as $fivesdraft ){
	
	$contagemPedido +=1;
    $idPedido = $fivesdraft->id_pedido;
	$valor_total = $fivesdraft->valor_total;    
	//echo $valor_total ."HAHAHHA";
	$frete = $fivesdraft->frete;
 
    $tipo_pagto = $fivesdraft->tipo_pagto;
    $status_pagto = $fivesdraft->status_pagto;
    $comentario_cliente = $fivesdraft->comentario_cliente ;
    $comentario_admin = $fivesdraft->comentario_admin;
    $extras = $fivesdraft->extras;
	
};


if($contagemPedido >0){
	
$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
}

$freteValor  =  explode($moedaCorrente,$frete);
$freteValor  =  floatval(str_replace(')','',$freteValor[1]));


$valorTotalFloat =$valor_total;


if(strlen($valorTotalFloat)>6){
 $valorTotalFloat= str_replace('.','',$valorTotalFloat);
};  
$valorTotalFloat= str_replace(',','.',$valorTotalFloat);//CENTAVOS CIELO

//$valorTotalFloat +=$freteValor;


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
 
 
//echo $valorDesconto."sss";
//$valor_total = number_format($valorTotalFloat ,2,',','.');

$valorDesconto +=$freteValor;	
$valor_total =  number_format($valorDesconto ,2,',','');	 
 
  //echo $valor_total."sss";
	 
 
 
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

 
 
$vencimento =  $dataVencimento; // 15 dias corridos após a data de emissão.


$orderN = str_replace('.','',$order);

$nosso_num  =  substr($orderN,0, 9); //numerico até 15 digitos

$num_doc    = substr($orderN,  -8);  //numerico até 15 digitos


 
 
// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 5;
$taxa_boleto = 0;


//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";

$data_venc = $vencimento;

//echo $valor_total."sss";
$valor_cobrado = $valor_total; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal



$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');



// Composição Nosso Numero - CEF SIGCB

$dadosboleto["nosso_numero1"] = "000"; // tamanho 3
$dadosboleto["nosso_numero_const1"] = "2"; //constanto 1 , 1=registrada , 2=sem registro
$dadosboleto["nosso_numero2"] = "000"; // tamanho 3
$dadosboleto["nosso_numero_const2"] = "4"; //constanto 2 , 4=emitido pelo proprio cliente
$dadosboleto["nosso_numero3"] =$nosso_num; // tamanho 9


$dadosboleto["numero_documento"] =  $order;	// Num do pedido ou do documento

$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA

$dadosboleto["data_documento"] = $dataPedidoO; // Data de emissão do Boleto
$dadosboleto["data_processamento"] = $dataPedidoO; // Data de processamento do boleto (opcional)

$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula



 
$sNome      = trim($displayNameUser); //$displayNameUser; //alfanumerico até 40 digitos
$sEndereco  = $userEndereco;//alfanumerico até 40 digitos
//$userEnderecoNumero
$sCEP       =  $userCep; //alfanumerico até 40 digitos - 99999-999
$sCidade    =   $userCidade; //texto 25 caracteres
$sEstado    =   $userEstado; //UF


// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $sNome ;
$dadosboleto["endereco1"] =$sEndereco." ".$userEnderecoNumero;
$dadosboleto["endereco2"] = $sCidade." ".$sEstado." ".$sCEP ;




// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "".get_bloginfo('name');
$dadosboleto["demonstrativo2"] = "Pedido : ".$order."<br> - Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
$dadosboleto["demonstrativo3"] = "".get_bloginfo('url');


$telContato1 = get_option('telContato1'); 
$horarioAtendimento = get_option('horarioAtendimento'); 
 
// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = "- Sr. Caixa, ";
$dadosboleto["instrucoes2"] = "-Não receber após o vencimento.";
$emailAdmin =  get_option('emailAdminWPSHOP');
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas ";
$dadosboleto["instrucoes4"] = "".get_bloginfo('url');




// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //



$caixaCedenteCodigo= get_option('caixaCedenteCodigo'); 
$caixaCedenteAgencia= get_option('caixaCedenteAgencia'); 
$caixaCedenteDigito= get_option('caixaCedenteDigito'); 
$caixaCedenteConta= get_option('caixaCedenteConta'); 
$caixaCedenteCNPJ= get_option('caixaCedenteCNPJ'); 

// DADOS DA SUA CONTA - CEF
$dadosboleto["agencia"] = "$caixaCedenteAgencia"; // Num da agencia, sem digito
$dadosboleto["conta"] = "$caixaCedenteConta"; 	// Num da conta, sem digito
$dadosboleto["conta_dv"] = "$caixaCedenteDigito"; 	// Digito do Num da conta

// DADOS PERSONALIZADOS - CEF
$dadosboleto["conta_cedente"] = "$caixaCedenteCodigo"; // Código Cedente do Cliente, com 6 digitos (Somente Números)
$dadosboleto["carteira"] = "SR";  // Código da Carteira: pode ser SR (Sem Registro) ou CR (Com Registro) - (Confirmar com gerente qual usar)

$caixaCedenteNome = "".get_option('caixaCedenteNome'); 
// SEUS DADOS
$dadosboleto["identificacao"] = $caixaCedenteNome;


   $ruaEndereco  = get_option('ruaEndereco');
   $cepEndereco  = get_option('cepEndereco');   
   $enderecoEndereco  = get_option('enderecoEndereco'); 
   
   
$dadosboleto["cpf_cnpj"] = "$caixaCedenteCNPJ";
$dadosboleto["endereco"] = "$enderecoEndereco";
$dadosboleto["cidade_uf"] = "$ruaEndereco $cepEndereco";

$caixaCedenteNome= get_option('caixaCedenteNome'); 
$dadosboleto["cedente"] = "$caixaCedenteNome";

// NÃO ALTERAR!
include("include/funcoes_cef_sigcb.php"); 
include("include/layout_cef.php");

}else{
echo "erro - chame o ariate";	
};
?>
