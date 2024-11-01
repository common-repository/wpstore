<?php
	

$plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));

	

$emailPagseguro = get_option('emailPagseguro');
$tokenPagseguro =  get_option('tokenPagseguro');

$emailGerencianet = get_option('emailGerencianet');
$tokenGerencianet =  get_option('tokenGerencianet');


$emailRedecard =  get_option('emailRedecard');
$filicaoRedecard =  get_option('filicaoRedecard');
$filicaoRedecardGateway =  get_option('filicaoRedecardGateway');

$filiacaoCielo=  get_option('filiacaoCielo'); 
$chaveCielo=  get_option('chaveCielo');
$tipoParcelamentoCielo =  get_option('tipoParcelamentoCielo');
$capturarAutomaticamenteCielo =  get_option('capturarAutomaticamenteCielo');
$indicadorAutorizacaoCielo =  get_option('indicadorAutorizacaoCielo');

  
            $depositoNomeCnpj =get_option('depositoNomeCnpj'); 
            
            $depositoBanco1 = get_option('depositoBanco1'); 
            $depositoAgencia1 =get_option('depositoAgencia1');
            $depositoConta1 = get_option('depositoConta1');
            
            $depositoBanco2 = get_option('depositoBanco2');
            $depositoAgencia2 = get_option('depositoAgencia2'); 
            $depositoConta2 = get_option('depositoConta2');
            
            $depositoMaisInfos = get_option('depositoMaisInfos');
            
            
            $enderecoRetirada = get_option('enderecoRetirada');
            
     
            $ativaPagseguro = get_option('ativaPagseguro');
			$ativaGerencianet = get_option('ativaGerencianet');
			
			
            $ativaCielo = get_option('ativaCielo');
			$ativaAmex = get_option('ativaAmex'); 
            $ativaDeposito = get_option('ativaDeposito ');
            $ativaRetirada= get_option('ativaRetirada');      
            $ativaRetiradaParcial= get_option('ativaRetiradaParcial'); 
			
           $ativaMoip= get_option('ativaMoip');
           $ativaPaypal= get_option('ativaPaypal'); 
           
        

$emailPaypal = get_option('emailPaypal');        
$currentCodePaypal  = get_option('currentCodePaypal');       

$emailMoip = get_option('emailMoip');        
$currentCodePaypal  = get_option('currentCodePaypal');
 
$meuPinMoip = get_option('meuPinMoip');    



$ativaBoleto  = get_option('ativaBoleto');  
$boletoDesconto  = get_option('boletoDesconto');  
$boletoMsg= get_option('boletoMsg');  
	
	
		$caixaCedenteCNPJ= get_option('caixaCedenteCNPJ'); 
		$caixaCedenteNome= get_option('caixaCedenteNome'); 
	$caixaCedenteCodigo= get_option('caixaCedenteCodigo'); 
	$caixaCedenteAgencia= get_option('caixaCedenteAgencia'); 
	$caixaCedenteConta= get_option('caixaCedenteConta'); 
	$caixaCedenteDigito= get_option('caixaCedenteDigito'); 
	
	
	
  	$arrCatRemoveDesconto =  get_option('arrCatRemoveDesconto'); 

	 
	$ativaCybersource = get_option('ativaCybersource'); 
	$ativaCybersourceTeste = get_option('ativaCybersourceTeste'); 
	
	$segmentoEmpresaCieloCYB = get_option('segmentoEmpresaCieloCYB'); 
	$decisaoAltoRiscoCieloCYB = get_option('decisaoAltoRiscoCieloCYB');  
	$decisaoMedioRiscoCieloCYB = get_option('decisaoMedioRiscoCieloCYB'); 
	$decisaoBaixoRiscoCieloCYB = get_option('decisaoBaixoRiscoCieloCYB'); 
	$decisaoErroDadosCieloCYB =get_option('decisaoErroDadosCieloCYB'); 
	$decisaoErroIndisponivelCieloCYB = get_option('decisaoErroIndisponivelCieloCYB'); 
	$valorMinimoConsultaCieloCYB =  get_option('valorMinimoConsultaCieloCYB'); 
      
			if($action==""){              
			$action = verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=lista_pagamentos";
		  };
					
