<?php
  $simbolo =  get_current_symbol();   
  
  global $current_user;

  get_currentuserinfo();

  $idUser = $current_user->ID;
  
  
   
  ?>
  <div id="meusPedidos" class="aba">

	
	     
	
    <h2>Meus Pedidos</h2>
          
    
    
    <form id="editarPedidos">
          
    
    
    <p class="buscarPedido">
        <label for="numPedido" class="numPedido">Número do Pedido</label>
        <input type="text" id="numPedido" name="numPedido" class="numPedido" />
        <input type="submit" value="Buscar" class="buscar" />
    </p>
          
    
    
    
    
    <table>
    	<thead>
    	<tr>
            <th class="thNumero">Número do pedido</th>
            <th class="thData">Data do Pedido</th>
            <th class="thValor">Valor Total</th>
            <th class="thAvaliar  hide-phone" >Avaliar</th>
            <th class="thDetalhes">+ detalhes</th>
        </tr>
        </thead>
        
        <tbody>
        
           
 
 
 
 
 
 
 
 
            <?php

               global $wpdb;
               $tabela = $wpdb->prefix."";
               $tabela .=  "wpstore_orders";

               $totalpedidos = 0;

               $fivesdrafts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM  `$tabela` WHERE  `id_usuario`='$idUser' ORDER BY `id`  DESC " ,1,'') );

               $tipo_pagto = "";

               foreach ( $fivesdrafts as $fivesdraft ){

                   $totalpedidos +=1;
                   $id = $fivesdraft->id; 
                   $idPedido = $fivesdraft->id_pedido;
               	   $valor_total = $fivesdraft->valor_total;
               	   $frete = $fivesdraft->frete;
                   $tipo_pagto = $fivesdraft->tipo_pagto;
                   $status_pagto = $fivesdraft->status_pagto;
                   $comentario_cliente = $fivesdraft->comentario_cliente ;
                   $comentario_admin = $fivesdraft->comentario_admin;

                   //   echo "ID Pedido : ".$idPedido ."<br/><br/>";
                   ///	echo "Valor : ".$valor_total."<br/><br/>";
                   //	echo "Frete : ".$frete."<br/><br/>";
                   //	echo "Tipo de pagamento : ".$tipo_pagto."<br/><br/>";
                   //	echo "STATUS : ".$status_pagto."<br/><br/>";

               	$fretev = 0;
               	$totalPagto = getPriceFormat(custom_get_sum( $valor_total,$fretev));

               	//echo "Observações1 : ".$comentario_cliente."<br/><br/>";
                   //echo "Observações2 : ".$comentario_admin."<br/><br/>";
              //     echo "<hr/>";

                   $dataArray = explode('.',$idPedido);

                   $get_total_Products = custom_get_total_products_in_order($idPedido); 



                   if($status_pagto=="PENDENTE"){
           			$cor = "#ff5f76";
           			}elseif($status_pagto=="VERIFICANDO"){
           			$cor = "#A2C6DE";
           			}elseif($status_pagto=="APROVADO"){
           			$cor = "green";
           			}else{
           		   	$cor = "red"; 
           			};

                    $cupom=  explode('***',$comentario_admin);

                    $numeroCupom = $cupom[0];

                                          
                                          $desconto = 0.00;
                                          $vt = $totalPagto; 
                                          $vt = str_replace('.','',$vt);
                                          $vt = str_replace(',','.',$vt);
                                          $vt = floatval($vt);


                                           if($cupom[1]=="Valor"){ 
                                              $msg =  $cupom[1]." $moedaCorrente".$cupom[2];
                                              $desconto = floatval(str_replace(',','.',$cupom[2]));
                                            }elseif($cupom[1]=="Percentual"){
                                              $msg = $cupom[1]." " .$cupom[2]."%" ;  
                                              $desconto = ( $vt*floatval(str_replace(',','.',$cupom[2])) ) / 100 ;
                                            };


                                            $precoAdddArray = explode('(R$',$frete);
                                   	        $tipoFrete = $precoAdddArray[0];
                                            $frete = str_replace(')','',$precoAdddArray[1]);
                                            $frete =  str_replace(',','.',$frete);

                                          	$vtf = $vt+floatVal($frete)-$desconto ;

                                       	    $totalPagto = $vtf;

                                            $obs = ""; 

                                            if( intval($totalPagto)<0){
                                                 $positivoTotal = str_replace('-','',$totalPagto);
                                                   $obs = "<br/><span style='font-size:0.8em;color:red'>Seu cupom é maior que o total de suas compras . Em breve você receberá um  novo cupom no valor de $positivoTotal. </span><br/><br/>";
                                                $comentarioAdmin .= $obs;
                                                 $totalPagto= "0.00";
                                             };

                                             
                                             if($frete==""){$frete = "0.00"; }

                  
                    $arrInfP = explode(".",$idPedido);   
                    $ano = $arrInfP[2];
                    $mes=  $arrInfP[3];   
                    $dia =  $arrInfP[4];   
                ?>
                
                
        	<tr> 
        	      
            	<td class="idPedido"><?php echo $idPedido; ?></td>      
            	
                <td><?php echo $dia; ?>/<?php echo $mes; ?>/<?php echo $ano; ?></td>       
                
                <td><?php echo $simbolo; ?><?php echo getPriceFormat($totalPagto); ?></td>   
                
                <td class="hide-phone">
                    <?php if($status_pagto=="APROVADO"){  ?>  
                    <span class="avaliarCompra" rel="<?php echo $id; ?>" >Avaliar Compra</span>
                    <?php }; ?>  
                </td>
                       	<?php  $idPaginaPedido =   get_idPaginaPedido();    ?>
                      
                <td class="detalhesProdutos" rel="<?php echo $id; ?>"  ><span class="detProd hide-phone" > <a href="<?php echo get_permalink($idPaginaPedido); ?>?order=<?php echo $idPedido; ?>" target="_blank">Detalhes do Pedido</a></span>  
                
                <span class="detProdMobile hide-desktop show-phone">+</span></td>  
             
            </tr>
            
          
          <?php }; ?>   
               	
               	
               	
            
        </tbody>
        
    </table>
          
         
    <div id="contentDetalhesPedido">
    <?php  //include('meu-pedido.php'); ?>
    </div>
    
    
    </form>
    
</div><!-- #meusPedidos -->