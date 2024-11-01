<?php

              require("../../../../../wp-load.php");

              global $current_user;

              get_currentuserinfo(); 
            
               $oid = addslashes( trim($_POST['oid']) );            
               $idp = addslashes( trim($_POST['idp']) );    
               $avaliacao = addslashes( trim($_POST['avaliacao']) );    
               $idUser = $current_user->ID;
           
 
      global $wpdb;
      $tabela = $wpdb->prefix."";
      $tabela .=  "wpstore_orders_products";

      $totalpedidos = 0;
      
      if($avaliacao !=""){ 
          $data = gmdate('y-m-d');
		  
      $fivesdrafts = $wpdb->query( "UPDATE `$tabela` SET  `comentarioCliente` = '$avaliacao' , `comentario_data`='$data'  WHERE  `id_usuario`='$idUser' AND   `id_produto`='$idp' AND   `id_pedido`='$oid' "  );
	  
      echo "Comentário Salvo com sucesso! Após analise de nossa equipe seu comentário ficará disponível para que outros usuarios possam visualizar.";
	  
      };
	  
	  
?>
