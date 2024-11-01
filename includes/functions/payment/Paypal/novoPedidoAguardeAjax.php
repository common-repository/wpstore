<?php


$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
}

 
 
$idPedido = $pedidoID;           

$plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));
$imgTopo = "";
 
 
if($tipoFrete=="SEDEX"){	
$frete="SD";
}elseif($tipoFrete=="PAC"){
$frete="EN";	
};  

 
global $current_user;

get_currentuserinfo();

$idUser = $current_user->ID;
$userLogin = $current_user->user_login;
$userEmail = $current_user->user_email;



$userEndereco = "";
$userEnderecoNumero = ""; 
$userComplemento = ""; 
$userCidade = ""; 
$userBairro = ""; 
$userEstado = ""; 
$userCep = "";
$userPais = "";  
$userDDD = "";  
$userTelefone = "";  
$displayNameUser  = "";
$frete = "";              
 







$totalCompra = 0;
 
 
$Array[] = array();        
 
    $tabela = $wpdb->prefix."";
    $tabela .=  "wpstore_orders_products";
    
    $fivesdraftCs = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$idPedido' ORDER BY `id`  ASC  "  ,1,'') );
 
    // Adicionando PRODUTOS 
    
    $countPrd = 1;
    $inputsProdutos = "";
    foreach ( $fivesdraftCs as $item=>$fivesdraftC ){
         
        $idPedido = $fivesdraftC->id_pedido;
        $idProduto = $fivesdraftC->id_produto;
     
        
        $vowels = array(",");
       
        $preco = $fivesdraftC->preco;
        $preco = str_replace(".","", $preco);
        $preco = str_replace($vowels,".", $preco);
        $preco = floatval($preco); 
        
        $qtd = $fivesdraftC->qtdProd;
        $qtd = floatval($qtd);
        $variacao = $fivesdraftC->variacao;  
        
        $precoAlt = $fivesdraftC->precoAlt; 	
        $precoAlt = str_replace($vowels,".", $precoAlt);
        $precoAlt = floatval($precoAlt);
        $precoAltSymb= $fivesdraftC->precoAltSymb; 
        
        $frete = str_replace($vowels,".", $frete );
        $frete  = floatval($frete );
        
        $precoFinal =  $preco + $precoAlt;
        if($precoAltSymb=="-"){
        $precoFinal =  $preco - $precoAlt;    
        }
        
        $totalCompra +=$precoFinal;
 
   
      $var = str_replace($vowels,".", get_post_meta($idProduto,'weight',true)) ;
      $peso = floatval($var);
 
      
      $str_utf8 = get_the_title($idProduto)." - ".$variacao."";    
      
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
        
 
	   $produtosCheck .= " _gaq.push(['_addItem',
            '$idPedido',           // order ID - required
            '".$idProduto."',           // SKU/code - required
            '".$strNew."',        // product name
            '".$peso."',   // category or variation
            '".$precoFinal."',          // unit price - required
            '".$qtd."'               // quantity - required
          ]); ";   
          
          //0.40 ->PRECO  
          $precoP = str_replace(',','*',$precoFinal);  
          
               // if(strlen($precoP)>6){   
                    $precoP = str_replace('.',',',$precoP);
                   // $precoP = getPriceFormat(str_replace('*',',',$precoP)); 
                    $precoP =  str_replace(',','.',$precoP) ;  
                    //$precoP = "0.40";
              //  };  
            
            
          $inputsProdutos .='
          <input type="hidden" name="item_name_'.$countPrd.'" value="'.$strNew.'">
          <input type="hidden" name="amount_'.$countPrd.'" value="'.$precoP.'">
          <input type="hidden" name="quantity_'.$countPrd.'" value="'.$qtd.'"> 
          ';  
 
    
	
	$freteV = 0;  $countPrd+=1;  
	 
}; //End If Pagseguro Add
   
 

    $tabela = $wpdb->prefix."";
    $tabela .=  "wpstore_orders_address";

   $fivesdraftCs = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$idPedido' ORDER BY `id`  ASC  "  ,1,'') );

   // Adicionando PRODUTOS

   foreach ( $fivesdraftCs as $item=>$fivesdraftC ){
    
   
 
    $userEndereco = $fivesdraftC->endereco;
    $userEnderecoNumero = $fivesdraftC->numero;
    $userComplemento = $fivesdraftC->complemento;
    $userCidade = $fivesdraftC->cidade;
    $userBairro = $fivesdraftC->bairro;
    $userEstado = $fivesdraftC->estado;
    $userCep = $fivesdraftC->cep;
    
 
  
    $pesoTotal = $peso;

    $displayNameUser = trim("$current_user->user_firstname $current_user->user_lastname"); 
    if($displayNameUser ==""){$displayNameUser=$userLogin;};

    $userPais = trim(get_user_meta($idUser,'userPais',true));if($userPais==""){$userPais="Brasil";};
    $userDDD = trim(get_user_meta($idUser,'userDDD',true));if($userDDD==""){$userDDD="";};
    $userTelefone = trim(get_user_meta($idUser,'userTelefone',true));if($userTelefone==""){$userTelefone="";};
    
    $displayNameUser  = utf8_decode(trim(htmlentities(stripslashes($displayNameUser), ENT_QUOTES,'utf-8')));              
 
    //echo"Usuário:$nome";      
 
    $cidade = $userCidade;
    $estado = $userEstado;

 
   }; 
        
         $vt = $valor_total;
         $vt = str_replace('.','',$vt);
         $vt = str_replace(',','.',$vt);
         $vt = floatval($vt);
         $cupom =   get_session_cupom(); 
     
         $desconto = 0.00;
         $msg = "";
         $numeroCupom  = $cupom[0];
         
         if($cupom[1]=="Valor"){ 
             $msg =  $cupom[1]." $moedaCorrente".$cupom[2];
             $desconto = floatval(str_replace(',','.',$cupom[2]));
         }elseif($cupom[1]=="Percentual"){
             $msg = $cupom[1]." " .$cupom[2]."%" ;  
             $desconto = ( $vt*floatval(str_replace(',','.',$cupom[2])) ) / 100 ;
         }; 
 
 
 
         $totalCompra =    	$valorF;
		 
		 
		 if($extras>0){
			  $totalCompra += $extras;
		 };
         
          
         
         $obs = "";
         if( intval($totalCompra)<0){
            $positivoTotal = str_replace('-','',$totalCompra);
             $obs = "<br/><span style='font-size:0.8em;color:red'>Seu cupom é maior que o total de suas compras . Em breve você receberá um  novo cupom no valor de $positivoTotal. </span><br/><br/>";
             $comentario .= $obs;
             $totalCompra = "0.00";
         }

 
    $_SESSION['vt']  =   $totalCompra;
   
 
    $total = "$totalCompra";
 
                    //$totalCompra =  $subTotal ;

                   $valorFS  = str_replace(',','',  getPriceFormat($totalCompra) );

                   $valorF1 = str_replace('.','',$valorFS);

                   // $valorF = str_replace($moedaCorrente,'',$valorF1 );
                                                                          
                  
                   $valorF = $valorF1;
         
                  // $totalCompra = 100;$valorF =  $totalCompra;

                   //echo "<br/>".$valorF."<br/>";

                   $_SESSION['vt']  = $valorF;
                   $_SESSION['parc'] = "01";

    
    if(intval($totalCompra)>0 && $status_pagto!="APROVADO" && $status_pagto!="CANCELADO" ){
 
   // include_once('pages/carrinho.php');
	

	$emailPaypal = get_option("emailPaypal");        
	$currentCodePaypal  = get_option("currentCodePaypal");         

	//0.40 ->PRECO  
	    $valorFreteT = str_replace(",","*", $valorFreteT);
	    $valorFreteT = str_replace(".",",", $valorFreteT);
	    $valorFreteT = str_replace("*",".", $valorFreteT);
	    $valorFreteT = str_replace(",",".", $valorFreteT); 
	
	$formulario = '<form action="https://www.paypal.com/cgi-bin/webscr" name="paypal" method="post"  target="_blank"   ><input type="hidden" name="cmd" value="_cart"><input type="hidden" name="upload" value="1"><input type="hidden" name="business" value="'.$emailPaypal.'"><input type="hidden" name="currency_code" value="'.$currentCodePaypal.'">'.$inputsProdutos.'<input type="hidden" name="shipping_1" value="'.$valorFreteT.'"><input type="hidden" name="shipping_2" value="00.00"><input type="hidden" NAME="lc" value="BR"><INPUT TYPE="hidden" NAME="charset" value="utf-8"><INPUT TYPE="hidden" NAME="first_name" VALUE="'.$current_user->user_firstname.'"><INPUT TYPE="hidden" NAME="last_name" VALUE="'.$current_user->user_lastname.'"><INPUT TYPE="hidden" NAME="address1" VALUE="'.$userEndereco.'"><INPUT TYPE="hidden" NAME="address2" VALUE="'.$userBairro.'"><INPUT TYPE="hidden" NAME="city" VALUE="'.$userCidade.'"><INPUT TYPE="hidden" NAME="state" VALUE="'.$userEstado.'"><INPUT TYPE="hidden" NAME="zip" VALUE="'.$userCep.'"><INPUT TYPE="hidden" NAME="email" VALUE="'.$userEmail.'"><INPUT TYPE="hidden" NAME="night_phone_a" VALUE="'.$userDDD.'"><INPUT TYPE="hidden" NAME="night_phone_b" VALUE="'.$userTelefone.'"><INPUT TYPE="hidden" NAME="shopping_url" VALUE="".get_bloginfo("url").""><INPUT TYPE="hidden" NAME="return" VALUE="".get_bloginfo("url").""\><INPUT TYPE="hidden" NAME="rm" VALUE="0"><INPUT TYPE="hidden" NAME="notify_url" VALUE="".get_bloginfo("url")."/?cdp='.$idPedido.'"><input type="image" src="https://www.paypal.com/pt_BR/i/btn/btn_xpressCheckout.gif" NAME="submit" alt="Make payments with PayPal - its fast, free and secure!"></form>';   
 
		echo $formulario;
         
    };//IF VALOR >0
      
   ?> 