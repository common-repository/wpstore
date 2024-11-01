<?php


 

if($_POST['submit']=="Gravar"){
    
    $status  = $_POST['statusID'];
  
    for ($i=0; $i<=count($_POST['list']);$i++) {   
       $ID = $_POST['list'][$i]; 
       $comentario  = $_POST['comentario_'.$ID ];  
       alteraAvaliacaoStatus($ID,$status ,$comentario);  
    };
   
}elseif($_POST['submit']=="Salvar"){
 
    for ($i=0; $i<=count($_POST['list']);$i++) {   
       $ID = $_POST['list'][$i]; 
        $comentario  = $_POST['comentario_'.$ID ]; 
        alteraAvaliacaoComentario($ID, $comentario);  
    };
   
};


 
   global $wpdb;
   $tabela = $wpdb->prefix."";
   $tabela .=   "wpstore_orders_products"; 
   
   

   $oid = $_POST['oid'];
   $pid = $_POST['pid'];
   $oemail = $_POST['oemail'];


    $andQuery="";
   
       $sql = "SELECT *FROM `$tabela`  WHERE   `comentarioCLiente` !='' ORDER BY `ID` DESC";

       if(trim($oemail) != ''){
           $uid = trim($oemail);
           $idUser =  email_exists($uid);
          $sql = "SELECT *FROM `$tabela`  WHERE `id_usuario`='$idUser' AND `comentarioCLiente` !='' ORDER BY `ID` DESC";
       }
       
       if(trim($pid) != ''){
              $sql = "SELECT *FROM `$tabela`  WHERE `id_produto`='$pid' AND `comentarioCLiente` !='' ORDER BY `ID` DESC";
       }  
       
       if(trim($oid) != ''){
           $oid = trim($oid);
           $sql = "SELECT *FROM `$tabela`  WHERE `id_pedido`='$oid' AND `comentarioCLiente` !=''  ORDER BY `ID` DESC";
        }
        

   $fivesdrafts = $wpdb->get_results($sql);
    
    ?>

    

   
   
   
   
   
   
   
   
   
       <div id="cabecalho">
       	<ul class="abas">
       		<li>
       			<div class="aba gradient">
       				<span>Avaliações</span>
       			</div>
       		</li>  

       		 <?php /* 
       		<li>
       			<div class="aba gradient">
       				<span>Homepage</span>
       			</div>
       		</li>
       		<li>
       			<div class="aba gradient">
       				<span>Slide Home</span>
       			</div>
       		</li>
       		<li>
       			<div class="aba gradient">
       				<span>Sidebar</span>
       			</div>
       		</li>                   

       					*/ ?>      

       		<div class="clear"></div>
       	</ul>
       </div><!-- #cabecalho -->       





       <div id="containerAbas">  



       	<div class="conteudo"> 
       	
       	
       	
       	
       	
       	<form action="<?php echo verifyURL(get_option( 'siteurl' ))  ."/wp-admin/admin.php?page=lista_avaliacoes";?>"  method="post" >

            <p>Pesquise por :</p>
     		<label>ID do Pedido: </label>
     		<input type="text"  name="oid" value="<?php echo $oid; ?>"/>  <br/>
     		<label>ou pelo ID DO PRODUTO : </label>
     		<input type="text"  name="pid" value="<?php echo $pid; ?>"/> <br/> 
            <label>ou pelo E-mail do cliente : </label>
     		<input type="text"  name="oemail" value="<?php echo $oemail; ?>"/> 

             <br/>  <input type="submit"  name="submit" value="Filtrar"/>
     	</form><br/>

   
       		
 
	
	<?php 
	
	$tipo_pagto = "";
    
    
    if ($fivesdrafts) {
        
        
        ?>
 
	<form action="<?php echo verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=lista_avaliacoes";?>"  method="post" >
	
	
	<label>Selecionar Todos:</label>
	
	<input name="check" id="check" onClick="return selectCheckBox();"  type="checkbox"> 

 

   	<?php

        $orderCount = 0;

       foreach ( $fivesdrafts as $fivesdraft ){
           
        
              $id = $fivesdraft->id;
              $idPedido = $fivesdraft->id_pedido;
              $idUsuario = $fivesdraft->id_usuario;  
                      
              
              
	 	          $user_info = get_userdata($idUsuario); 
                  $email =  $user_info->user_email;       
	 	          $first_name   = trim(get_user_meta($idUsuario,'first_name',true));        
                  $last_name    = trim(get_user_meta($idUsuario,'last_name',true));
                  $userCidade = trim(get_user_meta($idUser,'userCidade',true));
                  $userEstado = trim(get_user_meta($idUser,'userEstado',true));
                      
                 $nome  = $first_name." ".$last_name;       
                 $localizacao  = $userCidade." ".$userEstado;  
                 
          	  $idProduto = $fivesdraft->id_produto; 
              $status = $fivesdraft->comentarioStatus;
              $comentario_cliente = $fivesdraft->comentarioCliente ;
              $comentario_data = $fivesdraft->comentario_data;  
           
                $cor = "";
           	    if($status=="PENDENTE"){
   				$cor = "#fffadf ";
   			    }elseif($status=="APROVADO"   ){
   				$cor = "#b2ffc8";
   				}elseif($status=="CANCELADO"){
   				$cor = "#ff6865";
   				}else{
   				$cor = "#fffadf";
   				};
   				
          
			   
        ?>
                  
       	
       	    <div class="bloco" style="background:<?php echo $cor; ?>;padding:10px;margin-bottom:5px;"  >      

    		<h3> <input type='checkbox' id='check_<?php echo $orderCount ?>'  name='list[]' value='<?php echo $id; ?>'/> 
    		       <?php echo $comentario_cliente; ?>  <br/><br/>
    		
    	   
    		 <?php 
    		    echo " sobre prod ID ($idProduto):<a href='".get_permalink($idProduto)."'>".get_the_title($idProduto)."</a>";
              ?>
    		     
    		</h3>

    		<span class="seta" rel='box_<?php echo $orderCount ?>'></span>     
    		
    		
    		<div class="texto" id='box_<?php echo $orderCount ?>'>
    		
    	    
       	
      
       	
                  <div>
               	       <br/><strong>STATUS:</strong> <?php echo  $status_comentario; ?>    
                       <br/><strong>Comentado  em:</strong> <?php echo $comentario_data; ?>
                       <br/><strong>Cliente : </strong>  <?php echo  $nome; ?> ,  <?php echo $email; ?>  , <?php echo $localizacao ; ?> 
                  </div>
               
               
                 <div class="clear"></div>
                 <br/><br/>     
                 
                 
                <div>  <p>Você pode editar o texto para exibir ao público. Após concluir clique no botão salvar  . </p>
                    <textarea  name='comentario_<?php echo  $id; ?>' id="comentario_<?php echo $orderCount; ?>" style="width:90%;height:150px;" ><?php echo $comentario_cliente; ?></textarea>
                    <br/>
                </div>  
                
              
              <div class="clear"></div> 
              
              <br/><br/>
              
                <div class='controleStatus'>   
 
                      <a  class="bttrocar" rel="check_<?php echo $orderCount ?>"  href="#trocarstatus">Alterar Status</a>    
               
                      <input   class="salvarPergunta salvar" rel="check_<?php echo $orderCount ?>" type="submit"  name="submit" value="Salvar"  />  
                      
                       
                </div> 
                 <div class='clear'></div>
              <br/>
              
              <br/>
                        
     

   		<?php /*
   		<div class="conteudo">
   			Conteúdo da aba 2
   		</div>


   		<div class="conteudo">
   			Conteúdo da aba 3
   		</div>    


   		<div class="conteudo">
   			Conteúdo da aba 4
   		</div>     
   		*/ ?>



         		</div>   <!-- .texto -->
          	</div><!-- .bloco -->
          	
         
     
     
           <?php     
           
           $orderCount +=1;
            };
            
            ?>

 
 
   <br/>
   
   <div id="trocarstatus"></div>
   
   <h3>Escolha acima os comentários que deseja mudar o status </h3>

   <br/>  

	<select name="statusID">
		<option value="0">Mudar Status</option>
       <option value="PENDENTE">PENDENTE</option>
        <option value="APROVADO">APROVADO</option>
       <option value="CANCELADO">CANCELADO</option>     
    </select>  


    <br/>

 
    
    

   <input type="submit"  name="submit" value="Gravar" onclick="return recordAction('Gravar');" />
 



	</div><!-- .content -->


 

	</form>

 
                    
 
 
 
           		<script>  
           	  
           	 
           		function checkAll(field){
           		for (i = 0; i < field.length; i++)
           			field[i].checked = true ;
           		}

           		function uncheckAll(field){
           		for (i = 0; i < field.length; i++)
           			field[i].checked = false ;
           		}

           		function selectCheckBox(){
           		    
           			field = document.getElementsByName('list[]');
           			
           			var i;
           			
           			ch	= document.getElementById('check');
           			
           			if(ch.checked){
           				checkAll(field);
           			}else{
           				uncheckAll(field);
           			}
           			
           		}   



           		function recordAction(tipo){   
           	 
           			var flag   = false;
                     
                 
         		    if(tipo=="Salvar"){
         		              rel = jQuery(this).attr('rel');
                            jQuery('input#'+rel).attr('checked','checked');
                      
         		    }
          
          
                    var chklength = document.getElementsByName("list[]").length;
                    
           			for(i=0;i<chklength;i++){
           			    
           			    flag = document.getElementById("check_"+i).checked;
           			    if(flag == true ){
           			   	  break;
           				};
           				
           			};
           			
           		     
           			if(flag == false){

           			if(tipo=="Gravar"){
           			   	 alert("Por Favor, antes de prosseguir Selecione um comentario para editar");
           				 return false;				
           			};
           			

           			};  

 
                    if(tipo=="Gravar"){
           				   if(!confirm('Você realmente deseja editar este(s) comentario(s) ?')){
           				   return false;
           		           };	
           		    };
               return true;
          };     
          
          
          
          
          
                 	 jQuery('.seta').click(function(){
                 	     rel = jQuery(this).attr('rel');
                 	     jQuery('.texto').hide();
                 	     jQuery('#'+rel).show();
                 	 });   
                 	 
                 	 
                 	 
                 	 
                 	 
                 	         jQuery('.verHistorico').click(function(){
                                   rel = jQuery(this).attr('rel');
                                   jQuery('.'+rel).fadeIn();

                               });
                               
                                jQuery('.bttrocar').click(function(){
                                     rel = jQuery(this).attr('rel');
                                     jQuery('input#'+rel).attr('checked','checked');

                                 });
                      

                                 jQuery('.salvar').click(function(){
                                          rel = jQuery(this).attr('rel');
                                          jQuery('input#'+rel).attr('checked','checked');

                                });



       	</script>
       	
       	
       	
       	
       	
	
	
	

		<?php
 
	   }else{
		?>
		    <h2> Não há avaliações realizadas </h2>
	  <?php }; //FINAL PAGINA-------------------------------?>
