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
 
// Incluindo o arquivo da biblioteca 	 Outras Informações
 
$Array[] = array();        
 
    $tabela = $wpdb->prefix."";
    $tabela .=  "wpstore_orders_products";
    
    $fivesdraftCs = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$idPedido' ORDER BY `id`  ASC  "  ,1,'') );
 
    // Adicionando PRODUTOS 
    
    $countPrd = 1;
 
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
		
		
		
		
		  
        $totalCompra =    	$totalPagto;
        
	 if($extras>0){
		  $totalCompra += $extras;
	 };
	 
	 
	 
 
        
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
          $precoP = str_replace('.',',',$precoP);
          $precoP = getPriceFormat(str_replace('*',',',$precoP)); 
          $precoP =  str_replace(',','.',$precoP) ; 
 
           
         // $precoP = "0.40";
          
        $inputsProdutos .="<input type='hidden' name='item_name_$countPrd' value='$strNew'><input type='hidden' name='amount_$countPrd' value='$precoP'>";  
 
    
	
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
         
          
         
         $obs = "";
         if( intval($totalCompra)<0){
            $positivoTotal = str_replace('-','',$totalCompra);
             $obs = "<br/><span style='font-size:0.8em;color:red'>Seu cupom é maior que o total de suas compras . Em breve você receberá um  novo cupom no valor de $positivoTotal. </span><br/><br/>";
             $comentario .= $obs;
             $totalCompra = "0.00";
         }

                 if(strlen( $totalCompra)>6){
                 $totalCompra= str_replace('.','', $totalCompra);
                 } //echo $valor."+++++++B";
                 $totalCompra= str_replace(',','.', $totalCompra);
              
               //echo $totalCompra ."YYZZZZ";



     
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
           
            $totalCompra += $valorFreteT;    
             //echo $totalCompra."ggg";        
            $total = "$totalCompra";    
            // echo $totalCompra."hhh";   
            $totalCompra  = str_replace(',','',  getPriceFormat($totalCompra) ); 
            //echo $totalCompra."iii";  
            $totalCompra  = str_replace('.','',   $totalCompra  ); 
            //echo $totalCompra."jjj";   
            $total = "$totalCompra"; 
            //include_once('pages/carrinho.php');
			
			
			$emailMoip = get_option('emailMoip');        
 
			/* */   


			//$total = getPriceFormat($total);
			//$total = str_replace(',','',$total);
			//$total = str_replace('.','',$total);

			$formulario .="<form action='https://www.moip.com.br/PagamentoMoIP.do' name='moip' method='post'  target='_blank' >"; 
    
            $formulario .="<input type='hidden' name='id_carteira' value='$emailMoip'>"; 
 
			$formulario .="<input type='hidden' name='valor' value='$total'>";    

			$formulario .="<input type='hidden' name='nome' value='".get_bloginfo('name')." $idPedido '>";  

			$formulario .="<input type='hidden' name='descricao' value='$descProdutos'>";  

            $formulario .="<input type='hidden' name='id_transacao' value='$idPedido'>";     

            $formulario .="<input type='hidden' name='frete' value='1'>";    

			$formulario .="<input type='hidden' name='peso_compra' value='$pesoTotal'>";   
 
			$formulario .="<INPUT type='hidden' name='pagador_nome' value='$current_user->user_firstname $current_user->user_lastname'>"; 

			$formulario .="<INPUT type='hidden' name='pagador_logradouro' value='$userEndereco'>";    

			$formulario .="<INPUT type='hidden' name='pagador_numero' value='$userNumero'>";    
 
			$formulario .="<INPUT type='hidden' name='pagador_complemento' value='$userComplemento'>";               
            $formulario .="<INPUT type='hidden' name='pagador_bairro' value='$userBairro'>";       

			$formulario .="<INPUT type='hidden' name='pagador_cidade' value='$userCidade'>"; 
			$formulario .="<INPUT type='hidden' name='pagador_estado' value='$userEstado'>"; 
			$formulario .="<INPUT type='hidden' name='pagador_cep' value='$userCep'>";  

			$formulario .="<INPUT type='hidden' name='pagador_email' value='$userEmail'>";    

			$formulario .="<INPUT type='hidden' name='pagador_telefone' value='$userDDD $userTelefone'>";   

			$formulario .="<INPUT type='hidden' name='pagador_celular' value='$userDDDCelular $userCelular'>";   

			$formulario .="<INPUT type='hidden' name='pagador_cpf' value='$userCpf'>";  

			$formulario .="<INPUT type='hidden' name='pagador_sexo' value='$userSexo'>";    
 
			$formulario .="<INPUT type='hidden' name='pagador_data_nascimento' value='$userNascimento'>";  

			$formulario .="<INPUT type='hidden' name='notify_url' value='".get_bloginfo('url')."/?cdp=$idPedido'>";  
  
			 $formulario .="<input type='image' name='submit' src='https://static.moip.com.br/imgs/buttons/bt_pagar_c01_e04.png' alt='Pagar com Moip' border='0' />"; 

            $formulario .="</form>";  
            echo $formulario; 
         
    };//IF VALOR >0
      
   ?>