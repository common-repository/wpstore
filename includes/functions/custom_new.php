<?php


 function custom_verify_login(){  
        
        
       $pageLogin = get_idPaginaLogin();
       $pagePerfil= get_idPaginaPerfil(); 
       
           if(is_user_logged_in() && is_page($pageLogin) ){
               wp_redirect(get_permalink($pagePerfil));
           }; 
        
        
            if(! is_user_logged_in() && is_page($pagePerfil) ){
               wp_redirect(get_permalink($pageLogin));
            };
            
            
    };   
    
    
     
    
    
    function get_user_address($typeList='select',$idUser=''){
               
             global $wpdb;       
             
             if($idUser==''){
                 global $current_user;
                 get_currentuserinfo();
                 $idUser = $current_user->ID;
             }; 
             
      
              $tabela = $wpdb->prefix."";
              $tabela .=  "wpstore_users_address";

              $sql = "SELECT * FROM `$tabela` WHERE  `id_usuario` = '$idUser' ";

              $userAddress = $wpdb->get_results( $sql);
              
              if($typeList=='select'){
              include('layout/userAddressSelect.php');
              }elseif('list'){
              include('layout/userAddressList.php');     
              }
         
    };
       

    function get_id_addr_cobranca($idUser='',$idPedido=''){
              
			  if($idUser==''){
                 global $current_user;
                 get_currentuserinfo();
                 $idUser = $current_user->ID;
              };
			   
              $idCob =   get_user_meta($idUser,'idEnderecoCobranca'.$idPedido , true); 
              return   $idCob;
   
    };
    
    function set_id_addr_cobranca($id,$idUser='',$idPedido=''){   
                 global $current_user;
                 get_currentuserinfo();
                 $idUser = $current_user->ID;
        
           update_user_meta($idUser,'idEnderecoCobranca'.$idPedido, $id);
           update_user_meta($idUser,'idEnderecoCobranca'.$idPedido, $id);    
           
    };     
    
    
    function get_user_address_by_id($idCob){

                global $wpdb;       

                if($idUser==''){
                    global $current_user;
                    get_currentuserinfo();
                    $idUser = $current_user->ID;
                }; 


                 $tabela = $wpdb->prefix."";
                 $tabela .=  "wpstore_users_address";

                 $sql = "SELECT * FROM `$tabela` WHERE  `id` = '$idCob' ";

                 $userAddress = $wpdb->get_results( $sql);
                 
                 return  $userAddress;

       };
    
    
    function update_user_infos($nome,$sobrenome,$nascimentoUsuario,$sexo,$telDDD,$telUm,$telDoisDDD,$telDois,$telTresDDD,$telTres){
                 
                 global $current_user;
                 get_currentuserinfo();
                 $idUser = $current_user->ID;
        
                                            
                 if($nome !="" && $nome!="undefined"){
                          update_user_meta($idUser,'first_name', $nome);
                          update_user_meta($idUser,'first_name', $nome);
                  };    
      
             
                   if($sobrenome !="" && $sobrenome!="undefined"){
                           update_user_meta($idUser,'last_name', $sobrenome);
                           update_user_meta($idUser,'last_name', $sobrenome);
                    };
                  
                    if($diaNasc!="" && $diaNasc!="undefined"){
                           update_user_meta($idUser,'diaNasc', $diaNasc);
                           update_user_meta($idUser,'diaNasc', $diaNasc);
                     };
                     
                     if($mesNasc !="" && $mesNasc!="undefined"){
                           update_user_meta($idUser,'mesNasc', $mesNasc);
                           update_user_meta($idUser,'mesNasc', $mesNasc);
                      };
                        
                      if($anoNasc !="" && $anoNasc!="undefined"){
                            update_user_meta($idUser,'anoNasc', $anoNasc);
                            update_user_meta($idUser,'anoNasc', $anoNasc);
                     }; 
                       
                     $userNascimento = $nascimentoUsuario;
					 
                       if($userNascimento !="" && $userNascimento!="undefined"){
                             update_user_meta($idUser,'userNascimento', $userNascimento);
                             update_user_meta($idUser,'userNascimento', $userNascimento);
                      }
                     
                           
                      if($sexo !="" && $sexo!="undefined"){
                            update_user_meta($idUser,'userSexo', $sexo);
                            update_user_meta($idUser,'userSexo', $sexo);
                      };
                              
                      if($telDDD !="" && $telDDD!="undefined"){
                             update_user_meta($idUser,'userDDD', $telDDD);
                             update_user_meta($idUser,'userDDD', $telDDD);
                       };
                                 
                      if($telUm !="" && $telUm!="undefined"){
                             update_user_meta($idUser,'userTelefone', $telUm);
                             update_user_meta($idUser,'userTelefone', $telUm);
                       };
                                    
                       if($telDoisDDD !="" && $telDoisDDD!="undefined"){
                              update_user_meta($idUser,'userDDD2', $telDoisDDD);
                              update_user_meta($idUser,'userDDD2', $telDoisDDD);
                       };
                                       
                        if($telDois !="" && $telDois!="undefined"){
                               update_user_meta($idUser,'userTelefone2', $telDois);
                               update_user_meta($idUser,'userTelefone2', $telDois);
                        };
                                          
                        if($telTresDDD !="" && $telTresDDD!="undefined"){
                               update_user_meta($idUser,'userDDDCel', $telTresDDD);
                               update_user_meta($idUserD,'userDDDCel',$telTresDDD);
                        };
                        
                         if($telTres !="" && $telTres!="undefined"){
                                   update_user_meta($idUser,'userTelefoneCel', $telTres);
                                   update_user_meta($idUser,'userTelefoneCel',$telTres);
                         };
                         
                  
              
    };   
    
    
    
    function get_endereco_entrega($idEndereco,$idUser=""){
              
             global $wpdb;       
             
             if($idUser==''){
                 global $current_user;
                 get_currentuserinfo();
                 $idUser = $current_user->ID;
             }; 
             
             $tabela = $wpdb->prefix."";
             $tabela .=  "wpstore_users_address";
             
             $sql = "SELECT * FROM `$tabela` WHERE  `id` = '$idEndereco' ";

             $userAddress = $wpdb->get_results( $sql);
              
             $contAddress = 0;  
             $addrCob = get_id_addr_cobranca();    
             $arrResult = array();
                 foreach ( $userAddress as $address ){
                     $contAddress +=1;  
										 $cepS =  $address->cep;
                     $cep =  explode('-', $cepS);
                     $cepUm =  $cep[0];
                     $cepDois =  $cep[1];  
                     $arrResult['id']   = $address->id;   
                     $arrResult['nomeEndereco']   = $address->nomeEndereco;   
                     $arrResult['destinatarioEndereco']   = $address->destinatarioEndereco;  
                     $arrResult['endereco']   = $address->endereco;  
                     $arrResult['numero']   = $address->numero;  
                     $arrResult['complemento']   = $address->complemento; 
                     $arrResult['bairro']   =  $address->bairro;      
                     $arrResult['cidade']   = $address->cidade;   
                     $arrResult['estado']   = $address->estado;     
                     $arrResult['tipoEndereco']   = $address->tipoEndereco;   
                     $arrResult['referencia']   = $address->referencia;
                     $arrResult['cepUm']   = $cepUm;
                     $arrResult['cepDois']   = $cepDois;  
									   $arrResult['cep']   =  $cepS;  
                }; 
              return $arrResult; 
    };    
    
       
    
    
    
    function simple_curlA($url,$post=array(),$get=array()){
    	$url = explode('?',$url,2);
    	if(count($url)===2){
    		$temp_get = array();
    		parse_str($url[1],$temp_get);
    		$get = array_merge($get,$temp_get);
    	}

    	$ch = curl_init($url[0]."?".http_build_query($get));
    	curl_setopt ($ch, CURLOPT_POST, 1);
    	curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
    	curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	return curl_exec ($ch);
    }
    
    
    
    function correios_frete($cepEntrega,$cidadeV='',$estadoV=''){   
        
  
              $freteGratis = false; 
              $cidadesFreteGratis = get_option('cidadesFreteGratis');
              //$arrayCidades = array('Niterói','Niteroi','São Gonçalo','Sao Gonçalo','Rio Bonito','Maricá','Marica','Itaborai','Itaboraí');
              $arrayCidades = array();
              $arrayEstados = array();  
              
              
              $cidade = "";  
              $estado= ""; 
              
              //----endereco com base no cep ------------------------------
              include('phpQuery-onefile.php');   
                    
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
              	
            // print_r($dados);
             
              $dados['cidade/uf'] = explode('/',$dados['cidade/uf']);
              $dados['cidade'] = trim($dados['cidade/uf'][0]);
              $dados['uf'] = trim($dados['cidade/uf'][1]);
              unset($dados['cidade/uf']);
                 $cidade = $dados['cidade']; 
                 $estado = $dados['uf']; 
               //endereco com base no cep -------------------------------
           
              
              
			  // echo  $cepEntrega."oooo";
               
              $msgFrete  = ""; 
              
			  
			  if($cidade==""){
			  	$cidade = $cidadeV;
			  }
			  if($estado==""){
			  	$estado = $estadoV;
			  };
			  
              $cidadeUser = $estado."**".$cidade;
              
			 // echo $cidadeUser."WW";
			  
              $arrayEstadosCidades = explode(',',$cidadesFreteGratis);
			  
              foreach($arrayEstadosCidades as $item=>$value){
				  
                  $arrayValue = explode('**',$value);
                  $arrayEstados[] = trim($arrayValue[0]);
                  $arrayCidades[] = trim($arrayValue[1]); 

                  $cidadeUserF = str_replace(' ','',$cidade ); 
                  $cidadePromocao = str_replace(' ','',$arrayValue[1] );
                  
                  if(  modificaAcento(strtolower($cidadeUser)) == modificaAcento(strtolower($value)) ){   
                  $freteGratis = true;  
                  $msgFrete = "Frete Grátis para sua cidade";
                  };

              }


              if(trim($cidade) ==""){
              	$freteGratis = false;
              };
              
              
              $valorPedido = custom_get_total_price_session_order();
                    
               if(strlen($valorPedido)>=6){
                   $valorPedido =  str_replace('.','',$valorPedido);
                   $valorPedido =  str_replace(',','.',$valorPedido);
                   }else{
                   $valorPedido =  str_replace(',','.',$valorPedido);
                   }; 


                   $idPrd   = $_POST['idPrd']; 
                   $precoProduto =  custom_get_price($idPrd);

                   if($precoProduto>0){
                    $valorPedido =  $precoProduto;
                   }

                   $simbolo =  get_current_symbol(); 
                   $precoPromocao = get_option('valorFreteGratis');

                          if(strlen($precoPromocao)>=6){
                           $precoPromocao =  str_replace('.','',$precoPromocao);
                           $precoPromocao =  str_replace(',','.',$precoPromocao );
                           }else{
                           $precoPromocao =  str_replace(',','.',$precoPromocao);
                           };   


               if($valorPedido > $precoPromocao &&  $precoPromocao > 0 ){
                   $freteGratis = true; 
                   $msgFrete  = "Frete Grátis para pedidos acima de  $simbolo".get_option('valorFreteGratis').". Aproveite!";   
               };   
               
               
                $promoFrete =  produtoPromoFrete($cidadeUser);
                if($promoFrete=='gratis'){
                    $freteGratis = true; 
                    $msgFrete  = "Frete Grátis para sua região !!! Aproveite!";   
                }else{
                	// $freteGratis = false; 
                }
				
			 
				
				//--------------------------
	            $arrayCarrinho = "";  
	            $blogid = intval(get_current_blog_id());  
	      	    if($blogid>1){
	      	          $arrayCarrinho =  $_SESSION['carrinho'.$blogid] ;     
	      	    }else{
	      	          $arrayCarrinho = $_SESSION['carrinho'];      
	            };

		
		    	$arrPodePromo = true; 
		
		        if(count($arrayCarrinho)>0){
	            foreach($arrayCarrinho as $key=>$item){ 
			                $postID = intval($item['idPost']);
						
					         $fg = produtoPromoFrete($cidadeUser,$postID);
						  	 $produtoSemPromoFrete = get_produto_promoFrete_status($postID);
				 
	               
						     if( $fg !='gratis' && $produtoSemPromoFrete==true ){
								 $arrPodePromo = false; 
							};
             
				 };
			    };
			 
	        	 if($arrPodePromo ==false){
				    $freteGratis = false;
	    	     };
				//--------------------------
         
                // DEFININDO OS VALORES
                 $CEP_ORIGEM = get_option('cepOrigemCorreios');   // SP
                 $CEP_DESTINO = $cepEntrega; // CAMPINAS      
                 
				 //echo "yyy".$cidadeUser;
                 $peso =  floatval(get_cart_weight($cidadeUser)); 
				 
				 if($peso=='gratis'){
                     $freteGratis = true; 
                     $msgFrete  = "Produto com Frete Grátis para sua região !";   
				 };
               
                if($freteGratis ==false){   
                    
          
                    
                   
                     $pesoReal = $peso;
					    
                     if(intval( $peso)>30){
                          $peso = "30";
                     }              
                     $PESO = "$peso"; 
                     $VALOR = '40';
					 // ZERANDO VALORES
                     $valorFrete = 0.0;
					 
					 
					 //FINAL CORREIOS --------------------------------------------------------
				  
                     // CHAMADA DO ARQUIVO QUE CONTEM A CLASSE PgsFrete()
                      //require_once('fretePgs.php'); // desativado para calculo e-sedex
					 // INSTANCIANDO A CLASSE
                    // $frete = new PgsFrete;
					 // CALCULANDO O FRETE
					// $valorFrete = $frete->gerar($CEP_ORIGEM,  $PESO, $VALOR, $CEP_DESTINO);
					 
					 $valorFrete = array();
					 
					// echo " $CEP_ORIGEM,  $PESO, $VALOR, $CEP_DESTINO AAAAA";
                    
					 //FINAL CORREIOS --------------------------------------------------------
					 
					  $moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
					 
					  
					  if(is_array($valorFrete)) {
						     $valorSedex  = $valorFrete["Sedex"];
						  
						     // $valorSedex = floatval( $valorSedex);
							 
                            $valorPac = $valorFrete["PAC"];
					  };
                       
					  if(empty($valorFrete )){ 
						  include('freteCorreiosNew.php');
					  }else{
					 
						 if($peso<30){ 
    
						   $PAC = "<input type='radio' name='radioFrete'  class='radioFrete'    rel='Pac'  id='Pac' value='".$valorPac."' /> PAC :  $moedaCorrente <span  class='red' id='valorFretePAC' >".$valorPac."</span><br/> <small>Prazo Correios PAC : Capital 3 a 7 dias úteis. Interior 7 a 10 dias úteis. </small><hr/> ";  

						   $prazoSedexT =  "<small> Prazo  Correios SEDEX :Capital 1 a 3 dias úteis. Interior 2 a 5 dias úteis.</small>";
    
						 }else{
						 	$prazoSedexT =  "<small> Prazo  Transportadora : Até 30 dias.</small>";
							$pesoReal = intval($pesoReal/$peso);
	
							$valorSedex = floatval($valorSedex)*$pesoReal;
						    $valorSedex= number_format( $valorSedex, 2 ,  '.', '');
						
					        //IMPOSTO ADICIONAL: -------------------------------
							$impostoAddTexto = get_option('impostoAddTexto');
							$impostoAddPct = floatval(get_option('impostoAddPct'));
							$impostoAddRegiao = get_option('impostoAddRegiao');
		
		 
						    $cidadesFreteAdicional= $impostoAddRegiao ;
		
							$regiao = "";
							$valorAdd = "";
					        $addCobranca = false;
						    $arrayEstadosCidades = explode(',',$cidadesFreteAdicional);       
   
						    foreach($arrayEstadosCidades as $item=>$value){    
       
						        $arrayValue = explode('**',$value);   
       
						           $estadoAdd = trim($arrayValue[0]);  
       
						           $cidadeAdd  = trim($arrayValue[1]); 
			   
								   if($estadoAdd == $cidadeAdd && $estadoAdd !=""){
			   	
						 	           if(  modificaAcento(strtolower($estado)) == modificaAcento(strtolower($estadoAdd)) ){   
						 	              $addCobranca = true; 
										  $regiao .="$estado, ";
						 	           };
				  
								   }else{
				   
						 	          if(  modificaAcento(strtolower($cidadeUserF)) == modificaAcento(strtolower($value)) ){   
						 	                $addCobranca = true; 
											$cidadeUs = str_replace('**','()',$cidadeUserF);
										    $regiao .="$cidadeUserF), ";
						 	          };
			   	
								   };
               
					        }
         
						    $valorAdd = custom_get_total_price_session_order();
							if(strlen($valorAdd)>6){
					         $valorAdd= str_replace('.','',$valorAdd);
					        };  
					        $valorAdd= floatval(str_replace(',','.',$valorAdd));//CENTAVOS CIELO
							$valorAdd +=$valorSedex;	
							$valorAdd = $valorAdd*$impostoAddPct/100;
							$valorAdd = number_format($valorAdd, 2 ,  '.', '');
		
							//if(current_user_can( 'manage_options' ) ){
							if ( $addCobranca ==true) {
							$cobrancaAdicional = "<span class='red'>Outras Taxas</span> :   $moedaCorrente<span id='taxaAdicional'>$valorAdd</span> <br/><small>  $impostoAddTexto , alicota de $impostoAddPct% sobre valor da nota fiscal  nas seguintes  regiões :  $regiao </small>";
						    };
							//};
							//IMPOSTO ADICIONAL -----------------------------------
							
							
							
							
							
						 }
 
 
 
						 $sedexNome = "SEDEX / TRANSPORTADORA";
						 $sedexPrazos = "Capital 1 a 3 dias úteis. Interior 2 a 5 dias úteis após a confirmação de pagamento.";
						 if( $peso>=30){
						 	$sedexNome = "TRANSPORTADORA";
							$sedexPrazos = "Até 15 dias úteis para entrega. Prazo a contar  da confirmação de pagamento";
						 }
						 
						 

						 $SEDEX = "<input type='radio'  name='radioFrete' class='radioFrete'  checked='checked'  rel='Sedex' id='Sedex' value='".$valorSedex."' />   $sedexNome : $moedaCorrente <span  class='red'  id='valorFreteSEDEX' >".$valorSedex."</span>  <br/> $sedexPrazos. <hr/> ";   
 
 
 
  
   
					 $ctCorreiosCod = "".get_option('ctCorreiosCod');
					 $ctCorreiosPass = "".get_option('ctCorreiosPass');
					 
					 if( $ctCorreiosCod !='' && $ctCorreiosPass !='' ){

				 		 //HACK --------------------------
				 	   	if(floatval($valorESedex)<=0){
				 			$valorESedex = floatval($valorSedex)/2;
				 			$valorESedex = number_format($valorESedex, 2 ,  '.', '');
				 		};
				    	 //HACK --------------------------

				   	 	$ESEDEX = " <div style='padding-top:5px'><input type='radio'  name='radioFrete' class='radioFrete'  checked='checked'  rel='ESedex' id='ESedex' value='".$valorESedex."' />   E-SEDEX : $moedaCorrente <span  class='red'  id='valorFreteSEDEX' >".$valorESedex."</span>  <br/>  <small class='prazoEntrega'>$sedexPrazos.</small> <hr/></div> ";   
  
				      };
					  
					  
					  
					  
   
   
 
	   					 $retirarLoja =get_option('retirarLoja');
					 $linkLojas = get_permalink(get_option('idPaginaRetiradaLojaWPSHOP')); 
					 
					 echo'<div id="retorno" style="font-size:16px">';
					 
					 
					global $current_user;
					get_currentuserinfo();
					$autorizacao = get_usermeta($current_user->ID, 'wpsAutorizacao');
					
						 
	   					 if($retirarLoja=='retirarLoja' || $autorizacao == "Confirmado"){
	   						 echo "<div style='padding-top:5px'><input type='radio'  name='radioFrete' class='radioFrete'  checked='checked'  rel='retirarLoja' id='retirarLoja' value='0.00' />Retirar na Loja
	   						 <span class='green' style='font-size:0.7em'>** Vou retirar a mercadoria na loja (Sem frete):  <a href='".$linkLojas."' target='_blank'>Consulte lojas </a></span><br/><hr/></div>";
	   					 };
					 
 
						echo' '.$PAC.'<div style="padding-top:5px">'.$SEDEX.'</div> <div style="padding-top:5px">  '.$ESEDEX.'';
						
						
   				
						echo'  '.$cobrancaAdicional.' </div>';  
				
	
				     };
					 
					 
					
                    
					 
                      
                }else{
                    echo "0.00 -  (Grátis)";
                }     
               
			   
    };     
    
    
    
    
    
    
    
    
    function calculaFreteCorreios($cod_servico, $cep_origem, $cep_destino, $peso, $altura='5', $largura='20', $comprimento='30', $valor_declarado='0.50')
    {
        #OFICINADANET###############################
        # Código dos Serviços dos Correios
        # 41106 PAC sem contrato
        # 40010 SEDEX sem contrato
        # 40045 SEDEX a Cobrar, sem contrato
        # 40215 SEDEX 10, sem contrato
        ############################################


        /**/
         $alturaS =  get_option('alturaEmbalagemCorreios');
         $larguraS= get_option('larguraEmbalagemCorreios');
         $comprimentoS = get_option('comprimentoEmbalagemCorreios');


        if(intval($alturaS)>0){
          $altura =  $alturaS;  
        }

        if(intval($larguraS)>0){
          $largura= $larguraS;  
        }

        if(intval($comprimentoS)>0){
         $comprimento =  $comprimentoS;  
        }




        $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor_declarado."&sCdAvisoRecebimento=s&nCdServico=".$cod_servico."&nVlDiametro=10&StrRetorno=xml";
        $xml = simplexml_load_file($correios);
        if($xml->cServico->Erro == '0')
            return $xml->cServico->Valor;
        else
            return false;
    };
    
    
       function get_cart_weight($cidadeUser='' ){
	       $freteGratis = false;
		    $cidadesFreteGratis = get_option('cidadesFreteGratis');
           $arrayEstadosCidades = explode(',',$cidadesFreteGratis);
		  
           foreach($arrayEstadosCidades as $item=>$value){
			  
               $arrayValue = explode('**',$value);
               $arrayEstados[] = trim($arrayValue[0]);
               $arrayCidades[] = trim($arrayValue[1]); 

               $cidadeUserF = str_replace(' ','',$cidade ); 
               $cidadePromocao = str_replace(' ','',$arrayValue[1] );
               
			   if(current_user_can('manage_options')){
			   		//echo "ZZZZ".modificaAcento(strtolower($cidadeUser))." == ". modificaAcento(strtolower($value)) ; 
		       };
			   
               if(  modificaAcento(strtolower($cidadeUser)) == modificaAcento(strtolower($value)) ){   
               $freteGratis = true;  
               $msgFrete = "Frete Grátis para sua cidade";
			   return 'gratis';
               };

           }
		   
		   
		   
                     $arrayCarrinho = "";
                     $pesoTotal = 0;  
                     $blogid = intval(get_current_blog_id());  
					 
                   	 if($blogid>1){
                   	          $arrayCarrinho =  $_SESSION['carrinho'.$blogid] ;     
                   	 }else{
                   	          $arrayCarrinho = $_SESSION['carrinho'];      
                    };  
					
                    if(!empty($arrayCarrinho)){
                    foreach($arrayCarrinho as $key=>$item){     
						
                            $postID = intval($item['idPost']);
							   
                            if($postID>0){
								
								  	$fg = produtoPromoFrete($cidadeUser,$postID);
						 
									$produtoSemPromoFrete = get_produto_promoFrete_status($postID);
									 
				                      if( $produtoSemPromoFrete  == true){
										 $fg='false';
									  };
								 	/**/
								
								     if( $fg !='gratis'  ){
										    if( $freteGratis==true){
												  if(  $produtoSemPromoFrete==true){
										    			$qtdprod = intval($item['qtdProduto']); 
								            			$pesoTotal += $qtdprod*get_weight_product($postID);
											 	  };
										     }else{
											     $qtdprod = intval($item['qtdProduto']); 
									             $pesoTotal += $qtdprod*get_weight_product($postID);
										     }
									};
							};
                    }; 
					};
					if($pesoTotal==0){
						$pesoTotal = 'gratis';
					};
                    return $pesoTotal;
       };  //get_cart_weight 
       
       
	   
	   function imprimePedido($orderNum,$index='0'){
		    if($orderNum !=""){
		          include('layout/imprimePedido.php');
		     };
			      return $impressaoAgrupada;
		};
       
       function reset_session_cart(){
       if($blogid>1){  unset($_SESSION['carrinho'.$blogid]);   }else{   unset($_SESSION['carrinho']);  }; 
	   
    
    	$_SESSION['vFrete'] = '';
     	$_SESSION['nomeFrete'] = '';
     	$_SESSION['enderecoEscolhido'] =  ''; 
	  
       };
       
     
     
     function  get_payment_mode(){
         $txtPrint = "";
         include('payment/payment.php'); 
         echo $txtPrint; 
     }  
	 
	 
	 // RELATORIO VENDAS -----------------------------------------------------------
	 function getRelatorioVendas($data,$dataFim=""){
		 
	     global $wpdb;
		 
	     $tabela = $wpdb->prefix."";
		 $tabela .=  "wpstore_orders";
		 
		 
		 $arrayResposta = array();
		 $totalValor = 0;
		 $totalPedidos = 0;
		 $totalAprovados = 0;
		 $totalAprovadosValor = 0;
		 $totalPendentes = 0;
		 $totalPendentesValor = 0;
		 $totalCancelados = 0;
		 $totalCanceladosValor = 0;
		 $totalOutros = 0;
		 $totalOutrosValor = 0;
		 
		 $diasPeriodo  = "";
	     $valoresAprovados   = "";
		 $valoresPendentes = "";
         $valoresCancelados = "";
		 
		 
		 if($dataFim !="" && $dataFim != $data){ //------RELATORIO DE PERIODO
 
			 $arrdataInicio= explode('/',$data);
			 $dataInicio= $arrdataInicio[2]."/".$arrdataInicio[1]."/".$arrdataInicio[0];
		 
			 $arrdataFinal= explode('/',$dataFim);
			 $dataFinal= $arrdataFinal[2]."/".$arrdataFinal[1]."/".$arrdataFinal[0];
		 
		     $arrayDatas = createDateRangeArray( $dataInicio, $dataFinal );
 
			 foreach($arrayDatas as $data){
				 
		 
		           $totalAprovadosValorParc = 0;
			       $totalPendentesValorParc= 0;
				   $totalCanceladosValorParc = 0;
				   $totalOutrosValorParc= 0;

				   $dataPesquisa = str_replace('-','.',$data);
				 
			 
			 	  $sql = "SELECT *FROM `$tabela`  WHERE `id_pedido` LIKE CONCAT('%', '$dataPesquisa' , '%')  ORDER BY `ID` DESC ";
				  
				
		 		 $results = $wpdb->get_results($sql);
			
		             if(  $results ){
		 	        foreach (  $results as  $result ){
				
		                     $valor_total = $result->valor_total;
					
		 					if(strlen( $valor_total )>6){
		 					    	$valor_total  = str_replace('.','',$valor_total );
		 					}
					
		 					$valor_total = str_replace(',','.',$valor_total );
		 					$valor_total  = floatval($valor_total); 
    
		 					$totalValor += $valor_total;
				 
		 	        	    $frete = $result->frete;
					
		 	                $tipo_pagto = $result->tipo_pagto;
					
		 	                $status_pagto = $result->status_pagto;
				  
		 					if( $status_pagto =="APROVADO" 
									||   $status_pagto =="SEPARACAO" 
							        ||   $status_pagto =="TRANSPORTADORA"
							        ||   $status_pagto =="ENTREGUE"   ){
		 						$totalAprovados +=1;
		 						$totalAprovadosValor +=  $valor_total ;
								$totalAprovadosValorParc +=  $valor_total ;
							}elseif($status_pagto =="PENDENTE" ||  $status_pagto =="VERIFICANDO" ){
		 						$totalPendentes +=1;
		 						$totalPendentesValor +=  $valor_total ;
								$totalPendentesValorParc +=  $valor_total ;
							}elseif($status_pagto =="CANCELADO" ){
		 						$totalCancelados+=1;
								$totalCanceladosValor +=  $valor_total ;
								$totalCanceladosValorParc +=  $valor_total ;
		 					};
							
						 
		 					$totalPedidos +=1;
		 	         };
			 
		 	 	    };
			 
 	 			    $diasPeriodo .= '"'.$data.'",';
			        $valoresAprovados .= "$totalAprovadosValorParc,";
					$valoresPendentes .= "$totalPendentesValorParc,";
					$valoresCancelados .=  "$totalCanceladosValorParc,";
				
					
			  
			 };
			 
			 
			
		 }else{ //----------------------------------- SOMENTE DATA INICIAL
	
		 
		 $diasPeriodo .= '"'.$data.'",';
			
         $arrDataPedido = explode('/',$data);
		 
		 $dataPesquisa = $arrDataPedido[2].".".$arrDataPedido[1].".".$arrDataPedido[0];
 
         $sql = "SELECT *FROM `$tabela`  WHERE `id_pedido` LIKE CONCAT('%', '$dataPesquisa' , '%')  ORDER BY `ID` DESC";
		 
		 $results = $wpdb->get_results($sql);
			
            if(  $results ){
	        foreach (  $results as  $result ){
				
                    $valor_total = $result->valor_total;
					
					if(strlen( $valor_total )>6){
					    	$valor_total  = str_replace('.','',$valor_total );
					}
					
					$valor_total = str_replace(',','.',$valor_total );
					$valor_total  = floatval($valor_total); 
    
					$totalValor += $valor_total;
				 
	        	    $frete = $result->frete;
					
	                $tipo_pagto = $result->tipo_pagto;
					
	                $status_pagto = $result->status_pagto;
					
					if( $status_pagto =="APROVADO" ){
						$totalAprovados +=1;
						$totalAprovadosValor +=  $valor_total ;
					}elseif($status_pagto =="PENDENTE"   ||  $status_pagto =="VERIFICANDO"  ){
						$totalPendentes +=1;
						$totalPendentesValor +=  $valor_total ;
					}elseif($status_pagto =="CANCELADO" ){
						$totalCancelados+=1;
						$totalCanceladosValor +=  $valor_total ;
					}else{
						$totalOutros +=1;
						$totalOutrosValor +=  $valor_total ;
					}
					
					$totalPedidos +=1;
	         };
			 
	 	    };
			
			
			};
			
			$arrayResposta['totalValor'] = $totalValor;
			$arrayResposta['totalPedidos'] = $totalPedidos;
			$arrayResposta['totalAprovados'] = $totalAprovados;
			$arrayResposta['totalPendentes'] = $totalPendentes;
			$arrayResposta['totalCancelados'] = $totalCancelados;
			$arrayResposta['totalOutros'] = $totalOutros;
			
			$arrayResposta['totalAprovadosValor'] = $totalAprovadosValor;
			$arrayResposta['totalPendentesValor'] = $totalPendentesValor;
			$arrayResposta['totalCanceladosValor'] = $totalCanceladosValor;
			$arrayResposta['totalOutrosValor'] = $totalOutrosValor;
			
			$arrayResposta['diasPeriodo'] = $diasPeriodo;
			$arrayResposta['valoresAprovados'] = $valoresAprovados;
			$arrayResposta['valoresPendentes'] = $valoresPendentes;
            $arrayResposta['valoresCancelados'] = $valoresCancelados;
			
			
			return $arrayResposta;
			
		
	 };    
	  // RELATORIO VENDAS -----------------------------------------------------------
	  
	 
 	  // AVALIACOES -----------------------------------------------------------
 	  function getAvaliacoesPendentes(){
	         global $wpdb;
             $tabela = $wpdb->prefix."";
             $tabela .=  "wpstore_orders_products";    
             $sql = "SELECT *FROM `$tabela`  WHERE   `comentarioCliente`!=''  AND  `comentarioStatus`!='APROVADO'   ORDER BY `ID` DESC ";
             $avaliacoes = $wpdb->get_results($sql);  
             $totalAvaliacoes = count($avaliacoes);    
             $total = 0;
             foreach($avaliacoes as $avaliacao ){   
			   $total += 1;
		     }
			 return $total;
      	 }; 
	  // AVALIACOES -----------------------------------------------------------    
	  
	  
	  
	  
	  
	  
 	  // PERGUNTAS -----------------------------------------------------------
 	  function getPerguntasPendentes(){
	   
             global $wpdb;
             $tabela = $wpdb->prefix."";
             $tabela .=  "wpstore_perguntas_products";    
             $sql = "SELECT *FROM `$tabela`  WHERE `comentario_status`='PENDENTE'   
				     ORDER BY `id` DESC ";
             $perguntas = $wpdb->get_results($sql);  
             $total = 0;
             foreach($perguntas as $pergunta ){   
			   $total += 1;
		     }
			 return $total;
      	 }; 
	  // PERGUNTAS  -----------------------------------------------------------  
	  
	   
	   
 	  //CONTATO-----------------------------------------------------------
 	  function getContatosPendentes(){
	   
             global $wpdb;
             $tabela = $wpdb->prefix."";
             $tabela .=  "wpstore_contacts";    
             $sql = "SELECT *FROM `$tabela` ORDER BY `id` DESC ";
             $perguntas = $wpdb->get_results($sql);  
             $total = 0;
             foreach($perguntas as $pergunta ){   
			   $total += 1;
		     }
			 return $total;
      	 }; 
	  // PERGUNTAS  -----------------------------------------------------------  
	  
	  
 
	  
	  
      function produtoPromoFrete($cidadeUser,$idPrdF=''){
		   
          $arrayCarrinho = "";
          $pesoTotal = 0;  
        
		  $returnFrete = "";
		          
      	
			    if($idPrdF!=''){ // se for produto
      	
		  	    $cidadesFreteGratis = get_post_meta($idPrdF, 'freteGratisProduto' , true); 
						 
	   		 
                         if($cidadesFreteGratis != ""){	
							 
                    	         $arrayEstadosCidades = explode(',',$cidadesFreteGratis);
					             $returnFrete = "";
						
					    	  	 foreach($arrayEstadosCidades as $item=>$value){
		                   		 	$cidadePromocao = str_replace(' ','',$value );
                           		 		if(modificaAcento(strtolower($cidadeUser)) == modificaAcento(strtolower($value)) ){  
												$returnFrete = "gratis";
                              			  };
                         		 
										  		$checkValue = explode("**",$value);
						 						$estadoValue =$checkValue[0];
						 		  			  	$cidadeValue =$checkValue[1];
						 
						 		 	 		     $checkCidadeUser = explode("**",$cidadeUser);
									  		     $estadoCidadeUser =$checkCidadeUser[0];
						 		                 $cidadeCidadeUser =$checkCidadeUser[1];
						 
					 
						 	            	if($estadoValue==$cidadeValue && $estadoValue == $estadoCidadeUser){
						 	 	            	$returnFrete = "gratis";
						 		            };
                   		        }
				 
				              
					   		 	
						 };
						 
                    }else{ // se for carrinho
						
						
			             	$blogid = intval(get_current_blog_id());  
							
	        	        	 if($blogid>1){
	        	        		 $arrayCarrinho =  $_SESSION['carrinho'.$blogid] ;     
	        	        	 }else{
	        	         			$arrayCarrinho = $_SESSION['carrinho'];      
	                    	 };  
						     if(count($arrayCarrinho)>=1){
                    				foreach($arrayCarrinho as $key=>$item){     
                    
											$postID = intval($item['idPost']);
											
                       					 	$cidadesFreteGratis = get_post_meta($postID, 'freteGratisProduto' , true);  
											                 
											 if($cidadesFreteGratis != ""){	
												
                    							$arrayEstadosCidades = explode(',',$cidadesFreteGratis);
					
					        					foreach($arrayEstadosCidades as $key2=>$value){
		                     					   	    $cidadePromocao = str_replace(' ','',$value );
                                                        if(modificaAcento(strtolower($cidadeUser)) == modificaAcento(strtolower($value))  ){                                                         $returnFrete = "gratis";
							                            };
												   
												   
				 								  	    $checkValue = explode("**",$value);
				 						 		  		$estadoValue =$checkValue[0];
				 						 		  		$cidadeValue =$checkValue[1];
						 
				 						 		  		$checkCidadeUser = explode("**",$cidadeUser);
				 								 	    $estadoCidadeUser =$checkCidadeUser[0];
				 						 		  	    $cidadeCidadeUser =$checkCidadeUser[0];
						  
				 						 	   	       if($estadoValue==$cidadeValue && $estadoValue == $estadoCidadeUser){
				 						 	 	   	       $returnFrete = "gratis";
				 						 		       }else{
				 						 		 
														    $qtdprod = intval($item['qtdProduto']); 
												   		    $pesoTotal += $qtdprod*get_weight_product($postID);
															if($pesoTotal>0){
														       $returnFrete = "";
															}
													   };
												
												}//foreach
								         
						                   }else{//elseif not promoCity
						                   	         
										   	 	$qtdprod = intval($item['qtdProduto']); 
								   		   	 	$pesoTotal += $qtdprod*get_weight_product($postID);
												if($pesoTotal>0){
										      	  	$returnFrete = "";
												}
											
						                   };
										
						            }; //foreach
								};//if arrray 
                    };//else
					
					
                 
  		            return $returnFrete;
	     
      };
	  
	  
	  // function get datas entre interval
	  
	  
	  function createDateRangeArray($strDateFrom,$strDateTo)
	  {
	      // takes two dates formatted as YYYY-MM-DD and creates an
	      // inclusive array of the dates between the from and to dates.

	      // could test validity of dates here but I'm already doing
	      // that in the main script

	      $aryRange=array();

	      $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
	      $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

	      if ($iDateTo>=$iDateFrom)
	      {
	          array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
	          while ($iDateFrom<$iDateTo)
	          {
	              $iDateFrom+=86400; // add 24 hours
	              array_push($aryRange,date('Y-m-d',$iDateFrom));
	          }
	      }
	      return $aryRange;
	  }
   
   
   
   
   


    function get_produto_parcela_status($postID){
       $produtoNaoParcela = false;
       $arrRemoveCatsParc  =  get_remove_cats_parc();
       $arrAllCatsProd  =  get_all_cats_prod($postID);
	   
	     	    foreach($arrAllCatsProd as $idCatP){
		
	     		      if (in_array($idCatP, $arrRemoveCatsParc)) {
	     		          $produtoNaoParcela = true;
	     		      }
	  		      };
		 
		   
   
	  return $produtoNaoParcela ;
    };
	
	
	
   function get_remove_cats_parc(){
  		$arrCatRemoveParcelaWPSHOP=  get_option('arrCatRemoveParcelaWPSHOP'); 
		$arrIds = explode(',' , $arrCatRemoveParcelaWPSHOP);
		return $arrIds;
    }
  
  
    function get_all_cats_prod($postID ){  
        $post_categories = wp_get_post_categories($postID);
        return $post_categories;
    };

 


    function get_produto_promoFrete_status($postID){
	   $produtoSemPromo = false;
       $arrCatRemovePromoFreteWPSHOP  =  get_arrCatRemovePromoFrete();
       $arrAllCatsProd  =  get_all_cats_prod($postID);
       if($arrAllCatsProd){
   	       foreach($arrAllCatsProd as $idCatP){
		       if (in_array($idCatP, $arrCatRemovePromoFreteWPSHOP )) {
   		         $produtoSemPromo= true;
   		      }
		   };
         };
		 
	   return $produtoSemPromo ;
	};
	
	
	
   function get_arrCatRemovePromoFrete(){
  		$arrCatRemovePromoFreteWPSHOP=  get_option('arrCatRemovePromoFreteWPSHOP'); 
		$arrIds = explode(',' , $arrCatRemovePromoFreteWPSHOP);
		return $arrIds;
    }
  
 
     
	function get_qtd_product_sell($postID){
		
		global $wpdb;
		
	    $tabela = $wpdb->prefix."";
	    $tabela .= "wpstore_orders_products"; 
		
		
		
	    $tabelaOrder = $wpdb->prefix."";
	    $tabelaOrder .=  "wpstore_orders";
		
		/*
		  //  $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_produto`='$postID'   ORDER BY `id`  ASC  "  ,1,'') );
			 
		
			 $results  =    $wpdb->get_results( $wpdb->prepare( 'SELECT * FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto='.$postID.' AND ord.status_pagto != "CANCELADO" ' ,1,''));
*/
		
		$sql = 'SELECT variacao,qtdProd FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto='.$postID.' AND ord.status_pagto != "CANCELADO" ' ;
		
		
		$results  =    $wpdb->get_results(  $sql  );
		
		//print_r($results);
	 	/**/
		    // Adicionando PRODUTOS 

		    $countPrd = 0;
            $arrCombQtd = array();
			if(count($results) > 0){
		    foreach ( $results   as $item=>$result   ){

               $variacaoProduto = $result->variacao;
			   $qtdProduto = $result->qtdProd ;
			  
			   if($variacaoProduto != ""){
			       $arrCombQtd["".$variacaoProduto] += intval($qtdProduto);
		       }else{
		         	$arrCombQtd[] += intval($qtdProduto);
		       }
			   //echo"   $variacaoProduto $qtdProduto<br/>";
		
			};
		    };
			
		    ksort($arrCombQtd);
		    if(!empty($arrCombQtd)){
	    	foreach($arrCombQtd as $keyV=>$valueV){
				if($keyV=="-"){$keyV = "*"; };
			    return intval($valueV);
		    };
		    };
		
		return 0;
		/**/
	}; 
	

 // ENVIO DE EMAIL ----------------------------------------------------------
  
	function send_email($nome,$user_email,$assuntoEmail,$mensagemEmail){
	
		   $header = "<div style='width:100%;padding:5px;background:#15829D;margin-bottom:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/topo-email.png' /></a></div>";

             $footer = "<div style='width:100%;padding:5px;background:#0A2A35;margin-top:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/footer-email.png'/></a></div>";

         
        include('email.php');
 
	  
	 };
