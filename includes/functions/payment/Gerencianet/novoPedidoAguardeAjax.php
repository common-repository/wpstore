<?php

$itemXMLPROD = "";
$itemXMLEND = "";


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
   
$txtPrint .= ' ';
	
 
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

      
       $strNew =  str_replace($vowels,"-", $str_utf8 ) ;
        
     
	$beta = intval($item)+1;
	
	$precoFinal = str_replace(array(',','.'),'',$precoFinal);
	
	$itemXMLPROD .=" 	
	    <item>    
		<itemValor>$precoFinal</itemValor>    
		<itemQuantidade>$qtd</itemQuantidade>    
		<itemDescricao>$strNew</itemDescricao>       
	    </item> ";
 
	 
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
  
    $cpf =   trim(get_user_meta($idUser,'userCpf',true));  
    $cnpj =   trim(get_user_meta($idUser,'cnpj',true));                if($cpf==""){
    	$cpf = $cnpj;
    } 

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
 
 
 

$itemXMLEND .=" 	
    <nome>$displayNameUser</nome>
    <cpf>$cpf</cpf>
    <email>$userEmail</email>
    <nascimento></nascimento>
    <celular>$userDDD$userTelefone</celular>
    <logradouro>$userEndereco</logradouro>
    <numero>$userEnderecoNumero</numero>
    <bairro>$userBairro</bairro>
    <cidade>$userCidade</cidade>
    <cep>$userCep</cep>
    <estado>$userEstado</estado>	
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
 
   
 }; //IF TOTALCOMPRA >0  

$valorFreteT  = str_replace(array(',','.'),'',$valorFreteT);

 include('Gerencianet.php');

?>