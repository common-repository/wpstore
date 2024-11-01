<?php 

require("../../../../../wp-load.php");

 $qtdCarrinho =  custom_get_qtd_items_Cart();

 $keyP = intval($_POST['idProdInCart']);
 $idProd = intval($_POST['idProd']);

 
 $tamanho = trim($_POST['variacaoTamanho']); 
 $cor = trim($_POST['variacaoCor']);
 
 $variacaoCor = trim( str_replace(' ','',$tamanho) )."-".trim( str_replace(' ','',$cor) );
 if($cor ==""){  $variacaoCor = trim( str_replace(' ','',$tamanho) ); };
 $qtdProdP = intval($_POST['qtdProduto']);
  
 $explode = explode('-',$variacaoNome);
 
 if($tamanho =="" && $cor==""){ $cor = '-'; };
 
 $arrayCarrinho = ""; 
   
 $blogid = intval(get_current_blog_id()); 
  
 if($blogid>1){$arrayCarrinho = $_SESSION['carrinho'.$blogid];}else{  $arrayCarrinho = $_SESSION['carrinho'];  };

    $qtdStock = custom_get_qtd_stock( $idProd,$cor,$tamanho);
 
   
    $qtdVendida = custom_get_qtd_vendida($idProd , trim(str_replace(' ','',$cor)) , trim(str_replace(' ','',$tamanho)) );
	
	$qtdStock -= $qtdVendida;
	$qtdStock -= $qtdProdP;
	
	$qtdReservaUsuario = intval(custom_get_stock_reservaUsuario($idProd, $variacaoCor));
	
	/**/
	
	 echo " $idProd - $variacaoCor** $qtdProdP  <= $qtdReservaUsuario";
	
	
	if(  $qtdProdP  <= $qtdReservaUsuario){
		 //$qtdStock += $qtdVendida;
		 //$qtdStock +=  $qtdReservaUsuario;
		 //$qtdStock += $qtdProdP;
	}else{
	   // $qtdStock +=  $qtdReservaUsuario; 
		//$qtdStock -= $qtdVendida;
	};
	
	
	
	
	

    if( $qtdStock > 0  ){
	 
       $qtdCarrinho -=$qtdAnt;
       $qtdCarrinho += $qtdCarrinho;
	   $cor = trim( str_replace(' ','',$cor) );
       $tamanho = trim( str_replace(' ','',$tamanho) );
       $variacaoCor = $tamanho."-".$cor;
       if($cor==""){
          $variacaoCor = $tamanho;
       }elseif($tamanho==""){
          $variacaoCor = $cor;
       };
       if($variacaoCor=="-"){
          $variacaoCor="";
       };
  
       
        $incluso = false;
        $chave = "";
        $qtdAnt  = 0;
        $chaveItem = "";
		
        if($arrayCarrinho==""){ $arrayCarrinho = array(); };
        foreach($arrayCarrinho as $key=>$item){
       
                //echo "<hr/>";
               // echo $item['prodString']."<br/>";
               // echo trim($postID.$variacaoCor)."<br/>";
               // echo "<hr/>";
			   
			   //echo " $key  ==  $keyP  ---- "; 
       
               if( $key  ==  $keyP ){
				    $postID = intval($item['idPost']);
         			$incluso = true; 
          		  	$qtdAnt = intval($item['qtdProduto']);
         		   	$chave = $key;
          	    }; 
				
        }
		
		
		
		
	   // echo " $keyP **  $idProd ==    $postID { $qtdAnt }  || $cor || $tamanho   ||  $qtdProdP   ";
 
 
        $precoAdd = get_price_product_variation($postID,$variacaoCor);
        if($precoAdd !=""){$precoAdd = "Variação de Preço:".$precoAdd."<br/>";};
        
		if (  $incluso ==true  ) {
                 //$_SESSION['carrinho'] = array();
				 $arrayCarrinho[$chave]['idPost'] = $postID;
                 $arrayCarrinho[$chave]['prodString'] = trim($postID.$variacaoCor);
                 $arrayCarrinho[$chave]['variacaoProduto'] = $variacaoCor;
                 $arrayCarrinho[$chave]['qtdProduto'] =   $qtdProdP;
                 
                 if($qtdCarrinho<=0){
                    unset($arrayCarrinho[$chave]);
                 };
                 
                 $sessionValue = '';
                 $blogid = intval(get_current_blog_id()); 
                 if($blogid>1){   $_SESSION['carrinho'.$blogid] = $arrayCarrinho;   }else{   $_SESSION['carrinho'] = $arrayCarrinho;   }; 

                 //echo ''.$precoAdd.'<span style="color:red">'.$qtdCarrinho.' - Este produto   foi adicionado recentemente a sua lista.</span>        <a href="'.get_bloginfo('url').'/carrinho/">Ver Carrinho</a>';
                 echo $qtdStock;
          };
  
      }else{
          echo '<span class="alerta" style="color:red">Não é possível adicionar mais unidades que o atual.</span>';
      };
 
?>