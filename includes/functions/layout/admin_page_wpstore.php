<?php

 $simbolo = get_current_symbol();    
 
 
if ( current_user_can( 'manage_options' ) ||  current_user_can( 'edit_posts' ) ) {
    /* A user with admin privileges */
} else {
    $urlR = verifyURL(get_bloginfo('url')).'/wp-admin';
	 echo '<script>window.location = "'.$urlR.'";</script>';
}


 
    $semana = array(
        'Sun' => 'Domingo',
        'Mon' => 'Segunda-Feira',
        'Tue' => 'Terca-Feira',
        'Wed' => 'Quarta-Feira',
        'Thu' => 'Quinta-Feira',
        'Fri' => 'Sexta-Feira',
                'Sat' => 'Sábado'
    );
 
    $mes_extenso = array(
        'Jan' => 'Janeiro',
        'Feb' => 'Fevereiro',
        'Mar' => 'Marco',
        'Apr' => 'Abril',
        'May' => 'Maio',
        'Jun' => 'Junho',
        'Jul' => 'Julho',
        'Aug' => 'Agosto',
        'Nov' => 'Novembro',
        'Sep' => 'Setembro',
        'Oct' => 'Outubro',
        'Dec' => 'Dezembro'
    );

?>    

<?php
	
	   $plugin_directory = str_replace('functions/layout/','',plugin_dir_url( __FILE__ ));
	   
?>
 <script src="<?php echo  $plugin_directory; ?>js/Chart.js"></script>

<div id="cabecalho">
	<ul class="abas">
		<li>
			<div class="aba gradient">
				<span>WPSTORE</span>
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