?>    
	<form  id='opcoesPagamento' name='opcoesPagamento' action="<?php echo $action;?>"  method="post" >


    
 
 
 
 
 <?php if(		$steps != true){ ?>
 

    <div id="cabecalho">
    	<ul class="abas">
    		<li>
    			<div class="aba gradient">
    				<span>Configurações de Pagamento</span>
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

<?php }; ?>



    <div id="containerAbas">  



    	<div class="conteudo">







<div class="bloco"> 

		<h3> 
		
        <input type="checkbox" id="ativaPagseguro" name="ativaPagseguro" value="ativaPagseguro"  <?php  if($ativaPagseguro=='ativaPagseguro'){ echo "CHECKED"; }; ?> />  
        1 ) <img src='<?php echo $plugin_directory."images/pagseguro.png "; ?>' />  Pagseguro
        
        </h3>

	              <span class="seta" rel='Pagseguro'></span>
				   	 <div class="texto" id='Pagseguro'>
		   
		   
		   
		   
                         <p>Preencha seus dados do Pagseguro :</p>

                         <p>
                         <label for="emailPagseguro">Pagseguro Email</label>
                         <input type="text" id="emailPagseguro" name="emailPagseguro" value="<?php echo $emailPagseguro; ?>" />
                         </p>

                         <p>
                         <label for="tokenPagseguro">Cole aqui o TOKEN do Pagseguro. </label>
                         <input type="text" id="tokenPagseguro" name="tokenPagseguro" value="<?php echo $tokenPagseguro; ?>" />
												 <small><a href="https://pagseguro.uol.com.br/preferencias/integracoes.jhtml#main-message" target='_blank'>Verifique o Token</a><br/>Após gerar o Token, copie e cole no campo acima.</small>
                         </p>

                         <p>Lembre-se de ATIVAR a opção <strong>Integrações- >Notificações</strong> em sua conta no pagseguro e definir a url de retorno  indicada abaixo : <br/><?php echo get_bloginfo('url'); ?></p>


                 <input type="submit"  name="submit" value="Salvar"   />   

                   
		   </div><!-- .texto -->
			</div><!-- .bloco -->
			
			
			
			
			
			
			
			
			
			
			
			<div class="bloco"> 

					<h3> 
		
			        <input type="checkbox" name="ativaGerencianet" id="ativaGerencianet" value="ativaGerencianet"  <?php  if($ativaGerencianet=='ativaGerencianet'){ echo "CHECKED"; }; ?> />  
			        2 ) <img src='<?php echo $plugin_directory."images/Gerencianet.png "; ?>' />  Gerencianet
        
			        </h3>

				              <span class="seta" rel='Gerencianet'></span>
							   	 <div class="texto" id='Gerencianet'>
		   
		   
		   
		   
			                         <p>Preencha seus dados do Gerencianet :</p>

			                         <p>
			                         <label for="emailGerencianet">Gerencianet Email</label>
			                         <input type="text" id="emailGerencianet" name="emailGerencianet" value="<?php echo $emailGerencianet; ?>" />
			                         </p>

			                         <p>
			                         <label for="tokenGerencianet">Gerencianet TOKEN </label>
			                         <input type="text" id="tokenGerencianet" name="tokenGerencianet" value="<?php echo $tokenGerencianet; ?>" />
			                         </p>

			                         <p>Lembre-se de ATIVAR a opção <strong>Integrações- >Notificações</strong> em sua conta no pagseguro e definir a url de retorno de seu site para :<?php echo get_bloginfo('url'); ?></p>


			                 <input type="submit"  name="submit" value="Salvar"   />   

                   
					   </div><!-- .texto -->
						</div><!-- .bloco -->
			
			
			
			
			
			

 
 
 
 
 
 
 
 
 
 <div class="bloco"> 

 		<h3> 
 		
 		
        <input type="checkbox"  id="ativaMoip" name="ativaMoip" value="ativaMoip"  <?php  if($ativaMoip =='ativaMoip'){ echo "CHECKED"; }; ?> /> 

        3 ) <img src='<?php echo $plugin_directory."images/moip.png "; ?>' /> Moip
        
        </h3>

 	              <span class="seta" rel='Moip'></span>
 				   	 <div class="texto" id='Moip'>



                         <p>Preencha seus dados de integração com o MOIP :</p>

                         <p>
                         <label for="emailMoip">Email Cadastro Moip</label>
                         <input type="text" id="emailMoip" name="emailMoip" value="<?php echo $emailMoip; ?>" />
                         </p>  


                         <p>
                         <label for="meuPinMoip">Crie uma chave de identificação para a URL de confirmação do Moip</label>
                         <input type="text" id="meuPinMoip" name="meuPinMoip" value="<?php echo $meuPinMoip; ?>" />
                         <br/><span> Você usará esta chave para certificar que suas mensagens de autenticação são do MOIP.</span>
                         <br/>  <?php if($meuPinMoip==""){$meuPinMoip = "suachave"; }; ?>
                         <span>Sua url de autenticação  no Moip : http://wpstore.com.br/loja1/?confirmaMoip=<strong><?php echo $meuPinMoip; ?></strong></span>
                         </p>


                  <input type="submit"  name="submit" value="Salvar"   />   

 		   </div><!-- .texto -->
 			</div><!-- .bloco -->
 
 
 
 