// FINAL ENVIO DE EMAIL ---------------------------------------------------------- 



//RASTREIO CORREIOS -------------------------------------------- 

/*
function rastreamento_correios($codigo){

	$url = 'http://websro.correios.com.br/sro_bin/txect01$.Inexistente?P_LINGUA=001&P_TIPO=002&P_COD_LIS=' . $codigo;

	$retorno = file_get_contents($url);
	 
	preg_match('/<table  border cellpadding=1 hspace=10>.*<\/TABLE>/s',$retorno,$tabela);

   if(count($tabela) == 1){
	   
		return $tabela[0];  
   
   }else{
	   
		return "ojbeto não encontrado";   
   }

}
*/


function currentStatusPedido($idPedido){
   		global $wpdb; 
        $tabela = $wpdb->prefix."";
        $tabela .=  "wpstore_orders";
		
  $sql = "SELECT `status_pagto` FROM `$tabela` WHERE `id_pedido` = '$idPedido' LIMIT 0 , 1";
        $statusPedido = $wpdb->get_var(  $sql );
        return $statusPedido;
}


function rastreamento_correios($codigoRastreio , $idPedido , $msgPedido){
	
	include_once('class-rastreio.php');


	// instanciando Objeto de rastreamento
	$obj = new RastrearPedido();
	// passando codigo de rastreamento como parametro
	$xml = $obj->rastrear( $codigoRastreio );
	// transformando arquivo xml retornado em um objeto
	$obj_xml = simplexml_load_string($xml); 
	
	
	if( isset($obj_xml) && is_object($obj_xml) ) {
        if( count( $obj_xml->error ) <= 0 ) {
                 //echo $obj_xml->qtd . "\n";
                 //echo $obj_xml->TipoPesquisa . "\n";
                // echo $obj_xml->TipoResultado . "\n";
                 // se for uma lista de objetos percorre a lista
				 
				echo "
					
					<table class='table-bordered'><thead>
									<tr>
										<th style='color:red'>Data - Hora</th>
										<th style='color:red'>Descrição</th>
										<th style='color:red'>Cidade</th>
										<th style='color:red'>UF</th>
										<th style='color:red' >Extra</th>
									</tr>
								</thead>
								<tbody> ";
								
					
								
				 $contagemEventos  = 0;				

                 foreach ( $obj_xml->objeto as $o ):
                        //echo $o->numero . "\n";
                      // percore todos os eventos registrados deste objeto
                  foreach( $o->evento as $itemC=>$e ):
                 // 3 campos que raramente sao preenchidos
				 $recebedor = (!isset($e->recebedor))?' ':$e->recebedor;
				 $documento = (!isset($e->documento))?' ':$e->documento;
				 $comentario = (!isset($e->comentario))?' ':$e->comentario;
				
				 $tipo = $e->tipo;
				
			     $sto=$e->sto;
			     $data =$e->data;
			     $hora =$e->hora;
			     $descricao =$e->descricao ;
			     $local =$e->local;
			     $codigo=$e->codigo ;
			     $cidade =$e->cidade ;
			     $uf =$e->uf;
			     $status =$e->status;
					 
			 
				  echo " </tr>";
					
						 
				   echo "<td> $data  - $hora</td>
									 <td> $descricao</td>
									 <td>$cidade </td>
									 <td>$uf</td>";
						
			
			
			
			
				 					

				  
				  
				  
				  			
				//se entregue
				 $statusEntregue = "";
				 $statusPedido = currentStatusPedido($idPedido);
				 
				if (strpos($descricao,'Objeto entregue ao destinatário') !== false) {
				     $statusEntregue = "$descricao  |  $data  - $hora | $cidade / $uf ";
					 
					 $sql = "SELECT `status_pagto` FROM `lojadb_wpstore_orders` WHERE `id_pedido` = '13.901.2014.05.29' LIMIT 0 , 1";

            
					 if($statusPedido !="ENTREGUE" && $statusPedido !=""){
					    alteraPedidoStatus($idPedido,"ENTREGUE",$statusEntregue);
					 };
					  //MODIFICANDO STATUS PEDIDOS -----------
					 
			    }else{
					
					
				    $statusTransito = "$descricao  |  $data  - $hora | $cidade / $uf :$codigoRastreio";
				   //MODIFICANDO STATUS PEDIDOS -----------
			        if($statusPedido =="TRANSPORTADORA" && $statusPedido !="" && $statusTransito != $msgPedido && $contagemEventos==0){
						
						   //echo "----- $statusTransito--------";
					       alteraPedidoStatus($idPedido,"TRANSPORTADORA",$statusTransito);
			        };
					
				
				
    if (strpos($descricao,'Objeto devolvido ao remetente') !== false) {
	 $statusEntregue = "$descricao  |  $data  - $hora | $cidade / $uf ";
	 $statusPedido = currentStatusPedido($idPedido);
	 alteraPedidoStatus($idPedido,"DEVOLVIDO",$statusEntregue);
    };
					//MODIFICANDO STATUS PEDIDOS -----------
 };
			 
			 
				
				
				 // se existe node destino entao ...
				 if( count( $e->destino ) > 0 ){
 
					 $local = $e->destino->local;
				     $codigo = $e->destino->codigo;
				     $bairro = $e->destino->bairro;
					 $cidade = $e->destino->cidade; 
				     $uf = $e->destino->uf;
					  echo "<td> <strong>$statusEntregue</strong><br/>  $local  -  $codigo  - $bairro  /  $cidade /  $uf </td> ";
					}else{
					  echo "<td> <strong>$statusEntregue</strong> </td> ";
				    };	
				 
				 echo " </tr>";
				 
				 
				  $contagemEventos +=1;	
				  
			 endforeach;
			 
		 endforeach;
		 
		 echo 		" </tbody></table> ";
		 
	 }else{
		 echo $obj_xml->error;
	 }
	}else{
		echo "XML não parece ser um objeto valido. Parece que há um problema com o serviço de rastreamento dos Correios.";
	};

};
//RASTREIO CORREIOS ---------------------------------------------



