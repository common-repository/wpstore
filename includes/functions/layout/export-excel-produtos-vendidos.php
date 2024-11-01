<?php

ini_set('memory_limit','256M');

require("../../../../../wp-load.php");

//header("Content-Type: application/vnd.ms-excel");
	
 header("Content-disposition: attachment; filename=planilha-produtos-vendidos.xls");
		 
  echo 'Produto' . "," . 'Quantidade'. "\n";
 
	///////GET USUARIOS---------
	
	
	$offset = 0;
	$page = intval(addslashes($_GET['page']));
	if($page >=2){
		$offset = 1000 * ($page - 1);
	}
	$args = array('blog_id' =>1,'number'=>'1000','offset' =>$offset);








  global $wpdb;
  $tabela = $wpdb->prefix."";
  $tabela .=  "wpstore_orders_products";
  
	  $sql = "SELECT *FROM `$tabela` ORDER BY `id_produto` DESC ";
	
	
    $fivesdrafts = $wpdb->get_results($sql);
    
	$contagemResultado = count($fivesdrafts);
	
	
     if ($fivesdrafts) {
	
	
	

       $idAtual = 0;
	     $qtdAtual = 0;
			 
       foreach ( $fivesdrafts as $fivesdraft ){
           
        
           $id = $fivesdraft->id;
           $idPedido = $fivesdraft->id_pedido;
           $idUsuario = $fivesdraft->id_usuario;
					 $idProduto = str_replace("'",'',$fivesdraft->id_produto);
					 $idProduto = intval($idProduto);
					 $variacao  = $fivesdraft->variacao;
					 $qtd = $fivesdraft->qtdProd; 
					 
					 $nomeProd  = get_the_title($idProduto);
					 if($nomeProd==""){
					 	 $nomeProd  = "PRODUTO Excluido:ID-$idProduto ( Consulte Pedido:$idPedido)";
					 };
					 
		     $nomeProduto = str_replace(',',' ',$nomeProd);
 
 
			   if($idAtual == $idProduto ||  $idAtual == 0 ){
					      $qtdAtual += intval($qtd);
	              //FINAL LINHA USUARIO -----
	       }else{
					     echo $nomeProduto. "," . $qtdAtual ."\n";
							 $qtdAtual = 0;
							 $qtdAtual += intval($qtd);
	       }
			     		
          $idAtual = $idProduto;	
				 
				 
		}
 
 
	};
 

	
?>