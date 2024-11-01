<?php

     require("../../../../../wp-load.php");
 
      $inputValue = addslashes($_REQUEST['inputValue']);
      $inputID = addslashes($_REQUEST['inputID']);
	    $step = addslashes($_REQUEST['step']) ?:  1 ; 

			
			$arrayOpcoes = get_steps_cfg();
			
			
			
			 
			if($inputID =="emailAdminWPSHOP" ){
				  update_option('emailAdminWPSHOP',$inputValue);
					update_option('currentStepInstall',$step );
			}elseif( $inputID =="totalParcela"  ){
				 update_option('totalParcela',$inputValue);
				 update_option('currentStepInstall',$step );
 			}elseif( $inputID =="parcelaMinima"  ){
 				 update_option('parcelaMinima',$inputValue);
				 update_option('currentStepInstall',$step );
  	  }elseif( $inputID =="configPagto"  ){
				  //verifica e salva opções de pagamento caso necessário ------------- 
				  savePaymentOptions();
					update_option('currentStepInstall',$step );
	  	  }elseif( $inputID =="configFrete"  ){
					  //verifica e salva opções de pagamento caso necessário ------------- 
					  saveFreteOptions();
						update_option('currentStepInstall',$step );
			 }
       
			 
			 
		
				 
		
		 if($step<=count($arrayOpcoes)){    

				    $current = $arrayOpcoes[$step];
			
			   	  $value =   get_option( $current[0] ); 
			
				    $msg = $current[2];
			
				    $title = $current[3];
 
       
						if($current[0] == "configPagto"){//ELSE TIPO CAMPO------------
							?>
							
							<h3> <?php echo $step; ?>. <?php echo  	$title ;   ?> </h3>
								<p>  <?php echo $msg ; ?>  </p>   
								
							<?php 
							$steps = true;
							$action =  verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=painel";
			
							
							include('../functions/layout/form-payment.php'); 
							?>
		 					
							<?php
							
						}elseif($current[0] == "configFrete"){//ELSE TIPO CAMPO------------
								?>
							
								<h3> <?php echo $step; ?>. <?php echo  	$title ;   ?> </h3>
									<p>  <?php echo $msg ; ?>  </p>   
									
									 
								<?php 
								$steps = true;
								$action =  verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=painel";
			
							
								include('../functions/layout/form-frete.php'); 
								?>
								 
								<?php
							
							
						}else{//ELSE TIPO CAMPO------------
?>


<h3> <?php echo $step; ?>. <?php echo  	$title ;   ?> </h3>
	  
	<?php// echo $inputID."88888". $current[0]; ?>
	
<div class="texto" id='<?php echo $inputID; ?>'>
	
			 		  <form id='itemStep<?php echo $step; ?>' name='itemStep' >
							
							<p>
								<input type="<?php echo $current[1]; ?>" class='inputStep' id="<?php echo $current[0]; ?>" name="<?php echo $inputID; ?>" value="<?php echo $value; ?>"  required   <?php if( $current[1]=="number" ){ echo "min='1' "; }?> />  <br/>
								<label for="emailAdm"> <?php echo $msg ; ?> </label></p>   
								            
		  					<input type="submit"  class='btSave' name="submit" value="Salvar"   /> 
								
		       </form> 
</div>
<?php 

   }; //ELSE TIPO CAMPO------------

}else{
	
  update_option('currentStepInstall',$step );
	
  echo "<h3><strong>Parabéns!</strong> Você seguiu todos os passos  de configuração! </h3> <p>Continue a otimizar sua loja</p>";
	include('../functions/layout/admin_painel_dashboard.php');

};

?>
					
					