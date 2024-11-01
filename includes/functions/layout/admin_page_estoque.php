<?php
global $wpdb;
 
?>    

 


<div id="cabecalho">
	<ul class="abas">
		<li>
			<div class="aba gradient" rel='estoque'>
				<span>Estoque</span>
			</div>
		</li>  
		<li>
			<div class="aba gradient" rel='esgotado'>
				<span>Lista de Produtos Esgotados</span>
			</div>
		</li>  
		
	 
		<div class="clear"></div>
	</ul>
</div><!-- #cabecalho -->       





<div id="containerAbas">  



	<div class="conteudo" id='estoque'>
		
		
		<h2>Selecine a categoria de produtos</h2>
		
		<select id='catEstoque'>
			
			<option value=''>--</option>
		<?php 
		
 
		
		
		$categories= get_categories();
		$idCurrentCat = intval($_GET['currentCat']);
		
	
		
		if ($categories) {
		$cat_count =count($categories);
		$output = '';
		
			//print_r($categories);
			
			$selected = '';
			
			foreach($categories as $category) {
		    
				if($idCurrentCat==intval($category->term_id)){
					$selected = 'selected="selected"';
				}else{
					$selected = '';
				}
		     echo "<option value='$category->term_id' $selected >$category->name</a></option>";
		 
			};
		};
		
		?>
		</select>	
		
 							  
												  
	
		<?php
		$pagina = 1;
		$paginacao = intval($_REQUEST['pagina']);
		if($paginacao>$pagina){
			$pagina = $paginacao;
		}
		

		if($idCurrentCat >0){
			
			
		?>
 						
		<?php 
		    query_posts(array( 
		        'post_type' =>  "produtos " ,
		        'showposts' =>  "50" ,
				'post_status' =>  "publish" ,
				'paged'=> "$pagina",
				'cat'=> "$idCurrentCat"
		    ) );  
		?>
		
		
		
		<table>
			<tr>
			<th>Produto</th>
			<th>Entrada de Estoque</th>
			<th>Vendas / Saídas </th>
			<th>Saldo</th>
			</tr>
			
			
		    <?php while (have_posts()) : the_post(); 	$idP = get_the_id();   
				
				
				 //FOREACH PRODUTOS  ------------------------------  
		  
		 global $wpdb; 
 
	    $tabela = $wpdb->prefix."";
	    $tabela .= "wpstore_stock"; 
		  
		  //GET VARIACAO DE PRODUTO COR -----------------------------------------
 
		 
		    $resultsCor  = $wpdb->get_results( "SELECT * FROM  `$tabela` WHERE  `idPost`='$idP' AND  `tipoVariacao`='cor' ORDER BY `showOrder`  ASC  "  );

		 
		
		 //GET VARIACAO DE PRODUTO TAMANHO ------------------------------------
		 

		    $resultsTamanho  = $wpdb->get_results(   "SELECT * FROM  `$tabela` WHERE  `idPost`='$idP' AND  `tipoVariacao`='tamanho' ORDER BY `showOrder`  ASC  "   );

		     
			 
			      if(!empty($resultsCor) &&  !empty($resultsTamanho) ){  
			            include('admin_page_estoque_tabela_cor-tamanho.php');
			      }elseif(!empty($resultsCor)){  
			            include('admin_page_estoque_tabela_cor.php');	
				  }elseif(!empty($resultsTamanho)){  
			      	    include('admin_page_estoque_tabela_tamanho.php');
				  }else{  
			      	    include('admin_page_estoque_tabela_unica.php');
			      };  
		    
			  ?>
			   
		 
		 
		 <?php endwhile;?>		
					
		    
		</table>
		
		
		
		 
		
		 
	
	
    <?php
 
 	$paginaAnt = $pagina-1;
 	$paginaPost = $pagina+1;
    ?>

    <?php if($pagina>1){ ?>
      <p class='nextPage'> <a href='?page=lista_estoque&pagina=<?php echo $paginaAnt; ?>'>Pagina Anterior</a> </p><br/>
 	 <?php }; ?>

    <p class='nextPage'> <a href='?page=lista_estoque&pagina=<?php echo $paginaPost; ?>&currentCat=<?php echo $idCurrentCat; ?>'>Próxima Pagina</a> </p><br/>

    <div class='clear'></div>
	 
	
	
	<?php }; // end if is $idCurrentCat>0 ?>
	
	
	</div>  
	
	

	<div class="conteudo" id='esgotado' style='display:none'>
		
			<h2>Produtos Esgotados</h2>
				<br/><br/>
			
			
			<?php
				
				
			$args = array(
			    'meta_query' => array(
			        array(
			            'key' => 'is_check_outofstock',
			            'value' => '0'
			        )
			    ),
			    'post_type' => 'produtos',
			    'posts_per_page' => 50
			);
			$posts = get_posts($args);
			
		    foreach($posts as $post){
				
			     $idP = $post->ID;
			 
				 $tipoProduto ='unico';
				 $txtesgotado = '';
				 $saldo = 1;
				
	            //GET VARIACAO DE PRODUTO COR --------------------
                $tabela = $wpdb->prefix."";
                $tabela .= "wpstore_stock"; 
	            $resultsCor  = $wpdb->get_results(  "SELECT * FROM  `$tabela` WHERE  `idPost`='$idP' AND  `tipoVariacao`='cor' ORDER BY `variacaoProduto`  ASC  " );
				
             
	            //GET VARIACAO DE PRODUTO TAMANHO ---- 
				 $resultsTamanho  = $wpdb->get_results(  "SELECT * FROM  `$tabela` WHERE  `idPost`='$idP' AND  `tipoVariacao`='tamanho' ORDER BY `variacaoProduto`  ASC  "   );
				
 
		 
		        if(!empty($resultsCor) &&  !empty($resultsTamanho) ){  
		            $tipoProduto ='corTamanho';
		        }elseif(!empty($resultsCor)){
		            $tipoProduto ='cor';
			    }elseif(!empty($resultsTamanho)){
		       	    $tipoProduto ='tamanho';
			    }else{
		      	    $tipoProduto ='unico';
		        };  
			  
			  
				$txtCorEsgotado = '';
			    $txtTamanhoEsgotado = '';
				$txtCorTamanhoEsgotado = '';
				
				
			    $tabelaOrder = $wpdb->prefix."";
			    $tabelaOrder .=  "wpstore_orders";
				
				
			      //Produto unico 
				  if($tipoProduto =='unico'){ //-----------------------------------------------------------
					  
	                    $tabela = $wpdb->prefix."";
						
						
		                $tabela .= "wpstore_orders_products"; 
						
					  
						/*
                        $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_produto`='$idP'   ORDER BY `id`  ASC  "  ,1,'') );
						*/
						
					
	   				 $results  =    $wpdb->get_results(  'SELECT qtdProd FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto='.$idP.' AND ord.status_pagto != "CANCELADO" ' );
					 
				 
				 
						
                        $initstock = intval(get_post_meta($idP,'initstock',true));	
				        $qtdVendida = 0;
			            foreach ( $results   as $item=>$result   ){
                           $qtdVendida += intval($result->qtdProd) ;
			            };
						$saldo = $initstock- $qtdVendida;
//-----------------------------------------------------------		  
				   }elseif($tipoProduto =='tamanho'){  	   	
		  			     $tabela = $wpdb->prefix."";
		   		         $tabela .= "wpstore_orders_products"; 
						 /*
                         $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_produto`='$idP'   ORDER BY `id`  ASC  "  ,1,'') );
						 */
						 $results  =    $wpdb->get_results( 'SELECT * FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto='.$idP.' AND ord.status_pagto != "CANCELADO" ' );
							 
							 
                         $arrTamanhosQTDVendido  = array();
		                 foreach ( $results   as $item=>$result   ){
		                      $variacaoProduto = $result->variacao;
		   				      $qtdProduto =intval( $result->qtdProd );
				              $qtdF =  $qtdProduto+intval($arrTamanhosQTDVendido[$variacaoProduto]);
				              $arrTamanhosQTDVendido[$variacaoProduto] = $qtdF;
				         };
						 
						 
			  		  //FOREACH TAMANHO 
	                   foreach ( $resultsTamanho  as $item=>$resultT   ){  
		  
			                $idPedidoT = $resultT->id_pedido;
			  			    $tipoVariacaoT = $resultT->tipoVariacao;
			  			    $variacaoProdutoT = $resultT->variacaoProduto;
			  			    $qtdProdutoT = intval($resultT->qtdProduto);
			  			    $qtdVendidoTamanho = intval($arrCorQTDVendido[$variacaoProdutoT]);
							
							$saldoP =  $qtdProdutoT - $qtdVendidoTamanho;
							if($saldoP <=0 ){
								$txtTamanhoEsgotado .= "$variacaoProdutoT ,";
							}
			  		   } ; //END FOREACH TAMANHO 
//-----------------------------------------------------------				 
 }elseif($tipoProduto =='cor'){
				   	
					 $tabela = $wpdb->prefix."";
					  $tabela .= "wpstore_orders_products"; 
					  /*
                      $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_produto`='$idP'   ORDER BY `id`  ASC  "  ,1,'') );
					  */
					  
					 $results  =    $wpdb->get_results(  'SELECT * FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto='.$idP.' AND ord.status_pagto != "CANCELADO" ' );
						
						
                           // Adicionando PRODUTOS 
                           $arrCorQTDVendido  = array();
                           foreach ( $results   as $item=>$result   ){
								$variacaoProduto = $result->variacao;
								$qtdProduto =intval( $result->qtdProd );
								$qtdF =  $qtdProduto+intval($arrCorQTDVendido[$variacaoProduto]);
								$arrCorQTDVendido[$variacaoProduto] = $qtdF;
							};
							
						 
				  		  //FOREACH COR 
		                  foreach ( $resultsCor  as $item=>$resultC   ){  
			  
				                $idPedidoC = $resultC->id_pedido;
				  			    $tipoVariacaoC = $resultC->tipoVariacao;
				  			    $variacaoProdutoC = $resultC->variacaoProduto;
				  			    $qtdProdutoC = intval($resultC->qtdProduto);
				  			    $qtdVendidoCor = intval($arrCorQTDVendido[$variacaoProdutoC]);
								
					 
								$saldoP =  $qtdProdutoC - $qtdVendidoCor;
								if($saldoP <=0 ){
									$txtCorEsgotado  .= "$variacaoProdutoC, ";
								}
								
								
				  		   } ; //END FOREACH CORE  
		 
   //-----------------------------------------------------------					
                                                                                                 }elseif($tipoProduto =='corTamanho'){ 

																							      		$tabela = $wpdb->prefix."";
						$tabela .= "wpstore_orders_products"; 
						
						/*
						$results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_produto`='$idP'   ORDER BY `id`  ASC  "  ,1,'') );
						*/
						
   					 $results  =    $wpdb->get_results(  'SELECT * FROM `'.$tabela.'` pro INNER JOIN `'.$tabelaOrder.'` ord ON pro.id_pedido = ord.id_pedido WHERE pro.id_produto='.$idP.' AND ord.status_pagto != "CANCELADO" ' );
				
				
						$arrCorTamanhosQTDVendido = array();
						// Adicionando PRODUTOS 
							foreach ( $results   as $item=>$result   ){
									$variacaoProduto = $result->variacao;
									$qtdProduto = $result->qtdProd ;
									$qtdProduto = intval($result->qtdProd);
									$qtdF = $qtdProduto+intval($arrCorTamanhosQTDVendido[$variacaoProduto]);
									
								$arrCorTamanhosQTDVendido[$variacaoProduto]= $qtdF;
									
							};
							 

                           $tabela = $wpdb->prefix."";
						   $tabela .= "wpstore_stock"; 
				           $results  = $wpdb->get_results(   "SELECT * FROM  `$tabela` WHERE  `idPost`='$idP' AND    `tipoVariacao`='tamanhoCor' ORDER BY `id`  ASC  "  );
						   $arrCorTamanhosQTD = array();
			               foreach ( $results   as $item=>$result   ){
                                $idPedido = $result->id_pedido;
							    $tipoVariacao = $result->tipoVariacao;
							    $variacaoProduto = $result->variacaoProduto;
								$qtdProduto = intval($result->qtdProduto);
								 
	 							$saldoP =  $qtdProduto -  $arrCorTamanhosQTDVendido[$variacaoProduto];
	 							if($saldoP <=0 ){
	 								$txtCorTamanhoEsgotado  .= "$variacaoProduto, ";
	 							}
						     
							};
							
						
			
			
   					
								
								
				           
                    };		
    //--------------------------------------------------------------- 
 	              ?>
			
		        <?php  if($saldo<=0){ ?>
				<h5><a href='<?php echo get_permalink($idP); ?>'><?php echo get_the_title($idP);?></a></h5><hr/><br/>
				<?php
				}elseif($txtCorEsgotado !=''){?>
					<h5><a href='<?php echo get_permalink($idP); ?>'><?php echo get_the_title($idP);?> </a></h5><p> <strong>variação esgotada:</strong> <?php echo $txtCorEsgotado; ?></p><hr/><br/>
					<?php
				}elseif($txtTamanhoEsgotado !=''){?>
					<h5><a href='<?php echo get_permalink($idP); ?>'><?php echo get_the_title($idP);?> </a></h5><p> <strong>variação esgotada:</strong>  <?php echo $txtTamanhoEsgotado; ?></p><hr/><br/>
					<?php
				}elseif($txtCorTamanhoEsgotado !=''){?>
					<h5><a href='<?php echo get_permalink($idP); ?>'><?php echo get_the_title($idP);?></a></h5> <p> <strong>variação esgotada:</strong>  <?php echo $txtCorTamanhoEsgotado; ?></p><hr/><br/>
					<?php
				};
		     
			
			}; //FOREACH PRODUCT --------------------------------
			
			?>
			 
	</div>
	
		<?php /*
	<div class="conteudo">
		Conteúdo da aba 3
	</div>    
	
	
	<div class="conteudo">
		Conteúdo da aba 4
	</div>     
	*/ ?>
	
	
   
	
