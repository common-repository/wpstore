<?php



$url =  get_bloginfo('url')."/wp-content/plugins/wpstore/includes/ajax/stepIntall.php";


$emailAdmin =  get_option('emailAdminWPSHOP');



 $plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));
 $loadFile =  $plugin_directory."images/loadingBar.gif"; 
 
 
 
 
   $plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));  
	 
	 
	 //verifica e salva opções de pagamento caso necessário ------------- 
	 savePaymentOptions();
 
	 
	 
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
				
				$step = addslashes($_REQUEST['step']) ?:  1 ; 
				
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
							
							http://remind.com.br/projetos/wpstore/wp-admin/admin.php?page=
							
							$steps = true;
							$action =  verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=painel";
	 
							include('form-payment.php'); 
							?>
		 					
					
									
									
							<?php
							
						}elseif($current[0] == "configFrete"){//ELSE TIPO CAMPO------------
								?>
							
								<h3> <?php echo $step; ?>. <?php echo  	$title ;   ?> </h3>
									<p>  <?php echo $msg ; ?>  </p>   
									
									  
										<?php include('admin_frete.php'); ?>
										
							 
								 
								<?php
							
							
						}else{//ELSE TIPO CAMPO------------
?>
			
			

	<h3> <?php echo $step; ?>. <?php echo  	$title ;   ?> </h3>
	  
	<div class="texto" id='<?php echo $inputID; ?>'>
	
				 		  <form id='itemStep<?php echo $step; ?>' name='itemStep' >
							
								<p>
									<input type="<?php echo $current[1]; ?>" class='inputStep' id="<?php echo $current[0]; ?>" name="<?php echo $current[0]; ?>" value="<?php echo $value; ?>"  required   <?php if( $current[1]=="number" ){ echo "min='1' "; }?> />  <br/>
									<label for="emailAdm"> <?php echo $msg ; ?> </label></p>   
								            
			  					<input type="submit"  class='btSave' name="submit" value="Salvar"   /> 
								
			       </form> 
	</div>
			
 <?php }; //defaul step   ?>
			
			
		 
	  </div>
	 
		</div>
		
	</div>
	
	
	
</div>

 
<script>


function showLoad(){
	jQuery('.ctajax').fadeOut();
	jQuery('.loadbar').fadeIn();
};

function hideLoad(){
	jQuery('.loadbar').fadeOut();
	jQuery('.ctajax').fadeIn();
};


var i = 1;

function loadSubmitRules(i){
 
  jQuery('#itemStep'+i).live('submit' , function(e){
 
  showLoad();

	inputValueV = jQuery('.inputStep').val();
	inputIDV = jQuery('.inputStep').attr('id');
	i+=1;
	jQuery.post( "<?php echo $url; ?>", {      inputValue:inputValueV , inputID:inputIDV , step:i } ,function( data ){ 
		// alert(data);
		 jQuery('.ctajax').html(data);
	   hideLoad();
		 
		 //
		 //alert(  jQuery('#opcoesPagamento').length );
	 
		 if( jQuery('#opcoesPagamento').length  ) {
			 
			 loadSubmitPayment();
			 
		 }else{
			 loadSubmitRules(i);
		 }
		 
		 
		 
	});
	
	e.preventDefault(); //STOP default action
	e.unbind(); //unbind. to stop multiple form submit.
	
});

};

loadSubmitRules(i);



function loadSubmitPayment(){
 
  jQuery('#opcoesPagamento').live('submit' , function(e){
		 
		 var n = true;
		 
		 
		 v = 'Pagseguro';
		 n= verificaPayment(v);
		 
		 
		 if( n !="stop"){
		 v = 'Gerencianet';
		 n= verificaPayment(v);
		 }; 
		 
		 if( n !="stop"){
		 v = 'Moip';
		 n= verificaPayment(v);
	   }; 
		 
	   if( n !="stop"){
		 v = 'Paypal';
		 n= verificaPayment(v);
     }; 
		 
     if( n !="stop"){
	   v = 'Cielo';
		 n= verificaPayment(v);
		
     }; 
		 
		 
		 
     if( n !="stop"){
	   v = 'Deposito';
		 n= verificaPayment(v);
		
     }; 
		 
		 
     if( n !="stop"){
	   v = 'Retirada';
		 n= verificaPayment(v);
		
     }; 
		 
		 
		 
     if( n !="stop"){
	   v = 'Boleto';
		 n= verificaPayment(v);
		
     }; 
		 
 
     if(n==true || n=='stop'){ }else{ return true; };
		 
    	e.preventDefault(); //STOP default action
	    e.unbind(); //unbind. to stop multiple form submit.
		
		 
  });
	
	
	
   jQuery('.seta').click(function(){
      rel = jQuery(this).attr('rel');
      jQuery('.texto').hide();
      jQuery('#'+rel).show();
	 });    
 
 
 

};



