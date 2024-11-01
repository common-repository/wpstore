<?php
$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
}

 
$plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));


 
if( intval($_REQUEST['idRmv'] )>0 ){
      if(is_admin()){
      global $wpdb;
      $tabela = $wpdb->prefix."";
      $tabela .=  "wpstore_orders_comments";
      $ID = $_REQUEST['idRmv'];
      $resultQuery = $wpdb->query("DELETE FROM `$tabela` WHERE `id` = '$ID'");
  	  //wp_redirect(verifyURL(get_bloginfo('url')).'/wp-admin/admin.php?page=lista_pedidos');
 echo"<script>window.location='".verifyURL(get_bloginfo('url'))."/wp-admin/admin.php?page=lista_pedidos'</script>";
 
 
      };
  	  
};

if($_POST['submit']=="Deletar"){
  
for ($i=0; $i<=count($_POST['list']);$i++) {

      	   $ID = $_POST['list'][$i];
          
            global $wpdb;
            $tabela = $wpdb->prefix."";
            $tabela2 =  $tabela;
            $tabela3 =  $tabela;
            $tabela .=  "wpstore_orders";
            $tabela2 .=  "wpstore_orders_address";
            $tabela3 .=  "wpstore_orders_products";
                   
                   
           $resultQuery = $wpdb->query("DELETE FROM `$tabela` WHERE `id_pedido` = '$ID'");
           
           $resultQuery = $wpdb->query("DELETE FROM `$tabela2` WHERE `id_pedido` = '$ID'");
           
           $resultQuery = $wpdb->query("DELETE FROM `$tabela3` WHERE `id_pedido` = '$ID'");
         
           //FINAL insere  no total de Inscrições da Etapa  

	} 
	
        //	wp_redirect(verifyURL(get_bloginfo('url')).'/wp-admin/admin.php?page=lista_pedidos');
		  echo "<script>window.location='".verifyURL(get_bloginfo('url'))."/wp-admin/admin.php?page=lista_pedidos'</script>";
    exit;
          
            
}elseif($_POST['submit']=="Gravar"){
    
    $status  = $_POST['statusID'];
 
    $comentario = $_POST['comentario'];
    
    for ($i=0; $i<=count($_POST['list']);$i++) {   
      $ID = $_POST['list'][$i];
	  if( $status =="0" ||  $status == "" ){}else{
		  alteraPedidoStatus($ID,$status,$comentario);
	  };
    };
    
    // ewp_redirect(verifyURL(get_bloginfo('url')).'/wp-admin/admin.php?page=lista_pedidos');
    // echo "<script>window.location='".verifyURL(get_bloginfo('url'))."/wp-admin/admin.php?page=lista_pedidos'</script>";
    
}elseif($_POST['submit']=="Imprimir"){
	 $impressaoAgrupada = "";
	echo "<div class='sectionPrint'> ";
	$totalOrders = count($_POST['list']);
    for ($i=0; $i<=$totalOrders;$i++) {   
        $ID = $_POST['list'][$i];
	    if($ID !=""){
			$index = $i;
			 $impressaoAgrupada .= imprimePedido($ID,$index); 
			 if( $i< $totalOrders && $totalOrders-1 > $i){
		    	echo "<div class='breakPage'></div>"; 
		     };
	
		}
    };
	 
	 echo "<div class='breakPage'></div>"; 
	 echo $impressaoAgrupada;
			 
	echo "</div>
		
		
		<p class='imprime nextPage'>Imprimir Lista</p>
		
        <script>
        jQuery('.sectionPrint').printElement();
		
		
    	 jQuery('.imprime').click(function(){
    	     jQuery('.sectionPrint').printElement();
    	 });   
		 
		 
		 
	    </script> ";
	 
	 
 }elseif($_POST['submit']=="Emitir"){
 	 $impressaoAgrupada = "";
 	echo "<div class='sectionPrint'> ";
 	$totalOrders = count($_POST['list']);
     for ($i=0; $i<=$totalOrders;$i++) {   
         $ID = $_POST['list'][$i];
 	    if($ID !=""){
 			$index = $i;
 			 $impressaoAgrupada .= imprimePedido($ID,$index); 
			 
			 $msg = "Pedido Emitido : em separação";
			 
			 alteraPedidoStatus($ID,'SEPARACAO',$msg,"","");
			 
 			 if( $i< $totalOrders && $totalOrders-1 > $i){
 		    	echo "<div class='breakPage'></div>"; 
 		     };
	
 		}
     };
	 
 	 echo "<div class='breakPage'></div>"; 
 	 echo $impressaoAgrupada;
			 
 	echo "</div>
		
		
 		<p class='imprime nextPage'>Imprimir Lista</p>
		
         <script>
         jQuery('.sectionPrint').printElement();
		
		
     	 jQuery('.imprime').click(function(){
     	     jQuery('.sectionPrint').printElement();
     	 });   
		 
		 
		 
 	    </script>
	 
 	 ";
 };



