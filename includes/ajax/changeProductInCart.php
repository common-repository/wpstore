<?php

include("../../../../../wp-load.php");
 
$oid = intval($_REQUEST['oid']);
$oidC = intval($_REQUEST['oidC']);
 
?>
<div class='single'>
     <div id="conteudo" itemscope itemtype="http://data-vocabulary.org/Product">
         <div class="entry-content">
			 
             <div class="comprarProduto "> 
             
                
                              <?php   	
             	                 //PLUGIN SHOP FUNCTION --------------------------------------
                                    custom_get_select_stock_formChange($oid);  
                             ?>

            </div>
			 
			 
			 
			 
		 </div>
	 </div>
</div>