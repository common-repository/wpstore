<?php


  
if($order==""){
	$order = $_GET['order'];
}



  $orderPrint .="<div style='background:#ddd;padding:10px;margin:10px'>

        <h3>Cielo : Opções de Administração</h3>";

    
       $dirname = dirname(__FILE__);
       $dirname = str_replace('layout','',$dirname);
       
       
       if($_GET['operacao']=="cons"){
                  include('pages/operacao.php');    
       }

      // if(trim($infoCieloXML)!=""){
             include('pages/pedidos.php'); 
      // }else{
          //   $orderPrint .="<p>Não há opções de gerenciamento CIELO para esta operação.</p>";  
      // };
	   
	   
       $orderPrint .="</div><br/><hr/><br/>";
 
 
?> 