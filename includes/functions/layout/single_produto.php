<?php
 
//TRAVA PRECO ---------------------------------
$travaPreco = get_option('wpstravapreco');
if($travaPreco== 'sim' || $travaPreco == 'true' ){
	$travaPreco = true;
}else{
		$travaPreco = false;
          }
$usuarioConfirmado = false;
global $current_user;
get_currentuserinfo();
$idUser = $current_user->ID;    
$autorizacao = get_usermeta($idUser, 'wpsAutorizacao');
if( $autorizacao =='Confirmado' ){
 	 $usuarioConfirmado = true;
	 $travaPreco = false;
};
//TRAVA PRECO ---------------------------------

	
	
?> 
		 <div class="produtoDir">
        
         
 
               <?php  custom_get_select_stock_form($post->ID); ?>
	 
                
                <div class="clear"></div>
					
             			
        
            <?php 
            
            $exibirFreteSingle = get_option('exibirFreteSingle');
            
            if($exibirFreteSingle !="não" && $travaPreco!=true){
            
            $tabelaVar = ""; 
            
            include('box-frete.php'); 
            
            echo  $tabelaVar ;  
            
            };
            
            
            ?>
       
			<div class="clear"></div>
				
			
        </div><!-- .produtoDir -->
		
 
		
        <div class="clear"></div>