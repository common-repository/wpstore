	<?php  /* */
    
		         global $wpdb; 
                   $tabela = $wpdb->prefix."";
                   $tabela .=  "wpstore_stock";
                   $sql = "SELECT variacaoProduto FROM `$tabela` WHERE  	`idPost` = '$postID' AND  `tipoVariacao` = 'tamanho'  ORDER BY `showOrder` ASC ";

                   $fivesdraftsTamanho = $wpdb->get_results( $sql);

                   //$arraySizes = array();


            if(count($fivesdraftsTamanho)>0){  ?>
		    
	
           <?php $urlImg =  plugin_dir_url( __FILE__ )."images/camisaMedida.png"; ?>

    		<span></span>
          	<div  class="tamanhoSelect2"  style='position:relative' > 
          	<p>  <?php echo $txtEscolhaTamanhoProduto; ?> </p>
                
 
              <?php   if($exibirTabela=="sim"){     ?>
                         	
                         	 <img class='camisaMedida' src="<?php echo $urlImg; ?>" />
           
               <?php  }; ?>
 

        

		         <?php foreach($arrayColor as $key =>$cor){ ?>
		    
		             
		     		<ul class="tamanhos <?php echo trim(str_replace(' ','xxx',$cor));//echo trim(str_replace(' ','',$cor)); ?>" <?php if($key>0){ ?> style="position:relative;display:none;"  <?php }; ?>  >
		     
		    	     <?php 
        		  
                         $qtdVendida =0;
                         
                       foreach ( $fivesdraftsTamanho as $fivesdraftT )  {
                           
                           $arraySizes[] = $fivesdraftT->variacaoProduto;  
                           $tamanho  = $fivesdraftT->variacaoProduto;
                           $tamAlt  = $fivesdraftT->variacaoProduto;
                           
                         
                           
                           $corTamanho = trim( str_replace(' ','',$tamanho) )."-".trim( str_replace(' ','',$cor) );
                             
						
                  //echo "bbb ".$arrayColorQtd[$key];
 
	   
                if( intval($arrayColorQtd[$key]) > 0 ){ //se cor está com quantidade habilitada
               
                             // $qtdProduto =  intval($fivesdraftT->qtdProduto);
                             
                             $qtdProduto = custom_get_qtd_stock( $postID,trim(str_replace(' ','',$cor)),trim(str_replace(' ','',$tamanho)) );
                              
                              
                              $qtdReservaUsuario = custom_get_stock_reservaUsuario($postID,$tamanho);
                              
                              $qtdVendida = custom_get_qtd_vendida( $postID , trim(str_replace(' ','',$cor)) , trim(str_replace(' ','',$tamanho)) );
                              
                              $qtdProdutoF =  ($qtdProduto - $qtdReservaUsuario) - $qtdVendida;
                          
                                //echo  $corTamanho."****"."$qtdProduto - $qtdReservaUsuario - $qtdVendida =  $qtdProdutoF";
                              
                               $qtdProduto =$qtdProdutoF;	  
							  
							   $qtdProduto = verificarEstoque($postID, trim(str_replace(' ','',$cor)),trim(str_replace(' ','',$tamanho)));
                               //echo "sss $qtdProduto";
							   
                              };
							  

							  $qtdVendida = custom_get_qtd_vendida( $postID , trim(str_replace(' ','',$cor)) , trim(str_replace(' ','',$tamanho)) );
							  
							  $qtdProduto = intval($qtdProduto) - intval($qtdVendida);
		   			 
		   				       if(current_user_can('manage_options')){
		   					    //echo $qtdProduto."ZZZ";
		   				       };
		   				   
                              
                           if($qtdProduto>0){
                               $sql = "SELECT `qtdProduto` FROM `$tabela` WHERE  	`idPost` = '$postID' AND  `tipoVariacao` = 'tamanhoCor' AND `variacaoProduto` = '$corTamanho'  ORDER BY `showOrder` ASC   LIMIT 0 , 100";
                                 $qtdProduto =   $wpdb->get_var( $wpdb->prepare(  $sql ,1,'') );
                                 $qtdProduto =  intval( $qtdProduto );
                                 $qtdReservaUsuario = custom_get_stock_reservaUsuario($postID,$corTamanho);
                                 $qtdProduto = $qtdProduto - $qtdReservaUsuario - $qtdVendida;
								 
								 
								   $qtdProduto = verificarEstoque($postID, trim(str_replace(' ','',$cor)),trim(str_replace(' ','',$tamanho)));
								   
								   
	 							  $qtdVendida = custom_get_qtd_vendida( $postID , trim(str_replace(' ','',$cor)) , trim(str_replace(' ','',$tamanho)) );
							  
	 							  $qtdProduto = intval($qtdProduto) - intval($qtdVendida);
								 
                                 $sql = "SELECT `precoOperacao` FROM `$tabela` WHERE  	`idPost` = '$postID' AND  `tipoVariacao` = 'tamanhoCor' AND `variacaoProduto` = '$corTamanho'  ORDER BY `showOrder` ASC   LIMIT 0 , 100";
                                 $precoOperacao =   $wpdb->get_var( $wpdb->prepare(  $sql ,1,'') );
                                 
                                 $sql = "SELECT `precoAlternativo` FROM `$tabela` WHERE  	`idPost` = '$postID' AND  `tipoVariacao` = 'tamanhoCor' AND `variacaoProduto` = '$corTamanho'  ORDER BY `showOrder` ASC   LIMIT 0 , 100";
                                  $precoAlternativo =   $wpdb->get_var( $wpdb->prepare(  $sql ,1,'') );  
                                 				   
                                  
                           }
                           
						   
					
 			              $precoSoma = get_post_meta($postID,'price',true); 
 			      $precoComDesconto = get_post_meta($postID,'specialprice',true);                    
				   
		 				  if($precoComDesconto!=''){
		 				  	 $precoSoma = $precoComDesconto;
		 				  }
		          
		                   if(strlen($precoSoma)>6){
		                       $precoSoma= str_replace('.','',$precoSoma );
		                   };
		                   $precoSoma = str_replace(',','.',$precoSoma);   
				  
		 				   $precoSoma = floatval($precoSoma);
				  
		 				  $classPrecoAlt = "";
		 		           $precoAlternativoSoma = floatval(str_replace(',','.',$precoAlternativo));
				   
				          // echo $precoAlternativoSoma."AA";
					 
		 				  if( $precoAlternativoSoma >0){
		 					   $classPrecoAlt = "precoAlt";
							   if($precoOperacao=="+"){
		 					   $precoSoma += $precoAlternativoSoma;
						       }else{
						       	$precoSoma -= $precoAlternativoSoma;
						       }
		 				  };
						  
						  
                      ?>


				   <?php 
			 
				       if(current_user_can('manage_options')){
					    //echo $qtdProduto."ZZZ";
				       };
				    ?>
					
					
                     <li class="selectVaricaoTamanho" style="position:relative" rel="<?php echo  $tamanho  ; ?>" rev="<?php if( $qtdProduto <=0 && $ilimitado ==false ){ ?>esgotado<?php }; ?>"   ><?php echo  $tamanho  ; ?>    
						 
						 <?php if($precoAlternativo>0){ ?> <span style="font-size:0.7em" class='<?php echo $classPrecoAlt; ?>' rel='<?php echo $precoAlternativo; ?>' >(  <?php echo $moedaCorrente; ?><?php echo $precoSoma; ?>)</span> 
							 
							 <?php }; ?>  
							 
							 <?php if($qtdProduto<=0  && $ilimitado !=true ){ ?><span class="esgotado"></span> <?php }; ?></li>

                     <?php }; ?>
                     
                     </ul>
                     
                    <?php }; ?>
                    
                    
                    </div>
                   
                   
      <?php }; ?>       
        		
        		    
			<?php /**/ ?>		