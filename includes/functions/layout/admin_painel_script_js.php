 
 
<script>


function showLoad(){
	jQuery('.ctajax').fadeOut();
	jQuery('.loadbar').fadeIn();
};

function hideLoad(){
	jQuery('.loadbar').fadeOut();
	jQuery('.ctajax').fadeIn();
};


var i = parseInt("<?php echo $step; ?>");

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
			 
			 if( jQuery('#opcoesFrete').length  ) {
			 
				 loadSubmitFrete();
			 
			 }else{
				 loadSubmitRules(i);
			 }
		
		 }
		 
		 
		 
	});
	
	e.preventDefault(); //STOP default action
	e.unbind(); //unbind. to stop multiple form submit.
	
});

};

 

 
 

<?php if($step==4){ ?>
		 loadSubmitPayment(); 
<?php }elseif($step==5){ ?>
			loadSubmitFrete(); 
<?php }else{ ?>
		loadSubmitRules(i);
<?php }; ?>





	function loadSubmitPayment(){  

	   var vrfPgt = 'empty';


	  jQuery('#opcoesPagamento').live('submit' , function(e){
	 
			 var n = true;
			 var vrfPgt = 'empty';
	 
		 
			 v = 'Pagseguro';
		   cfr = jQuery('input[name=ativa'+v+']').is(':checked');	 
		   if(cfr===true   ){
				 vrfPgt =  true;
			 	n= verificaPayment(v);
		   };
			 
			 
			 if( n !="stop"){
			 		v = 'Gerencianet';
	 		   cfr = jQuery('input[name=ativa'+v+']').is(':checked');	 
	 		   if(cfr===true   ){
					  vrfPgt =  true;
	 			 	n= verificaPayment(v);
	 		   };
			 }; 
	 
			 if( n !="stop"){
				 	v = 'Moip';
 	 		   cfr = jQuery('input[name=ativa'+v+']').is(':checked');	 
 	 		   if(cfr===true   ){
					  vrfPgt =  true;
 	 			 	n= verificaPayment(v);
 	 		   };
		   }; 
	 
		   if( n !="stop"){
			 		v = 'Paypal';
 	 		   cfr = jQuery('input[name=ativa'+v+']').is(':checked');	 
 	 		   if(cfr===true   ){
					  vrfPgt =  true;
 	 			 	n= verificaPayment(v);
 	 		   };
	     }; 
	 
	     if( n !="stop"){
		   		v = 'Cielo';
 	 		   cfr = jQuery('input[name=ativa'+v+']').is(':checked');	 
 	 		   if(cfr===true   ){
					  vrfPgt =  true;
 	 			 	n= verificaPayment(v);
 	 		   };
	     }; 
	 
	 
	 
	     if( n !="stop"){
		   		v = 'Deposito';
 	 		   cfr = jQuery('input[name=ativa'+v+']').is(':checked');	 
 	 		   if(cfr===true   ){
					  vrfPgt =  true;
 	 			 	n= verificaPayment(v);
 	 		   };
	     }; 
	 
	 
	     if( n !="stop"){
		   		v = 'Retirada';
 	 		   cfr = jQuery('input[name=ativa'+v+']').is(':checked');	 
 	 		   if(cfr===true   ){
					  vrfPgt =  true;
 	 			 	n= verificaPayment(v);
 	 		   };
	     }; 
	 
	 
	 
	     if( n !="stop"){
		   		v = 'Boleto';
 	 		   cfr = jQuery('input[name=ativa'+v+']').is(':checked');	 
 	 		   if(cfr===true   ){
					  vrfPgt =  true;
 	 			 	n= verificaPayment(v);
 	 		   };
	     }; 
	 
	 
	     if(n==true || n=='stop' || vrfPgt=='empty' ){ 
				 
				  if(vrfPgt =='empty' ){
			      jQuery('.texto').hide();
					  var ob = jQuery('#opcoesPagamento');
					   ob.show();
				    jQuery('html, body').animate({ scrollTop: ob.offset().top-120 }, 1000);
		      };
				 
			 }else{  return true; };
	 
	    	e.preventDefault(); //STOP default action
		    e.unbind(); //unbind. to stop multiple form submit.
	
	 
	  });



	   jQuery('.seta').click(function(){
	      rel = jQuery(this).attr('rel');
	      jQuery('.texto').hide();
	      jQuery('#'+rel).show();
		 });    




	};


 function verificaPayment(v){
	 
	 proximo = true;

	 
   pgs = jQuery('input[name=ativa'+v+']').is(':checked');
   tokenS = "token";
	  
   if(pgs==true   ){
		  
	  	n = true;
	  	email  = ""+jQuery('#email'+v+'').val();
	  	token  = ""+jQuery('#token'+v+'').val();
	
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
		   }else{
		   	jQuery("label[for='depositoNomeCnpj']").css('color','#0073AA');
		   }
		 
			 if(depositoBanco1==''){
				  jQuery("label[for='depositoBanco1']").css('color','red');
					openWin = true;
 		   }else{
 		   	jQuery("label[for='depositoBanco1']").css('color','#0073AA');
 		   }
		 
			 if(depositoAgencia1==''){
				  jQuery("label[for='depositoAgencia1']").css('color','red');
					openWin = true;
 		   }else{
 		   	jQuery("label[for='depositoAgencia1']").css('color','#0073AA');
 		   }
		 
			 if(depositoConta1==''){
				  jQuery("label[for='depositoConta1']").css('color','red');
					openWin = true;
 		   }else{
 		   	jQuery("label[for='depositoConta1']").css('color','#0073AA');
 		   }
		 
		 
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
  		  }else{
  		   	jQuery("label[for='enderecoRetirada']").css('color','#0073AA');
  		 }
		 
		 
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
  		  }else{
  		   	jQuery("label[for='caixaCedenteNome']").css('color','#0073AA');
  		 }
		 

		 
			 if(caixaCedenteCNPJ==''){
				  jQuery("label[for='caixaCedenteCNPJ']").css('color','red');
					openWin = true;
  		  }else{
  		   	jQuery("label[for='caixaCedenteCNPJ']").css('color','#0073AA');
  		 }
		 
		 
			 if(caixaCedenteCodigo==''){
				  jQuery("label[for='caixaCedenteCodigo']").css('color','red');
					openWin = true;
  		  }else{
  		   	jQuery("label[for='caixaCedenteCodigo']").css('color','#0073AA');
  		 }
		 
		 
		 
			 if(caixaCedenteAgencia==''){
				  jQuery("label[for='caixaCedenteAgencia']").css('color','red');
					openWin = true;
  		  }else{
  		   	jQuery("label[for='caixaCedenteAgencia']").css('color','#0073AA');
  		 }
		 
		 
			 if(caixaCedenteConta==''){
				  jQuery("label[for='caixaCedenteConta']").css('color','red');
					openWin = true;
  		  }else{
  		   	jQuery("label[for='caixaCedenteConta']").css('color','#0073AA');
  		 }
		 
		 
			 if(caixaCedenteDigito==''){
				  jQuery("label[for='caixaCedenteDigito']").css('color','red');
					openWin = true;
  		  }else{
  		   	jQuery("label[for='caixaCedenteDigito']").css('color','#0073AA');
  		 }
		 
		 
			 if( openWin == true){
 			   jQuery('.texto').hide();
 		  	 var ob = jQuery('#'+v);
       	 ob.show();
			 
				  jQuery('html, body').animate({ scrollTop: ob.offset().top-120 }, 1000);
	
					return "stop";
			
			 }
		 
		 
		 
	  }
	
	
 
	
 }; //----------------

   return n;

 }; //verifica PAYMENT






		
		
		
		
		
		
		
		//-------------------------------------



			function loadSubmitFrete(){

			  jQuery('#opcoesFrete').live('submit' , function(e){
	 
					 var n = true;
	 
					 v = 'Correios';
					 n= verificaFrete(v);
	  
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
			
			



function verificaFrete(){
  openWin = true;
	 
   checkfrete = jQuery('input[name=tipoFrete]').is(':checked');
	tF = "";
	if(  checkfrete ==true   ){
		tF = jQuery('input[name=tipoFrete]:checked').val();
	 
	  //GRATIS ---------------------------------
		if(tF=="gratis"){
			openWin = false;
		}
		
		//CORREIOS---------------------------------
		if(tF=="correios"){
			  openWin = false;
				
	      cepOrigemCorreios  = ""+jQuery('#cepOrigemCorreios').val();
		    alturaEmbalagemCorreios  = ""+jQuery('#alturaEmbalagemCorreios').val();
		    larguraEmbalagemCorreios  = ""+jQuery('#larguraEmbalagemCorreios').val();
		    comprimentoEmbalagemCorreios  = ""+jQuery('#comprimentoEmbalagemCorreios').val();
		  
			    if(cepOrigemCorreios==''){
				  jQuery("label[for='cepOrigemCorreios']").css('color','red');
					openWin = true;
  		    }else{
  		   	jQuery("label[for='cepOrigemCorreios']").css('color','#0073AA');
  		    };
			 
			   if(alturaEmbalagemCorreios==''){
				  jQuery("label[for='alturaEmbalagemCorreios']").css('color','red');
					openWin = true;
  		   }else{
  		   	jQuery("label[for='alturaEmbalagemCorreios']").css('color','#0073AA');
  		   };
			 
			   if(larguraEmbalagemCorreios==''){
				  jQuery("label[for='larguraEmbalagemCorreios']").css('color','red');
					openWin = true;
  		   }else{
  		   	jQuery("label[for='larguraEmbalagemCorreios']").css('color','#0073AA');
  		   };
			 
			   if(comprimentoEmbalagemCorreios==''){
				  jQuery("label[for='comprimentoEmbalagemCorreios']").css('color','red');
					openWin = true;
  		   }else{
  		   	jQuery("label[for='comprimentoEmbalagemCorreios']").css('color','#0073AA');
  		   };
	} //CORREIOS---------------------------------
	
	 
	
	//FIXO----------------------------------------
  if(tF=="fixo"){  
		//
		openWin = false;
		valorFreteFixo  = ""+jQuery('#valorFreteFixo').val();
		
    if(valorFreteFixo==''){
	  jQuery("label[for='valorFreteFixo']").css('color','red');
		openWin = true;
    }else{
   	jQuery("label[for='valorFreteFixo']").css('color','#0073AA');
    };
 
		  
	}
	//FIXO-------------------------------------
	
	
	//pesoBase---------------------------------
  if(tF=="pesoBase"){ 
		 openWin = false;
		    valorFretePeso1  = ""+jQuery('#valorFretePeso1').val();
			  valorFretePeso2  = ""+jQuery('#valorFretePeso2').val();
			  valorFretePeso3  = ""+jQuery('#valorFretePeso3').val();
			  valorFretePeso4  = ""+jQuery('#valorFretePeso4').val();
			  valorFretePeso5 = ""+jQuery('#valorFretePeso5').val();
			  valorFretePeso6  = ""+jQuery('#valorFretePeso6').val();
				
				
        i = 1;
		    if(valorFretePeso1==''){
				
			  jQuery("label[for='valorFretePeso"+i+"']").css('color','red');
				openWin = true;
		    }else{
		   	jQuery("label[for='valorFretePeso"+i+"']").css('color','#0073AA');
		    };
			
			  i = 2;
		    if(valorFretePeso2==''){
				
			  jQuery("label[for='valorFretePeso"+i+"']").css('color','red');
				openWin = true;
		    }else{
		   	jQuery("label[for='valorFretePeso"+i+"']").css('color','#0073AA');
		    };
				
				i = 3;
		    if(valorFretePeso3==''){
				
			  jQuery("label[for='valorFretePeso"+i+"']").css('color','red');
				openWin = true;
		    }else{
		   	jQuery("label[for='valorFretePeso"+i+"']").css('color','#0073AA');
		    };
				
				
				i = 4;
		    if(valorFretePeso4==''){
				
			  jQuery("label[for='valorFretePeso"+i+"']").css('color','red');
				openWin = true;
		    }else{
		   	jQuery("label[for='valorFretePeso"+i+"']").css('color','#0073AA');
		    };
				
				
				i = 5;
		    if(valorFretePeso5==''){
				
			  jQuery("label[for='valorFretePeso"+i+"']").css('color','red');
				openWin = true;
		    }else{
		   	jQuery("label[for='valorFretePeso"+i+"']").css('color','#0073AA');
		    };
				
				
				i = 6;
		    if(valorFretePeso6==''){
				
			  jQuery("label[for='valorFretePeso"+i+"']").css('color','red');
				openWin = true;
		    }else{
		   	jQuery("label[for='valorFretePeso"+i+"']").css('color','#0073AA');
		    };
		   
	}
	//pesoBase----------------------------------
	
	
	//precoBase---------------------------------
  if(tF=="precoBase"){  
		openWin = false;
		valorFreteValor1 = ""+jQuery('#valorFreteValor1').val();
		valorFreteValor2 = ""+jQuery('#valorFreteValor2').val();
		valorFreteValor3 = ""+jQuery('#valorFreteValor3').val();
		valorFreteValor4 = ""+jQuery('#valorFreteValor4').val();
		valorFreteValor5 = ""+jQuery('#valorFreteValor5').val();
		valorFreteValor6 = ""+jQuery('#valorFreteValor6').val();
		
		
      i = 1;
	    if(valorFreteValor1==''){
			
		  jQuery("label[for='valorFreteValor"+i+"']").css('color','red');
			openWin = true;
	    }else{
	   	jQuery("label[for='valorFreteValor"+i+"']").css('color','#0073AA');
	    };
			
	   
			i = 2;
	    if(valorFreteValor2==''){
			
		  jQuery("label[for='valorFreteValor"+i+"']").css('color','red');
			openWin = true;
	    }else{
	   	jQuery("label[for='valorFreteValor"+i+"']").css('color','#0073AA');
	    };
			
			
			i = 3;
	    if(valorFreteValor3==''){
			
		  jQuery("label[for='valorFreteValor"+i+"']").css('color','red');
			openWin = true;
	    }else{
	   	jQuery("label[for='valorFreteValor"+i+"']").css('color','#0073AA');
	    };
			
			
			i = 4;
	    if(valorFreteValor4==''){
			
		  jQuery("label[for='valorFreteValor"+i+"']").css('color','red');
			openWin = true;
	    }else{
	   	jQuery("label[for='valorFreteValor"+i+"']").css('color','#0073AA');
	    };



      i = 5;
	    if(valorFreteValor5==''){
			
		  jQuery("label[for='valorFreteValor"+i+"']").css('color','red');
			openWin = true;
	    }else{
	   	jQuery("label[for='valorFreteValor"+i+"']").css('color','#0073AA');
	    };
			
			
			i = 6;
	    if(valorFreteValor6==''){
			
		  jQuery("label[for='valorFreteValor"+i+"']").css('color','red');
			openWin = true;
	    }else{
	   	jQuery("label[for='valorFreteValor"+i+"']").css('color','#0073AA');
	    };
	  
	}
	//precoBase---------------------------------
	
	
		
	}else{
		openWin = true;
	}
	
	
 if( openWin === true){
     jQuery('.texto').hide();
		 jQuery('#'+tF).fadeIn();
 	   var ob = jQuery('#opcoesFrete');
   	 ob.show();
	   jQuery('html, body').animate({ scrollTop: ob.offset().top-120 }, 1000);
      return "stop";
 }else{
 	   return  false;
 };
 
}; //verificaFrete ------------------





		



	
</script>