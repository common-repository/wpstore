<?php

              require("../../../../../wp-load.php");
  
							global $wpdb;
							
				$nomeUsuario = addslashes($_REQUEST['nomeUsuario']);
              	$nascimentoUsuario = addslashes($_REQUEST['nascimentoUsuario']);
              	$sexoUsuario = addslashes($_REQUEST['sexoUsuario']);
              	$enderecoUsuario = addslashes($_REQUEST['enderecoUsuario']);
              	$enderecoUsuarioNumero = addslashes($_REQUEST['enderecoUsuarioNumero']);
              	$complementoUsuario = addslashes($_REQUEST['complementoUsuario']);
              	$bairroUsuario = addslashes($_REQUEST['bairroUsuario']);
              	$cidadeUsuario = addslashes($_REQUEST['cidadeUsuario']);
              	$estadoUsuario = addslashes($_REQUEST['estadoUsuario']);
              	$cepUsuario = addslashes($_REQUEST['cepUsuario']);
              	
              	$enderecoUsuario2 = addslashes($_REQUEST['enderecoUsuario2']);
              	$enderecoUsuarioNumero2 = addslashes($_REQUEST['enderecoUsuarioNumero2']);
              	$complementoUsuario2 = addslashes($_REQUEST['complementoUsuario2']);
              	$bairroUsuario2 = addslashes($_REQUEST['bairroUsuario2']);
              	$cidadeUsuario2 = addslashes($_REQUEST['cidadeUsuario2']);
              	$estadoUsuario2 = addslashes($_REQUEST['estadoUsuario2']);
              	$cepUsuario2 = addslashes($_REQUEST['cepUsuario2']);
              	
              	$userCpf = addslashes($_REQUEST['userCpf']);   
                $userCnpj = addslashes($_REQUEST['userCnpj']);
				
              	$dddUsuario = addslashes($_REQUEST['dddUsuario']);
              	$telefoneUsuario = addslashes($_REQUEST['telefoneUsuario']);

                $dddUsuarioCel = addslashes($_REQUEST['dddUsuarioCel']);
                $telefoneUsuarioCel = addslashes($_REQUEST['telefoneUsuarioCel']); 
           
		  
		   $extrasInput = $_REQUEST['extrasInput'] ;     
 
              
                  $msgError ='';

                   global $current_user;

                   $user_email =  $current_user->user_email ;
                   $idUser = $current_user->ID;
				   
                   if(intval($current_user->ID)<=0){
                         $msgError =  "Permissão Administrativa negada";
                         echo $msgError;
                   }else{   
                       
                   
				   
				
             
                      if($userCpf !="" && $userCpf!="undefined"){
                             update_user_meta($current_user->ID,'userCpf', $userCpf);
           
                      };
					  
                      if($userCnpj !="" && $userCnpj!="undefined"){
                             update_user_meta($current_user->ID,'userCnpj', $userCnpj);
           
                      };
                          
                          
                       if($nomeUsuario !="" && $nomeUsuario !="undefined"){
                          update_user_meta($current_user->ID,'first_name', $nomeUsuario);
                          update_user_meta($current_user->ID,'display_name', $nomeUsuario);
                       };
					   
					   
                       if($nascimentoUsuario !="" && $nascimentoUsuario !="undefined"){
                          update_user_meta($current_user->ID,'userNascimento', $nascimentoUsuario);
                       };
					   
					   
                       if($sexoUsuario !="" && $sexoUsuario  !="undefined"){
                          update_user_meta($current_user->ID,'userSexo', $sexoUsuario);
                       };
					   
					   
                        if($enderecoUsuario !="" && $enderecoUsuario  !="undefined"){
                            update_user_meta($current_user->ID,'userEndereco', $enderecoUsuario);
                         };
						 
						 
                       if($enderecoUsuarioNumero !="" && $enderecoUsuarioNumero !="undefined"){
                           update_user_meta($current_user->ID,'userEnderecoNumero', $enderecoUsuarioNumero);
                        };
						
						
                        if($complementoUsuario !="" && $complementoUsuario !="undefined"){
                           update_user_meta($current_user->ID,'userComplemento', $complementoUsuario);
                        };
						
						
                        if($bairroUsuario !="" && $bairroUsuario !="undefined"){
                           update_user_meta($current_user->ID,'userBairro', $bairroUsuario);
                        };
						
						
                        if($cidadeUsuario !="" && $cidadeUsuario !="undefined"){
                           update_user_meta($current_user->ID,'userCidade', $cidadeUsuario);
                        };
						
						
                        if($estadoUsuario !="" && $estadoUsuario!="undefined"){
                           update_user_meta($current_user->ID,'userEstado', $estadoUsuario);
                        };
						
						
                         if($cepUsuario !="" && $cepUsuario !="undefined"){
                             update_user_meta($current_user->ID,'userCep', $cepUsuario);
                          };
						  
						  
                          
                          
                         //if($enderecoUsuario2 !="" && $enderecoUsuario2  !="undefined"){
                              update_user_meta($current_user->ID,'userEndereco2', $enderecoUsuario2);
                         //};
                        // if($enderecoUsuarioNumero2 !="" && $enderecoUsuarioNumero2 !="undefined"){
                             update_user_meta($current_user->ID,'userEnderecoNumero2', $enderecoUsuarioNumero2);
                         // };
                         // if($complementoUsuario2 !="" && $complementoUsuario2 !="undefined"){
                             update_user_meta($current_user->ID,'userComplemento2', $complementoUsuario2);
                         // };
                         // if($bairroUsuario2 !="" && $bairroUsuario2 !="undefined"){
                             update_user_meta($current_user->ID,'userBairro2', $bairroUsuario2);
                         // };
                         // if($cidadeUsuario2 !="" && $cidadeUsuario2 !="undefined"){
                             update_user_meta($current_user->ID,'userCidade2', $cidadeUsuario2);
                         // };
                         // if(trim($estadoUsuario2) !="" && $estadoUsuario2!="undefined"){
                             update_user_meta($current_user->ID,'userEstado2', $estadoUsuario2);
                         // };
                         //  if($cepUsuario2 !="" && $cepUsuario2 !="undefined"){
                               update_user_meta($current_user->ID,'userCep2', $cepUsuario2);
                         //   };
                            
                            
                            
                        if($dddUsuario !="" && $dddUsuario!="undefined"){
                             update_user_meta($current_user->ID,'userDDD', $dddUsuario);
                          };
						  
						  
                        if($telefoneUsuario !="" && $telefoneUsuario !="undefined"){
                           update_user_meta($current_user->ID,'userTelefone', $telefoneUsuario);
                        };
						
						
                        
                        if($dddUsuarioCel !="" && $dddUsuarioCel!="undefined"){
                                 update_user_meta($current_user->ID,'userDDDCel', $dddUsuarioCel);
                        };
						
						
                              
                        if($telefoneUsuarioCel !="" && $telefoneUsuarioCel !="undefined"){
                               update_user_meta($current_user->ID,'userTelefoneCel', $telefoneUsuarioCel);
                        };
						
						
                            
     if(count($extrasInput )>=1){		   
	 foreach( $extrasInput as $key=>$value){
          update_user_meta( $idUser, "".$key, $value);
	 
 	 }
     };
		            
                
				     
                         

//------------UPDATE MOBILE CAD --------------------------
                                    //if($nome !=""){
                                    $nome     = addslashes($_REQUEST['nome']);
                                    $sobrenome  = addslashes($_REQUEST['sobrenome']);
                                    $diaNasc  = addslashes($_REQUEST['diaNasc']);  
                                    $mesNasc  = addslashes($_REQUEST['mesNasc']);    
                                    $anoNasc   = addslashes($_REQUEST['anoNasc']); 
                                    $sexo      = addslashes($_REQUEST['sexo']);
                                    $telDDD    = addslashes($_REQUEST['telDDD']);
                                    $telUm     = addslashes($_REQUEST['telUm']);
                                    $telDoisDDD  = addslashes($_REQUEST['telDoisDDD']);    
                                    $telDois     = addslashes($_REQUEST['telDois']);
                                    $telTresDDD  = addslashes($_REQUEST['telTresDDD']);
                                    $telTres    = addslashes($_REQUEST['telTres']);
                                    update_user_infos($nome,$sobrenome,$nascimentoUsuario,$sexo,$telDDD,$telUm,$telDoisDDD,$telDois,$telTresDDD,$telTres);
                                    //};
																		
																		
//-------------UPDATE MOBILE CAD ----------------------------


   
                        echo "Atualizado com sucesso!";
											 
		 
		 
		 
		 
		 
		 
		 
 //------------ ---------------------ADD NOVO ENDERECO TABELA						 										
											 
                        $tabela = $wpdb->prefix."";
                        $tabela .=  "wpstore_users_address";
                        
												$localNome = "Endereço 1";
										 	 
                     $sql = "SELECT * FROM `$tabela` WHERE    `nomeEndereco` = '$localNome'  AND  `id_usuario` = '$idUser' ";

                     $userAddress = $wpdb->get_results( $sql);  
                     $contAddress = 0;   
										 $idSaved = 0;
                     
                     foreach ( $userAddress as $address ){
                         $contAddress +=1;
												 $idSaved = $address->id;
                     };
                     
	//SE NOME DO ENDERECO JA EXISTE ADICIONA NUMERO AO NOME   
	   
                     if($contAddress>0){    
                         
		                    
                       $sql = "UPDATE `$tabela` SET 
                       `nomeEndereco` = '$localNome',
                       `destinatarioEndereco` = '$nomeUsuario',
                       `cep` = '$cepUsuario',
                       `cidade` = '$cidadeUsuario',
                       `bairro` = '$bairroUsuario',
                       `estado` = '$estadoUsuario',
                       `endereco` = '$enderecoUsuario',
                       `numero` = '$enderecoUsuarioNumero',
                       `complemento` = '$complementoUsuario',
                       `referencia` = '',
                       `tipoEndereco` = 'Residencial' 
                        WHERE  `nomeEndereco`  =  '$localNome' AND `id_usuario` =  '$idUser';"; 
                         
                       $userAddress = $wpdb->query( $sql);
                       $msg =  "1***<span class='green'>Editado com sucesso!</span>"; 
                        
                         
                 //if($definirCobranca=="1"){
                      set_id_addr_cobranca( $idEdit,$idUser);
                 //};
                     
              
	
	 $localNome = "Endereço 2 Entrega";
   $sql = "UPDATE `$tabela` SET 
   `nomeEndereco` = '$localNome',
   `destinatarioEndereco` = '$nomeUsuario',
   `cep` = '$cepUsuario2',
   `cidade` = '$cidadeUsuario2',
   `bairro` = '$bairroUsuario2',
   `estado` = '$estadoUsuario2',
   `endereco` = '$enderecoUsuario2',
   `numero` = '$enderecoUsuarioNumero2',
   `complemento` = '$complementoUsuario2',
   `referencia` = '',
   `tipoEndereco` = 'Residencial' 
    WHERE `nomeEndereco` =  '$localNome' AND `id_usuario` =  '$idUser';"; 
     
   $userAddress = $wpdb->query( $sql);
	 
	 
 
 	       $sql = "SELECT * FROM `$tabela` WHERE    `nomeEndereco` = '$localNome'  AND  `id_usuario` = '$idUser' ";
        $userAddress = $wpdb->get_results( $sql);  
        $idSaved = 0;
        foreach ( $userAddress as $address ){
           $idSaved = $address->id;
        };
        update_user_meta($idUser,'idEntrega',  $idSaved);    
	
			 
                        
                  }else{  
                             
                            
			  	                  $localNome = "Endereço 1";
					 
			                      $sql = "INSERT INTO `$tabela` (   `id` ,   `id_usuario` , `nomeEndereco` ,   `destinatarioEndereco` ,  `cep` ,  `cidade` , `bairro` , `estado` ,  `endereco` ,  `numero` , `complemento` ,`referencia` ,`tipoEndereco`  )
                                     VALUES ( NULL , '$idUser', '$localNome', '$nomeUsuario',  '$cepUsuario', '$cidadeUsuario', '$bairroUsuario', '$estadoUsuario', '$enderecoUsuario', '$enderecoUsuarioNumero',  '$complementoUsuario', '', 'Residencial' );";
                             
                          
                             
                             $userAddress = $wpdb->query( $sql);   
                             $id = mysql_insert_id(); 
                             
                             //if($definirCobranca=="1"){
                             set_id_addr_cobranca($id,$idUser);
                             //};
                             
			   
			      //if($definirEntrega=="1"){
                              update_user_meta($idUser,'idEntrega', $id);    
                                //}; 
																 
					  	                  $localNome = "Endereço 2 Entrega";
																
					                      $sql = "INSERT INTO `$tabela` (   `id` ,   `id_usuario` , `nomeEndereco` ,   `destinatarioEndereco` ,  `cep` ,  `cidade` , `bairro` ,`estado` ,  `endereco` ,  `numero` , `complemento` ,`referencia` ,`tipoEndereco`  )
		                                     VALUES ( NULL , '$idUser', '$localNome Entrega', '$nomeUsuario',  '$cepUsuario2', '$cidadeUsuario2', '$bairroUsuario2', '$estadoUsuario2', '$enderecoUsuario2', '$enderecoUsuarioNumero2',  '$complementoUsuario2', '', 'Residencial' );";
                              
		                             $userAddress = $wpdb->query( $sql);  
																  
                                $msg =  "$id***<span class='green'>Adicionado com sucesso!</span>";
																
																
														 	 $idEdit = $wpdb->insert_id;
														    update_user_meta($idUser,'idEntrega',  $idEdit); 
                             
                     };
	   
                //------------------------------------------------------------------ADD NOVO ENDERECO TABELA						  
							
							
							
							
							
							
                   };




              	?>