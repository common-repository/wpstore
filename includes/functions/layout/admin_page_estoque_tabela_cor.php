 <?php
 	
 $tabela = $wpdb->prefix."";
  $tabela .= "wpstore_orders_products"; 
  $tabelaOrder = $wpdb->prefix."";
  $tabelaOrder .=  "wpstore_orders";


  /*
    $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_produto`='$idP'   ORDER BY `id`  ASC  "  ,1,'') );
*/
	
	
	$results  =    $wpdb->get_results( 'SELECT * FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto='.$idP.' AND ord.status_pagto != "CANCELADO" ' );					 
			 
			 			 
			 
			 

    // Adicionando PRODUTOS 

     $arrCorQTDVendido  = array();

       foreach ( $results   as $item=>$result   ){
          $variacaoProduto = $result->variacao;
	      $qtdProduto =intval( $result->qtdProd );
	      $qtdF =  $qtdProduto+intval($arrCorQTDVendido[$variacaoProduto]);
	      $arrCorQTDVendido[$variacaoProduto] = $qtdF;
	   };
 ?>
 
 
 
			 <tr>
			 
			       <td> 
				
				      <a href="<?php the_permalink() ?>"> <?php the_title(); ?>  <?php 
				
				    $initstock = intval(get_post_meta($idP,'initstock',true));	
					$controleEstoque = get_post_meta($idP,'is_check_outofstock',true); if($controleEstoque==1){ echo "<small class='green'>(ilimitado)</small>"; }else{ echo "<mall class='red'>(Controle Ativo : $initstock )</small>";  }; ?> </a>
					
		           </td>
		    
		    </tr>
			
			
			
			
			
			
		  <?php  
		  
		  //FOREACH COR----------------
		  
		  foreach ( $resultsCor  as $item=>$resultC   ){  
			   $idItem =  $resultC->id; 
              $idPedidoC = $resultC->id_pedido;
			  $tipoVariacaoC = $resultC->tipoVariacao;
			  $variacaoProdutoC = $resultC->variacaoProduto;
			  $qtdProdutoC = intval($resultC->qtdProduto);
			  $arrayCoresImgC =  $resultC->imgAlternativa;
			  
			  
			  $qtdVendidoCor = intval($arrCorQTDVendido[$variacaoProdutoC]);
			  
			  
			  
			  //VERIFICANDO DOS VENDIDOS QUANTOS PENDENTES --------	
		
  		    $tabelaOrder = $wpdb->prefix."";
  		    $tabelaOrder .=  "wpstore_orders";
		
  		  $resultsCount  =    $wpdb->get_var( $wpdb->prepare( 'SELECT count(*) FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto="'.$idP.'" AND  pro.variacao="'.$tipoVariacaoC.'"   AND ( ord.status_pagto = "PENDENTE" OR   ord.status_pagto = "VERIFICANDO" ) ' ,1,''));	
  		 if($resultsCount>0){
  		 	$resultsCount = " ($resultsCount) ";
  		 }else{
  		 	$resultsCount = "";
  		 }
	        //VERIFICANDO DOS VENDIDOS QUANTOS PENDENTES --------	
			
			
			
			  ?>
			  
			  
			  
			 <tr>
				 
				 <td style='background:<?php echo  $arrayCoresImgC; ?>'> <?php echo $variacaoProdutoC; ?></td>
				 
				 
				 <td>
				 
		
				<span class='alterarEstoque' id='<?php echo $idItem; ?>'  rel='<?php echo $tipoVariacaoC; ?>' rev='<?php echo $tipoVariacaoC; ?>'  ><?php echo $qtdProdutoC; ?></span>
				
				 </td>
				 
				 
				 <td><?php echo $qtdVendidoCor; ?> <?php echo $resultsCount; ?></td>
				 <td><?php echo $qtdProdutoC - $qtdVendidoCor; ?></td>
				 
   		   </tr>
			   
		   <?php } ; //END FOREACH CORES ------------------?>