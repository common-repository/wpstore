<?php


if ( current_user_can( 'manage_options' ) ) {
    /* A user with admin privileges */
} else {
    $urlR = verifyURL(get_bloginfo('url')).'/wp-admin';
	echo '<script>window.location = "'.$urlR.'";</script>';
}



$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
}

saveFreteOptions();
 
       
 
$valorFreteGratis = get_option('valorFreteGratis'); 

$cepOrigemCorreios = get_option('cepOrigemCorreios');

$alturaEmbalagemCorreios  =  get_option('alturaEmbalagemCorreios');
$larguraEmbalagemCorreios = get_option('larguraEmbalagemCorreios');
$comprimentoEmbalagemCorreios =get_option('comprimentoEmbalagemCorreios');
$valorFreteFixo  =get_option('valorFreteFixo');
 
    $valorFretePeso1 =get_option('valorFretePeso1');
       $valorFretePeso2 =get_option('valorFretePeso2');
          $valorFretePeso3 =get_option('valorFretePeso3');
             $valorFretePeso4 =get_option('valorFretePeso4');
                $valorFretePeso5 =get_option('valorFretePeso5');
                   $valorFretePeso6 =get_option('valorFretePeso6');


      $valorFreteValor1 =get_option('valorFreteValor1');
       $valorFreteValor2 =get_option('valorFreteValor2');
        $valorFreteValor3 =get_option('valorFreteValor3');
         $valorFreteValor4 =get_option('valorFreteValor4');
          $valorFreteValor5 =get_option('valorFreteValor5');
          $valorFreteValor6 =get_option('valorFreteValor6');
          
          $cidadesFreteGratis =get_option('cidadesFreteGratis');
		  



$ctCorreios =get_option('ctCorreios');
$ctCorreiosAno =get_option('ctCorreiosAno');
$ctCorreiosReg =get_option('ctCorreiosReg');
 $ctCorreiosCod =get_option('ctCorreiosCod');
 $ctCorreiosPass =get_option('ctCorreiosPass');
 
$tipoFrete =get_option('tipoFrete');

$retirarLoja =get_option('retirarLoja');

if(intval($alturaEmbalagemCorreios)<=0){
  $alturaEmbalagemCorreios  = 9;  
}

if(intval($larguraEmbalagemCorreios)<=0){
  $larguraEmbalagemCorreios  = 9;  
}

if(intval($comprimentoEmbalagemCorreios)<=0){
  $comprimentoEmbalagemCorreios  = 9;  
}



	$arrCatRemovePromoFreteWPSHOP=  get_option('arrCatRemovePromoFreteWPSHOP'); 
	
	
?>  




		



<div id="cabecalho">
	<ul class="abas">
		<li>
			<div class="aba gradient">
				<span>Configurações de Frete</span>
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
	
	 
	
											<?php 
										
											include('form-frete.php'); 
										
											?>
					 


  </div>  
	
	
 
	
	
</div><!-- .content -->

 
 


 <script>

 jQuery('.seta').click(function(){
     rel = jQuery(this).attr('rel');
     jQuery('.texto').hide();
     jQuery('#'+rel).show();
 });    
 
 
  
 jQuery('input.price').priceFormat({
                   prefix: '',
                   centsSeparator: ',',
                   thousandsSeparator: '.'
    });


 </script>
 

 