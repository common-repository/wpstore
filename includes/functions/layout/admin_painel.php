<?php



$url =  get_bloginfo('url')."/wp-content/plugins/wpstore/includes/ajax/stepIntall.php";


$emailAdmin =  get_option('emailAdminWPSHOP');



 $plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));
 $loadFile =  $plugin_directory."images/loadingBar.gif"; 
 
 
 
 
   $plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));  
	 
	 
	
	$step = addslashes($_REQUEST['step']) ?:  1 ; 
	
	$step  = intval($step);
	
	if($step==1){		 
		$stepSave = get_option('currentStepInstall',$step );	
		if($stepSave !=""){
			$step  = $stepSave;
		}
	}
	 
	 //verifica e salva opções de pagamento se necessário ------------- 
	 if($step==4){
		      savePaymentOptions();
					update_option('currentStepInstall',$step );
	 }elseif($step==5){
	 		 //verifica e salva opções de FRETE se necessário ------------- 
			 saveFreteOptions();
			 update_option('currentStepInstall',$step );
	 };
	 
	 

 
	 
	 
	 ?> 
 
	<link rel="stylesheet" type="text/css" href="<?php echo $plugin_directory; ?>panel/css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $plugin_directory; ?>panel/style.css">
	
 
<style>
.painel { width:98%; }
.painel .destaque { width:100%;margin:0px;padding:0px;height:200px;background:#0073aa;
	text-align:center; padding-top:20px;}
.painel .destaque  h1 { font-size:3.3em; color:#fff; padding-top:20px;margin-bottom:15px;}
.painel .destaque  p { width:70%;font-size:1.3em;margin:0 auto; margin-top:20px;color:#fff; }


.step{background:#fff;border:1px solid #ccc; width:100%;}


.stepCt{ margin:40px; min-height:170px; }


.stepCt h3{ margin:10px;  color:#0073AA; }


.stepCt p{ margin:10px;  color:#0073AA; }

.btSave{margin-left:10px;padding:10px;background:#0073AA;border-radius:5px;color:#fff;border:0px;}

.inputStep{padding:10px; width:90%;border:1px  solid #ccc; }

.loadbar{display:none;width:100%;margin-top:80px;position:absolute;text-align:center;}





.dashboard{ }

.dashboard .bloco{ float:left; background:#0073AA;padding:20px; color:#fff;}
.dashboard .bloco h3{ background:#0073AA; font-size:3em;margin:20px;  color:#fff;} 
.dashboard .bloco p{ margin:20px;  color:#fff;} 
.dashboard .bloco a{ margin:20px;  color:#D54E21;} 
.dashboard .bloco a:hover{    color:#fff;} 
.dashboard .bloco50{ width:50%;}
.dashboard .bloco30{ width:30%;margin-left:10px;}
	
	
</style>

<div class='painel'>
	
	<div class='destaque'>
		<h1><strong>Bem vindo ao WPSTORE! </strong> </h1>
		<p>Fique tranquilo! Iremos  ajudar em cada etapa. Confira o checklist abaixo. Seja bem vindo ao WPSTORE! </p>    
	</div>
	
	<div class='step'>
		
	 
	 <div class='loadbar'><img src='<?php echo $loadFile; ?>' /></div>
		
		
		<div class='stepCt'>
			
			<div  class='ctajax'>
				
				
				
				<?php
			
				if(addslashes($_REQUEST['submit']) == "Salvar e Prosseguir"){
					$step = intval($step)+1;
				}
				
				$arrayOpcoes = get_steps_cfg();
				 
		    $current = $arrayOpcoes[$step];
	
	   	  $value =   get_option( "".$current[0] ); 
	
	      $msg = $current[2];
	
		    $title = $current[3];
				
				
 
       
						if($current[0] == "configPagto"){//ELSE TIPO CAMPO------------
							?>
							
							<h3> <?php echo $step; ?>. <?php echo  	$title ;   ?> </h3>
								<p>  <?php echo $msg ; ?>  </p>   
								
							<?php 
							
						 
							$steps = true;
							$action =  verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=painel";
	 
							include('form-payment.php'); 
							?>
		 					
					
									
									
							<?php
							
						}elseif($current[0] == "configFrete"){//ELSE TIPO CAMPO------------
								?>
							
								<h3> <?php echo $step; ?>. <?php echo  	$title ;   ?> </h3>
									<p>  <?php echo $msg ; ?>  </p>   
									
									  
										<?php 
										
							
										$steps = true;
										$action =  verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=painel";
	 
	 
										include('form-frete.php'); 
										
										?>
										
							 
								 
								<?php
							
							
	  }else{//ELSE TIPO CAMPO------------
			
			 $inputID = $current[0];
	 
?>
			
			<?php if($title !=""){ ?>

	<h3> <?php echo $step; ?>. <?php echo  	$title ;   ?> </h3>
	  
	<div class="texto" id='<?php echo $inputID; ?>'>
	
				 		  <form id='itemStep<?php echo $step; ?>' name='itemStep' >
							
								<p>
									<input type="<?php echo $current[1]; ?>" class='inputStep' id="<?php echo $current[0]; ?>" name="<?php echo $current[0]; ?>" value="<?php echo $value; ?>"  required   <?php if( $current[1]=="number" ){ echo "min='1' "; }?> />  <br/>
									<label for="emailAdm"> <?php echo $msg ; ?> </label></p>   
								            
			  					<input type="submit"  class='btSave' name="submit" value="Salvar"   /> 
								
			       </form> 
	</div>
	<?php  
         }else{
		        update_option('currentStepInstall',$step );
			      echo "<h3><strong>Parabéns!</strong> Você configurou as principais opções de  sua loja virtual ! </h3> <p>Continue a otimizar a experiência! Siga as dicas de seu gerente virtual indicadas todos os dias em seu painel . Confira as dicas de hoje! </p>";
						include('admin_painel_dashboard.php');
			  
	       };
	?>
			
 <?php }; //defaul step   ?>
			
			  
	  </div>
	 
		</div>
		
	</div>
	
	
	
</div>

 
 <?php include('admin_painel_script_js.php'); ?>
