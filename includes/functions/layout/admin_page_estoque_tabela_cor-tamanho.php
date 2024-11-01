		    <?php
		    	
		    $tabela = $wpdb->prefix."";
		    $tabela .= "wpstore_stock"; 
		    $tabelaOrder = $wpdb->prefix."";
		    $tabelaOrder .=  "wpstore_orders";
		   
			$results  = $wpdb->get_results( "SELECT id,variacaoProduto,qtdProduto FROM  `$tabela` WHERE  `idPost`='$idP' AND    `tipoVariacao`='tamanhoCor' ORDER BY `id`  ASC  "  );
			 
			 
					 	 			 
			 
             $arrCorTamanhosQTD = array();
			 $arrCorTamanhosQTDId = array();
			 
		    foreach ( $results   as $item=>$result   ){
              $idItem = $result->id;
              //$idPedido = $result->id_pedido;
			 // $tipoVariacao = $result->tipoVariacao;
			  $variacaoProduto = $result->variacaoProduto;
			  $qtdProduto = intval($result->qtdProduto);
			  // echo" $tipoVariacao $variacaoProduto $qtdProduto<br/><br/>";
			  $qtdF =  $qtdProduto+intval($arrCorTamanhosQTD[$variacaoProduto]);
		      $arrCorTamanhosQTD[$variacaoProduto] = $qtdF;
			  $arrCorTamanhosQTDId[$variacaoProduto] = $idItem;
			};
			
			

			
			 
			 
		    $tabela = $wpdb->prefix."";
		    $tabela .= "wpstore_orders_products"; 
           
			/*
			    $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_produto`='$idP'   ORDER BY `id`  ASC  "  ,1,'') );
				*/
				
				$results  =    $wpdb->get_results( 'SELECT  variacao,qtdProd   FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto='.$idP.' AND ord.status_pagto != "CANCELADO" ' );			
			

			    // Adicionando PRODUTOS 

			    $arrCorTamanhosQTDVendido  = array();
		 
                foreach ( $results   as $item=>$result   ){
                   $variacaoProduto = $result->variacao;
				   $qtdProduto = $result->qtdProd ;
				    
	 			  $qtdProduto = intval($result->qtdProd);
	 			 
	 			   $qtdF =  $qtdProduto+intval($arrCorTamanhosQTDVendido[$variacaoProduto]);
				   
	 		      $arrCorTamanhosQTDVendido[$variacaoProduto] = $qtdF;
				  
				  
				};
				
				
			
			?>
			
			 <tr>
			 
			       <td> 
				
				      <a href="<?php the_permalink() ?>"> <?php the_title(); ?>  <?php 
				
				 $initstock = get_post_meta($idP,'initstock',true);	
					$controleEstoque = get_post_meta($idP,'is_check_outofstock',true); if($controleEstoque==1){ echo "<small class='green'>(ilimitado)</small>"; }else{ echo "<mall class='red'>(Controle Ativo : $initstock )</small>";  }; ?> </a>
					
		           </td>
		    
		    </tr>
			
                  
				  <?php  
				  
				  //FOREACH COR----------------
				  
				  foreach ( $resultsCor  as $item=>$resultC   ){  
					  
		              $idPedidoC = $resultC->id_pedido;
					  $tipoVariacaoC = $resultC->tipoVariacao;
					  $variacaoProdutoC = $resultC->variacaoProduto;
					  $qtdProdutoC = $resultC->qtdProduto;
					  $arrayCoresImgC =  $resultC->imgAlternativa;
					  
					  ?>


			 <tr>
				 
				 <td style='background:<?php echo $arrayCoresImgC; ?>'> <?php echo $variacaoProdutoC; ?></td>
		  
				 
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
							  
			   			      $tipoVariacaoCT = $resultT->tipoVariacao;
			   			 
						 
						  ?>
						<?php
						$variacaoTrim = str_replace(' ','',$variacaoProdutoT.'-'.$variacaoProdutoC);
					$qtdEstoqueCorTamanho = intval($arrCorTamanhosQTD[$variacaoTrim]);
					$idItemCT = intval($arrCorTamanhosQTDId[$variacaoTrim]);
					
					 
						?>
						    <td> 
								
						<span class='alterarEstoque' id='<?php echo $idItemCT; ?>'  rel='tamanhoCor' rev='tamanhoCor'  ><?php echo  $qtdEstoqueCorTamanho; ?></span>
									
									</td>
				   	 <?php }; ?>	 
					</tr>
				 
   				   </table>
   			   </td>
			   
			   
			   
			   <?php //QTD VENDIDO ESTOQUE ------------------------------ ?>
			   
   		      <td>
   				   <Table> 
   				    <tr> 
   						 <?php echo $tdTamanho; ?>
   					</tr>
					
				   
				   
				   
			    <tr> 
				<?php  foreach ( $resultsTamanho   as $item=>$resultT   ){ ?>
					<?php
					 $variacaoProdutoT = $resultT->variacaoProduto;
					 
					 $variacaoTrim = str_replace(' ','',$variacaoProdutoT.'-'.$variacaoProdutoC);
					 
				$qtdEstoqueCorTamanhoVendido = intval($arrCorTamanhosQTDVendido[$variacaoTrim]);
				
				
				
  			  //VERIFICANDO DOS VENDIDOS QUANTOS PENDENTES --------	
	
		    $tabelaV = $wpdb->prefix."";
		    $tabelaV .= "wpstore_orders_products"; 

		    $tabelaOrderV = $wpdb->prefix."";
		    $tabelaOrderV .=  "wpstore_orders";
	
			 $sql = 'SELECT count(*) FROM `'.$tabelaV.'` pro INNER JOIN `'.$tabelaOrderV.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto="'.$idP.'" AND  pro.variacao="'.$variacaoTrim.'"   AND ( ord.status_pagto = "PENDENTE" OR   ord.status_pagto = "VERIFICANDO" ) ';
			
			 //echo $sql;
			
    		  $resultsCount  =    $wpdb->get_var( $wpdb->prepare( $sql ,1,''));	
    		 if($resultsCount>0){
    		 	$resultsCount = " ($resultsCount) ";
    		 }else{
    		 	$resultsCount = "";
    		 }
  	        //VERIFICANDO DOS VENDIDOS QUANTOS PENDENTES --------	
		
		
		
		
					?>
					
					    <td><?php echo $qtdEstoqueCorTamanhoVendido;  
							echo $resultsCount;    ?></td>
						
							
			   	 <?php }; ?>
				 	 
				</tr>
				
				
				 
   				   </table>
   			   </td>
			   
			   
			   
			   <?php //SALDO DE ESTOQUE ------------------------------ ?>
			   
			   
   		      <td>
   				   <Table> 
   				    <tr> 
   						 <?php echo $tdTamanho; ?>
   					</tr>
					
				    <tr> 
						<?php  foreach ( $resultsTamanho   as $item=>$resultT   ){ 
								 $variacaoProdutoT = $resultT->variacaoProduto;
					 
							 $variacaoTrim = str_replace(' ','',$variacaoProdutoT.'-'.$variacaoProdutoC);
							 
							$arrCorTamanhosQTDSaldo = $arrCorTamanhosQTD[$variacaoTrim] -  $arrCorTamanhosQTDVendido[$variacaoTrim];
										 
										 ?>
							    <td><?php  echo $arrCorTamanhosQTDSaldo; ?></td>
					   	 <?php }; ?>
					</tr>
				 
   				   </table>
   			   </td>
			   
			   
			  
			   </tr>
			   
			   <?php }; //end FOREACH COR --------------   ?>