</div><!-- .content -->

 



 
 





 <script>
 
 
 
jQuery( "#catEstoque" ).on('change', function() { 
   idCat = jQuery( this ).val();
   window.location = '?page=lista_estoque&currentCat='+idCat;
});


 jQuery('.seta').click(function(){
     rel = jQuery(this).attr('rel');
     jQuery('.texto').hide();
     jQuery('#'+rel).show();
 });    
 
 
 var inputAberto = '0';
 
 
 
jQuery( '.alterarEstoque' ).click(function() {
 
		var prodEditId = jQuery(this).attr('id');
		var prodEditRel = jQuery(this).attr('rel');
		var prodEditRev = jQuery(this).attr('rev');
 
 
		var prodEditText = jQuery(this).text();
	 
		var htmlInsert = "<input type='text' name='"+prodEditId+"' id='"+prodEditId+"' rel='"+prodEditRel+"' rev='"+prodEditRev+"' class='inputEdit' value='"+prodEditText+"' title='"+prodEditText+"'  />";
	
	  jQuery(htmlInsert).insertAfter(this);
	  jQuery(this).remove();
	
	  add_action_edit_input(prodEditId);
 
	
});


 
 
function add_action_edit_input(prodEditId){
	
    jQuery('#'+prodEditId).focusout(function() {
         
		var prodEditId = jQuery(this).attr('id'); 
		var prodEditRel = jQuery(this).attr('rel');
		var prodEditText =  jQuery(this).val();
		var qtdV = jQuery(this).val();
	 
	 htmlInsert = "<span  class='"+prodEditId+"' id='"+prodEditId+"'  rel='"+prodEditId+"' rev='"+prodEditId+"' >"+qtdV+"</span>";
	 
	 
  	    jQuery(htmlInsert).insertAfter(this);
  	    jQuery(this).remove();
		habilitaInput(prodEditId);
		

		var urlBase = "<?php echo  plugins_url('wpstore/includes/ajax/' ,'WP STORE' );?>";
		
      
        url= urlBase+"editAjaxStockQtd.php"; 
		jQuery.post(url, {itemID:prodEditId ,variacao :prodEditRel,qtdProd:qtdV  } , function(data) {
			alert(data);
		});
				
		
    });
   
	
}
 




function habilitaInput(prodEditId){

jQuery( '#'+prodEditId ).click(function() {
 
		var prodEditId = jQuery(this).attr('id');
		var prodEditRel = jQuery(this).attr('rel');
		var prodEditRev = jQuery(this).attr('rev');
		
		 
		var prodEditText = jQuery(this).text();
	 
		var htmlInsert = "<input type=text' name='"+prodEditId+"' id='"+prodEditId+"' rel='"+prodEditRel+"' rev='"+prodEditRev+"' class='inputEdit' value='"+prodEditText+"' title='"+prodEditText+"'  />";
	
	  jQuery(htmlInsert).insertAfter(this);
	  jQuery(this).remove();
	
	  add_action_edit_input(prodEditId);
 
	
});


};


jQuery( '.aba').click(function() {
	rel = jQuery(this).attr('rel');
	jQuery('.conteudo').hide();
	jQuery('#'+rel).fadeIn();
});	
 </script>
