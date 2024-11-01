<?php
              require("../../../../../wp-load.php");   
              
              $idEdit =  intval(addslashes($_REQUEST['ide'])); 
              
 
          

                   $msgError ='';

                   global $current_user;

                   $user_email =  $current_user->user_email ;    
                   $idUser =     $current_user->ID;

                   if(intval($current_user->ID)<=0){       
                       
                         $msg =  "0***Permissão Administrativa negada";
                         
                         
                   }else{   
                               
                          set_id_addr_cobranca($idEdit,$idUser);  
						  update_user_meta($idUser,'idEntrega',  $idEdit);     
                          $msg =  "1***<span class='green'>Endereço alterado com sucesso.</span>";
                          
                   };


                      echo $msg;

?>