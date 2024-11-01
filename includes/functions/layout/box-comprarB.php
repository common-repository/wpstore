<?php  



      $moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
         if($moedaCorrente==""){
             $moedaCorrente = "R$" ; 
           };  
      
$urlImgM =  "".get_option('imagemTabelaWPSHOP');;  
$exibirTabela =  "".get_option('exibirTabelaWPSHOP');

$parcelaMinima=  get_parcelaMinima(); 
$totalParcela = get_totalParcela();         

$txtParcelamentoJuros = get_option('txtParcelamentoJurosWPSHOP');   
if($txtParcelamentoJuros==""){
   $txtParcelamentoJuros = "sem juros* no cartão"; 
}


$txtEscolhaCorProduto= get_option('txtEscolhaCorProdutoWPSHOP');   
if($txtEscolhaCorProduto==""){
   $txtEscolhaCorProduto = "Cor do Produto :"; 
}
 
 
 
 $txtEscolhaTamanhoProduto= get_option('txtEscolhaTamanhoProdutoWPSHOP');   
 if( $txtEscolhaTamanhoProduto==""){
    $txtEscolhaTamanhoProduto= "Tamanho do Produto :"; 
 }
 
    
 $txtComprarBtProduto= get_option('txtComprarBtProdutoWPSHOP');   
 if( $txtComprarBtProduto==""){
    $txtComprarBtProduto= "Comprar"; 
 }          

 $txtAdicionarBtProduto= get_option('txtAdicionarBtProdutoWPSHOP');   
 if( $txtAdicionarBtProduto==""){
    $txtAdicionarBtProduto= "Adicionar ao Carrinho"; 
 }
 
 
 $txtprodutoIndisponivel= get_option('txtprodutoIndisponivelWPSHOP');   
  if( $txtprodutoIndisponivel==""){
     $txtprodutoIndisponivel= "Produto Indisponível."; 
  }     
  
  $txtprodutoAvisarChegar= get_option('txtprodutoAvisarChegarWPSHOP');   
   if( $txtprodutoAvisarChegar==""){
      $txtprodutoAvisarChegar= "Avisar quando chegar?"; 
   }     

    $txtprodutoEnviarFormContato= get_option('txtprodutoEnviarFormContatoWPSHOP');   
    if( $txtprodutoEnviarFormContato==""){
       $txtprodutoEnviarFormContato= "Enviar."; 
    } 
    
    $txtprodutoNomeFormContato= get_option('txtprodutoNomeFormContatoWPSHOP');   
    if( $txtprodutoNomeFormContato==""){
       $txtprodutoNomeFormContato= "Digite seu Nome"; 
    }
    
    
    $txtprodutoEMailFormContato= get_option('txtprodutoEmailFormContatoWPSHOP');   
    if( $txtprodutoEmailFormContato==""){
       $txtprodutoEmailFormContato= "Email para contato "; 
    }    
       
     $txtSelecioneParcela= get_option('txtSelecioneParcelaWPSHOP');   
    if( $txtSelecioneParcela==""){
       $txtSelecioneParcela= "Selecione a quantidade de Produtos "; 
    }
 
 
?>
  <input type="hidden" name='tabelaMedidas' id="tabelaMedida" value="<?php echo $urlImgM; ?>" />

<div >


 
		<?php
		/*========================================BOTAO COR  ===================================
		========================================BOTAO COR   ===================================
			========================================BOTAO COR ===================================*/
	    include('botaoCor.php'); 
	 	/*========================================BOTAO COR   ===================================
	 	========================================BOTAO COR  ===================================
	 		========================================BOTAO COR  ===================================*/
		 ?>
		

