<?php

              require("../../../../../wp-load.php");
  
		  
		   $extrasInput = $_REQUEST['extrasInput'] ;     
 
              
                  $msgError ='';

                   global $current_user;

                   $user_email =  $current_user->user_email ;
                   $idUser = $current_user->ID;
				   
                   if(intval($current_user->ID)<=0){
                         $msgError =  "Permissão Administrativa negada";
                         echo $msgError;
                   }else{   
                         
				   
	 foreach( $extrasInput as $key=>$value){
          update_user_meta( $idUser, "".$key, $value);
	 
 	 }
		            
                
		 echo "Atualizado com sucesso!";
    };




              	?>