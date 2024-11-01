<?php

              require("../../../../../wp-load.php");
			  
			  session_start();
 			 	
              	$idE = addslashes($_REQUEST['idE']);
                $valorFrete = addslashes($_REQUEST['radioFrete']);
				$nomeFrete = addslashes($_REQUEST['radioFreteNome']);
 
 			 
                  $msgError ='';

                   global $current_user;
                   
                   if(intval($current_user->ID)<=0){
                         $msgError =  "Permissão Administrativa negada";
                         echo $msgError;
                   }else{   
	    			   		 $_SESSION['vFrete'] = $valorFrete;
	                  		 $_SESSION['nomeFrete'] = $nomeFrete;
	   						 $_SESSION['enderecoEscolhido'] = $idE;
				
                               //update_user_meta($current_user->ID,'idEntrega', $idE);    
                               
                               $url = get_permalink(get_IdPaginaCheckout());
                      
                                echo "Atualizado com sucesso!****$url";
                   };




              	?>