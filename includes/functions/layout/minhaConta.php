<?php
  $simbolo =  get_current_symbol();   
  
  global $current_user;

  get_currentuserinfo();

  $idUser = $current_user->ID;
  
  
   
  ?>
<div class="minhaConta">
           
           	   <ul id="minhaConta">
                      	<li class="meusDados ativo">Meus Dados</li> 
               	        <li class="meusEnderecos ">Meus Endereços</li> 
                        <li class="meusPedidos ">Meus Pedidos</li>
                        <div class="clear"></div>
               </ul>
               
               <?php include('../../../../../../themes/cfcare/shop/layout/meus-dados.php'); ?> 
               
               <?php include('../../../../../../themes/cfcare/shop/layout/meus-enderecos.php'); ?>  
               
               <?php include('../../../../../../themes/cfcare/shop/layout/meus-pedidos.php'); ?>
        </div>
        
<div class="clear"></div>
   