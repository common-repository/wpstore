<?php

              require("../../../../../wp-load.php");
 
              	$pic = addslashes($_REQUEST['pic']);
     
              
                  $msgError ='';

                   global $current_user;

                   $user_email =  $current_user->user_email ;

                   if(intval($current_user->ID)<=0){
                         $msgError =  "Permissão Administrativa negada";
                         echo $msgError;
                   }else{   
                         
                        if($pic !="" && $pic !="undefined"){
                               update_user_meta($current_user->ID,'picUser', $pic);
                        };
                      
                        echo "Atualizado com sucesso!";
                   };




              	?>