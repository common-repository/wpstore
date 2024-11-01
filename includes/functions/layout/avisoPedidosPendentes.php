<?php 

if( 
get_the_ID() != get_idPaginaPedidos() &&  
get_the_ID() != get_idPaginaPedido()  &&  
get_the_ID() != get_idPaginaObrigado() 
){  
	
 ?>
				
				<div class='obrigadoPorComprar'>
					<p class='introducao'><strong>Você tem pedidos pendentes em nosso site.</strong> </p>
					<?php /* <h4 class='pedidoNumero'><strong><?php echo $idPedido; ?></strong></h4> */ ?>
					<p class='pedidoSalvo'><strong>Vá até a pagina de pedidos para prosseguir com o pagamento.</strong></p>
					<p class='pedidoSalvoDesc'>Você também poderá cancelar seus pedidos pendentes para iniciar uma nova compra.</p>
					
					<p class='btMeusPedidos'>
<a href='<?php echo get_permalink(get_idPaginaPedidos()); ?>'>Ver Pedidos</a></p>
					
					<div class='clear'></div>
				</div><br/><br/><br/>
				
				
<?php  }; ?>