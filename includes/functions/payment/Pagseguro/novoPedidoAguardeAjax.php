<?php
$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
}
 

 $codigoAnalytics =  get_option('codigoAnalytics'); 

$emailVendedor =  get_option('emailPagseguro');

$idPedido = $pedidoID;

  $pesoTotal = 0;
  

      $msg = "";
       
      $totalCompra =    $valor;
    
      if(intval($totalCompra)>0){
   
   
   $extras = $taxasExtras;
	 
	 if(floatval($desconto)>0){
		 $extras = $desconto;
		 $extras = "-$extras";
	 }
   
$txtPrint .= '
      <form  id="fpagseguro" name="pagseguro"   action="https://pagseguro.uol.com.br/security/webpagamentos/webpagto.aspx" method="post" target="_self">
	  <input type="hidden" name="email_cobranca" value="'.$emailVendedor.'"  />
	  <input type="hidden" name="encoding" value="UTF-8"  />
	
	  <input type="hidden" name="ref_transacao" value="'.$idPedido.'"  />
	  <input type="hidden" name="extras" value="'.$extras.'"  />
	  <input type="hidden" name="extraAmount" value="'.$extras.'"  />
	  <input type="hidden" name="tipo" value="CP"  />
	  <input type="hidden" name="moeda" value="BRL"  />
 ';
	
 
// Incluindo o arquivo da biblioteca 	 Outras Informações
//include('pgs.php');

// Criando um novo carrinho
/*
$pgs=new pgs(array(
  'email_cobranca'=>''.$emailVendedor.'',
  'encoding'=>'UTF-8',
  'tipo_frete'=>''.$tipoFrete.'',
  'ref_transacao'=>'Id do Pedido:'.$idPedido.'',
  'extras'=>''.$extras.''


));
 */

 $Array[] = array();        



    $tabela = $wpdb->prefix."";
    $tabela .=  "wpstore_orders_products";
    
    $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$idPedido' ORDER BY `id`  ASC  "  ,1,'') );
 
    // Adicionando PRODUTOS
 
    foreach ( $fivesdrafts as $item=>$fivesdraft ){
        
       
        
        $idPedido = $fivesdraft->id_pedido;
        $idProduto = $fivesdraft->id_produto;
     
        
        $vowels = array(",");
       
        $preco = $fivesdraft->preco;
        $preco = str_replace(".","", $preco);
        $preco = str_replace($vowels,".", $preco);
        $preco = floatval($preco);
        $qtd = $fivesdraft->qtdProd;
        $qtd = floatval($qtd);
        $variacao = $fivesdraft->variacao;
        $precoAlt = $fivesdraft->precoAlt; 	
        $precoAlt = str_replace($vowels,".", $precoAlt);
        $precoAlt = floatval($precoAlt);
        $precoAltSymb= $fivesdraft->precoAltSymb; 
        
         $valorFreteT = str_replace($vowels,".", $valorFreteT );
        $valorFreteT  = floatval( $valorFreteT );
        
        $valorFreteT= number_format( $valorFreteT, 2, '.', '');
        
        $precoFinal =  $preco + $precoAlt;
        if($precoAltSymb=="-"){
        $precoFinal =  $preco - $precoAlt;    
        }
        
        $totalCompra +=$precoFinal;
 
        $precoFinal = number_format($precoFinal, 2, '.', '');
   
      $var = str_replace($vowels,".", get_post_meta($idProduto,'weight',true)) ;
      $peso = floatval($var);
 
      $pesoTotal += $peso;
	   
      $str_utf8 = get_the_title($idProduto)." - ".$variacao." | Pedido : $idPedido";    
      
      //tirar os acentos de uma string! pode ser adaptadas para outras coisas

       $a = array(
       '[ÂÀÁÄÃ]'=>'A',
       '/[âãàáä]/'=>'a',
       '/[ÊÈÉË]/'=>'E',
       '/[êèéë]/'=>'e',
       '/[ÎÍÌÏ]/'=>'I',
       '/[îíìï]/'=>'i',
       '/[ÔÕÒÓÖ]/'=>'O',
       '/[ôõòóö]/'=>'o',
       '/[ÛÙÚÜ]/'=>'U',
       '/[ûúùü]/'=>'u',
       '/ç/'=>'c',
       '/Ç/'=> 'C');

       //$strNew = preg_replace(array_keys($a), array_values($a), $str_utf8 );
       $strNew =  str_replace($vowels,"-", $str_utf8 ) ;
        
            /*
        // Adicionando um produto
	    $pgs->adicionar(array(
	     array(
	    "descricao"=>"".$strNew."",
	    "valor"=>"".$precoFinal."",
	    "peso"=>"$peso",
	    "quantidade"=>$qtd,
	    "id"=>"".$idProduto."",
	    "frete"=>"".$valorFrete."",
	    ),
	    ));
              */
 
		$beta = intval($item)+1;
	
	$txtPrint .=  '
 
		<input type="hidden" name="item_id_'.$beta .'" value="'.$idProduto.'">
		<input type="hidden" name="item_descr_'.$beta .'" value="'. $strNew.'">
		<input type="hidden" name="item_quant_'.$beta .'" value="'.$qtd.'">
		<input type="hidden" name="item_frete_'.$beta .'" value="'.$valorFreteT.'">
		<input type="hidden" name="item_valor_'.$beta .'" value="'.$precoFinal.'">
		<input type="hidden" name="item_peso_'.$$beta .'" value="'.$peso.'">

	';
	
	
	
	   $produtosCheck .= " _gaq.push(['_addItem',
            '$idPedido',           // order ID - required
            '".$idProduto."',           // SKU/code - required
            '".$strNew."',        // product name
            '".$peso."',   // category or variation
            '".$precoFinal."',          // unit price - required
            '".$qtd."'               // quantity - required
          ]); ";
 
	
	
	
	
	
	$freteV = 0;    
	 
}; //End If Pagseguro Add
   

 



    $tabela = $wpdb->prefix."";
   $tabela .=  "wpstore_orders_address";

   $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$idPedido' ORDER BY `id`  ASC  " ,1,'' ) );

   // Adicionando PRODUTOS

   foreach ( $fivesdrafts as $item=>$fivesdraft ){
    
   
 
    $userEndereco = $fivesdraft->endereco;
    $userEnderecoNumero = $fivesdraft->numero;
    $userComplemento = $fivesdraft->complemento;
    $userCidade = $fivesdraft->cidade;
    $userBairro = $fivesdraft->bairro;
    $userEstado = $fivesdraft->estado;
    $userCep = $fivesdraft->cep;
    
    
    
    global $current_user;
    
    get_currentuserinfo();
    
    $idUser = $current_user->ID;
    $userLogin = $current_user->user_login;
    $userEmail = $current_user->user_email;
  
  

    $displayNameUser = trim("$current_user->user_firstname $current_user->user_lastname"); 
    if($displayNameUser ==""){$displayNameUser=$userLogin;};

    $userPais = trim(get_user_meta($idUser,'userPais',true));if($userPais==""){$userPais="Brasil";};
    $userDDD = trim(get_user_meta($idUser,'userDDD',true));if($userDDD==""){$userDDD="";};
    $userTelefone = trim(get_user_meta($idUser,'userTelefone',true));if($userTelefone==""){$userTelefone="";};
    
    $displayNameUser  = utf8_decode(trim(htmlentities(stripslashes($displayNameUser), ENT_QUOTES,'utf-8')));              
 
//echo"Usuário:$nome";      
    /*
$pgs->cliente(
  array (
   'nome'   => ''.$displayNameUser.'', 
   'cep'    => ''.$userCep.'',   
   'end'    => ''.$userEndereco.'',
   'num'    => ''.$userEnderecoNumero.'',
   'compl'  => ''.$userComplemento.'',
   'bairro' => ''.$userBairro.'',
   'cidade' => ''.$userCidade.'',
   'uf'     => ''.$userEstado.'',
   'pais'   => ''.$userPais.'',
   'ddd'    => ''.$userDDD.'',
   'tel'    => ''.$userTelefone.'',
   'email'  => ''.$userEmail.''
  )
);  
   */
$cidade = $userCidade;
$estado = $userEstado;

 
 
// Mostrando o botão de pagamento
//$pgs->mostra();
 
 

 $txtPrint .= "
	  <input type='hidden' name='cliente_nome' value='$displayNameUser'  />
      <input type='hidden' name='cliente_cep' value='$userCep'  />
	  <input type='hidden' name='cliente_end' value='$userEndereco'  />
	  <input type='hidden' name='cliente_num' value='$userEnderecoNumero'  />
	  <input type='hidden' name='cliente_compl' value='$userComplemento'  />
	  <input type='hidden' name='cliente_bairro' value='$userBairro'  />
	  <input type='hidden' name='cliente_cidade' value='$userCidade' />
	  <input type='hidden' name='cliente_uf' value='$userEstado'  />
	  <input type='hidden' name='cliente_pais' value='$userPais'  />
	  <input type='hidden' name='cliente_ddd' value='$userDDD'  />
      <input type='hidden' name='cliente_tel' value='$userTelefone'   />
	  <input type='hidden' name='cliente_email' value='$userEmail'   />
	";  
	
	
};




if(trim($tipoFreteR)=="SEDEX"){	
$tipoFreteR="SD";
}elseif(trim($tipoFreteR)=="PAC"){
$tipoFreteR="EN";	
}else{
$tipoFreteR="";
}

if($pesoTotal>=30){
	$tipoFreteR="";
}

$txtPrint .= '<input type="hidden" name="tipo_frete" value="'.$tipoFreteR.'"  />';

  
$linkImgPagseguro = "https://p.simg.uol.com.br/out/pagseguro/i/botoes/carrinhoproprio/btnFinalizaBR.jpg";  
       
$txtPrint .= " <center> <input type='image' id='fpagsegurobt' src='$linkImgPagseguro'  name='submit' alt='Pague com o PagSeguro - &eacute; r&aacute;pido, gr&aacute;tis e seguro!' /></form>



    		<div class='clearfix container_message'>
           <br/>
           <center><h4 class='head2'>Pedido Finalizado . Para concluir clique no botão acima  e efetue o pagamento via Pagseguro.</h4></center>

    <center>				
             </div>



";


 }; //IF TOTALCOMPRA >0  

  

?>