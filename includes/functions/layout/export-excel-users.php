<?php

ini_set('memory_limit','256M');

require("../../../../../wp-load.php");

//header("Content-Type: application/vnd.ms-excel");
	
 header("Content-disposition: attachment; filename=planilha-usuarios.xls");
		 
echo 'Email' . "," . 'Nome' . "," . 'Sobrenome'. "," . 'Sexo'. "," . 'Cidade'. "," . 'Estado'. "," . 'Bairro' . "," . 'Nascimento' .  "," .'Telefone'.  "\n";
	
	
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

	// The Query
	$user_query = new WP_User_Query( $args );

	//print_r($user_query);
	
	// User Loop
	if ( ! empty( $user_query->results ) ) {
		
		foreach ( $user_query->results as $user ) {
			
		  $id = $user->ID;
			$email = $user->user_email;
			
			$nome = trim(get_user_meta($id,'first_name',true)); 
			$sobrenome = trim(get_user_meta($id,'last_name',true)); 
			
			$sexo = trim(get_user_meta($id,'userSexo',true)); 
			$nascimento=  trim(get_user_meta($id,'userNascimento',true));
			//--------
			$cidade =trim(get_user_meta($id,'userCidade',true));
			$estado =trim(get_user_meta($id,'userEstado',true));
			$bairro =trim(get_user_meta($id,'userBairro',true));
			
			
			
	   
	   $cepEntrega = "";
	   $idEndereco = "";
	 
	   $enderecoEntrega  =  trim(get_user_meta($id,'idEntrega',true));   
	   
 		   $address = get_endereco_entrega($enderecoEntrega);
         
				 
 			$cidade =trim($address['cidade']);
 			$estado =trim($address['estado']);
 			$bairro =trim($address['bairro']);
			
				 
				 
			$ddd=trim(get_user_meta($id,'userDDD',true));
			$telefone = "(".$ddd.")".trim(get_user_meta($id,'userTelefone',true));
			
			//LINHA USUARIO -----
			echo $email. "," . $nome. "," . $sobrenome . "," . $sexo . "," . $cidade . "," . $estado. "," . $bairro . "," . $nascimento . "," . $telefone. "\n";
			//FINAL LINHA USUARIO -----
			
			
		}
	} else {
		echo 'No users found.';
	}
	
 

	
?>