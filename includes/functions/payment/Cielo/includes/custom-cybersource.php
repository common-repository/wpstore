<?php
//IF CYBER  CYBERSOURCE-------------------

global $wpdb;

$pedidoID =  $this->dadosPedidoDescricao;
$order = trim($pedidoID); 

$valorMinimoConsultaCieloCYB =  get_option('valorMinimoConsultaCieloCYB'); 
$segmentoEmpresaCieloCYB = get_option('segmentoEmpresaCieloCYB'); 
$seguimentoEmpresa  = substr($segmentoEmpresaCieloCYB, 0, 255);
	
	
if(strlen($valorMinimoConsultaCieloCYB)>6){
 $valorMinimoConsultaCieloCYB = str_replace('.','', $valorMinimoConsultaCieloCYB );
};
$valorMinimoConsultaCieloCYB = str_replace(',','.',$valorMinimoConsultaCieloCYB);   
$valorMinimoConsultaCieloCYB = floatval($valorMinimoConsultaCieloCYB); 
  
 
$precoTotalCompra = $this->dadosPedidoValor;
$precoTotalCompraInteiro = substr($precoTotalCompra,0,-2);
$precoTotalCompraCentavos = substr($precoTotalCompra,-2);

$precoTotalCompra = floatval($precoTotalCompraInteiro.".".$precoTotalCompraCentavos);


