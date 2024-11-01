<?php 
require("../../../../../wp-load.php");
 

 
	$email= $_REQUEST['emp'];
	$senha1 = $_REQUEST['pwp'];
	$senha2 = $_REQUEST['pw2p'];
	$nome = $_REQUEST['nome'];
	$sobrenome = $_REQUEST['sobrenome']; 
	
	
	$checkout = $_REQUEST['checkout'];
    $receba  = $_REQUEST['receba']; 
 
                 
     $nomeUsuario = $_REQUEST['nome']." ".$_REQUEST['sobrenome'];   
     $userCpf = $_REQUEST['cpfUm'];  
	 $userCnpj = $_REQUEST['cnpj'];  
      
	$nascimentoUsuario = $_REQUEST['nascimentoUsuario'];  
    //$diaNasc = $_REQUEST['diaNasc'];    
     //$mesNasc = trim($_REQUEST['mesNasc']);     
    // $anoNasc = $_REQUEST['anoNasc']; 
	// $nascimentoUsuario =  $diaNasc."/".$mesNasc."/".$anoNasc;
       
     $sexoUsuario= trim($_REQUEST['sexo']); 
     
     $cepUm = $_REQUEST['cepUm'];  
     $cepDois = $_REQUEST['cepDois'];
     $cepUsuario = $cepUm."-".$cepDois;
     
     $dddUsuario = $_REQUEST['telDDD'];    
     $telefoneUsuario = $_REQUEST['telUm'];  

     $dddUsuario2= $_REQUEST['telDoisDDD'];   
     $telefoneUsuario2 = $_REQUEST['telDois']; 

     $dddUsuarioCel  = $_REQUEST['telTresDDD'];    
     $telefoneUsuarioCel = $_REQUEST['telTres'];
     
             
    
	$user_login = sanitize_user( $email);
	$user_email = apply_filters( 'user_registration_email', $email );
	
	$msgReg ='' ;
	
	
	$plugin_directory = str_replace('ajax/','',plugin_dir_url( __FILE__ ));
    


	// Check the username
	if ( $user_login == '' )
		$msgReg .='ERROR: Por favor, escolha um nome de usuário.<br/>' ;
	elseif ( !validate_username( $user_login ) ) {
		$msgReg .='<strong>ERROR</strong>: Este nome é invalido.  Escolha um nome válido.<br/>';
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
		$msgReg .='<strong>ERROR</strong>: Este nome  de usuário já esta registrado em nosso sistema. Por favor, escolha outro nome de usuário.<br/>';

	// Check the e-mail address
	if ($user_email == '') {
		$msgReg .='<strong>ERROR</strong>: Por favor  informe seu email de contato.<br/>';
	
	} elseif ( email_exists( $user_email ) )
		$msgReg .='<strong>ERROR</strong>: Este email já está registrado . Por favor ,   escolha outro.<br/><br/>';


	if ( $msgReg =="" ){
	    
	 $user_id = wp_create_user($email, $senha1,$email);
	    
	
		if($nome != '' && $nome  !="undefined" ){
	   	
	        $user_id = wp_update_user( array( 'ID' =>  $user_id, 'first_name' =>  $nome ) );
		
		  // add_user_meta($user_id,'first_name',$nome,true);
		  //update_user_meta($user_id,'first_name',$nome);
		 
		   add_user_meta($user_id,'display_name',$nome,true);
		   update_user_meta($user_id,'display_name', $nome);   
		 
		};
		 
		 
		if($sobrenome !='' && $sobrenome !="undefined"){  
	     add_user_meta($user_id,'last_name',$sobrenome,true);
		 update_user_meta($user_id, 'last_name',$sobrenome);   
	     };   
	     
	     
	     
	      
             if($_REQUEST['cpfUm']!="" && $_REQUEST['cpfUm']!="undefined"){
                 
				    add_user_meta($user_id,'userCpf', $userCpf,true) OR  update_user_meta($user_id,'userCpf', $userCpf);    
				 
					     
              };
            
			
              if($_REQUEST['cnpj']!="" && $_REQUEST['cnpj']!="undefined"){
                    add_user_meta($user_id,'userCnpj', $userCnpj,true) OR update_user_meta($user_id, 'userCnpj', $userCnpj);   
					
			  };
			   
			
			
				
               
            if($nomeUsuario !="" && $nomeUsuario !="undefined"){
               //update_user_meta($user_id,'first_name', $nome);  
               //update_user_meta($user_id,'last_name', $sobrenome);
               //update_user_meta($user_id,'display_name', $nomeUsuario);
            };     
            
        
            if($nascimentoUsuario !="" && $nascimentoUsuario !="undefined"){ 
                
               update_user_meta($user_id,'userNascimento', $nascimentoUsuario);
               
               //update_user_meta($user_id,'diaNasc', $diaNasc);
               //update_user_meta($user_id,'mesNasc', $mesNasc);
               //update_user_meta($user_id,'anoNasc', $anoNasc);
               
            };     
        
            
            
            if($sexoUsuario !="" && $sexoUsuario  !="undefined"){
               update_user_meta($user_id,'userSexo', $sexoUsuario);
            }; 
            
             
         
      
                   
             if($cepUsuario !="" && $cepUsuario !="undefined"){
                   update_user_meta($user_id,'userCep', $cepUsuario); 
                   update_user_meta($user_id,'cepUm', $cepUm); 
                   update_user_meta($user_id,'cepDois', $cepDois); 
             };
                
       
             /*
             if($bairroUsuario !="" && $bairroUsuario !="undefined"){
                    update_user_meta($user_id,'userBairro', $bairroUsuario);
             };  
             
             
             if($cidadeUsuario !="" && $cidadeUsuario !="undefined"){
                update_user_meta($user_id,'userCidade', $cidadeUsuario);
             };  
             
             
             if($estadoUsuario !="" && $estadoUsuario!="undefined"){
                update_user_meta($user_id,'userEstado', $estadoUsuario);
             };    
              */
             
             
            
               
               
             
                 
                 
                 
             if($dddUsuario !="" && $dddUsuario!="undefined"){
                  update_user_meta($user_id,'userDDD', $dddUsuario);
               };
             if($telefoneUsuario !="" && $telefoneUsuario !="undefined"){
                update_user_meta($user_id,'userTelefone', $telefoneUsuario);
             };
             
            
            
              if($dddUsuario2 !="" && $dddUsuario2!="undefined"){
                   update_user_meta($user_id,'userDDD2', $dddUsuario2);
                };
              if($telefoneUsuario2 !="" && $telefoneUsuario2 !="undefined"){
                 update_user_meta($user_id,'userTelefone2', $telefoneUsuario2);
              };
                                    
               
             
                 if($dddUsuarioCel !="" && $dddUsuarioCel!="undefined"){
                      update_user_meta($user_id,'userDDDCel', $dddUsuarioCel);
                   };
                                     
                 if($telefoneUsuarioCel !="" && $telefoneUsuarioCel !="undefined"){
                    update_user_meta($user_id,'userTelefoneCel', $telefoneUsuarioCel);
                 };
                 
         
                 if($receba !="" && $receba !="undefined"){
                     update_user_meta($user_id,'receba', $receba);
                  };
         
         
                    
         
         
         
         
         
         
         
         
         
         
         
         
         
         
         

     
		
		 //LOGIN----------------------
            $creds = array();
         	$creds['user_login'] = $email; 
         	$creds['user_password'] = $senha1;

         	//echo $_REQUEST['rememberme'];

         	if($_REQUEST['rememberme'] == "forever "){

         	$creds['remember'] = true;

         	}

         	$user = wp_signon( $creds, false );
           //END LOGIN----------------------
           
                  
          
		
		if ( is_wp_error($user) ){
		     echo $msgReg;
		}else{
		    
		              //echo $user->ID;
	        
	              // ENVIO DE EMAIL ----------------------------------------------------------
	              
	              
	                  $user_email =  $user_email;
	        
    				   $header = "<div style='width:100%;padding:5px;background:#15829D;margin-bottom:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/topo-email.png' /></a></div>";

                       $footer = "<div style='width:100%;padding:5px;background:#0A2A35;margin-top:20px'><a href='".get_bloginfo('url')."'><img src='".$plugin_directory."images/footer-email.png'/></a></div>";

                       $idLogin = get_idPaginaLogin();
                       $pageLogin = get_permalink($idLogin);
                       
                       
					   
				  	 $emailRegistroTexto= get_option('emailRegistroTextoWPSHOP'); 
					   
					   
					  $akEmail =  wp_generate_password();
					  
			 		 $arrRemove = array( '!','@','#','$','%','^','&','*','(',')', '-','_','[',']','{','}','<','>','~','`','+','=',',','.',';',':','/','?','|');
			 		  $akEmail = str_replace($arrRemove,'',$akEmail);
					  
					  update_user_meta($user_id,'akEmail', $akEmail);
						 
						 
                       $mensagemEmail = "
                          <h1>Olá $nome,  </h1> 
                          <p>Seja Bem vindo ao <strong> ".get_bloginfo('name')." </strong> ! Obrigado por acessar e se inscrever em nosso site.</p>
						  
						  	   <p> $emailRegistroTexto</p> 
							   
                          <p>Para acessar sua conta  siga <a href='".$pageLogin."?akEmail=$akEmail' >".$pageLogin."?akEmail=$akEmail</a> . </p> 
                          <p><strong>Dados para acesso:</strong></p>
                          <p>usuario : $email <br/>  senha : $senha1<br/>  </p>
						  
					
						   
						    ";
                          
                          
                          $mensagemEmail2 = "
                                <h1>Olá Administrador ,  </h1> 
                                <p>Novo usuário cadastrado no <strong>".get_bloginfo('name')."</strong>.</p>
                                 <p>usuario : $email <br/>  Nome : $nome <br/>  </p>
                                <p>Para administrar faça o login em  <a href='".$pageLogin."' >".$pageLogin."</a> . </p> 
                                ";
                                
                      
                        $assuntoEmail = "Registro de Usuário : Bem Vindo ao ".get_bloginfo('name')."";
                        $assuntoEmail2 = "Registro de Usuário : Nova conta criada no ".get_bloginfo('name')."";
 
                        if(intval($user->ID)>0){
                
                                  $idPaginaPerfil = get_idPaginaPerfil();
                                  if($checkout =="TRUE"){
                                   $idPaginaPerfil = get_idPaginaCheckout();    
                                  }
                                  
                                  $urlRedirect = get_permalink($idPaginaPerfil);
                                  echo $user->ID."****".$urlRedirect;
                                  
                                  
                                  include_once('email.php');
                        };
                        
                        
                // FINAL ENVIO DE EMAIL ----------------------------------------------------------
                        
                        
	
		}


 
        if($receba !=""){
           //UPDATE NEWSLETTER FORM --------------
           if (function_exists('registerNewsletterMail')) {
                registerNewsletterMail($nome,$user_email, "1***",'nao');   
           };
       }
      
 	
	
	

	}else{
	    
	        echo $msgReg;
	        
	}
	
	
	
	?>