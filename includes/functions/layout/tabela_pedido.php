<?php
$ajaxFiltro = true;
 $tipoSkinShop = get_option('tipoSkinShop');
if($tipoSkinShop=="DARK"){
 
}else{
 include("tabela_pedido-light.php");    
}

?>