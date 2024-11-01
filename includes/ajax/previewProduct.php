<?php

include("../../../../../wp-load.php");
 
$oid = intval($_REQUEST['oid']);
 
 
 
 

$txtParcelamentoJuros = get_option('txtParcelamentoJurosWPSHOP');   
if($txtParcelamentoJuros==""){
   $txtParcelamentoJuros = "sem juros* no cartão"; 
}
 
 

//TRAVA PRECO ---------------------------------
$travaPreco = get_option('wpstravapreco');
if($travaPreco== 'sim' || $travaPreco == 'true' ){
	$travaPreco = true;
}
$usuarioConfirmado = false;
global $current_user;
get_currentuserinfo();
$idUser = $current_user->ID;    
$autorizacao = get_usermeta($idUser, 'wpsAutorizacao');
if( $autorizacao =='Confirmado' ){
 	 $usuarioConfirmado = true;
	 $travaPreco = false;
};
//TRAVA PRECO ---------------------------------


 
 
 
 
?>
<div class='single'>
<div id="conteudo" itemscope itemtype="http://data-vocabulary.org/Product">

	
	<div class="entry-content">
		
	
		<div class="esq esqajax"   >
             
        
         
            
			<div class="foto">
			            
					<?php
					
					         $simbolo = get_current_symbol();    
                             $preco = custom_get_price($oid); 
                             $precoComDesconto = custom_get_specialprice($oid); //PLUGIN SHOP FUNCTION --------------------------------------            
                              
                     if ( has_post_thumbnail($oid)) { ?>  
				  <?php  $url = wp_get_attachment_url( get_post_thumbnail_id($oid) ); ?>
                             <a href="<?php echo $url; ?>" class="group"  title="<?php the_title(); ?>"><img itemprop="image" width="300" alt="<?php the_title(); ?>" src="<?php bloginfo('template_url'); ?>/timthumb.php?src=<?php echo $url; ?>&w=300&q=80" /></a>
                     <?php } else { ?> 
                             <div class="semanuncio">
                                   <img width="80" itemprop="image"  alt="<?php the_title(); ?>" src="<?php bloginfo('template_url'); ?>/images/semanuncio.png" />
                             </div>   
                     <?php }; ?>   
                    
             
              </div>
            
            
    
	
	
            
			<ul class="minifotos"> 
			      
			                  <?php
              					$args = array(
                  				'post_type' => 'attachment',
                  			    'numberposts' => -1,
                  				'post_status' => null,
                  				'orderby'         => 'menu_order',
                  			    'order'           => 'ASC',
                  			    'post_parent' => $oid);



              				$attachments = get_posts($args);
              				$count  = 0;

              				$totalGaleria = 0;

              					if ($attachments) {
              						foreach ($attachments as $attachment) {
              							//echo apply_filters('the_title', $attachment->post_title);
              							   $image_id = $attachment->ID;  
              							   $legenda = $attachment->post_excerpt;  
              							   $image_url = wp_get_attachment_image_src($image_id,'large');  
              							   $image_url = $image_url[0];
              							   $totalGaleria  +=1;



              					?>
                                <li><a href="<?php echo $image_url; ?>" class="group" title="<?php the_title(); ?>"><img width="75" alt="<?php the_title(); ?>" src="<?php bloginfo('template_url'); ?>/timthumb.php?src=<?php echo $image_url; ?>&w=60&h=40&zc=1" /></a></li>         

                                 <?php 
              						$count +=1;

              				    			}
              							}

                                       wp_reset_query();
                               ?>
                               
			              
            </ul> 
            
            <div class="clear"></div>   
			
			<?php //include('includes/midiasSingle.php'); ?>
			

			
		</div><!-- .esq -->
		
		
		
		
		
		
		
		
		<div class="dirajax"    >
        
        	<div class="titulo">
				
				
				<?php
					
				$produtoSemPromoFrete = get_produto_promoFrete_status($oid);
					
			
	   				if( $produtoSemPromoFrete  ==false){
				
					
				?>
            
            	<div class="freteGratis">  
            	   
            	
            	<?php  
            	$cidadesFreteGratis =get_option('cidadesFreteGratis'); 
            	$arrCidades = explode(',',$cidadesFreteGratis);
            	     
            	?>
            	       <span> <strong>Frete Grátis para    </strong>
                     <?php 
                        
                        foreach($arrCidades as $cidadeG){    
                                     $arrCidadeG = explode('**',$cidadeG);
                     ?> 
                     
                     - 
                     
                     <?php echo$arrCidadeG[1]; ?> <?php echo $arrCidadeG[0]; ?> 
                         
                     <?php }; ?>  
                     
                       </span>       
                     
                    <div class="clear"></div>
                </div> 
                
				
				
				<?php }; //produto com promo frete  ?>
				
				
				
				
				
				  <h1 itemprop="name"><?php echo get_the_title($oid); ?></h1>
                
                
                
        
            </div><!-- .titulo -->
		
		
			<div class="details">    
			
			
            	
                <div class="wps-dadosProdutos" itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer">
                                 
                  
                    <div id="dadosProduto"> 
                    
                    
                    
                        <?php if(function_exists('the_ratings')) {  the_ratings('div', $oid);   } ?>  


                        		<p class="marcaProd">Marca: <a href="#"><span itemprop="seller"> <?php  if(get_post_meta($oid,'marca',true) ==""){ echo get_bloginfo('name'); }else{ echo get_post_meta($oid,'marca',true); };  ?> </span></a></p>




                        <meta itemprop="currency" content="BRL" />
                        
                        <?php    
                        
                        
						
						
						
						
			
			  	        if( $travaPreco!="true"){   
							
							
							
							
                       
                            $parcelaMinima=  get_parcelaMinima(); 
                            $totalParcelas = intval(get_totalParcela());
                            
                            $textoParcelamento = "";
                            
                             $precoParcela = $preco;
                           
                            $parcelamentoTabela= "";  $parcelamentoTabela2= "";   
                            if($precoComDesconto>0) {    $precoParcela = $precoComDesconto;  }; 
                            
                            $precoF = $precoParcela;                 
                            $totalParc = 1;
                            for($i=1;$i<=$totalParcelas;$i++){
                            $valorParcelaV =  $precoF/$i;  
                            $precoParcelaV = getPriceFormat($valorParcelaV); 
                              
                            if($valorParcelaV>=$parcelaMinima && $i>1){ $precoParcela = $precoParcelaV; $totalParc = $i; };     
                               
                              if($i>1 && $i<=5 && $valorParcelaV>=$parcelaMinima ){   
                              $parcelamentoTabela .= "<tr>
                            	<th>$i X sem juros</th>
                                <td>$simbolo $precoParcelaV</td>
                               </tr>";
                               };   
                               
                                if($i>5  && $valorParcelaV>=$parcelaMinima ){
                                 $parcelamentoTabela2 .= "<tr>
                               	<th>$i X sem juros</th>
                                   <td>$simbolo $precoParcelaV</td>
                                  </tr>";
                                  };
                               
                               
                            };
                            
                      
                                if($precoComDesconto>0) {
                        ?>
                                             
                        <ul>
                            <li class="precoDe">De: <strong> <?php echo $simbolo; ?><?php echo $preco; ?> </strong></li>
                            
                            <li class="precoPor">Por: <?php echo $simbolo; ?><span itemprop="price"><?php echo  $precoComDesconto ; ?></span>
								
								
								<?php  
	 		   				 $produtoNaoParcela = get_produto_parcela_status($oid);
		 
					
	 		   				if( $produtoNaoParcela ==false){
								?>
                          
                             <?php if($totalParc>1 ){ ?> 
                            <span class="ou">ou <?php echo $totalParc; ?>X de <?php echo $simbolo; ?><?php echo $precoParcela; ?></span></li>
                             <?php }; ?>
                             
                            <li class="vantagem">V
	   						 Pague em até
	   			             <?php echo $totalParcelas; ?>X*
	   						 <?php echo $txtParcelamentoJuros; ?>
                            <span><strong>*Parcela mínima de :</strong><?php echo $simbolo; ?><?php echo getPriceFormat($parcelaMinima); ?> </span></li>
                            
							
							     <?php }; ?>
								 
								 
                        </ul>
                        
                        <?php } else { ?>
                        
                            <ul>
                                 <?php  $preco = custom_get_price($oid);     ?>
                           <li class="precoPor">Por: <?php echo $simbolo; ?><span itemprop="price"><?php echo  $preco ; ?></span>   
                           
						   
						   
							<?php  
 		   				 $produtoNaoParcela = get_produto_parcela_status($oid);
	 
				
 		   				if( $produtoNaoParcela ==false){ ?>
							
                    
                                  <?php if($totalParc >1 ){ ?>    
                                           <span class="ou">ou <?php echo $totalParc; ?>X de <?php echo $simbolo; ?><?php echo $precoParcela; ?></span></li>
                                  <?php }; ?>
                                     
                                     
									 
							
									
									
                            <li class="vantagem">
	   						 Pague em até
	   			             <?php echo $totalParcelas; ?>X*
	   						 <?php echo $txtParcelamentoJuros; ?>
                            <span><strong>*Parcela mínima de :</strong> <?php echo $simbolo; ?><?php echo getPriceFormat($parcelaMinima); ?> </span></li>
							
							<?php }; ?>
                       
                        </ul>
                        
                        <?php }; ?>
						
						
						
		
		 			   <?php };  // endif     if( $travaPreco!="true"){    ?>
						
						
                        
                    </div><!-- #dadosProduto -->
                    
                     
                                

                               <div class="comprarProduto "> 
                               
                               
                               


                     <?php   	
                      //PLUGIN SHOP FUNCTION --------------------------------------
                         if( $travaPreco!="true"){                                 custom_get_select_stock_formB($oid);  
                                             
						?>

		
						   <?php }else{ // endif     if( $travaPreco!="true"){    ?>
                           
						   
						   
						   
							<?php if ( is_user_logged_in() ) { ?>
						
						
						<p>	Ok, você já fez login. Mas seu cadastro de militar ainda não foi verificado. Se você ainda não enviou os dados extras para completar seu cadastro, <a href='<?php $idPaginaMensagemAutorizacao = get_option('idPaginaMensagemAutorizacaoWPSHOP');
							echo get_permalink($idPaginaMensagemAutorizacao); ?>' class='red' >Confirme seu cadastro</a>. Caso já tenha enviado aguarde. Nossa equipe entrará em contato assim que seu cadastro for verificado.  </p>
							
							
							<?php }else{  ?>	
						
								
									<p>Para comprar no IFARDAS você precisa ter seu cadastro de militar confirmado. Por favor, faça o login e verifique seu cadastro militar.   <a href='<?php $idPaginaLogin = get_idPaginaLogin();
							echo get_permalink($idPaginaLogin); ?>' class='red'>Clique aqui para fazer o login</a>.</p>
									
							<?php }; ?>
							
							
							
							<?php };  // endif     if( $travaPreco!="true"){   ?>
                              </div>



                        
                        
                        
                    
                    
                    <div class="clear"></div>
                    
                
                </div><!-- .wps-dadosProdutos -->
                
                
				<?php
				
			    $prazoEspecialProd = trim(get_post_meta($oid,'entregaEspecialData',true)); 

				$prazoTxt = "";
				if($prazoEspecialProd !=""){
					$prazoTxt = "<p class='red'>Produto entregue por transportadora.  O prazo  para entrega desta mercadoria é de até $prazoEspecialProd .</p>";
				}

				$permalinkEntrega  = get_permalink(get_idPaginaEntrega());

				$prazoTxt .= "<p> <span style='color:#d02130'>Atenção!!!</span> O Prazo de entrega é estimado pelos Correios ou transportador. Não nos responsabilizamos por possíveis atrasos gerados por imprevistos no funcionamento deste serviço. Para mais detalhes sobre prazos e entrega <a href='$permalinkEntrega' target='_blank'> Clique aqui </a> .</p>";
			
			
				?>
			
			 
			
			</div><!-- .details -->
		
		
		</div><!-- .dir -->
		
		<div class="clear"></div>
                            
        
        
		</div>
		
		
		</div>
		
		</div>