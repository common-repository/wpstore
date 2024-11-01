<?php



       
 
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
	
	
	
							
	

					$plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));
					
					
					if($action==""){              
					$action = verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=lista_frete";
				  };
					
					
					?>					
										
	 <script type="text/javascript" src="<?php  echo  plugins_url('wpstore/includes/js/jquery.price_format.1.7.js' ,'WP STORE' );  ?>"></script> 
 
    
	<form  id='opcoesFrete' name='opcoesFrete'  action="<?php echo 	$action ; ?>"  method="post" >

	
	
	
	
	<p>Método de frete atual : <strong><?php echo $tipoFrete; ?></strong> </p>  
	
	
	

        <div class="bloco"> 

		<h3> <input type="radio" name="tipoFrete" value="gratis" <?php  if($tipoFrete=='gratis'){ echo "CHECKED"; }; ?>  /> 1) Frete Gratis  </h3>

	              <span class="seta" rel='gratis'></span>
				   	 <div class="texto" id='gratis'>
		 
		 
		 
                         <p>Selecione acima para ativar promoção de frete Grátis </p>

                  <input type="submit"  name="submit" value="Salvar"   />      
		   </div><!-- .texto -->
			</div><!-- .bloco -->

 

               <div class="bloco"> 

    		<h3><input type="radio" name="tipoFrete" value="correios"  <?php  if($tipoFrete=='correios'){ echo "CHECKED"; }; ?> /> 2 ) SEDEX / PAC / E-SEDEX  </h3>

    	              <span class="seta" rel='correios'></span>
    				   	 <div class="texto" id='correios'>



                             <h2> 2.1 ) CEP DE ORIGEM </h2>

                             <p>Preencha o CEP De origem para calculo de entrega Correiors :</p>

                             <p>
                             <label for="cepOrigemCorreios">Cep Origem : </label>
                             <input type="text" id="cepOrigemCorreios" name="cepOrigemCorreios" value="<?php echo $cepOrigemCorreios; ?>" />
                             <br/>
                             <span style="font-size:10px">Sem espaços ou hiffen</span>
                             </p>



                             <h2   class="tipoFrete"  style="background:#eee;padding:10px;cursor:pointer"> 2.2 ) Dimensões de Embalagem  </h2>

                             <p>Preencha as dimensões da Embalagem de entrega :</p>

                             <p>
                             <label for="alturaEmbalagemCorreios">Altura: </label>
                             <input type="text" id="alturaEmbalagemCorreios" name="alturaEmbalagemCorreios" value="<?php echo $alturaEmbalagemCorreios; ?>" />
                             <br/>
                             <span style="font-size:10px">Minimo Recomendado : 9 </span>
                             </p>

                             <p>
                             <label for="larguraEmbalagemCorreios">Largura: </label>
                             <input type="text" id="larguraEmbalagemCorreios" name="larguraEmbalagemCorreios" value="<?php echo $larguraEmbalagemCorreios; ?>" />
                             <br/>
                             <span style="font-size:10px">Minimo Recomendado : 18 </span>
                             </p>


                             <p>
                             <label for="comprimentoEmbalagemCorreios">Comprimento: </label>
                             <input type="text" id="comprimentoEmbalagemCorreios" name="comprimentoEmbalagemCorreios" value="<?php echo $comprimentoEmbalagemCorreios; ?>" />
                             <br/>
                             <span style="font-size:10px">Minimo Recomendado : 27 </span>
                             </p>
                             
							 
							 
							 
                             <h2   class="tipoFrete"  style="background:#eee;padding:10px;cursor:pointer"> 2.3 ) Configuração  E-SEDEX </h2>

                             <p> <label for="ctCorreios">Numero do Contrato: </label>
                             <input type="text" id="ctCorreios" name="ctCorreios" value="<?php echo $ctCorreios; ?>" />
                             <br/>
							 <span style="font-size:10px">Ex: 9912368654</span>
						 </p>
							 
							 
						 <p> <label for="contratoCorreiosAno">Ano  do Contrato: </label>
                             <input type="text" id="ctCorreiosAno" name="ctCorreiosAno" value="<?php echo $ctCorreiosAno; ?>" />
                             <br/>
						  <span style="font-size:10px">Ex: 2014</span>
					     </p>
							 
                         <p> <label for="ctCorreiosReg">DR  Contrato: </label>
                             <input type="text" id="ctCorreiosReg" name="ctCorreiosReg" value="<?php echo $ctCorreiosReg; ?>" />
                              <br/>
						      <span style="font-size:10px">Ex: DR/RJ</span>
					     </p>
                            
                             
							 
							 
	                         <p> <label for="ctCorreiosCod">Código Administrativo integração: </label>
	                             <input type="text" id="ctCorreiosCod" name="ctCorreiosCod" value="<?php echo $ctCorreiosCod; ?>" />
	                              <br/>
							 </p>
							 
							 
	                         <p> <label for="ctCorreiosPass">Senha de integração: </label>
	                             <input type="password" id="ctCorreiosPass" name="ctCorreiosPass" value="<?php echo $ctCorreiosPass; ?>" />
	                              <br/>
							      <span style="font-size:10px">Ex:no primeiro acesso é os 8 primeiros digitos do CNPJ.<br/> É possível trocar a senha em : <a href='http://www.corporativo.correios.com.br/encomendas/servicosonline/recuperaSenha' target="_blank">http://www.corporativo.correios.com.br/encomendas/servicosonline/recuperaSenha</a></span>
						     </p>
							 
							 
                      <input type="submit"  name="submit" value="Salvar"   />            




    		   </div><!-- .texto -->
    			</div><!-- .bloco -->
 




 

          

                <div class="bloco"> 

           		<h3>  <input type="radio" name="tipoFrete" value="fixo" <?php  if($tipoFrete=='fixo'){ echo "CHECKED"; }; ?> />   3) Frete FIXO  </h3>

           	              <span class="seta" rel='fixo'></span>
           				   	 <div class="texto" id='fixo'>


     
                                    <p>Digite o valor abaixo see desejar cobrar um valor fixo de frete para cada Venda.</p>
                                    <label for="valorFreteFixo">Valor fixo para o frete : <?php echo $moedaCorrente; ?></label>
                                    <input type="text" id="valorFreteFixo" name="valorFreteFixo" value="<?php echo $valorFreteFixo; ?>" />
                                    <br/>
                                    <span style="font-size:10px">Ex:10.00</span>
                                    
                             <input type="submit"  name="submit" value="Salvar"   />    

           		   </div><!-- .texto -->
           			</div><!-- .bloco -->



 


 
 
 
 
 
              
 
 
 
                        <div class="bloco"> 

                   		<h3>   <input type="radio" name="tipoFrete" value="pesoBase"  <?php  if($tipoFrete=='pesoBase'){ echo "CHECKED"; }; ?> />   4) Peso como base de frete </h3>

                   	              <span class="seta" rel='pesoBase'></span>
                   				   	 <div class="texto" id='pesoBase'>



                                                       <p>Digite o valor do frete de acordo com a faixa de peso.</p>

                                                        <br/>
                                                         <label for="valorFretePeso1">Peso entre 0 e 1 kg => <?php echo $moedaCorrente; ?></label>
                                                         <input type="text" id="valorFretePeso1" name="valorFretePeso1" value="<?php echo $valorFretePeso1; ?>" />
                                                          <br/>
                                                           <span style="font-size:10px">Ex:10.00</span>


                                                          <br/>
                                                          <label for="valorFretePeso2">Peso entre 1 e 5 kg => <?php echo $moedaCorrente; ?></label>
                                                          <input type="text" id="valorFretePeso2" name="valorFretePeso2" value="<?php echo $valorFretePeso2; ?>" />
                                                          <br/>
                                                           <span style="font-size:10px">Ex:10.00</span>


                                                           <br/>
                                                           <label for="valorFretePeso3">Peso entre 5 e 10 kg => <?php echo $moedaCorrente; ?></label>
                                                            <input type="text" id="valorFretePeso3" name="valorFretePeso3" value="<?php echo $valorFretePeso3; ?>" />
                                                             <br/>
                                                             <span style="font-size:10px">Ex:10.00</span>

                                                              <br/>
                                                               <label for="valorFretePeso4">Peso entre 10 a 20 kg => <?php echo $moedaCorrente; ?></label>
                                                               <input type="text" id="valorFretePeso4" name="valorFretePeso4" value="<?php echo $valorFretePeso4; ?>" />
                                                               <br/>
                                                               <span style="font-size:10px">Ex:10.00</span>



                                                              <br/>
                                                              <label for="valorFretePeso5">Peso entre 20 a 30 kg => <?php echo $moedaCorrente; ?></label>
                                                              <input type="text" id="valorFretePeso5" name="valorFretePeso5" value="<?php echo $valorFretePeso5; ?>" />
                                                               <br/>
                                                               <span style="font-size:10px">Ex:10.00</span>



                                                               <br/>
                                                              <label for="valorFretePeso6">Acima de 30 kg => <?php echo $moedaCorrente; ?></label>
                                                             <input type="text" id="valorFretePeso6" name="valorFretePeso6" value="<?php echo $valorFretePeso6; ?>" />
                                                              <br/>
                                                                <span style="font-size:10px">Ex:10.00</span>

                                                 <input type="submit"  name="submit" value="Salvar"   />    

                   		   </div><!-- .texto -->
                   			</div><!-- .bloco -->

                



                            <div class="bloco"> 

                        		<h3>   <input type="radio" name="tipoFrete"  value="precoBase"  <?php  if($tipoFrete=='precoBase'){ echo "CHECKED"; }; ?>  />    5) Preço como base de frete  </h3>

                        	              <span class="seta" rel='precoBase'></span>
                        				   	 <div class="texto" id='precoBase'>



                                                            <p>Digite o valor do frete de acordo com a faixa de preço .</p>

                                                             <br/>
                                                             <label for="valorFreteValor1">Preço entre <?php echo $moedaCorrente; ?>10 e <?php echo $moedaCorrente; ?>100  => <?php echo $moedaCorrente; ?></label>
                                                             <input type="text" id="valorFreteValor1" name="valorFreteValor1" value="<?php echo $valorFreteValor1; ?>" />
                                                             <br/>
                                                             <span style="font-size:10px">Ex:10.00</span>

                                                             <br/>
                                                             <label for="valorFreteValor2">Preço entre <?php echo $moedaCorrente; ?>100 e <?php echo $moedaCorrente; ?>200 => <?php echo $moedaCorrente; ?></label>
                                                             <input type="text" id="valorFreteValor2" name="valorFreteValor2" value="<?php echo $valorFreteValor2; ?>" />
                                                             <br/>
                                                             <span style="font-size:10px">Ex:10.00</span>

                                                             <br/>
                                                             <label for="valorFreteValor3">Preço entre <?php echo $moedaCorrente; ?>200 e <?php echo $moedaCorrente; ?>300  => <?php echo $moedaCorrente; ?></label>
                                                             <input type="text" id="valorFreteValor3" name="valorFreteValor3" value="<?php echo $valorFreteValor3; ?>" />
                                                             <br/>
                                                             <span style="font-size:10px">Ex:10.00</span>



                                                             <br/>
                                                             <label for="valorFreteValor4">Preço entre <?php echo $moedaCorrente; ?>300 e <?php echo $moedaCorrente; ?>400  => <?php echo $moedaCorrente; ?></label>
                                                             <input type="text" id="valorFreteValor4" name="valorFreteValor4" value="<?php echo $valorFreteValor4; ?>" />
                                                             <br/>
                                                             <span style="font-size:10px">Ex:10.00</span>


                                                              <br/>
                                                              <label for="valorFreteValor5">Preço entre <?php echo $moedaCorrente; ?>400 e <?php echo $moedaCorrente; ?>500  => <?php echo $moedaCorrente; ?></label>
                                                              <input type="text" id="valorFreteValor5" name="valorFreteValor5" value="<?php echo $valorFreteValor5; ?>" />
                                                              <br/>
                                                              <span style="font-size:10px">Ex:10.00</span>


                                                               <br/>
                                                               <label for="valorFreteValor6">Acima de <?php echo $moedaCorrente; ?>500  => <?php echo $moedaCorrente; ?></label>
                                                               <input type="text" id="valorFreteValor6" name="valorFreteValor6" value="<?php echo $valorFreteValor6; ?>" />
                                                               <br/>
                                                               <span style="font-size:10px">Ex:10.00</span>

                                                          <input type="submit"  name="submit" value="Salvar"   />    

                        		   </div><!-- .texto -->
                        			</div><!-- .bloco -->
                        			
                        			
                        			
                        			


                  




                                    <div class="bloco"> 

                               		<h3>   6) PROMOÇÕES DE FRETE </h3>

                               	              <span class="seta" rel='promoFrete'></span>
                               				   	 <div class="texto" id='promoFrete'>



                                                                           <h2>Frete Grátis para Cidades:</h2>
                                                                              <p>Digite entre Virgulas a lista de UF**CIDADES para promoção de frete grátis.</p>
                                                                              <label for="cidadesFreteGratis"></label>
                                                                              <textarea id="cidadesFreteGratis" name="cidadesFreteGratis"  style="width:50%" ><?php echo $cidadesFreteGratis; ?></textarea>
                                                                              <br/>
                                                                              <span style="font-size:10px">Ex: RJ**Niterói,RJ**São Gonçalo,RJ**Rio Bonito,RJ**Maricá,RJ**Itaboraí</span> 

                                                                              <br/><br/>
																			  
																			  
																			  
																			  
																			  
																			  
																			  
																			  
																			  
											      							   <h4>Marque para excluir da promoção os produtos incluídos nas seguintes categorias : </h4>
							   
