<?php

	require("../../../../../wp-load.php");

     global $current_user;
	   $pedidoID = "";
	 
	   $produtoSemFrete = false;
     $marcouFalse = false;     
	 
     get_currentuserinfo(); 
            
     $tipoPagto = addslashes($_POST['tipoPagto']);
     $formaPagamento= addslashes($_POST['formaPagamento']);
     $parcelas = addslashes($_POST['parcelas']);
     $codigoBandeira   = addslashes($_POST['codigoBandeira']) ;
     $radioFrete    = addslashes($_POST['radioFrete']) ; 
     $msgError = "";
     $idUser = $current_user->ID;
     $update = false;   
	 
					
	   $tipoFreteR = "";
     $cidade = "";  
     $valorFreteT = 0.00;
			  
	   $msgFrete = "";
     $msg = "";
	 
	   $freteGratisGlobal = false;
		 
		 $desconto = 0;
                                 
         
     $user_email =  $current_user->user_email ;
              
     if(intval($current_user->ID)<=0){
          $msgError =  "Permissão Administrativa negada";
     }
                    
     if($msgError=="" ){
               
          if($_REQUEST['tipoPagto']!=''){   
                            
                 $valor = custom_get_total_price_session_order(); 
				         $valorC = $valor;
				 
				        if($valor>0){ 
					  
				                $tipoFrete = floatval($radioFrete); 
										
                        $enderecoEntrega  = trim(get_user_meta($idUser,'idEntrega',true));  
									    
                      $address = get_endereco_entrega($enderecoEntrega);  
				 
										     
                        $cepEntrega = $address['cepUm'].$address['cepDois'];
									 
												if($cepEntrega==""){
													$cepEntrega = $address['cep'];
												}
												
												 
                        $userCep2 =    $address['cepUm'].$address['cepDois'];
									   
                        $userEstado2=   $address['estado'];
									   
                        $userCidade2=   $address['cidade'];
									   
                        $userBairro2=    $address['bairro'];
									   
                        $userEndereco2=  $address['endereco'];
									   
                        $userEnderecoNumero2=    $address['numero'];
                                      
						$userComplemento2 =   $address['complemento']; 
									   
                        $userComplemento2 .=  " ***REF: ".$address['referencia'];

						 $comentario = "";
						 
						 
						 
						 
						
             $vt =$valor;
						 
			
            // $vt = str_replace('.','',$vt);
//$vt = str_replace(',','.',$vt);
            // $vt = floatval($vt);
						 
						 

                         if($_SESSION['cupomDesconto']){
                                $info = $_SESSION['cupomDesconto'];
                                $infoCupom =  explode('***',$_SESSION['cupomDesconto']);
                                $numeroCupom = $infoCupom[0];
                                $tipoDesconto = $infoCupom[1];
                                $valorDesconto = $infoCupom[2];
                                $info = "$numeroCupom***$tipoDesconto***$valorDesconto";
                                $total = getCupomDisponivel($numeroCupom);

                                if($total>0){ // se limite cupom ok
																	
                                  $comentario = $info;
                              
								                addUseCupom($info);
								                unset($_SESSION['cupomDesconto']);
																
																//CUPOM DESCONTO -------------
																
																
																if($tipoDesconto=='Percentual'){
																	$desconto = ( $vt*floatval(str_replace(',','.',$valorDesconto)) ) / 100 ;
																}else{
																	$desconto = $valorDesconto;
																}
																 
																   }; // se limite cupom ok
																	 
																//CUPOM DESCONTO -------------
                            };           
                                                
																				
								          $desconto = number_format($desconto,2,'.','');		
															
											   // echo "////".$desconto."////";
																											 
                            $obs = "";
                            
							              if( intval($valor)<0){
                               $positivoTotal = str_replace('-','',$valor);
                               $obs = "<br/><span style='font-size:0.6em;color:red'>Seu cupom é maior que o total de suas compras . Em breve você receberá um  novo cupom no valor de $positivoTotal. </span><br/><br/>";
                               $comentario .= $obs;
                                $comentario .= $obs;
                                 $valor= "0.00";
                              }
                                          
                                              
              // DEFININDO OS VALORES    Para calculo do frete--------------------- 
                                             
                                             
              //definir se frete é grátis para cidade do Usuário - estado**cidade---   
               $freteGratis = false; 
               $cidadesFreteGratis = get_option('cidadesFreteGratis');
		         $msgFrete = "";
               //$arrayCidades = array('Niterói','Niteroi','São Gonçalo','Sao Gonçalo','Rio Bonito','Maricá','Marica','Itaborai','Itaboraí');
                $arrayCidades = array();
               $arrayEstados = array();  

            $estado= ""; 
			//----endereco com base no cep ------------------------------
                                                                			include('shipping/phpQuery-onefile.php');   



										 
             $html = simple_curlA('http://m.correios.com.br/movel/buscaCepConfirma.do',array(
                                                                				'cepEntrada'=>$cepEntrega,
                  'tipoCep'=>'',
                  'cepTemp'=>'',
                  'metodo'=>'buscarCep'));

               phpQuery::newDocumentHTML($html, $charset = 'utf-8');

              $dados = array(
                     'logradouro'=> trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
                    'bairro'=> trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
                    'cidade/uf'=> trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
                   'cep'=> trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
			          ); 

 				//print_r($dados);

         $dados['cidade/uf'] = explode('/',$dados['cidade/uf']);
          $dados['cidade'] = trim($dados['cidade/uf'][0]);
         $dados['uf'] = trim($dados['cidade/uf'][1]);
                           				unset($dados['cidade/uf']);
                 $cidade = $dados['cidade']; 
                 $estado = $dados['uf']; 
				 $cidadeUserF = $estado."**".$cidade;    
                  //endereco com base no cep -------------------------------
                 $arrayEstadosCidades = explode(',',$cidadesFreteGratis);
                 foreach($arrayEstadosCidades as $item=>$value){
                      $arrayValue = explode('**',$value);
                      $arrayEstados[] = trim($arrayValue[0]);
                      $arrayCidades[] = trim($arrayValue[1]); 
                      $cidadeUser = str_replace(' ','',$cidade ); 
                      $cidadePromocao = str_replace(' ','',$arrayValue[1] );

     				 if(  modificaAcento(strtolower($cidadeUserF)) == modificaAcento(strtolower($value)) ){   
                         $freteGratis = true; 
                         $msgFrete = "Frete Grátis para sua cidade";
		                     $freteGratisGlobal = true;
                                     
      			   	 };
				  };


                                                                		  		      if(trim($cidade) ==""){
              $freteGratis = false;
          };
       //definir se frete é grátis para cidade do Usuário - estado**cidade---   
	   
			 	
          if($freteGratis==false){   
                            
					$arrayCarrinho = "";  
					$blogid = intval(get_current_blog_id());  
					
					if($blogid>1){
						$arrayCarrinho =  $_SESSION['carrinho'.$blogid] ;                      
					 }else{
						$arrayCarrinho = $_SESSION['carrinho'];      
					};

		        $arrPodePromo = true; 
									
		         foreach($arrayCarrinho as $key=>$item){ 
					   
					       $postID = intval($item['idPost']);
						     
								 $produtoSemPromoFrete = get_produto_promoFrete_status($postID);
								 
	                if( $produtoSemPromoFrete  == true){                                          $arrPodePromo = false ; 
							        $produtoSemFrete = true;
	 					      }else{
	 					 	        $produtoSemFrete = false;
	 					      };
						 
						      $fg =  produtoPromoFrete($estado."**".$cidade,$postID);
						
						      //if(current_user_can('manage_options'))
				              //echo " $estado**$cidade,$postID =  $fg <br/>";
				       
 						      if( $fg=='gratis'){
 							         $msgFreteGratis  = "Frete Grátis. Este produto tem frete grátis para sua região.";   
 							         $produtoSemFrete = true;
								   }else{
 							   	 			$fg ='';
 							   				$msgFreteGratis  = "";   
 							   	 		 	$marcouFalse = true;
 								 				$produtoSemFrete = false;
 						 			 };
						 
						 
	              };
			
			
				
 				 	   if( $marcouFalse===true){
        			 	   $freteGratis = false; 
						   $msgFreteGratis  = "";  
				 	    };
	
	             	   
						
	  				  if( $produtoSemFrete ==true){
	  					     $freteGratis = true;
	   				  }else{
						  
						    if($arrPodePromo ==false){						
							     $freteGratis = false;				 	   
							};						
				      };
					  
					  
				 }; //elseif freteGratis==false //--------------------------
											
											
				 if($freteGratis==false){   
                                                 
                          $origemCep =  get_option('cepOrigemCorreios');
                                                 
                          $destinoCep = $cepEntrega;
                                                        
                          $CEP_ORIGEM = $origemCep; // SP
                          $CEP_DESTINO = $destinoCep; // CAMPINAS
                                             
                         //$peso =  floatval(get_cart_weight($destinoCep));   
                          $peso =  floatval(get_cart_weight($cidadeUserF));    
						  //echo " $peso - $cidade";
                                           
						   $pesoReal =  $peso;  
                                             
                           if($peso>30){
                                 $peso = 30;
                            }
                            
							              $PESO = $peso;  
                            $VALOR = '40';
                                             
						    /*  */

                            // CHAMADA DO ARQUIVO QUE CONTEM A CLASSE PgsFrete()
                                             //require_once('shipping/fretePgs.php'); //Desabilitando para calculo e-sedex
                             // INSTANCIANDO A CLASSE
                             // $frete = new PgsFrete;
                             // ZERANDO VALORES
                             $valorFrete = 0.0;
                             // CALCULANDO O FRETE
                             //$valorFrete = $frete->gerar($CEP_ORIGEM, $PESO, $VALOR, $CEP_DESTINO); 
						      //echo "PESO : $PESO  -   $CEP_DESTINO";
                              $valorSedex = "";
							  $valorESedex = "";
                              $valorPac = "";  
											 
                            if(is_array($valorFrete) ) {
								
                              $valorSedex = floatval($valorFrete["Sedex"]);
                              $valorPac = floatval($valorFrete["PAC"]);
							  $valorESedex = floatval($valorFrete["ESedex"]);
							  
                            }; 
											 
									
							if(empty($valorFrete )){
							   $checkoutPagto = true;
							   include('../functions/freteCorreiosNew.php');
											  
					   	     }
										 
                                         
                             $moedaCorrente  =  get_option('moedaCorrenteWPSHOP');  
                             $valorF = $valor; 
							 //echo $valorF."+*+*+*";
                             $valorFrete = 0;
							 //echo  $tipoFrete."AAAA";
							 //echo $valorSedex."BBBB";
							 //echo $valorPac."CCCC";
										
							 if($peso>=30 &&  $valorSedex >0){
								  //$pesoReal = intval($pesoReal/$peso);
                                  //$valorSedex =  $valorSedex *$pesoReal;
								  //$valorSedex= number_format( $valorSedex, 2 ,  '.', ''); 
							  };
						
										 
						   if($tipoFrete==$valorSedex){
									 $tipoFreteR = "SEDEX";
                                     $tipoFrete = "SEDEX ($moedaCorrente$valorSedex)"; 
                                     $salvar = true;    
                                      $msg = '1-Cadastrado com Sucesso!';
                                              
                                              if(strtolower($_REQUEST['tipoPagto'])=='cielo' || strtolower($_REQUEST['tipoPagto'])=='moip' ){  
                                 if(strlen($valor)>6){
                                  $valor= str_replace('.','',$valor);
                            	 };  
                             	$valor= str_replace(',','.',$valor);//CENTAVOS CIELO
                             	 //echo $valor."+++++++A";   
                             	 $valor +=$valorSedex;   
                              	 // echo $valor."+++++++B";
                                              
                                 };  
						  
						  	 	$valorFreteT  = $valorSedex; 
                                              
                             }elseif($tipoFrete==$valorPac ){ 
                                               
                             $tipoFreteR = "PAC";
                             $tipoFrete = "PAC  ($moedaCorrente$valorPac)";                              $salvar = true;    
                             $msg = '2-Cadastrado com Sucesso!'; 
                                              
                                              								if(strtolower($_REQUEST['tipoPagto'])=='cielo'  || strtolower($_REQUEST['tipoPagto'])=='moip'  ){     
  								 if(strlen($valor)>6){
                                      $valor= str_replace('.','',$valor);
                                   }   
                                                        
                                 $valor= str_replace(',','.',$valor);  //CENTAVOS CIELO
                                 // echo $valor."+++++++C";      
                                  $valor +=$valorPac; 
                                  //echo $valor."+++++++D";  
                                  //echo $valorPac."+++E";  
                                             
                                  };   
								  $valorFreteT  = $valorPac;   
                              
							  
							   }elseif($tipoFrete==$valorESedex && intval($valorESedex)>2 ){
											   
								   $tipoFreteR = "E-SEDEX";
                                   $tipoFrete = "E-SEDEX ($moedaCorrente$valorESedex)"; 
                                   $salvar = true;    
                                   $msg = '1-Cadastrado com Sucesso!';
                                              
    							   if(strtolower($_REQUEST['tipoPagto'])=='cielo' || strtolower($_REQUEST['tipoPagto'])=='moip' ){  
                                       if(strlen($valor)>6){
                                         $valor= str_replace('.','',$valor);
                                       };  
                                        $valor= str_replace(',','.',$valor);//CENTAVOS CIELO
                                       //echo $valor."+++++++A";   
                                       $valor +=$valorESedex;   
                                        // echo $valor."+++++++B";
                                    };   
									$valorFreteT  = $valorESedex; 
									
                                }else{
									
									
                    			   //if(intval($tipoFrete)<=0){ 
									
									   if($produtoSemFrete ===true){
									
									   $tipoFrete = "Produto Frete Grátis";
								      
									   }else{
										   //aplica valor PAC----
			                               $tipoFreteR = "PAC";
			                               $tipoFrete = "PAC  ($moedaCorrente$valorPac)";                                                         $salvar = true;    
			                               $msg = '2-Cadastrado com Sucesso!'; 
                                              
			                                                								if(strtolower($_REQUEST['tipoPagto'])=='cielo'  || strtolower($_REQUEST['tipoPagto'])=='moip'  ){     
			    								 if(strlen($valor)>6){
			                                        $valor= str_replace('.','',$valor);
			                                     }   
                                                        
			                                   $valor= str_replace(',','.',$valor);  //CENTAVOS CIELO
			                                   // echo $valor."+++++++C";      
			                                    $valor +=$valorPac; 
			                                    //echo $valor."+++++++D";  
			                                    //echo $valorPac."+++E";  
                                             
			                                    };   
			  								  $valorFreteT  = $valorPac;   
										   //aplica valor PAC----
										   //};
									  
			  					   };
									
									
									if(strtolower($_REQUEST['tipoPagto'])=='retirada'){
										$tipoFrete = "Retirar na Loja";
  		   							};
											  
				 				    $valorFreteGratis = get_option('valorFreteGratis'); 
	
				  				  	if( $valor>=intval($valorFreteGratis) && intval($valorFreteGratis)  >0 ){
						  			  $tipoFrete = "Frete Grátis valor pedido";
				 	 				}
		           				 //OU FRETE GRATIS ------------  
												  
                 				if(strtolower($_REQUEST['tipoPagto'])=='cielo' ||       strtolower($_REQUEST['tipoPagto'])=='moip' ){ 
								   
	                				if(strlen($valor)>6){
                        				$valor= str_replace('.','',$valor);
                     			   	};  
														 
                      			    $valor= str_replace(',','.',$valor);//CENTAVOS CIELO
                       			 	//echo $valor."+++++++A";   
                       			 	$valor +=0;   
                      			  	// echo $valor."+++++++B";
                      		  	};   
							    $valorFreteT  = 0; 
					  }; 
										   
									 
                                           
               }else{    
				   		 // IF FRETEGRATIS==false
                         $tipoFrete = "Frete Grátis para sua cidade"; 
						 if($msgFreteGratis !=''){
						    $tipoFrete =	$msgFreteGratis;
						 }
											   
                   if(strtolower($_REQUEST['tipoPagto'])=='cielo' || strtolower($_REQUEST['tipoPagto'])=='moip' ){  
                          if(strlen($valor)>6){
                                 $valor= str_replace('.','',$valor);
                           };  
                          $valor= str_replace(',','.',$valor);//CENTAVOS CIELO
                           //echo $valor."+++++++A";   
                            $valor +=$valorSedex;   
                            // echo $valor."+++++++B";
                                              
                        };
											    
               };      // ELSEIF FRETEGRATIS==false      
                                       
                                   
                                       
    		if(strtolower($_REQUEST['tipoPagto'])=='cielo'){  
          	  	$tipoPagto = "Cielo";     
   	 		}elseif(strtolower($_REQUEST['tipoPagto'])=='pagseguro'){
           	 	$tipoPagto = "Pagseguro"; 
    		}elseif(strtolower($_REQUEST['tipoPagto'])=='paypal'){
            	$tipoPagto = "Paypal"; 
   		 	}elseif(strtolower($_REQUEST['tipoPagto'])=='moip'){
            	$tipoPagto = "Moip"; 
    		}elseif(strtolower($_REQUEST['tipoPagto'])=='deposito'){
           	 	$tipoPagto = "Depósito"; 
    		}elseif(strtolower($_REQUEST['tipoPagto'])=='retirada'){
          	  	$tipoPagto = "Retirar na Loja"; 
    		};    
                                          
										  
	 	   	if(  strtolower($_REQUEST['tipoPagto'])=='boleto' || strtolower($_REQUEST['tipoPagto'])=='deposito' ||    strtolower($_REQUEST['tipoPagto'])=='retirada' || strtolower($_REQUEST['tipoPagto'])=='cielo' || strtolower($_REQUEST['tipoPagto'])=='pagseguro' ){
											  
	   	 	}else{
			 	$valor = getPriceFormat($valor); 
	   		} 
	   
	   
	         ///GERAR PEDIDO ------------------------------------------------------------------
										
			 //VERIRICAR IMPOSTO ADICIONAL: -------------------------------
	  	   	$impostoAddTexto = get_option('impostoAddTexto');
	  	  	$impostoAddPct = floatval(get_option('impostoAddPct'));
	   	 	$impostoAddRegiao = get_option('impostoAddRegiao');
		
	   	 	$cidadesFreteAdicional= $impostoAddRegiao ;
		
			$regiao = "";
		 	$valorAdd = "";
			$addCobranca = false;
	     	$arrayEstadosCidades = explode(',',$cidadesFreteAdicional);      
		  
		 	if( $arrayEstadosCidades ){
			 
				  foreach($arrayEstadosCidades as $item=>$value){    
       
						   $arrayValue = explode('**',$value);   
                           $estadoAdd = trim($arrayValue[0]);  
                           $cidadeAdd  = trim($arrayValue[1]); 
			              
						  if($estadoAdd == $cidadeAdd && $estadoAdd !=""){
			   	
						  	if(  modificaAcento(strtolower($estado)) == modificaAcento(strtolower($estadoAdd)) ){   
							    $addCobranca = true; 
						 	 };
				  
						  }else{
				   
							  if(  modificaAcento(strtolower($cidadeUserF)) == modificaAcento(strtolower($value)) ){   
								  $addCobranca = true; 
							   };
						   };       
					 };
           	  };
									    
				  $taxasExtras = 0.00;
										
				 if ( $addCobranca ==true) { 
											
						 $valorAdd = custom_get_total_price_session_order();
						 if(strlen($valorAdd)>6){
							 $valorAdd= str_replace('.','',$valorAdd);
						  };  
		                  $valorAdd= floatval(str_replace(',','.',$valorAdd));//CENTAVOS CIELO
						  $valorAdd +=$valorSedex;	
						  $valorAdd = $valorAdd*$impostoAddPct/100;
						  $valorAdd = number_format($valorAdd, 2 ,  '.', '');
		                  $taxasExtras = $valorAdd;
									
			   };
	 //VERIRICAR  IMPOSTO ADICIONAL -----------------------------------
										
  	if(strtolower($_REQUEST['tipoPagto'])=='boleto'){
	 	$percentual  = intval(get_option('boletoDesconto'));  
	 	$taxasExtras="DESC-$percentual";
  	};                                            
										  
 if(strtolower($_REQUEST['tipoPagto'])=='cielo'  || strtolower($_REQUEST['tipoPagto'])=='moip'  ){    
								
   $pedidoID = gerarPedido($idUser,$valorC,$tipoFrete,$tipoPagto,'PENDENTE',$comentario,$taxasExtras);   
											    
	   }else{
												   
				if( strtolower($_REQUEST['tipoPagto'])== 'retirar na Loja'){
					$tipoFrete =  strtolower($_REQUEST['tipoPagto']);
				}; 

 			  $pedidoID = gerarPedido($idUser,$valor,$tipoFrete,$tipoPagto,'PENDENTE',$comentario,$taxasExtras); 	
		
		};
											   
											
	 ///END. COBRANCA ---------------------------------------------------------------------------------									   
 	 $idCob = get_id_addr_cobranca();
 	  set_id_addr_cobranca($idCob,$idUser,$pedidoID);
											                                          
 ///GRAVAR ENDERECO PEDIDO --------------------------------------------------------------------------------------------
                                                                             gravarEnderecoPedido($pedidoID,$idUser,$userCep2,$userEstado2,$userCidade2,$userBairro2,$userEndereco2,$userEnderecoNumero2,$userComplemento2);
																			 
													
		 ///GRAVAR PRODUTOS DO PEDIDO -----------------------------------------------------------
         gravarProdutosPedido($pedidoID,$idUser);
                                               
          $blogid = intval(get_current_blog_id());  
                                          
           $user_info = get_userdata($idUser);

          $user_email = $user_info->user_email;
		  
          $nome = $user_info->user_firstname . " ". $user_info->user_lastname;
		  
          if(trim($nome)==""){ $nome = $user_info->user_login; };

                                   	           
          // ENVIO DE EMAIL ----------------------------------------------
 
           $header = "<div style='width:100%;padding:5px;background:#15829D;margin-bottom:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/topo-email.png' /></a></div>";

             $footer = "<div style='width:100%;padding:5px;background:#0A2A35;margin-top:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/footer-email.png'/></a></div>";
 
             $idLogin = get_idPaginaLogin();
             $pageLogin = get_permalink($idLogin);
 
             $mensagemEmail = "<h1>Olá $nome,  </h1> 
                  <p>Seu pedido foi registrado em nosso site. <br/> <strong> ".get_bloginfo('name')." </strong> ! Obrigado por comprar conosco.</p>  <p>Para acessar sua conta  siga <a href='".$pageLogin."' >".$pageLogin."</a> . </p>   ";
 
                                                          $mensagemEmailOrder = custom_get_order_user(false,$pedidoID,'off');

               $mensagemEmail .=  $mensagemEmailOrder ; 

               $mensagemEmail2 = " <h1>Olá Administrador ,  </h1> 
 <p>Novo pedido realizado <strong>".get_bloginfo('name')."</strong>.</p>
                                                                  <p>usuario : $user_email <br/>  Nome : $nome <br/>  </p>

<p>Para administrar faça o login em  <a href='".$pageLogin."' >".$pageLogin."</a> . </p>  ";

                $mensagemEmail2 .=  $mensagemEmailOrder ;       

                $assuntoEmail = "NOVO PEDIDO : ".get_bloginfo('name')."";
                $assuntoEmail2 = "NOVO PEDIDO  :  ".get_bloginfo('name')."";
                $msgF = $msg;


                 if(  $idUser > 0  ){
                      //echo $idUser;
                      include( 'email.php');
                };

                // FINAL ENVIO DE EMAIL --------------------  
                                       
									   
			  if($taxasExtras>0){
					 	$valor+=$taxasExtras;
			  };
				
$paginaObrigado =  get_permalink(get_idPaginaObrigado());
					 					    
if(strtolower($_REQUEST['tipoPagto'])=='cielo'){     
   require_once  "../functions/payment/Cielo/includes/include.php";
   include_once('../functions/payment/Cielo/pages/novoPedidoAguardeAjax.php');
   echo "****".$paginaObrigado;
   
}elseif(strtolower($_REQUEST['tipoPagto'])=='pagseguro'){ 
   $txtPrint  ="";  
   include_once('../functions/payment/Pagseguro/novoPedidoAguardeAjax.php');
    
   echo "2****";
   echo $txtPrint; 
   echo "****".$paginaObrigado;

}elseif(strtolower($_REQUEST['tipoPagto'])=='gerencianet'){ 
   $txtPrint  ="";  
   include_once('../functions/payment/Gerencianet/novoPedidoAguardeAjax.php');
    
   echo "7****";
   echo $txtPrint; 
   echo "****".$paginaObrigado;

}elseif(strtolower($_REQUEST['tipoPagto'])=='moip'){       
   $formulario = ""; 
    echo "4****"; 
	include_once('../functions/payment/Moip/novoPedidoAguardeAjax.php');
    echo "****".$paginaObrigado;
}elseif(strtolower($_REQUEST['tipoPagto'])=='paypal'){     
   $formulario = ""; 
   $status_pagto = "PENDENTE";
   echo '3****';
   include_once('../functions/payment/Paypal/novoPedidoAguardeAjax.php');
    echo "****".$paginaObrigado;
 }elseif(strtolower($_REQUEST['tipoPagto'])=='deposito'){
   echo "5****".get_permalink(get_idPaginaPagamento());     
   echo "****".$paginaObrigado;
}elseif(strtolower($_REQUEST['tipoPagto'])=='retirada'){
   echo "6****".get_permalink(get_idPaginaPagamento());    
   echo "****".$paginaObrigado;  
}elseif(strtolower($_REQUEST['tipoPagto'])=='boleto'){
   echo "6****".get_permalink(get_idPaginaPagamento()); 
   echo "****".$paginaObrigado;   
};    



				
/*RESET SESSION ***********************************************************************************/

      //if(current_user_can('manage_options')){}else{
        reset_session_cart();  
	   // };


/*RESET SESSION ***********************************************************************************/
     
 }; //IF VALOR >0           

 }; 

};


 ?>