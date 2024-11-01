 <?php    $plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));  ?> 
 
	<link rel="stylesheet" type="text/css" href="<?php echo $plugin_directory; ?>css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $plugin_directory; ?>style.css">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:700' rel='stylesheet' type='text/css' />

 

<div class="container">

	<div id="panel">
		
		<div id="lateral">
			<div class="logo">
				<a href="http://wpstore.com.br"><img src="<?php echo $plugin_directory; ?>images/logo.png" width="150" height="49" alt="wp store panel" /></a>
			</div><!-- .logo --> 
			
			<?php
			  $ativo = $_REQUEST['page'];
			  
			  $pedidosAtivo = ""; 
				$wpstorePainel = "";
			  $pagamentosAtivo = ""; 
			  $contatoAtivo = ""; 
			  $freteAtivo = "";
			  $descontoAtivo= "";
			  $designAtivo = "";   
			  $smtpAtivo = "";
			  $wpstoreAtivo = "";
			  $impostosAtivo = "";
			  $traducaoAtivo = "";
			  $perguntas = ""; 
			  $avaliacoes = ""; 
			  $estoque = ""; 
		 
			 $general = ""; 
			 
			  $listatools= ''; 		
				
				
			  if($ativo=="wpstore"){
			     $wpstoreAtivo = 'current';
 	 			}elseif($ativo=="painel"){
 	 			   $wpstorePainel  = 'current';
 			  }elseif($ativo=="lista_pedidos"){
			     $pedidosAtivo = 'current'; 
			  }elseif($ativo=="lista_pedidos"){
     			 $pedidosAtivo = 'current'; 
     		  }elseif($ativo=="lista_contatos"){
       			 $contatosAtivo = 'current'; 
       		  }elseif($ativo=="lista_pagamentos"){
       			 $pagamentosAtivo = 'current'; 
       		  }elseif($ativo=="lista_frete"){
       			 $freteAtivo = 'current'; 
       		  }elseif($ativo=="lista_descontos"){
       			 $descontoAtivo = 'current'; 
       		  }elseif($ativo=="lista_design"){
       			 $designAtivo = 'current'; 
       		  }elseif($ativo=="lista_smtp"){
       			 $smtpAtivo = 'current'; 
       		  }elseif($ativo=="lista_impostos"){
       			 $impostosAtivo = 'current'; 
       		  }elseif($ativo=="lista_translate"){
            	 $traducaoAtivo = 'current'; 
              }elseif($ativo=="lista_perguntas"){
                 	$perguntas = 'current'; 
              }elseif($ativo=="lista_avaliacoes"){
                         	$avaliacoes = 'current'; 
               }elseif($ativo=="lista_estoque"){
                         	$estoque = 'current'; 
		    }elseif($ativo=="general"){
		                     $general = 'current'; 
		    }elseif($ativo=="lista-tools"){		                                        $listatools= 'current'; 		      
				 }  
			?>
			
			<ul class='menu'>
				
       
				
				
				<li><a href='admin.php?page=wpstore' class="<?php echo $wpstoreAtivo; ?>">WP STORE</a></li>
				
				
           
				
				<li><a href='admin.php?page=painel' class="<?php echo $wpstorePainel; ?>">Painel</a></li>
				
				
			
				
                <?php
			 
				if ( current_user_can( 'manage_options' ) ) {
				    /* A user with admin privileges */
			    ?>
				
				<li><a href='admin.php?page=general' class="<?php echo $general; ?>">Opções Gerais</a></li>
				
                <?php
				
		     	};
				 
			    ?>
				
				<li><a href='post-new.php?post_type=produtos'>Adicionar Produto</a></li>
				
				<li><a href='edit.php?post_type=produtos'>Listar Produtos</a></li>
				
			
				
				<li><a href='admin.php?page=lista_estoque' class="<?php echo $estoque; ?>">ESTOQUE</a></li>
				
				
			 
				<li><a href='admin.php?page=lista_pedidos' class="<?php echo $pedidosAtivo; ?>">PEDIDOS</a></li>
				
			
				<li><a href='users.php'>Usuários</a></li>
				
				
				
                <?php if ( current_user_can( 'manage_options' ) ) {   ?>
				
				<li><a href='admin.php?page=lista_pagamentos' class="<?php echo $pagamentosAtivo; ?>">Configurações de Pagamento</a></li>
				
				
                <?php
				
		     	};
				 
				if ( current_user_can( 'manage_options' ) ) {
				    /* A user with admin privileges */
				  ?>
					
				<li><a href='admin.php?page=lista_frete' class="<?php echo $freteAtivo; ?>">Configurações de Frete</a></li>
				
                <?php
				
		     	};
				 
				if ( current_user_can( 'manage_options' ) ) {
				    /* A user with admin privileges */
				  ?>
					
				
				<li><a href='admin.php?page=lista_descontos' class="<?php echo $descontoAtivo; ?>">Cupom de Descontos</a></li>
				
                <?php
				
		     	};
				 
				if ( current_user_can( 'manage_options' ) ) {
				    /* A user with admin privileges */
				  ?>
					
					
				
				<li><a href='admin.php?page=lista_design' class="<?php echo $designAtivo; ?>">Opções de Design</a></li>
				
                <?php
				
		     	};
				 
				if ( current_user_can( 'manage_options' ) ) {
				    /* A user with admin privileges */
			    ?>
				
				<li><a href='admin.php?page=lista_smtp' class="<?php echo $smtpAtivo; ?>">Opções de SMTP</a></li>
				
				
                <?php
				
		     	};
				 
				if ( current_user_can( 'manage_options' ) ) {
				    /* A user with admin privileges */
				 ?>
				
				<li><a href='admin.php?page=lista_impostos' class="<?php echo $impostosAtivo; ?>">Opções de Impostos</a></li>
				<?php }; ?>
				
				<li><a href='admin.php?page=lista_translate' class="<?php echo $traducaoAtivo; ?>">Opções de texto e tradução</a></li>   
				
				<li><a href='admin.php?page=lista_perguntas' class="<?php echo $perguntas; ?>">Perguntas</a></li> 
				
				<li><a href='admin.php?page=lista_avaliacoes' class="<?php echo $avaliacoes; ?>">Avaliações</a></li>
				
				<li><a href='admin.php?page=lista_contatos' class="<?php echo $contatosAtivo; ?>">Contatos</a></li>
              
							
					
					<li><a href='admin.php?page=lista-tools' class="<?php echo $listatools; ?>">Ferramentas</a></li>
					
					
							
							
							
							  
			</ul>
			
		</div><!-- #lateral -->
		
		<div id="opcoes">   
		
		
			<div class="TabControl">
			                       
			
		   
				
				
