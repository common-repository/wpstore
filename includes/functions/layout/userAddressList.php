<p class='msg'></p>   

<div  id="contentAdressList">  
    
<?php 

$contAddress = 0;  
 $addrCob = get_id_addr_cobranca($idUser);  
foreach ( $userAddress as $address ){
    $contAddress +=1;  
    
    $cep =  explode('-',$address->cep);
    $cepUm =  $cep[0];
    $cepDois =  $cep[1];   
?>
         <div class="enderecoC" id='end<?php echo $address->id; ?>' >   
                 
                   <h4 ><span  id="nomeEndereco<?php echo $address->id; ?>" class='tituloEndereco'><?php echo $address->nomeEndereco; ?></span></h4> 
                     
                   <ul class="dados"> 
                       <li  >Destinatário:<span id="destinatarioEndereco<?php echo $address->id; ?>"  ><?php echo $address->destinatarioEndereco; ?></span></li>
                       <li  >  
                       <span id="endereco<?php echo $address->id; ?>" ><?php echo $address->endereco; ?></span>
                       <span id="numero<?php echo $address->id; ?>" ><?php echo $address->numero; ?></span> 
                       <span id="bairro<?php echo $address->id; ?>" ><?php echo $address->bairro; ?></span>
					   
					     <span id="complemento<?php echo $address->id; ?>" ><?php echo $address->complemento; ?></span>
						 
                       <span id="cidade<?php echo $address->id; ?>" ><?php echo $address->cidade; ?></span> - <span id="estado<?php echo $address->id; ?>" ><?php echo $address->estado; ?> </span>
                         - CEP :<span id="cepUm<?php echo $address->id; ?>" ><?php echo $cepUm; ?></span> <span id="cepDois<?php echo $address->id; ?>" ><?php echo $cepDois; ?></span></li>
                       <li class='hide'>Tipo: <span id="tipoEndereco<?php echo $address->id; ?>" ><?php echo $address->tipoEndereco; ?></span></li>
					   
                       <li >Referência: <span id="referencia<?php echo $address->id; ?>" ><?php echo $address->referencia; ?> </span></li>
                      
                        <span id="definirCobranca<?php echo $address->id; ?>" rel='<?php echo $address->id; ?>' class="red" >- 
							
							<small class='endCob cob<?php echo $address->id; ?>'>
							 
							<?php 
							/*
							if( $addrCob == $address->id ){ 
								echo "Escolhido como endereço de cobrança."; 
							
							
							};  
							*/
							?>
								 
								 </small> </span>
                       
                       </ul>

                   
				   <?php
				   	
                   global $current_user;
                   get_currentuserinfo();
                   $idUserCurrent = $current_user->ID;
				   
				   if( $idUser == $idUserCurrent){
				   ?>


                   <div class="botaoEntrega" rel='<?php echo $address->id; ?>' >
                       <p>Confirmar este  Endereço para a entrega</p>
                       <span>Utilizar esta opção de entrega.</span>
                       <span>Prazo de entrega. Entre 1 e 10 dia(s) útil(eis).</span>
                   </div>
              

                   <ul class="editarEnd">
                       <li class="botaoEditarEnd" rel='<?php echo $address->id; ?>'>Editar |</li>
                       <li class="botaoExcluirEnd"  rel='<?php echo $address->id; ?>' >Excluir</li>
                       <div class="clear"></div>
                   </ul>
				   <?php }; ?>
				   
				   

          </div><!-- .endereco -->
                 
<?php    };  ?>  
<?php if($contAddress==0){  $_SESSION['exibirFormEnd'] = 'SIM'; ?>        
    
              <p>Ainda não há endereços cadastrados.</p>   
			  
    

		   
    
<?php    };  ?>   

</div>  <!-- #contentAdressList -->     
 