<div class="bloco"> 

		<h3>
		
		
        <input type="checkbox" id="ativaPaypal"  name="ativaPaypal" value="ativaPaypal"  <?php  if($ativaPaypal =='ativaPaypal'){ echo "CHECKED"; }; ?> />
				 4 ) 
        
        <img src='<?php echo $plugin_directory."images/paypal.png "; ?>' /> Paypal </h3>

	              <span class="seta" rel='Paypal'></span>
				   	 <div class="texto" id='Paypal'>
		   	  
		   	  
		   	  
		   	  
		   	             <p>Preencha seus dados de integração com o paypal :</p>

                         <p>
                         <label for="emailPaypal">Email Cadastro Paypal</label>
                         <input type="text" id="emailPaypal" name="emailPaypal" value="<?php echo $emailPaypal; ?>" />
                         </p>

                         <p> 

                         <label for="currentCodePaypal">Current CODE</label>    

                         <select  id="currentCodePaypal" name="currentCodePaypal"> 
                         <option value="USD" <?php if($currentCodePaypal=="USD"){ echo "SELECTED"; }; ?> >USD - American Dollars</option>
                         <option value="BRL" <?php if($currentCodePaypal=="BRL"){ echo "SELECTED"; };  ?> >BRL - Real Brasileiro</option> 
                         </select>  

                         </p>


                    <input type="submit"  name="submit" value="Salvar"   />   
                   
		   </div><!-- .texto -->
			</div><!-- .bloco -->
			
			
 
 
 



 





 
 
 <div class="bloco"> 

 		<h3> <input type="checkbox" id="ativaCielo" name="ativaCielo" value="ativaCielo"  <?php  if($ativaCielo=='ativaCielo'){ echo "CHECKED"; }; ?> /> 

        5 ) <img src='<?php echo $plugin_directory."images/cielo.png "; ?>' /> Cielo </h3>

 	              <span class="seta" rel='Cielo'></span>
 				   	 <div class="texto" id='Cielo'>
 		   
 		   
 		
 		   
 		                 <p>Preencha seus dados de integração com a Cielo :</p>

                         <p>
                         <label for="emailCielo">Numero Filiação</label>
                         <input type="text" id="filiacaoCielo" name="filiacaoCielo" value="<?php echo $filiacaoCielo; ?>" />
                         </p>

                         <p>
                         <label for="chaveCielo">Chave</label>
                         <input type="text" id="chaveCielo" name="chaveCielo" value="<?php echo $chaveCielo; ?>" />
                         </p>




                         <table>
                         						<tbody><tr>
                         							<td>
                         								Parcelamento
                         							</td>
                         							<td><?php //echo $tipoParcelamentoCielo; ?>
                         								<select name="tipoParcelamentoCielo">
                         									<option value="2" <? if($tipoParcelamentoCielo=='2'){ echo 'selected="selected" '; }; ?> >Loja</option>
                         									<option value="3"  <? if($tipoParcelamentoCielo=='3'){ echo 'selected="selected" '; }; ?> >Administradora</option>
                         								</select>
                         							</td>
                         						</tr>
                         						<tr>
                         							<td>Capturar Automaticamente?</td>
                         							<td><?php //echo $capturarAutomaticamenteCielo; ?>
                         								<select name="capturarAutomaticamenteCielo">
																						<option value="false"  <? if($capturarAutomaticamenteCielo=='false'){ echo 'selected="selected" '; }; ?> >Não</option>
                         									<option value="true"  <? if($capturarAutomaticamenteCielo=='true'){ echo 'selected="selected" '; }; ?> >Sim</option>
                         								
                         								</select>
                         							</td>
                         						</tr>
                         						<tr>
                         							<td>Autorização Automática</td>
                         							<td><?php //echo $indicadorAutorizacaoCielo; ?>
                         								<select name="indicadorAutorizacaoCielo">
																					
																						<option value="1" <? if($indicadorAutorizacaoCielo=='1'){ echo 'selected="selected" '; }; ?> >Autorizar transação somente se autenticada</option>
																						
                         									<option value="3" <? if($indicadorAutorizacaoCielo=='3'){ echo 'selected="selected" '; }; ?> >Autorizar Direto</option>
                         									<option value="2" <? if($indicadorAutorizacaoCielo=='2'){ echo 'selected="selected" '; }; ?> >Autorizar transação autenticada e não-autenticada</option>
                         									<option value="0" <? if($indicadorAutorizacaoCielo=='0'){ echo 'selected="selected" '; }; ?> >Somente autenticar a transação</option>
                         								
                         								</select>
                         							</td>
                         						</tr>
												
												<tr>
													<td>   
											 
														<input type="checkbox" name="ativaAmex" value="ativaAmex"  <?php  if($ativaAmex=='ativaAmex'){ echo "CHECKED"; }; ?> />   Habilitar Compras com bandeira American Express
												    </td>
											    </tr>
												
												
												
												
												<tr>
													<td>   
											 
														<input type="checkbox" name="ativaCybersource" value="ativaCybersource"  <?php  if($ativaCybersource=='ativaCybersource'){ echo "CHECKED"; }; ?> />Habilitar CIELO CYBERSOURCE (PROGRAMA ANTIFRAUDE ) - <small>Antes de habilitar entre em contato com a CIELO para se inscrever e  consultar a tarifa adicional do serviço</small><br/><br/>
		<p>Dados de configuração CyberSource:</p>
		<br/>
		
		
        <p>
        <label for="segmentoEmpresaCieloCYB">Segmento da Empresa</label>
        <input type="text" id="segmentoEmpresaCieloCYB" name="segmentoEmpresaCieloCYB" value="<?php echo $segmentoEmpresaCieloCYB; ?>" /><br/>
		<small>Ex: Venda Material Hospitalar</small>
        </p>
		<br/><br/>

        <p>
        <label for="valorMinimoConsultaCieloCYB">Definir Valor Mínimo da compra para realizar  Consulta Antifraude: </label><br/>
        R$<input type="text" id="valorMinimoConsultaCieloCYB" name="valorMinimoConsultaCieloCYB" value="<?php echo $valorMinimoConsultaCieloCYB; ?>" /><br/>
		<small>Ex: 1.000,00 </small>
        </p>
		<br/><br/>
		
		
		<p> Decisão de captura no retorno do CIELO CYBERSOURCE:</p>
		<br/>
		<p>
			Alto Risco : 
		    <select name="decisaoAltoRiscoCieloCYB">
				
			<option value="desfazer" <? if($decisaoAltoRiscoCieloCYB=='desfazer'){ echo 'selected="selected" '; }; ?> >desfazer</option>
			
			<option value="amp" <? if($decisaoAltoRiscoCieloCYB=='amp'){ echo 'selected="selected" '; }; ?> >Ação Manual Posterior (amp)</option>
			
		     </select>	
		</p>
		
		
		<p>
			Médio Risco : 
		    <select name="decisaoMedioRiscoCieloCYB">
				
			<option value="desfazer" <? if($decisaoMedioRiscoCieloCYB=='desfazer'){ echo 'selected="selected" '; }; ?> >desfazer</option>
			
				<option value="capturar" <? if($decisaoMedioRiscoCieloCYB=='capturar'){ echo 'selected="selected" '; }; ?> >capturar</option>
				
			
			<option value="amp" <? if($decisaoMedioRiscoCieloCYB=='amp'){ echo 'selected="selected" '; }; ?> >Ação Manual Posterior (amp)</option>
			
		     </select>	
		</p>
		
		
		
		<p>
			 Baixo Risco : 
		    <select name="decisaoBaixoRiscoCieloCYB">
				
		 <option value="capturar" <? if($decisaoBaixoRiscoCieloCYB=='capturar'){ echo 'selected="selected" '; }; ?> >capturar</option>
				
			
			<option value="amp" <? if($decisaoBaixoRiscoCieloCYB=='amp'){ echo 'selected="selected" '; }; ?> >Ação Manual Posterior (amp)</option>
			
		     </select>	
		</p>
		
		
		
		<p>
			Erro de dados  : 
		    <select name="decisaoErroDadosCieloCYB">
				
			<option value="desfazer" <? if($decisaoErroDadosCieloCYB=='desfazer'){ echo 'selected="selected" '; }; ?> >desfazer</option>
			
				<option value="capturar" <? if($decisaoErroDadosCieloCYB=='capturar'){ echo 'selected="selected" '; }; ?> >capturar</option>
				
			
			<option value="amp" <? if($decisaoErroDadosCieloCYB=='amp'){ echo 'selected="selected" '; }; ?> >Ação Manual Posterior (amp)</option>
			
		     </select>	
		</p>
		
		
		
		<p>
			Erro de indisponibilidade : 
		    <select name="decisaoErroIndisponivelCieloCYB">
				
			<option value="desfazer" <? if($decisaoErroIndisponivelCieloCYB=='desfazer'){ echo 'selected="selected" '; }; ?> >desfazer</option>
			
				<option value="capturar" <? if($decisaoErroIndisponivelCieloCYB=='capturar'){ echo 'selected="selected" '; }; ?> >capturar</option>
				
			
			<option value="amp" <? if($decisaoErroIndisponivelCieloCYB=='amp'){ echo 'selected="selected" '; }; ?> >Ação Manual Posterior (amp)</option>
			
		     </select>	
		</p>
		
		<br/>	<br/>
		
		
		<p>
		<input type="checkbox" name="ativaCybersourceTeste" value="ativaCybersourceTeste"  <?php  if($ativaCybersourceTeste=='ativaCybersourceTeste'){ echo "CHECKED"; }; ?> />Ativar em modo de teste : <small>Só ativar para   pedidos de usuário administrador </small><br/><br/>
	</p>
		
		
 
		
												    </td>
											    </tr>
												
												
                         					</tbody></table>
                         					
                         					
                         					

                   <input type="submit"  name="submit" value="Salvar"   />   


 		   </div><!-- .texto -->
 			</div><!-- .bloco -->
 			
 			
 			
			
			



         
   
       <div class="bloco"> 
          
				<h3>
				
				 <input type="checkbox" name="ativaDeposito" value="ativaDeposito"  <?php  if($ativaDeposito=='ativaDeposito'){ echo "CHECKED"; }; ?> /> 

             6 )      <img src='<?php echo $plugin_directory."images/deposito.png "; ?>' /> Depósito bancário
                
                </h3>

			              <span class="seta" rel='Deposito'></span>
   						   	
   						  <div class="texto" id='Deposito'>
   						   	 
			              
			              
			              <p>Preencha seus dados bancários para depósito :</p>


                          <p>
                          <label for="depositoNomeCnpj">Nome / CNPJ</label>
                          <input type="text" id="depositoNomeCnpj" name="depositoNomeCnpj" value="<?php echo $depositoNomeCnpj; ?>" />
                          </p>


