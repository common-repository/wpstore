<?php

              require("../../../../../wp-load.php");

             
              $idU = intval($_POST['id']);
              $status = trim($_POST['status']);
              $msgstatus = $_POST['msgStatus'];
			  
			  
			  
 	          $user_info = get_userdata($idU); 
			  $user_email =  $user_info->user_email;     
			  
		  
              $first_name   = trim(get_user_meta( $idU,'first_name',true));        
              $last_name    = trim(get_user_meta( $idU,'last_name',true));        
              
             
              $nome =  $first_name ;        
              $sobrenome = $last_name ;

              $display_name  = trim(get_user_meta( $idU,'display_name',true));        
			  
			  
			  
			  
			  
                  if (  current_user_can( 'manage_options', $$idU ) ){
	  			        update_usermeta( $idU, 'wpsAutorizacao',  $status  );
						
						
						
						
						
						
 					   //ENVIAR EMAIL ADMIN------
						
						
 	 	              // ENVIO DE EMAIL ----------------------------------------------------------
					 if($status=="Confirmado" || $status =="Revisar"){
	              
				  
				  
				  
				  
 	 	                  $user_email =  $user_email;
	        
 	     				   $header = "<div style='width:100%;padding:5px;background:#15829D;margin-bottom:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/topo-email.png' /></a></div>";

 	                        $footer = "<div style='width:100%;padding:5px;background:#0A2A35;margin-top:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/footer-email.png'/></a></div>";

 	                        $idLogin = get_idPaginaLogin();
 							$idMinhaConta = get_idPaginaPerfil();
							
 	            $pageLogin = get_permalink($idLogin);
                 $pageMinhaConta= get_permalink($idMinhaConta);
						
 	  $emailConfirmacaoRegistroTexto= get_option('emailConfirmacaoRegistroTextoWPSHOP'); 
					   
 		$pageEditUser = get_bloginfo('url')."/wp-admin/users.php?s=$user_email";	
		
			 
	   $msgExtra = "";               
     if($status=="Confirmado"){
     	$msgExtra = "Seu cadastro foi aprovado em nosso site e a partir de agora você tem acesso a nosso catalogo de compras e produtos especiais.";
     };
     if($status=="Revisar"){
     	$msgExtra = "Verifique os campos informados acima em seu cadastro e solicite uma nova revisão.";
     };      		 
						 
  $mensagemEmail = "
	 
 	       <h1>Olá $nome,  </h1> 
 
 	      <p>Sua solicitação  de autênticação foi analisada no site  <strong> ".get_bloginfo('name')." </strong> .</p>
		   	  
 	      <p> $emailConfirmacaoRegistroTexto </p> 
		  
		  <p>Status : <strong> $status</strong><br/>
		    $msgstatus</p>
		  
		
			<p>$msgExtra</p>
		
		
 		  <p>Para acessar sua conta  siga <a href='".$pageLogin."/' >".$pageLogin."</a> . </p> ";
           
	          
  $mensagemEmail2 = "
 	       <h1>Olá Administrador ,  </h1> 
 	  <p>Confirmação de aprovação de cadastro.</p>
 
 
	  <p>Status : <strong> $status</strong><br/>
	    $msgstatus</p>

		
 	 <p> Dados do usuário :   <a href='".$pageMinhaConta."?idUser=$idU' >".$pageMinhaConta."?idUser=$idU</a>  </p>
												
												
   <p>Para modificar o status de  autenticação faça o login em  <a href='".$pageLogin."' >".$pageLogin."</a> 
   <br/>
  Após login  Edite as opções do usuário em :
    <a href='".$pageEditUser."' >".$pageEditUser."</a> 
   
 
  
    </p> ";
                                
                      
					  
 	                         $assuntoEmail = "Analise Autênticação de cadastro:  ".get_bloginfo('name')."";
							 
 	                         $assuntoEmail2 = "Analise Autênticação de cadastro:  ".get_bloginfo('name')."";
 
	            
                    $idPaginaPerfil = get_idPaginaPerfil();
 	               if($checkout =="TRUE"){
 	               $idPaginaPerfil = get_idPaginaCheckout();    
 	               }
                                  
 	                 $urlRedirect = get_permalink($idPaginaPerfil);
 	                    // echo $idUser."****".$urlRedirect;
                                  
                         include_once('email.php');
	                
					
					
					
					 };
 	                 // FINAL ENVIO DE EMAIL ----------------------------------------------------------
					 
					 	 
 					   //ENVIAR EMAIL ADMIN --------
					   
					   
					   
					   
					   
					   
				        echo "OK : Salvo com Sucesso!";
				  };  
        
?>