if($_POST['submit']=="Imprimir" || $_POST['submit']=="Emitir"){
	
  
	
}else{


 
   global $wpdb;
   $tabela = $wpdb->prefix."";
   $tabela .=  "wpstore_orders";
   
   

   $oid = $_REQUEST['oid'];
   $oemail = $_REQUEST['oemail'];
   $pesquisarStatus = $_REQUEST['pesquisarStatus'];
   $pesquisarPagto= $_REQUEST['pesquisarPagto'];
   $onome = addslashes(trim($_REQUEST['onome']));
   $osobrenome = addslashes(trim($_REQUEST['osobrenome'])); 
   $oDataP = addslashes(trim($_REQUEST['oDataP']));

   $oIdProd = addslashes(trim($_REQUEST['oIdProd']));


   //MANTENDO PESQUISA AO SALVAR PEDIDOS ------
   $oidS = $_REQUEST['oidS'];
   if($oidS!='' && $oidS!="0"  ){
   	$oid = $oidS;
   };
   $oemailS = $_REQUEST['oemailS'];
   if($oemailS!='' && $oemailS!="0"  ){
   	$oemail = $oemailS;
   };
   $pesquisarStatusS = $_REQUEST['pesquisarStatusS'];
   if($pesquisarStatusS!='' && $pesquisarStatusS!="0"  ){
   	$pesquisarStatus = $pesquisarStatusS;
   };
   $pesquisarPagtoS= $_REQUEST['pesquisarPagtoS'];
   if($pesquisarPagtoS!='' && $pesquisarPagtoS!="0"  ){
   	$pesquisarPagto = $pesquisarPagtoS;
   };
   $onomeS = addslashes(trim($_REQUEST['onomeS']));
   if($onomeS!='' && $onomeS!="0"  ){
   	$onome = $onomeS;
   };
   $osobrenomeS = addslashes(trim($_REQUEST['osobrenomeS'])); 
   if($osobrenomeS!='' && $osobrenomeS!="0"  ){
   	$osobrenome = $osobrenomeS;
   };
   $oDataPS = addslashes(trim($_REQUEST['oDataPS']));
   if($oDataPS!='' && $oemailS!="0"  ){
   	$oDataP = $oDataPS;
   };
   //MANTENDO PESQUISA AO SALVAR PEDIDOS ------
   
   
   
   $andQuery="";
	
   $pagina =  intval(addslashes(trim($_REQUEST['pagina'])));
   
   if($pagina==""){
   	 $pagina =  intval(addslashes(trim($_REQUEST['lastPage'])));
   };
   
	 
		$limite = 0;
		if( $pagina==0 ){ $pagina = 1; };
	
		$paginaQ = $pagina;
	
	    if($paginaQ>1){
		    $paginaQ = $paginaQ - 1;
	       $limite = $paginaQ*30;
        };
	
	
	
	
	//MANTENDO OPCOES DE PESQUISA NA PAGINACAO ---------
	$urlAdicionalPagina = "";
	if($oid!="" && $oid!="0" ){
		$urlAdicionalPagina .= "&oid=$oid";
	}
	if($oemail!=""){
		$urlAdicionalPagina .= "&oemail=$oemail";
	}
	if($pesquisarStatus!="" && $pesquisarStatus!="0" ){
		$urlAdicionalPagina .= "&pesquisarStatus=$pesquisarStatus";
	}
	
	if($pesquisarPagto!="" && $pesquisarPagto!="0"){
		$urlAdicionalPagina .= "&pesquisarPagto=$pesquisarPagto";
	}
	
	
	if($onome!="" && $onome!="0"){
		$urlAdicionalPagina .= "&onome=$onome";
	}
	
	if($osobrenome!="" && $osobrenome!="0"){
		$urlAdicionalPagina .= "&osobrenome=$osobrenome";
	}
	
	if($oDataP!="" && $oDataP!="0"){
		$urlAdicionalPagina .= "&oDataP=$oDataP";
	}
	//MANTENDO OPCOES DE PESQUISA NA PAGINACAO ---------
	
	
	
   
    $sql = "SELECT *FROM `$tabela` ORDER BY `ID` DESC LIMIT $limite,30 ";

     
	 
    if(trim($onome) != '' ||  trim($osobrenome) != '' ){
		
        $onome = trim($onome);
		
        $arrayIds = array();
		
	   global $wpdb;
	   
	    $sqlUser = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'first_name' AND meta_value LIKE '%$onome%' ";
		
	    if(trim($onome) == '' &&  trim($osobrenome) != '' ){
	   $sqlUser = "SELECT user_id FROM $wpdb->usermeta WHERE (meta_key = 'last_name' AND meta_value LIKE '%$osobrenome%' )";
        }
		
		
	
	    if(trim($onome) != '' &&  trim($osobrenome) != '' ){
	   $sqlUser = "SELECT user_id FROM $wpdb->usermeta WHERE ( meta_key = 'first_name'  AND  meta_value  LIKE   '%$onome%'  ) OR  ( meta_key = 'last_name'  AND  meta_value  LIKE  '%$osobrenome%'  ) ";
        }
	   
	   
		
	
	   $users = $wpdb->get_results( $sqlUser );
	   if( $users ) {
	   	foreach ( $users as $user ) {
	   		 $arrayIds[] = $user->user_id;
	   	}
	   };
	   

	    $sql = "SELECT *FROM `$tabela`  WHERE `id_usuario`  IN (". implode(',', array_map('intval', $arrayIds)) .")  ORDER BY `ID`   DESC  LIMIT $limite,30 ";
		
		
    }
	 
	 
	 
	 if(trim($oemail) != ''){
         $uid = trim($oemail);
         $idUser =  email_exists($uid);
        $sql = "SELECT *FROM `$tabela`  WHERE `id_usuario`='$idUser' ORDER BY `ID`   DESC LIMIT $limite,30   ";
     }
	 
	 
	 
	 
	 if(trim( $pesquisarStatus) != '' &&  trim( $pesquisarStatus) != '0'  ){
         $pesquisarStatus = trim($pesquisarStatus);
         $sql = "SELECT *FROM `$tabela`  WHERE `status_pagto`='$pesquisarStatus' ORDER BY `ID`   DESC   LIMIT $limite,30";
     }
	 
	 
	 if(trim( $pesquisarPagto) != '' &&  trim( $pesquisarPagto) != '0'  ){
         $pesquisarPagto = trim($pesquisarPagto);
         $sql = "SELECT *FROM `$tabela`  WHERE `tipo_pagto`='$pesquisarPagto' ORDER BY `ID`   DESC  LIMIT $limite,30 ";
     }
	 
	 
 
     
	 if(trim($oDataP) != ''){
		 
         $arrDataPedido = explode('/',$oDataP);
		
		 $dataPesquisa = $arrDataPedido[2].".".$arrDataPedido[1].".".$arrDataPedido[0];
         
		 $sql = "SELECT *FROM `$tabela`  WHERE `id_pedido` LIKE CONCAT('%', '$dataPesquisa' , '%')  ORDER BY `ID` DESC LIMIT $limite,30 ";
		 
      }
	  
	  

     if(trim($oid) != ''){
         $oid = trim($oid);
         //$sql = "SELECT *FROM `$tabela`  WHERE `id_pedido` LIKE '$oid' ORDER BY `ID`    DESC LIMIT $limite,100 ";
		 
		 $sql = "SELECT *FROM `$tabela`  WHERE `id_pedido` LIKE '%{$oid}%' ORDER BY `ID`    DESC LIMIT $limite,30 ";
	 
			 
      }
 
 
	if($oIdProd !=''){
	    $tabela = $wpdb->prefix."";
	    $tabela2 = $wpdb->prefix."wpstore_orders_products";
		$tabela .=  "wpstore_orders";
   
	    $sql = "SELECT * FROM `$tabela`  pro INNER JOIN `$tabela2`  ord  ON pro.id_pedido = ord.id_pedido  WHERE ord.id_produto=$oIdProd;";

   
	}
	
	

    $fivesdrafts = $wpdb->get_results($sql);
    
	$contagemResultado = count($fivesdrafts);
		
	$sql21= str_replace('SELECT *','SELECT COUNT(*) ',$sql);
	$sql2 = str_replace("LIMIT $limite,30",'',$sql21);
	
 
    $totalPedidos = $wpdb->get_var( $sql2 );
 
?>

    
 
       <div id="cabecalho">
       	<ul class="abas">
       		<li>
       			<div class="aba gradient">
       				<span>Controle de Pedidos</span>
       			</div>
       		</li>  
  

       		<div class="clear"></div>
       	</ul>
       </div><!-- #cabecalho -->       





       <div id="containerAbas">  



       	<div class="conteudo"> 
       	
       	
    
       	
       	
       	<form action="<?php echo verifyURL(get_option( 'siteurl' ))  ."/wp-admin/admin.php?page=lista_pedidos";?>"  method="post" >

            <p>Pesquise por :</p>
     		<label>Numero do pedido : </label>
     		<input type="text"  name="oid" value="<?php echo $oid; ?>"/>  <br/>
			<hr/>
     		<label>ou pelo nome / sobrenome do cliente : </label>
     		<br/>Nome : <input type="text"  name="onome" value="<?php echo $onome; ?>"/> <br/>
			Sobrenome : <input type="text"  name="osobrenome" value="<?php echo $osobrenome; ?>"/> 
			 <br/>
			 
			 	<hr/>
     		<label>ou pelo E-mail do cliente : </label>
     		<input type="text"  name="oemail" value="<?php echo $oemail; ?>"/> <br/>
			
				<hr/>
     		<label>ou pela data do Pedido : </label>
     		<input type="text"  name="oDataP" value="<?php echo $oDataP; ?>"  class='datepicker' /> 
			
			<br/>
			
			
				<hr/>
     		<label>ou pelo Id do Produto : </label>
     		<input type="text"  name="oIdProd" value="<?php echo $oIdProd; ?>"    /> 
			
			<br/>
			
			
	<hr/>
	 
	
    <br/>  
   	<label>Pesquise pelo STATUS : </label>
 	<select name="pesquisarStatus">
 		<option value="0">Todos</option>
        <option value="PENDENTE">PENDENTE</option>
        <option value="VERIFICANDO">PAGAMENTO EM VERIFICAÇÃO</option>
        <option value="APROVADO">APROVADO</option>
        <option value="SEPARACAO">PRODUTOS EM SEPARAÇÃO</option>
        <option value="TRANSPORTADORA">ENCOMENDA ENTREGUE A TRANSPORTADORA</option>  
        <option value="ENTREGUE">ENTREGUE</option>
        <option value="DISPUTA">DISPUTA</option>   
		<option value="DISPUTAENCERRADA">DISPUTA ENCERRADA</option>
		<option value="CANCELADO">CANCELADO</option>     
		<option value="DEVOLVIDO">DEVOLVIDO</option> 
     </select>  
	
	
	
	
	
   	<label>Ou Tipo de Pagamento : </label>
 	<select name="pesquisarPagto">
 

	<option value="0">Todos</option>
	
	
	<?php
		 
    $totalParcela = get_totalParcela(); 
 
    $ativaPagseguro = get_option('ativaPagseguro');
   $ativaGerencianet = get_option('ativaGerencianet');
    $ativaCielo = get_option('ativaCielo');
     $ativaBoleto = get_option('ativaBoleto');
	 $ativaDeposito = get_option('ativaDeposito ');
    $ativaRetirada= get_option('ativaRetirada'); 


    $ativaMoip= get_option('ativaMoip');
    $ativaPaypal= get_option('ativaPaypal');
	 
		 // current_user_can('manage_options') && 
		   if( $ativaBoleto =="ativaBoleto"){   
 	            echo "<option value='boleto'>boleto</option>";
		   }
		   
		   
		   
		
		  if($ativaCielo=="ativaCielo"){
		  
		  
			  	 echo "<option value='Cielo'>cielo</option>";
		  
		  }
		  
		  
		  
		    if($ativaPagseguro=="ativaPagseguro"){ 
			
			
			
				 echo "<option value='Pagseguro'>pagseguro</option>";
			
			
			}
			
			
		    if($ativaGerencianet=="ativaGerencianet"){ 
			
			
			
				 echo "<option value='Gerencianet'>gerencianet</option>";
			
			
			}
			
			
			
			 	if($ativaMoip=="ativaMoip"){  
				
				
				
	   			 echo "<option value='Moip'>moip</option>";
				
				
				}
				
				

               	if($ativaPaypal=="ativaPaypal"){
				
				
			 echo "<option value='Paypal'>paypal</option>";
				
				
				}
				
				
				
				   if($ativaDeposito=="ativaDeposito"){  
				   
 					  echo "<option value='Deposito'>Deposito</option>";
					 
				   }
				   
	               $ativaRetiradaParcial= get_option('ativaRetiradaParcial'); 
			
				     if($ativaRetirada =="ativaRetirada" ||  $ativaRetiradaParcial=="ativaRetiradaParcial"){   
					 
					  echo "<option value='Retirar na Loja'>Retirada</option>";
					 
					  }
					 
				 
					 
					 
	?>
   
   </select>  
			
			
			
	
	<br/>
	
	
	
	<br/>
              <input type="submit"  name="submit" value="Filtrar"/>
     	</form><br/>

   
       		
 
	
	<?php 
	
	$tipo_pagto = "";
    
    
    if ($fivesdrafts) {
        
        
        ?>
		
		
       	<?php
       		
		$extraRequest="";
		if($pagina !=""){
			$extraRequest .="&pagina=$pagina";
		}
		if($pesquisarStatus !=""){
			$extraRequest.="&pesquisarStatus=$pesquisarStatus";
		}
		
	
		?>
		
 
 <p style="float:right"> pagina <?php echo $pagina; ?> :  Exibindo  <?php echo $contagemResultado; ?>  de  <?php echo $totalPedidos;?> </p>
 
 
  
	<form action="<?php echo verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=lista_pedidos".$extraRequest ;?>"  method="post" >
	
	
	<label>Selecionar Todos:</label>
	
	<input name="check" id="check" onClick="return selectCheckBox();"  type="checkbox"> 

 <div style='clear:both'></div>

   	<?php

        $orderCount = 0;
		

	
       foreach ( $fivesdrafts as $fivesdraft ){
           
        
           $id = $fivesdraft->id;
           $idPedido = $fivesdraft->id_pedido;
           $idUsuario = $fivesdraft->id_usuario;
       	   $valor_total = $fivesdraft->valor_total;
 
       	   $frete = $fivesdraft->frete;
           $tipo_pagto = $fivesdraft->tipo_pagto;
           $status_pagto = $fivesdraft->status_pagto;
           $comentario_cliente = $fivesdraft->comentario_cliente ;
           $comentario_admin = $fivesdraft->comentario_admin;
	         $extras = $fivesdraft->extras;
		   
		        $extraInfo = $extras;
		   
   			 
	          $userCpf = trim(get_user_meta($idUsuario,'userCpf',true)); 

           $dataArray = explode('.',$idPedido);

           $get_total_Products = custom_get_total_products_in_order($idPedido); 
           
           
           	    if($status_pagto=="PENDENTE"){
   					$cor = "#fffadf ";
   				}elseif($status_pagto=="VERIFICANDO"){
    				$cor = "#CFA206";
    			}elseif($status_pagto=="APROVADO"  ){
   					$cor = "#b2ffc8";
   				}elseif($status_pagto=="TRANSPORTADORA"  ){
   					$cor = "#A2C6DE";
   				}elseif($status_pagto=="SEPARACAO"  ){
   					$cor = "#0074A2";
   				}elseif($status_pagto=="ENTREGUE"  ){
   					$cor = "#D7E5EE";
   				}elseif($status_pagto=="CANCELADO"){
   					$cor = "#ff6865";
			    }elseif($status_pagto=="DISPUTA"){
			         $cor = "#cc2f2c";	
 			    }elseif($status_pagto=="DISPUTAENCERRADA"){
 			         $cor = "#a6d759";	
 			    }elseif($status_pagto=="DEVOLVIDO"){
   				     $cor = "#6bc5b7";
		        }else{
			        $cor = "#fffadf";
			   };
				
   			 
      
             	  
                                          $cupom=  explode('***',$comentario_admin);

                                          $numeroCupom = $cupom[0];
																					
																					
																					$tipoDesconto = $cupom[1];
																 
                                          $desconto = 0;
										 
                                          $vt = $valor_total;
										 
										                      if(strlen($vt)>6){
                                          $vt = str_replace('.','',$vt);
                                          };
																					$vt = str_replace(',','.',$vt); 
																					$vt = floatval($vt);
																					
																
                                          if($cupom[1]=="Valor"){ 
                                            
											 										 		$msg =  $cupom[1]." $moedaCorrente".$cupom[2];
                                             $desconto = floatval(str_replace(',','.',$cupom[2]));
                                          
										  										 }elseif($cupom[1]=="Percentual"){
              															 	$msg = $cupom[1]." " .$cupom[2]."%" ;  
		 
   																					 	$desconto = ( $vt*floatval(str_replace(',','.',$cupom[2])) ) / 100 ;


                                          };


                                           $precoAdddArray = explode('(R$',$frete);
                                  	       $tipoFrete = $precoAdddArray[0];
                                           $frete= str_replace(')','',$precoAdddArray[1]);
                                           $frete =  str_replace(',','.',$frete);
                                           $vtf = $vt;
											
 																
											
											//DESCONTO ---------------------------------
											
								   			$pct = "";
												$valorDeconto = "";
		                    $pos = strpos($extraInfo,"DESC-");
						            if($pos === false) {
								            $extras = floatval( $extraInfo);
								            $valorDesconto = 0;
						            }else{
							              $extras = "";
						                $pct = intval(str_replace('DESC-','', $extraInfo));
                            $precoSoma = $vtf ;  
				 
					                  if(strlen( $precoSoma )>6){
						                     // $precoSoma = str_replace('.','', $precoSoma );
					                  };  
					  
		  											$precoSoma = str_replace(',','.', $precoSoma );//CENTAVOS CIELO
		 
		 											  $descontoV =   floatval(number_format($precoSoma *$pct / 100,2,'.',''));
		 
													  $valorDesconto =   $descontoV;
	
			                };
											
											  
											 
											  $vFret = floatVal($frete) ;
									  
		                    $vtf =  $vtf + $vFret - $valorDesconto;
												
											  $subTotal =  $vtf;
												
												$vtf  = $vtf - $desconto;
						 
											 //DESCONTO ---------------------------------
										
										   
										   
										   
										   
										   

                                      	$totalPagto = $vtf;
 
																				
                                        $extras  = floatval($extras);
										
										if( $extras >0){
											$totalPagto +=  $extras;
										}

                           	  if($frete==""){$frete = "0.00"; }
                           	  
                           	  
                           	  
                           	  
             	
              
                     $user_info = get_userdata($idUsuario);

                     $user_email =  $user_info->user_email;

                     $nome = "$user_info->user_firstname $user_info->user_lastname  ($user_email )";
             
            
             
                   
                        	  if($tipo_pagto=="Depósito"){
                        	      $imgPagto = "".$plugin_directory."images/deposito.png";
                        	  }elseif($tipo_pagto=="Retirar na Loja"){
                        	      $imgPagto = "".$plugin_directory."images/retirada.png"; 
                        	  }elseif($tipo_pagto=="Moip"){
                               $imgPagto = "".$plugin_directory."images/moip.png"; 
                           }elseif($tipo_pagto=="Pagseguro"){
                               $imgPagto = "".$plugin_directory."images/pagseguro.png"; 
                           }elseif($tipo_pagto=="gerencianet"){
                               $imgPagto = "".$plugin_directory."images/Gerencianet.png"; 
                           }elseif($tipo_pagto=="Paypal"){
                               $imgPagto = "".$plugin_directory."images/paypal.png"; 
                           }elseif($tipo_pagto=="Cielo"){
                               $imgPagto = "".$plugin_directory."images/cielo.png"; 
                           }elseif($tipo_pagto=="boleto"){
                               $imgPagto = "".$plugin_directory."images/boleto.png"; 
                           }
						   
						   
					    $userCnpj = trim(get_user_meta( $idUsuario,'userCnpj',true));  
						$tituloDoc = "CPF";
						if($userCnpj !=''){
							$tituloDoc = "CNPJ";
							$userCpf =  $userCnpj;
						}
						
						
                        	?>    
             
 
       	
       	    <div class="bloco" style="background:<?php echo $cor; ?>;padding:10px;margin-bottom:5px;"  >      

    		<h3> <input type='checkbox' id='check_<?php echo $orderCount ?>'  name='list[]' value='<?php echo $idPedido; ?>'/>  <?php echo $idPedido; ?> |  <?php echo  $nome; ?></h3>

    		<span class="seta" rel='box_<?php echo $orderCount ?>'></span>     
    		
    		
    		<div class="texto" id='box_<?php echo $orderCount ?>'>
    		
    	    
       	
      
       	
               <div>
               	      
                       <br/><strong>ID do pedido:</strong> <?php echo $idPedido; ?>
                       <br/><strong>Cliente : </strong>  <?php echo  $nome; ?> 
					    <br/><strong><?php echo $tituloDoc; ?> : </strong>  <?php echo   $userCpf; ?>  <br/><small><a href='http://www.receita.fazenda.gov.br/aplicacoes/atcta/cpf/consultapublica.asp' target='_blank'>Consultar NOME</a></small><br>
                       <br/><strong>Data:</strong> <?php echo $dataArray[4]; ?>/<?php echo $dataArray[3]; ?>/<?php echo $dataArray[2]; ?> 
                       <br/><strong>Tipo de Pagamento:</strong><img src='<?php echo $imgPagto; ?>' />  <?php echo $tipo_pagto; ?> 
                       <br/><strong>Quantidade de Produtos:</strong> <?php echo $get_total_Products; ?>
               </div>
               
               
                 <div class="clear"></div>
                 <br/><br/>     
                 
                 
                <div>
                   <br/><strong>Status:</strong><?php echo $status_pagto; ?> 
                   <br/><strong>SubTotal:</strong> <?php echo $moedaCorrente; ?><?php echo $valor_total; ?>         
                   <br/><strong>Frete:</strong>  <?php echo " ($tipoFrete) $moedaCorrente".$frete; ?> 
									 
									<br/><strong>Extras:</strong>  <?php echo " $moedaCorrente".$extras; ?> 
				
				
			 <br/><strong>SubTotal :</strong>  <?php echo $subTotal; ?>
				
					<?php //if($numeroCupom!=""){ ?>
                   <br/> <strong>Desconto:</strong> (-<?php echo $moedaCorrente; ?>  <?php echo $desconto ; ?>)
                    <?php //}; ?>
                  <br/> <strong>Total:</strong> <?php echo $moedaCorrente; ?><?php echo  $totalPagto; ?>  
                </div>  
                
              
              <div class="clear"></div> 
              
              <br/><br/>
              
                <div class='controleStatus'>
                   <a target="_BLANK" href="<?php echo get_bloginfo('url'); ?>/pedido/?order=<?php echo $idPedido; ?>">Ver Detalhes</a> -
				   
				   <?php /* ?>
                   <a  class="bttrocar" rel="check_<?php echo $orderCount ?>"  href="#trocarstatus">Mudar Status</a>
				   */ ?>
				   
				   
				  
					
                </div> 
                 <div class='clear'></div>
              <br/>
              
              <br/>
                  
                   <table width="650" class="table <?php echo $idPedido; ?>">
                   
                   
                       <thead>
                              <tr>
                                  <td class="ta-left" width="20%"><strong>Data</strong></td>
                                  <td class="ta-left"><strong>Status</strong></td>
                                  <td class="ta-left"><strong>Comentário</strong></td>
                               </tr>
                       </thead>
                       
                       
                       <tbody>



                                           <tr>
                                               <td class="ta-left va-top"><?php echo $dataArray[4]; ?>/<?php echo $dataArray[3]; ?>/<?php echo $dataArray[2]; ?></td>
                                               <td class="ta-left va-top">PENDENTE</td>
                                               <td class="ta-left va-top">Aguardando confirmação de pagamento. </td>
                                           
                                           </tr>
                                           
                           
                        <?php


                               $tabela = $wpdb->prefix."";
                               $tabela .=  "wpstore_orders_comments";

                               $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_pedido`='$idPedido' ORDER BY `id`  ASC  ",1,'' ) );

                               // Adicionando PRODUTOS
                               $infoCielo = "";
                               $infoCieloXML = "";
							   
							   $totalStatus = count($fivesdrafts);
							   
                               foreach ( $fivesdrafts as $item=>$fivesdraft ){

    		                    $id= $fivesdraft->id;
    		                    $comentario_cliente = $fivesdraft->comentario_cliente;
                                $userCidade = $fivesdraft->cidade;
                                $status_pagto = $fivesdraft->status_pagto ;
                                $data = $fivesdraft->data;
                           
                                $infoCieloXML =  $fivesdraft->comentario_pagt;

                          ?>





                                  <tr>
                                       <td class="ta-left va-top"><?php echo  $data ; ?></td>
                                       <td class="ta-left va-top"><?php echo $status_pagto; ?></td>
                                       <td class="ta-left va-top"><?php echo $comentario_cliente; ?>
                                        (<a  href="<?php echo get_bloginfo('url').'/wp-admin/admin.php?page=lista_pedidos'; ?>&idRmv=<?php echo  $id; ?>">Remover</a>)<br/>
										
	<?php
	
 
        	if($status_pagto=='TRANSPORTADORA' && $totalStatus -1 ==$item){
				$arrComt = explode(':',$comentario_cliente);
				$codeRastreio = trim($arrComt[1]);
				
				if (strpos($codeRastreio,'|') !== false) {
					$arrComt = explode(':',$comentario_cliente);
					$codeRastreio = trim($arrComt[2]);
				};	
				
				$arrCod = explode(' ',$codeRastreio);
				if(count($arrCod)>1){
					$codeRastreio = $arrCod[0];
				}
				
				if($codeRastreio==""){
					$codeRastreio = trim($comentario_cliente);
				}
				
				$codeRastreio = strtoupper($codeRastreio);
				
			    echo rastreamento_correios($codeRastreio,$idPedido,$comentario_cliente);
				echo "<br/><a href='http://www2.correios.com.br/sistemas/rastreamento/' target='_blank'>Consulte nos correios</a>";
			}
	?>
                                        </td>
                                   </tr>


                           <?php   };  ?>
                           
                           
                           
                                </tbody>
                               </table>
                    
					
					
					
					
					
					
					
 				   <?php
				   
				    /************************/ 
				  
				   ?>

 				   <br>  

 					<select name="statusID<?php echo $orderCount ?>" id="statusID<?php echo $orderCount ?>" class='statusChange' rev='<?php echo $orderCount ?>'>
 						<option value="0">Mudar Status</option>
 				       <option value="PENDENTE" <?php if($status_pagto=="PENDENTE"){ echo "selected='selected'";}; ?> >PENDENTE</option>
 				       <option value="VERIFICANDO" <?php if($status_pagto=="VERIFICANDO"){ echo "selected='selected'";}; ?>>PAGAMENTO EM VERIFICAÇÃO</option>
 				       <option value="APROVADO" <?php if($status_pagto=="APROVADO"){ echo "selected='selected'";}; ?>>APROVADO</option>
 				       <option value="SEPARACAO" <?php if($status_pagto=="SEPARACAO"){ echo "selected='selected'";}; ?>>PRODUTOS EM SEPARAÇÃO</option>
 				       <option value="TRANSPORTADORA" <?php if($status_pagto=="TRANSPORTADORA"){ echo "selected='selected'";}; ?>>ENCOMENDA ENTREGUE A TRANSPORTADORA</option>  
 				       <option value="ENTREGUE" <?php if($status_pagto=="ENTREGUE"){ echo "selected='selected'";}; ?>>ENTREGUE</option>
 				       <option value="CANCELADO" <?php if($status_pagto=="CANCELADO"){ echo "selected='selected'";}; ?>>CANCELADO</option>     
 				    </select>  

				    <br>

 				    <p>Preencha abaixo para fazer uma anotação sobre a mundança no status do pedido  . <br/> Esta mensagem será encaminhada por email ao cliente.</p>
					
	
	    <br/><small><strong class='red'>NOVO: </strong> Agora pode definir uma mensagem  padrão para cada STATUS do pedido . Para  edita as mensagens de status do pedido<a href='<?php bloginfo('url'); ?>/wp-admin/admin.php?page=lista_translate'>Clique aqui </a> .  </small>
	 	<br/>
					

 				    <textarea name="comentario<?php echo $orderCount ?>" id="comentario<?php echo $orderCount ?>" style="width:50%;height:150px;"></textarea>
 				    <br>
			 
					   <input type="submit"  name="submit" value="Gravar" class='btUpdate' rel="check_<?php echo $orderCount ?>" rev="<?php echo $orderCount ?>"   />
					   
					   
 					   <?php /************************/ ?>
					
					
					
					
     

   		<?php /*
   		<div class="conteudo">
   			Conteúdo da aba 2
   		</div>


   		<div class="conteudo">
   			Conteúdo da aba 3
   		</div>    


   		<div class="conteudo">
   			Conteúdo da aba 4
   		</div>     
   		*/ ?>



         		</div>   <!-- .texto -->
          	</div><!-- .bloco -->
          	
         
     
     
           <?php     
           
           $orderCount +=1;
            };
            
            ?>

 
 


 
		    <br/>
   
		    <?php
   	
		 	$paginaAnt = $pagina-1;
		 	$paginaPost = $pagina+1;
			
			
		 
		    ?>
			
			<?php //if($urlAdicionalPagina ==''){  //  SE PESQUISA DESATIVADA  ?>
				
				
				
		    <?php if($pagina>1){ ?>
		      <p class='nextPage' style="float:left"> <a href='?page=lista_pedidos&pagina=<?php echo $paginaAnt.$urlAdicionalPagina; ?>'>Pagina Anterior</a> </p><br/>
		 	 <?php }; ?>
	 
	 
		    <p class='nextPage'  style="float:left;margin-left:20px;margin-top:-10px;" > <a href='?page=lista_pedidos&pagina=<?php echo $paginaPost.$urlAdicionalPagina; ?>'>Próxima Pagina</a> </p>
			<?php //}; //  SE PESQUISA DESATIVADA;  ?>
   
   
		    <div class='clear'></div>
   
		    <div id="trocarstatus"></div>
			
			
   
   <h3>Escolha acima os pedidos que deseja editar  </h3>

   <br/>  

	<select id="statusID" name="statusID" class='statusChange' rev='-'>
		<option value="0">Mudar Status</option>
       <option value="PENDENTE">PENDENTE</option>
       <option value="VERIFICANDO">PAGAMENTO EM VERIFICAÇÃO</option>
       <option value="APROVADO">APROVADO</option>
       <option value="SEPARACAO">PRODUTOS EM SEPARAÇÃO</option>
       <option value="TRANSPORTADORA">ENCOMENDA ENTREGUE A TRANSPORTADORA</option>  
       <option value="ENTREGUE">ENTREGUE</option>
       <option value="CANCELADO">CANCELADO</option>     
    </select>  


    <br/>
	
	 
	
	<?php
	$msgPedidoPendente  = get_option('msgPedidoPendenteWPSHOP');
	$msgPedidoVerificando= get_option('msgPedidoVerificandoWPSHOP');
	$msgPedidoAprovado= get_option('msgPedidoAprovadoWPSHOP');
	$msgPedidoSeparacao	= get_option('msgPedidoSeparacaoWPSHOP');	
	$msgPedidoTransportadora= get_option('msgPedidoTransportadoraWPSHOP');		
	$msgPedidoEntregue	= get_option('msgPedidoEntregueWPSHOP');		
	$msgPedidoCancelado= get_option('msgPedidoCanceladoWPSHOP');
    ?>
	
	
	
     <div style='display:none'>
		<div id='msgPENDENTE'><?php echo $msgPedidoPendente; ?></div>
		<div id='msgVERIFICANDO'><?php echo $msgPedidoVerificando; ?></div>
		<div id='msgAPROVADO'><?php echo $msgPedidoAprovado; ?></div>
		<div id='msgSEPARACAO'><?php echo $msgPedidoSeparacao; ?></div>
		<div id='msgTRANSPORTADORA'><?php echo $msgPedidoTransportadora; ?></div>
		 <div id='msgENTREGUE'><?php echo $msgPedidoEntregue; ?></div>
		<div id='msgCANCELADO'><?php echo $msgPedidoCancelado; ?></div>
		
	</div>
	
	
	<br/>
    <p>Preencha abaixo para fazer uma anotação sobre a mundança no status do pedido.<br/> Esta mensagem será encaminhada por email ao cliente.</p>
	<br/>
		
	    <br/><small><strong class='red'>NOVO: </strong> Agora pode definir uma mensagem  padrão para cada STATUS do pedido .Para  edita as mensagens de status do pedido<a href='<?php bloginfo('url'); ?>/wp-admin/admin.php?page=lista_translate'>Clique aqui </a> .  </small>
	 	<br/>
		
		
<br/>
    <textarea name="comentario" id="comentario" style="width:50%;height:150px;" ></textarea>
    <br/>
    
    

   <input type="submit"  name="submit" value="Gravar" onclick="return recordAction('Gravar');" />
   <input type="submit"  name="submit" value="Deletar" onclick="return recordAction('Delete');" /> 

   <input type="submit"  name="submit" value="Imprimir" onclick="return recordAction('Imprimir');" />        

   <input type="submit"  name="submit" value="Emitir" onclick="return recordAction('Emitir');" />       

 
<input type='hidden' name='oidS' value='<?php echo $oid; ?>'  />
<input type='hidden' name='oemailS' value='<?php echo $oemail; ?>'  />
<input type='hidden' name='pesquisarStatusS' value='<?php echo $pesquisarStatus; ?>'  />
<input type='hidden' name='pesquisarPagtoS' value='<?php echo $pesquisarPagto; ?>'  />
<input type='hidden' name='onomeS' value='<?php echo $onome; ?>'  />
<input type='hidden' name='osobrenomeS' value='<?php echo $osobrenome; ?>'  />

<input type='hidden' name='oDataPS' value='<?php echo $oDataP; ?>'  />
 
 
 <input type='hidden' name='lastPage' value='<?php echo $pagina; ?>'  />
 


	</div><!-- .content -->


 

	</form>

 
                    
 
 
 
           		<script>  
           	  
           	 
           		function checkAll(field){
           		for (i = 0; i < field.length; i++)
           			field[i].checked = true ;
           		}

           		function uncheckAll(field){
           		for (i = 0; i < field.length; i++)
           			field[i].checked = false ;
           		}

           		function selectCheckBox(){
           		    
           			field = document.getElementsByName('list[]');
           			
           			var i;
           			
           			ch	= document.getElementById('check');
           			
           			if(ch.checked){
           				checkAll(field);
           			}else{
           				uncheckAll(field);
           			}
           			
           		}   



           		function recordAction(tipo){ 
           		    
           			var flag   = false;
          
                    var chklength = document.getElementsByName("list[]").length;
                    
           			for(i=0;i<chklength;i++){
           			    
           			    flag = document.getElementById("check_"+i).checked;
           			    if(flag == true ){
           			   	  break;
           				};
           				
           			};
           			
           		     
           			if(flag == false){

           			if(tipo=="Delete"){
           			     alert("Por Favor, antes de prosseguir Selecione um pedido para deletar");
           				 return false; 
           			}else{
           			   	 alert("Por Favor, antes de prosseguir Selecione um pedido para editar");
           				 return false;				
           			};
           			

           			};  

 
                    if(tipo=="Delete"){
           			       if(!confirm('Você realmente deseja apagar este(s) pedido(s)')){
           			       return false;
           			       };
           		    }else{
						   if(tipo=="Gravar"){
        				   if(!confirm('Você realmente deseja editar este(s) pedido(s) ?')){
        				   return false;
        		           };
					       }else{
							   txt = "emitir";
							   if(tipo=="Imprimir"){
								    txt = "imprimir";
							   };
           				   if(!confirm('Você realmente deseja '+txt+' este(s) pedido(s) ?')){
           				   return false;
           		           };
						   };	
           		    };
               return true;
          };     
          
          
          
          
		  
		  
     		function alterarStatusPedido(tipo){ 
     		  
				if(tipo=="Gravar"){
  				   if(!confirm('Você realmente deseja editar este(s) pedido(s) ?')){
  				   return false;
  		           };
			     }else{
     				   if(!confirm('Você realmente deseja imprimir este(s) pedido(s) ?')){
     				   return false;
     		           };
				  };	
     	 
                   return true;
              };   
	
	
		  
		  
		  
          
                 	 jQuery('.seta').click(function(){
                 	     rel = jQuery(this).attr('rel');
                 	     jQuery('.texto').hide();
                 	     jQuery('#'+rel).show();
                 	 });   
                 	 
                 	 
                 	 
                 	 
                 	 
                 	         jQuery('.verHistorico').click(function(){
                                   rel = jQuery(this).attr('rel');
                                   jQuery('.'+rel).fadeIn();

                               });
                               
      jQuery('.bttrocar').click(function(){
       rel = jQuery(this).attr('rel');
        jQuery('input#'+rel).attr('checked','checked');
      });
                      

 jQuery('.btUpdate').click(function(){
	 
	 
      rel = jQuery(this).attr('rel');
	  rev = jQuery(this).attr('rev');
	 
	    field = document.getElementsByName('list[]');
 		for (i = 0; i < field.length; i++){
 			field[i].checked = false ;
 		};
        jQuery('input#'+rel).attr('checked','checked');
	  
	  statusV = jQuery('#statusID'+rev).val(); 
	 
	  msgV = jQuery('#comentario'+rev).val(); 
	  
	  // alert(statusV);
	  // alert(msgV);
	  jQuery('#comentario').val(msgV);
	  jQuery('#statusID').val(statusV);
	  

      if(!confirm('Você realmente deseja editar este(s) pedido(s) ?')){
          return false;
      }else{
      	 return true;
      }
    	

      
	
});




jQuery('.statusChange').change(function(){
	  newStatus = jQuery(this).val();
	  rev = jQuery(this).attr('rev');
	  textoPadrao = jQuery("#msg"+newStatus).text();
	  jQuery('#comentario').val(textoPadrao);
	  jQuery('#comentario'+rev).val(textoPadrao);
});

 

 </script>
       	
       	
       	
       	
       	
	
	
	

		<?php
 
	   }else{
		?>
		    <h2> Não há pedidos realizados </h2>
	  <?php }; };//FINAL PAGINA-------------------------------?>