function gerar_boleto($idPedido,$tipo='caixa'){
	if($tipo='caixa'){
		//include('payment/boleto/caixa/BoletoWebCaixa.php');
	}
	include('payment/boleto/boletos/boleto_cef_sigcb.php');
}

function gerar_aviso_impressao(){
		include('payment/boleto/caixa/aviso.php');
}


 
	
function get_cielo_gerenciar_pedido($order,$infoCieloXML){
	$orderPrint = "";
	include('payment/Cielo/customAdminPedido.php');
	return $orderPrint;
}



function verificaDescontoBoleto($postId){
		  $arrCatRemoveDesconto =  get_option('arrCatRemoveDesconto'); 
          $arrIds = explode(',' , $arrCatRemoveDesconto);
		  if ( in_category( $arrIds , $postId )) {
			  return false;
		  }else{
		  	  return true;
		  }           
};



//ADICIONAR CAMPO NA EDICAO RÁPIDA DO POST --------
add_filter( 'manage_posts_columns', 'add_coluna_postEdit', 10, 2 );
function add_coluna_postEdit( $columns, $post_type ) {
   if ( $post_type == 'produtos' )
      $columns[ 'peso_produto' ] = 'Peso do Produto';
   return $columns;
}
//-------------

//PREENCHENDO DADOS COLUNA EXTRA --------

