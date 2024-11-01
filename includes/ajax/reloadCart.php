<?php 

require("../../../../../wp-load.php");

 $qtdCarrinho =  custom_get_qtd_items_Cart();
 
 $operacao = $_POST['classProdP'];
 $key = $_POST['relProdP'];
 $variacaoNome = $_POST['revProdP'];
  $qtdProdP = intval($_POST['qtdProdP']);
 //echo  $variacaoNome."<br/>";
 
 $idProd =  intval($_POST['idProd']);

  
  
 $explode = explode('-',$variacaoNome);
 

 $tamanho = $explode[0]; 
 $cor = $explode[1];
 if($tamanho =="" || $cor==""){ 
 $cor = $variacaoNome;
 };
 
 $arrayCarrinho = ""; 
   
 $blogid = intval(get_current_blog_id());  
 if($blogid>1){$arrayCarrinho = $_SESSION['carrinho'.$blogid];}else{  $arrayCarrinho = $_SESSION['carrinho'];  };
 
 //print_r($arrayCarrinho);
 $postID = $arrayCarrinho[$key]['idPost'];
 if( $postID ==''){
 $postID =  $idProd;
 };
          
 //echo $postID."<br/>";
 //echo $cor."<br/>";
 //echo $tamanho."<br/>";
 
 
$qtdStock = intval(custom_get_qtd_stock($postID,$cor,$tamanho));
 $qtdStockI= $qtdStock;
$qtdVendida = intval(custom_get_qtd_vendida($postID , trim(str_replace(' ','',$cor)) , trim(str_replace(' ','',$tamanho)) ));

$qtdReservaUsuario = intval(custom_get_stock_reservaUsuario($postID,$variacaoNome));
  
  
   
  //   echo "$qtdStock ____";
  $qtdStock +=$qtdReservaUsuario;
  // echo "$qtdStock ____";
  $qtdStock -= $qtdVendida;
  // echo "$qtdStock ____";
  $qtdStock -= $qtdProdP;
  // echo " $qtdStock JJJJJ";
 
if( $qtdStock >= 0 || $operacao=="setaDown" || $operacao=="setaUp" || $operacao=="adicionarItem"   ||  $operacao=="removerItem"){
    
    $qtdCarrinho +=1;
    
    $cor = trim( str_replace(' ','',$cor) );
    $tamanho = trim( str_replace(' ','',$tamanho) );
    

    $variacaoCor = $tamanho."-".$cor;
    if($cor==""){
        $variacaoCor = $tamanho;
    }elseif($tamanho==""){
        $variacaoCor = $cor;
    }elseif($cor==$tamanho){
    	 $variacaoCor = $cor;
    }
    
    
    if($variacaoCor=="-"){
        $variacaoCor="";
    };
  

   if($arrayCarrinho==""){ $arrayCarrinho = array(); };
   
   $countA = 0;
   
   $incluso = false;
   $chave = "";
   
  
   $qtdPrev = 0;
   $chaveItem = "";
   
   foreach($arrayCarrinho as $key=>$item){
       
       $countA +=  1;
       
       //echo "<hr/>";
      // echo $item['prodString']."<br/>";
      // echo trim($postID.$variacaoCor)."<br/>";
      // echo "<hr/>";
       
      if( $item['prodString'] == trim($postID.$variacaoCor) ){
       
	      $incluso = true; 
          $qtdPrev = intval($item['qtdProduto']);
          $chave = $key;
		  
		  
		  $qtdPrd = $qtdPrev;
		  
		  if( $qtdProdP !=  $qtdPrev &&  $qtdStock>=0 ){
		       $qtdPrd = $qtdProdP;
		  }else{
		     if( $operacao=="setaUp"  || $operacao=="adicionarItem" ){ 
                  if($qtdStock>0  ){
                  	    $qtdPrd = $qtdPrev+1;
					    //if( $qtdPrd>$qtdStock) {  $qtdPrd = $qtdStockI; };
				  }else{
					echo '<span class="alerta" style="color:red">Não é possível adicionar mais unidades que o atual.</span>';
				  };
             }elseif($operacao=="setaDown" || $operacao=="removerItem"  ){
                        $qtdPrd = $qtdPrev-1;  
			        //    if( $qtdPrd>$qtdStock ) {  $qtdPrd  = $qtdStockI ; };
				  
             };
		  };
   
      }; 
      
   }
   
   
   
    $precoAdd = get_price_product_variation($postID,$variacaoCor);
    
    if($precoAdd !=""){$precoAdd = "Variação de Preço:".$precoAdd."<br/>";};
    
   
    if (  $incluso ==true  ) {
                 //$_SESSION['carrinho'] = array();
              
                 $arrayCarrinho[$chave]['idPost'] = $postID;
                 $arrayCarrinho[$chave]['prodString'] = trim($postID.$variacaoCor);
                 $arrayCarrinho[$chave]['variacaoProduto'] = $variacaoCor;
                 $arrayCarrinho[$chave]['qtdProduto'] =  $qtdPrd;
                 
                 if($qtdPrd<=0){
                    unset($arrayCarrinho[$chave]);
                }
               
                 $sessionValue = '';
                 $blogid = intval(get_current_blog_id()); 
                 if($blogid>1){   $_SESSION['carrinho'.$blogid] = $arrayCarrinho;   }else{   $_SESSION['carrinho'] = $arrayCarrinho;   }; 
 
                 //echo ''.$precoAdd.'<span style="color:red">'.$qtdPrd.' - Este produto   foi adicionado recentemente a sua lista.</span> <a href="'.get_bloginfo('url').'/carrinho/">Ver Carrinho</a>';
                 //echo $qtdPrd;
    };
      
        echo $qtdPrd;
  
}else{
echo '<span class="alerta" style="color:red">Não é possível adicionar mais unidades que o atual.</span>';
};
 
?>