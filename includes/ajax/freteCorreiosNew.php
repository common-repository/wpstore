<?php
 
if($freteGratis == false){ 
	
    $moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
    if($moedaCorrente==""){
      $moedaCorrente = "R$" ; 
    }
	
	require_once('rsCorreios.php');

	 $freteRs = new RsCorreios();

 
	   
	  $CEP_ORIGEM = "".$origemCep;
	  $CEP_DESTINO = "".$destinoCep;
	  $PESO = "".$peso;
	   
        $alturaS =  get_option('alturaEmbalagemCorreios');
        $larguraS= get_option('larguraEmbalagemCorreios');
        $comprimentoS = get_option('comprimentoEmbalagemCorreios');
 
	   //echo " $CEP_ORIGEM  ****  $CEP_DESTINO **** $PESO  ";
	   
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
   
 
   
      $PAC = "<input type='radio' name='radioFrete'  class='radioFrete'    rel='Pac'  id='Pac' value='".$valorPac."' /> <span class='reduzir'>PAC</span> :  $moedaCorrente <span  class='red' id='valorFretePAC' >".$valorPac."</span><br/> <small class='prazoEntrega '>Capitais: 3 a 7 dias úteis <br/>  Interior : 7 a 10 dias úteis</small><hr/> ";  

  	   $prazoSedexT =  " <small class='prazoEntrega'> Capitais 1 a 3 dias úteis <br/>  Interior: 2 a 5 dias úteis</small>";
   
   
 }else{
 	$prazoSedexT =  " <small class='prazoEntrega hide'> Prazo  Transportadora : Até 30 dias após a confirmação de pagamento.</small>";
	
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
 
 
 
 $sedexNome = " <span class='reduzir'>SEDEX / TRANSPORTADORA</span> ";
 $sedexPrazos = "Capital 1 a 3 dias úteis<br/> Interior 2 a 5 dias úteis.";
 
 
 if( $peso>=30){
 	$sedexNome = "TRANSPORTADORA";
	$sedexPrazos = "Até 15 dias úteis para entrega. ";
 }
 
 

    $SEDEX = "  <input type='radio'  name='radioFrete' class='radioFrete'  checked='checked'  rel='Sedex' id='Sedex' value='".$valorSedex."' />   $sedexNome : $moedaCorrente <span  class='red'  id='valorFreteSEDEX' >".$valorSedex."</span>  <br/>  <small class='prazoEntrega'>$sedexPrazos.</small> <hr/> ";   
 
 
 
 
 $ctCorreiosCod =get_option('ctCorreiosCod');
 $ctCorreiosPass =get_option('ctCorreiosPass');
 
 if($ctCorreiosCod !='' && $ctCorreiosPass !=''){
	 
	 
      $ESEDEX = "";
	 if(floatval($valorESedex)<=0){
		//$valorESedex = floatval($valorSedex)/2;
		//$valorESedex = number_format($valorESedex, 2 ,  '.', '');
	 }else{
         $ESEDEX = " <div style='padding-top:5px'> <input type='radio'  name='radioFrete' class='radioFrete'  checked='checked'  rel='ESedex' id='ESedex' value='".$valorESedex."' />   E-SEDEX : $moedaCorrente <span  class='red'  id='valorFreteSEDEX' >".$valorESedex."</span>  <br/>  <small class='prazoEntrega'>$sedexPrazos.</small> <hr/> </div>";   
     };
};


 
 $retirarLoja =get_option('retirarLoja');
$linkLojas = get_permalink(get_option('idPaginaRetiradaLojaWPSHOP')); 

echo'<div id="retorno" style="font-size:16px">';
 
 if($retirarLoja=='retirarLoja' ){
	 echo "<div style='padding-top:5px'><input type='radio'  name='radioFrete' class='radioFrete'  rel='retirarLoja' id='retirarLoja' value='0.00' />Retirar na Loja
	 <span class='green' style='font-size:0.7em'>** Vou retirar a mercadoria na loja (Sem frete):  <a href='".$linkLojas."' target='_blank'>Consulte lojas </a></span><br/> <hr/></div>";
 };
 
 
  
echo' '.$PAC.'<div style="padding-top:5px">'.$SEDEX.'</div>  '.$ESEDEX.'   '.$cobrancaAdicional.'   </div>';  
	

	
}else{ 
	
 
    echo'<div id="retorno"><span style="color:green">FRETE GRÁTIS PARA SUA REGIÃO. APROVEITE !  </div>';          
	
};



?>