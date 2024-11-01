<?php

              require("../../../../../wp-load.php");

              global $current_user;

              get_currentuserinfo();
              $idUser = $current_user->ID;
			  $user_email =  $current_user->user_email ;
      
              $itemID = intval($_POST['itemID']);
              $qtdProduto  = intval($_POST['qtdProd']);
              $variacao  = $_POST['variacao'];
			  
              $msgError = "";
              $msg = "";
       
             
              
              if(intval($current_user->ID)<=0){
                   $msgError =  "Permissão Administrativa negada";
				   exit( $msgError);
              }
              
              if ( current_user_can('edit_post', $idPost) ) {  }else{
                 $msgError =  "Permissão Administrativa temporariamente indisponível";
				   exit( $msgError);
              };
                
             
              $returnMSG = edit_qtd_stock($itemID,$variacao,$qtdProduto);
                 
              echo $returnMSG;
             
    
	?>