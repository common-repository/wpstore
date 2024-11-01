<?php


if ( current_user_can( 'manage_options' ) ) {
    /* A user with admin privileges */
} else {
    $urlR = verifyURL(get_bloginfo('url')).'/wp-admin';
	echo '<script>window.location = "'.$urlR.'";</script>';
}

 
 
     if( $_POST['submit']=="Salvar"  ){
		 
	                                      
     };

  
	    
	  	  
?>    


<form action="<?php echo verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=general";?>"  method="post" >




<div id="cabecalho">
	<ul class="abas">
		<li>
			<div class="aba gradient">
				<span>Ferramentas</span>
			</div>
		</li>  
		
		 <?php /* 
		<li>
			<div class="aba gradient">
				<span>Homepage</span>
			</div>
		</li>
		<li>
			<div class="aba gradient">
				<span>Slide Home</span>
			</div>
		</li>
		<li>
			<div class="aba gradient">
				<span>Sidebar</span>
			</div>
		</li>                   
		
					*/ ?>      
					
		<div class="clear"></div>
	</ul>
</div><!-- #cabecalho -->       





<div id="containerAbas">  



	<div class="conteudo">
	
	
	
	
		<div class="bloco">      
			
			<h3>1. Exportar Usuários </h3>
			
			<span class="seta" rel='exportUsers'></span>
			<div class="texto" id='exportUsers'>
				             
			  
				<p>Exportar Usuários : <a href='<?php bloginfo('url'); ?>/wp-content/plugins/wpstore/includes/functions/export-excel-users.php?page=1' target="_blank">Clique aqui</a> </p>
				
								<p><small>Exporta   planilha com os dados de usuários cadastrados </small></p>   
			
			</div>
		</div><!-- .bloco -->
		
		
		
		
		
		
		<div class="bloco">      
			
		  	<h3>2. Exportar Lista de pedidos X usuários</h3>
			
			  <span class="seta" rel='exportorders'></span>
			  <div class="texto" id='exportorders'>
				             
			  
				<p>Exportar Lista Pedidos X Usuários : <a href='<?php bloginfo('url'); ?>/wp-content/plugins/wpstore/includes/functions/export-excel-users-pedidos.php?page=1' target="_blank">Clique aqui</a> </p>   
				
				<p><small>Exporta a planilha  com numero de pedidos e infos do usuário.</small></p>
				
			</div>
		</div><!-- .bloco -->
		
		
		
		 
		 
		
 		<div class="bloco">      
			
 			<h3>3. Exportar Lista Pedidos X Produtos </h3>
			
 			<span class="seta" rel='exportordersProds'></span>
 			<div class="texto" id='exportordersProds'>
				             
			  
 				<p>Lista Pedidos X Produtos : <a href='<?php bloginfo('url'); ?>/wp-content/plugins/wpstore/includes/functions/export-excel-pedidos-produtos.php?page=1' target="_blank">Clique aqui</a> </p>   
				
 				<p><small>Exporta uma planilha de produtos vendidos em pedidos. </small></p>
				
 			</div>
 		</div><!-- .bloco -->
		
		
		        
						
						
						
				 		<div class="bloco">      
			
				 			<h3>4. Exportar Lista Produtos Vendidos </h3>
			
				 			<span class="seta" rel='exportordersProdsV'></span>
				 			<div class="texto" id='exportordersProdsV'>
				             
			  
				 				<p>Exportar Lista de produtos Vendidos : <a href='<?php bloginfo('url'); ?>/wp-content/plugins/wpstore/includes/functions/export-excel-produtos-vendidos.php?page=1' target="_blank">Clique aqui</a> </p>   
				
				 				<p><small>Exporta a planilha consolidada de produtos vendidos.</small></p>
				
	 
				 			</div>
				 		</div><!-- .bloco -->
						
						
			 
			 
			 
			 
			 
		
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

 



 
</form>





 <script>

 jQuery('.seta').click(function(){
     rel = jQuery(this).attr('rel');
     jQuery('.texto').hide();
     jQuery('#'+rel).show();
 });    
 
 
 

 </script>
