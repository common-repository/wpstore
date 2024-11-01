               
			   
			   <?php  
			   
			   
			   
			   $qtdStock = custom_get_qtd_stock($postID,'',''); 
 
			   $check = intval(get_post_meta($postID,'is_check_outofstock',true));       
 
			   if($check===1){
			        $qtdStock = 1000000000000000;
			   };
 

			   $qtdVendida = custom_get_qtd_vendida( $postID , trim(str_replace(' ','','')) , trim(str_replace(' ','','')) );
 
 
 
			  $qtdStock -= $qtdVendida;
              $qtdStock -= $qtdProduto;
			  $saldoEstoque  = $qtdStock;
			   
			    $qtdVendido = get_qtd_product_sell($postID);
				
				
			    $saldoEstoque = intval( get_post_meta($postID,'initstock',true) ) - $qtdVendido;
			  
			   if($saldoEstoque < 0 ){$saldoEstoque = 0; }
			   
			   $saldoEstoque  = intval($saldoEstoque);
			   
			   
			   
			   
			 
			    if( $saldoEstoque > 0 || $ilimitado==true ){ 
					
			   
	 			      if($preco>0){
					
					
					 ?>
                 
        	             
        	             
        	             
        	             
        	             
        	                   	<div class="clear"></div>
							 

								<?php /*?> 
								
								REMOVIDO NA NOVA VERSAO> TEMA MOBILE
                                     <p class="preco"  ><?php if($precoS >0) { echo "<span style='font-size:0.8em'>De: </span>"; }; ?><?php echo $moedaCorrente; ?> <span <?php if($precoS >0) { echo "style='text-decoration:line-through;font-size:1.3em'"; }; ?> ><?php echo $preco; ?></span></p>
								
								*/ ?>


                                                                <?php
                                                              	//PLUGIN SHOP FUNCTION --------------------------------------

                                                                       if($precoS>0){  /*?>

                                                           			 <p class="preco"  ><span style='font-size:0.8em'>Por:</span> <span style='color:red;font-size:1em'><?php echo $moedaCorrente; ?></span> <span  style='color:red;font-size:1.7em;' ><?php echo $precoS; ?></span></p>


                                                                 <?php */}; ?>
                                                                 
                                                                 
                                                                 
                                                                 
                                                                 
                                                                                                   <?php $exibeQtdProd = get_option('exibeQtdProd');
                                                                                                         if($exibeQtdProd  =="sim"){ ?>
                                                                                                      <p class='quantidade'> <label for='qtdProd'> <?php echo $txtSelecioneParcela; ?>:</label>  <input type='text' class='somenteNumeros'  name='qtdProd' id='qtdProd' value='1' style='width:30px' /> </p>
                                                                                                      <?php  }; ?>
                                                                 
                                                                 
                             
							 
							
				<?php															 		   				                 																	   				                          $produtoNaoParcela = get_produto_parcela_status($postID);
			       if( $produtoNaoParcela ==false){
					
					?>                                    

 

           <?php }; // produto parcela?>        

                                         <div class="clear"></div>
                                        

<?php /*
                                       <div id='boxComprar'></div>

                                    <a class="addCarrinho btComprar" href="<?php the_permalink(); ?>"><?php echo   $txtAdicionarBtProduto    ; ?> </a>   
                                    
                                    <a class="comprar btComprar" href="<?php the_permalink(); ?>"><?php echo  $txtComprarBtProduto    ; ?></a>


      */ ?> 
      
      
      



      <a href="#" title="Comprar <?php the_title(); ?>" class="btComprar" >
          <span itemprop="availability" content="in_stock"><?php echo $txtAdicionarBtProduto; ?></span>
      </a> 
      <p  class="msg"><span style="color:red"> </span></p>
      
	  <?php }; //if preco >0?>
                            
  							
 
        	           <?php }else{ ?>   
        	            
        	               <p class="indisp" style="display:block;background:#ddd;padding:10px" ><?php echo  $txtprodutoIndisponivel;      ?>  <br/>
        	               <?php  if($showButtom ==true){ ?>        <span style="font-size:0.8em"> <?php echo  $txtprodutoAvisarChegar;      ?> </span>
        	               <br/>
        	               <?php echo $txtprodutoNomeFormContato ?>:<input type="text" id="nomeAviso2" value="Digite seu Nome" title="Digite seu Nome" /> <br/>
                   		   <?php echo $txtprodutoEmailFormContato ?>:<input type="text" id="emailAviso2" value="Digite seu Email" title="Digite seu Email" />
			 		     <br/>
			 		   Telefone para contato:<input type="text" id="telefoneAviso2"  value="Telefone com ddd" title="Telefone com ddd"  />
                   		 <br/><br/>
                   		 <a href="#" class="btAviso2" >  <?php echo  $txtprodutoEnviarFormContato;      ?></a>
						 
			 	        <p  class="msg"><span style="color:red"> </span></p>
      
                            
                   	    <?php }; ?>       </p>  
                   		  
                   		
        	           <?php }; ?>
        	           	