<?php if($step==4){ ?>
	loadSubmitPayment(); 
	<?php }; ?>





 function verificaPayment(v){
	 proximo = true;
   pgs = jQuery('input[name=ativa'+v+']').is(':checked');
   if(pgs==true   ){
		 
	  	n = true;
	  	email  = ""+jQuery('#email'+v+'').val();
	  	token  = ""+jQuery('#token'+v+'').val();
		
			tokenS = "token";
			if(v=="Moip"){
				tokenS  = "meuPin";
				token  = ""+jQuery('#meuPin'+v+'').val();
			}
		
			if(v=="Paypal"){
		 		 tokenS  = "currentCode";
		   	token  = ""+jQuery('#currentCode'+v+'').val();
			}
			
			if(v=="Cielo"){
				 tokenS  = "chave";
				 email  = ""+jQuery('#filiacao'+v+'').val();
		  	 token  = ""+jQuery('#chave'+v+'').val();
		  }
 	 
	 
	  
		  if(email  == "" || token ==""){
				jQuery('.texto').hide();
		  	var ob = jQuery('#'+v+'');
      	ob.show();
		
				 if(email  == "" ){
					jQuery("label[for='email"+v+"']").css('color','red');
		  	 };
			   if( token ==""){
					jQuery("label[for='"+tokenS+v+"']").css('color','red');
		  	 };
				 
				  jQuery('html, body').animate({ scrollTop: ob.offset().top-120 }, 1000);
			
					return "stop";
			
		 }else{
	     
			 jQuery("label[for='email"+v+"']").css('color','#0073AA');
		   jQuery("label[for='"+tokenS+v+"']").css('color','#0073AA');
		   n = false;
		   
	   };
		 
		 
		 
		 
		 
 
		if(v=="Deposito"){
		 	openWin = false;
			 tokenS  = "chave";
			 depositoNomeCnpj  = ""+jQuery('#depositoNomeCnpj').val();
	  	 depositoBanco1  = ""+jQuery('#depositoBanco1').val();
			 depositoAgencia1  = ""+jQuery('#depositoAgencia1').val();
			 depositoConta1  = ""+jQuery('#depositoConta1').val();
			 
			 if(depositoNomeCnpj==''){
				  jQuery("label[for='depositoNomeCnpj']").css('color','red');
					openWin = true;
		   }
			 
			 if(depositoBanco1==''){
				  jQuery("label[for='depositoBanco1']").css('color','red');
					openWin = true;
		   };
			 
			 if(depositoAgencia1==''){
				  jQuery("label[for='depositoAgencia1']").css('color','red');
					openWin = true;
		   };
			 
			 if(depositoConta1==''){
				  jQuery("label[for='depositoConta1']").css('color','red');
					openWin = true;
		   };
			 
			 
			 if( openWin == true){
 			   jQuery('.texto').hide();
 		  	 var ob = jQuery('#'+v);
       	 ob.show();
				 
				  jQuery('html, body').animate({ scrollTop: ob.offset().top-120 }, 1000);
		
					return "stop";
				
			 }
			 
	  }
		
		
		
		if(v=="Retirada"){
			 openWin = false;
			 tokenS  = "chave";
			 enderecoRetirada = ""+jQuery('#enderecoRetirada').val();
			 
			 if(enderecoRetirada==''){
				  jQuery("label[for='enderecoRetirada']").css('color','red');
					openWin = true;
		   };
			 
			 
			 if( openWin == true){
 			   jQuery('.texto').hide();
 		  	 var ob = jQuery('#'+v);
       	 ob.show();
				 
				  jQuery('html, body').animate({ scrollTop: ob.offset().top-120 }, 1000);
		
					return "stop";
				
			 }
			 
	  }

		
		if(v=="Boleto"){
			 openWin = false;
			 tokenS  = "chave";
			 
			 caixaCedenteNome  = ""+jQuery('#caixaCedenteNome').val();
			 caixaCedenteCNPJ  = ""+jQuery('#caixaCedenteCNPJ').val();
			 caixaCedenteCodigo  = ""+jQuery('#caixaCedenteCodigo').val();
			 caixaCedenteAgencia  = ""+jQuery('#caixaCedenteAgencia').val();
			 caixaCedenteConta = ""+jQuery('#caixaCedenteConta').val();
			 caixaCedenteDigito  = ""+jQuery('#caixaCedenteDigito').val();

			 if(caixaCedenteNome==''){
				  jQuery("label[for='caixaCedenteNome']").css('color','red');
					openWin = true;
		   };
			 
	
			 
			 if(caixaCedenteCNPJ==''){
				  jQuery("label[for='caixaCedenteCNPJ']").css('color','red');
					openWin = true;
		   };
			 
			 if(caixaCedenteCodigo==''){
				  jQuery("label[for='caixaCedenteCodigo']").css('color','red');
					openWin = true;
		   };
			 
			 
			 if(caixaCedenteAgencia==''){
				  jQuery("label[for='caixaCedenteAgencia']").css('color','red');
					openWin = true;
		   };
			 
			 if(caixaCedenteConta==''){
				  jQuery("label[for='caixaCedenteConta']").css('color','red');
					openWin = true;
		   };
			 
			 if(caixaCedenteDigito==''){
				  jQuery("label[for='caixaCedenteDigito']").css('color','red');
					openWin = true;
		   };
			 
			 if( openWin == true){
 			   jQuery('.texto').hide();
 		  	 var ob = jQuery('#'+v);
       	 ob.show();
				 
				  jQuery('html, body').animate({ scrollTop: ob.offset().top-120 }, 1000);
		
					return "stop";
				
			 }
			 
			 
			 
	  }
		
		
	 
		
 };
 
   return n;
 
  }; //verifica
	
	
</script>
