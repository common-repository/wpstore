<?php


$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
}


?>
    
    
<?php
 
$idPedido = $idPedido;

$plugin_directory = str_replace('functions/','functions/',plugin_dir_url( __FILE__ ));
$imgTopo = "";
 
$frete="";
if($tipoFrete=="SEDEX"){	
$frete="SD";
}elseif($tipoFrete=="PAC"){
$frete="EN";	
};


$totalCompra = 0;
 
// Incluindo o arquivo da biblioteca 	 Outras Informações
 
$Array[] = array();        
 
    $tabela = $wpdb->prefix."";
    $tabela .=  "wpstore_orders_products";
 
    // Adicionando PRODUTOS
	 
    $sql = "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$idPedido' ORDER BY `id`  ASC  ";

   

    if ( current_user_can( 'manage_options' ) ) {
     	$sql = "SELECT * FROM  `$tabela` WHERE  `id_pedido`='$idPedido' ORDER BY `id`  ASC   ";
    };

       $fivesdraftCs = $wpdb->get_results( $wpdb->prepare( "$sql"  ,1,'') );
   
   
   
   
 
    foreach ( $fivesdraftCs as $item=>$fivesdraftC ){
        
       
        
        $idPedido = $fivesdraftC->id_pedido;
        $idProduto = $fivesdraftC->id_produto;
     
        
        $vowels = array(",");
       
        $preco = $fivesdraftC->preco;
        $preco = str_replace(".","", $preco);
        $preco = str_replace($vowels,".", $preco);
        $preco = floatval($preco);
        $qtd = $fivesdraftC->qtdProd;
        $qtd = floatval($qtd);
        $variacao = $fivesdraftC->variacao;
        $precoAlt = $fivesdraftC->precoAlt; 	
        $precoAlt = str_replace($vowels,".", $precoAlt);
        $precoAlt = floatval($precoAlt);
        $precoAltSymb= $fivesdraftC->precoAltSymb; 
        
        $frete = str_replace($vowels,".", $frete );
        $frete  = floatval($frete );
        
        $precoFinal =  $preco + $precoAlt;
        if($precoAltSymb=="-"){
        $precoFinal =  $preco - $precoAlt;    
        }
        
        $totalCompra +=$precoFinal;
 
   
      $var = str_replace($vowels,".", get_post_meta($idProduto,'weight',true)) ;
      $peso = floatval($var);
 
      
      $str_utf8 = get_the_title($idProduto)." - ".$variacao."";    
      
      //tirar os acentos de uma string! pode ser adaptadas para outras coisas

       $a = array(
       '[ÂÀÁÄÃ]'=>'A',
       '/[âãàáä]/'=>'a',
       '/[ÊÈÉË]/'=>'E',
       '/[êèéë]/'=>'e',
       '/[ÎÍÌÏ]/'=>'I',
       '/[îíìï]/'=>'i',
       '/[ÔÕÒÓÖ]/'=>'O',
       '/[ôõòóö]/'=>'o',
       '/[ÛÙÚÜ]/'=>'U',
       '/[ûúùü]/'=>'u',
       '/ç/'=>'c',
       '/Ç/'=> 'C');

       //$strNew = preg_replace(array_keys($a), array_values($a), $str_utf8 );
       $strNew =  str_replace($vowels,"-", $str_utf8 ) ;
        
 
	   $produtosCheck .= " _gaq.push(['_addItem',
            '$idPedido',           // order ID - required
            '".$idProduto."',           // SKU/code - required
            '".$strNew."',        // product name
            '".$peso."',   // category or variation
            '".$precoFinal."',          // unit price - required
            '".$qtd."'               // quantity - required
          ]); ";
 
	
	
	
	
	
	$freteV = 0;    
	 
}; //End If Pagseguro Add
   

 
 

    $tabela = $wpdb->prefix."";
    $tabela .=  "wpstore_orders_address";

   $fivesdraftCs = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE `id_usuario`='$idUser' AND `id_pedido`='$idPedido' ORDER BY `id`  ASC  "  ,1,'') );

   // Adicionando PRODUTOS

   foreach ( $fivesdraftCs as $item=>$fivesdraftC ){
    
   
 
    $userEndereco = $fivesdraftC->endereco;
    $userEnderecoNumero = $fivesdraftC->numero;
    $userComplemento = $fivesdraftC->complemento;
    $userCidade = $fivesdraftC->cidade;
    $userBairro = $fivesdraftC->bairro;
    $userEstado = $fivesdraftC->estado;
    $userCep = $fivesdraftC->cep;
    
    
    
    global $current_user;
    
    get_currentuserinfo();
    
    $idUser = $current_user->ID;
    $userLogin = $current_user->user_login;
    $userEmail = $current_user->user_email;
  
    $pesoTotal = $peso;

    $displayNameUser = trim("$current_user->user_firstname $current_user->user_lastname"); 
    if($displayNameUser ==""){$displayNameUser=$userLogin;};

    $userPais = trim(get_user_meta($idUser,'userPais',true));if($userPais==""){$userPais="Brasil";};
    $userDDD = trim(get_user_meta($idUser,'userDDD',true));if($userDDD==""){$userDDD="";};
    $userTelefone = trim(get_user_meta($idUser,'userTelefone',true));if($userTelefone==""){$userTelefone="";};
    
    $displayNameUser  = utf8_decode(trim(htmlentities(stripslashes($displayNameUser), ENT_QUOTES,'utf-8')));              
 
    //echo"Usuário:$nome";      
 
   $cidade = $userCidade;
   $estado = $userEstado;

 
 
// Mostrando o botão de pagamento
//$pgs->mostra();
 
  }; 
        
         $vt = $valor_total;
         $vt = str_replace('.','',$vt);
         $vt = str_replace(',','.',$vt);
         $vt = floatval($vt);
		 
		 
         $cupom =   get_session_cupom(); 
     
         $desconto = 0.00;
         $msg = "";
         $numeroCupom  = $cupom[0];
         
         if($cupom[1]=="Valor"){ 
             $msg =  $cupom[1]." $moedaCorrente".$cupom[2];
             $desconto = floatval(str_replace(',','.',$cupom[2]));
         }elseif($cupom[1]=="Percentual"){
             $msg = $cupom[1]." " .$cupom[2]."%" ;  
             $desconto = ( $vt*floatval(str_replace(',','.',$cupom[2])) ) / 100 ;
         }; 
 
      
			  
         $totalCompra =    	$totalPagto;
         
		 if($extras>0){
			  $totalCompra += $extras;
		 };
		 
		 
         
         
         
         $obs = "";
         if( intval($totalCompra)<0){
            $positivoTotal = str_replace('-','',$totalCompra);
             $obs = "<br/><span style='font-size:0.8em;color:red'>Seu cupom é maior que o total de suas compras . Em breve você receberá um  novo cupom no valor de $positivoTotal. </span><br/><br/>";
             $comentario .= $obs;
            $totalCompra = "0.00";
         }




         
         $totalCompraCielo = str_replace('.','',getPriceFormat($totalCompra));
         $totalCompraCielo = str_replace(',','',$totalCompraCielo);
 	 
	 
	 
	  	$txtPrint .= "<br/>
       <h3 style='width:92;background:#ddd;margin-left:5px;padding:20px;text-align:center;font-size:1.2em'  >Total a pagar: $moedaCorrente".getPriceFormat($totalCompra)." </h3>  $obs";  
 
    $_SESSION['vt']  =   $totalCompra;

    ?>
   <?php $txtPrint .= "	    <br/>"; 


    /*
    Tipo de Transação Código
    À vista
    04
    Parcelado Emissor
    06
    Parcelado Estabelecimento
    08
    */
    
    $semjuros = true;
    
    if($semjuros==true){
    	$transacao  = "08";
    }else{
    	$transacao  = "06";	
    }


    
    $n_filiacao = "$filiacao";
    $total = "$totalCompra";
    $ip = $REMOTE_ADDR;

 
                    //$totalCompra =  $subTotal ;

                   $valorFS  = str_replace(',','',  getPriceFormat($totalCompra) );

                   $valorF1 = str_replace('.','',$valorFS);

                   // $valorF = str_replace($moedaCorrente,'',$valorF1 );
                  
                   $valorF = $valorF1;
         
                  // $totalCompra = 100;$valorF =  $totalCompra;

                   //echo "<br/>".$valorF."<br/>";

                   $_SESSION['vt']  = $valorF;
                   $_SESSION['parc'] = "01";

        
		
    if(intval($totalCompra)>0){
    
    

    
     $txtPrint .= " <div id='pagamento'>";
     
     $registroTransacao = "";
 
      if($registroTransacao !=""){
      $txtPrint .=    $registroTransacao;  
      };
      
    
   

     require_once  "includes/include.php";


 
                 //SALVANDO PEDIDO CIELO ---------------------
                 $svCi = $_SESSION['svCi'];
                 $svCi2 = $_SESSION['svCi2'];
                 
                 if($svCi=='1' ){
                     
                              $svCi="";  
                              $_SESSION['svCi'] = '';
                              $finalizacao = $_SESSION['fiCi'];
                              $tid = $_SESSION['tidCi'];
                              $status =  $_SESSION['statusCi'];
                              $dataCi =  $_SESSION['dataCi']; 
                              $xmlCi = $_SESSION['xmlCi'];
                              $StrPedido =  $_SESSION['StrPedido']
                              
                 ?>
                 
                 <div style="background:#A2C6DE;padding:10px;margin:10px">
                
                
        		<h3> Pedido Concluído :  (<?php echo $dataCi; ?>)</h3>

 
                <p>Número pedido : <?php echo $idPedido; ?></p>
 			    <p>Sucesso : <?php echo $finalizacao ? "sim" : "não"; ?></p>
 				<p>Transação:<?php echo $tid; ?></th>
 				<p>Status transação: <span style="color: red;"><?php echo $status; ?> </span></p>
				
				
				
					    <?php /*
                		<h3>XML</h3>
                		<textarea name="xmlRetorno" cols="60" rows="25" readonly="readonly">
                         <?php echo $xmlCi; ?>
                		</textarea>
                	         */ ?>
                		
                  </div>
                		
                 
                 <?php
                   
      
                    //SALVANDO NO BANCO DE DADOS A ALTERACAO DO PEDIDO
                    $msg = "Identificado :$finalizacao - TRANSAÇÃO:$tid-STATUS:$status";

		 if($status=="Autorizada"){
		   	       $msg = "Em verificação : Aguardando análise de crédito - $finalizacao - TRANSAÇÃO:$tid-STATUS:$status.";                                 alteraPedidoStatus($idPedido,'PENDENTE',$msg,$xmlCi,$StrPedido);    
    
                            
          }elseif($status=="Capturada"){
                                                 alteraPedidoStatus($idPedido,'APROVADO',$msg,$xmlCi,$StrPedido);
$googleConversaoPagto =  get_option('googleConversaoPagto'); 

             if($googleConversaoPagto !=""){
	               $googleConversaoPagto = str_replace('\"','"',$googleConversaoPagto );
                   echo $googleConversaoPagto;
             };
 

             $facebookConversaoPagto =  get_option('facebookConversaoPagto'); 
             if( $facebookConversaoPagto  !=""){
                   $facebookConversaoPagto = str_replace('\"','"',$facebookConversaoPagto );
                  echo   $facebookConversaoPagto;
             };
									
									
	 }elseif($status=="Cancelada"){
                                    alteraPedidoStatus($idPedido,'PENDENTE',$msg,$xmlCi,$StrPedido);    
     }elseif($status=="N? autorizada"){
                                    alteraPedidoStatus($idPedido,'PENDENTE',$msg,$xmlCi,$StrPedido);    
     }elseif($status=="N�o autorizada"){
                                    alteraPedidoStatus($idPedido,'PENDENTE',$msg,$xmlCi,$StrPedido);    
      }else{ 	
                                    alteraPedidoStatus($idPedido,'PENDENTE',$msg,$xmlCi,$StrPedido);    
      };
                                    
                                    
        $idPage = get_idPaginaPedido();
        $page  = get_permalink($idPage);
                                    
                                    
  echo"<script>window.location='".verifyURL($page)."/?order=".$_GET['order']."'</script>";
                 
                        
                            
                 };

              //SALVANDO PEDIDO CIELO ---------------------


   

      if($_REQUEST['codigoBandeira']!=''){
         
             include_once('pages/novoPedidoAguarde.php');  
           
      }elseif($_REQUEST['orderCIELO']!='' ){
          
             include_once('pages/retorno.php');  
             $ver="1";
          
       }else{
          
             include_once('pages/carrinho.php');
          
      };
      
  };//IF VALOR >0
      
?> 