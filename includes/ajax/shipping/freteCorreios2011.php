<?php

 $moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
 if($moedaCorrente==""){
   $moedaCorrente = "R$" ; 
 }

if (function_exists('calculaFrete')) { }else{
	
	
function calculaFrete($cod_servico, $cep_origem, $cep_destino, $peso, $altura='5', $largura='20', $comprimento='30', $valor_declarado='0.50')
 {
     #OFICINADANET###############################
     # Código dos Serviços dos Correios
     # 41106 PAC sem contrato
     # 40010 SEDEX sem contrato
     # 40045 SEDEX a Cobrar, sem contrato
     # 40215 SEDEX 10, sem contrato
     ############################################


     /**/
      $alturaS =  get_option('alturaEmbalagemCorreios');
      $larguraS= get_option('larguraEmbalagemCorreios');
      $comprimentoS = get_option('comprimentoEmbalagemCorreios');


     if(intval($alturaS)>0){
       $altura =  $alturaS;  
     }

     if(intval($larguraS)>0){
       $largura= $larguraS;  
     }

     if(intval($comprimentoS)>0){
      $comprimento =  $comprimentoS;  
     }




     $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?nCdEmpresa=&sDsSenha=&sCepOrigem=".$cep_origem."&sCepDestino=".$cep_destino."&nVlPeso=".$peso."&nCdFormato=1&nVlComprimento=".$comprimento."&nVlAltura=".$altura."&nVlLargura=".$largura."&sCdMaoPropria=n&nVlValorDeclarado=".$valor_declarado."&sCdAvisoRecebimento=s&nCdServico=".$cod_servico."&nVlDiametro=10&StrRetorno=xml";
     $xml = simplexml_load_file($correios);
     if($xml->cServico->Erro == '0')
         return $xml->cServico->Valor;
     else
         return false;
 };
 
 };
/*
echo "<br><Br>Cálculo de FRETE PAC: ". 
calculaFrete('41106','24340000','24340160','4')."<br>";

echo "<br><Br>Cálculo de FRETE SEDEX: ". 
calculaFrete('40010','24340000','24340160','4')."<br>";

echo "<br><Br>Cálculo de FRETE SEDEX a cobrar: ". 
calculaFrete('40045','24340000','24340160','4')."<br>";

echo "<br><Br>Cálculo de FRETE SEDEX 10: ". 
calculaFrete('40215','24340000','24340160','4')."<br>";
*/


$origemCep =  get_option('cepOrigemCorreios');


global $current_user;
get_currentuserinfo();
$idUser = $current_user->ID;
 
$userCidade2 = $_POST['cidadeV']; 
if($userCidade2 ==""){
    $userCidade2 =$cidade;
}
$tipoPagto = $_POST['varSelectV'];

 
$destinoCep = trim($_REQUEST['CepDestinoR']);   

if($destinoCep==""){
$destinoCep = trim(get_user_meta($idUser,'userCep2',true));
}   

if($destinoCep==""){
$destinoCep = trim(get_user_meta($idUser,'userCep',true));
}

$destinoCep = str_replace(' ','',$destinoCep);

$valorFreteEnviado = $_POST['radioFrete'];
$comentario = $_POST['commentOrderV'];

 $cidade = ""; 
 $Estado = "";  
 //Pegando cidade com base no CEP --------------------------------------------- 
     $caputurar = true;
     include('buscaEndereco.php');
//Pegando cidade com base no CEP --------------------------------------------- 
       

$userCidade2 = $cidade;  

if($userCidade2 ==""){
$userCidade2 = trim(get_user_meta($idUser,'userCidade2',true)); 
};  



if($userCidade2 ==""){
$userCidade2 = trim(get_user_meta($idUser,'userCidade',true)); 
};



$userCidade2 = $cidade;



$pesoReal = $peso;


if($idPrd==''){
$cidadeUser = $estado."**".$cidade;
$peso =  get_cart_weight($cidadeUser);  
$pesoReal = $peso;

};

