<?php 


    $url = "https://go.gerencianet.com.br/api/pagamento/xml";
	
	
	$token = "".get_option('tokenGerencianet');
     
    $xml = "<?xml version='1.0' encoding='utf-8'?>
    <integracao>
    <itens>
    $itemXMLPROD
    </itens>
	<frete>$valorFreteT</frete>
	<tipo>produto</tipo>
	<retorno>
	<identificador>$idPedido</identificador>
	<url>".get_bloginfo('url')."</url>
	</retorno>
    <cliente>
	$itemXMLEND
    </cliente>
    </integracao>";
     
    $xml = str_replace(array("\n", "\r", "\t"), '', $xml);
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    $data = array("token" => $token, "dados" => $xml);
     
    curl_setopt($ch, CURLOPT_POST, true);
     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    $response = curl_exec($ch);
     
    curl_close($ch);
     
   // echo "<xmp>".$response."</xmp>";
	$txtPrint   = get_string_between($response, "<link>", "</link>");
?>