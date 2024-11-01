//$.noConflict();
jQuery(document).ready(function(){
    
    
    
	

          	jQuery('input, textarea').focus(function(){
          		if (jQuery(this).val() == jQuery(this).attr("title")){
          			jQuery(this).val("");
          		}
          	}).blur(function(){
          		if (jQuery(this).val() == "") {
          			jQuery(this).val(jQuery(this).attr("title"));
          		}
          	});


 
      
     var baseUrl = jQuery('meta[name=urlShop]').attr("content");
     var pgsUrl = jQuery('meta[name=pgsUrl]').attr("content");
     var urlSite = jQuery('meta[name=urlSite]').attr("content");
     
 
     //ABAS MAIS INFOS -----------------------------------
     
     
     
      jQuery("div.abas ul.botoes li").click(function () {

            var v = jQuery(this).attr('id');

            jQuery("ul.botoes li").removeClass('ativo');
            jQuery(this).addClass('ativo');

            jQuery('div.abas div').hide();
            jQuery('.'+v).fadeIn();

     });

     
     
     
     //FINAL ABA MAIS INFOS -----------------------------------
     
 
 
     //thumbs change galeria Imagem Produto
	 
	  function startGaleria(){
		  
        jQuery('ul.galeriaThumb li a').click(function(){   

             	 var urlItem =    jQuery(this).attr('href');

             	 jQuery('.imagem img').hide();
             	 jQuery('.imagem img').attr('src','');
              	 jQuery('.imagem img').attr('src',urlItem);  
              	 
              	 jQuery('a.imageFirst').attr('href',urlItem);   
              	 
              	 jQuery('.imagem img').fadeIn();

 	             return false;

 	    });
		
	   };
        startGaleria();
 	     //FINAL  thumbs change galeria Imagem Produto
 	     
      
      
         //VARIACAO COR --------------------------
		 
		 
		 function startVariacaoTamanhoCor(){
         
         jQuery('li.selectVaricaoCor').click(function(){
             
    
              jQuery('p.msg').html(''); jQuery('p.msg').hide();
            
             jQuery('p.indisp').fadeOut();  
			  
             jQuery('.btComprar').fadeIn();
             jQuery('p.quantidade').fadeIn();   
			 
			 jQuery('p.parc').fadeIn(); 
			 
             jQuery('li.selectVaricaoCor').removeClass('ativo');
             jQuery("ul.tamanhos li").removeClass('ativo');
			 
             jQuery(this).addClass('ativo');   
             
             var variacaoNome = ""+jQuery(this).attr('rel');
             var preEstoque = ""+jQuery(this).attr('rev');
             
             if(preEstoque=='esgotado'){
               jQuery('.btComprar').hide(); 
               jQuery('p.quantidade').fadeOut();   
			   jQuery('p.parc').fadeOut();  
               jQuery('p.indisp').fadeIn();   
             };
 
             jQuery('ul.tamanhos').hide();
             jQuery('ul.'+variacaoNome).fadeIn();
             
         });
		 
	    
          //FINAL VARIACAO COR --------------------------
          
          
          
          
          
          
               //VARIACAO TAMANHO--------------------------

               jQuery('li.selectVaricaoTamanho').click(function(){
 
                    jQuery('p.msg').html(''); jQuery('p.msg').hide();
                    
                     jQuery('p.indisp').fadeOut();   
                     jQuery('.btComprar').fadeIn();
                     jQuery('p.quantidade').fadeIn();   
					 jQuery('p.parc').fadeIn(); 
                     jQuery('li.selectVaricaoTamanho').removeClass('ativo');
                     jQuery(this).addClass('ativo');   
 
                   var variacaoNome = ""+jQuery(this).attr('rel');
                   var preEstoque = ""+jQuery(this).attr('rev');

                   if(preEstoque=='esgotado'){
                     jQuery('.btComprar').hide();  
                     jQuery('p.quantidade').fadeOut();   
					 jQuery('p.parc').fadeOut(); 
                     jQuery('p.indisp').fadeIn();   
                     
                   };
  

               });
			   
 	          }; 
			  
			  startVariacaoTamanhoCor();
         

                //FINAL VARIACAO TAMANHO --------------------------
                
                
                
                
                  //BT INDISPONIVEL-------------------------
                    function btIndisponivel(){
                   jQuery('a.btAviso').click(function() {
                       
                               msg = "Enviando...";
                                 jQuery('p.msg').html('<span >'+msg+'</span>');
                                 jQuery('p.msg').fadeIn();
                       
                         var postIDP = ""+jQuery('#idP').val();
                         var variacaoCorP = "";
                         var variacaoTamanhoP = "";
                         var ed = false;
                         
                          if(  verificaCor()<1 && verificaTamanho()<1  ){
                              ed = true;
                           }else{
     
                               var vC = parseInt(verificaCor());
                               if(vC>=1){
                                     ativo = ""+jQuery('ul.cores li.ativo').attr('rel'); 
                                     if(ativo=='undefined'){
                                           msg = "Escolha uma cor disponível.";
                                      }else{
                                            variacaoCorP = ativo;
                                      }
                               }; 

                               var vT =  parseInt(verificaTamanho());
                                 if(vT>=1){
                                       ativo = ""+jQuery('ul.tamanhos li.ativo').attr('rel'); 
                                       if(ativo=='undefined'){
                                           if(msg ==""){
                                            msg = "Escolha um tamanho disponível.";
                                           }else{
                                            msg = "Escolha uma cor e tamnho disponível.";   
                                           };
                                       }else{
                                            variacaoTamanhoP = ativo; 
                                       }
                                  };

                           };
                           
                         var nomeAviso = ""+jQuery('#nomeAviso').val();
                         var emailAviso = ""+jQuery('#emailAviso').val();
						 
						 var telAviso = ""+jQuery('#telefoneAviso').val();
						 if(telAviso =='Telefone com ddd'){
						 	telAviso ='-';
						 }
						// alert(telAviso);
						 
                         if(nomeAviso =="Digite seu Nome" || emailAviso =="Digite seu Email" ){
                             msg = "Preencha os dados acima para ser avisado quando este produto chegar.";
                                 jQuery('p.msg').html('<span style="color:red">'+msg+'</span>');
                                 jQuery('p.msg').fadeIn();
                                 return false;
                         }else{
                    
                              jQuery.post(baseUrl+"avisarQuandoChegar.php", {nomeAvisoR:''+nomeAviso+'' ,emailAvisoR:''+emailAviso+'' , telAvisoR:telAviso , postIDPR:''+postIDP+'',variacaoCorPR:''+variacaoCorP+'',variacaoTamanhoPR:''+variacaoTamanhoP+''} ,
                                          function(data) {
                                                  msg = data;
                                                  jQuery('p.msg').html('<span style="color:green;font-size:0.9em">'+msg+'</span>');
                                                  jQuery('p.msg').fadeIn();
                              });
                                  
                                  
                          
                         };
                         
                         
                         
 
                          return false;
                     
                     });
					 
					 
					 
					 
					 
					 
					 
					 
					 
					 
                     jQuery('a.btAviso2').click(function() {
                       
                                   msg = "Enviando...";
                                   jQuery('p.msg').html('<span >'+msg+'</span>');
                                   jQuery('p.msg').fadeIn();
                       
                           var postIDP = ""+jQuery('#idP').val();
                           var variacaoCorP = "";
                           var variacaoTamanhoP = "";
                           var ed = false;
                         
                            if(  verificaCor()<1 && verificaTamanho()<1  ){
                                ed = true;
                             }else{
     
                                 var vC = parseInt(verificaCor());
                                 if(vC>=1){
                                       ativo = ""+jQuery('ul.cores li.ativo').attr('rel'); 
                                       if(ativo=='undefined'){
                                             msg = "Escolha uma cor disponível.";
                                        }else{
                                              variacaoCorP = ativo;
                                        }
                                 }; 

                                 var vT =  parseInt(verificaTamanho());
                                   if(vT>=1){
                                         ativo = ""+jQuery('ul.tamanhos li.ativo').attr('rel'); 
                                         if(ativo=='undefined'){
                                             if(msg ==""){
                                              msg = "Escolha um tamanho disponível.";
                                             }else{
                                              msg = "Escolha uma cor e tamnho disponível.";   
                                             };
                                         }else{
                                              variacaoTamanhoP = ativo; 
                                         }
                                    };

                             };
                           
                           var nomeAviso = ""+jQuery('#nomeAviso2').val();
                           var emailAviso = ""+jQuery('#emailAviso2').val();
						   
  						 var telAviso = ""+jQuery('#telefoneAviso2').val();
  						 if(telAviso =='Telefone com ddd'){
  						 	telAviso ='-';
  						 }
						 
						 // alert(telAviso);
						 
						 
                           if(nomeAviso =="Digite seu Nome" || emailAviso =="Digite seu Email" ){
                               msg = "Preencha os dados acima para ser avisado quando este produto chegar.";
                                   jQuery('p.msg').html('<span style="color:red">'+msg+'</span>');
                                   jQuery('p.msg').fadeIn();
                                   return false;
                           }else{
                    
                                jQuery.post(baseUrl+"avisarQuandoChegar.php", {nomeAvisoR:''+nomeAviso+'' ,emailAvisoR:''+emailAviso+'' ,telAvisoR:''+telAviso+'', postIDPR:''+postIDP+'',variacaoCorPR:''+variacaoCorP+'',variacaoTamanhoPR:''+variacaoTamanhoP+''} ,
                                            function(data) {
                                                    msg = data;
                                                    jQuery('p.msg').html('<span style="color:green;font-size:0.9em">'+msg+'</span>');
                                                    jQuery('p.msg').fadeIn();
                                });
                                  
                                  
                          
                           };
                         
                         
                         
 
                            return false;
                     
                       });
					   
					   
					   
					   
					   
					 
				 }; btIndisponivel();
         //BT INDISPONIVEL-------------------------
         
         
         
         
          //BT COMPRAR--------------------------
             function btComprar(){
				 
				 
				 
				 jQuery('.btComprar').click(function(){
            
                 jQuery('p.msg').html(''); jQuery('p.msg').hide();
                  
          
                  var variacaoCorP = "";
                  var variacaoTamanhoP = "";
                  
                  var qtdProdutoV = ''+jQuery('#qtdProd').val();
				  if(qtdProdutoV == 'undefined' ){
				  	qtdProdutoV = 1;
				  }
				  
			 
                  
                  var postIDP = ""+jQuery('#idP').val();
                  
                 /// alert(postIDP); alert(variacaoP);
             
                  var ed = false;
                  var msg = "";
         
                  if(  verificaCor()<1 && verificaTamanho()<1  ){
                     ed = true;
                  }else{
                      
                      var vC = parseInt(verificaCor());
                      if(vC>=1){
                            ativo = ""+jQuery('ul.cores li.ativo').attr('rel');    
                            if(ativo=='undefined'){
                                  msg = "Escolha uma cor disponível.";
                             }else{
                                   variacaoCorP = ativo;
                             }
                      }; 
                      
                      var vT =  parseInt(verificaTamanho());
                       if(vT>=1){
                              ativo = ""+jQuery('ul.tamanhos li.ativo').attr('rel'); 
                              if(ativo=='undefined'){
                                  if(msg ==""){
                                   msg = "Escolha um tamanho disponível.";
                                  }else{
                                   msg = "Escolha uma cor e tamnho disponível.";   
                                  };
                              }else{
                                   variacaoTamanhoP = ativo; 
                              }
                         };
                        
                     };
                     
                
                  if(msg ==""){ ed = true;   };
                  
                  
                  if(ed ==true){ 
					  
				 
                       jQuery('.carreg').fadeIn(); 
                       jQuery.post(baseUrl+"consultaEstoque.php", { postID:postIDP, variacaoCor: variacaoCorP , variacaoTamanho:variacaoTamanhoP , qtdProduto:qtdProdutoV  },
                               function(data) { 
																 
								                    /// alert(data);
																		
                                    var preEstoque = ""+data;   
                                    jQuery('.carreg').hide(); 
                                    var stk = parseInt(preEstoque);
                                    if(stk=='1'){
                                         jQuery('p.indisp').fadeIn();   
                                         jQuery('p.quantidade').fadeOut();   
										 jQuery('p.parc').fadeOut(); 
										 jQuery('.btComprar').fadeOut();  
										 
										   
                                     }else{
                                         reloadQtdItems();
                                         //jQuery('p.msg').html(data);
                                         //jQuery('p.msg').fadeIn();
                                          //window.location = ""+data; 
										                      aposAdicionarProduto(data);
										  
										 
										   var qtdF = parseInt(qtdProdutoV);
										   var qtdAtual = parseInt(jQuery('span.qtdProd').text());
										   if(qtdAtual>0){
										   	 qtdF+=qtdAtual;
										   };
										   //jQuery('span.qtdProd').text(qtdF+" Produtos");
										   jQuery('span.qtdProd').text(qtdF+"");
										  
                                     };
                       });  
                       
                  }else{  
                      jQuery('.msg').html("<span style='color:red'>"+msg+"</span>");
                      jQuery('.msg').fadeIn();
                     
                 }; 
                 
                  return false;
                  
              });
			  
			  
			  
		  };
		  
		   btComprar();
		    
		   
          //FINAL BT COMPRAR--------------------------
		  
		  
		  function aposAdicionarProduto(data){
		 
					arrData =  data.split("****");  
		  	      var html = "<div class='contentSeguir'><span class='confirmAdd'></span><h3>Produto Adicionado com Sucesso</h3><br/><br/>";
		          html += "<div class='contentBtSeguir'><p class='btSeguirLoja left'>Continuar a comprar</p>";
					    html += "<a href='"+arrData[0]+"'><p class='btSeguirCarrinho left'>Editar Carrinho</p></a></div>";
					    html += "<a href='"+arrData[1]+"'><p class='btSeguirCheckout left'>Ir para Pagamento</p></a></div>";
			        html += "<div class='clear'></div></div>";
				      jQuery('#contentLight').html(html);
			        btSeguirLoja();
					    lightbox_open(); 
			  
	      };
		  
		  
		  
		  
		  
		  
		  function btSeguirLoja(){
			  jQuery('.btSeguirLoja').click(function(){ 
                   lightbox_close();
              });
		  };
         
         
         function verificaCor(){
              var variacaoCores =  jQuery("ul.cores li").size();
              return variacaoCores;
         };
         
         function verificaTamanho(){
               var verificaTamanho =  jQuery("ul.tamanhos li").size();
               return verificaTamanho;
          };
          
          
          function reloadQtdItems(){
              jQuery.post(baseUrl+"reloadQtdItems.php", {  },
                         function(data) { 
                           
                              jQuery('a.qtdItemsCart').text(data);
              });
          };
         

 
           jQuery('.btCalcularFrete').click(function(){ 
               
			   if(jQuery('.freteInfo')){  jQuery('.freteInfo').remove(); };
			 
               //jQuery('<span class="freteInfo" style="font-size:12px">  Total já Incluíndo o valor do Frete ( '+relV+' ) de  '+val.toFixed(2)+'  </span>').insertAfter('.totalCart');
               getEndereco(); 
           });
 
              
              
              jQuery('#cepDois').focusout(function() {
                   getEndereco(); 
              });
              
               getEndereco(); 
            
       
             function getEndereco() { 
                 
                        var cepDestino = ""+jQuery('input.cep').val();  
                        if(cepDestino=="" || cepDestino =="undefined"){
                          cepDestino = ""+jQuery('input.cepUm').val()+jQuery('input.cepDois').val();  
                        };   
                        
                        var bairro = "";
                        var cidade = "";
                        var estado = "";
                        // Se o campo CEP não estiver vazio
						
					 
                      	if(cepDestino != ""  && cepDestino != "undefined" && cepDestino != "undefinedundefined" ){   
                      	    
                      	         jQuery('.btCalcularFrete').text('Carregando');
                             
                      	          jQuery.getJSON(baseUrl+'shipping/buscaEndereco.php?cep='+cepDestino+'', function(data) {
									 
									     if(data !=null || data !="" ){
											 
                      	                 	    jQuery.each(data, function(key, val) {
                                                 if(key=='logradouro'){  rua = ""+val; };
                                                 if(key=='bairro'){  bairro = ""+val; };
                                                 if(key=='cidade'){  cidade = ""+val; };
                                                 if(key=='uf'){  estado = ""+val; };
                                          		});
                                        
												if(rua=='null'){ rua = ''; };
												if(cidade=='null'){ cidade = ''; };
												if(bairro=='null'){ bairro = ''; };
									
									
                                                jQuery('input.cityEntrega').val(estado+"**"+cidade); 
                                                calculaFrete();
                                                if(cidade !="" || rua !="" || bairro!="" || estado !="" ){
                                                   endereco = "<span>Referência:   "+rua+" "+bairro+" "+cidade+" "+estado+"</span>";
                                                   jQuery(".endereco").html(endereco);
                                                };     
                                       
                                               jQuery('input#enderecoCad').val(rua);
                                               jQuery('input#cidade').val(cidade);
                                               jQuery('input#bairro').val(bairro);
                                               jQuery("select#estadoUsuario option").filter(function() { return jQuery(this).val() == estado; }).prop('selected', true);
                                          
									     }else{
											 alert('Endereço não encontrado. Verifique o CEP.');
									     }
										  jQuery('.btCalcularFrete').text('Calcular');
											   
                                 });
                          };
               };
            
            
            
            
            
            
            
            
            
             
             
            var loadCep = false;
            jQuery('input.campoCep').focusout(function() {
                   
                     var cepDestino = ""+jQuery(this).val(); 
                       
                               
                     var bairro = "";
                     var cidade = "";
                     var estado = "";
                     var rua = ""; 
                     // Se o campo CEP não estiver vazio
                   	if(cepDestino != "" &&  loadCep ==false   && cepDestino != "undefined" && cepDestino != "undefinedundefined" ){      
                   	                         loadCep = true;
                   	      jQuery('.carregaCep').fadeIn();
                   	    
                          jQuery.getJSON(baseUrl+'shipping/buscaEndereco.php?cep='+cepDestino+'', function(data) {
                   	                  jQuery.each(data, function(key, val) {
                                              if(key=='logradouro'){  rua = ""+val; };
                                              if(key=='bairro'){  bairro = ""+val; };
                                              if(key=='cidade'){  cidade = ""+val; };
                                              if(key=='uf'){  estado = ""+val; };  
                                               jQuery('.carregaCep').fadeOut(); 
                                       });
                                    loadCep = false;
									
									if(rua=='null'){ rua = ''; };
									if(cidade=='null'){ cidade = ''; };
									if(bairro=='null'){ bairro = ''; };
									
                                    jQuery('input#enderecoUsuario').val(rua);
                                    jQuery('input#cidadeUsuario').val(cidade);
                                    jQuery('input#bairroUsuario').val(bairro);
                                    jQuery("select#estadoUsuario option").filter(function() { return jQuery(this).val() == estado; }).prop('selected', true);
                           });
                       };
                       
                       
             });
           
             
              jQuery('input.campoCep2').focusout(function() {

                          var cepDestino = ""+jQuery(this).val();   
                          
                          var bairro = "";
                          var cidade = "";
                          var estado = "";
                          var rua = ""; 
                          // Se o campo CEP não estiver vazio
                        	if(cepDestino != "" &&  loadCep ==false   && cepDestino != "undefined" && cepDestino != "undefinedundefined" ){      
                        	                         loadCep = true;
                        	      jQuery('.carregaCep').fadeIn();

                               jQuery.getJSON(baseUrl+'shipping/buscaEndereco.php?cep='+cepDestino+'', function(data) {
                        	                  jQuery.each(data, function(key, val) {
                                                   if(key=='logradouro'){  rua = ""+val; };
                                                   if(key=='bairro'){  bairro = ""+val; };
                                                   if(key=='cidade'){  cidade = ""+val; };
                                                   if(key=='uf'){  estado = ""+val; };  
                                                    jQuery('.carregaCep').fadeOut(); 
                                            });
                                         loadCep = false;
										 
	 									if(rua=='null'){ rua = ''; };
	 									if(cidade=='null'){ cidade = ''; };
	 									if(bairro=='null'){ bairro = ''; };
									
                                         jQuery('input#enderecoUsuario2').val(rua);
                                         jQuery('input#cidadeUsuario2').val(cidade);
                                         jQuery('input#bairroUsuario2').val(bairro);
                                          jQuery("select#estadoUsuario2 option").filter(function() { return jQuery(this).val() == estado; }).prop('selected', true);
                                         
                                });
                            };


                  });
                  
                  
                  
             
             
             function calculaFrete(){
                                       
                         var cepDestino = ""+jQuery('input.cep').val();       
                        
						   jQuery('p.resultFrete').html('');
						   
                           if(cepDestino=="" || cepDestino =="undefined"){
                                cepDestino = ""+jQuery('input.cepUm').val()+jQuery('input.cepDois').val();  
                              };  
                              
                              
                         if(cepDestino=="" || cepDestino=="undefined" ){
                             cepDestino = ""+jQuery('input#cepUsuario2').val(); 
                                 if(cepDestino=="" || cepDestino=="unefined" ){
                                    cepDestino = ""+jQuery('input#cepUsuario').val();  
                                 } 
                                 
                                
                                     
                         }    
                         
                         var peso = ""+jQuery('input.peso').val();   
                         
                         var cityUserE = ""+jQuery('input.cityEntrega').val();
						 
						 var qtdProdV = ""+jQuery('input#qtdProd').val();
					 
                         var idPrdV  =   ""+jQuery('input.idPrd').val();   
                           
                        if(cepDestino != ""+jQuery('input.cep').attr('title') ){

                         jQuery('.btCalcularFrete').text('Carregando');   

                         jQuery.post(baseUrl+"shipping/frete.php", {CepDestinoR:''+cepDestino+'' ,PesoR:''+peso+'' ,cityUser:''+cityUserE+'',idPrd:idPrdV , qtdProd:qtdProdV} ,
                                    function(data) { 
                                        // alert(data);
                                        jQuery('p.resultFrete').html(data);
                                        jQuery('.btCalcularFrete').text('Calcular');
                                        somaFrete();
                         });

                         };
 
              };
              
              
              
              
                          
     
     
     
     
     
     
     
     
               jQuery('input.radioFrete').change(function(){
				   
                    var relV = ""+jQuery(this).attr('id');
                    var val =  ""+jQuery(this).val().replace(",", ".");
                        val = parseFloat(val);
						 
                    var subtotal = ""+jQuery('.subtotalCart').text().replace(".", "");
                        subtotal = subtotal.replace(",", ".");
                        subtotal = parseFloat(subtotal);
                        
					 
                    var  descontoCart = ""+jQuery('.descontoCart').text().replace(".", "");
                         descontoCart = descontoCart.replace(",", ".");
                         descontoCart  = parseFloat(descontoCart);    
                         
					 
				         var totalCart = subtotal  - descontoCart ;      
						 
					 
						          
                         var valorAdicional  = ""+jQuery('#taxaAdicional').text();
						
						 if(  valorAdicional !="" && val >0){  
					        valorAdicional  = valorAdicional.replace(",", ".");
                            valorAdicional  = parseFloat(valorAdicional);           
                            totalCart = subtotal + valorAdicional  - descontoCart ; 
						 };        
                             
               
                        //parce----------- 
                         var  subtotalCartParc = parseFloat(""+jQuery('.subtotalCartParc').text().replace(",", ".")); 
                       
                         var novaParcela =   ( totalCart / subtotalCartParc );   
                       
                         jQuery('.subtotalCartParcValor').text(""+novaParcela.toFixed(2));  
                           
                       //parce-----------
                    
	 
                    
                     jQuery('.totalCart').text('R$ '+totalCart.toFixed(2));
                     jQuery('.freteInfo').remove();
                     jQuery('<span class="freteInfo" style="font-size:12px">   </span>').insertAfter('.totalCart');
                      
					 pctDesconto = 0;
					 if(jQuery('.pctDesconto').text() !='' &&  jQuery('.pctDesconto').text() != undefined){
				      pctDesconto = parseInt(""+jQuery('.pctDesconto').text());
				     };
					 
					  valorDesconto = totalCart * pctDesconto  / 100;
					  totalCart  -= valorDesconto;
					  totalCart  += val;
				      jQuery('.valorDesconto').text( totalCart.toFixed(2) );
                      jQuery('.totalCart').text('R$ '+totalCart.toFixed(2));
   
                }).change();
                
                
                
                
                
                
                
                
             
                     function somaFrete(){
                         
						 
						  jQuery('.totalCart').text( 'R$ '+jQuery('.totalCart').attr('rel') );
						  
                      jQuery('input.radioFrete').change(function(){
                          var relV = ""+jQuery(this).attr('id');
                          var val =  ""+jQuery(this).val().replace(",", ".");
                              val = parseFloat(val);
                          var subtotal = ""+jQuery('.subtotalCart').text().replace(".", "");
                              subtotal = subtotal.replace(",", ".");
                              subtotal = parseFloat(subtotal);
                              
                          var  descontoCart = ""+jQuery('.descontoCart').text().replace(".", "");
                               descontoCart = descontoCart.replace(",", ".");
                               descontoCart  = parseFloat(descontoCart);    
                               
                              
					         var totalCart = subtotal + val   - descontoCart ;               
 	                         var valorAdicional  = ""+jQuery('#taxaAdicional').text();
							
							 if(valorAdicional !="" && val >0){
						        valorAdicional  = valorAdicional.replace(",", ".");
 	                            valorAdicional  = parseFloat(valorAdicional);           
                                totalCart = subtotal + val + valorAdicional  - descontoCart ; 
							 };            
                           //         
                            
                       
                          
                          //parce----------- 
                             /*     */
                             var  subtotalCartParc = parseFloat(""+jQuery('.subtotalCartParc').text().replace(",", ".")); 
                             
                              var novaParcela =   ( totalCart / subtotalCartParc );   
                             
                               jQuery('.subtotalCartParcValor').text(""+novaParcela.toFixed(2));  
                                 
                             //parce-----------
                              jQuery('.totalCart').text('R$ '+totalCart.toFixed(2));
                          	  jQuery('.freteInfo').remove();
                              jQuery('<span class="freteInfo" style="font-size:12px">   </span>').insertAfter('.totalCart');

                      });

                               var relV = ""+jQuery('input.radioFrete[checked=checked]').attr('id');
                               var val = ""+jQuery('input.radioFrete[checked=checked]').val().replace(",", ".");
                                   val = parseFloat(val);    
                                   
                               var subtotal = ""+jQuery('.subtotalCart').text().replace(".", "");;
                                   subtotal = subtotal.replace(",", ".");
                                   subtotal = parseFloat(subtotal);
                                   
                               var  descontoCart = ""+jQuery('.descontoCart').text().replace(".", "");
                                    descontoCart = descontoCart.replace(",", ".");   
                                    descontoCart  = parseFloat(descontoCart);
								   
							         var totalCart = subtotal + val - descontoCart ;
									 
		 	                         var valorAdicional  = ""+jQuery('#taxaAdicional').text();
									 if(valorAdicional !="" && val >0){
								        valorAdicional  = valorAdicional.replace(",", ".");
		 	                            valorAdicional  = parseFloat(valorAdicional);           
		                                totalCart = subtotal + val + valorAdicional  - descontoCart ; 
									 };            
		                           //   
								 
                                    //parce----------- 
                                    /*     */
                                    var  subtotalCartParc = parseFloat(""+jQuery('.subtotalCartParc').text().replace(",", ".")); 
                                    
                                     var novaParcela =   ( totalCart / subtotalCartParc );   
                                    
                                      jQuery('.subtotalCartParcValor').text(""+novaParcela.toFixed(2));  
                                        
                                    //parce----------- 
                           
                               jQuery('.totalCart').text('R$'+totalCart.toFixed(2));
                               jQuery('.freteInfo').remove();
                               jQuery('<span class="freteInfo" style="font-size:12px">   </span>').insertAfter('.totalCart');



                     };
                     
                     
                     
                     

           
            
            
            
          
            
               jQuery('.btSeguir2').click(function() {
                  
                               resultFrete = ""+jQuery('.resultFrete').text();
                                
                                var Self = jQuery('div.block-content').eq(2);
                                var irpara = parseInt(jQuery('.checkout').offset().top);
                                              
                                if(resultFrete ==""){ 
                                    Self = jQuery('div.block-content').eq(0);
                                    alert('Edite corretamente seu CEP para endereço de entrega.');
                                    irpara =parseInt(jQuery('#entregando').offset().top);
                               };
                                
                                 //if(jQuery('.checkout .block .block-content:visible').is(Self)) return;

                                 jQuery('.checkout .block .block-content:visible').slideUp(300);
                 			     Self.slideDown(300);
                                 jQuery('.msg').html('');
                     
                                 jQuery('html, body').animate({ scrollTop: irpara }, 1000);
                                 
                });
            
                 
                jQuery('.btSeguir3').click(function() {
                      
                                    jQuery('.msg2').html('');

                                    jQuery(".carregando").fadeOut();

                                    //getCidade();
                                    
                                    var cidade="";
                                    var commentOrder = ""+jQuery('#addComentOrder').val();
                                    var radioFreteV = ""+jQuery('input[name=radioFrete]:checked').val();
                                    var varSelect =    jQuery("input[name='tipoPagto']:checked").val();
                                    
                                     goCheckout( radioFreteV , commentOrder , cidade , varSelect );
                                    
																		//redirectCheckout( radioFreteV , commentOrder , cidade , varSelect );
                  
               });    
                  
                  
                  
            
               function redirectCheckout(radioFreteV,commentOrder,cidade,varSelect ){

                              jQuery('.btSeguir3').text('Salvando Pedido...');
                              
                              var url = pgsUrl+"?confirma=true";
                              var form = jQuery('<form action="' + url + '" method="post">' +
                                '<input type="hidden" name="radioFrete" value="' + radioFreteV + '" />'  +
                                    '<input type="hidden" name="commentOrderV" value="' + commentOrder + '" />' +
                                   '<input type="hidden" name="cidadeV" value="' + cidade + '" />' +
                                    '<input type="hidden" name="varSelectV" value="' + varSelect + '" />' +
                                '</form>');
                              jQuery('body').append(form);
                              jQuery(form).submit();
                };
                       
                       
               function goCheckout(radioFreteV,commentOrder,cidade,varSelect ){
                   
                        jQuery('.btSeguir3').text('Salvando Pedido...');
                                     
																		//alert("PREPARANDO : "+radioFreteV+" - "+commentOrder+" - "+cidade+" - "+varSelect );
																		
																		/*
																		
																		alert(baseUrl+"shipping/checkoutAJAX.php");
																		
                                    jQuery.post(baseUrl+"shipping/checkoutAjax.php", { radioFrete:radioFreteV , commentOrderV:commentOrder,cidadeV:cidade,varSelectV:varSelect  } ,
                                               
																							 function(data) { 
                                                   
												                        alert( "RETORNO : "+data );
												   
                                                            arrDat = data.split("-"); 
                                                            arrDat2 = data.split("****"); 
															
                                                            r = parseInt(""+arrDat[0]);
															
                                                            m = ""+arrDat2[0];
                                                            url = ""+arrDat2[1];
                                                            //alert(url);
                                                             if( r <= 0  ){ 
                                                             }else{
                                                               jQuery('.msg2').html(m);  jQuery('.msg2').fadeIn();
                                                               jQuery('.btSeguir3').text('Redirecionando para Pagamento');
                                                               jQuery('<a href="'+url+'">Ou clique aqui para redirecionar</a>').insertAfter(this);
                                                               verificaF(r, url);
                                                             };  

                                    });
																		*/
															
															
															
																		
				    //UP CHECKOUT THEME1 -----------------------------
																		
												
												
												
											              //var  radioFreteV   = ""+jQuery("#vFrete").val();
			                              var tipoPagtoV = ""+varSelect; 
																		var  formaPagamentoV  = ""+jQuery("input[name=formaPagamento]:checked").val();        
			                              var  parcelasV  = ""+jQuery("#parcelas option:selected").val();    
			                              var  codigoBandeiraV   = ""+jQuery("input[name=codigoBandeira]:checked").val(); 
							                     
							 
			                         
			                           url= baseUrl+"saveOrderPayment.php";    
                                         
			                            if(enviando==false){ 
																		enviando = true;
			                              showBigLoad();   
																		goo = false;
																		
											             // alert("VERIFICANDO DADOS PEDIDOS : "+radioFreteV+"-"+tipoPagtoV+"-"+formaPagamentoV+"-"+parcelasV+"-"+codigoBandeiraV );
											   
			                          jQuery.post(url, { radioFrete:radioFreteV, tipoPagto:tipoPagtoV , formaPagamento:formaPagamentoV , parcelas:parcelasV , codigoBandeira:codigoBandeiraV  } , function(data) {
											          
			 											 
			                             hideBigLoad();  
																		
																	 // alert(data);
																	 
			                              enviando = false; 
			                              dataArr = data.split('****');    
			                              numb = parseInt(dataArr[0]);  
			 													    
											
													    
			                              if(numb == 2 ){   
			                                      jQuery('.returnajx').html(dataArr[1]);  
			                                      goo=true;  
			                                      //setTimeout('document.pagseguro.submit()',5000); 
			 														          document.pagseguro.submit();
			                                }; 
                                                     
			                                if(numb == 3 ){   
			                                     jQuery('.returnajx3').html(dataArr[1]);  
			                                     goo=true;
			 															       document.paypal.submit();
			 													      };  
                                                     
			                                  if(numb == 4 ){   
			                                      jQuery('.returnajx4').html(dataArr[1]);  
			                                      goo=true;  
			 														         document.moip.submit();
			 													        };
                                                     
													  
			                                 if(numb == 7 ){   //gerencianet ---- 
			                                     urlRedirect = dataArr[1];  
			 													 	        if(urlRedirect!='undefined' || urlRedirect!=undefined){
			 													   	       window.location = ""+urlRedirect;
			 												            }else{ 
			 																			//alert(urlRedirect); 
			 																    };
			                                      goo=true;  
			 														         //setTimeout('document.moip.submit()',5000); 
			 													      };
																
													      
													             /*   
			 													         formObrigado = "<form action='"+dataArr[2]+"'   method='post'  target='_blank'   id='obrigado' name='obrigado' style='display:none'  ><input type='hidden' name='redurl'  value='"+dataArr[1]+"'/><input type='submit'  value='ir'/></form>";
			 												           jQuery('.returnajx').html(formObrigado); 
			 																	// alert(formObrigado);
			 												       	   //setTimeout( function(){    jQuery( "#obrigado" ).submit();  }, 3000);
			 													         //jQuery( "#obrigado" ).submit(); 
			 																	 document.obrigado.submit();
			 												       	   goo=true; 
															     	 */
													   
			                                    if(goo==false){
			                                        urlRedirect = dataArr[1];   
			 														           if(urlRedirect=='undefined' || urlRedirect==undefined){
			 														   	           window.location = "";
			 														            }else{
			 							                           window.location = ""+urlRedirect;
			 													              };
			 							                          //window.open(urlRedirect,'_blank'); 
			 													          };
													  
													          
													 
                                                     
			                                  });  
			                               };
																		 
																		 						
																		
					 // UP CHECKOUT THEME 1 ------------------------------
																		

                 };
                 
                 
                 function verificaF(formVerifica , url){
                     
                     
                         if(parseInt(formVerifica) > 0){

                         window.location = ''+url+''; 
                          
         			     }else{
         		
         			     jQuery('.msg2').html('<p class="red">'+data+'</p>');  jQuery('.msg2').fadeIn();
         			       
         			     };
         			     
         			     
                 }


          
                   jQuery('.btChangeO').click(function() {
                                  jQuery('.ctChan').hide();
                                   var relProd = ""+jQuery(this).attr('rel');
                                 jQuery('.'+relProd).fadeIn();
                                   
                    });
                                   
                                         
                         
                 jQuery('ul.setas li').click(function() {
                                
                                showBigLoad();
                          
                                var relProd = ""+jQuery(this).attr('rel');
                                var revProd = ""+jQuery(this).attr('rev');
                                var classProd = ""+jQuery(this).attr('class');
								var idProdV = ""+jQuery(this).attr('title');
                                var qtdProd = ""+jQuery('input[title="'+idProdV+'"]').val();
                                		 
                                jQuery.post(baseUrl+"reloadCart.php", { relProdP:relProd , qtdProdP:qtdProd ,revProdP:revProd,classProdP:classProd  },
                                     function(data) { 
                                         
                                         //alert(data);
                                         
                                         if( parseInt(data) >=1 ){
                                          //window.location = location.href;
                                          window.location = '';
										  jQuery('input[title="'+idProdV+'"]').val(data);
                                        
                                         // hideBigLoad();
                                         
                                                    if(classProd =="setaUp"){ 
                                                     jQuery('input[title="'+idProdV+'"]').val( parseInt(qtdProd)+1 );
                                                    }else{
                                                     jQuery('input[title="'+idProdV+'"]').val( parseInt(qtdProd)-1 );  
                                                    }
                                                    
                                         }else{
                                              window.location = '';
											  //window.location = location.href;
                                              jQuery('.alerta').remove();
                                              //hideBigLoad();
                                              jQuery(data).insertAfter('input[title='+idProdV+']');
                                        }
                               });
                               
                              
           
              });
             
             
             
             
			
             
             
             
             
                  jQuery('div.setas span').click(function() {

                                  showBigLoad();

                                    var relProd = ""+jQuery(this).attr('rel');
                                    var revProd = ""+jQuery(this).attr('rev');
                                    var classProd = ""+jQuery(this).attr('class'); 
                                    var idProdV = ""+jQuery(this).attr('title'); 
									var qtdProd = ""+jQuery('input[title="'+idProdV+'"]').val();  
									
								     //  alert(relProd);  alert( revProd); alert(classProd);  alert(qtdProd);  
                                  jQuery.post(baseUrl+"reloadCart.php", { relProdP:relProd , revProdP:revProd,classProdP:classProd,qtdProdP:qtdProd   },
                                       function(data) { 
										   //alert(data);
                                           if( parseInt(data) >=1 ){
                                           //window.location = location.href;
										   window.location = '';
                                           jQuery('input[title="'+idProdV+'"]').val(data);

                                           // hideBigLoad();

                                                      if(classProd =="adicionarItem"){ 
                                                       jQuery('input[title="'+idProdV+'"]').val( parseInt(qtdProd)+1 );
                                                      }else{
                                                       jQuery('input[title="'+idProdV+'"]').val( parseInt(qtdProd)-1 );  
                                                      }

                                           }else{
                                                //window.location = location.href;
											    //window.location = '';
											    jQuery('.alerta').remove();
                                                hideBigLoad();
                                                jQuery(data).insertAfter('input[title="'+idProdV+'"]');
                                          }
                                 });



                });
                
				
				
				
			 
   			 jQuery(".addQtd").focus(function() {
   			      //console.log('in');
   			  }).blur(function() {
   			      //console.log('out');
                     showBigLoad();
              
                     var relProd = ""+jQuery(this).attr('rel');
                     var revProd = ""+jQuery(this).attr('rev');
                     var qtdProd = ''+jQuery(this).val();
					 var idProdV = ""+jQuery(this).attr('title');
					  
                     jQuery.post(baseUrl+"reloadCart.php", { idProd :idProdV, relProdP:relProd , qtdProdP:qtdProd ,revProdP:revProd  },
                          function(data) { 
 
                              if( parseInt(data) >=0 ){
                              //window.location = location.href;
							  window.location = '';
                              jQuery('input[title="'+idProdV+'"]').val(data);

                              // hideBigLoad();

                                         if(classProd =="adicionarItem"){ 
                                          jQuery('input[title="'+idProdV+'"]').val( parseInt(qtdProd)+1 );
                                         }else{
                                          jQuery('input[title="'+idProdV+'"]').val( parseInt(qtdProd)-1 );  
                                         }

                              }else{
                                  //window.location = location.href;
							      //window.location = '';
							      jQuery('.alerta').remove();
                                  hideBigLoad();
                                        jQuery(data).insertAfter('input[title="'+idProdV+'"]');
                             }
                    });
			 
			 
			 
				  
   			  });
             
             
			 
			 
                 
              
              function showBigLoad(){
                 
                  var txt  = "<div id='janela'><div class='popup'><div class='loading'><span>Carregando</span></div></div></div>";
                  jQuery(txt).insertAfter('body');
                  jQuery('#janela').fadeIn();
                  
              };
              
               function hideBigLoad(){

                     jQuery('#janela').fadeOut();
                     jQuery('#janela').remove();

                };

       
       
       
       //LOGIN REGISTRO----------------------------------------------------------------------
       
      
       jQuery('.btForgotPass').click(function() {
           //jQuery('#novoRegistroForm').hide();
    	  jQuery('#loginForm').hide();
       	   jQuery('#forgotPassFormConfirma').hide();
       	   jQuery('#forgotPassForm').fadeIn();	
       });



       jQuery('.btNovoCadastro').click(function() {
                    jQuery('#forgotPassFormConfirma').hide();
                    jQuery('#forgotPassForm').hide();
                    //jQuery('#loginForm').hide();
              	    jQuery('#novoRegistroForm').fadeIn();
       });



       jQuery('.btLogin').click(function() {
             jQuery('#forgotPassFormConfirma').hide();
             jQuery('#forgotPassForm').hide();
             //jQuery('#novoRegistroForm').hide();
       	     jQuery('#loginForm').fadeIn();

       });
       
       
       //FINAL LOGIN REGISTRO --------------------------------------------------------------
       
       
       
      
       
       // FINAL BOTOES PARA ESCOLHER TIPO DE FORM

              // GO LOGIN

              jQuery('#formLogin').validate({

       		 messages:{
                 	emp: "Digite seu email. Não utilize espaços antes ou depois do email."

       		 },

       			  rules: {
       				password: "required",
       				password_again: {
       				equalTo: "#pwp"
       			 }
       		  },

       		 submitHandler: function( form ){  

       		          var email= jQuery('#emp').val();
       		          var pass1 = jQuery('#pwp').val();
       		          
       		          var checkoutV = ""+jQuery('#checkout').val();
                      

                         jQuery('.carregando').fadeIn();     jQuery(".msg").html("");   jQuery(".msg").fadeOut();  
 
                                url= baseUrl+"editLoginAjax.php";
                   
                                jQuery.post(url, { emp:email, pwp:pass1 , checkout:checkoutV } , function(data) {
                                  
                                        dataArr = data.split('****');    
                                        numb = dataArr[0];
                                        urlRedirect = dataArr[1];
 

                                jQuery('.carregando').fadeOut(); jQuery(".msg").fadeOut();  

                                msg = "";

                                if(parseInt(numb)){
                                   msg = "<strong style='color:green'>Seu acesso foi confirmado com sucesso! - Redirecionando... </strong>";
                                   jQuery(".msg").html(msg); jQuery(".msg").fadeIn();  
                             
                                    var timeout = function(){ window.location = urlRedirect+"" };
                                      setTimeout(timeout,1000);
                                

                                   //jQuery('#janela').fadeOut();
                                }else{
                                   msg = "<strong style='color:red'>Houve erros no envio! Tente novamente </strong> | ERRO :"+data;    
                                   jQuery(".msg").html(msg);   jQuery(".msg").fadeIn();     
                                }



                                });




       		        return false;   
                }


       	    });


       		// END GO LOGIN
       		
       		
       		
       		
       		
       		
       		
       		
       			// GO RECOVER

        		jQuery('#formSenha').validate({

        			 messages:{
	                  emailr: "Digite seu email. Não utilize espaços antes ou depois do email."
        			 },

        				  rules: {
        					password: "required",
        					password_again: {
        					equalTo: "#emailr"
        				 }
        			  },

        			 submitHandler: function( form ){  



                           var emailr= ""+jQuery('#emailr').val();

                             jQuery('.carregando').fadeIn();
                             jQuery(".msg").html("");   
                             jQuery(".msg").fadeOut();  

                                    url= baseUrl+"editLostPassAjax.php";   
                             
                                    jQuery.post(url, { emp:emailr  } , function(data) {
                                    
                                
                                    jQuery('.carregando').fadeOut();

                                    msg = "";
                                 
                                    if(parseInt(data)){
                                        
                                        msg = "<strong style='color:green'>Pedido de nova senha realizado com  sucesso! Você receberá um email nos próximos 5 minutos. Caso demore, verifique também em seu filtro de SPAM e assine nosso email  como confiável.  </strong>";
                                        jQuery(".msg").html(msg);
                                        jQuery(".msg").fadeIn();  
                                        
                                     }else{
                                         
                                        msg = "<strong style='color:red'>Houve erros no envio! Tente novamente </strong> | ERRO :"+data;    
                                        jQuery(".msg").fadeIn();
                                        jQuery(".msg").html(msg); 
                                         
                                     }



                                    });


        			        return false;   
                     }


        		});

        		// END GO RECOVER
        		
        		
        		
        		   
        		
        		
        			// GO RECOVER NEW

            		jQuery('#formRSenha').validate({

            			    messages:{
            			        emailrS: "Digite seu email. Não utilize espaços antes ou depois do email."
            				},
                            rules: {
            					pwpR: "required",
            					pwpR2: {
            					equalTo: "#pwpR"
            				    }
            			    },

            			  submitHandler: function( form ){  

                               var pwpR= jQuery('#pwpR').val();
                               var pwpR2= jQuery('#pwpR2').val();
                               var emailr= ""+jQuery('#emailrS').val();
                               var lkV= ""+jQuery('#lk').val();



                                 jQuery('.carregando').fadeIn();     jQuery(".msg").html("");   jQuery(".msg").fadeOut();  

                                        url= baseUrl+"editPassAjax.php";

                                        jQuery.post(url, { emp:emailr ,pwp:pwpR ,pw2p:pwpR2 , lk:lkV } , function(data) {
                                     
                                        dataArr = data.split('****');    
                                        numb = dataArr[0];
                                        urlRedirect = dataArr[1];

                                        jQuery('.carregando').fadeOut();

                                        msg = "";

                                        if(parseInt(numb)){
                                           msg = "<strong style='color:green'>Senha Alterada com Sucesso!</strong>";
                                           jQuery(".msg").html(msg);
                                           window.location =  ''+urlRedirect;
                                        }else{
                                           msg = "<strong style='color:red'>Houve erros no envio! Tente novamente </strong> | ERRO :"+data;    
                                           jQuery(".msg").html(msg);   jQuery(".msg").fadeIn();  
                                        }



                                        });


            			        return false;   
                         }


            		});

            		// END GO RECOVER NEW
            
            
            
            
                      
            
            
            
            
            
            
            
            
            
                     // EDIT PASS

                		jQuery('#formESenha').validate({

                			    messages:{
                			    },
                                rules: {
                					pwpR: "required",
                					pwpR2: {
                					equalTo: "#pwpR"
                				    }
                			    },

                			  submitHandler: function( form ){  

                                   var pwpR= jQuery('#pwpR').val();
                                   var pwpR2= jQuery('#pwpR2').val();
                                            
                                            url= baseUrl+"editUserPassAjax.php";    
                                            
                                            showBigLoad();   
                                            jQuery('.msgRP').html('');   
                                             
                                            jQuery.post(url, {  pwp:pwpR ,pw2p:pwpR2   } , function(data) {
                                             
                                              jQuery('.msgRP').html(data);
                                              hideBigLoad();   
                                              
                                           });


                			        return false;   
                             }


                		});

                		// EDIT PASS
                		
                		
                		
            
            
            
            
            
            
            
                     // GO NEW
                    		jQuery('#formCadastro').validate({

                    			 messages:{
                    					termos: "Para se cadastrar você deve aceitar os termos de uso.",
                    					emailc: "Digite seu email. Não utilize espaços antes ou depois do email.",
                    			 
                    			 },

                    				rules: {
                    					passc: "required",
                    					passc2: { equalTo: "#passc" },
                    				    termos: { required: true,  minlength: 1 }
                                    },

                    			 submitHandler: function( form ){  
                     
                                    var nomeV= ""+jQuery('#nome').val();
                                    var sobrenomeV= ""+jQuery('#sobrenome').val();
										                var emailc= ""+jQuery('#emailc').val();
                    			          var passc = ""+jQuery('#passc').val();
                    			          var pass2c = ""+jQuery('#passc2').val();
                    			          var checkoutV = ""+jQuery('#checkout').val();
                                    var recebaV = "";   
																 
																		 veriBox = parseInt(jQuery('input[name="receba"]').length);
																		 
																		 recebaV = 0;
																		 if( veriBox>0){
																        jQuery(boxes).each(function(){ recebaV = 1; });
																			};
																		
                                     jQuery('.carregando').fadeIn();   
															       jQuery(".msg").html("");    
																	   jQuery(".msg").fadeOut();  
 
																		
												            var che =  Math.random();
												            url = baseUrl+"editCriarLoginAjax.php?che="+che;
												 
							 
                                                 jQuery.post(url, { emp:emailc, pwp:  passc , pw2p: pass2c  , nome:nomeV, sobrenome:sobrenomeV,checkout:checkoutV,receba:recebaV  } , function(data) {

                                                 jQuery('.carregando').fadeOut();

                                                 msg = "";
                                
                                                dataArr = data.split('****');    
                                                numb = dataArr[0];
                                                urlRedirect = dataArr[1];
                                                
                                           
                                                 if(parseInt(numb)){


                                                     msg = "<strong style='color:green'>Seu acesso foi confirmado com sucesso!- Redirecionando...</strong>";
                                                     jQuery(".msg").html(msg);
                                                     var lgan = ''+jQuery('#lganuncio').val();
                                                     var lgan2 = ''+jQuery('#lgsite').val();
                                                   
                                                   
                                                       var timeout = function(){ window.location = urlRedirect; };
                                                       setTimeout(timeout,1000);
                                              
                                                  


                                                 }else{
                                                    msg = "<strong style='color:red'>Houve erros no envio! Tente novamente </strong> | ERRO :"+data;    
                                                    jQuery(".msg").html(msg);    jQuery(".msg").fadeIn();  
                                                 }

                                                  return false;

                                                 });





                    			        return false;   
                                 }


                    		});

                  	    // END GO NEW
                  	    
                  	    
                  	    
            
       		                if ( jQuery.datepicker  ) {   
                   	   jQuery( ".nascC" ).datepicker({
                   	       changeYear: true,
                                          changeMonth: true,
                                          yearRange: '-100:+0'
                       });
				       };



                        
       		
       		
       		            // GO  EDIT DADOS

                              jQuery('#infoPedido').validate({

                                  	 messages:{
                          				    telefoneUsuario: "Digite um número válido. Não utilize espaços antes ou depois do numero.",
                          					telefoneUsuarioCel: "Digite um número válido. Não utilize espaços antes ou depois do numero.", 
                          					userCpf: "Digite um número válido. Não utilize espaços, traços ou pontos antes ou depois dos numeros.",

                          			 }, 

                      			  rules: {
                      			  },

                       		    submitHandler: function( form ){  
                            
                       		        salvarDados();
                       		           
                                       return false;   
                                }


                       	    });


                       		// END GO  EDIT DADOS
       		
       		
       		 

             function msgP(data){
                 jQuery('.msgP').fadeIn();  
                 jQuery('.msgP').html(data);   
                 // setTimeout( function() { jQuery('.msgP').fadeOut(); }, 8000 );
             };


            /*
            function carregarEditarDados(){

                  jQuery('#btSalvarDados').click(function(){
             	    salvarDados();
                  });

            }
            */
            
 
                /*
                jQuery('.btSalvarDados').click(function(){
             	    salvarDados();
                  });
                  */
            
                  function  salvarDados(){
		 
                           //jQuery('#copiarEnderecoC').fadeOut();

                           var arrayData =  new Array();
 
                           jQuery('input.userData').each(function(index) {
                                var id = ""+jQuery(this).attr('id');
                                //var relV = ""+jQuery(this).attr('rel');
                                var text = ""+jQuery(this).val();
                                //jQuery('span#'+relV+'').html(text);
                                arrayData[id+"V"] = text;  
                            }); 
                     
                                   arrayData["sexoUsuarioV"]  =  ""+jQuery("select[name=sexoUsuario] option:selected").val();  
                                   
                                    
                                      
          
                                   var nomeUsuarioV = ""+arrayData['nomeUsuarioV'];
                                   var nascimentoUsuarioV =  ""+arrayData['nascimentoUsuarioV'];
                                   var sexoUsuarioV =  ""+arrayData['sexoUsuarioV'];  
                                   var enderecoUsuarioV  = ""+arrayData['enderecoUsuarioV'];
                                   var enderecoUsuarioNumeroV  = ""+arrayData['enderecoUsuarioNumeroV'];
                                   var complementoUsuarioV =  ""+arrayData['complementoUsuarioV'];
                                   var bairroUsuarioV = ""+arrayData['bairroUsuarioV'];
                                   var cidadeUsuarioV = ""+arrayData['cidadeUsuarioV'];    
                                  
                                   var userCpfV = ""+arrayData['userCpfV'];   
                                   
                                  // var estadoUsuarioV = ""+arrayData['estadoUsuarioV'];
                                  var estadoUsuarioV = ""+jQuery("#estadoUsuario option:selected").val();
                                   
                                   var cepUsuarioV =  ""+arrayData['cepUsuarioV'];
                                   var dddUsuarioV =  ""+arrayData['dddUsuarioV'];
                                   var telefoneUsuarioV= ""+arrayData['telefoneUsuarioV'];
                                   var dddUsuarioCelV =  ""+arrayData['dddUsuarioCelV'];
                                   var telefoneUsuarioCelV= ""+arrayData['telefoneUsuarioCelV'];
                                         
                                   
                                  
                                        var enderecoUsuario2V  = "";
                                        var enderecoUsuarioNumero2V  = "";
                                        var complementoUsuario2V =  "";
                                        var bairroUsuario2V = "";
                                        var cidadeUsuario2V = "";
                                        var estadoUsuario2V = "";  
                                        var estadoUsuario2V  =  ""; 
                                        var cepUsuario2V =  "";
                                      
                                       statusCheck =  jQuery('#abrirEnderecoEntrega').attr('checked');
                                       
                                       if(statusCheck =="checked"){ 
                                                 var enderecoUsuario2V  = ""+arrayData['enderecoUsuario2V'];
                                                 var enderecoUsuarioNumero2V  = ""+arrayData['enderecoUsuarioNumero2V'];
                                                 var complementoUsuario2V =  ""+arrayData['complementoUsuario2V'];
                                                 var bairroUsuario2V = ""+arrayData['bairroUsuario2V'];
                                                 var cidadeUsuario2V = ""+arrayData['cidadeUsuario2V'];
                                                 var estadoUsuario2V  =  ""+jQuery("#estadoUsuario2 option:selected").val(); 
                                                 var cepUsuario2V =  ""+arrayData['cepUsuario2V'];
                                       }else{
                                                var enderecoUsuario2V  = ""+enderecoUsuarioV ;
                                                var enderecoUsuarioNumero2V  = ""+enderecoUsuarioNumeroV;
                                                var complementoUsuario2V =  ""+complementoUsuarioV;
                                                var bairroUsuario2V = ""+bairroUsuarioV;
                                                var cidadeUsuario2V = ""+cidadeUsuarioV;
                                                var estadoUsuario2V =  ""+estadoUsuarioV;
                                                var cepUsuario2V =  ""+cepUsuarioV;
                                       };
                                       
                                      
                                     
																			 
																			 ///alert('Salvando form...');
                                   salvarForm(nomeUsuarioV,nascimentoUsuarioV,sexoUsuarioV,enderecoUsuarioV,enderecoUsuarioNumeroV,complementoUsuarioV,bairroUsuarioV,cidadeUsuarioV,estadoUsuarioV,cepUsuarioV,enderecoUsuario2V,enderecoUsuarioNumero2V,complementoUsuario2V,bairroUsuario2V,cidadeUsuario2V,estadoUsuario2V,cepUsuario2V,dddUsuarioV,telefoneUsuarioV,dddUsuarioCelV,telefoneUsuarioCelV,userCpfV);

                                   //jQuery('#btSalvarDados').remove();
                                  // editOpen = false;

                  };


                  function salvarForm(nomeUsuarioV,nascimentoUsuarioV,sexoUsuarioV,enderecoUsuarioV,enderecoUsuarioNumeroV,complementoUsuarioV,bairroUsuarioV,cidadeUsuarioV,estadoUsuarioV,cepUsuarioV,enderecoUsuario2V,enderecoUsuarioNumero2V,complementoUsuario2V,bairroUsuario2V,cidadeUsuario2V,estadoUsuario2V,cepUsuario2V,dddUsuarioV,telefoneUsuarioV,dddUsuarioCelV,telefoneUsuarioCelV,userCpfV){
                           
													 
													 jQuery(".carregando").fadeIn();   
                          
                           jQuery.post(baseUrl+"editAjaxDadosUsuario.php", {nomeUsuario:nomeUsuarioV,nascimentoUsuario:nascimentoUsuarioV,sexoUsuario:sexoUsuarioV,enderecoUsuario:enderecoUsuarioV,enderecoUsuarioNumero:enderecoUsuarioNumeroV,complementoUsuario:complementoUsuarioV,bairroUsuario:bairroUsuarioV,cidadeUsuario:cidadeUsuarioV,estadoUsuario:estadoUsuarioV,cepUsuario:cepUsuarioV,enderecoUsuario2:enderecoUsuario2V,enderecoUsuarioNumero2:enderecoUsuarioNumero2V,complementoUsuario2:complementoUsuario2V,bairroUsuario2:bairroUsuario2V,cidadeUsuario2:cidadeUsuario2V,estadoUsuario2:estadoUsuario2V,cepUsuario2:cepUsuario2V,dddUsuario:dddUsuarioV,telefoneUsuario:telefoneUsuarioV,dddUsuarioCel:dddUsuarioCelV,telefoneUsuarioCel:telefoneUsuarioCelV,userCpf:userCpfV },
                              
                              function(data) {  
                                     
                              jQuery(".carregando").fadeOut();
                             
                              msgP(data); 
                              
                              
                              //jQuery('.btEditarDatos').fadeIn();
                              
                               if( cepUsuario2V !='undefined' ){
                               jQuery('input.cep').val(cepUsuario2V);
                               jQuery('.cepEntrega').text(cepUsuario2V);
                               };    
                               
                               
                               getEndereco(); 
                               
                               
                               
                                    var checkout = jQuery('#checkout').val();
          		         
          		                        if(checkout=='TRUE'){  
          		                                  calculaFrete();
          		                                  var Self = jQuery('div.block-content').eq(1);
                                                  var irpara = parseInt(jQuery('.checkout').offset().top);
                                                  jQuery('html, body').animate({ scrollTop: irpara }, 1000);
                                                  //if(jQuery('.checkout .block .block-content:visible').is(Self)) return;
                                                  jQuery('.checkout .block .block-content:visible').slideUp(300);
                                   			      Self.slideDown(300);
                                                  jQuery('.msg').html('');
                                       };
                               
                               
                               
                           });
                  };

            /*FINAL EDITAR DADOS -------------------------- --------*/
            
            
            
            
            //CHECKOUT -------------------------------------------------
            
            
        	    jQuery('.checkout .block').not(jQuery('.checkout .block:first')).find('.block-content').hide();	
        		
        		
        		
        		jQuery('.checkout .block .block-head').click(function(){
        		    
        		    jQuery('.carregando').hide(); 
        		    jQuery('.msgP').text('');
        		    jQuery('.msg2').text('');
        		     
        			var Self = jQuery(this).next().find('.block-content');
        			
        			   var Self = jQuery('div.block-content').eq(0);

        			irpara = parseInt(jQuery('.checkout').offset().top);
                    jQuery('html, body').animate({ scrollTop: irpara }, 1000);
       


        			if(jQuery('.checkout .block .block-content:visible').is(Self)) return;

        			jQuery('.checkout .block .block-content:visible').slideUp(300);
        			
        			Self.slideDown(300);	
        			       	
        		 });


                 
              jQuery('#copiarEndereco').change(function() {
                      var statusCheck = jQuery(this).attr('checked');
                      if(statusCheck =="checked"){ 
                          var endereco = jQuery('#enderecoUsuario').val(); 
                          jQuery('#enderecoUsuario2').val( endereco );
                          var numero = jQuery('#enderecoUsuarioNumero').val();  
                          jQuery('#enderecoUsuarioNumero2').val( numero );
                          var complemento = jQuery('#complementoUsuario').val();  
                          jQuery('#complementoUsuario2').val( complemento );
                          var bairro = jQuery('#bairroUsuario').val();  
                          jQuery('#bairroUsuario2').val( bairro );
                          var cidade = jQuery('#cidadeUsuario').val(); 
                          jQuery('#cidadeUsuario2').val( cidade );
                          var estado = jQuery('#estadoUsuario').val();  
                          jQuery('#estadoUsuario2').val( estado );
                          var cep = jQuery('#cepUsuario').val();  
                          jQuery('#cepUsuario2').val( cep );
                          //salvarDados();
                      };
               });
            
                
             
               jQuery('#abrirEnderecoEntrega').change(function() {
                         var statusCheck = jQuery(this).attr('checked');
                         if(statusCheck =="checked"){      
                              //jQuery('#enderecoUsuario2').val( '' );
                             // jQuery('#enderecoUsuarioNumero2').val('');
                             // jQuery('#complementoUsuario2').val( '');
                              //jQuery('#bairroUsuario2').val( '');
                              //jQuery('#cidadeUsuario2').val( '' );
                              //jQuery('#estadoUsuario2').val( '');
                             // jQuery('#cepUsuario2').val( '' );
                                                
                                        
                              jQuery('.contentDadosEntrega').fadeIn(); 
                         }else{
                             jQuery('.contentDadosEntrega').hide();   
                         }
                  });
                  
                  




            //CHECKOUT ---------------------------------------------------
            
            
            
            //consulta descontos
            
            jQuery('.btCalcularDesconto').click(function(){
                
                    var cupomV = jQuery('#cupom').val();
                    
                    jQuery(this).text('Carregando...');
                 
                              url= baseUrl+"consultaDescontoAjax.php";
                              
                              
                              jQuery.post(url, { cupom:cupomV } , function(data) {
                                  
																themefolder = jQuery('.themefolder').val();
																if(themefolder=='loja1'){
																	jQuery('.retCupom').text(data);
																}else{
																	alert(themefolder);
																}
																 //window.location = self.location; 
                  
                              });
           
            });
            
            
            //consulta desconto
            
            
            
            //FILTRO PESQUISA
            
            
                   var tamanhoOpen = false;
                
                    
                       jQuery('.expandirT').click(function(){
                           key = jQuery(this).attr('rel');
                           
                           if(tamanhoOpen==false){
                           jQuery('.'+key).fadeIn();
                           tamanhoOpen = true;
                           }else{
                           jQuery('.tamanhoSelect .hide').hide(); 
                           tamanhoOpen = false;
                           };
                      });
            
     
                         var corOpen = false;
                         
                      jQuery('.expandirC').click(function(){
                               key = jQuery(this).attr('rel');
                               if(corOpen==false){
                                 jQuery('.'+key).fadeIn();
                                 corOpen = true;
                               }else{
                                  jQuery('.corSelect .hide').hide();
                                  corOpen = false;
                               };
                        });
            
            
               showCamisaMedida = false;
               
 



               jQuery('.camisaMedida').click(function(){
                   
                    if(showCamisaMedida==false){
                      
                      urlImg = ""+jQuery('#tabelaMedida').val();
                      htmlTabelaMedidas = "<div  class='containerMedidas'><p class='btFecharMedidas'></p><img src='"+urlImg+"' /></div><div id='fade' class='white_overlay'></div>";
                      jQuery('body').append( htmlTabelaMedidas );
                      jQuery('.containerMedidas,.white_overlay').fadeIn();
                      loadBtFecharTabelaTamanho();
                      showCamisaMedida = true;
                      
                      
                    }else{
                        
                      jQuery('.containerMedidas,.black_overlay').hide();
                      jQuery('.containerMedidas').remove();
                      jQuery('.white_overlay').remove();
                      showCamisaMedida = false;
                      
                    };

                });
            
            
            function loadBtFecharTabelaTamanho(){
            jQuery('.btFecharMedidas').click(function(){
                   jQuery('.containerMedidas,.white_overlay').hide();
                   showCamisaMedida = false;
            });
           };
            
            
                   subFechado = true;
                   jQuery('.temaSelect p.ativo').click(function(){
                             if(subFechado==true){
                               jQuery('.temaSelect p.sub').fadeIn();
                               subFechado = false;
                             }else{
                               jQuery('.temaSelect p.sub').fadeOut();    
                                subFechado = true;
                             }
                           
                    }); 
                    
                    
                       jQuery('.temaSelect p.sub').click(function(){
                                  valor = jQuery(this).text();
                                  jQuery('.temaSelect p.ativo').text(valor);
                                  jQuery('.temaSelect p.ativo').attr('rel',jQuery(this).attr('rel') );
                                  jQuery('.temaSelect p.sub').fadeOut();    
                                  subFechado = true;
                                  carregaFiltro();
                       });   
                            
                
                       jQuery('.tamanhoSelect li').click(function(){
                                 jQuery('.tamanhoSelect li').removeClass('ativo');
                                 jQuery(this).addClass('ativo');
                                 carregaFiltro();
                        });
                        
                        jQuery('.corSelect li').click(function(){
                                jQuery('.corSelect li').removeClass('ativo');
                                jQuery(this).addClass('ativo');
                                carregaFiltro();
                        });
                           
                           
                            
                        function carregaFiltro(){
                                tema =  ""+""+jQuery('.temaSelect p.ativo').attr('rel');
                                tamanho =  ""+jQuery('.tamanhoSelect li.ativo').attr('rel');
                                cor =  ""+jQuery('.corSelect li.ativo').attr('rel');
                                currentCat = ""+jQuery('#currentCat').val();
                                //alert(""+tema+""+tamanho+""+cor);
                                //alert( currentCat);
                                      url= baseUrl+"consultaFiltroBusca.php";

                                     showBigLoad();

                                      jQuery.post(url, { temaV:tema,tamanhoV:tamanho,corV:cor,currentCatV:currentCat } , function(data) {
                                           jQuery('.produtosRecentes').hide();
                                           jQuery('.produtosRecentes').html(data);
                                           jQuery('.produtosRecentes').fadeIn();
                                           hideBigLoad(); 
                                       });
                         }
                         
                         
                         
                         
                               jQuery('.botaoEntrega').click(function(){  
                                           
                                           var  idEV=""+jQuery(this).attr('rel');
										   
			                               var  radioFreteV   = ""+jQuery("input[name=radioFrete]:checked").val(); 
                                           var  radioFreteR   = ""+jQuery("input[name=radioFrete]:checked").attr('rel'); 
										   
										   //alert(idEV);
										   
										   showBigLoad();
                                          
                                               url= baseUrl+"defineEntregaPedido.php";

                                               jQuery.post(url, {idE:idEV,radioFrete:radioFreteV,radioFreteNome:radioFreteR} , function(data) {
                                                    // hideBigLoad();
                                                      //alert( data);
                                                      dataArr = data.split('****');    
                                                      numb = dataArr[0];
                                                      urlRedirect = dataArr[1];
                                                      window.location = ""+urlRedirect; 
                                               }); 
										   
                                               
                               });      
                               
                                 
                        //SOMENTE NUMEROS FIELD ----------------------------
                        
                        jQuery(".somenteNumeros").keydown(function(event) {
                                // Allow: backspace, delete, tab, escape, and enter
                                if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || 
                                     // Allow: Ctrl+A
                                    (event.keyCode == 65 && event.ctrlKey === true) || 
                                     // Allow: home, end, left, right
                                    (event.keyCode >= 35 && event.keyCode <= 39)) {
                                         // let it happen, don't do anything
                                         return;
                                }
                                else {
                                    // Ensure that it is a number and stop the keypress
                                    if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                                        event.preventDefault(); 
                                    }   
                                }
                            });
                            //SOMENTE NUMEROS FIELD ---------------------------- 
                            
                            
                               
                               
                        
                        //PAGAMENTO ----------------------------------------------------------------------     
                        var enviando = false;    goo=false;
						
						//escolhendo janela Pagto ---
						jQuery('.tipo').click(function(){    
							
							var tipoPagtoV = ""+jQuery(this).attr('rel'); 
							jQuery('.tipo').removeClass('active');
							jQuery(this).addClass('active');
							
							jQuery('.formaDet').hide();
							jQuery('#'+tipoPagtoV+'Box').stop().fadeIn();
						 
						});
						//escolhendo janela Pagto ---
							
                          jQuery('.checkPagto').click(function(){         
                          
                             var tipoPagtoV = ""+jQuery(this).attr('rel'); 
                             var  formaPagamentoV  = ""+jQuery("input[name=formaPagamento]:checked").val();           
                             var  parcelasV  = ""+jQuery("#parcelas option:selected").val();    
                             var  codigoBandeiraV   = ""+jQuery("input[name=codigoBandeira]:checked").val(); 
							 
							 
                             //var  radioFreteV   = ""+jQuery("input[name=radioFrete]:checked").val();
							   var  radioFreteV   = ""+jQuery("#vFrete").val();
							   //alert(radioFreteV);
							   //   
                                         url= baseUrl+"saveOrderPayment.php";    
                                         
                                         if(enviando==false){ enviando = true;
                                               showBigLoad();   goo = false;
											 
											  // alert(radioFreteV+"-"+tipoPagtoV+"-"+formaPagamentoV+"-"+parcelasV+"-"+codigoBandeiraV );
											   
                         jQuery.post(url, { radioFrete:radioFreteV, tipoPagto:tipoPagtoV , formaPagamento:formaPagamentoV , parcelas:parcelasV , codigoBandeira:codigoBandeiraV  } , function(data) {
											          
													 // alert(data);
													   
                             hideBigLoad();  
                             enviando = false; 
                             dataArr = data.split('****');    
                             numb = parseInt(dataArr[0]);  
													   //alert(data);
													   
													 
                             if(numb == 2 ){   
                                     jQuery('.returnajx').html(dataArr[1]);  
                                     goo=true;  
                                     // setTimeout('document.pagseguro.submit()',5000); 
														         document.pagseguro.submit();
                               }; 
                                                     
                               if(numb == 3 ){   
                                    jQuery('.returnajx3').html(dataArr[1]);  
                                    goo=true;
															      document.paypal.submit();
													     };  
                                                     
                                 if(numb == 4 ){   
                                     jQuery('.returnajx4').html(dataArr[1]);  
                                     goo=true;  
														         document.moip.submit();
													      };
                                                     
													  
                                if(numb == 7 ){   //gerencianet ---- 
                                    urlRedirect = dataArr[1];  
													 	        if(urlRedirect!='undefined' || urlRedirect!=undefined){
													   	       window.location = ""+urlRedirect;
												            }else{ 
																			alert(urlRedirect); 
																    };
                                     goo=true;  
														         //setTimeout('document.moip.submit()',5000); 
													      };
																
													      
													         
													         formObrigado = "<form action='"+dataArr[2]+"'   method='post'    id='obrigado' name='obrigado' style='display:none'  ><input type='hidden' name='redurl'  value='"+dataArr[1]+"'/><input type='submit'  value='ir'/></form>";
												           jQuery('.returnajx').html(formObrigado); 
																	// alert(formObrigado);
												       	   //setTimeout( function(){    jQuery( "#obrigado" ).submit();  }, 3000);
													         //jQuery( "#obrigado" ).submit(); 
																	 document.obrigado.submit();
												       	   goo=true; 
																
													   
                                   if(goo==false){
                                       urlRedirect = dataArr[1];   
														           if(urlRedirect=='undefined' || urlRedirect==undefined){
														   	           window.location = "";
														            }else{
							                           window.location = ""+urlRedirect;
													              };
							                          //window.open(urlRedirect,'_blank'); 
													          };
													  
													  
													 
                                                     
                                 });  
                              };
                           return false; 
                          }); //CLICK
                        //PAGAMENTO -----------------------------------------------------------------------      
                        
                                          
               
                       jQuery('.bSearchOrder').click(function(){
                                            
                                             url= baseUrl+"getOrderUser.php";    
                                              oidV = jQuery('#numPedido').val();
                                             if(enviando==false){ enviando = true;
                                                   showBigLoad();  
                                               jQuery.post(url, { oid:oidV   } , function(data) {
                                                          hideBigLoad(); 
                                                          jQuery('#contentOrders').html(data); 
                                                          enviando = false; 
                                                });  
                                           };
                                           return false;  
                                           
                       });
                       
                       
                       jQuery('.sendAvalProd').click(function(){     
                           
                                                var oidV = ""+jQuery("#orderNum").val();
                                                var idpV = ""+jQuery(this).attr('rel');
                                                var avaliacaoV  = ""+jQuery("#avaliacao"+idpV).val();   
                                                
                                                url= baseUrl+"setAvaliacaoProduto.php";    
											 
                                               if(enviando==false){ enviando = true;
                                                      showBigLoad();  
                                                  jQuery.post(url, { oid:oidV ,idp:idpV , avaliacao:avaliacaoV   } , function(data) {
                                                             hideBigLoad(); 
															 //alert(data); 
                                                             enviando = false; 
                                                   });  
                                              };
                                              return false;  

                          });
                          
                                      
                            
                             
                             
                                                       
                       jQuery('.facebook_connect').click(function(){
                                showBigLoad();   
                       }); 
                    
                    
                       jQuery('.facebook_connect2').click(function(){
                                     showBigLoad();   
                        });
                         
			 
	
						jQuery( ".btlightboxprod" ).click(function(){
							/**/
							  jQuery('#contentLight').html(''); 
							  jQuery('.carregando').fadeIn();
                              url= baseUrl+"previewProduct.php";
							oidV = ""+jQuery(this).attr('rel');   
                            
                               jQuery.post(url, { oid:oidV } , function(data) {
								  jQuery('#contentLight').html(data);
								    startVariacaoTamanhoCor();
								    btComprar();
									btIndisponivel();
									
									 if ( jQuery.swipebox  ) {  jQuery(".group").swipebox(); };	
									 
									    jQuery('.carregando').fadeOut();
                               });  
							   
						    lightbox_open(); 
							
						 });
						
						
						
						
						
 						jQuery( ".btEditarQdt" ).click(function(){
							
 							 
							  oidVC = ""+jQuery(this).attr('rel'); 
							  oidV = ""+jQuery(this).attr('rev'); 
							   
							  jQuery('#contentLight').html(''); 
 							  jQuery('.carregando').fadeIn();
							  
                              url= baseUrl+"changeProductInCart.php";
							 
 							  jQuery.post(url, { oid:oidV , oidC:oidVC } , function(data) {
 								 jQuery('#contentLight').html(data);
 								    startVariacaoTamanhoCor();
 								    btAlterar();
 									btIndisponivel();
 										 if ( jQuery.swipebox  ) {  jQuery(".group").swipebox(); };
 									     jQuery('.carregando').fadeOut();
                                });  
							   
 						         lightbox_open(); 
 						 });
						 
						 
						 
						 
						 
						 
						 
						 
	
						jQuery(".lightbox_close").click(function(){
					       lightbox_close();
						});
						jQuery("#fecharLight").click(function(){
					       lightbox_close();
						});
	
							function lightbox_open(){ 
							    window.scrollTo(0,0);
							    jQuery('#light').stop().fadeIn();
							    jQuery('#fade').stop().fadeIn(); 
							}
	
	
							function lightbox_close(){
							    jQuery('#light').stop().fadeOut();
							    jQuery('#fade').stop().fadeOut();
							}
							
							
						    var limitAge = ""+jQuery('meta[name=limitAge]').attr("content");
							if(limitAge=="18"){
								limitAge = "-"+limitAge+"Y";
							}else{
								//limitAge = "-1Y";
							}
							
							
	                       if ( jQuery.datepicker  ) {   
						  jQuery( ".datepicker" ).datepicker({
						      dateFormat: 'dd/mm/yy',
						      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
						      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
						      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
						      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
						      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
						      nextText: 'Próximo',
						      prevText: 'Anterior',
							  changeYear: true,
                              changeMonth: true,
							  yearRange: '-100:+0',
							  minDate: new Date(1900,1-1,1), 
							  maxDate: ''+limitAge, 
                      	     
						  });
					      };
						  
						  
		   
			              //BT COMPRAR--------------------------
			                 function btAlterar(){
				                        jQuery('.btAlterar').click(function(){
											
											
	  				                      var variacaoCorP = "";
	  				                      var variacaoTamanhoP = "";
                  
	  				                      var qtdProdutoV = ''+jQuery('#qtdProd').val();
                                          var postIDP = ""+jQuery('#idP').val();
                  
	  				                     /// alert(postIDP); alert(variacaoP);
             
	  				                      var ed = false;
	  				                      var msg = "";
										  
										  
	 				                     jQuery('p.msg').html(''); jQuery('p.msg').hide();
                  
          
				                     
	 				                      if(  verificaCor() <1 && verificaTamanho()<1  ){
	 				                           ed = true;
	 				                      }else{
                      
	 				                          var vC = parseInt(verificaCor());
	 				                          if(vC>=1){
	 				                                ativo = ""+jQuery('ul.cores li.ativo').attr('rel');    
	 				                                if(ativo=='undefined'){
	 				                                      msg = "Escolha uma cor disponível.";
	 				                                 }else{
	 				                                       variacaoCorP = ativo;
	 				                                 }
	 				                          }; 
                      
	 				                          var vT =  parseInt(verificaTamanho());
	 				                           if(vT>=1){
	 				                                  ativo = ""+jQuery('ul.tamanhos li.ativo').attr('rel'); 
	 				                                  if(ativo=='undefined'){
	 				                                      if(msg ==""){
	 				                                       msg = "Escolha um tamanho disponível.";
	 				                                      }else{
	 				                                       msg = "Escolha uma cor e tamnho disponível.";   
	 				                                      };
	 				                                  }else{
	 				                                       variacaoTamanhoP = ativo; 
	 				                                  }
	 				                             };
                        
	 				                         };
											 
											 
											 
											 
					  
					  
					                         if(msg ==""){ ed = true;   };
  
  
					                         if(ed ==true){
												showBigLoad();
					 
		   				   					    var idProdInCartV = ""+jQuery(this).attr('rel');
		   				                        var idProdV = ""+jQuery(this).attr('rev');
		 
		   				                          jQuery.post(baseUrl+"reloadCartEdit.php", {idProdInCart:idProdInCartV,idProd :idProdV,variacaoCor:variacaoCorP,variacaoTamanho:variacaoTamanhoP,qtdProduto:qtdProdutoV},
		   				                               function(data){
														  // alert("BBB-"+data);
													 	    hideBigLoad();
                                                           if( parseInt(data) >=1 ){ 
		   				                                       window.location = '';
															   //window.location = location.href;
		   				                                   }else{
		   				                                   	
										                       jQuery('.msg').html(data);
										                       jQuery('.msg').fadeIn();
															   
		   				                                   };
														
												  });
											
					   						 }else{
											   
						                       jQuery('.msg').html("<span style='color:red'>"+msg+"</span>");
						                       jQuery('.msg').fadeIn();
											   
					   						 }
										
		 
									    });
							 };
		  
			    		  // btAlterar();
 
					  	jQuery("li.precoAlt").click(function(){
					  		precoAlt = jQuery(this).find("span.precoAlt").attr('rel');
							precoAlt = precoAlt.replace('.',''); 
							precoAlt = precoAlt.replace(',','.'); 
							precoAlt = parseFloat(precoAlt); 
					  		//alert(precoAlt);
					  	});
	
	
	
					  	jQuery(".enviarRevisao").click(function(){
							alert('enviando solicitação');
                              url= baseUrl+"enviarSolicitacaoVerificacao.php";
						 
							  jQuery.post(url, {  } , function(data) {
								   window.location = "";
							  });  
						
						
						});
						
						
	
}); 