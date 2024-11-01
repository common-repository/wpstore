<?php
 
if($freteGratis == false){ 
	
    $moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
    if($moedaCorrente==""){
      $moedaCorrente = "R$" ; 
    }
	
	require_once('rsCorreios.php');

	 $freteRs = new RsCorreios();

	/*
	
	 $resposta = $freteRs
	     ->setCepOrigem('88101000')
	     ->setCepDestino('01310200')
	     ->setLargura('15')
	     ->setComprimento('20')
	     ->setAltura('5')
	     ->setPeso('1')
	     ->setFormatoDaEncomenda(RsCorreios::FORMATO_CAIXA)
	     ->setServico(empty($tipo) ? RsCorreios::TIPO_PAC : $data['tipo'])
	     ->dados();

	 // Imprime na tela o resultado obtido:

	 echo "Servi&ccedil;o: " . $resposta['servico'] . " <br />";
	 echo "Valor do Frete: " . $resposta['valor'] . " <br />";
	 echo "Prazo de Entrega: " . $resposta['prazoEntrega'] . " <br />";
	 echo "M&atilde;o Pr&oacute;pria: " . $resposta['maoPropria'] . " <br />";
	 echo "Aviso de Recebimento: " . $resposta['avisoRecebimento'] . " <br />";
	 echo "Valor Declarado: " . $resposta['valorDeclarado'] . " <br />";
	 echo "Entrega Domiciliar: " . $resposta['entregaDomiciliar'] . " <br />";
	 echo "Entrega S&aacute;bado: " . $resposta['entregaSabado'] . " <br />";
	 echo "Erro: " . $resposta['erro'] . " <br />";
	 echo "Mensagem de Erro: " . $resposta['msgErro'];
 
  
       echo "$origemCep  ****  $destinoCep **** $peso ****  $cidade";
	      */ 
	 
        $alturaS =  get_option('alturaEmbalagemCorreios');
        $larguraS= get_option('larguraEmbalagemCorreios');
        $comprimentoS = get_option('comprimentoEmbalagemCorreios');
 
	 
	   $arrSedex = $freteRs
	     ->setCepOrigem("".$CEP_ORIGEM)
	     ->setCepDestino("".$CEP_DESTINO)
	     ->setLargura("".$larguraS)
	     ->setComprimento("".$comprimentoS)
	     ->setAltura( "".$alturaS )
	     ->setPeso("".$PESO)
	     ->setFormatoDaEncomenda(RsCorreios::FORMATO_CAIXA)
	     ->setServico(empty($tipo) ? RsCorreios::TIPO_SEDEX : $data['tipo'])
	     ->dados();
	   
	   
       $valorSedex =  $arrSedex['valor'];    
	   
	   
	   $arrPac = $freteRs
	     ->setCepOrigem($CEP_ORIGEM)
	     ->setCepDestino($CEP_DESTINO)
	     ->setLargura($larguraS)
	     ->setComprimento($comprimentoS)
	     ->setAltura( $alturaS)
	     ->setPeso($PESO)
	     ->setFormatoDaEncomenda(RsCorreios::FORMATO_CAIXA)
	     ->setServico(empty($tipo) ? RsCorreios::TIPO_PAC : $data['tipo'])
	     ->dados();
	   
	  $valorPac = $arrPac['valor'];   
	  

	
	  
      $arrESedex = $freteRs
        ->setCepOrigem($CEP_ORIGEM)
        ->setCepDestino($CEP_DESTINO)
        ->setLargura($larguraS)
        ->setComprimento($comprimentoS)
        ->setAltura( $alturaS)
        ->setPeso($PESO)
        ->setFormatoDaEncomenda(RsCorreios::FORMATO_CAIXA)
        ->setServico(empty($tipo) ? RsCorreios::TIPO_ESEDEX: $data['tipo'])
        ->dados();
   
      $valorESedex = $arrESedex['valor'];   
  
  
	
	
	
	
   //Prazo: $prazoSedex
      //Prazo:'.$prazoPac.' 
      $PAC = "";
	  $prazoSedexT =  "";
 
 if($peso<30){ 
   
 
   
      $PAC = "<input type='radio' name='radioFrete'  class='radioFrete'    rel='Pac'  id='Pac' value='".$valorPac."'  /> <span class='reduzir'>PAC </span>:  $moedaCorrente <span  class='red' id='valorFretePAC' >".$valorPac."</span><br/> <small class='prazoEntrega'> Capitais : 3 a 7 dias <br/> Interior : 7 a 10 dias. </small><hr/> ";  

  	   $prazoSedexT =  "<small class='prazoEntrega'> Capitais: 1 a 3 dias úteis <br/>  Interior : 2 a 5 dias úteis</small>";
   
   
 }else{
 	$prazoSedexT =  "<small class='prazoEntrega'> Prazo  Transportadora : Até 30 dias úteis.</small>";
	
	$pesoReal = intval($pesoReal/$peso);
	
	$valorSedex = floatval($valorSedex)*$pesoReal;
    $valorSedex= number_format( $valorSedex, 2 ,  '.', '');
	
	$valorESedex = floatval($valorESedex)*$pesoReal;
    $valorESedex= number_format( $valorESedex, 2 ,  '.', '');
	
	
	
    //IMPOSTO ADICIONAL: -------------------------------
	$impostoAddTexto = get_option('impostoAddTexto');
	$impostoAddPct = floatval(get_option('impostoAddPct'));
	$impostoAddRegiao = get_option('impostoAddRegiao');
	
	 
    $cidadesFreteAdicional= $impostoAddRegiao ;
	
	$regiao = "";
	$valorAdd = "";
    $addCobranca = false;
    $arrayEstadosCidades = explode(',',$cidadesFreteAdicional);       

    foreach($arrayEstadosCidades as $item=>$value){    
   
        $arrayValue = explode('**',$value);   
   
           $estadoAdd = trim($arrayValue[0]);  
   
           $cidadeAdd  = trim($arrayValue[1]); 
		   
		   if($estadoAdd == $cidadeAdd && $estadoAdd !=""){
		   	
 	           if(  modificaAcento(strtolower($estado)) == modificaAcento(strtolower($estadoAdd)) ){   
 	              $addCobranca = true; 
				  $regiao .="$estado, ";
 	           };
			  
		   }else{
			   
 	          if(  modificaAcento(strtolower($cidadeUserF)) == modificaAcento(strtolower($value)) ){   
 	                $addCobranca = true; 
					$cidadeUs = str_replace('**','()',$cidadeUserF);
				    $regiao .="$cidadeUserF), ";
 	          };
		   	
		   };
           
    }
     
    $valorAdd = custom_get_total_price_session_order();
	if(strlen($valorAdd)>6){
     $valorAdd= str_replace('.','',$valorAdd);
    };  
    $valorAdd= floatval(str_replace(',','.',$valorAdd));//CENTAVOS CIELO
	$valorAdd +=$valorSedex;	
	$valorAdd = $valorAdd*$impostoAddPct/100;
	$valorAdd = number_format($valorAdd, 2 ,  '.', '');
	
	//if(current_user_can( 'manage_options' ) ){
		if ( $addCobranca ==true) {
		$cobrancaAdicional = "<span class='red'>Outras Taxas</span> :   $moedaCorrente<span id='taxaAdicional'>$valorAdd</span> <br/><small>  $impostoAddTexto , alicota de $impostoAddPct% sobre valor da nota fiscal  nas seguintes  regiões :  $regiao </small>";
	    };
	//};
	//IMPOSTO ADICIONAL -----------------------------------
	
	
	
	
 }
 

    $SEDEX = " <input type='radio'  name='radioFrete' class='radioFrete'    rel='Sedex' id='Sedex' value='".$valorSedex."'   checked='checked' />  <span class='reduzir'>SEDEX / TRANSPORTADORA</span>  : $moedaCorrente <span  class='red'  id='valorFreteSEDEX' >".$valorSedex."</span>  <br/>
		<small class='prazoEntrega'>  Capital 1 a 3 dias úteis. Interior 2 a 5 dias úteis.</small> <hr/> ";   
 
 
 
 
 $ctCorreiosCod =get_option('ctCorreiosCod');
 $ctCorreiosPass =get_option('ctCorreiosPass');
 
 if($ctCorreiosCod !='' && $ctCorreiosPass !=''){
	 
     $ESEDEX = "";
 
	  if(floatval($valorESedex)<=0){
		//$valorESedex = floatval($valorSedex)/2;
		//$valorESedex = number_format($valorESedex, 2 ,  '.', '');
	  }else{
         $ESEDEX = "  <div style='padding-top:5px''><input type='radio'  name='radioFrete' class='radioFrete'  checked='checked'  rel='ESedex' id='ESedex' value='".$valorESedex."' />   E-SEDEX : $moedaCorrente <span  class='red'  id='valorFreteSEDEX' >".$valorESedex."</span>  <br/>  <small class='prazoEntrega'> Capital 1 a 3 dias úteis. Interior 2 a 5 dias úteis.</small> <hr/> </div>";   
      };
};


 
	$retirarLoja =get_option('retirarLoja');

	$linkLojas = get_permalink(get_option('idPaginaRetiradaLojaWPSHOP')); 
 
	if($checkoutPagto !=true){

		echo'<div id="retorno" style="font-size:16px">';
		
		
		global $current_user;
		get_currentuserinfo();
		$autorizacao = get_usermeta($current_user->ID, 'wpsAutorizacao');
	 
	
	if($retirarLoja=='retirarLoja'  || $autorizacao == "Confirmado" ){
	 echo "<div style='padding-top:5px'><input type='radio'  name='radioFrete' class='radioFrete'  checked='checked'  rel='retirarLoja' id='retirarLoja' value='0.00' />
	 <span class='green' style='font-size:0.7em'>** Vou retirar a mercadoria na loja (Sem frete):  <a href='".$linkLojas."' target='_blank'>Consulte lojas </a></span></div><br/><hr/>";
	};
	
	
 
		echo  ''.$PAC.'<div style="padding-top:5px">'.$SEDEX.'</div> '.$ESEDEX.'';  
	



		echo ''.$cobrancaAdicional.'  </div>';  

	};
	
}else{ 
	
 if($checkoutPagto !=true){
    echo'<div id="retorno"><span style="color:green">FRETE GRÁTIS PARA SUA REGIÃO. APROVEITE!</div>';          
	};
};



?>