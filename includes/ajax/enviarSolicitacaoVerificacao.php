<?php

              require("../../../../../wp-load.php");
  
		 
                  $msgError ='';

                   global $current_user;
                   get_currentuserinfo();
                   $user_email =  $current_user->user_email ;
                   $idUser = $current_user->ID;
				   
                   if(intval($current_user->ID)<=0){
                         $msgError =  "Permissão Administrativa negada";
                         echo $msgError;
                   }else{   
                       
      
	  
	   				$verificaSolicitacao = get_user_meta( $idUser,'solicitacaoConfirmacao', true);
	   				 if($verificaSolicitacao=='enviado'){
					    update_user_meta( $idUser,'solicitacaoConfirmacao2', 'enviado');
					 }             
		 
 update_user_meta( $idUser,'solicitacaoConfirmacao', 'enviado');
					  
		  $akEmail = get_user_meta($idUser,'akEmail',true);		
		
		 //if($akEmail==""){
		  $akEmail =  wp_generate_password();
		  
		  $arrRemove = array( '!','@','#','$','%','^','&','*','(',')', '-','_','[',']','{','}','<','>','~','`','+','=',',','.',';',':','/','?','|');
		  $akEmail = str_replace($arrRemove,'',$akEmail);
		  update_user_meta($idUser,'akEmail', $akEmail);
		  //};
		  
		  //ENVIAR EMAIL ADMIN------
						
		 // ENVIO DE EMAI ----------------------------------------------------------
	              
	              
	 	                  $user_email =  $user_email;
	        
	     				   $header = "<div style='width:100%;padding:5px;background:#15829D;margin-bottom:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/topo-email.png' /></a></div>";

	                        $footer = "<div style='width:100%;padding:5px;background:#0A2A35;margin-top:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/footer-email.png'/></a></div>";

	                        $idLogin = get_idPaginaLogin();
							$idMinhaConta = get_idPaginaPerfil();
							
	            $pageLogin = get_permalink($idLogin);
                $pageMinhaConta= get_permalink($idMinhaConta);
						
	  $emailConfirmacaoRegistroTexto= get_option('emailConfirmacaoRegistroTextoWPSHOP'); 
					   
		$pageEditUser = get_bloginfo('url')."/wp-admin/users.php?s=$user_email";		 
						 
						 
 $mensagemEmail = "
	 
	       <h1>Olá $nome,  </h1> 
 
	      <p>Sua solicitação para autenticação de cadastro no site <strong> ".get_bloginfo('name')." </strong> foi enviada com sucesso ! Obrigado por acessar e se inscrever em nosso site.</p>
		  
		  <p>Você receberá uma resposta de nossa equipe assim que sua solicitação for analisada. </p>
						  
	      <p> $emailConfirmacaoRegistroTexto </p> 
		  
		  <p>Para acessar sua conta  siga <a href='".$pageLogin."?akEmail=$akEmail' >".$pageLogin."?akEmail=$akEmail</a> . </p> ";
                          
                          
 $mensagemEmail2 = "
	       <h1>Olá Administrador ,  </h1> 
	  <p>Você têm uma nova solicitação de  autênticação de cadastro</p>
 
	 <p> Dados do usuário :   <a href='".$pageMinhaConta."?idUser=$idUser' >".$pageMinhaConta."?idUser=$idUser</a>  </p>
												
												
  <p>Para autorizar a autenticação faça o login em  <a href='".$pageLogin."' >".$pageLogin."</a> 
  <br/>
 Após login  Edite as opções do usuário em :
   <a href='".$pageEditUser."' >".$pageEditUser."</a> 
   
 
  
   </p>
									 
									  
	                                 ";
                                
                      
					  
	                         $assuntoEmail = "Autênticação de cadastro:  ".get_bloginfo('name')."";
							 
	                         $assuntoEmail2 = "Autênticação de cadastro:  ".get_bloginfo('name')."";
 
	            
                   $idPaginaPerfil = get_idPaginaPerfil();
	               if($checkout =="TRUE"){
	               $idPaginaPerfil = get_idPaginaCheckout();    
	               }
                                  
	                 $urlRedirect = get_permalink($idPaginaPerfil);
	                     echo $idUser."****".$urlRedirect;
                                  
                        include_once('email.php');
	                
                        
	                 // FINAL ENVIO DE EMAIL ----------------------------------------------------------
					 
					 	 
					   //ENVIAR EMAIL ADMIN --------
                    
				 
                        //echo "Solicitação enviada com sucesso!";
                   };



?>