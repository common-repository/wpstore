<?php
          


if ( current_user_can( 'manage_options' ) ) {
    /* A user with admin privileges */
} else {
    $urlR = verifyURL(get_bloginfo('url')).'/wp-admin';
	echo '<script>window.location = "'.$urlR.'";</script>';
}

 $plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));



$idPaginaCarrinho = 0;
$idPaginaCheckout = 0;


//verifica e salva opções de pagamento caso necessário ------------- 
savePaymentOptions();
 

					
?>

 
    <?php include('form-payment.php'); ?>





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
 
 



 