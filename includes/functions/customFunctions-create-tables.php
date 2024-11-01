<?php

//CREATE TABLES ----------------------------------------------------------------
   
   global $wpstore_version;
   $wpstore_version = "2.0";
   
   //verify update version 
   
   function shopPlugin_update_db_check() {
       global $wpstore_version;
     if (get_option('wpstore_version') != $wpstore_version) {
           update_option("wpstore_version", $wpstore_version);
           wpstore_createTable();
      }   
       wpstore_createTable();       
   }
         
   
   add_action('plugins_loaded', 'shopPlugin_update_db_check');
 
   function wpstore_createTable(){


	    //if(  is_home() || is_page()  || is_single() ){
        //create table ---------------------------------------------

          global $wpdb;
          global $jal_db_version;
          
          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            
   
          $table_nameA = $wpdb->prefix ."wpstore_orders"; 
           
          	$sqlA = "CREATE TABLE IF NOT EXISTS `$table_nameA` (
              `id` int(11) NOT NULL auto_increment,
              `id_pedido` varchar(155) NOT NULL,
              `id_usuario` varchar(155) NOT NULL,
              `valor_total` varchar(155) NOT NULL,
              `frete` varchar(155) NOT NULL,
              `extras` varchar(155) NOT NULL,
		      `tipo_pagto` varchar(55) NOT NULL,
              `status_pagto` varchar(500) NOT NULL,
              `comentario_cliente` varchar(3000) NOT NULL,
              `comentario_admin` varchar(3000) NOT NULL,
              `comentario_pagt` varchar(3000) NOT NULL,
              PRIMARY KEY  (`id`)
            ) AUTO_INCREMENT=1 ; ";
             
          dbDelta($sqlA);
		  
		  
		  
		  
		  
		  
    
						     
   
                 
          $table_nameB = $wpdb->prefix ."wpstore_orders_address"; 

 
                                   	 $sqlB = "CREATE TABLE IF NOT EXISTS `$table_nameB` (
                                      `id` int(11) NOT NULL auto_increment,
                                      `id_pedido` varchar(155) NOT NULL,
                                      `id_usuario` varchar(155) NOT NULL,
                                      `cep` varchar(15) NOT NULL,
                                      `cidade` varchar(155) NOT NULL,
                                      `bairro` varchar(155) NOT NULL,
                                      `estado` varchar(155) NOT NULL,
                                      `endereco` varchar(1000) NOT NULL,
                                      `numero` varchar(10) NOT NULL,
                                      `complemento` varchar(1000) NOT NULL,
                                      PRIMARY KEY  (`id`)
                                    ) AUTO_INCREMENT=1 ;";
                                   	
           
                  dbDelta($sqlB);
                  
           
           
           
           
             $table_nameC = $wpdb->prefix ."wpstore_users_address"; 

                               
                                       
                                        	 $sqlB = "CREATE TABLE IF NOT EXISTS `$table_nameC` (
                                             `id` int(11) NOT NULL auto_increment,
                                             `id_usuario` varchar(155) NOT NULL,  
                                             `nomeEndereco` varchar(155) NOT NULL,
                                             `destinatarioEndereco` varchar(155) NOT NULL, 
                                             `cep` varchar(15) NOT NULL,
                                             `cidade` varchar(155) NOT NULL,
                                             `bairro` varchar(155) NOT NULL,
                                             `estado` varchar(155) NOT NULL,
                                             `endereco` varchar(1000) NOT NULL,
                                             `numero` varchar(10) NOT NULL,
                                             `complemento` varchar(1000) NOT NULL,  
                                             `referencia` varchar(1000) NOT NULL, 
                                             `tipoEndereco` varchar(20) NOT NULL,   
                                             PRIMARY KEY  (`id`)
                                           ) AUTO_INCREMENT=1 ;";


                     dbDelta($sqlB);


       
                       
                  
                 
                  $table_nameD = $wpdb->prefix ."wpstore_orders_products"; 

                   $sql3 = "CREATE TABLE IF NOT EXISTS `$table_nameD` (
                   	  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
                   	  `id_pedido` VARCHAR(155) DEFAULT '' NOT NULL,
                   	  `id_usuario` VARCHAR(155) DEFAULT '' NOT NULL,
                   	  `id_produto` VARCHAR(155) DEFAULT '' NOT NULL,
                   	  `preco` VARCHAR(155) DEFAULT '' NOT NULL,
                   	  `variacao` VARCHAR(55) DEFAULT '' NOT NULL,
                   	  `qtdProd` VARCHAR(55) DEFAULT '' NOT NULL,
                   	  `precoAlt` VARCHAR(55) DEFAULT '' NOT NULL,
                   	  `precoAltSymb` VARCHAR(55) DEFAULT '' NOT NULL, 
                   	  `comentarioCliente` TEXT DEFAULT '' NOT NULL,
                   	  `comentarioStatus`  TEXT  DEFAULT '' NOT NULL, 
                   	  `comentario_data` DATE NOT NULL,  
                   	   PRIMARY KEY  (`id`)
                   	) AUTO_INCREMENT=1 ;";

                   dbDelta($sql3);
                   
                   
                   
                     
                   $table_nameE = $wpdb->prefix ."wpstore_perguntas_products"; 

                      $sql3B = "CREATE TABLE IF NOT EXISTS `$table_nameE` (
                           `id` int(11) NOT NULL AUTO_INCREMENT,
                           `id_produto` int(11) NOT NULL,  
                           `idr` int(11) NOT NULL,   
                           `nome_cliente` varchar(150) NOT NULL,
                           `email_cliente` varchar(150) NOT NULL,
                           `localizacao_cliente` varchar(150) NOT NULL,
                           `comentario_cliente` text NOT NULL,
                           `comentario_status` varchar(15) NOT NULL,  
                           `comentario_data` DATE NOT NULL ,  
                           `comentario_tipo` TEXT NOT NULL , 
                           PRIMARY KEY (`id`)
                         ) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

                      dbDelta($sql3B);

                   
                   
                  
                   
                   
                   



                   $table_nameF = $wpdb->prefix  ."wpstore_orders_comments"; 

                     $sql4 = "CREATE TABLE IF NOT EXISTS `$table_nameF` (
                     	  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
                     	  `id_pedido` VARCHAR(155) DEFAULT '' NOT NULL,
                     	  `status_pagto` VARCHAR(1000) DEFAULT '' NOT NULL,
                     	  `comentario_cliente` VARCHAR(3000) DEFAULT '' NOT NULL, 
                     	  `comentario_admin` VARCHAR(3000) DEFAULT '' NOT NULL, 
                     	  `comentario_pagt` VARCHAR(3000) DEFAULT '' NOT NULL, 
                     	  `data` VARCHAR(10) DEFAULT '' NOT NULL,
                     	  PRIMARY KEY  (`id`)
                     	)  AUTO_INCREMENT=1 ;";

                     dbDelta($sql4);





                        
                     $table_nameG = $wpdb->prefix ."wpstore_stock";


                       $sql5 = "CREATE TABLE IF NOT EXISTS `$table_nameG` (
                           	      `id` mediumint(9) NOT NULL AUTO_INCREMENT,
                            	  `idPost` VARCHAR(155) DEFAULT '' NOT NULL,
                            	  `tipoVariacao` VARCHAR(155) DEFAULT '' NOT NULL,
                            	 `variacaoProduto` VARCHAR(155) DEFAULT '' NOT NULL,
                            	 `qtdProduto` VARCHAR(155) DEFAULT '' NOT NULL,
                            	  `precoOperacao` VARCHAR(55) DEFAULT '' NOT NULL,
                            	  `showOrder` VARCHAR(1000) DEFAULT '' NOT NULL,
                            	  `precoAlternativo` VARCHAR(1000) DEFAULT '' NOT NULL,
                            	  `imgAlternativa` VARCHAR(10000) DEFAULT '' NOT NULL,
                            	  PRIMARY KEY  (`id`) 
                           	)  AUTO_INCREMENT=1 ;";

                          dbDelta($sql5);






                     $table_nameH = $wpdb->prefix  ."wpstore_contacts"; 

                          $sql6 = "CREATE TABLE IF NOT EXISTS `$table_nameH` (
                          	  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
                          	  `nomeAviso` VARCHAR(155) DEFAULT '' NOT NULL,
                          	  `emailAviso` VARCHAR(100) DEFAULT '' NOT NULL,
							  `telefoneAviso` VARCHAR(15) DEFAULT '' NOT NULL,
                          	  `postIDP` mediumint(9)  NOT NULL,
                          	  `variacaoCorP` VARCHAR(100) DEFAULT '' NOT NULL,
                          	  `variacaoTamanhoP` VARCHAR(100) DEFAULT '' NOT NULL,
                          	  	  PRIMARY KEY  (`id`) 
                             	)  AUTO_INCREMENT=1 ;";

                               
							   
							    dbDelta($sql6);
                           
                                $table_nameI = $wpdb->prefix  ."wpstore_descontos"; 

                                $sql7 = "CREATE TABLE IF NOT EXISTS `$table_nameI` (
                               	  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
                               	  `numeroCupom` VARCHAR(155) DEFAULT '' NOT NULL,
                               	  `tipoDesconto` VARCHAR(100) DEFAULT '' NOT NULL,
                               	  `valorDesconto` VARCHAR(100) DEFAULT '' NOT NULL,
                               	  `limite` mediumint(9)  NOT NULL,
                               	  `qtdUsado` mediumint(9)  NOT NULL,
                                  	  PRIMARY KEY  (`id`) 
                                 	)  AUTO_INCREMENT=1 ;";

                                dbDelta($sql7);

				 // };
   
   };
   
    

   
   //call to function
  register_activation_hook(__FILE__,'wpstore_createTable');
 
   
  
   // END CREATE TABLES -----------------------------------------------------------------
   
	 
 
 	// update_option('idCatSlide',$destaques);   
 	 update_option('totalPostSlide',3);
 	 update_option('slideOrderby','ID');
 	 update_option('listagemOrder','DESC');
 	 update_option('moedaCorrenteWPSHOP','R$');
	 
	 
	 
   ?>