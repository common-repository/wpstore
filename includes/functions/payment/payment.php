<?php


if($_REQUEST['confirma']=='true'){
    
    $CURRENT_SOURCE_FOLDER = dirname(__FILE__);
    $CURRENT_SOURCE_FOLDER = str_replace('functions/payment','ajax/shipping',$CURRENT_SOURCE_FOLDER);
    $CURRENT_SOURCE_FOLDERB = str_replace('/shipping','',$CURRENT_SOURCE_FOLDER);
    include_once("$CURRENT_SOURCE_FOLDER/checkoutFinalizacao.php");
 
};


$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
}
?>
    
<?php

    global $current_user;
    get_currentuserinfo();
    $idUser = $current_user->ID;
    

    global $wpdb;
    $tabela = $wpdb->prefix."";
    $tabela .=  "wpstore_orders";
    
 
	$sql = "SELECT * FROM  `$tabela` WHERE  `id_usuario`='$idUser' ORDER BY `id`  DESC LIMIT 0,1";
	
	
	
    if($_GET['order'] !=""){
		
        $order = $_GET['order'];
     
		if ( current_user_can( 'manage_options' ) ) {
		   $sql = "SELECT * FROM  `$tabela` WHERE  `id_pedido`='$order'    ORDER BY `id`  DESC LIMIT 0,1";
		} else {
		   $sql = "SELECT * FROM  `$tabela` WHERE  `id_pedido`='$order'  AND `id_usuario`='$idUser' ORDER BY `id`  DESC LIMIT 0,1";
		}
 
 
 
    };
    
    
    
    if($_GET['orderCIELO'] !=""){
        $order = $_GET['orderCIELO'];
        $sql = "SELECT * FROM  `$tabela` WHERE  `id_pedido`='$order'  AND `id_usuario`='$idUser' ORDER BY `id`  DESC LIMIT 0,1";
    };
    
    
        $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "$sql"  ,1,'') );
    
    $tipo_pagto = "";
    $tipoFrete = "";
    
    $idPedido=0;
	
	$extras = 0;
	
	$pesoTotal = 0;
	
    $pct = "";
	  $desconto = "";
	  $valorDeconto = "";
 
  
    
    foreach ( $fivesdrafts as $fivesdraft ){
        
        $idPedido = $fivesdraft->id_pedido;
    	$valor_total = $fivesdraft->valor_total;
    	$frete = $fivesdraft->frete;
		
  	     $precoAdddArray = explode('(R$',$frete);
         $tipoFrete = $precoAdddArray[0];
         $freteV= str_replace(')','',$precoAdddArray[1]);
         $freteV =  floatval(str_replace(',','.',$freteV));
		
		
        $tipo_pagto = $fivesdraft->tipo_pagto; 
        $status_pagto = $fivesdraft->status_pagto;
        $comentario_cliente = $fivesdraft->comentario_cliente ;
        $comentario_admin = $fivesdraft->comentario_admin;
		
		 $extraInfo= $fivesdraft->extras;
		 $pos = strpos($extraInfo,"DESC-");
         if($pos === false) {
             $extras = floatval( $extraInfo);
	     }else{
			 $pct = intval(str_replace('DESC-','', $extraInfo));
		
		
			 $precoSoma = $valor_total  ;
             if(strlen($precoSoma)>6){
                 $precoSoma= str_replace('.','',$precoSoma );
             };
               $precoSoma = floatval(str_replace(',','.',$precoSoma)) ;   
			  
			   //$precoSoma += $freteV;
		
			
		     $desconto =   floatval(number_format($precoSoma *$pct / 100,2,'.',''));
		
			   $valorDeconto =  $precoSoma + $freteV - $desconto;
			 
	
	 
	     }
		
        if($status_pagto=="PENDENTE"){
			$cor = "#ff5f76";
			}elseif($status_pagto=="APROVADO"){
			$cor = "green";
			}else{
		   	$cor = "red"; 
			};
        
       
        
                       $cupom =     getCupomInfos($comentario_admin);
         
                       $desconto = 0.00;
                       $msg = "";
                       $numeroCupom  = $cupom[0];
                       
                       
                                    $vt = $valor_total;  
									
								 
								    if(strlen($vt)>6){
                                    $vt = str_replace('.','',$vt);
                                  
							        };
								   $vt = str_replace(',','.',$vt);
                           
                                    $vt = floatval($vt);


                       if($cupom[1]=="Valor"){ 
                          $msg =  $cupom[1]."  $moedaCorrente".$cupom[2];
                          $desconto = floatval(str_replace(',','.',$cupom[2]));
                      }elseif($cupom[1]=="Percentual"){
                         $msg = $cupom[1]." " .$cupom[2]."%" ;  
                         $desconto = ( $vt*floatval(str_replace(',','.',$cupom[2])) ) / 100 ;
                     }; 
                   
                       
                   	     $precoAdddArray = explode('(R$',$frete);

                   	        $tipoFrete = $precoAdddArray[0];
                            $frete= str_replace(')','',$precoAdddArray[1]);
                            $frete =  str_replace(',','.',$frete);



                   	$vtf = $vt+floatVal($frete)-$desconto ;

                   	$totalPagto = $vtf;
					
					 
		
		
					//PESO CARRINHO ----------------------------
					if($order !=''){
 	           	   $arrOrder = explode('.',$order);
        	
 	           	   $idUser = 	intval($arrOrder[0]);
				   
				   
				   $tabela = $wpdb->prefix."";
				   $tabela .=  "wpstore_orders_products";
				   
	           	

				   $fivesdraftCar = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$order' ORDER BY `id`  ASC  " ,1,'') );

				   // Adicionando PRODUTOS
				   $pesoTotal = 0;
				   foreach ( $fivesdraftCar as $item=>$fivesdraft ){
       
					          $id_produto = $fivesdraft->id_produto;
				  
						      $var = str_replace(",",".", get_post_meta($id_produto,'weight',true)) ;
						      $peso = floatval($var);

						      $pesoTotal += $peso;
			  
				   };
   
   
				    if( $pesoTotal >=30){
				   	$tipoFrete = 'TRANSP.';
					$frete = str_replace('SEDEX','',$frete);
					
					}
				    };
					//PESO CARRINHO ----------------------------
					

  
					
        $txtPrint .= "  <div style='float:left;background:#ddd;margin-left:5px;padding:10px;margin-top:5px'><strong>ID Pedido : ".$idPedido ."</strong></div>";
    	$txtPrint .= "<div style='float:left;background:#ddd;margin-left:5px;padding:10px;margin-top:5px'>Sub Total :  $moedaCorrente".$valor_total."</div>";
        $txtPrint .= "<div style='float:left;background:#ddd;margin-left:5px;padding:10px;margin-top:5px'>Frete : ($tipoFrete) $moedaCorrente".$frete."</div>";
  
			
    	$freteV = $frete;
		
		
    	
    	if($extras>0){
	    $totalPagto += $extra;
	    $txtPrint .= "<div style='float:left;background:#ddd;margin-left:5px;padding:10px;margin-top:5px'>EXTRAS : $moedaCorrente".$extras."</div>";
		
	    };
    	
    	if(floatval($desconto)>0){
    	
    	$txtPrint .=  "<div style='float:left;background:#ddd;margin-left:5px;padding:10px;margin-top:5px'>Desconto :  $moedaCorrente".getPriceFormat($desconto)." ( Cupom Desconto  :$numeroCupom | $msg )</div>";
    	
	    }; 
	    
    	$txtPrint .=  "<div style='float:left;background:#ddd;margin-left:5px;padding:10px;margin-top:5px'>Tipo de pagamento : ".$tipo_pagto."</div>";
    	
    	$txtPrint .= "<div style='float:left;background:#ddd;margin-left:5px;padding:10px;margin-top:5px'>STATUS : <span style='color:$cor'>$status_pagto</span> </div><div class='clear'></div>";
    	
  
    	
    	//echo "Observações1 : ".$comentario_cliente."<br/><br/>";
        //echo "Observações2 : ".$comentario_admin."<br/><br/>";

        
    };
    
 
    if($tipo_pagto=="Redecard"){ // -----------------REDECARD ------------------------
        
        //include('Redecard/Redecard_response.php');
        
    }elseif($tipo_pagto=="Cielo"){ // -----------------CIELO ------------------------
             $paginaPedidoT = true;
            include('Cielo/Cielo_response.php');

   }elseif($tipo_pagto=="Pagseguro"){ // -----------------PAGSEGURO ------------------------
        
        include('Pagseguro/Pagseguro_response.php');
        
    }elseif($tipo_pagto=="Gerencianet"){ // -----------------Gerencianet------------------------
        
         include('Gerencianet/Gerencianet_response.php');
        
     }elseif($tipo_pagto=="Paypal"){ // ----------------- RETIRADA NA LOJA ------------------------

         include('Paypal/Paypal_response.php');         
         
   }elseif($tipo_pagto=="Moip"){ // ----------------- RETIRADA NA LOJA ------------------------
          
          include('Moip/Moip_response.php');          
          
   }elseif($tipo_pagto=="Depósito"){ // ----------------- RETIRADA NA LOJA ------------------------

       include('Prebanktransfer/Prebanktransfer_response.php');

   }elseif($tipo_pagto=="Retirar na Loja"){ // ----------------- RETIRADA NA LOJA ------------------------

           include('Payondelevary/Payondelevary_response.php');
         //include('Prebanktransfer/Prebanktransfer_response.php');

     }elseif($tipo_pagto=="boleto"){ // ----------------- RETIRADA NA LOJA ------------------------

             include('boleto/boleto.php');
           //include('Prebanktransfer/Prebanktransfer_response.php');

     }
    
       $_SESSION['orderCC'] ="";   
       
       if($idUser<=0){
          echo  "<p>Você precisa estar logado para acessar seus dados.</p>";
       }
      
       
       if( $tipo_pagto=="boleto" || $tipo_pagto=="Depósito" || $tipo_pagto=="Retirar na Loja"){
		   
       $googleConversaoPagto =  get_option('googleConversaoPagto'); 
       $googleConversaoPagto = str_replace('\"','"',$googleConversaoPagto );
       echo   $googleConversaoPagto;
	   
	   

       $facebookConversaoPagto =  get_option('facebookConversaoPagto'); 
  	  if( $facebookConversaoPagto  !=""){
       $facebookConversaoPagto = str_replace('\"','"',$facebookConversaoPagto );
       echo   $facebookConversaoPagto;
      };
	  
	  
      };
?>