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

 			     $arrTamanhosQTDVendido  = array();
		 
                 foreach ( $results   as $item=>$result   ){
                    $variacaoProduto = $result->variacao;
 				    $qtdProduto =intval( $result->qtdProd );
				    
 	 			   $qtdF =  $qtdProduto+intval($arrTamanhosQTDVendido[$variacaoProduto]);
				   
 	 		      $arrTamanhosQTDVendido[$variacaoProduto] = $qtdF;
				  
				  
 				};
 			 ?>
			 
			 
			 <tr>
			 
 			       <td> 
				
 				      <a href="<?php the_permalink() ?>"> <?php the_title(); ?>  <?php 
				
 				 $initstock = get_post_meta($idP,'initstock',true);	
 					$controleEstoque = get_post_meta($idP,'is_check_outofstock',true); if($controleEstoque==1){ echo "<small class='green'>(ilimitado)</small>"; }else{ echo "<mall class='red'>(Controle Ativo : $initstock )</small>";  }; ?> </a>
					
 		           </td>
		    
  
			 
				 
   		      <td>
   				   <Table> 
   				    <tr> 
						<?php
						$tdTamanho = '';
						foreach ( $resultsTamanho   as $item=>$resultT   ){
                             
			              $idPedidoT = $resultT->id_pedido;
						  $tipoVariacaoT = $resultT->tipoVariacao;
						  $variacaoProdutoT = $resultT->variacaoProduto;
						  $qtdProdutoT = $resultT->qtdProduto;
			  
						  //echo" $tipoVariacao $variacaoProduto $qtdProduto<br/><br/>";
		                 $tdTamanho .= "<th>$variacaoProdutoT</th>";
						 };
						
						?>
   						 <?php echo $tdTamanho; ?>
   					</tr>
					
			        <tr> 
				<?php  foreach ( $resultsTamanho   as $item=>$resultT   ){
					       $idItem =  $resultT->id;
						   $tipoVariacao = $resultT->tipoVariacao;
						   
					       $variacaoProdutoT = $resultT->variacaoProduto;
						   $qtdProdutoT = $resultT->qtdProduto;
					  ?>
					 
					    <td> 
							
					
							<span class='alterarEstoque' id='<?php echo $idItem; ?>'  rel='<?php echo $tipoVariacao; ?>' rev='<?php echo $tipoVariacao; ?>'  ><?php echo $qtdProdutoT; ?></span>
							
							
							</td>
			   	 <?php }; ?>	 
				   </tr>
				 
   				   </table>
   			   </td>
			   
			   
			   
			   <?php //QTD VENDIDO ESTOQUE ------------------------------ ?>
			   
   		      <td>
   				   <Table> 
   				    <tr> 
						<?php
						$tdTamanho = '';
						foreach ( $resultsTamanho   as $item=>$resultT   ){
                             
			              $idPedidoT = $resultT->id_pedido;
						  $tipoVariacaoT = $resultT->tipoVariacao;
						  $variacaoProdutoT = $resultT->variacaoProduto;
						  $qtdProdutoT = $resultT->qtdProduto;
			  
						  //echo" $tipoVariacao $variacaoProduto $qtdProduto<br/><br/>";
		                 $tdTamanho .= "<th>$variacaoProdutoT</th>";
						 };
						
						?>
   						 <?php echo $tdTamanho;   ?> 
   					</tr>
					
				  
				 
				  
   			         <tr> 
   				<?php  foreach ( $resultsTamanho   as $item=>$resultT   ){ ?>
   					<?php
   					 $variacaoProdutoT = $resultT->variacaoProduto;
					 
   					// $variacaoTrim = str_replace(' ','',$variacaoProdutoT);
					 $variacaoTrim = $variacaoProdutoT;
					 
   				     $qtdEstoqueTamanhoVendido = intval($arrTamanhosQTDVendido[$variacaoTrim]);
					 
					 
   				  //VERIFICANDO DOS VENDIDOS QUANTOS PENDENTES --------	
			
   	  		    $tabelaOrder = $wpdb->prefix."";
   	  		    $tabelaOrder .=  "wpstore_orders";
			
   	  		  $resultsCount  =    $wpdb->get_var( $wpdb->prepare( 'SELECT count(*) FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto="'.$idP.'"" AND  pro.variacao="'.$variacaoProdutoT.'"   AND ( ord.status_pagto = "PENDENTE" OR   ord.status_pagto = "VERIFICANDO" ) ' ,1,''));	
   	  		 if($resultsCount>0){
   	  		 	$resultsCount = " ($resultsCount) ";
   	  		 }else{
   	  		 	$resultsCount = "";
   	  		 }
   		        //VERIFICANDO DOS VENDIDOS QUANTOS PENDENTES --------	
				
				
   					?>
   					    <td>
							<?php echo $qtdEstoqueTamanhoVendido; ?> 
							<?php echo $resultsCount; ?> 
						</td>
   			   	 <?php }; ?>	 
   				   </tr>
				   
				   
				 
   				   </table>
   			   </td>
			   
			   
			   
			   <?php //SALDO DE ESTOQUE ------------------------------ ?>
   		      <td>
   				   <Table> 
   				    <tr> 
						<?php
						$tdTamanho = '';
						foreach ( $resultsTamanho   as $item=>$resultT   ){
                             
			              $idPedidoT = $resultT->id_pedido;
						  $tipoVariacaoT = $resultT->tipoVariacao;
						  $variacaoProdutoT = $resultT->variacaoProduto;
						  $qtdProdutoT = $resultT->qtdProduto;
			  
						  //echo" $tipoVariacao $variacaoProduto $qtdProduto<br/><br/>";
		                 $tdTamanho .= "<th>$variacaoProdutoT</th>";
						 };
						
						?>
   						 <?php echo $tdTamanho; ?>
   					</tr>
					
				   
				   
   			        
					
					
				    <tr> 
						<?php  foreach ( $resultsTamanho   as $item=>$resultT   ){ 
								 
								 $variacaoProdutoT = $resultT->variacaoProduto;
							     //$variacaoTrim = str_replace(' ','',$variacaoProdutoT);
						         $variacaoTrim = $variacaoProdutoT;
						 
								 $qtdProdutoT = intval($resultT->qtdProduto) - $arrTamanhosQTDVendido[$variacaoTrim];
										 
										 ?>
							    <td><?php   echo $qtdProdutoT; ?></td>
					   	 <?php }; ?>
					</tr>
					
					
					
				   
				   
				 
   				   </table>
   			   </td>
			   
			   
			  
			   </tr>