<?php


if( intval($_REQUEST['idRmv'] )>0 ){
      if(is_admin()){
      global $wpdb;
      $tabela = $wpdb->prefix."";
      $tabela .=   "wpstore_perguntas_products"; 
      $ID = $_REQUEST['idRmv'];
      $resultQuery = $wpdb->query("DELETE FROM `$tabela` WHERE `id` = '$ID' ");
  	  $resultQuery = $wpdb->query("DELETE FROM `$tabela` WHERE `idr` = '$ID' AND  `idr` != '0' "); 
  	  //wp_redirect(verifyURL(get_bloginfo('url')).'/wp-admin/admin.php?page=lista_pedidos');
  	  	  echo "<script>window.location='".verifyURL(get_bloginfo('url'))."/wp-admin/admin.php?page=lista_perguntas'</script>";
      };
  	  
};

if($_POST['submit']=="Deletar"){
  
    for ($i=0; $i<=count($_POST['list']);$i++) {

      	    $ID = $_POST['list'][$i];
          
            global $wpdb;
            $tabela = $wpdb->prefix."";
            $tabela .=  "wpstore_perguntas_products";
             
           $resultQuery = $wpdb->query("DELETE FROM `$tabela` WHERE `id` = '$ID'  ");
           $resultQuery = $wpdb->query("DELETE FROM `$tabela` WHERE `idr` = '$ID' AND  `idr` != '0' "); 
         
           //FINAL insere  no total de Inscrições da Etapa  

	} 
	
        //	wp_redirect(verifyURL(get_bloginfo('url')).'/wp-admin/admin.php?page=lista_pedidos');
	   echo "<script>window.location='".verifyURL(get_bloginfo('url'))."/wp-admin/admin.php?page=lista_perguntas'</script>";
    exit;
          
            
}elseif($_POST['submit']=="Gravar"){
    
    $status  = $_POST['statusID'];
  
    for ($i=0; $i<=count($_POST['list']);$i++) {   
       $ID = $_POST['list'][$i]; 
       $comentario  = $_POST['comentario_'.$ID ];  
       alteraPerguntaStatus($ID,$status ,$comentario);  
    };
   
}elseif($_POST['submit']=="Salvar"){
 
    for ($i=0; $i<=count($_POST['list']);$i++) {   
       $ID = $_POST['list'][$i]; 
        $comentario  = $_POST['comentario_'.$ID ]; 
        alteraPerguntaComentario($ID, $comentario);  
    };
   
};


 if($_POST['submit']=="Gravar" || $_POST['submit']=="Salvar"){ //enviar email caso resposta 

      for ($i=0; $i<=count($_POST['list']);$i++) {   
		   
      $ID = $_POST['list'][$i]; 
	  $comentario  = $_POST['comentario_'.$ID ]; 
	  $status  = $_POST['statusID'];
	    
	  $tipo = "";
	  $idr = '';
	  
      global $wpdb;
      $tabela = $wpdb->prefix."";
      $tabela .=  "wpstore_perguntas_products";    
      $sql = "SELECT *FROM `$tabela`  WHERE `id`='$ID'  ORDER BY `ID` DESC ";
      $perguntas = $wpdb->get_results($sql);  
	  
	  
         foreach($perguntas as $pergunta ){   
		  	 $tipo = $pergunta->comentario_tipo;
			  $idr = $pergunta->idr ;
         };
  
   
	     if($tipo=="Resposta" && $status =="APROVADO"){
  	  	    //Mandar email com resposta ao usuário ---------------
			
	        $sql = "SELECT *FROM `$tabela`  WHERE `id`='$idr'  ORDER BY `ID` DESC ";
	        $perguntas2 = $wpdb->get_results($sql);  
			
            foreach($perguntas2 as $pergunta2 ){   
				
   		  	$nome = $pergunta2->nome_cliente;
   		  	$email = $pergunta2->email_cliente;
   		  	$pergunta = $pergunta2->comentario_cliente;
   		  	$tipo = $pergunta2->comentario_tipo;
			$idProduto = $pergunta2->id_produto;
			
            //------
			$usuarioNome = $nome;
	  	  	$usuarioEmail = $email;
	 
	  	  	$assunto ='Resposta a sua pergunta na loja '.verifyURL(get_bloginfo('url'));
	  	  
		  	$conteudo = "Olá $nome , </br> Sua  pergunta  em nosso site foi respondida.<br/><br/> <strong>Duvida sobre o produto </strong>: <a href='".verifyURL(get_permalink($idProduto))."'>".get_the_title($idProduto)."</a> <br/><br/>";
			
			$conteudo .= "<strong>Você perguntou  </strong>: $pergunta <br/><br/>";
			
			
			
	  	  	$conteudo .= "<strong>Resposta </strong>: $comentario <br/>";
	 	  
			enviaEmailPergunta($usuarioNome,$usuarioEmail,$assunto,$conteudo);
			
            };
  	 
			//mandar email com resposta ao usuario ---------------
         };
	  
	 };
	  
  };
 
   global $wpdb;
   $tabela = $wpdb->prefix."";
   $tabela .=   "wpstore_perguntas_products"; 
   
   

   $oid = $_POST['oid'];

   $oemail = $_POST['oemail'];


    $andQuery="";
   
    $sql = "SELECT *FROM `$tabela`  ORDER BY `id` DESC";

     if(trim($oemail) != ''){
          $sql = "SELECT *FROM `$tabela`  WHERE `email_cliente`='$oemail' ORDER BY `id` DESC";
     }

     if(trim($oid) != ''){
         $oid = trim($oid);
         $sql = "SELECT *FROM `$tabela` WHERE `id_produto`='$oid'    ORDER BY `id` DESC";
      }
 

   $fivesdrafts = $wpdb->get_results($sql);
    
    ?>

    

   
   
   
   
   
   
   
   
   
       <div id="cabecalho">
       	<ul class="abas">
       		<li>
       			<div class="aba gradient">
       				<span>Perguntas</span>
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
       	
       	
       	
       	
       	
       	<form action="<?php echo verifyURL(get_option( 'siteurl' ))  ."/wp-admin/admin.php?page=lista_perguntas";?>"  method="post" >

            <p>Pesquise por :</p>
     		<label>ID do Produto: </label>
     		<input type="text"  name="oid" value="<?php echo $oid; ?>"/>  <br/>
     		<label>ou pelo E-mail do cliente : </label>
     		<input type="text"  name="oemail" value="<?php echo $oemail; ?>"/> 

              <input type="submit"  name="submit" value="Filtrar"/>
     	</form><br/>

   
       		
 
	
	<?php 
	
	$tipo_pagto = "";
    
    
    if ($fivesdrafts) {
        
        
        ?>
 
	<form action="<?php echo verifyURL(get_option( 'siteurl' )) ."/wp-admin/admin.php?page=lista_perguntas";?>"  method="post" >
	
	
	<label>Selecionar Todos:</label>
	
	<input name="check" id="check" onClick="return selectCheckBox();"  type="checkbox"> 

 

   	<?php

        $orderCount = 0;

       foreach ( $fivesdrafts as $fivesdraft ){
           
        
           $id = $fivesdraft->id;
           $idr = $fivesdraft->idr;    
           $idProduto = $fivesdraft->id_produto;
           $nome = $fivesdraft->nome_cliente;      
           $email = $fivesdraft->email_cliente;   
           $localizacao = $fivesdraft->localizacao_cliente;  
           
           $status_comentario  = $fivesdraft->comentario_status;
           $comentario_cliente = $fivesdraft->comentario_cliente ;
           $comentario_data = $fivesdraft->comentario_data ; 
           $comentario_tipo = $fivesdraft->comentario_tipo;     
           
                $cor = "";
           	    if($status_comentario=="PENDENTE"){
   				$cor = "#fffadf ";
   			    }elseif($status_comentario=="APROVADO"   ){
   				$cor = "#b2ffc8";
   				}elseif($status_comentario=="CANCELADO"){
   				$cor = "#ff6865";
   				}else{
   				$cor = "#fffadf";
   				};
   				
          
				        

           
        ?>
                  
       	
       	    <div class="bloco" style="background:<?php echo $cor; ?>;padding:10px;margin-bottom:5px;"  >      

    		<h3> <input type='checkbox' id='check_<?php echo $orderCount ?>'  name='list[]' value='<?php echo $id; ?>'/> 
    		       <?php echo $comentario_cliente; ?>  <br/><br/>
    		

    		 <?php 
		 
    		                                     
    		    if($comentario_tipo=='Resposta'){ 
    		       $sql = "SELECT *FROM `$tabela`  WHERE `id`='$idr' AND  `comentario_tipo`='Pergunta'   ORDER BY `id` DESC ";
                   $respostas = $wpdb->get_results($sql);  
                
                    foreach($respostas as $resposta ){
                          echo "<strong  >Resposta a pergunta: </strong>".$resposta->comentario_cliente."<br/><br/>";   
                    }; 
    		   
    		    }; 
    		    echo " sobre prod ID ($idProduto):<a href='".verifyURL(get_permalink($idProduto))."' target='_blank'>".get_the_title($idProduto)."</a>";
                
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
                   
                <?php if($comentario_tipo!='Resposta'){ ?>
                   <a target="_BLANK" href="<?php echo verifyURL(get_bloginfo('url')); ?>/faca-uma-pergunta/?idp=<?php echo $idProduto; ?>&resp=<?php echo $id; ?>">Responder</a>  
                 <?php }; ?>  
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
   
   <h3>Escolha acima as perguntas  que deseja mudar o status </h3>

   <br/>  

	<select name="statusID">
		<option value="0">Mudar Status</option>
       <option value="PENDENTE">PENDENTE</option>
        <option value="APROVADO">APROVADO</option>
       <option value="CANCELADO">CANCELADO</option>     
    </select>  


    <br/>

 
    
    

   <input type="submit"  name="submit" value="Gravar" onclick="return recordAction('Gravar');" />
   <input type="submit"  name="submit" value="Deletar" onclick="return recordAction('Delete');" /> 

          



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

           			if(tipo=="Delete"){
           			     alert("Por Favor, antes de prosseguir Selecione o comentario para deletar");
           				 return false; 
           			}else{
           			   	 alert("Por Favor, antes de prosseguir Selecione um comentario para editar");
           				 return false;				
           			};
           			

           			};  

 
                    if(tipo=="Delete"){
           			       if(!confirm('Você realmente deseja apagar este(s) comentario(s)')){
           			       return false;
           			       };
           		    }else{
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
		    <h2> Não há perguntas realizadas </h2>
	  <?php }; //FINAL PAGINA-------------------------------?>