depositoNomeCnpj depositoBanco1 depositoAgencia1 depositoConta1

                          <p>
                          <label for="depositoBanco1">Opção Banco 1</label>
                          <input type="text" id="depositoBanco1" name="depositoBanco1" value="<?php echo $depositoBanco1; ?>" />
                          </p>

                          <p>
                          <label for="depositoAgencia1">Opção Agência 1</label>
                          <input type="text" id="depositoAgencia1" name="depositoAgencia1" value="<?php echo $depositoAgencia1; ?>" />
                          </p>


                          <p>
                          <label for="depositoConta1">Opção Conta 1</label>
                          <input type="text" id="depositoConta1" name="depositoConta1" value="<?php echo $depositoConta1; ?>" />
                          </p>



                          <p>
                          <label for="depositoBanco2">Opção Banco 2</label>
                          <input type="text" id="depositoBanco2" name="depositoBanco2" value="<?php echo $depositoBanco2; ?>" />
                          </p>

                          <p>
                          <label for="depositoAgencia2">Opção Agência 2</label>
                          <input type="text" id="depositoAgencia2" name="depositoAgencia2" value="<?php echo $depositoAgencia2; ?>" />
                          </p>


                          <p>
                          <label for="depositoConta2">Opção Conta 2</label>
                          <input type="text" id="depositoConta2" name="depositoConta2" value="<?php echo $depositoConta2; ?>" />
                          </p>


                          <p>
                          <label for="depositoMaisInfos">Mais Informações:</label><br/>
                          <textarea id="depositoMaisInfos" name="depositoMaisInfos"  style="width:50%" >
                          <?php echo $depositoMaisInfos; ?>
                          </textarea>
                          </p>
                          
                          

                       <input type="submit"  name="submit" value="Salvar"   />   

                             
				   </div><!-- .texto -->
					</div><!-- .bloco -->
   
   





                           <div class="bloco">




                 				<h3> <input type="checkbox" name="ativaRetirada" value="ativaRetirada"  <?php  if($ativaRetirada=='ativaRetirada'){ echo "CHECKED"; }; ?> />     7 )
                 				 <img src='<?php echo $plugin_directory."images/retirada.png "; ?>' /> Pagar na Loja </h3>

                 			              <span class="seta" rel='Retirada'></span>
                 						   	 <div class="texto" id='Retirada'>
                 				   	    	 <p>Preencha abaixo os dados e mensagem para reserva com  pagamento e  retirada de produtos na loja  :</p>
                               	    	 <p>
                 				      	     <label for="enderecoRetirada">Endereço e infos para retirada:</label><br/>
                 				      	 <textarea id="enderecoRetirada" name="enderecoRetirada"  style="width:50%" ><?php echo $enderecoRetirada; ?></textarea>
                 				      	 </p>
										 
										 
										 <p>
											 <input type="checkbox" name="ativaRetiradaParcial" value="ativaRetiradaParcial"  <?php  if($ativaRetiradaParcial=='ativaRetiradaParcial'){ echo "CHECKED"; }; ?> />
											 Permitir a opção retirada somente para alguns usuários, marque somente esta opção e confirme na aba Usuários os perfis que devem ter acesso a este recurso. (Não marque a opção principal neste caso)</p>
										 <br/>

                                     <input type="submit"  name="submit" value="Salvar"   />   


                 				   </div><!-- .texto -->
                 					</div><!-- .bloco -->




                           <div class="bloco">






               				<h3> <input type="checkbox" name="ativaBoleto" value="ativaBoleto"  <?php  if($ativaBoleto=='ativaBoleto'){ echo "CHECKED"; }; ?> />     8 )
               				 <img src='<?php echo $plugin_directory."images/boleto.png "; ?>' /> Boleto Bancário</h3>

               			            <span class="seta" rel='Boleto'></span>
               						   	 <div class="texto" id='Boleto'>
               				   	  
									<p>Mensagem / instrução Extra para pagamentos com Boleto:</p>
                              	    <p>
                				        <input type="text" id="boletoMsg" name="boletoMsg" value="<?php echo $boletoMsg; ?>" />
 									 </p>
									 
									 <br/><br/>
									 
									 <h3>Caixa Econômica</h3>
									  <br/>
 									<p>
									  <label for="caixaCedenteNome">Nome do Cedente</label>
									</p>
									
									
                               	     <p>
                 				        <input type="text" id="caixaCedenteNome" name="caixaCedenteNome" value="<?php echo $caixaCedenteNome; ?>" />
  									 </p>
									 <small>Nome da loja . Máximo de 40 caracteres.</small>
									 <br/><br/>
									 
									 
 									  
  									<p> <label for="caixaCedenteCNPJ">CNPJ</label></p>
                                	     <p>
                  				        <input type="text" id="caixaCedenteCNPJ" name="caixaCedenteCNPJ" value="<?php echo $caixaCedenteCNPJ; ?>" />
   									 </p>
 									 <small>CNPJ.</small>
 									 <br/><br/>
									 
									 
									 
  									<p><label for="caixaCedenteCodigo">Código do Cedente</label></p>
                                	 <p>
                  				        <input type="text" id="caixaCedenteCodigo" name="caixaCedenteCodigo" value="<?php echo $caixaCedenteCodigo; ?>" />
									 </p>
									 <small>Código do cedente sem o dígito verificador para exibição no boleto- Campo numérico com tamanho máximo de 6 dígitos - ex: 000170 </small>
									 
 									 <br/><br/>
									 
   									<p><label for="caixaCedenteAgencia">Agência</label></p>
  									 <p>
                  				        <input type="text" id="caixaCedenteAgencia" name="caixaCedenteAgencia" value="<?php echo $caixaCedenteAgencia; ?>" />
   									 </p>
									 <small>Código da agência de vinculação sem o dígito verificador - Campo numérico com tamanho máximo de 4 dígitos  - ex:1679</small>
									 
									 <br/>
									 
									 
									  									 <br/><br/>
									 
									    									<p><label for="caixaCedenteConta">Conta</label></p>
									   									 <p>
									                   				        <input type="text" id="caixaCedenteConta" name="caixaCedenteConta" value="<?php echo $caixaCedenteConta; ?>" />
									    									 </p>
									 									 <small>Conta. Sem DV.</small>
									 <br/><br/>
									 
									 
									 
									  									 <br/><br/>
									 
									    									<p><label for="caixaCedenteDigito">CONTA DV</label></p>
									   									 <p>
									                   				        <input type="text" id="caixaCedenteDigito" name="caixaCedenteDigito" value="<?php echo $caixaCedenteDigito; ?>" />
									    									 </p>
									 									 <small>Digito conta: - ex:1</small>
									 <br/><br/>
									 
	
	
	       <h3>DESCONTO BOLETO</h3>
	        <br/>
	   	    <p>Percentual de desconto   para compras feitas via boleto:</p>
			

		 
        	    <p>
	        <input type="text" id="boletoDesconto" name="boletoDesconto" value="<?php echo $boletoDesconto; ?>" />
			 </p>
			 
			 
			     <br/>
		  <h4>Não exibir desconto nos produtos das seguintes categorias  : </h4>
	   
		 
		 	<br/>
		 	<br/>
		 	<div class='catcheck'>
		 			 <ul>
		 			 <?php 
		 
		 			 $arrIds = explode(',' , $arrCatRemoveDesconto);
    wp_category_checklist(0,0,$arrIds,false,null,false); 
		 			 ?>
					 </ul>
		 	 </div> 
			 <br/><br/>
			 
		
	 


               				   </div><!-- .texto -->
               					</div><!-- .bloco -->
                              


 
			  
	 <input type="submit"  name="submit" value="Salvar"   />   
	 
	 
	 

  <?php if(		$steps == true ){ ?>
	   
 	 <input type='hidden' name='step' value='<?php echo $step; ?>' />
 
 	 <input type="submit"  name="submit" value="Salvar e Prosseguir"  class='btSave'   />   
	 
 <?php  };  ?>
 

</form>