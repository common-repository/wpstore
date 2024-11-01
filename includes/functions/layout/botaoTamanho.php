   
  <?php /**/  ?>
  
 
<div  class="tamanhoSelect2">
 
  		<ul class="tamanhos">
  		
		<?php 
		
		       global $wpdb; 
               $tabela = $wpdb->prefix."";
               $tabela .=  "wpstore_stock";
               $sql = "SELECT * FROM `$tabela` WHERE  	`idPost` = '$postID' AND  `tipoVariacao` = 'tamanho'  ORDER BY `showOrder` ASC   LIMIT 0 , 100";

               $fivesdraftsTamanho = $wpdb->get_results( $sql);
               
               $arraySizes = array();$cont = 0; ?>
                    
               
               
               <?php $urlImg =  plugin_dir_url( __FILE__ )."images/camisaMedida.png"; ?>         



                <?php
                
                    if(count($fivesdraftsTamanho )>0){ ?>    
                      
                   <p> <?php echo $txtEscolhaTamanhoProduto; ?></p>
                      
               <?php   if($exibirTabela=="sim"){     ?>
                               <img class='camisaMedida' src="<?php echo $urlImg; ?>" />
                 <?php  }; ?>
                    
                 
               <?php
               foreach ( $fivesdraftsTamanho as $fivesdraftT )  {
                   
                     $arraySizes[] = $fivesdraftT->variacaoProduto;  
        
                              $tamanho  = $fivesdraftT->variacaoProduto;
                              $tamAlt  = $fivesdraftT->variacaoProduto;
                              $qtdProduto =  intval($fivesdraftT->qtdProduto);
                              $qtdReservaUsuario = custom_get_stock_reservaUsuario($postID,$tamanho);
							  
		   	                   $qtdVendida = custom_get_qtd_vendida( $postID , '', $tamanho);
           
                               $qtdProduto =  $qtdProduto -  $qtdVendida - $qtdReservaUsuario;   
                              
                              $precoOperacao =    $fivesdraftT->precoOperacao; 
                              $precoAlternativo =    $fivesdraftT->precoAlternativo;  
							  
							 
							 
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
 
             <li class="selectVaricaoTamanho <?php echo $classPrecoAlt; ?>" rel="<?php echo  $tamanho  ; ?>" rev="<?php if( $qtdProduto <= 0 && $ilimitado ==false ){ ?>esgotado<?php }; ?>"    ><?php echo  $tamanho  ; ?>   
				 
	  <?php if($precoAlternativo>0){ ?> <span style="font-size:0.7em" class='<?php echo $classPrecoAlt; ?>' rel='<?php echo $precoAlternativo; ?>'>(<?php echo $moedaCorrente; ?><?php echo $precoSoma; ?>)</span>
      <?php }; ?>  
					 
					 <?php if($qtdProduto<=0  && $ilimitado ==false ){ ?><span class="esgotado"></span> <?php }; ?></li>
          
             <?php $cont+=1; }; ?>
             
			 
             <?php };  ?>
             
             
			 
             </ul>
 	   </div>
	   
	     <?php /**/?>  
  