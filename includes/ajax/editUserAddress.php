<?php
              require("../../../../../wp-load.php");   
              
              $idEdit =  intval(addslashes($_REQUEST['ide'])); 
              
              $act =  addslashes(trim($_REQUEST['act']));
              
               
               $localNome =  addslashes($_REQUEST['localNome']);  
               
               $nomeDest =  addslashes($_REQUEST['nomeDest']);
               $cepUm = addslashes( $_REQUEST['cepUm']); 
               $cepDois =  addslashes($_REQUEST['cepDois']); 
                  
               $cep = $cepUm."-".$cepDois;  
               
               $enderecoCad = addslashes($_REQUEST['enderecoCad']);    
               $numero = addslashes($_REQUEST['numero']);
               $complemento = addslashes($_REQUEST['complemento']);    
               $pontoRef = addslashes($_REQUEST['pontoRef']);
               $bairro = addslashes($_REQUEST['bairro']);  
               $cidade = addslashes($_REQUEST['cidade']);
               $estado = addslashes($_REQUEST['estado']);   
               $tipoEndereco = addslashes($_REQUEST['tipoEndereco']);     
               $definirCobranca = addslashes($_REQUEST['definirCobranca']);  
			   $definirEntrega = addslashes($_REQUEST['definirEntrega']);  
			   
			   
			   //----------------------------------------------------
			   
			   $telUmDDD  = addslashes($_REQUEST['telUmDDD']);   
			   $telUm  = addslashes($_REQUEST['telUm']);    
			   $cpfUm  = addslashes($_REQUEST['cpfUm']);     
			   $userCnpj  = addslashes($_REQUEST['userCnpj']); 
			   
			   
                   if( $telUmDDD!="" && $telUmDDD!="undefined"){
                        add_user_meta($current_user->ID,'userDDD', $telUmDDD,true) OR update_user_meta($current_user->ID,'userDDD', $telUmDDD);
                   };
				    
                   if( $telUm !="" &&  $telUm !="undefined"){
                      add_user_meta($current_user->ID,'userTelefone',  $telUm,true) OR update_user_meta($current_user->ID,'userTelefone',  $telUm);
                   };
				   
				   
		 
				   
                   if($cpfUm !="" && $cpfUm!="undefined"){
					   
					      $userCpf = $cpfUm;
						  
		                 add_user_meta($current_user->ID,'userCpf', $userCpf,true) OR   update_user_meta($current_user->ID,'userCpf', $userCpf);
						    
		            
						  
                   };
 
 
                   if($userCnpj !="" && $userCnpj!="undefined"){
					 
		                 add_user_meta($current_user->ID,'userCnpj', $userCnpj,true) OR   update_user_meta($current_user->ID,'userCnpj', $userCnpj);
						    
		            
						  
                   };
 
 
				   //--------------------------------------------------------
          

                   $msgError ='';

                   global $current_user;
                    
                   get_currentuserinfo(); 

                   $user_email =  $current_user->user_email ;    
                   $idUser =     $current_user->ID;

                   if(intval($current_user->ID)<=0){       
                       
                         $msg =  "Permissão Administrativa negada";
                         
                         
                   }else{   
                               
                          
                           
                                 $tabela = $wpdb->prefix."";
                                 $tabela .=  "wpstore_users_address";

                          
                                
                              
                          if($idEdit >0){ 
                                 
								 
							
                                  $sql = "SELECT * FROM `$tabela` WHERE    `nomeEndereco` = '$localNome'  AND  `id_usuario` = '$idUser' ";

                                 $userAddress = $wpdb->get_results( $sql);  
                                 $contAddress = 0;   

                                 foreach ( $userAddress as $address ){
                                     $contAddress +=1;
                                 };
                                 
                                 
                                 if($act=='edt'){
                                       
                                         $sql = "UPDATE `$tabela` SET 
                                         `nomeEndereco` = '$localNome',
                                         `destinatarioEndereco` = '$nomeDest',
                                         `cep` = '$cep',
                                         `cidade` = '$cidade',
                                         `bairro` = '$bairro',
                                         `estado` = '$estado',
                                         `endereco` = '$enderecoCad',
                                         `numero` = '$numero',
                                         `complemento` = '$complemento',
                                         `referencia` = '$pontoRef',
                                         `tipoEndereco` = '$tipoEndereco' 
                                          WHERE `id` =  '$idEdit' AND `id_usuario` =  '$idUser';"; 
                                           
                                         $userAddress = $wpdb->query( $sql);
                                         $msg =  "1***<span class='green'>Editado com sucesso!</span>"; 
                                          
                                           
		                                       //if($definirCobranca=="1"){
		                                                set_id_addr_cobranca( $idEdit,$idUser);
		                                       //};
                                       
									          // if($definirEntrega=="1"){
		                                        update_user_meta($idUser,'idEntrega',  $idEdit);                                 
											 //  }; 
										  
										  
										  
                                                 
                                                     
                                 }elseif($act=='rmv'){ 
                                     
                                         $sql = "DELETE FROM `$tabela` WHERE `id`  = '$idEdit' AND `id_usuario` =  '$idUser'; ";
                                         $userAddress = $wpdb->query( $sql);
                                         $msg =  "2***<span class='green'>Removido com sucesso!</span>";  
                                               
                                 }
                              
                              
                          }else{
                                   
                          
                          
                               //------------------------------------------------------------------ADD NEW  
                              
                             
                               $sql = "SELECT * FROM `$tabela` WHERE    `nomeEndereco` = '$localNome'  AND  `id_usuario` = '$idUser' ";

                               $userAddress = $wpdb->get_results( $sql);  
                               $contAddress = 0;   
                               
                               foreach ( $userAddress as $address ){
                                   $contAddress +=1;
                               };
                               
							//SE NOME DO ENDERECO JA EXISTE ADICIONA NUMERO AO NOME   
							   
                               if($contAddress>0){    
                                   
								   $tentativa = 2;
								   $nomeDisponivel = false;
								   while($nomeDisponivel==false){
								   	
								  
	                               $sql = "SELECT * FROM `$tabela` WHERE    `nomeEndereco` = '$localNome".$tentativa."'  AND  `id_usuario` = '$idUser' ";

	                               $userAddress = $wpdb->get_results( $sql);  
	                               $contAddress = 0;   
                               
	                               foreach ( $userAddress as $address ){
	                                   $contAddress +=1;
	                               };
							   
								    if($contAddress<=0){
								       $nomeDisponivel =true;
									   //GRAVAR ENDERECO -------------
									   $sql = "INSERT INTO `$tabela` (   `id` ,   `id_usuario` , `nomeEndereco` ,   `destinatarioEndereco` ,  `cep` ,  `cidade` , `bairro` ,`estado` ,  `endereco` ,  `numero` , `complemento` ,`referencia` ,`tipoEndereco`  )
                                               VALUES ( NULL , '$idUser', '$localNome".$tentativa."', '$nomeDest',  '$cep', '$cidade', '$bairro', '$estado', '$enderecoCad', '$numero',  '$complemento', '$pontoRef', '$tipoEndereco' );";
                                       
                                    
                                       
                                       $userAddress = $wpdb->query( $sql);   
                                       $id = mysql_insert_id(); 
                                       
                                       //if($definirCobranca=="1"){
                                            set_id_addr_cobranca($id,$idUser);
                                       //};
                                       
									   
									      //if($definirEntrega=="1"){
                                          update_user_meta($idUser,'idEntrega', $id);    
                                          //}; 
										  
										  
                                          $msg =  "$id***<span class='green'>Adicionado com sucesso!</span>";
									   //FIM GRAVAR ENDERECO -------------
									   
									};  
									
									  $tentativa +=1;
								 }; // while nome disponivel  ==false
									 
                                  
                            }else{  
                                       
                                      
									  
									   $sql = "INSERT INTO `$tabela` (   `id` ,   `id_usuario` , `nomeEndereco` ,   `destinatarioEndereco` ,  `cep` ,  `cidade` , `bairro` ,`estado` ,  `endereco` ,  `numero` , `complemento` ,`referencia` ,`tipoEndereco`  )
                                               VALUES ( NULL , '$idUser', '$localNome', '$nomeDest',  '$cep', '$cidade', '$bairro', '$estado', '$enderecoCad', '$numero',  '$complemento', '$pontoRef', '$tipoEndereco' );";
                                       
                                    
                                       
                                       $userAddress = $wpdb->query( $sql);   
                                       $id = mysql_insert_id(); 
                                       
                                       //if($definirCobranca=="1"){
                                                set_id_addr_cobranca($id,$idUser);
                                       //};
                                       
									   
									      //if($definirEntrega=="1"){
                                          update_user_meta($idUser,'idEntrega', $id);    
                                          //}; 
										  
										  
                                          $msg =  "$id***<span class='green'>Adicionado com sucesso!</span>";
                                       
                               };
							   
					 }
                                   
                             //------------------------------------------------------------------ADD NEW    
                                     
                                
                                
                                
                            
                                
                                
                                
                                
                                
                                
                                   
                                     
                          
                          
                   };


                      echo $msg;

              	?>