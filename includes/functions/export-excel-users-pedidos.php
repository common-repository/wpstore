<?php

ini_set('memory_limit','256M');

require("../../../../../wp-load.php");

//header("Content-Type: application/vnd.ms-excel");
	
 header("Content-disposition: attachment; filename=planilha-pedidos-usuarios.xls");
		 
echo 'Numero Pedido' . "," . 'Email Cliente' . "," . 'SubTotal'."," . 'Frete'. "\n";
	
	
	$email ="#";
	$nome ="#";
	$sobrenome ="#";
	$sexo ="#";
	$cidade ="#";
	$estado ="#";
	$bairro ="#";
	$nascimento= "#";
	$telefone= "#";
	
	///////GET USUARIOS---------
	
	
	$offset = 0;
	$page = intval(addslashes($_GET['page']));
	if($page >=2){
		$offset = 1000 * ($page - 1);
	}
	$args = array('blog_id' =>1,'number'=>'1000','offset' =>$offset);







  global $wpdb;
  $tabela = $wpdb->prefix."";
  $tabela .=  "wpstore_orders";
  
	  $sql = "SELECT *FROM `$tabela` ORDER BY `ID` DESC ";
	
	
    $fivesdrafts = $wpdb->get_results($sql);
    
	$contagemResultado = count($fivesdrafts);
	
	
     if ($fivesdrafts) {
	
	
	

	
       foreach ( $fivesdrafts as $fivesdraft ){
           
        
           $id = $fivesdraft->id;
           $idPedido = $fivesdraft->id_pedido;
           $idUsuario = $fivesdraft->id_usuario;
       	   $subtotal = $fivesdraft->valor_total;
       	   $frete = $fivesdraft->frete;
           $tipo_pagto = $fivesdraft->tipo_pagto;
           $status_pagto = $fivesdraft->status_pagto;
           $comentario_cliente = $fivesdraft->comentario_cliente ;
           $comentario_admin = $fivesdraft->comentario_admin;
	         $extras = $fivesdraft->extras;


       $user = get_user_by( 'id',  $idUsuario );

			 $email =  $user->user_email; 
			 
		
 			$nome = trim(get_user_meta($idUsuario,'first_name',true)); 
			
 			$sobrenome = trim(get_user_meta($idUsuario,'last_name',true)); 
			
			
			$nome .= " ".$sobrenome ;
 
		//LINHA  PEDIDO-----
		echo $fivesdraft->id_pedido. "," . $nome. "," . $email. "," .$subtotal. ",".$frete ."\n";
		//FINAL LINHA USUARIO -----
			
			
		}
 
 
	};
 

	
?>