<?php

include("../../../../../wp-load.php");
       
 
	$senha1 = $_REQUEST['pwp'];
	$senha2 = $_REQUEST['pw2p'];	
 

     global $wpdb;
 
    $msgLost = "";
  
    
    if ( $senha1 != $senha2 ){
    	$msgLost .='<strong>ERROR</strong>: As senhas devem ser iguais.<br/>';
    };

 
     
 

        global $current_user;
             
        get_currentuserinfo(); 

        $user_email =  $current_user->user_email ;    
        $idUser =     $current_user->ID;         
        
        $loginN = $current_user->user_login;
     
        if(intval($current_user->ID)<=0){        
            
               $msgLost =  "Permissão Administrativa negada";      
               
         }else{   
                     
        };
         

    if ( $msgLost =="" ){	   
    
     	$new_pass =  $senha1;
        wp_set_password($new_pass, $current_user->ID);
     	update_usermeta($current_user->ID, 'default_password_nag', true); //Set up the Password change nag.

           
                       //LOGIN----------------------
                    $creds = array();
                  	$creds['user_login'] = $loginN; 
                  	$creds['user_password'] = $new_pass;

                  	//echo $_REQUEST['rememberme'];

                  	if($_REQUEST['rememberme'] == "forever "){

                  	$creds['remember'] = true;

                  	}

                  	$user = wp_signon( $creds, false );
                    //END LOGIN----------------------
                    
                    echo "Alterado com sucesso!";  

 
       
 
    }else{

      echo $msgLost;


    };
    
?>