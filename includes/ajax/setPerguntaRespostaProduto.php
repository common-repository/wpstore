<?php

              require("../../../../../wp-load.php");

              global $current_user;
              get_currentuserinfo(); 
              $idUser = $current_user->ID; 
             
                $idp = addslashes( trim($_POST['idp']) );
                $resp = intval(addslashes( trim($_POST['resp']) )); 
                $nomeCliente = addslashes( trim($_POST['nomeCliente']) );
                $emailCliente= addslashes( trim($_POST['emailCliente']) );
                $localCliente = addslashes( trim($_POST['localCliente']) );    
                $avaliacao = addslashes( trim($_POST['avaliacao']) );    
               
           
 
      global $wpdb;
      $tabela = $wpdb->prefix."";
      $tabela .=  "wpstore_perguntas_products";

      $totalpedidos = 0;  
      
      $tipo = "Pergunta";
	  
      if($resp>0){//----------------------------------
		 $tipo = "Resposta";  
	  };//----------------------------------
      
      if($avaliacao !=""){                            
      $gmDate = gmdate('y-m-d');   
	  
	  
	  $statusPergunta = 'PENDENTE'; 
	  if ( current_user_can( 'manage_options' ) ||  current_user_can( 'edit_posts' ) ) {
		$statusPergunta = 'APROVADO';   
	  };
	  
	
	  
      $sql = "INSERT INTO `$tabela` ( `id` , `id_produto`, `idr`,`nome_cliente` , `email_cliente` , `localizacao_cliente`, `comentario_cliente`  , `comentario_status`  , `comentario_data` , `comentario_tipo` ) VALUES ( NULL , '$idp','$resp',  '$nomeCliente', '$emailCliente', '$localCliente',  '$avaliacao'  ,  '$statusPergunta'   ,  '$gmDate' , '$tipo'  );";  
	  
      $fivesdrafts = $wpdb->query( $sql );
	
	if($statusPergunta=="APROVADO"){  
	  
   //ENVIA EMAIL ------------------------------------------
   
      $sql = "SELECT *FROM `$tabela`  WHERE `id`='$resp'  ORDER BY `ID` DESC ";
      $perguntas2 = $wpdb->get_results($sql);  

       foreach($perguntas2 as $pergunta2 ){   
	
 		   	$nome = $pergunta2->nome_cliente;
 			$email = $pergunta2->email_cliente;
 			$pergunta = $pergunta2->comentario_cliente;
 			$tipo = $pergunta2->comentario_tipo;
		    $idProduto = $pergunta2->id_produto;
   
            $usuarioNome = $nome;
	        $usuarioEmail = $email;
		
          	$assunto ='Resposta a sua pergunta na loja '.verifyURL(get_bloginfo('url'));
		
	        $conteudo = "Olá $nome , </br> Sua  pergunta  em nosso site foi respondida.<br/><br/> <strong>Duvida sobre o produto </strong>: <a href='".verifyURL(get_permalink($idProduto))."'>".get_the_title($idProduto)."</a> <br/><br/>";
		
             $conteudo .= "<strong>Você perguntou  </strong>: $pergunta <br/><br/>";
             $conteudo .= "<strong>Resposta </strong>: $avaliacao <br/>";
  
              enviaEmailPergunta($usuarioNome,$usuarioEmail,$assunto,$conteudo);
	     };
	};	
   //ENVIA EMAIL -------------------------------------------
   
   
	  
      echo "Comentário Salvo com sucesso!Após analise de nossa equipe ele será exibido para outros usuários.";
	  
      };  
      
?>