<small>Se a compra do usuário possuir produtos de outras categorias, somente será cobrado frete dos produtos incluídos nas categorias marcadas abaixo e que portanto não participam da promoção . </small>
											   								<br/>
											                                   <br/>
											   							   <div class='catcheck'>
											   								   <ul>
								 <?php 
											   								  $arrIds = explode(',' , $arrCatRemovePromoFreteWPSHOP);
											   								  wp_category_checklist(0,0,$arrIds,false,null,false); 
											   								 ?>
											   							     
																			 
																			  </ul>
											   							  </div> 
								 
								 
											   									<br/><br/>
																			  
																			  
																			  
																			  
																			  
																			  
																			  
																			  
																			  
                                                                              <hr/>

                                                                              <h2>Frete Grátis para compras acima de determinado valor:</h2>
                                                                              <p>Digite o valor  da compra mínima para promoção de frete grátis |  UTILIZE  get_option('valorFreteGratis') para colocar o valor em uma variavel de seu site .</p>
                                                                              <label for="valorFreteGratis"></label>
                                                                              R$<input text id="valorFreteGratis" name="valorFreteGratis" class='price'  style="width:50%" value='<?php echo $valorFreteGratis; ?>' />
                                                                              <br/>
                                                                              <span style="font-size:10px">Ex:1.000,00  </span>


                                                                <input type="submit"  name="submit" value="Salvar"   />    
                               		   </div><!-- .texto -->
                               			</div><!-- .bloco -->
                               			
                               			
                               		
									
									
									
									
									
									

	

								        <div class="bloco"> 
										 
										<h3> <input type="checkbox" name="retirarLoja" value="retirarLoja" <?php 
											if($retirarLoja=='retirarLoja'){ echo "CHECKED"; }; ?>  /> Extra)  Permitir que usuário retire os produtos na loja </h3>

									              <span class="seta" rel='retirarLoja'></span>
												   	 <div class="texto" id='retirarLoja'>
		 
		 
		 
								                         <p>Selecione acima para possibilitar que o usuário retire a mercadoria direto na loja </p>

								                  <input type="submit"  name="submit" value="Salvar"   />      
																	
																	
																	
																  
																	
																	
																	
										   </div><!-- .texto -->
											</div><!-- .bloco -->
				
				
				
				
 
			  
		 	 <input type="submit"  name="submit" value="Salvar"   />   
	 
				
				
				
			   <?php if(		$steps == true ){ ?>

			  	 <input type='hidden' name='step' value='<?php echo $step; ?>' />

			  	 <input type="submit"  name="submit" value="Salvar e Prosseguir"  class='btSave'   />   

			  <?php  };  ?>
				
					
 
 
</form>