add_action( 'manage_posts_custom_column', 'add_dados_coluna_extra', 10, 2 );
function add_dados_coluna_extra( $column_name, $post_id ) {
   switch( $column_name ) {
      case 'peso_produto':
         echo '<div id="peso_produto-' . $post_id . '">' . get_post_meta( $post_id, 'weight', true ) . '</div><small>kg</small>';
         break;
   }
}

//ADD COLUNA EXTRA TO QUICK EDIT --------------


add_action( 'bulk_edit_custom_box', 'add_coluna_quick_edit_custom_box', 10, 2 );

add_action( 'quick_edit_custom_box', 'add_coluna_quick_edit_custom_box', 10, 2 );

function add_coluna_quick_edit_custom_box( $column_name, $post_type ) {
   switch ( $post_type ) {
      case 'produtos':

         switch( $column_name ) {
            case 'peso_produto':
               ?><fieldset class="inline-edit-col-right">
                  <div class="inline-edit-group">
                     <label>
                        <span class="title">Peso do Produto</span>
                        <input type="text" name="peso_produto" value="" />
                     </label>
                  </div>
               </fieldset><?php
               break;
         }
         break;

   }
}

//ADD DADOS COLUNA EXTRA QUICK EDIT -------------

add_action( 'admin_print_scripts-edit.php', 'adicionar_enqueue_edit_scripts' );
function adicionar_enqueue_edit_scripts() {
   wp_enqueue_script( 'peso-admin-quick-edit', get_bloginfo( 'stylesheet_directory' ) . '/js/quick_edit.js', array( 'jquery', 'inline-edit-post' ), '', true );
}

