<?php

/**/
     global $wpdb; 

     $tabela = $wpdb->prefix."";
     $tabela .=  "wpstore_stock";
 
     $sql = "SELECT * FROM `$tabela` WHERE   `idPost` = '$postID' AND  `tipoVariacao` = 'cor'  ORDER BY `showOrder` ASC   LIMIT 0 , 100";

     $fivesdraftsCor = $wpdb->get_results( $sql );
 
     $arrayColor = array();
     $arrayColorQtd = array();
     $arraySizes = array();
 
  if( intval($fivesdraftsCor) >0){     ?><span></span>
	   
	  
		<div  class="sexoSelect3">
		
		 <p> <?php echo $txtEscolhaCorProduto; ?> </p>
		 
		<ul class="cores" style="position:relative" >
		
		       <?php 
 
        
             foreach ( $fivesdraftsCor as $key0 =>$fivesdraftC )  {
                   
                   $color  = $fivesdraftC->variacaoProduto;
                   $corAlt  = $fivesdraftC->imgAlternativa;
                 
                   $qtdProduto =  intval($fivesdraftC->qtdProduto);
				   
                   $qtdReservaUsuario = custom_get_stock_reservaUsuario($postID,$color);
				   
	               $qtdVendida = custom_get_qtd_vendida( $postID , $color , '');
           
		   
                   $qtdProduto =  $qtdProduto -  $qtdVendida  - $qtdReservaUsuario;
                   
				  // echo $qtdProduto ;
				   //$qtdProduto = verificarEstoque($postID,$color,'');
			 
                   $arrayColor[] = $color;
                   $arrayColorQtd[] =$qtdProduto;
                   
                   
                   if($corAlt =="#F4F4F4" ){ $corAlt="";  }; 
				   
				   
                   $precoOperacao =    $fivesdraftC->precoOperacao; 
                   $precoAlternativo =    $fivesdraftC->precoAlternativo;
				   
				   
                 
					 
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
				       };
					   
				  };
				  
			 
              ?> 
              
			  
		   <?php 
		       if(current_user_can('manage_options')){
			   // echo $qtdProduto."ZZZ";
		       };
		    ?>
			
              <li   class="selectVaricaoCor<?php if($key0==0){ ?> ativo  <?php }; ?>" rel="<?php echo trim(str_replace(' ','xxx',$color));  //echo trim(str_replace(' ','',$color));?>"  rev="<?php if( $qtdProduto <= 0 && $ilimitado ==false ){ ?>esgotado<?php }; ?>"
               <?php if($corAlt !=""){ ?>
               style="background:<?php echo $corAlt; ?>"
               <?php }; ?>
               > 
               
               <span><?php echo $color; ?> </span>  
			   
			   <span><?php if($precoAlternativo>0){ ?> 
				   
				   <span style="font-size:0.7em" class='<?php echo $classPrecoAlt; ?>' rel='<?php echo $precoAlternativo; ?>' >(  <?php echo $moedaCorrente; ?><?php echo $precoSoma; ?>) </span> 
				   
				   <?php }; ?>
				   
				   <?php 
				       if(current_user_can('manage_options')){
					    //echo $qtdProduto."ZZZ";
				       };
				    ?>
			    <?php if( $qtdProduto <=0 && $ilimitado ==false ){ ?> <span class="esgotado"></span><?php }; ?></li>
		 
			<?php };  ?>
			
			
		</ul></div>
		
		<?php }; ?>
		
		<div class="clear"></div>
	
		<div class="carreg"></div>  <br/>
		
		
<?php /**/ ?>