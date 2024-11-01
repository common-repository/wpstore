<?php
 
 
if ( current_user_can( 'manage_options' ) ) {
    /* A user with admin privileges */
} else {
    $urlR = verifyURL(get_bloginfo('url')).'/wp-admin';
	echo '<script>window.location = "'.$urlR.'";</script>';
}
 
   if( $_POST['submit']=="Salvar" ){
         
         $tipoImposto = trim($_POST['tipoImposto']);
         add_option('tipoImposto',$tipoImposto,'','yes'); 
         update_option('tipoImposto',$tipoImposto);
 
          
         $impostoNome1 = trim($_POST['impostoNome1']);
          add_option('impostoNome1',$impostoNome1 ,'','yes'); 
          update_option('impostoNome1',$impostoNome1 );
          
          
         $impostoPercetual1 = trim($_POST['impostoPercetual1']);
         add_option('impostoPercetual1',$impostoPercetual1,'','yes'); 
         update_option('impostoPercetual1',$impostoPercetual1);
         
         
            $impostoNome2 = trim($_POST['impostoNome2']);
               add_option('impostoNome2',$impostoNome2 ,'','yes'); 
               update_option('impostoNome2',$impostoNome2 );


              $impostoPercetual2 = trim($_POST['impostoPercetual2']);
              add_option('impostoPercetual2',$impostoPercetual2,'','yes'); 
              update_option('impostoPercetual2',$impostoPercetual2);
              
              
                 $impostoNome3 = trim($_POST['impostoNome3']);
                    add_option('impostoNome3',$impostoNome3 ,'','yes'); 
                    update_option('impostoNome3',$impostoNome3 );


                   $impostoPercetual3 = trim($_POST['impostoPercetual3']);
                   add_option('impostoPercetual3',$impostoPercetual3,'','yes'); 
                   update_option('impostoPercetual3',$impostoPercetual3);
                   
                   
                      $impostoNome4 = trim($_POST['impostoNome4']);
                         add_option('impostoNome4',$impostoNome4 ,'','yes'); 
                         update_option('impostoNome4',$impostoNome4 );


                        $impostoPercetual4 = trim($_POST['impostoPercetual4']);
                        add_option('impostoPercetual4',$impostoPercetual4,'','yes'); 
                        update_option('impostoPercetual4',$impostoPercetual4);
						
						
			
                        $impostoAddTexto = trim($_POST['impostoAddTexto']);
                        add_option('impostoAddTexto',$impostoAddTexto,'','yes'); 
                        update_option('impostoAddTexto',$impostoAddTexto);
						
                        $impostoAddPct = trim($_POST['impostoAddPct']);
                        add_option('impostoAddPct',$impostoAddPct,'','yes'); 
                        update_option('impostoAddPct',$impostoAddPct);
						
                        $impostoAddRegiao= trim($_POST['impostoAddRegiao']);
                        add_option('impostoAddRegiao',$impostoAddRegiao,'','yes'); 
                        update_option('impostoAddRegiao',$impostoAddRegiao);
 
						
 
    };


$tipoImposto = get_option('tipoImposto');
 
$impostoNome1 = get_option('impostoNome1');
$impostoPercetual1 = get_option('impostoPercetual1');

$impostoNome2 = get_option('impostoNome2');
$impostoPercetual2 = get_option('impostoPercetual2');

$impostoNome3 = get_option('impostoNome3');
$impostoPercetual3 = get_option('impostoPercetual3');

$impostoNome4 = get_option('impostoNome4');
$impostoPercetual4 = get_option('impostoPercetual4');


$impostoAddTexto = get_option('impostoAddTexto');
$impostoAddPct = get_option('impostoAddPct');
$impostoAddRegiao = get_option('impostoAddRegiao');
	
	
?>

 
    
