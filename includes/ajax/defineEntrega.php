<?php

              require("../../../../../wp-load.php");
 
              	$idE = addslashes($_REQUEST['idE']);
 
                         
              
                  $msgError ='';

                   global $current_user;
                   
                   if(intval($current_user->ID)<=0){
                         $msgError =  "Permissão Administrativa negada";
                         echo $msgError;
                   }else{   
                     
                               update_user_meta($current_user->ID,'idEntrega', $idE);    
                               
                               $url = get_permalink(get_IdPaginaCheckout());
                      
                        echo "Atualizado com sucesso!****$url";
                   };




              	?>