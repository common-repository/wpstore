 	 <tr>
			 
 			       <td> 
				
 				      <a href="<?php the_permalink() ?>"> <?php the_title(); ?>  <?php 
				
 				 $initstock = intval(get_post_meta($idP,'initstock',true));	
				 
 					$controleEstoque = get_post_meta($idP,'is_check_outofstock',true); if($controleEstoque==1){ echo "<small class='green'>(ilimitado)</small>"; }else{ echo "<mall class='red'>(Controle Ativo : $initstock )</small>";  }; ?> </a>
					
 		           </td>
				 
		            <td class='tdEditStock'><span class='alterarEstoque' id='<?php echo $idP; ?>'  rel='unico' rev='unico'  ><?php echo $initstock; ?></span></td>
					
					
					
					<?php
 				 
				 
        
				    $tabela = $wpdb->prefix."";
				    $tabela .= "wpstore_orders_products"; 
   
				    $tabelaOrder = $wpdb->prefix."";
				    $tabelaOrder .=  "wpstore_orders";
					
					/*
		             $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` JOIN `$tabelaOrder`  WHERE   ( `".$tabela.".id_pedido` = `".$tabelaOrder.".id_pedido` AND  `".$tabelaOrder.".status_pagto` != 'CANCELADO' ) AND   `".$tabela.".id_produto`='$idP'   ORDER BY `id`  ASC  "  ,1,'') );
			*/
		    
			        /*
					 $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_produto`='$idP'   ORDER BY `id`  ASC  "  ,1,'') );
				*/
					
				 $results  =    $wpdb->get_results(  'SELECT * FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto='.$idP.' AND ord.status_pagto != "CANCELADO" '  );	
				 
				 
				  $resultsCount  =    $wpdb->get_var( 'SELECT count(*) FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto="'.$idP.'" AND ( ord.status_pagto = "PENDENTE" OR   ord.status_pagto = "VERIFICANDO" ) ' );	
				
				
	    	  		 if($resultsCount>0){
	    	  		 	$resultsCount = " ($resultsCount) ";
	    	  		 }else{
	    	  		 	$resultsCount = "";
	    	  		 }
		
				  
	  				    // Adicionando PRODUTOS 
					 
	  				    $countPrd = 0;
	                    $arrCombQtd = array();
						$qtdProduto = 0;
	  				    foreach ( $results   as $item=>$result   ){
                                 $qtdProduto += intval($result->qtdProd) ;
					     };
				      
					 
						
	  					?>
						
						
						
					<td> <?php echo $qtdProduto; echo $resultsCount; ?> </td>
					<td> <?php echo $initstock - $qtdProduto;  ?>   </td>
 		   
			   
			   
			  
			   </tr>