if($peso<=0){
$peso = floatval($_SESSION['pesoCheckout']);
$pesoReal = $peso;
}

 
if($peso>30){
$peso  = 30;	
}
 

   $freteGratis = false;
 
   $cidadesFreteGratis = get_option('cidadesFreteGratis');
   //$arrayCidades = array('Niterói','Niteroi','São Gonçalo','Sao Gonçalo','Rio Bonito','Maricá','Marica','Itaborai','Itaboraí');

   $arrayCidades = array();
   $arrayEstados = array();

   $arrayEstadosCidades = explode(',',$cidadesFreteGratis);       
   
   foreach($arrayEstadosCidades as $item=>$value){    
       
       $arrayValue = explode('**',$value);   
       
       //$arrayEstados = trim($arrayValue[0]);  
       
      // $arrayCidades = trim($arrayValue[1]); 

       $cidadeUserF = $estado."**".$cidade;    

       $cidadeUser = str_replace(' ','',$arrayValue[1] ); 
       $cidadPromocao = str_replace(' ','',$userCidade2 );

       if(  modificaAcento(strtolower($cidadeUserF)) == modificaAcento(strtolower($value)) ){   
       $freteGratis = true; 
       };

   

   }

 

if(trim($userCidade2) ==""){
	$freteGratis = false;
}

$salvar = false;


/**/


if($idPrd !=""){
     $produtoSemPromoFrete = get_produto_promoFrete_status($idPrd);
     if( $produtoSemPromoFrete  ==true){
     $freteGratis = false;
     };
}else{
	     
         $arrPodePromo = true ; 
		 
         $arrayCarrinho = "";  
         $blogid = intval(get_current_blog_id());  
   	     if($blogid>1){
   	          $arrayCarrinho =  $_SESSION['carrinho'.$blogid] ;     
   	     }else{
   	          $arrayCarrinho = $_SESSION['carrinho'];      
         };
	
          foreach($arrayCarrinho as $key=>$item){ 
	                $postID = intval($item['idPost']);
			        $produtoSemPromoFrete = get_produto_promoFrete_status($postID);
		        	if( $produtoSemPromoFrete  == true){
							$arrPodePromo = false ; 
		    	     };
		 };
		
		 
      	 if($arrPodePromo ==false){
		    $freteGratis = false;
  	     };
	
} 