//SALVAR QUICK EDIT CHANGES --------------


add_action( 'save_post','wpstoreQuick_save_post', 10, 2 );
function wpstoreQuick_save_post( $post_id, $post ) {

   // don't save for autosave
   if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
      return $post_id;

   // dont save for revisions
   if ( isset( $post->post_type ) && $post->post_type == 'revision' )
      return $post_id;

   switch( $post->post_type ) {

      case 'produtos':

         // release date
	 // Because this action is run in several places, checking for the array key keeps WordPress from editing
         // data that wasn't in the form, i.e. if you had this post meta on your "Quick Edit" but didn't have it
         // on the "Edit Post" screen.
	 if ( array_key_exists( 'peso_produto', $_POST ) )
	    update_post_meta( $post_id, 'weight', $_POST[ 'peso_produto' ] );

	 break;

   }

}


//SAVE AJAX  COLUNA EXTRA -----

add_action( 'wp_ajax_wpstore_save_bulk_edit', 'wpstore_save_bulk_edit' );
function wpstore_save_bulk_edit() {
   // get our variables
   $post_ids = ( isset( $_POST[ 'post_ids' ] ) && !empty( $_POST[ 'post_ids' ] ) ) ? $_POST[ 'post_ids' ] : array();
   $peso_produto = ( isset( $_POST[ 'peso_produto' ] ) && !empty( $_POST[ 'peso_produto' ] ) ) ? $_POST[ 'peso_produto' ] : NULL;
   // if everything is in order
   if ( !empty( $post_ids ) && is_array( $post_ids ) && !empty( $peso_produto ) ) {
      foreach( $post_ids as $post_id ) {
         update_post_meta( $post_id, 'weight', $peso_produto );
      }
   }
}



		// Add scripts to wp_head()
		function verifica_pedidos_pendentes() {
			
			cancelaPedido();
		    // Your PHP goes here
			$total = get_qtd_pedidos_pendentes();
			if($total>0){
			include('layout/avisoPedidosPendentes.php');
		    };
		}
		
		
		function get_qtd_pedidos_pendentes(){
			
			  global $current_user;
                get_currentuserinfo();
                $idUser = $current_user->ID;
           
			
		    global $wpdb;
		    $tabela = $wpdb->prefix."";
		    $tabela .=  "wpstore_orders";
    
		    $totalpedidos = 0;
    
		  /*  
		   $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_usuario`='$idUser' AND `status_pagto`='PENDENTE' ORDER BY `id`  DESC " ,1,'') );
           */
	 
			$totalpedidos = $wpdb->get_var(   "SELECT COUNT(*)  FROM  `$tabela` WHERE  `id_usuario`='$idUser' AND `status_pagto`='PENDENTE' ORDER BY `id`  DESC "  );
			
			return $totalpedidos;
		}




   
		function cancelaPedido(){
			
			
			
		   $order = addslashes($_REQUEST['order']);
		   $cancelar = addslashes($_REQUEST['cancelar']);
		    
		      if(  $cancelar  !=''){
			 
  			       global $current_user;
                   get_currentuserinfo();
                   $idUser = $current_user->ID;
			       $userPedido = "";
			       
	   		    global $wpdb;
	   		    $tabela = $wpdb->prefix."";
	   		    $tabela .=  "wpstore_orders";
    
	
		
   		            $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_usuario`='$idUser' AND `id_pedido` = '$order' ORDER BY `id`  DESC " ,1,'') );


   		           foreach ( $fivesdrafts as $fivesdraft ){
                        $userPedido = $fivesdraft->id_usuario;
   		           };

 

                  if($userPedido==$idUser && $userPedido !=""){
		             $msg = "Pedido Cancelado pelo cliente";
                     alteraPedidoStatus($order,'CANCELADO',$msg,"","");
				     wp_redirect(get_permalink(get_idPaginaPedidos()));
		           };
	         };
		 
		};
		
		
		
		
		function get_string_between($string, $start, $end){
		    $string = " ".$string;
		    $ini = strpos($string,$start);
		    if ($ini == 0) return "";
		    $ini += strlen($start);
		    $len = strpos($string,$end,$ini) - $ini;
		    return substr($string,$ini,$len);
		}

	
		
		
		
?>