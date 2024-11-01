<?php
$moedaCorrente  =  get_option('moedaCorrenteWPSHOP');
if($moedaCorrente==""){
  $moedaCorrente = "R$" ; 
}




$txtPrint .= "<br/><br/> $pct%  DE DESCONTO NO BOLETO A  VISTA<br/><br/>" ;
 
?>
 



                   <?php $txtPrint .= "<br/>
                      <h3 style='width:92;background:#ddd;margin-left:5px;padding:20px;text-align:center;font-size:1.2em'  >Total a pagar: $moedaCorrente".getPriceFormat( $valorDeconto)." </h3> $obs";  
                   ?>


<?php
if($order==""){$order = $idPedido;};

$url = get_permalink(get_idPaginaBoleto())."?order=$order";

$txtPrint .= "<a href='$url' target='_blank'><h2 class='imprimeBoleto'>Imprimir BOLETO</h2></a><br/><br/><br/><br/> ";
?>