<?php
 //RELATORIO PERIODO ------------------------------------------ 
 
 $dataInicio= $_POST['periodoInicial'];
 $dataFim = $_POST['periodoFinal'];
 
 $mesCorrente = gmdate('m/Y'); 
 $mes = date('M', strtotime( gmdate('y-m-d') )); 
 $ano = gmdate('Y');
 
 $dataHoje = gmdate('d/m/Y');
 $diahoje = date('D', strtotime( gmdate('y-m-d') ));

 $nomeMes = "";    
 
 if( $dataInicio==""){
	 $dataInicio = "01/".$mesCorrente;
	 $nomeMes = $mes_extenso["$mes"];   
 };
 
 if( $dataFim==""){
	 $dataFim =  $dataHoje;
 };
 

 if ( $dataInicio != "" ) {  
	
	
 if($dataFim==""){
	 $dataFim = $dataInicio;
 }
 
 $arrHoje =  getRelatorioVendas($dataInicio,$dataFim);
 

 $diasPeriodo =    $arrHoje['diasPeriodo'];
 
 $valoresAprovados =   $arrHoje['valoresAprovados'];
 $valoresPendentes =   $arrHoje['valoresPendentes'];
 $valoresCancelados =   $arrHoje['valoresCancelados'];
 


 


 ?>  
 



<div id="containerAbas">  
 

	<form action="<?php echo verifyURL(get_option( 'siteurl' ))  ."/wp-admin/admin.php?page=wpstore";?>"  method="post" >
        <h2>Pesquise por Período:</h2>
		<label>De: </label>
		<input type="text"  name="periodoInicial" class='datepicker' value="<?php echo $dataInicio; ?>"/>  
		<label>Até : </label>
		<input type="text"  name="periodoFinal"  class='datepicker'  value="<?php echo $dataFim; ?>"/>
	    <input type="submit"  name="submit" value="Filtrar"/>
	</form><br/><br/><br/><br/>
 
 
	<div class="conteudo">
		
		
		
			
			
		
		
		
		 
	 
			
			
		<div class='itemRelatorio'>
			<h2> Período  : <?php if($nomeMes!=""){ echo $nomeMes; };?> De  <?php echo  $dataInicio; ?> a  <?php  echo $dataFim; ?>  </h2>
			<ul>
				<li><strong>Total:</strong><?php echo $simbolo; ?><?php echo getPriceFormat($arrHoje['totalValor']); ?> (<?php echo $arrHoje['totalPedidos']; ?> pedidos)</li>
				 
				<li><strong>Aprovados, em separação  ou  entregues :</strong> <?php echo $simbolo; ?><?php echo getPriceFormat($arrHoje['totalAprovadosValor']+$arrHoje['totalOutrosValor']); ?> (<?php echo $arrHoje['totalAprovados']+$arrHoje['totalOutros']; ?>pedidos)</li>
				<li><strong>Pendentes:</strong> <?php echo $simbolo; ?><?php echo getPriceFormat($arrHoje['totalPendentesValor']); ?> (<?php echo $arrHoje['totalPendentes']; ?>pedidos)</li>
				<li><strong>Cancelados</strong> <?php echo $simbolo; ?><?php echo getPriceFormat($arrHoje['totalCanceladosValor']); ?> (<?php echo $arrHoje['totalCancelados']; ?>pedidos)</li>
			 
			</ul>
			
			
			
			<?php if($dataInicio != $dataFim){ ?>
 
	 
			<canvas id="canvasGeral" height="400" width="540"></canvas>


				<script>

					var barChartDataV = {
						labels : [
						<?php echo $diasPeriodo; ?>
						],
						datasets : [
					
				
							{
								fillColor : "rgba(255,250,223,0.8)",
								strokeColor : "rgba(220,220,220,1)",
								data : [
								<?php echo $valoresPendentes; ?>
								]
							},
						
						
									{
							fillColor : "rgba(255,0,0,0.6)",
							strokeColor : "rgba(255,0,0,0.6)",
							data : [
							<?php echo $valoresCancelados; ?>
							]
						},
						
						{
							fillColor : "rgba(151,187,205,0.5)",
							strokeColor : "rgba(151,187,205,1)",
							data : [
							<?php echo  $valoresAprovados; ?>
							]
						}
						
						
						]
	
					}

				var myLine = new Chart(document.getElementById("canvasGeral").getContext("2d")).Line(barChartDataV);

				</script>
				
				
				<br/>
				
				<?php }; ?>
			
			<br/><br/>
			
				<p>Receita X Status Pedido</p>
				
		
			<canvas id="canvas1" height="300" width="450"></canvas>


				<script>
 
				 

				var pieData = [
						
						{
							value : <?php echo $arrHoje['totalPendentesValor']; ?>,
							color : "#F5ECCE"
						},
						{
							value : <?php echo $arrHoje['totalCanceladosValor']; ?>,
							color : "#E25359"
						},{
							value: <?php echo $arrHoje['totalAprovadosValor']+$arrHoje['totalOutrosValor']; ?>,
							color:"#B7D0DE"
						}
			
					];

			var myPie = new Chart(document.getElementById("canvas1").getContext("2d")).Pie(pieData);
			
			
			myPie.setPieUnitsColor('#9B9B9B');
			myPie.setPieValuesColor('#6A0000');
			
			
	
				</script>
			
			 
					<p style="color:#B7D0DE"><strong>Aprovados , despachados ou entregues : <?php echo  $arrHoje['totalAprovadosValor']+$arrHoje['totalOutrosValor']; ?></strong></p>
					<p style="color:#F5ECCE"><strong>Pendentes: <?php echo $arrHoje['totalPendentesValor']; ?></strong></p>
					<p style="color:#E25359"> <strong>Cancelados : <?php echo $arrHoje['totalCanceladosValor']; ?></strong></p>
			 
			
			
		</div>
		
		
		
		<?php } //RELATORIO PERIODO ------------------------------------------ ?>
 
		
		
		<?php $avaliacoesPendentes = getAvaliacoesPendentes(); ?> 
		<div class='itemRelatorio'>
			<h2>Avaliações de produtos</h2>
			<p <?php if($avaliacoesPendentes>0){ echo 'class="red"'; }; ?> > 
				<a href='<?php bloginfo('url'); ?>/wp-admin/admin.php?page=lista_avaliacoes'   <?php if($avaliacoesPendentes>0){ echo 'class="red"'; }; ?>  target="_blank" >
			<strong>Avaliações Pendentes:</strong>  <?php echo $avaliacoesPendentes; ?></a> </p>
			<p>  <a href='<?php bloginfo('url'); ?>/wp-admin/admin.php?page=lista_avaliacoes' target="_blank">Ver lista</a </p>
		</div>  
 				
				
				
				
			 
			 
				
				
		<?php  $totalPerguntas = getPerguntasPendentes(); ?>		
		<div class='itemRelatorio'>
			<h2>Perguntas</h2>
				<p  <?php if($totalPerguntas>0){ echo 'class="red"'; }; ?>   > 
					<a href='<?php bloginfo('url');?>/wp-admin/admin.php?page=lista_perguntas' <?php if($totalPerguntas>0){ echo 'class="red"'; }; ?>  target="_blank">
					<strong>Perguntas Pendentes:</strong>  <?php  echo $totalPerguntas; ?>   
				    </a>
				</p>
			<p> <a href='<?php bloginfo('url');?>/wp-admin/admin.php?page=lista_perguntas'  target="_blank" >Ver lista</a></p>
		</div>    
			
			
			
			
			
			
			
				
			<?php  $totalContatos = getContatosPendentes(); ?>		
			<div class='itemRelatorio'>
				<h2>Contatos</h2>
					<p  <?php if($totalContatos>0){ echo 'class="red"'; }; ?>   > 
						<a href='<?php bloginfo('url');?>/wp-admin/admin.php?page=lista_contatos' <?php if($totalContatos>0){ echo 'class="red"'; }; ?>  target="_blank">
						<strong>Total Contatos:</strong>  <?php  echo $totalContatos; ?>   
					    </a>
					</p>
				<p> <a href='<?php bloginfo('url');?>/wp-admin/admin.php?page=lista_contatos'  target="_blank" >Ver lista</a></p>
			</div>    
		
		
		
		
		
		
		 
		
	</div>  
	
	
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
	
	
	
	
</div><!-- .content -->
 

 