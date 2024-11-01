<?php
$ajaxFiltro = true;
 $tipoSkinShop = get_option('tipoSkinShop');  
 
 $txtProdutosRelacionados= get_option('txtProdutosRelacionadosWPSHOP');   
  if( $txtProdutosRelacionados==""){
     $txtProdutosRelacionados= "Produtos Relacionados"; 
  }
  
  
if($tipoSkinShop=="DARK"){
 
}else{
 include("single_produto_relation_light.php");    
}

?>