if($precoTotalCompra > $valorMinimoConsultaCieloCYB ){ //SE VALOR MINIMO ATINGIDO -----


$precoTotalCompra = number_format($precoTotalCompra ,2,'.','');
	
//GET PRODUTOS PEDIDO
$precosIndividualCompra = ""; //36.00
$categoriaProduto = $seguimentoEmpresa; //categoria individual do produto



 $tabela = $wpdb->prefix."";
$tabela .=  "wpstore_orders_products";

$fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_pedido`='$order' ORDER BY `id`  ASC  " ,1,'') );

// 
 
  
 $contagemP = 0;
 $totalDeProdutos = count($fivesdrafts); 
 if($fivesdrafts){
 foreach ( $fivesdrafts as  $item=>$fivesdraft ){
      	 	 	 	 	
	$contagemP +=1;				
                 
                        $id_produto = $fivesdraft->id_produto;
						
	                   
						
						
                        $preco = $fivesdraft->preco;
						
                        $variacao = $fivesdraft->variacao;
                        $qtdProd = $fivesdraft->qtdProd;
                        $precoAlt = $fivesdraft->precoAlt;
                        $precoAltSymb = $fivesdraft->precoAltSymb;
                        $sinal = $precoAltSymb;
						
						
                        $precoSoma = $preco;
               
                        if(strlen($precoSoma)>6){
                         $precoSoma= str_replace('.','',$precoSoma );
                        };
						
                          $precoSoma = str_replace(',','.',$precoSoma);   
                          
                          $precoAlt = floatval(str_replace(',','.',$precoAlt));  
                   
                               if(strlen($precoAlt)>=6){
                                $precoAlt =  str_replace('.','',$precoAlt);
                                $precoAlt =  str_replace(',','.',$precoAlt); 
                                }else{
                                $precoAlt =  str_replace(',','.',$precoAlt);
                                };
                             
                            if($sinal=="-"){
                                $precoSoma = $precoSoma -  $precoAlt;  
                            }elseif($sinal=="+"){
                                 $precoSoma = $precoSoma +  $precoAlt;    
                            };   
                            $qtd = intval($qtdProd);
                            // $precoLinha =    getPriceFormat($qtd*$precoSoma) ;
                            $precoLinha =   $qtd*$precoSoma;
						 
						     $precoLinha  = number_format( $precoLinha,2,'.','');
							
							$arrRemove = array('-','/',';',',','&#8211');
							
							if( $totalDeProdutos > 1  && $contagemP  < $totalDeProdutos ){
								 $precosIndividualCompra .= $precoLinha.";";
		 	                     
$categoriaProduto .= str_replace($arrRemove,'',utf8_decode(get_the_title($id_produto))).",";  
							                                                                                                 }else{
								$precosIndividualCompra .= $precoLinha;
			                   
$categoriaProduto .=  str_replace($arrRemove,'',utf8_decode(get_the_title($id_produto)));  
							   
							};
	
							              
 };	 };	//FOREACH PRODUTOS PEDIDO			
 
 $categoriaProduto = substr( $categoriaProduto, 0, 255);
 
//FINAL GET PRODUTOS PEDIDO

	
	$decisaoAltoRiscoCieloCYB = get_option('decisaoAltoRiscoCieloCYB');  
	$decisaoMedioRiscoCieloCYB = get_option('decisaoMedioRiscoCieloCYB'); 
	$decisaoBaixoRiscoCieloCYB = get_option('decisaoBaixoRiscoCieloCYB'); 
	$decisaoErroDadosCieloCYB =get_option('decisaoErroDadosCieloCYB'); 
	$decisaoErroIndisponivelCieloCYB = get_option('decisaoErroIndisponivelCieloCYB'); 



  
    $pedidoIDF = substr( str_replace('.','',$pedidoID) ,0,50);
	$this->idPedidoF =  $pedidoIDF;

	

	$arrOrder = explode('.',$order);
	$idUser = 	intval($arrOrder[0]);
	$user_info = get_userdata($idUser);
	$displayNameUser="$user_info->user_firstname  $user_info->user_lastname"; 

	
	$userCpf = trim(get_user_meta($idUser,'userCpf',true));  
	$userCnpj = trim(get_user_meta($idUser,'userCnpj',true));  


	$userCpfUm   = trim(get_user_meta($idUser,'userCpfUm',true));        
 
	$first_name   = trim(get_user_meta($idUser,'first_name',true));        
	$last_name    = trim(get_user_meta($idUser,'last_name',true));     

	$userLogin =  $user_info->user_login;
	$userEmail =  $user_info->user_email;
	$userCnpj = trim(get_user_meta( $idUser,'userCnpj',true));  
	if($userCnpj !=''){
	    $userCpf =  $userCnpj;
    };
    $userCpf = str_replace('.','',$userCpf);
    $userCpf = str_replace('-','',$userCpf);
  
    $userDDD = trim(get_user_meta($idUser,'userDDD',true));
    if($userDDD==""){$userDDD="";};

    $userTelefone = trim(get_user_meta($idUser,'userTelefone',true));
   
     $totalComCentavo = $this->dadosPedidoValor;
	 $inteiro = substr($totalComCentavo,0,-2);
	 $centavos = substr($totalComCentavo,-2);
	 $totalComCentavo = $inteiro.".".$centavos;
     $this->totalCompraCielo  =  substr($totalComCentavo, 0, 15);
  
    $this->userId =  substr($userLogin, 0, 50);
 
    $this->userCpf =	  substr($userCpf, 0, 26);

    $this->userEmail =   substr($userEmail, 0, 100);
    $this->userNome	=  substr($user_info->user_firstname, 0, 60);
    $this->userSobrenome =  substr($user_info->user_lastname, 0,60);
    $this->userTelefone	=  substr($userDDD."".$userTelefone, 0, 15);
    $this->userIp =  substr($_SERVER['REMOTE_ADDR'], 0, 15);
    $this->entregaTelefone =  substr($userDDD."".$userTelefone, 0, 15);
 
    $tabela = $wpdb->prefix."";
    $tabela .=  "wpstore_orders_address";
    $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$order' ORDER BY `id`  ASC  ",1,'' ) );


     // Adicionando PRODUTOS
     foreach ( $fivesdrafts as $item=>$fivesdraft ){
		 
		 $userEndereco = $fivesdraft->endereco;
     	 $userEnderecoNumero = $fivesdraft->numero;
			
	     $comp = str_replace('***REF','',$fivesdraft->complemento);
     	 $userComplemento = $comp;
			
     	 $userCidade = $fivesdraft->cidade;
     	 $userBairro = $fivesdraft->bairro;
     	 $userEstado = $fivesdraft->estado;
    	 $userCep = $fivesdraft->cep;
			
		 $this->entregaEndereco	=  substr($userEndereco." ".$userEnderecoNumero, 0, 60);
 		 $this->entregaComplemento	= substr($userComplemento, 0, 60); 
 		 $this->entregaCidade	= substr($userCidade, 0, 50); 
 		 $this->entregaEstado=  substr($userEstado, 0, 2);
 		 $this->entregaCep=  substr($userCep, 0, 10);
			
	  	 $this->cobEndereco =   substr($userEndereco." ".$userEnderecoNumero, 0,60);
	   	 $this->cobComplemento = substr( $userComplemento, 0,60);
	  	 $this->cobCidade =   substr( $userCidade, 0,50);
	  	 $this->cobEstado =  substr($userEstado, 0,2);
	  	 $this->cobCep =  substr( $userCep, 0,60);
			
      };
	  
	  

	
	    $idCob = intval(get_id_addr_cobranca($idUser,$order)); 
		
        if( $idCob >0 ){ //SE ENDERECO DE COBRANCA != ENDEREÇO DE COBRANÇA ----------
			
   	         $userAddress = get_user_address_by_id($idCob); 
			  
	         if(count($userAddress)>0){
  		     foreach ( $userAddress as $address ){   
			
 		   		$cep =  explode('-',$address->cep);
  			  	$cepUm =  $cep[0];
  			  	$cepDois =  $cep[1];
  			  	$userEndereco = $address->endereco;  
  			  	$userEnderecoNumero = $address->numero;  
  			  	$userBairro = $address->bairro; 
  			  	$userCidade  =  $address->cidade;
  			  	$userEstado = $address->estado; 
  			  	$userComplemento =  $address->complemento;  
  			  	$userCep = $cepUm."-".$cepDois; 
  			  	$tipoENd = $address->tipoEndereco; 
  			  	$ref =  $address->referencia; 
				
				$endereco = substr($userEndereco." ".$userEnderecoNumero, 0, 60);
		        $this->cobEndereco = $endereco;
			   	
				
				$comp = str_replace('***REF','',$address->complemento);
	     	    $comp= substr($comp, 0, 60);
				$this->cobComplemento = $comp;
				 
				$cidade= substr($userCidade, 0, 50);
  			  	$this->cobCidade = $cidade;
  			  	
				$estado= substr($userEstado, 0, 2);
				$this->cobEstado = $estado;
  			  	$this->cobCep = substr($cepUm."".$cepDois, 0, 10);
				 
             }; 
			 
			 }; 
		 
	    };
		
		 
		$xmlCyberSource ="<analise-fraude>

 	 	<configuracao>
   		 		<analisar-fraude>true</analisar-fraude>
    			 	<alto-risco>".$decisaoAltoRiscoCieloCYB."</alto-risco>
    				<medio-risco>".$decisaoMedioRiscoCieloCYB."</medio-risco>
    				<baixo-risco>".$decisaoBaixoRiscoCieloCYB."</baixo-risco>
    				<erro-dados>".$decisaoErroDadosCieloCYB."</erro-dados>
              <erro-indisponibilidade>".$decisaoErroIndisponivelCieloCYB."</erro-indisponibilidade>
 		</configuracao>


 		<afsService_run>true</afsService_run>

 		<merchantReferenceCode>".$this->idPedidoF."</merchantReferenceCode>";
		 
	   
 		$xmlCyberSource .="
			
	    <billTo_street1>".$this->cobEndereco."</billTo_street1>

 		<billTo_street2>".$this->cobComplemento."</billTo_street2>

		<billTo_city>".$this->cobCidade."</billTo_city>

 		<billTo_state>".$this->cobEstado."</billTo_state>

 		<billTo_country>BR</billTo_country>

 		<billTo_postalCode>".$this->cobCep."</billTo_postalCode>

 		<billTo_customerID>".$this->userId."</billTo_customerID>
 
           <billTo_personalID>".$this->userCpf."</billTo_personalID>

           <billTo_email>".$this->userEmail."</billTo_email>

           <billTo_firstName>".$this->userNome."</billTo_firstName>

           <billTo_lastName>".$this->userSobrenome."</billTo_lastName>

           <billTo_phoneNumber>".$this->userTelefone."</billTo_phoneNumber>

           <billTo_ipAddress>".$this->userIp."</billTo_ipAddress>

          <shipto_street1>".$this->entregaEndereco."</shipto_street1>

          <shipto_street2>".$this->entregaComplemento."</shipto_street2>
		  
          <shipto_city>".$this->entregaCidade."</shipto_city>
		  
          <shipto_state>".$this->entregaEstado."</shipto_state>
		  
          <shipto_country>BR</shipto_country>
		  
          <shipto_postalCode>".$this->entregaCep."</shipto_postalCode>
		  
         <shipTo_phoneNumber>".$this->entregaTelefone."</shipTo_phoneNumber>
		 
         <deviceFingerprintID>null</deviceFingerprintID>
		 
		 ";
		 
 
 	   	  	  	$xmlCyberSource.="
 				<purchaseTotals_currency>BRL</purchaseTotals_currency>
 				";
		
		
 	   	 		$xmlCyberSource .="
 				<purchaseTotals_grandTotalAmount>".$precoTotalCompra."</purchaseTotals_grandTotalAmount>
 				";
	   
 	    		$xmlCyberSource .="
 				<item_unitPrice>".$precosIndividualCompra."</item_unitPrice>
 				";	
				
				
				$xmlCyberSource .="
				<mdd>
			  <merchantDefinedData_mddField_13>".$categoriaProduto."</merchantDefinedData_mddField_13>
			 ";	
	   
	       	 	$xmlCyberSource.="
				<merchantDefinedData_mddField_14>".$this->userEmail."</merchantDefinedData_mddField_14>  
				";	
	       	 
				$xmlCyberSource.="
				<merchantDefinedData_mddField_26>".$seguimentoEmpresa."</merchantDefinedData_mddField_26>
				</mdd>
				";	
		 
$xmlCyberSource .="</analise-fraude>";

}; //FINAL SE VALOR MINIMO ATINGIDO -----

//IF CYBER  CYBERSOURCE-------------------
?>