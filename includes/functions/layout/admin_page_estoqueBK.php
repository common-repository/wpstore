<?php

 
?>    

 


<div id="cabecalho">
	<ul class="abas">
		<li>
			<div class="aba gradient">
				<span>Estoque</span>
			</div>
		</li>  
		
	 
		<div class="clear"></div>
	</ul>
</div><!-- #cabecalho -->       





<div id="containerAbas">  



	<div class="conteudo">
		
		
		<h2>Selecine a categoria de produtos</h2>
		
		<select id='catEstoque'>
			
			<option value=''>--</option>
		<?php 
		
 
		
		
		$categories= get_categories();
		$idCurrentCat = intval($_GET['currentCat']);
		
	
		
		if ($categories) {
		$cat_count =count($categories);
		$output = '';
		
			print_r($categories);
			
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
		
		
		<script>
		
		
		
		jQuery( "#catEstoque" ).on('change', function() { 
		   idCat = jQuery( this ).val();
		   window.location = '?page=lista_estoque&currentCat='+idCat;
		});
		
		
		
		</script>									  
												  
												  
												  
	
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
		        'showposts' =>  "200" ,
				'post_status' =>  "publish" ,
				'paged'=> "$pagina",
				'cat'=> "$idCurrentCat"
		    ) );  
		?>
		
		
		
		
		
		
		<table border="1">
		<tr>
		<th>Titulo</th>
		<th>Tamanhos</th>
		<th>Cores</th>
		<th>Combinações - QTD</th>
		<th> QTD VENDIDA</th>
		</tr>
	
	 
	
		<?php while (have_posts()) : the_post(); 	$idP = get_the_id();  ?>
			
			
		        
				<tr>
				<td> <a href="<?php the_permalink() ?>"> <?php the_title(); ?>  <?php 
					
					 $initstock = get_post_meta($idP,'initstock',true);	
						$controleEstoque = get_post_meta($idP,'is_check_outofstock',true); if($controleEstoque==1){ echo "<small class='green'>(ilimitado)</small>"; }else{ echo "<mall class='red'>(Controle Ativo : $initstock )</small>";  }; ?> </a></td>
				<td> 
				  <?php
				
					 global $wpdb; 
	        
				    $tabela = $wpdb->prefix."";
				    $tabela .= "wpstore_stock"; 
    
				    $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `idPost`='$idP' AND  `tipoVariacao`='tamanho' ORDER BY `id`  ASC  "  ,1,'') );
 
				    // Adicionando PRODUTOS 
    
				    $countPrd = 0;
                    
				    foreach ( $results   as $item=>$result   ){
        
		              $idPedido = $result->id_pedido;
					  $tipoVariacao = $result->tipoVariacao;
					  $variacaoProduto = $result->variacaoProduto;
					  $qtdProduto = $result->qtdProduto;
					  
					  echo" $tipoVariacao $variacaoProduto $qtdProduto<br/><br/>";
				
					};
				
					?>
				 </td>
				 
				 
 				<td> 
 				  <?php
 				 
 				    $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `idPost`='$idP' AND  `tipoVariacao`='cor' ORDER BY `id`  ASC  "  ,1,'') );
 
 				    // Adicionando PRODUTOS 
    
 				    $countPrd = 0;
 
 				    foreach ( $results   as $item=>$result   ){
        
 		              $idPedido = $result->id_pedido;
 					  $tipoVariacao = $result->tipoVariacao;
 					  $variacaoProduto = $result->variacaoProduto;
 					  $qtdProduto = $result->qtdProduto;
					  
 					  echo" $tipoVariacao $variacaoProduto $qtdProduto<br/><br/>";
				
 					};
				
 					?>
 				 </td>
				 
				 
				 
				 
 				<td> 
 				  <?php
 				 
    
 				    $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `idPost`='$idP' AND    `tipoVariacao`='tamanhoCor' ORDER BY `id`  ASC  "  ,1,'') );
 
 				    // Adicionando PRODUTOS 
    
 				    $countPrd = 0;
 
 				    foreach ( $results   as $item=>$result   ){
        
 		              $idPedido = $result->id_pedido;
 					  $tipoVariacao = $result->tipoVariacao;
 					  $variacaoProduto = $result->variacaoProduto;
 					  $qtdProduto = $result->qtdProduto;
					  
 					  echo" $tipoVariacao $variacaoProduto $qtdProduto<br/><br/>";
				
 					};
				
 					?>
 				 </td>
				 
				 
				 
				 
				 
				 
				 
  				<td> 
  				  <?php
 				 
				 
        
			    $tabela = $wpdb->prefix."";
			    $tabela .= "wpstore_orders_products"; 
  
    
  				    $results  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_produto`='$idP'   ORDER BY `id`  ASC  "  ,1,'') );
 
  				    // Adicionando PRODUTOS 
    
  				    $countPrd = 0;
                    $arrCombQtd = array();
  				    foreach ( $results   as $item=>$result   ){
        
  		               $variacaoProduto = $result->variacao;
  					   $qtdProduto = $result->qtdProd ;
					  
					   if($variacaoProduto != ""){
					       $arrCombQtd["".$variacaoProduto] += intval($qtdProduto);
				       }else{
				         	$arrCombQtd[] += intval($qtdProduto);
				       }
  					   //echo"   $variacaoProduto $qtdProduto<br/>";
				
  					};
				 
				    ksort($arrCombQtd);
				    if(!empty($arrCombQtd)){
			    	foreach($arrCombQtd as $keyV=>$valueV){
						if($keyV=="-"){$keyV = "*"; };
					echo" $keyV : $valueV <br/><br/>";
				    };
				    };
				
				
				
  					?>
  				 </td>
				 
				 
				 
		 
				</tr>
				
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
	
	
	<?php /*
	<div class="conteudo">
		Conteúdo da aba 2
	</div>
	
	
	<div class="conteudo">
		Conteúdo da aba 3
	</div>    
	
	
	<div class="conteudo">
		Conteúdo da aba 4
	</div>     
	*/ ?>
	
	
   
	
</div><!-- .content -->

 



 
 





 <script>

 jQuery('.seta').click(function(){
     rel = jQuery(this).attr('rel');
     jQuery('.texto').hide();
     jQuery('#'+rel).show();
 });    
 
 
 

 </script>
