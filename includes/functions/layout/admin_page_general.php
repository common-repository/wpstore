<?php


if ( current_user_can( 'manage_options' ) ) {
    /* A user with admin privileges */
} else {
    $urlR = verifyURL(get_bloginfo('url')).'/wp-admin';
	echo '<script>window.location = "'.$urlR.'";</script>';
}

$idPaginaCarrinho = 0;
$idPaginaCheckout = 0;


 		 $variacaoPrecoValor = intval(trim($_POST['variacaoPrecoValor'])); 
		 
		 
      if($_POST['submit']=="Confirmar" || $variacaoPrecoValor  >0){
		  
		  
		  
		 
 		 //REMARCACAO--------------------------
 		  //   		
 		 $idCatRemarcar = trim($_POST['idCatRemarcar']);  

 		 $variacaoPreco= trim($_POST['variacaoPreco']); 
 		 $confirmar = false;
		 
		 
		
		 
		 
		 
 		 $idCatRemarcarC = trim($_POST['idCatRemarcarC']);  
 		 $variacaoPrecoValorC = intval(trim($_POST['variacaoPrecoValorC'])); 
 		 $variacaoPrecoC= trim($_POST['variacaoPrecoC']); 
		
	
	
		 $aplicarPreco= trim($_POST['aplicarPreco']); 
		 
		 
 		 if($variacaoPrecoValorC >0){
 			 $idCatRemarcar =  $idCatRemarcarC ;  
 			 $variacaoPrecoValor =  $variacaoPrecoValorC; 
 			 $variacaoPreco=  $variacaoPrecoC; 
 			 $confirmar = true;
 		 }
		 
		  
         
		 if($variacaoPrecoValor  >0 && $variacaoPrecoValor <100 ){
		 	           
			 if(current_user_can('manage_options')){
				 
				 
	
				 echo " <h1>Atualizando Produtos....</h1>";
					/*
					echo "   ALTERANDO VALORES ......<br/>
					    $idCatRemarcar *******  
				        $variacaoPreco ******* 
						$variacaoPrecoValor  <br/> ";
					*/
				 
				  
			       if($idCatRemarcar=='-1'){
			 	        query_posts('posts_per_page=-1&post_type=produtos');
			        }else{
			        	                          query_posts("cat=$idCatRemarcar&posts_per_page=-1&post_type=produtos");
			        }
				    global $post;
			 		while ( have_posts() ) : the_post(); 
					
					
		            $preco =  custom_get_price($post->ID); 
		 		  
					$precoConta = $preco;
					if(strlen($preco)>6){
 						$precoConta  = floatval(str_replace('.','',$preco));
					}
					$precoConta  = floatval(str_replace(',','.',$precoConta));
 					$diferenca =  $precoConta* $variacaoPrecoValor / 100;
 					$precoF = $precoConta;
			        if($variacaoPreco=='-'){
						$precoF =  $precoConta - $diferenca;
					}else{
						$precoF =  $precoConta + $diferenca;
					}
				    $precoFS=   number_format($precoF ,2,',','.');
					
			
					
					    //SALVANDO NOVO PRECO -------
					 if($precoF>0 && $confirmar==true && $aplicarPreco !='promocional'){
				          update_post_meta($post->ID ,'price' , $precoFS );
					 };
					 
					
					
 		 		    $precoEspecial =custom_get_specialprice($post->ID);   
					 
					if($precoEspecial !='0,00'){
						
 					    $precoContaPromo = $precoEspecial;
  					     if(strlen($precoContaPromo)>6){
 						$precoContaPromo  = floatval(str_replace('.','',$precoContaPromo));
 					      }
					
					      $precoContaPromo  = floatval(str_replace(',','.',$precoContaPromo));
			
			
  					       $diferencaPromo =  $precoContaPromo* $variacaoPrecoValor / 100;
					 
					        $precoFPromo = $precoConta;
					 
 							if($variacaoPreco=='-'){
 								$precoF =  $precoConta - $diferenca;
 								$precoFPromo =  $precoContaPromo - $diferenca;
 							}else{
 								$precoF =  $precoConta + $diferenca;
 								$precoFPromo =  $precoContaPromo + $diferenca;
 							}
				
							if($precoFPromo<=0){
 									$precoFPromo = "0,00";
 						    }
					
 							$precoFPromoS=   number_format($precoFPromo ,2,',','.');
			        
					
					        //SALVANDO NOVO PRECO -------
					 	   if($precoFPromoS >0 && $precoEspecial>0 && $confirmar==true && $aplicarPreco !='principal'){
					      	 	update_post_meta($post->ID ,'specialprice',$precoFPromoS);	
		            	 	}
							
							
						};//SE PRECO PROMOCIONAL NAO FOR VAZIO
					 
					
 			 	    echo get_the_title()."
						<br/>PRECO ANTIGO: $preco  
					    <br/>PREÇO NOVO  : $precoFS";
					if($precoEspecial !='0,00'){
				           echo "<br/>PRECO PROMOCIONAL ANTIGO - $precoEspecial 
						    <br/>PRECO PROMOCIONAL NOVO  - $precoFPromoS
						    ";
				     };
				
					 echo "<br/><hr/>";
					 
					/**/
		
			 		endwhile; wp_reset_query(); 
					if( $confirmar==true){
						echo "<h2>VALORES ATUALIZADOS</h2><br/><br/>";
					}else{ ?>
						
				
					   <h2 class='red' >Deseja Confirmar as alterações?</h2>
					   
						<form action="<?php echo verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=general";?>"  method="post" >
						
   		 
					  <input type='hidden' name='idCatRemarcarC' value='<?php echo $idCatRemarcar; ?>'/>
					  <input type='hidden' name='variacaoPrecoValorC' value='<?php echo $variacaoPrecoValor; ?>'/>
					  <input type='hidden' name='variacaoPrecoC' value='<?php echo  $variacaoPreco; ?>'/>
					  <input type="submit"  name="submit" value="Confirmar"   />  
					
					</form>
					<br/><br/> 
					
					<?php } ?>
			
			<?php
			 };

					   
					  
		 }
		 
		 
		 //REMARCACAO --------------------------
		 /**/
		 
		 
      	
      };

     if( $_POST['submit']=="Salvar"  ){
		 
		 
		 
		 
		 
  
         $wpstravaexibicao = trim($_POST['wpstravaexibicao']); 
         add_option('wpstravaexibicao',$wpstravaexibicao,'','yes');
         update_option('wpstravaexibicao',$wpstravaexibicao);
  
	   
	   
         $wpstravapreco = trim($_POST['wpstravapreco']); 
         add_option('wpstravapreco',$wpstravapreco,'','yes');
         update_option('wpstravapreco',$wpstravapreco);
		 
		 
	   
		  $categories  = "";
		   if(!empty($_POST['post_category'])) {
			  foreach($_POST['post_category'] as $check) {
		               $categories .=",$check"; 
		      }
	       };
		  add_option('arrCatRemoveParcelaWPSHOP',$categories,'','yes'); 
          update_option('arrCatRemoveParcelaWPSHOP',$categories);
		 

         $emailAdmin = trim($_POST['emailAdmin']); 
         add_option('emailAdminWPSHOP',$emailAdmin,'','yes'); 
         update_option('emailAdminWPSHOP',$emailAdmin);
         

      
         
        
         $moedaCorrente = trim($_POST['moedaCorrente']); 
		 $moedaCorrenteS  =  get_option('moedaCorrenteWPSHOP');
		 if($moedaCorrenteS != $moedaCorrente){
         add_option('moedaCorrenteWPSHOP',$moedaCorrente,'','yes'); 
         update_option('moedaCorrenteWPSHOP',$moedaCorrente);
	     };
         
		 
		 
		 
          $idPaginaLogin  = trim($_POST['idPaginaLogin']); 
 		 $idPaginaLoginS  =  get_option('idPaginaLoginWPSHOP');
 		 if($idPaginaLoginS !=$idPaginaLogin){
          add_option('idPaginaLoginWPSHOP',$idPaginaLogin  ,'','yes'); 
          update_option('idPaginaLoginWPSHOP',$idPaginaLogin );   
	     };

         $idPaginaTermos = trim($_POST['idPaginaTermos']); 
 		 $idPaginaTermosS  =  get_option('idPaginaTermosWPSHOP');
 		 if($idPaginaTermosS !=$idPaginaTermos){
           add_option('idPaginaTermosWPSHOP',$idPaginaTermos  ,'','yes'); 
           update_option('idPaginaTermosWPSHOP',$idPaginaTermos);
	      }
         
         
             $idPaginaPerfil  = trim($_POST['idPaginaPerfil']); 
		     $idPaginaPerfilS  =  get_option('idPaginaPerfilWPSHOP');
   		   if($idPaginaPerfilS !=$idPaginaPerfil){
            add_option('idPaginaPerfilWPSHOP',$idPaginaPerfil ,'','yes'); 
            update_option('idPaginaPerfilWPSHOP',$idPaginaPerfil);
           };
		 
		 
		   
            $idPaginaPedido  = trim($_POST['idPaginaPedido']); 
			 $idPaginaPedidoS  =  get_option('idPaginaPedidoWPSHOP');
  		    if($idPaginaPedidoS !=$idPaginaPedido){
                add_option('idPaginaPedidoWPSHOP',$idPaginaPedido,'','yes'); 
                update_option('idPaginaPedidoWPSHOP',$idPaginaPedido); 
            };    
                
				
	 	  $idPaginaPedidos = trim($_POST['idPaginaPedidos']); 		
	      $idPaginaPedidosS  =  get_option('idPaginaPedidosWPSHOP');
  		   if($idPaginaPedidosS !=$idPaginaPedidos){
               add_option('idPaginaPedidosWPSHOP',$idPaginaPedidos,'','yes'); 
                update_option('idPaginaPedidosWPSHOP',$idPaginaPedidos);
						
	        }
                        
            $idPaginaCheckout  = trim($_POST['idPaginaCheckout']); 
			$idPaginaCheckoutS  =  get_option('idPaginaCheckoutWPSHOP');
		    if($idPaginaCheckoutS !=$idPaginaCheckout){
				add_option('idPaginaCheckoutWPSHOP',$idPaginaCheckout,'','yes'); 
                update_option('idPaginaCheckoutWPSHOP',$idPaginaCheckout);
			}
                                
		  $idPaginaCarrinho  = trim($_POST['idPaginaCarrinho']);
		  $idPaginaCarrinhoS  =  get_option('idPaginaCarrinhoWPSHOP');
	      if($idPaginaCarrinhoS !=$idPaginaCarrinho){
			add_option('idPaginaCarrinhoWPSHOP',$idPaginaCarrinho,'','yes'); 
             update_option('idPaginaCarrinhoWPSHOP',$idPaginaCarrinho);
          
		  };
		                             
          $idPaginaPagto  = trim($_POST['idPaginaPagto']); 
		  $idPaginaPagtoS  =  get_option('idPaginaPagtoWPSHOP');
	       if($idPaginaPagtoS !=$idPaginaPagto){
			  add_option('idPaginaPagtoWPSHOP',$idPaginaPagto,'','yes'); 
               update_option('idPaginaPagtoWPSHOP',$idPaginaPagto);
          };    
		  
		  
		  
	      $idPaginaDetalhesEntrega = trim($_POST['idPaginaDetalhesEntrega']); 
	      $idPaginaDetalhesEntregaS  =  get_option('idPaginaDetalhesEntregaWPSHOP');
	      if($idPaginaDetalhesEntregaS !=$idPaginaDetalhesEntrega){  
	 	    add_option('idPaginaDetalhesEntregaWPSHOP',$idPaginaDetalhesEntrega,'','yes'); 
	         update_option('idPaginaDetalhesEntregaWPSHOP',$idPaginaDetalhesEntrega);                   
	      };                             
                                  
	    $idPaginaRetiradaLoja= trim($_POST['idPaginaRetiradaLoja']); 
	    $iidPaginaRetiradaLojaS  =  get_option('idPaginaRetiradaLojaWPSHOP');
	    if($idPaginaRetiradaLojaS !=$idPaginaRetiradaLoja){  
	 	 add_option('idPaginaRetiradaLojaWPSHOP',$idPaginaRetiradaLoja,'','yes'); 
	      update_option('idPaginaRetiradaLojaWPSHOP',$idPaginaRetiradaLoja);                   
	    };     
		
		
		   
		   
		
	    $idPaginaBoleto= trim($_POST['idPaginaBoleto']); 
	    $iidPaginaBoletoS  =  get_option('idPaginaBoletoWPSHOP');
	    if($idPaginaBoletoS !=$idPaginaBoleto){  
	 	 add_option('idPaginaBoletoWPSHOP',$idPaginaBoleto,'','yes'); 
	      update_option('idPaginaBoletoWPSHOP',$idPaginaBoleto);                   
	    };     
		
		
	    $idPaginaObrigado= trim($_POST['idPaginaObrigado']); 
	    $iidPaginaObrigadoS  =  get_option('idPaginaObrigadoWPSHOP');
	    if($idPaginaObrigadoS !=$idPaginaObrigado){  
	 	 add_option('idPaginaObrigadoWPSHOP',$idPaginaObrigado,'','yes'); 
	      update_option('idPaginaObrigadoWPSHOP',$idPaginaObrigado);                   
	    };   
		   
		   
		                    
 //--------      
  	   $idPaginaMensagemAutorizacao = trim($_POST['idPaginaMensagemAutorizacao']); 
	   
  	    add_option('idPaginaMensagemAutorizacaoWPSHOP', $idPaginaMensagemAutorizacao,'','yes'); 
  	      update_option('idPaginaMensagemAutorizacaoWPSHOP', $idPaginaMensagemAutorizacao);           
 
	
          $mensagemAutorizacao   = trim($_POST['mensagemAutorizacao']); 
		   			add_option('mensagemAutorizacaoWPSHOP',$mensagemAutorizacao,'','yes'); 
                update_option('mensagemAutorizacaoWPSHOP',$mensagemAutorizacao); 
				
				//--------
         
 	   $idPaginaMensagemAutorizacao2 = trim($_POST['idPaginaMensagemAutorizacao2']); 
	   
 	    add_option('idPaginaMensagemAutorizacao2WPSHOP', $idPaginaMensagemAutorizacao2,'','yes'); 
 	      update_option('idPaginaMensagemAutorizacao2WPSHOP', $idPaginaMensagemAutorizacao2);           
 
	
         $mensagemAutorizacao2   = trim($_POST['mensagemAutorizacao2']); 
 	  			add_option('mensagemAutorizacao2WPSHOP',$mensagemAutorizacao2,'','yes'); 
               update_option('mensagemAutorizacao2WPSHOP',$mensagemAutorizacao2);
 	 
	//--------	
		
	
		 
		  $parcelaMinima  = trim($_POST['parcelaMinima']); 
		  $parcelaMinimaS  =  get_option('parcelaMinima');
	      if($parcelaMinimaS !=$parcelaMinima){
			  add_option('parcelaMinima',$parcelaMinima,'','yes'); 
               update_option('parcelaMinima',$parcelaMinima);
		  };
                                                                
          $totalParcela  = trim($_POST['totalParcela']); 
 		  $totalParcelaS  =  get_option('totalParcela');
 		    if($totalParcelaS !=$totalParcela){
				add_option('totalParcela',$totalParcela,'','yes'); 
                update_option('totalParcela',$totalParcela);
		    };
                                                                              
                                       
   $facebookAPPID  = trim($_POST['facebookAPPID']); 
   $facebookAPPIDS  =  get_option('facebookAPPID');
   if($facebookAPPIDS !=$facebookAPPID){
        add_option('facebookAPPID',$facebookAPPID,'','yes'); 
         update_option('facebookAPPID',$facebookAPPID);
   };
                                                                                            
   $facebookSecret = trim($_POST['facebookSecret']);
   $facebookSecretS  =  get_option('facebookSecret');
   if($facebookSecretS !=$facebookSecret){ 
       add_option('facebookSecret',$facebookSecret,'','yes'); 
        update_option('facebookSecret',$facebookSecret);
   };
                                                                                                           
   $googleMarca= trim($_POST['googleMarca']); 
   $googleMarcaS  =  get_option('googleMarca');
   if($googleMarcaS !=$googleMarca){ 
      add_option('googleMarca',$googleMarca,'','yes'); 
      update_option('googleMarca',$googleMarca);
   };
   
    $codigoAnalytics = trim($_POST['codigoAnalytics']); 
    $codigoAnalyticsS  =  get_option('codigoAnalytics');
    if($codigoAnalyticsS !=$codigoAnalytics){                                
       add_option('codigoAnalytics',$codigoAnalytics,'','yes'); 
       update_option('codigoAnalytics',$codigoAnalytics);
    };                                                                                                                               
	$googleCategorias = trim($_POST['googleCategorias']); 
    $googleCategoriasS  =  get_option('googleCategorias');
    if($googleCategoriasS !=$googleCategorias){    
  	  	    add_option('googleCategorias',$googleCategorias,'','yes');
 		   	update_option('googleCategorias',$googleCategorias);
    };
	
	
   $googleConversaoCheckout= trim($_POST['googleConversaoCheckout']); 
   $googleConversaoCheckoutS  =  get_option('googleConversaoCheckout');
   if($googleConversaoCheckoutS !=$googleConversaoCheckout){  
	    add_option('googleConversaoCheckout',$googleConversaoCheckout,'','yes');
      update_option('googleConversaoCheckout',$googleConversaoCheckout);
  };
  

		 
       $googleConversaoPagto= trim($_POST['googleConversaoPagto']); 
       $googleConversaoPagtoS  =  get_option('googleConversaoPagto');
       if($googleConversaoPagtoS != $googleConversaoPagto){  
	   add_option('googleConversaoPagto',$googleConversaoPagto,'','yes');
       update_option('googleConversaoPagto',$googleConversaoPagto);
       };
	   
	   
	   
	   
       $facebookConversaoPagto= trim($_POST['facebookConversaoPagto']); 
       $facebookConversaoPagtoS  =  get_option('facebookConversaoPagto');
       if($facebookConversaoPagtoS != $facebookConversaoPagto){  
	   add_option('facebookConversaoPagto',$facebookConversaoPagto,'','yes');
       update_option('facebookConversaoPagto',$facebookConversaoPagto);
       };
	   

       $boxFacebookLike= trim($_POST['boxFacebookLike']); 
       add_option('boxFacebookLike',$boxFacebookLike,'','yes');
       update_option('boxFacebookLike',$boxFacebookLike);
  
	 
	 
       $limitAgeRegisterWpstore= trim($_POST['limitAgeRegisterWpstore']); 
       add_option('limitAgeRegisterWpstore',$limitAgeRegisterWpstore,'','yes');
       update_option('limitAgeRegisterWpstore',$limitAgeRegisterWpstore);
  
    
	   
                          
                                                                                                                                                           
        if (isset( $_POST['ativarssl'] )) {
               $ativarssl = "sim"; 
               add_option('ativarsslWPSHOP',$ativarssl,'','yes'); 
               update_option('ativarsslWPSHOP',$ativarssl);
        }else{
               $ativarssl = "não"; 
               add_option('ativarsslWPSHOP',$ativarssl,'','yes'); 
               update_option('ativarsslWPSHOP',$ativarssl);
        };      
  
  
  
        if (isset( $_POST['controlarEstoque'] )) {
               $controlarEstoque= 1; 
               add_option('controlarEstoqueWPSHOP',$controlarEstoque,'','yes'); 
               update_option('controlarEstoqueWPSHOP',$controlarEstoque);
        }else{
               $controlarEstoque= 0; 
               add_option('controlarEstoqueWPSHOP',$controlarEstoque,'','yes'); 
               update_option('controlarEstoqueWPSHOP',$controlarEstoque);
        };  
		
		
  
        if (isset( $_POST['etiquetaRemetenteDesativar'] )) {
               $etiquetaRemetenteDesativar = "sim"; 
               add_option('etiquetaRemetenteDesativarWPSHOP',$etiquetaRemetenteDesativar,'','yes'); 
               update_option('etiquetaRemetenteDesativarWPSHOP',$etiquetaRemetenteDesativar);
        }else{
               $etiquetaRemetenteDesativar = "não"; 
               add_option('etiquetaRemetenteDesativarWPSHOP',$etiquetaRemetenteDesativar,'','yes'); 
               update_option('etiquetaRemetenteDesativarWPSHOP',$etiquetaRemetenteDesativar);
        }; 
		
						 
        if (isset( $_POST['agruparEnderecos'] )) {
               $agruparEnderecos = "sim"; 
               add_option('agruparEnderecosWPSHOP',$agruparEnderecos,'','yes'); 
               update_option('agruparEnderecosWPSHOP',$agruparEnderecos);
        }else{
               $agruparEnderecos = "não"; 
               add_option('agruparEnderecosWPSHOP',$agruparEnderecos,'','yes'); 
               update_option('agruparEnderecosWPSHOP',$agruparEnderecos);
        };      
 
		
		
			 

		 
		                                         
};

 $emailAdmin =  get_option('emailAdminWPSHOP');
 $moedaCorrente  =  get_option('moedaCorrenteWPSHOP');

 $idPaginaLogin  =  get_option('idPaginaLoginWPSHOP');
 $idPaginaPerfil   =  get_option('idPaginaPerfilWPSHOP');
 $idPaginaPedido   =  get_option('idPaginaPedidoWPSHOP');
 $idPaginaTermos   =  get_option('idPaginaTermosWPSHOP');
 $idPaginaPedidos  =  get_option('idPaginaPedidosWPSHOP');
 $idPaginaCheckout  =  get_option('idPaginaCheckoutWPSHOP');
 $idPaginaCarrinho  =  get_option('idPaginaCarrinhoWPSHOP'); 
 $idPaginaPagto =  get_option('idPaginaPagtoWPSHOP'); 
 $idPaginaDetalhesEntrega =  get_option('idPaginaDetalhesEntregaWPSHOP'); 
 $idPaginaRetiradaLoja=  get_option('idPaginaRetiradaLojaWPSHOP'); 
 $idPaginaBoleto=  get_option('idPaginaBoletoWPSHOP'); 
 $idPaginaObrigado=  get_option('idPaginaObrigadoWPSHOP'); 
 
 $ativarssl  =  get_option('ativarsslWPSHOP'); 
 
 $controlarEstoque =  get_option('controlarEstoqueWPSHOP'); 
  
  
 $parcelaMinima=  get_parcelaMinima(); 
 $totalParcela = get_totalParcela();
 
 $facebookAPPID  =  get_option('facebookAPPID'); 
 $facebookSecret  =  get_option('facebookSecret'); 
        
 $googleMarca  =  get_option('googleMarca'); 
 $googleCategorias  =  get_option('googleCategorias'); 
 $codigoAnalytics  =  get_option('codigoAnalytics'); 
   
 $arrCatRemoveParcelaWPSHOP=  get_option('arrCatRemoveParcelaWPSHOP'); 
  
 
 $googleConversaoCheckout=  str_replace('\"','"',get_option('googleConversaoCheckout'));      
 
 
 $googleConversaoPagto =  str_replace('\"','"',get_option('googleConversaoPagto'));     
 
 
 $boxFacebookLike = str_replace('\"','"',get_option('boxFacebookLike')); 
 
 
  $facebookConversaoPagto =  str_replace('\"','"',get_option('facebookConversaoPagto'));  
  
  
  
 $wpstravaexibicao = get_option('wpstravaexibicao');
 $wpstravapreco = get_option('wpstravapreco');
 
 
 


 
 