<form action="<?php echo verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=lista_impostos";?>"  method="post" >

 
 
 
 
 
 
 
 
 
 <div id="cabecalho">
 	<ul class="abas">
 		<li>
 			<div class="aba gradient">
 				<span>Impostos</span>
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
		
		<h3>1) Adicionar e exibir valor e impostos </h3>
		
		<span class="seta" rel='adicionarexibir'></span>
		<div class="texto" id='adicionarexibir'>
		
		    <p><input name="tipoImposto" value="impostoZero" type="radio"  <?php if($tipoImposto=="impostoZero"){ echo "CHECKED"; }; ?>  >Não adicionar impostos   </p>

               <p> <input name="tipoImposto" value="impostoCheckout"  type="radio" <?php if($tipoImposto=="impostoCheckout"){ echo "CHECKED"; }; ?> >Adicionar  Impostos ao valor total  da compra  </p>
        
			   
               <input type="submit"  name="submit" value="Salvar"   />
		</div>
	</div><!-- .bloco -->
	
	
	
	
     
 
 	
 	<div class="bloco">      
		
		<h3>2) Definir Tributos e Percentuais </h3>
		
		<span class="seta" rel='definirTrib'></span>
		<div class="texto" id='definirTrib'>
		
		   
		   
		    <p>Tributo 1 <br/>
            <input type="text" id="impostoNome1" name="impostoNome1" value="<?php echo $impostoNome1; ?>" style="width:20%"/> 
            <br/>
            <span style="font-size:11px">Ex: ICMS,ISS,IPI </strong>  </span>
            </p> 

            <p>Taxa Tributo 1<br/> 
             <input type="text" id="impostoPercetual1" name="impostoPercetual1" value="<?php echo $impostoPercetual1; ?>" style="width:20%"/>
             %<br/>
             <span style="font-size:11px">Ex: 27  - O produto ou carrinho terá seu valor acrescido de acordo com  percentual indicado. </strong>  </span>
             </p>

             <hr/>


             <p>Tributo 2 <br/>
               <input type="text" id="impostoNome2" name="impostoNome2" value="<?php echo $impostoNome2; ?>" style="width:20%"/> 
               <br/>
               <span style="font-size:11px">Ex: ICMS </strong>  </span>
               </p> 

               <p>Taxa Tributo 2<br/>
                <input type="text" id="impostoPercetual2" name="impostoPercetual2" value="<?php echo $impostoPercetual2; ?>" style="width:20%"/>
                %<br/>
                <span style="font-size:11px">Ex: 11   - O produto ou carrinho terá seu valor acrescido de acordo com  percentual indicado. </strong>  </span>
                </p>

                <hr/>


                <p>Tributo 3 <br/>
                  <input type="text" id="impostoNome3" name="impostoNome3" value="<?php echo $impostoNome3; ?>" style="width:20%"/> 
                  <br/>
                  <span style="font-size:11px">Ex:  ISS </strong>  </span>
                  </p> 

                  <p>Taxa Tributo 1<br/>
                   <input type="text" id="impostoPercetual3" name="impostoPercetual3" value="<?php echo $impostoPercetual3; ?>" style="width:20%"/>
                   %<br/>
                   <span style="font-size:11px">Ex:9  - O produto ou carrinho terá seu valor acrescido de acordo com  percentual indicado. </strong>  </span>
                   </p>

                   <hr/>


                   <p>Tributo 4 <br/>
                     <input type="text" id="impostoNome4" name="impostoNome4" value="<?php echo $impostoNome4; ?>" style="width:20%"/> 
                     <br/>
                     <span style="font-size:11px">Ex:  IPI </strong>  </span>
                     </p> 

                     <p>Taxa Tributo 1<br/>
                      <input type="text" id="impostoPercetual4" name="impostoPercetual4" value="<?php echo $impostoPercetual4; ?>" style="width:20%"/>
                     % <br/>
                      <span style="font-size:11px">Ex: 11   - O produto ou carrinho terá seu valor acrescido de acordo com  percentual indicado. </strong>  </span>
                      </p>

                      <hr/>
                      
                      
                  
                      <input type="submit"  name="submit" value="Salvar"   />    
			  
		</div>
	</div><!-- .bloco -->
 







 	
 	
 	<div class="bloco">      
		
		<h3>3) Opções Extras  </h3>
		
		<span class="seta" rel='extrasexibir'></span>
		<div class="texto" id='extrasexibir'>
			
			
			<h2>Cobrança de Imposto Adicional para entrada de mercadorias por transportadora  em determinada região (estado)</h2>
			
		<br/><br/>
                     <p>3.1) Especifique o nome da taxa / imposto <br/>
                      <input type="text" id="impostoAddTexto" name="impostoAddTexto" value="<?php echo $impostoAddTexto; ?>" />
                      <br/>
                      <span style="font-size:11px">Ex: Imposto sobre entrada de mercadorias no estado . </strong>  </span>
                      </p>
					
				<br/><br/>	
					
          <p> 3.2)Especifique a porcentagem incidente do imposto.<br/>
           <input type="text" id="impostoAddPct" name="impostoAddPct" value="<?php echo $impostoAddPct; ?>" style="width:20%"/> %
           <br/>
           <span style="font-size:11px">Ex: Coloque o valor  10 para  um desconto de 10% .  Lembre que o imposto será adicionado ao valor total da Nota. </strong>  </span>
           </p>
					 
					 
					 
					 <br/><br/>
					 
                     <p>3.3)Especifique a Região em que será cobrado o imposto. <br/>
                      <input type="text" id="impostoAddRegiao" name="impostoAddRegiao" value="<?php echo $impostoAddRegiao; ?>" style="width:20%"/>
                      <br/>
                      <span style="font-size:11px">Ex: Use UF**UF para todas as cidades de um estado, onde UF = sigla do Estado.<br/> Use  UF**Cidade para escolher apenas uma cidade de um determinado estado .<br/> Separe por virgula caso desejar definir mais de uma cidade. <br/>Ex: RJ**Niterói,RJ**São Gonçalo </strong>  </span>
                      </p>
					  
					  
				<hr/>	    
					  
			   
               <input type="submit"  name="submit" value="Salvar"   />
		</div>
	</div><!-- .bloco -->
	
	
	
	
	
	
	
	

</form>

       	
       	


      
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