if($freteGratis == false){ 
  
       //echo "$origemCep  ****  $destinoCep **** $peso";
       
        //$valorSedex = "".calculaFrete('40010',''.$origemCep.'',''.$destinoCep.'',''.$peso.'')."";     
        //$valorPac =  "".calculaFrete('41106',''.$origemCep.'',''.$destinoCep.'',''.$peso.'')."";   
       $valorSedex = 0.00;     
       $valorPac =  0.00;
	    
       if(floatval($valorSedex)<1 || floatval($valorPac)<1){
          include('../freteCorreiosNew.php');
	  
       }

	  
	   if(empty($valorFrete )){ 
           
		   //require_once('freteCorreios2011-pgs.php'); //desabilitado para teste e-sedex
 	
	  }else{
	 
      



	   //Prazo: $prazoSedex
       //Prazo:'.$prazoPac.' 
	  $PAC = "";
 	  $prazoSedexT =  "";
	  
	  $cobrancaAdicional = "";
	 
	 if($peso<30){ 
	   
		   
		    
				
	/*			
    $PAC = "<input type='radio' name='radioFrete'  class='radioFrete'    rel='Pac'  id='Pac' value='".$valorPac."' /> PAC :  $moedaCorrente <span  class='red' id='valorFretePAC' >".$valorPac."</span><br/> <small>Prazo Correios PAC : $prazoPac dias </small><hr/> ";  
 
	   $prazoSedexT =  "<small> Prazo  Correios SEDEX :$prazoSedex dias.</small>";
	 	*/
	   
	   
       $PAC = "<input type='radio' name='radioFrete'  class='radioFrete'    rel='Pac'  id='Pac' value='".$valorPac."' /><span class='reduzir'> PAC </span>:  $moedaCorrente <span  class='red' id='valorFretePAC' >".$valorPac."</span><br/> <small class='prazoEntrega'>Capitais: 3 a 7 dias úteis <br/>  Interior 7 a 10 dias úteis. </small><hr/> ";  
 
   	   $prazoSedexT =  "<small class='prazoEntrega '> Prazo  Correios SEDEX :Capitais: 1 a 3 dias úteis <br/>  Interior 2 a 5 dias úteis</small>";
	   
	   
	 }else{
	 	$prazoSedexT =  "<small class='prazoEntrega '> Prazo  Transportadora : Até 30 dias após a confirmação de pagamento.</small>";
		
		$pesoReal = intval($pesoReal/$peso);
		
		$valorSedex = floatval($valorSedex)*$pesoReal;
	    $valorSedex= number_format( $valorSedex, 2 ,  '.', '');
		


        //IMPOSTO ADICIONAL: -------------------------------
		$impostoAddTexto = get_option('impostoAddTexto');
		$impostoAddPct = floatval(get_option('impostoAddPct'));
		$impostoAddRegiao = get_option('impostoAddRegiao');
		
		 
	    $cidadesFreteAdicional= $impostoAddRegiao ;
		
		$regiao = "";
		$valorAdd = "";
        $addCobranca = false;
	    $arrayEstadosCidades = explode(',',$cidadesFreteAdicional);       
        if( $arrayEstadosCidades ){
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
	/*
    $SEDEX = " <hr/> <input type='radio'  name='radioFrete' class='radioFrete'  checked='checked'  rel='Sedex' id='Sedex' value='".$valorSedex."' />  SEDEX / TRANSPORTADORA : $moedaCorrente <span  class='red'  id='valorFreteSEDEX' >".$valorSedex."</span>  <br/> $prazoSedexT <hr/> ";     
 */
   
		
		 $sedexNome = "<span class='reduzir'>SEDEX / TRANSPORTADORA</span> ";
		 $sedexPrazos = "Capital 1 a 3 dias úteis <br/> Interior 2 a 5 dias úteis.  ";
		 if( $peso>=30){
		 	$sedexNome = "TRANSPORTADORA";
			$sedexPrazos = "Até 15 dias úteis para entrega.";
		 }
 
     $SEDEX = "   <input type='radio'  name='radioFrete' class='radioFrete'  checked='checked'  rel='Sedex' id='Sedex' value='".$valorSedex."' /> $sedexNome  : $moedaCorrente <span  class='red'  id='valorFreteSEDEX' >".$valorSedex."</span>  <br/>  <small class='prazoEntrega'>$sedexPrazos</small> <hr/> ";   
	 
	 
	 
	 
	 

	 $retirarLoja =get_option('retirarLoja');
	 
      $linkLojas = get_permalink(get_option('idPaginaRetiradaLojaWPSHOP')); 
 
 echo'<div id="retorno" style="font-size:16px">';
	 
	 if($retirarLoja=='retirarLoja'){
		 echo "<div style='padding-top:5px'><input type='radio'  name='radioFrete' class='radioFrete'     rel='retirarLoja' id='retirarLoja' value='0.00' />Retirar na Loja
		 <span class='green' style='font-size:0.7em'>** Vou retirar a mercadoria na loja (Sem frete):  <a href='".$linkLojas."' target='_blank'>Consulte lojas </a></span><br/><hr/> </div>";
	 };
 
 
 
	echo' '.$PAC.'<div style="padding-top:5px">'.$SEDEX.'</div> '.$cobrancaAdicional.'  </div>';



 };

	
}else{ 
	
 
    echo'<div id="retorno"><span style="color:green">FRETE GRÁTIS PARA SUA REGIÃO. APROVEITE !    </div>';          
	
};



?>