$idPaginaMensagemAutorizacao = get_option('idPaginaMensagemAutorizacaoWPSHOP');
$mensagemAutorizacao = get_option('mensagemAutorizacaoWPSHOP');
	
 
$idPaginaMensagemAutorizacao2 = get_option('idPaginaMensagemAutorizacao2WPSHOP');
$mensagemAutorizacao2 =get_option('mensagemAutorizacao2WPSHOP');
	
	
		$limitAgeRegisterWpstore =get_option('limitAgeRegisterWpstore');
	
	$etiquetaRemetenteDesativar =get_option('etiquetaRemetenteDesativarWPSHOP');
	$agruparEnderecos =get_option('agruparEnderecosWPSHOP');
	
	    
	  	  
?>    


<form action="<?php echo verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=general";?>"  method="post" >




<div id="cabecalho">
	<ul class="abas">
		<li>
			<div class="aba gradient">
				<span>Opções Gerais</span>
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
			
			<h3>1. Email do administrador</h3>
			
			<span class="seta" rel='email'></span>
			<div class="texto" id='email'>
				<label for="emailAdm">Digite o email do administrador</label>
			  <input type="text" id="emailAdmin" name="emailAdmin" value="<?php echo $emailAdmin; ?>"  />                
			  
				<p>Ex:email@seudominio.com.br</p>   
				
				  <input type="submit"  name="submit" value="Salvar"   />  
				  
			</div>
		</div><!-- .bloco -->
		
		
		
		        
		
		
		<div class="bloco">
			<h3>2. Paginas de configuração  do Sistema </h3>
			
			<span class="seta" rel='paginas'></span>
			<div class="texto" id='paginas'>
			
			
			               
			               
			               
			               <p>Ao instalar nosso plugin , automáticamente criamos algumas paginas. Você pode querer remover estas pagina e definir abaixo uma nova estrutura de paginas  para seu sistema de vendas.</p>
                           
                            <br/>

                           <h4>Pagina Carrinho :</h4>
                           <p>Selecione a pagina de PEDIDO ( CARRINHO ) :   <br/>
                            <?php wp_dropdown_pages("show_option_none=---&id=idPaginaCarrinho&name=idPaginaCarrinho&selected=$idPaginaCarrinho"); ?>  
                           <br/>
                           <span style="font-size:11px">Selecione a pagina ou deixe em branco para não adicionar automáticamente. Neste caso insira o código <strong>get_cart_Table(); </strong>  no   template de pagina que deseja usar ou a expressão <strong>[get_cart_Table] </strong> 
                           no content da pagina no wordpress.</span>
                           </p>

                           <br/> <br/> 
                           
                           <h4>Pagina Checkout :</h4>
                           <p>Selecione  a pagina de CHECKOUT ( PAGAMENTO ) :   <br/>
                            <?php wp_dropdown_pages("show_option_none=---&id=idPaginaCheckout&name=idPaginaCheckout&selected=$idPaginaCheckout"); ?>  
                           <br/>
                           <span style="font-size:11px">Selecione a pagina ou deixe em branco para não adicionar automáticamente. Neste caso insira o código <strong>custom_get_checkout(); </strong>  no   template de pagina que deseja usar ou a expressão <strong>[custom_get_checkout] </strong> 
                           no content da pagina no wordpress.</span>
                           </p>

                           <br/> <br/>  
                           
                           <h4>Pagina PAGAR:</h4>
                           <p>Selecione a  pagina de PAGAMENTO ( PAGAMENTO ) :   <br/>
                            <?php wp_dropdown_pages("show_option_none=---&id=idPaginaPagto&name=idPaginaPagto&selected=$idPaginaPagto"); ?>  
                           <br/>
                           <span style="font-size:11px">Selecione a pagina ou deixe em branco para não adicionar automáticamente. Neste caso insira o código <strong>get_payment_checkout(); </strong>  no   template de pagina que deseja usar ou a expressão <strong>[get_payment_checkout] </strong> 
                           no content da pagina no wordpress.</span>
                           </p>

                           <br/>  <br/> 
                           
                           <h4>Pagina Meus Pedidos :</h4>
                           <p>Selecione a pagina com a listagem dos pedidos de cada usuário( MEUS PEDIDOS ) :   <br/>
                            <?php wp_dropdown_pages("show_option_none=---&id=idPaginaPedidos&name=idPaginaPedidos&selected=$idPaginaPedidos"); ?>  
                           <br/>
                           <span style="font-size:11px">Selecione a pagina ou deixe em branco para não adicionar automáticamente. Neste caso insira o código <strong> custom_get_orders_user(); </strong>  no   template de pagina que deseja usar ou a expressão <strong>[custom_get_orders_user] </strong> 
                           no content da pagina no wordpress.</span>
                           </p>


                           <br/> <br/> 
                           
                           <h4>Pagina Pedido :</h4>
                           <p>Selecione a  pagina que informa os detalhes do pedido de cada usuário( PEDIDO) :   <br/>
                            <?php wp_dropdown_pages("show_option_none=---&id=idPaginaPedido&name=idPaginaPedido&selected=$idPaginaPedido"); ?> 
                           <br/>
                           <span style="font-size:11px">Selecione a pagina ou deixe em branco para não adicionar automáticamente. Neste caso insira o código <strong>custom_get_order_user(); </strong>  no   template de pagina que deseja usar ou a expressão <strong>[custom_get_order_user] </strong> 
                           no content da pagina no wordpress.</span>
                           </p>

                           <br/> <br/> 
                           
                           <h4>Pagina Meus Dados :</h4>
                           <p>Selecione a  da pagina que informa os detalhes da conta de cada usuário( MEUS DADOS) :   <br/>
                           <?php wp_dropdown_pages("show_option_none=---&id=idPaginaPerfil&name=idPaginaPerfil&selected=$idPaginaPerfil"); ?>  
                           <br/>
                           <span style="font-size:11px">Selecione a pagina ou deixe em branco para não adicionar automáticamente. Neste caso insira o código <strong>get_edit_form_perfil(); </strong>  no   template de pagina que deseja usar ou a expressão <strong>[get_edit_form_perfil] </strong> 
                           no content da pagina no wordpress.</span>
                           </p>

                           <br/> <br/> 
                           
                           <h4>Pagina LOGIN :</h4>
                           <p>Selecione a pagina que será inserido o formulário de LOGIN/CADASTRO ( LOGIN) :   <br/>
                            <?php wp_dropdown_pages("show_option_none=---&id=idPaginaLogin&name=idPaginaLogin&selected=$idPaginaLogin"); ?>  
                           <br/>
                           <span style="font-size:11px">Selecione a pagina ou deixe em branco para não adicionar automáticamente. Neste caso insira o código <strong>get_Login_form(); </strong>  no   template de pagina que deseja usar ou a expressão <strong>[get_Login_form] </strong> 
                           no content da pagina no wordpress.</span>
                           </p><br/> <br/> 
                           
                           <h4>Pagina Termos :</h4>
                           <p>Selecione a pagina que será inserido a politica de trocas, devoluções .... :   <br/>
                            <?php wp_dropdown_pages("show_option_none=---&id=idPaginaTermos&name=idPaginaTermos&selected=$idPaginaTermos"); ?>  
                           <br/>
                           <span style="font-size:11px">Selecione a pagina  ou deixe em branco para não adicionar automáticamente. Neste caso insira  a expressão <strong>[custom_get_Termos] </strong> 
                           no content da pagina no wordpress.</span>
                           </p><br/>  <br/> 
						   
						   
						   
						   
                           <br/> <br/> 
                           
                           <h4>Pagina Detalhes de entrega :</h4>
                           <p>Selecione a  da pagina que informa os detalhes e prazos para entrega dos produtos :   <br/>
                           <?php wp_dropdown_pages("show_option_none=---&id=idPaginaDetalhesEntrega&name=idPaginaDetalhesEntrega&selected=$idPaginaDetalhesEntrega"); ?>  
                           <br/>
                           <span style="font-size:11px">Selecione a pagina ou deixe em branco para não adicionar automáticamente. Neste caso insira o código <strong>  </strong>  no   template de pagina que deseja usar ou a expressão <strong>[get_detalhes_entrega] </strong> 
                           no content da pagina no wordpress.</span>
                           </p>
						   
						   

                           <br/> <br/> 
                           
                           <h4>Pagina Lojas e Pontos de Retirada :</h4>
                           <p>Selecione a   pagina que informa os detalhes e localização das lojas e pontos para retirada de mercadorias :   <br/>
                           <?php wp_dropdown_pages("show_option_none=---&id=idPaginaRetiradaLoja&name=idPaginaRetiradaLoja&selected=$idPaginaRetiradaLoja"); ?>  
                           <br/>
                         
                           </p>

                           <br/> <br/> 
						   
						   
                         
                           <h4>Pagina para geração de Boletos:</h4>
                           <p>Selecione a   pagina que  gera os boletos de pagamento de vendas online :   <br/>
                           <?php wp_dropdown_pages("show_option_none=---&id=idPaginaBoleto&name=idPaginaBoleto&selected=$idPaginaBoleto"); ?>  
                           <br/>
                       
                           </p>

                           <br/> <br/>
						   
						   
                           <h4>Pagina de Agradecimento após Compra:</h4>
                           <p>Selecione a   pagina de agradecimento:                                <br/>
							   
                           <?php wp_dropdown_pages("show_option_none=---&id=idPaginaObrigado&name=idPaginaObrigado&selected=$idPaginaObrigado"); ?>  
						   
                           <br/>
						   
                       <small>O usuário será redirecionado para esta pagina após o pagamento.</small>
                           </p>

                           <br/> <br/>
						   
						   
						   
						   
						   



                            <input type="submit"  name="submit" value="Salvar"   />
                            
                            
                            
				
				
				
			</div><!-- .texto -->
		</div><!-- .bloco -->
		
		
		         
		
		
		
		
		
		
		
		
		
		
		
		
	     
		<div class="bloco">
			<h3>3. Moeda Corrente</h3>
			
		        <span class="seta" rel='moeda'></span>
				<div class="texto" id='moeda'>
	 
	
	
	
	                <p>Escolha o simbolo da moeda Corrente . (ex:U$) :
                    <input type="text" id="moedaCorrente" name="moedaCorrente" value="<?php echo $moedaCorrente; ?>" style="width:20%"/>
                    </p><br/>  

                     <input type="submit"  name="submit" value="Salvar"   />
                     
                     
                     
			</div><!-- .texto -->
		</div><!-- .bloco -->   
	 
		




			<div class="bloco">
				<h3>4. Parcelamento</h3>

			        <span class="seta" rel='parcelamento'></span>
						<div class="texto" id='parcelamento'>
				
				
				
				                <h4>Parcelamento mínimo</h4>
                            <p>Valor mínimo para parcelamento (Tabela Pagina produtos) . Exemplo : R$5,00 <br/>
                               <input type="text" id="parcelaMinima" name="parcelaMinima" value="<?php echo $parcelaMinima; ?>" style="width:20%"/>     

                               </p> <br/><br/>
                               
							   
							   <h4>Máximo de parcelas</h4>
                               <p>Total Máximo de Parcelas :
                                  <input type="text" id="totalParcela" name="totalParcela" value="<?php echo $totalParcela; ?>" style="width:20%"/>
                                  </p><br/><br/>






   							   <h4>Marque para não  parcelar produtos incluídos nas seguintes categorias : </h4>
							   
							    <small>Se a compra do usuário possuir produtos de outras categorias, será autorizado o parcelamento.</small>
								<br/>
                                <br/>
							   <div class='catcheck'>
								   <ul>
								 <?php 
								  $arrIds = explode(',' , $arrCatRemoveParcelaWPSHOP);
								  wp_category_checklist(0,0,$arrIds,false,null,false); 
								 ?>
							      </ul>
							  </div> 
								 
								 
									<br/><br/>





                            <input type="submit"  name="submit" value="Salvar"   />
                            
                            
                            
				</div><!-- .texto -->
			</div><!-- .bloco -->   





                 <div class="bloco">
					<h3>5. Facebook </h3>

				        <span class="seta" rel='facebookLogin'></span>
							<div class="texto" id='facebookLogin'>
					
					
					              <h4>Facebook APPID LOGIN</h4>
                                   <p>sua APPID do facebook :
                                   <input type="text" id="facebookAPPID" name="facebookAPPID" value="<?php echo $facebookAPPID; ?>" style="width:20%"/>
                                   </p>   <br/>   <br/> 
                                   <h4>Facebook API SECRET KEY API LOGIN</h4>
                                   <p>O código  API SECRET KEY de sua API: 
                                      <input type="text" id="facebookSecret" name="facebookSecret" value="<?php echo $facebookSecret; ?>" style="width:20%"/>
                                      </p><br/> <br/> 
									  
									  
				              <h4>BOX LIKE FACEBOOK</h4>
                                 <p>Crie seu box no facebook:
                               
                                    <textarea name='boxFacebookLike' id='boxFacebookLike'><?php echo $boxFacebookLike; ?></textarea>
                                    </p>
									<small><a href='https://developers.facebook.com/docs/plugins/like-box-for-pages/'>Clique aqui</a>, gere e cole o código IFRAME gerado.  </small>
									
									<br/> <br/>	  
									
									
									
									
									
									
                                    <h4>Facebook CONVERSÕES  Anúncios- PAGAMENTO</h4>
                                    <p>Insira seu código de conversões para pagamentos do Facebook :      
                                     <br/>   <br/> 
                                     <textarea    id="facebookConversaoPagto" name="facebookConversaoPagto"  ><?php echo $facebookConversaoPagto; ?></textarea>
                                     </p>
                                    
									
									  





                                <input type="submit"  name="submit" value="Salvar"   />
                                
                                
                                
					</div><!-- .texto -->
				</div><!-- .bloco -->
		
		   
		
		
		
		
		               <div class="bloco">
 							<h3>6. Opções do Google</h3>

 						        <span class="seta" rel='googleShop'></span>
        							<div class="texto" id='googleShop'>
 							   
 							
 							             <h4>Codigo site no analytics  </h4>
                                         <p>Ex : UA-6sgfdhs4-34tv  </p>    
                                          
                                         <br/>
                                          <input type="text" id="codigoAnalytics" name="codigoAnalytics" value="<?php echo $codigoAnalytics; ?>" style="width:20%"/> 
                                         </p>  <br/>  <br/>
 							
 							            <h4>Marca Padrão</h4>
                                         <p>Marca padrão escolhida quando produto não possuir marca cadastrada : </p>     
                                         <br/>
                                          <input type="text" id="googleMarca" name="googleMarca" value="<?php echo $googleMarca; ?>" style="width:20%"/> 
                                         </p>  <br/>  <br/> 
                                         <h4>Categorias do Google</h4>
                                         <p>Escolha as categorias correspondentes a seus produtos :     
                                          <br/>   <br/> 
                                            <input type="text" id="googleCategorias" name="googleCategorias" value="<?php echo $googleCategorias; ?>" style="width:20%"/>
                                         </p>

                                         <br/>  <br/>    
                                         
                                         
                                         
                                              <h4>CONVERSÕES ADWORDS - CHECKOUT</h4>
                                              <p>Insira seu código de conversões Checkout do Google :     
                                               <br/>   <br/> 
                                                 <textarea    id="googleConversaoCheckout" name="googleConversaoCheckout"  ><?php echo $googleConversaoCheckout; ?></textarea>
                                                 
                                              </p>
                                             
                                             
                                             
                                                    <h4>CONVERSÕES  ADWORDS - PAGAMENTO</h4>
                                                    <p>Insira seu código de conversões para pagamentos do Google :      
                                                     <br/>   <br/> 
                                                     <textarea    id="googleConversaoPagto" name="googleConversaoPagto"  ><?php echo $googleConversaoPagto; ?></textarea>
                                                     </p>
                                                    
                                                     
                                              

                                      <input type="submit"  name="submit" value="Salvar"   />
                                      
                                      
                                      
 							</div><!-- .texto -->
 						</div><!-- .bloco -->
 						
 						
						
						
						
						
						
						
						
						
  		               <div class="bloco">
   							<h3>7. REMARCAÇÃO DE PREÇOS</h3>

   						        <span class="seta" rel='optRemarcacao'></span>
          							<div class="texto" id='optRemarcacao'>
 							   
							   
							               <h5>Escolha as categorias que serão afetadas pela mudança </h5>
								
		                       
		                           <?php wp_dropdown_categories("show_option_none=Todas&id=idCatRemarcar&name=idCatRemarcar&orderby=name&order=asc"); ?> 
		                          <br/><br/>
								 
								  		   
										   
										   
 							
   							              <h5>Defina a variação </h5>
										   
										   
 									      <p>Escolha '+' para aumentar  o preço atual de cada produto, ou '-' para  aumentar. </p>
											<select name='variacaoPreco'>
												<option>-</option>
												<option>+</option>
											</select>
								
											  
												<br/><br/>
 							
      							             <h5> Escolha o Percentual de modificação</h5>
												
												
											    <input type='text' name='variacaoPrecoValor' id='variacaoPrecoValor' />  % </p>
												<small>Coloque somente o numero percentual da mudança  - Valor inteiro e positivo inferior a 100. </small>
										 <br/>	 <br/>	
										 
										 
										 
									      <p>Aplicar aos preços</p>
										<select name='aplicarPreco'>
											<option value='todos'>Todos</option>
											<option value='principal'>Principal</option>
											<option value='promocional'>Promocional</option>
										</select>
										 
										 
										 <br/>	 <br/>	
										 
      
                                        <input type="submit"  name="submit" value="Salvar"   />
										
										<br/>         <br/>                
										          <small class='red'>ATENÇÃO! Alterações realizadas nesta guia são irreversíveis. Para retornar a um estágio de preço anterior , realize uma nova remarcação de preços, com a variação e percentual desejado. </small>
                                      
                                      
                                      
   							</div><!-- .texto -->
   						</div><!-- .bloco -->
						
						
						
						
						
						
						
						
						
						
						
					  <div class="bloco">
					  	<h3>8. Opções de impressão </h3>

				          <span class="seta" rel='optImpressao'></span>
			        
					      <div class="texto" id='optImpressao'>
 
							   
					       <h3>Impressão de etiquetas</h3>
							   
					    	 <h4>Deseja  <strong>não imprimir</strong> a etiqueta de remetente (endereço da loja) para cada pedido selecionado ? </h4>
                                  
							 <p><input type="checkbox" name="etiquetaRemetenteDesativar"  <?php if($etiquetaRemetenteDesativar=="sim"){ echo "CHECKED"; }; ?> /> Selecione para não imprimir a etiqueta de  remetente. </p>
						    <br/>
						 
	
 				          <h3>Agrupar endereços no final da impressão</h3>
						   
 				    	 <h4>Deseja  <strong>agrupar</strong> as etiquetas do destinatário no final da pagina de impressão </h4>
                                
 						 <p><input type="checkbox" name="agruparEnderecos"  <?php if($agruparEnderecos=="sim"){ echo "CHECKED"; }; ?> /> Selecione para agrupar todas as etiquetas de endereço  na última pagina da impressão. </p>
 		                <br/>
						
						
					   
						   
    <input type="submit"  name="submit" value="Salvar"   />
                                      
	
							</div><!-- .texto -->
						</div><!-- .bloco -->
						
 						
		     
			 
			 
			 
		
		
	 		<div class="bloco">
	 			<h3>9. Forçar Controle Estoque </h3>
			
	 			  <span class="seta" rel='controlarEstoque'></span>
	 				<div class="texto" id='controlarEstoque'>
			
	  
	  
	 	                <p><input type="checkbox" name="controlarEstoque"  <?php if($controlarEstoque=="1"){ echo "CHECKED"; }; ?> /> Selecione para forçar controle de estoque e desabilitar estoque ilimitado.</p>
				 
	                     <br/> 

	                      <input type="submit"  name="submit" value="Salvar"   />
                     
                     
                     
	 			</div><!-- .texto -->
	 		</div><!-- .bloco -->
			 
			 
			 
			 
			 
			 
			 
						
		
		
			 		               <div class="bloco">
			  							<h3>10. Opções Extra</h3>

			  						        <span class="seta" rel='optExtra'></span>
			         							<div class="texto" id='optExtra'>
												
												
								 
		 
																<h3>Opção para Ativar URLS COM HTTPS (SOMENTE SE SEU SITE TEM CERTIFICADO SSL )  </h3>
			
							 
	  
														                <p><input type="checkbox" name="ativarssl"  <?php if($ativarssl=="sim"){ echo "CHECKED"; }; ?> /> Selecione para ativar endereços de URL iniciados com HTTPS .   Só habilite esta opção se seu domínio possui  certificado SSL ativo.</p><br/>
													
													                    <br/> 

													                     <input type="submit"  name="submit" value="Salvar"   />
																				 
																							 <br/>
																				 
																							 <small> Ativou sem possuir SSL ? Para forçar a desativação deste item , insira o código a seguir no final do  arquivo header.php de seu tema :<br/> <strong>update_option('ativarsslWPSHOP' , '');  </strong> 
																								 <br/> Após inserir   recarregue a pagina inicial de seu site para que a alteração seja realizada. Em seguida remova   no header.php e atualize novamente . </small>  
																				 
																				 
																							 <br/><br/>
                     
                     
                     
								 
												
												
												
												
												
 
							   
			    <h3>Idade mínima para cadastro</h3>
							   
			    	 <h4>Deseja inserir uma idade mínima para cadastro? </h4>
                                         
					
							    <input type='text' name='limitAgeRegisterWpstore' id='limitAgeRegisterWpstore' value="<?php echo $limitAgeRegisterWpstore; ?>" />    </p>
				
				  <br/> <small>Ex:18. Deixe vazio para não estabelecer limite</small><br/> 
        
														  
			   	 <br/>
	
	
	
							   
							   
							   
			 <h3>MOSTRAR PRODUTOS SÓ PARA USUARIOS AUTORIZADOS</h3>
							   
			 	 <h4>Exibir Produtos somente para Usuários com registro confirmado. </h4>
                                         
			      <select name="wpstravaexibicao" id="wpstravaexibicao" > 
													  	  <option value="false" <?php if($wpstravaexibicao=='false'){ echo 'selected="selected"';}; ?> >Não</option>                              <option value="true" <?php if($wpstravaexibicao=='true'){ echo 'selected="selected"';}; ?>>Sim</option> 
													   </select>
														  
				 <br/>
	 
	
	
	
	 
	 
	 
	 
	 
				 <h3>MOSTRAR PREÇOS SÓ PARA USUARIOS AUTORIZADOS</h3>
							   
				 	 <h4>Exibir Preços somente para Usuários com registro confirmado. </h4>
                                         
				      <select name="wpstravapreco" id="wpstravapreco" > 
														  	  <option value="false" <?php if($wpstravapreco=='false'){ echo 'selected="selected"';}; ?> >Não</option>                              <option value="true" <?php if($wpstravapreco=='true'){ echo 'selected="selected"';}; ?>>Sim</option> 
														   </select>
														  
					 <br/>
	 
	 
	 
	 
	 
	 
	 
	 
			      <h4>AVISO DE REGISTRO PARA  USUARIOS LOGADOS NO SISTEMA :</h4>
	  
			      <p>Selecione o content de uma pagina <br/>
		  
		  
			                            <?php wp_dropdown_pages("show_option_none=---&id=idPaginaMensagemAutorizacao&name=idPaginaMensagemAutorizacao&selected=$idPaginaMensagemAutorizacao"); ?>  
			                           <br/>
                           
			                           </p>

			                           <br/> <br/> 
						   
	
				 <h5>OU DIGITE UMA MENSAGEM PERSONALIZADA : </h5>
							
							
									    <input type='text' name='mensagemAutorizacao' id='mensagemAutorizacao' value="<?php echo $mensagemAutorizacao; ?>" />    </p>
						
						  <br/> <br/> 
			  
			  
			   
			  
					       <h4>AVISO DE REGISTRO PARA USUARIOS  NÃO LOGADOS NO SIsTEMA:</h4>
	  
					       <p>Selecione o content de uma pagina <br/>
		  
		  
					                             <?php wp_dropdown_pages("show_option_none=---&id=idPaginaMensagemAutorizacao2&name=idPaginaMensagemAutorizacao2&selected=$idPaginaMensagemAutorizacao2"); ?>  
					                            <br/>
                         
					                            </p>

					                            <br/> <br/> 
						   
		
					 	 <h5>OU DIGITE UMA MENSAGEM PERSONALIZADA : </h5>
							
							
					 						    <input type='text' name='mensagemAutorizacao2' id='mensagemAutorizacao2' value="<?php echo $mensagemAutorizacao2; ?>" />    </p>
						
					 			  <br/> <br/>
						   
					   
						   
			   <input type="submit"  name="submit" value="Salvar"   />
                                      
                                      
                                      
			  							</div><!-- .texto -->
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
