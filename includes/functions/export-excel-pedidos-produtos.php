<?php

ini_set('memory_limit','256M');

require("../../../../../wp-load.php");

//header("Content-Type: application/vnd.ms-excel");
	
 header("Content-disposition: attachment; filename=planilha-pedidos-produtos.xls");
		 
echo 'Numero Pedido' . "," . 'Produto' . "," . 'Variacao'."," . 'Quantidade'. "\n";
 
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
	
	
	

	
       foreach ( $fivesdrafts as $fivesdraft ){
           
        
           $id = $fivesdraft->id;
           $idPedido = $fivesdraft->id_pedido;
           $idUsuario = $fivesdraft->id_usuario;
					 $idProduto = $fivesdraft->id_produto;
					 $variacao  = $fivesdraft->variacao;
					 $qtd = $fivesdraft->qtdProd; 
				 
				 $nomeProduto = get_the_title($idProduto );
 
		echo $fivesdraft->id_pedido. "," . $nomeProduto. "," .$variacao. ",".$qtd ."\n";
		//FINAL LINHA USUARIO -----
			
			
		}
 
 
	};
 

	
?>