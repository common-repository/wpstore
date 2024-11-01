<?php

global $current_user;
get_currentuserinfo();
$idUser = $current_user->ID;


$etiquetaRemetenteDesativar =get_option('etiquetaRemetenteDesativarWPSHOP');
$agruparEnderecos =get_option('agruparEnderecosWPSHOP');
$impressaoAgrupada = "";
    


if($idUser>0 &&  current_user_can( 'manage_options' ) ){
	
}else{
    
    $idLogin = get_idPaginaLogin();
    $pageLogin = get_permalink($idLogin);
    echo "<script>window.location='".$pageLogin ."'</script>";
};



$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
};
 
		    
		    $order = trim($orderNum);
		 
      
        	$arrOrder = explode('.',$order);
        	
        	$idUser = 	intval($arrOrder[0]);
        	
			 
	        $user_info = get_userdata($idUser);
			
			$userCpf = trim(get_user_meta($idUser,'userCpf',true)); 

	        $userLogin =  $user_info->user_login;
	        $userEmail =  $user_info->user_email;


	        $displayNameUser="$user_info->user_firstname  $user_info->user_lastname"; 

	  
            $userEndereco = trim(get_user_meta($idUser,'userEndereco',true));if($userEndereco==""){$userEndereco="";};
			
            $userEnderecoNumero = trim(get_user_meta($idUser,'userEnderecoNumero',true));if($userEnderecoNumero==""){$userEnderecoNumero="";};
			
            $userComplemento = trim(get_user_meta($idUser,'userComplemento',true));if($userComplemento==""){$userComplemento="";};
			
            $userCidade = trim(get_user_meta($idUser,'userCidade',true));if($userCidade==""){$userCidade="";};
			
            $userBairro = trim(get_user_meta($idUser,'userBairro',true));if($userBairro==""){$userBairro="";};
			
            $userEstado = trim(get_user_meta($idUser,'userEstado',true));if($userEstado==""){$userEstado="";};
			
            $userCep = trim(get_user_meta($idUser,'userCep',true));if($userCep==""){$userCep="";};
			
            $userDDD = trim(get_user_meta($idUser,'userDDD',true));if($userDDD==""){$userDDD="";};
			
            $userTelefone = trim(get_user_meta($idUser,'userTelefone',true));if($userTelefone==""){$userTelefone="";};

            $userDDD2 =  trim(get_user_meta($idUser,'userDDDCel',true));if($userDDDCel==""){$userDDDCel="";};
			
            $userTelefone2 =  trim(get_user_meta($idUser,'userTelefoneCel',true));if($userTelefoneCel==""){$userTelefoneCel="";};

	        $plugin_directory = str_replace('layout/','payment/',plugin_dir_url( __FILE__ ));
	        
	      
            global $wpdb;
            $tabela = $wpdb->prefix."";
            $tabela .=  "wpstore_orders";
			
			
			
		  
		  

            
                $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_pedido`='$order'    ORDER BY `id`  DESC LIMIT 0,1" ,1,'') );
           

            $tipo_pagto = ""; 
            $status_pagto = "";
 
 
             $comentario_admin ="";
             
             $valor_total = 0.00;
             
             $frete  = "";

            foreach ( $fivesdrafts as $fivesdraft ){

                $idPedido = $fivesdraft->id_pedido;
            	$valor_total = $fivesdraft->valor_total;    
                        
            	$frete = $fivesdraft->frete;
                $tipo_pagto = $fivesdraft->tipo_pagto;
                $status_pagto = $fivesdraft->status_pagto;
                $comentario_cliente = $fivesdraft->comentario_cliente ;
                $comentario_admin = $fivesdraft->comentario_admin;
				        $extras = floatval($fivesdraft->extras);
                $extraInfo = $fivesdraft->extras;
                //echo "ID Pedido : ".$idPedido ."<br/><br/>";
            	//echo "Valor : R$".$valor_total."<br/><br/>";
            	//echo "Frete : ".$frete."<br/><br/>";
            	//echo "Tipo de pagamento : ".$tipo_pagto."<br/><br/>";
            	//echo "STATUS : ".$status_pagto."<br/><br/>";
				 

            	//$totalPagto = custom_get_sum($valor_total,floatVal($frete));
				
				
				
                $precoAdddArray = explode('(R$',$frete);
       	        $tipoFrete = $precoAdddArray[0];
                $frete= str_replace(')','',$precoAdddArray[1]);
                $frete =  str_replace(',','.',$frete);
				
				
                $vt = $valor_total;
			 
			    if(strlen($vt)>6){
                     $vt = str_replace('.','',$vt);
			    };
			    $vt = str_replace(',','.',$vt); 
			    $vt = floatval($vt);
			
				 //DESCONTO ---------------------------------
				
	   			$pct = "";
	   			$desconto = "";
	   			$valorDeconto = "";

 				 	 // $totalPagto = $vt+floatVal($frete);
       	 $totalPagto = $vt;
  
	
	
			   $pos = strpos($extraInfo,"DESC-");
			   if($pos === false) {
			         $extras = floatval( $extraInfo);
			   	     $valorDesconto = 0;
			   }else{
			   	     $extras = "";
			         $pct = intval(str_replace('DESC-','', $extraInfo));

			         $precoSoma = $totalPagto;  

					     if(strlen( $precoSoma )>6){
					     $precoSoma = str_replace('.','', $precoSoma );
					     };  
				  	   $precoSoma = str_replace(',','.', $precoSoma );//CENTAVOS CIELO

			         $desconto =   floatval(number_format($precoSoma *$pct / 100,2,'.',''));
			         $valorDesconto  =   $desconto;
			   };
			   
			  
					 
			    	$vtf =  $totalPagto  - $valorDesconto;
			     	$vtfFinal =  $totalPagto  - $valorDesconto;
						
							$vtfFinal = 	$vtfFinal+floatVal($frete);
			    //DESCONTO ---------------------------------
			
			   
			   
			      
            	
 
            	//echo "Observações1 : ".$comentario_cliente."<br/><br/>";
                //echo "Observações2 : ".$comentario_admin."<br/><br/>";
                
                $dataArray = explode('.',$idPedido);

                $get_total_Products = custom_get_total_products_in_order($idPedido);

               
            };
 
        
        if($status_pagto=="PENDENTE"){
			$cor = "#ff5f76";
			}elseif($status_pagto=="APROVADO"){
			$cor = "green";
			}else{
		   	$cor = "red"; 
			};
      

                $cupom=  getCupomInfos($comentario_admin);  
                
                $numeroCupom = $cupom[0];
         
                $desconto = 0.00;
                   $vt =$valor_total;
                   $vt = str_replace('.','',$vt);
                   $vt = str_replace(',','.',$vt);
                   $vt = floatval($vt);


                    if($cupom[1]=="Valor"){ 
                       $msg =  $cupom[1]."  $moedaCorrente  ".$cupom[2];
                       $desconto = floatval(str_replace(',','.',$cupom[2]));
                     }elseif($cupom[1]=="Percentual"){ 
                       $msg = $cupom[1]." " .$cupom[2]."%" ;  
                       $desconto = ( $vt*floatval(str_replace(',','.',$cupom[2])) ) / 100 ;
                     };
                    
                    
                     $precoAdddArray = explode('(R$',$frete);
            	    // $tipoFrete = $precoAdddArray[0];
            	     
            	 
                     $freteV= str_replace(')','',$precoAdddArray[1]);
                     $freteV =  floatVal(str_replace(',','.',$freteV));
 
                   //	$vtf = $vt-$desconto ;
              
                   	$vtf = $vt ;   
					
					
         
		   		    if($extras>0){
		   			   $vtf += $extras;
		   		    };
					
              	
                    $totalPagto = getPriceFormat(custom_get_sum( $vtf,$freteV));
                    
           
                    
                    
                    
                    
                    
 
                $orderPrint ="
		
			<section class='content '>
              <h2>Pedido : $order</h2>
                    ";  
                    
                          
                          
                    
                    
                      	 $orderPrint .= "    
 
                                     <div class='pagamento'>
									 
									 <table id='detalhesPedido' class='table'>
										<tr>
											<thead>
												<th style='color:#222;' >ID do pedido:</th>
												";
												
											/* $orderPrint .= "<th>Metodo de Pagamento:</th> "; */
											
										    $orderPrint .= "<th style='color:#222;' >Status do pedido:</th>
												<th style='color:#222;'>Tipo Pagto:</th>
												<th style='color:#222;'>Data:</th>
												<th style='color:#222;' >Sub-total:</th>
												<th style='color:#222;' >Frete:</th>";
												
											if($extras>0){	
											$orderPrint .= "<th style='color:#222;' >Extras:</th>";
											}
											
											if($desconto>0 || $valorDesconto >0){	
											$orderPrint .= "<th style='color:#222;' >Descontos:</th>";
											}	
												
												 $orderPrint .= "
												
												<th style='color:#222;'>Total:</th>
											</thead>
										</tr>
										
										<tr>
											<td>$order</td>";
											
											
											
					   /*$orderPrint .="<td>$tipo_pagto</td>";*/
				       $orderPrint .= "
						   
						   
						   <td>$status_pagto</td><td>$tipo_pagto</td>
											<td>".$dataArray[4] ."/ ".$dataArray[3]." / ".$dataArray[2]."</td>
											<td>R$$valor_total</td>
											<td>";
											
											
											
								if($tipoFrete=="Frete Grátis para sua cidade"){
									$orderPrint .="gratis";				
								}else{
									$orderPrint .="($tipoFrete) $moedaCorrente $frete";	
							   };
											
											
											
										  $orderPrint .=	"</td>  ";
										if($extras>0){	
											  	$orderPrint .= "<td>R$$extras</td>";
										}
										
								 
										
										if($desconto>0 || $valorDesconto>0){	
											  	$orderPrint .= "<td>R$$valorDesconto</td>";
										}
										
											
									      $orderPrint .= "
											  <td>R$$vtfFinal</td>
										</tr>
									</table>
											
                                

                                	</div>


                                     ";
                                     
                                     
                    
                    if( $numeroCupom  !=""){  
                        
                        



                       	     $obs = "";
                       	     
                       	     	$vtf2 = $vt-$desconto ;
                              if( intval($vtf2 )<0){
                                 $positivoTotal = str_replace('-','',$vtf2 );
                                  $obs = " <span style='font-size:0.8em;color:red'>Seu cupom é maior que o total de suas compras . Em breve você receberá um  novo cupom no valor de $positivoTotal. </span><br/><br/>";
                                     $comentario .= $obs;
                                 $comentario .= $obs;
                                 $vtf = "0.00";
                              }


                        
                          $orderPrint .="<b>Cupom Desconto :</b>  $numeroCupom <br>
                    <b>Valor do Desconto :</b>  $moedaCorrente   $desconto <br><br>$obs";   
					  
					  
					  
					  }; 
                    
                    
                              
                  
                  
                  
                  
                    
					
					
                        $idCob = get_id_addr_cobranca($idUser,$order); 
						
                        $userAddress = get_user_address_by_id($idCob);  
                        $cepUm =  "";
                        $cepDois =  ""; 
						
						
                        foreach ( $userAddress as $address ){   
                           $cep =  explode('-',$address->cep);
                           $cepUm =  $cep[0];
                           $cepDois =  $cep[1];
                           $userEndereco = $address->endereco;  
                           $userEnderecoNumero = $address->numero;  
                           $userBairro = $address->bairro; 
                           $userCidade  =  $address->cidade;
                           $userEstado = $address->estado; 
                           $userComplemento =  $address->complemento;  
                           $userCep = $cepUm."-".$cepDois; 
                           $tipoENd = $address->tipoEndereco; 
                           $ref =  $address->referencia; 
                            
                           }; 
                           
						   
						   
			    		   $replace = array('- de','- até','- lado');
			    		    $userEndereco= str_replace($replace ,'301red', $userEndereco);
			    		   $explode = explode('301red', $userEndereco);
	   
	   
			    		   if( count($explode)>0 ){
			    		       $userEndereco =  $explode[0];
			    		   };
	   
	   
	   
						   
						   
						   
      					    $userCnpj = trim(get_user_meta( $idUser,'userCnpj',true));  
      						$tituloDoc = "CPF";
      						if($userCnpj !=''){
      							$tituloDoc = "CNPJ";
      							$userCpf =  $userCnpj;
      						}
						
						
						
			  			 if($print ==false){	
				 	  
			  	         $orderPrint .="
			  		      <h2>Dados do Cliente</h2>
			                <p>Nome: $displayNameUser  | $tituloDoc  : $userCpf  | Tel: $userDDD $userTelefone --  $userDDDCel $userTelefoneCel</p>
			  			  <hr/>
			  			  ";     
           
			  		     };        
					      
						  
						                    $userComplemento = str_replace('***REF','<br/><strong>Referência</strong>',$userComplemento);
    
                	 $orderPrint .= "    
                	
                	 
                  	        
                               <div class='pagamento' style='float:left;width:250px;margin-right:40px'>
					 
					  	       <h2>Endereço Fatura</h2>
							
								<div class='detalhesPedido'>
                                
								<p><strong>Endereço:</strong>$userEndereco - $userEnderecoNumero</p>
									 
								<p><strong>Complemento:</strong>$userComplemento $tipoENd $ref</p>
								
								<p><strong>Estado:$userEstado </strong>- <strong>Cidade</strong>: $userCidade  <br/><strong> Bairro:</strong>$userBairro - <strong>CEP:</strong> $userCep</p>
						 
								
								<p><strong>DDD - Telefone</strong>: $userDDD - $userTelefone <br/> <strong>DDD - Telefone2:</strong>  $userDDD2 - $userTelefone2</p>
        							 
                        	    </div>

                        	    </div>
					 
                       
                             ";
                
                
                     $tabela = $wpdb->prefix."";
                    $tabela .=  "wpstore_orders_address";

                    $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$idPedido' ORDER BY `id`  ASC  ",1,'' ) );

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
				 
				 
			
	     		  $nomeDestinatario = $displayNameUser;
				  

    		   $replace = array('- de','- até','- lado');
    		    $userEndereco= str_replace($replace ,'301red', $userEndereco);
    		   $explode = explode('301red', $userEndereco);
	   
	   
    		   if( count($explode)>0 ){
    		       $userEndereco =  $explode[0];
    		   };
	   
	   
	   
	     		  $enderecoDestinatario = $userEndereco." - ".$userEnderecoNumero;
	     		  $complementoDestinatario =  str_replace('***',' - ', $userComplemento);
	     		  $bairroDestinatario = $userBairro;
	     		  $cidadeDestinatario = $userCidade;
	     		  $estadoDestinatario = $userEstado;
	     		  $cepDestinatario =  $userCep;




		   
		   
                  $userComplemento = str_replace('***REF','<br/><strong>Referência</strong>',$userComplemento);
 
                            	 $orderPrint .= "    
                      
								   <div class='pagamento'  class='pagamento' style='width:250px;float:left' >
										 
                                 <h2>Endereço Entrega</h2>
                            	 
										 
									<div class='detalhesPedido'>
                                    <p> <strong>Endereço:</strong> $userEndereco  - <strong>Numero:</strong>$userEnderecoNumero <br/>
									<strong>Complemento:</strong> $userComplemento</p>
									
                            		<p><strong> <strong>Estado:</strong> $userEstado - <strong>Cidade:</strong> $userCidade <br/> Bairro:</strong> $userBairro - <strong>CEP:</strong>$userCep</p>
                                    </div>
						
						
						
						   </div>
						   
						   
						   <div class='clear'></div>
						   
						   ";


                
                
                
                
                
                $orderPrint .= " 
                
               
                
                
                <h2>Produtos</h2>
                
                "; 
                
                
              
			  
			   
 
			    $orderPrint .="
 

			    <section class='cart'>



			    	<table class='table' style='width: 100%;'>
			                <thead>
			                    <tr>
			                    	<td class='hide-phone'>Imagem</td>
			                        <td class='ta-left'>Nome do Produto</td>
			                        <td class='ta-left hide-phone'>Variação</td>
			                        <td class='ta-left'>Quantidade</td>
			                        <td class='ta-right'>Preço Unidade</td>
			                        <td class='ta-right'>Total</td>
			                    </tr>
			                </thead>

			                <tbody> ";  
            
			               //print_r($arrayCarrinho);
            
			               $subtotal = 0;
			               $pesoTotal = 0;
            
        
        
           
			                    $tabela = $wpdb->prefix."";
			                   $tabela .=  "wpstore_orders_products";

			                   $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$idPedido' ORDER BY `id`  ASC  " ,1,'') );

			                   // Adicionando PRODUTOS

			                   foreach ( $fivesdrafts as $item=>$fivesdraft ){
                      	 	 	 	 	
                     
			                                    $id_produto = $fivesdraft->id_produto;
			                                    $preco = $fivesdraft->preco;
			                                    $variacao = $fivesdraft->variacao;
			                                    $qtdProd = $fivesdraft->qtdProd;
			                                    $precoAlt = $fivesdraft->precoAlt;
			                                    $precoAltSymb = $fivesdraft->precoAltSymb;
			                                    $sinal = $precoAltSymb;
                 
                
			                   $postID = intval( $id_produto);
                
			                   if($postID>0){
                    
                   
			                       if($variacao==""){
			                           $variacao="-";
			                       }
                    
               
			                      $precoSoma = $preco;
                   
			                               if(strlen($precoSoma)>6){
			                                $precoSoma= str_replace('.','',$precoSoma );
			                               };
			                                 $precoSoma = str_replace(',','.',$precoSoma);   
                              
			                          $precoAlt = floatval(str_replace(',','.',$precoAlt));  
                       
			                                      if(strlen($precoAlt)>=6){
			                                       $precoAlt =  str_replace('.','',$precoAlt);
			                                       $precoAlt =  str_replace(',','.',$precoAlt); 
			                                       }else{
			                                       $precoAlt =  str_replace(',','.',$precoAlt);
			                                       };
                                    
                                     
                                      
			                        if($sinal=="-"){
			                        $precoSoma = $precoSoma -  $precoAlt;  
			                        }elseif($sinal=="+"){
			                        $precoSoma = $precoSoma +  $precoAlt;    
			                        };   
          
			                      $qtd = intval($qtdProd);
                   
                   
			                      $precoLinha =    getPriceFormat($qtd*$precoSoma) ;
                   
			                      $subtotal += $qtd*$precoSoma;
			                      $extra ="";
			                       if(floatval($precoAlt)!=0){
			                      $extra = "($sinal $moedaCorrente$precoAlt)";
			                      };
			               
                
                
                
                
			                   $categories = "<span style='font-size:10px'><strong>Categorias do produto:</strong></span>";


			                   foreach((get_the_category($postID)) as $category) { 
			                       $categories .= "<span style='font-size:10px'>".$category->cat_name.", </span>"; 
			                   }




			                   $orderPrint .="

                
                
       
			            <tr>
			            	<td width='1' class='ta-center hide-phone'><a href='".get_permalink($postID)."'>".custom_get_image($postID,50,50,true,false)."</a></td>
			                <td><a href='".get_permalink($postID)."'>".get_the_title($postID)."</a> ($categories ) </td>
			                <td class='hide-phone'>".$variacao."  </td>
			                <td>
			                $qtdProd 
			                </td>
			                <td class='ta-right'>$moedaCorrente $preco <br/> $extra </td>
			                <td class='ta-right'>$moedaCorrente $precoLinha  </td>
			        	</tr>
      
			               	";  
							
							 };  
						 
						  };  

			                      $orderPrint .="

           
        
			           <tfoot>
			                  <tr>
			                  	<td colspan='6'>
			                      	<div class='float-right'>

			                  

			                           ";
                        
			                           if($numeroCupom !=""){  
 
			                                 $orderPrint .="
 
			                                <b>Cupom Desconto :</b>$numeroCupom;<br>
			                                  <b>Valor do Desconto :</b> $moedaCorrente$desconto<br>
			                                  <b>Valor (sem Frete) :</b> $moedaCorrente$totalPagto <br><br>
                               
			                                  "; 
										  
										  
										  };  

			                                            $orderPrint .="

                               
                               
			                                  </div>
			                                  <div class='float-right ta-right'>
                           
			                              	
                           	  	 
			                              	  	 ";
                           	  	 
			                              	  	
												 if($numeroCupom !=""){ 
													 
													  $orderPrint .=" <h4> 	Desconto :  </h4>"; 
												   }; 
												   
												     $orderPrint .="
			                           
			                              </div>
			                          </td>
			                      </tr>
			                  </tfoot>
               
			               </tbody>
			           </table>
     
			   </section><!-- .cart -->

			    	<div class='clear'></div>
					
					"; 

 
          $orderPrint .=   "    </section> 
			  <div class='breakPage'></div>
			 "; 
		  
		  //IMPRIME ETIQUETAS DE ENTREGA :
		  
		  
		  
	        $ruaEndereco  = get_option('ruaEndereco');
	        $cepEndereco  = get_option('cepEndereco');   
	        $enderecoEndereco  = get_option('enderecoEndereco');      
			
			
			
            $dadosImpressao =  "
		   	<div  style='float:left;margin-right:30;border:1px solid #eee;padding:10px;width:40%;height:220px;margin-bottom:10px'>
		   <h3>Remetente</h3>";
		   
		   
		   $replace = array('- de','- até','- lado');
		   $ruaEndereco= str_replace($replace ,'301red',$ruaEndereco);
		   $explode = explode('301red',$ruaEndereco);
		   
		   
		   if( count($explode)>0 ){
		      $ruaEndereco = $explode[0];
		   };
		   
		   
   			$dadosImpressao .=  "<p>".get_bloginfo('url')."</p>";
   		 	$dadosImpressao .=  "<p>".$ruaEndereco." <br/> $enderecoEndereco  <br/> $cepEndereco </p>";
   			$dadosImpressao .=   "</div>";
			
			
			
			
			
			
 		   $replace = array('- de','- até','- lado');
 		   $enderecoDestinatario= str_replace($replace ,'301red',$enderecoDestinatario);
 		   $explode = explode('301red',$enderecoDestinatario);
		   
		   
 		   if( count($explode)>0 ){
 		      $enderecoDestinatario =  $explode[0];
 		   };
		   
		   
		   
		   //remove comentario
		   $complementoDestinatarioArr = explode('- REF:',$complementoDestinatario);
		   if(count($complementoDestinatarioArr)>0){
		   	 $complementoDestinatario = $complementoDestinatarioArr[0];
		   }
		   $dadosImpressao2 =  "
			   	<div  style='float:left;margin-right:30;border:1px solid #eee;padding:10px;width:40%;height:220px;margin-bottom:10px'>
		   <p>Pedido :$order <br>
		   <h3>($tipoFrete)</h3></p>    
		   <h3>Destinatário</h3>";  
		   $dadosImpressao2 .=   "<p>$nomeDestinatario</p>";
		   $dadosImpressao2 .=   "<p>$enderecoDestinatario  / $complementoDestinatario <br/>  $bairroDestinatario - $cidadeDestinatario - $estadoDestinatario   <br/> CEP : $cepDestinatario </p>";
		   $dadosImpressao2 .=  "
			
			</div> ";
			
			 
		    
 		   if(  intval($index) !=0 &&  intval($index) !=10 && ( intval($index)== 7 || (  intval($index)  % 8) == 0 )  ){
		   	   $dadosImpressao2 .=  "
				    <div class='breakPage'></div>
				     <div class='clear' style='clear:both'></div>
					  <br/> 
			       ";
 		   };
			
		   
		 
		    if($agruparEnderecos=='sim'){
				
		        if($etiquetaRemetenteDesativar!='sim'){
			       $impressaoAgrupada .= $dadosImpressao;
		        };
				   $impressaoAgrupada .= $dadosImpressao2;
		     }else{
 		         if($etiquetaRemetenteDesativar!='sim'){
 			       $orderPrint .=  $dadosImpressao;
 		         };
		     	 $orderPrint .=  $dadosImpressao2;
				 $orderPrint .="<div class='breakPage'></div> <div class='clear' style='clear:both'></div><br/> ";
		     }
		
                     
         $orderPrintB .= "</section>"; 
		 
		 echo  $orderPrint;
		 
?>