<?php  if( intval($fivesdraftsCor) >0){     ?> 
	
	 
	
	<?php
	/*========================================BOTAO COR TAMANHO ===================================
	========================================BOTAO COR TAMANHO ===================================
		========================================BOTAO COR TAMANHO ===================================*/
	 include('botaoCorTamanho.php'); 
 	/*========================================BOTAO COR TAMANHO ===================================
 	========================================BOTAO COR TAMANHO ===================================
 		========================================BOTAO COR TAMANHO ===================================*/
	 ?>
	
	
		    
<?php }else{ // se não existe cor -------------------------------------  ?>
  
  
  
  
   <?php
   
    /*========================================BOTAO TAMANHO ===================================
  	========================================BOTAO TAMANHO===================================
  	========================================BOTAO TAMANHO===================================*/
   
    include('botaoTamanho.php');
	
   	/*========================================BOTAO TAMANHO ===================================
   	=======================================BOTAO TAMANHO===================================
    ========================================BOTAO TAMANHO===================================*/
	  ?>
	  
	  
   
<?php }; ?>
  
     

		<div class="clear"></div>
		<br/>
		     

		<p class="indisp" style="background:#ddd;padding:10px" >Produto Indisponível.  <br/>
	    
	    
		<?php  if($showButtom ==true){ ?>   
		
		<span style="font-size:0.8em">Avisar quando chegar?</span>
           <br/>
           Digite seu Nome:<input type="text" id="nomeAviso" value="Digite seu Nome" title="Digite seu Nome" /> <br/>
   		   Email para contato:<input type="text" id="emailAviso"  value="Digite seu Email" title="Digite seu Email"  />
		     <br/>
		   Telefone para contato:<input type="text" id="telefoneAviso"  value="Telefone com ddd" title="Telefone com ddd"  />
		   
   		<br/><br/>
   			<a href="#"  class="btAviso" >Enviar.</a>  
   			
   			
    		<?php }; ?>


		</p>  
 
 
                <?php 
                
                $variacaoEscolhida = '';
                
                
                       
                          

                            $preco=custom_get_price($postID); 
							if(strlen($preco)<=4){
								$preco= floatval(str_replace(',','.',$preco));
							}
							
                            $precoS = custom_get_specialprice($postID);
							if(strlen($precoS)<=4){
								$precoS=  floatval(str_replace(',','.',$preco));
							}
                    
                   
                if( intval($fivesdraftsCor) || intval($fivesdraftsTamanho) ){  ?>
                   
                 
                   
                   
                   
                   
                   
 	              	<div class="clear"></div>
 	         
  
                       
                       
                       
                       
 <?php $exibeQtdProd = get_option('exibeQtdProd');
                                                                                                                  if($exibeQtdProd  =="sim"){ ?>
 <p class='quantidade'> <label for='qtdProd'> <?php echo $txtSelecioneParcela; ?>:</label>  <input type='text' class='somenteNumeros'  name='qtdProd' id='qtdProd' value='1' style='width:30px' /> </p>
     <?php  }; ?>


                                              
						
						
						



                        <a href="#" title="Comprar <?php the_title(); ?>" class="btComprar" >
                            <span itemprop="availability" content="in_stock"><?php echo $txtAdicionarBtProduto; ?></span>
                        </a> 
                        <p  class="msg"><span style="color:red"> </span></p>  
                        
                        
                        
                    	
                    
<?php }else{ 
	
	
	$variacaoEscolhida = 'unico'; ?>
 
               
			   
			   <?php
			   
		   	/*========================================BOTAO COR UNICO ===================================
		   	========================================BOTAO COR UNICO===================================
		   		========================================BOTAO COR UNICO===================================*/
			   
			    include('botaoUnico.php');
				
				/*========================================BOTAO COR UNICO ===================================
				========================================BOTAO COR UNICO===================================
					========================================BOTAO COR UNICO ===================================*/
				
				
				 ?>
			  
	 <?php  }; ?> 
 
       		<input type="hidden" name="idP" id="idP" value="<?php echo $postID; ?>" />

  <?php /**/ ?>
		<br/>
   </div><!-- .variacoes -->
 