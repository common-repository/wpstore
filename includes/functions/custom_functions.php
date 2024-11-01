<?php 
      
      //LOGIN FACEBOOK FUNCTIONS ----------------------------------------------------------------------
     // include('custom_loginFacebook.php');    
       
	  function includeLoginFacebook(){
	
	      //LOGIN FACEBOOK FUNCTIONS ----------------------------------------------------------------------
	           include('custom_loginFacebook_2014.php');    
		      //include('custom_loginFacebook.php');
    
	  }
	  
	  
	   includeLoginFacebook();
	    
	  function curPageURL() {
	     $pageURL = 'http';
	     if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	      $pageURL .= "://";
	      if ($_SERVER["SERVER_PORT"] != "80") {
	        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	      } else {
	       $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	     }
	    $pageURL = explode("?", $pageURL);
	     return $pageURL[0];
	  }
      
      
      
      
      //função que remove acentos
      # @nome diegoSubistitui
      # @autor diegoSubistitui
      # @usar diegoSubistitui($variavel);
      function modificaAcento($sub){
          $acentos = array(
              'À','Á','Ã','Â', 'à','á','ã','â',
              'Ê', 'É',
              'Í', 'í', 
              'Ó','Õ','Ô', 'ó', 'õ', 'ô',
              'Ú','Ü',
              'Ç', 'ç',
              'é','ê', 
              'ú','ü',
              );
          $remove_acentos = array(
              'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
              'e', 'e',
              'i', 'i',
              'o', 'o','o', 'o', 'o','o',
              'u', 'u',
              'c', 'c',
              'e', 'e',
              'u', 'u',
              );
          return str_replace($acentos, $remove_acentos, urldecode($sub));
      }
      
      


 
function custom_get_category_id($blog_ID=1,$catName){
     global $wpdb;
        $prefixTerm= $wpdb->prefix."";
     $query  = "SELECT * FROM `$prefixTerm".$blog_ID."_terms` WHERE `name` = '".$catName."' LIMIT 0 , 30";
  
    if(intval($blog_ID)==1){
     $query  = "SELECT * FROM `$wpdb->terms` WHERE `name` = '".$catName."' LIMIT 0 , 30";
    }
    
    
     $tvlt_posts = $wpdb->get_results($query, OBJECT);
     $id = 0;
     foreach($tvlt_posts as $postProd ){
       $id = $postProd->term_id;   
     };
     return  $id;
}

 
   //custom get all post meta of post --------------------------------------------------
   
   function custom_get_post_meta_all($post_id){include 'custom_functions.php';
   
       global $wpdb;
       $data   =   array();
       $wpdb->query("
           SELECT `meta_key`, `meta_value`
           FROM $wpdb->postmeta
           WHERE `post_id` = $post_id
       ");
       foreach($wpdb->last_result as $k => $v){
           $data[$v->meta_key] =   $v->meta_value;
       };
       return $data;
   }
 
   
    //custom IMAGE DISPLAY--------------------------------------------------
    

    function custom_get_image($postID,$width='260',$height='160' , $crop=0 , $print=true, $principal=false ,$class2=""){
       
 
        $imgPrint = "";
        include('layout/imagemListagem.php');
        if($print==false){
            return $imgPrint;
        }
        /* */

    };   
    
    
       function get_image_path_wpstore($src) {
       global $blog_id;
       if(isset($blog_id) && $blog_id > 0) {
        $sub = get_bloginfo('url').'/wp-content'; 
        $src = str_replace($sub,'',$src);
       }
       return $src;
       }
    
    
    
    
    
    function ranger($url){
        $headers = array(
        "Range: bytes=0-32768"
        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }






  /* */
 

  add_action('save_post','my_cf_check');
  function my_cf_check($post_id) {

      // verify this is not an auto save routine. 
      if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

      //authentication checks
      if (!current_user_can('edit_post', $post_id)) return;

      //obtain custom field meta for this post
       $custom_fields = get_post_custom($post_id);

      if(!$custom_fields) return;

      foreach($custom_fields as $key=>$custom_field):

          $values = array_filter($custom_field);

          //After removing 'empty' fields, is array empty?
          if(empty($values)):
              if($key!="embedVideo"){
              delete_post_meta($post_id,$key); //Remove post's custom field
              };
          endif;

      endforeach; 

      return;

  }

  /* */
          
 
 
 add_action(  'delete_post' ,'apagarCores'); 
 add_action('trash_post','apagarCores',1,1);     
 function   apagarCores($post_id){ 
     if(!did_action('trash_post')){ 
        global $wpdb; 
        $table_name = $wpdb->prefix."wpstore_stock"; 
        $sql = "DELETE FROM  `$table_name`  WHERE `idPost`='$post_id' "; 
        $wpdb->query($wpdb->prepare("$sql",'')); 
     }  
 };


  if ( ! function_exists( 'ucc_add_cpts_to_pre_get_posts' ) ) {
      function ucc_add_cpts_to_pre_get_posts( $query ) {
          if ( $query->is_main_query() && ! is_post_type_archive() && ! is_singular() && ! is_404() ) {
          $my_post_type = get_query_var( 'post_type' );
              if ( empty( $my_post_type ) ) {
                  $args = array(
                      'exclude_from_search' => false,
                      'public' => true,
                      '_builtin' => false
                  );
                  $output = 'names';
                  $operator = 'and';
                  $post_types = get_post_types( $args, $output, $operator );

                  // Or uncomment and edit to explicitly state which post types you want.
                  // $post_types = array( 'event', 'location' );
                  // Add 'link' and/or 'page' to array() if you want these included.
                  // array( 'post', 'link', 'page' ), etc.
                  $post_types = array_merge( $post_types, array( 'post' ) );
                  $query->set('post_type', $post_types );
              }
          }
      } 
  }

  add_action( 'pre_get_posts', 'ucc_add_cpts_to_pre_get_posts' );





  add_action('wp_head', 'add_metatag');
 
  function add_metatag() {
  
  $plugin_directory = str_replace('functions/','ajax/',plugin_dir_url( __FILE__ ));
  
  $idPage = get_idPaginaPagamento();
  $pgsUrl =  get_permalink($idPage);
  
  $limitAge =  get_option('limitAgeRegisterWpstore');
 
  echo '<meta name="urlShop" content="'.$plugin_directory.'">';
  echo '<meta name="pgsUrl" content="'.$pgsUrl.'">';
  echo '<meta name="urlSite" content="'.get_bloginfo('url').'">';
  echo '<meta name="limitAge" content="'.$limitAge.'">';
   
       if( is_page( get_idPaginaPerfil() ) ){
       wp_enqueue_media();
       };
  
  
  }


 
 
 //inserindo style no header ---------------------------------
 $ajaxFiltro = true;
$tipoSkinShop = get_option('tipoSkinShop');
 if($tipoSkinShop=="DARK"){
 }else{
 wp_register_style( 'prefix-style', plugins_url('wpstore/includes/css/general-product-light.css','WP STORE' ) ,'', NULL  );    
 }
 wp_enqueue_style( 'prefix-style' );
//inserindo style no header --------------------------------- 

 

 //  WP-ADMIN DATE PICKER ----------------------------------------------
 //if($_GET['page']=='wpstore'){
wp_register_style( 'date-pickercss', plugins_url('wpstore/includes/css/ui-lightness/jquery-ui-1.8.20.custom.css','WP STORE' ) ,'', NULL ); 
          wp_enqueue_style( 'date-pickercss' );
//};
 //  WP-ADMIN DATE PICKER ----------------------------------------------  

 
//VALIDATE FORM ----------------------------------
          wp_register_script( 'validade', plugins_url('wpstore/includes/js/jquery-validade.js','WP STORE' ), array('jquery' ),NULL  );
          wp_enqueue_script( 'validade' );


          wp_register_script( 'maskInput', plugins_url('wpstore/includes/js/maskInput.js','WP STORE' ), array('validade' ),NULL  );
          wp_enqueue_script( 'maskInput' );
		  

          wp_register_script( 'validaDocumentos', plugins_url('wpstore/includes/js/validar-documentos.js','WP STORE' ), array('maskInput' ),NULL  );
          wp_enqueue_script( 'validaDocumentos' );
		  
		  
   
		  
		  
		  
//FINAL  VALIDATE---------------------------------



//  CONTROL HEAD JS --------------------------------

		 add_action( 'wp_enqueue_scripts', 'enqueue_controlHeader_script' );
 
		 function enqueue_controlHeader_script() { 
	 
	 
		     //wp_register_script( 'jui2', plugins_url('wpstore/includes/js/jquery-ui.js','WP STORE' ), array('jquery') );
		     //wp_enqueue_script( 'jui2' );
	 
	 
	 
		  	 if ( is_single() || is_home() || is_category() ) {  //SCRIPTS USED IN SINGLE -----------------
	   	             wp_register_style( 'date-swipper', plugins_url('wpstore/includes/css/swipebox.css','WP STORE' ) , '', NULL ); 
	   	             wp_enqueue_style( 'date-swipper' );
		             //inserindo JS no header ---------------------------------
	                 wp_register_script( 'swipperbox', plugins_url('wpstore/includes/js/jquery.swipebox.min.js','WP STORE' ), array('jquery' ),NULL  );
	                 wp_enqueue_script( 'swipperbox' );
				
		     }; //SCRIPTS USED IN SINGLE ----------------------------------------
			
			
			 if(is_page( get_idPaginaPerfil() )){
				 
		     wp_register_script( 'prefix-script', plugins_url('wpstore/includes/js/custom.js','WP STORE' ), array('jquery', 'jquery-ui-core' , 'jquery-ui-datepicker', 'thickbox')   );
		     wp_enqueue_script( 'prefix-script' );
			 
		     }else{
			     wp_register_script( 'prefix-script', plugins_url('wpstore/includes/js/custom.js','WP STORE' ), array('jquery', 'jquery-ui-core' , 'jquery-ui-datepicker') );
			     wp_enqueue_script( 'prefix-script' );
		     }
 
	
		 } 

//  END CONTROL  HEAD JS --------------------------------
	 
	  
// WP-ADMIN  PAGE WPSTORE DATE PICKER---------------------------------
	  	 if($_GET['page']=='wpstore'){
	           wp_register_script( 'prefix-script', plugins_url('wpstore/includes/js/custom.js','WP STORE' ), array('jquery', 'jquery-ui-core' , 'jquery-ui-datepicker', 'thickbox'),NULL  );
		     wp_enqueue_script( 'prefix-script' );
	      };
 // WP-ADMIN DATE PICKER--------------------------------- 
	 
	 
 
// WP-ADMIN  PRINT JS---------------------------------
	 if($_GET['page']=='lista_pedidos'){
		 
		 
         wp_register_script( 'prefix-script', plugins_url('wpstore/includes/js/custom.js','WP STORE' ), array('jquery', 'jquery-ui-core' , 'jquery-ui-datepicker', 'thickbox'),NULL  );
     wp_enqueue_script( 'prefix-script' );
	 
	 
     wp_register_script( 'prefix-script2', plugins_url('wpstore/includes/js/print.js','WP STORE' ), array('thickbox'),NULL  );
     wp_enqueue_script( 'prefix-script2' );
    };
// WP-ADMIN PRINT JS---------------------------------

 
 
 
 
 
 
 
	  
   //FINAL ATUALIZA DADOS DA ASSINATURA DO USUARIO-------------------------------

	 function my_plugin_page_filter_shop(){
	    
	    $registro = intval(get_option('registroWPSHOP'));
	  
	    if($registro<=0){ 
	    updatePagesShop();
	    };   
	 
     };
	     
 
	     
	 //ATUALIZA DADOS DA ASSINATURA DO USUARIO-------------------------------
   function updatePagesShop(){
             
     update_option('registroWPSHOP',1);
     
      global $current_user;

     get_currentuserinfo(); 
 
     $idUser = $current_user->ID;
     
    $page = get_page_by_title( 'Carrinho' );
    if(intval($page->ID)<=0){
      // Create post object
     $my_post = array(
     'post_title' => 'Carrinho',
     'post_content' => '[get_cart_Table]',
     'post_type' => 'page',
     'post_status' => 'publish',
     'post_author' => $idUser
     );
     $the_page_id = wp_insert_post( $my_post);
       
     add_option('idPaginaCarrinhoWPSHOP',$the_page_id,'','yes'); 
     update_option('idPaginaCarrinhoWPSHOP',$the_page_id);
                    
  };
  
  
  $page = get_page_by_title( 'Checkout' );
  if(intval($page->ID)<=0){ 	      
      	      
      // Create post object
      $my_post = array(
      'post_title' => 'Checkout',
      'post_content' => '[custom_get_checkout]',
      'post_type' => 'page',
      'post_status' => 'publish',
      'post_author' => $idUser
      );
      $the_page_id = wp_insert_post( $my_post);   
      
      add_option('idPaginaCheckoutWPSHOP',$the_page_id,'','yes'); 
       update_option('idPaginaCheckoutWPSHOP',$the_page_id);
                    	      
   };
   
   
   $page = get_page_by_title( 'Pagamento' );
   if(intval($page->ID)<=0){           	      
                    	      
       // Create post object
        $my_post = array(
        'post_title' => 'Pagamento',
         'post_content' => '[get_payment_checkout]',
         'post_type' => 'page',
         'post_status' => 'publish',
         'post_author' => $idUser 
         );
        
        $the_page_id = wp_insert_post($my_post);
         add_option('idPaginaPagtoWPSHOP',$the_page_id,'','yes'); 
         update_option('idPaginaPagtoWPSHOP',$the_page_id);                       	      
                              	      
  };
               
               
   $page = get_page_by_title( 'Pedidos' );
   if(intval($page->ID)<=0){
                   
                                   	      
           // Create post object
           $my_post = array(
           'post_title' => 'Pedidos',
           'post_content' => '[custom_get_orders_user]',
           'post_type' => 'page',
           'post_status' => 'publish',
           'post_author' => $idUser
           );
           $the_page_id =wp_insert_post( $my_post );   
           add_option('idPaginaPedidosWPSHOP',$the_page_id,'','yes'); 
           update_option('idPaginaPedidosWPSHOP',$the_page_id);
                                         	      
   };
                 
                 
   $page = get_page_by_title( 'Pedido' );
   if(intval($page->ID)<=0){                        	      
                                        	      
                                        	      
            // Create post object
             $my_post = array(
             'post_title' => 'Pedido',
             'post_content' => '[custom_get_order_user]',
             'post_type' => 'page',
             'post_status' => 'publish',
             'post_author' => $idUser
             );
            $the_page_id= wp_insert_post($my_post); 
            add_option('idPaginaPedidoWPSHOP',$the_page_id,'','yes'); 
            update_option('idPaginaPedidoWPSHOP',$the_page_id);
                                                          	      
    };
    
    
    $page = get_page_by_title( 'Meus Dados' );
    if(intval($page->ID)<=0){
     
     
              // Create post object
              $my_post = array(
                      'post_title' => 'Meus Dados',
               'post_content' => '[get_edit_form_perfil]',
               'post_type' => 'page',
               'post_status' => 'publish',
               'post_author' => $idUser);
              $the_page_id =  wp_insert_post($my_post);
              add_option('idPaginaPerfilWPSHOP',$the_page_id,'','yes'); 
              update_option('idPaginaPerfilWPSHOP',$the_page_id);
                                                                                          	      
     };
    
     $page = get_page_by_title( 'Login' );
     if(intval($page->ID)<=0){                                                          	      
                                                                                	      
                // Create post object
                 $my_post = array(
                 'post_title' => 'Login',
                 'post_content' => '[get_Login_form]',
                 'post_type' => 'page',
                 'post_status' => 'publish',
                 'post_author' => $idUser
                  );
                  $the_page_id = wp_insert_post($my_post);
                 add_option('idPaginaLoginWPSHOP',$the_page_id,'','yes'); 
                 update_option('idPaginaLoginWPSHOP',$the_page_id);                                                                        	      
                                                                            	      
                 };
                                                                  	                                                           	                    	      
      	};
	
	
      add_filter( 'the_post', 'my_plugin_page_filter_shop' );
 
 
 
 	 //ATUALIZA DADOS DA ASSINATURA DO USUARIO-------------------------------
	 
	 
	 
  //CIELO RETORNO é feito direto na pagi na cieloRESPONSE Cielo.
    
  //CIELO RETORNO é feito direto na pagi na cieloRESPONSE Cielo.
 
	 
	 //ATUALIZA TRANSACAO PAYPAL E MOIP -------------------------------
	 
      function confirmaTransacao(){
 
        //CONFIRMA PAYPAL IPN 
        if($_POST['cdp'] !=""){
        include( 'payment/Paypal/pages/IPN/ipn.php');    
        }
      
        //CONFIRMA MOIP RETORNO 
        $meuPinMoip = trim(get_option('meuPinMoip'));  
        if($_REQUEST['confirmaMoip'] == $meuPinMoip  && $_REQUEST['confirmaMoip'] !="" ){
        include( 'payment/Moip/pages/retorno.php');    
        }
		
	
      
      };


      add_filter( 'wp_head', 'confirmaTransacao' );


      add_filter( 'show_admin_bar', '__return_false' );


      add_filter( 'show_admin_bar', '__return_false' );
	 
 	 //ATUALIZA TRANSACAO PAYPAL E MOIP-------------------------------
	  
      
	  //RETORNO PAGSEGURO --------------------------------
    
      function confirmaPagseguro(){
          
           if(isset($_POST['notificationType']) && $_POST['notificationType'] == 'transaction'){
             include( 'payment/Pagseguro/retornoPagseguro.php'); 
          };
	 
      
      };


      add_filter( 'wp_head', 'confirmaPagseguro' );
       
	   //RETORNO PAGSEGURO --------------------------------
	   
	    
	  
	 
	 
	 //XML GOOGLE SHOP ---------------------------------------------------- 
      
      function rssgoogleShop(){          
		      
     		 if(isset($_GET['googlerss'])){
         	 	 include('layout/feed-google-shop.php');
      		 };          
	  
             if(isset($_GET['uolrss'])){
                  include('layout/feed-uol-shop.php');
             };  
	  
      };
        add_action( 'after_setup_theme', 'rssgoogleShop' );
   	 //XML GOOGLE SHOP ---------------------------------------------------- 
        
      
	 
 
		
		
		
        //ADD CUSTOM COLLUM IN WP ADMIN USER-------------------------------
        add_filter('manage_users_columns', 'pippin_add_user_id_column');
        function pippin_add_user_id_column($columns) {
            $columns['user_id'] = '+Infos ';
			$columns['autoriz'] = 'Autorização';
            return $columns;
        }

        add_action('manage_users_custom_column',  'pippin_show_user_id_column_content', 10, 3);
        function pippin_show_user_id_column_content($value, $column_name, $user_id) {
          
		    $user = get_userdata( $user_id );
        
			if ( 'user_id' == $column_name ){
        	     $idPaginaDt = get_idPaginaPerfil();
        	     $linkP = get_permalink($idPaginaDt );
        		return "<a href='$linkP?idUser=$user_id' target='_BLANK'>+ Infos</a>";
    		
			}elseif(  'autoriz' == $column_name ){
    			
	  		 
	  			  $autorizacao = get_usermeta($user_id, 'wpsAutorizacao');
	  			  $checked = "";
	  			  $checked2 ="";
	  			  if($autorizacao=="Confirmado"){
	  			  	$checked2 ="selected='selected'";
	  			  }elseif($autorizacao=="Normal"){
	  			  	$checked ="selected='selected'";
	  			  }
				  
  
				  $plugin_directory = str_replace('functions/','ajax/',plugin_dir_url( __FILE__ ));
  
  
	  			  $html = "<select name='autorizacaoSelect$user_id' id='autorizacaoSelect$user_id' >";
	  		      $html .= "<option value='Normal' $checked>Normal</option>";
	  			  $html .= "<option value='Confirmado' $checked2>Confirmado</option>";
				  
				   $html .= "<option value='Revisar' >Revisar</option>";
				   
	  			  $html .= "</select>";
				
				
				
   				$verificaSolicitacao = get_user_meta( $user_id,'solicitacaoConfirmacao', true);
   				 if($verificaSolicitacao=='enviado' &&  $checked2 =='' ){
				     $html .= "<small>Aguardando solicitação</small>";
		         };      
		 
		 
					  
				 $html .=  "
					  
					 <div class='ct$user_id hide'> <textarea class='textMotivo$user_id' rel='$user_id' style='width:100px;height:120px'>Digite aqui o motivo da revisão</textarea><span id='enviarMotivo$user_id' rel='$user_id' >Enviar</span> </div>
				  
					        <script> 
				              jQuery('#autorizacaoSelect$user_id').on('change', function() {
			 var statusV=this.value ;
		     var idU='$user_id';
			 var baseUrl = '$plugin_directory';
	
		 if(statusV == 'Revisar'){
			 
			 jQuery('.ct$user_id').show();
			 
		 }else{
			 
			 alert('Salvando alteração..Aguarde');
		 
			 jQuery('.ct$user_id').hide();
								  jQuery.post(baseUrl+'editUserExtraOption.php', {id:''+idU+'' ,status:''+statusV+'' } ,
                 function(data) {
                       msg = data;
					   alert(msg);
                 });
		 };						   
	  });
	  
	  
	  
   jQuery('#enviarMotivo$user_id').click(function(){
	  
	  statusV =  jQuery('#autorizacaoSelect$user_id').val();
	  idU = jQuery(this).attr('rel');				
	  msgStatusV = jQuery('.textMotivo$user_id').val();
	   var baseUrl = '$plugin_directory';
	   
	   alert('Salvando alteração..Aguarde');
	   
  jQuery.post(baseUrl+'editUserExtraOption.php', {id:''+idU+'' ,status:''+statusV+'' , msgStatus: ''+msgStatusV+'' } ,
       function(data) {
             msg = data;
		     alert(msg);
    });
	   
	   
	 });		   
							   
					         </script>";
	  			  return $html;
			 
			  
			  
    		};
			
        }
		 
		//ADD CUSTOM COLLUM IN WP ADMIN USER-------------------------------
		 
		function after_logout() {
		    
   
            $blogid = intval(get_current_blog_id());  
        		if($blogid>1){  unset($_SESSION['carrinho'.$blogid]);   }else{   unset($_SESSION['carrinho']);  }; 
				
		}
		add_action('wp_logout', 'after_logout');
		
		
		
		
		
		
		
		function savePaymentOptions(){
			
			

           if( $_POST['submit']=="Salvar" || $_POST['submit']== "Salvar e Prosseguir" ){
               
               
               $emailPagseguro = trim($_POST['emailPagseguro']);
               $tokenPagseguro = trim($_POST['tokenPagseguro']);
               
			   
               $emailGerencianet = trim($_POST['emailGerencianet']);
               $tokenGerencianet= trim($_POST['tokenGerencianet']);
			   
			   
			   $emailRedecard = trim($_POST['emailRedecard']);
               $filicaoRedecard = trim($_POST['filicaoRedecard']);
               $filicaoRedecardGateway = trim($_POST['filicaoRedecardGateway']);
           
  
               add_option( 'emailPagseguro', $emailPagseguro, '', 'yes' ); 
               update_option( 'emailPagseguro',$emailPagseguro );
               add_option( 'tokenPagseguro', $tokenPagseguro, '', 'yes' ); 
               update_option( 'tokenPagseguro', $tokenPagseguro );
			   
			   
			   
			   
               add_option( 'emailGerencianet', $emailGerencianet, '', 'yes' ); 
               update_option( 'emailGerencianet',$emailGerencianet );
               add_option( 'tokenGerencianet', $tokenGerencianet, '', 'yes' ); 
               update_option( 'tokenGerencianet', $tokenGerencianet );
			   
			   
			   
               add_option( 'emailRedecard', $emailRedecard , '', 'yes' ); 
               update_option( 'emailRedecard',  $emailRedecard );
               add_option( 'filicaoRedecard', $filicaoRedecard, '', 'yes' ); 
               update_option('filicaoRedecard', $filicaoRedecard);
               
               add_option( 'filicaoRedecardGateway', $filicaoRedecardGateway, '', 'yes' ); 
               update_option('filicaoRedecardGateway', $filicaoRedecardGateway);
             
             
             
             
                      $depositoNomeCnpj = trim($_POST['depositoNomeCnpj']); 
                      
                      $depositoBanco1 = trim($_POST['depositoBanco1']); 
                      $depositoAgencia1 = trim($_POST['depositoAgencia1']);
                      $depositoConta1 = trim($_POST['depositoConta1']); 
                      
                      $depositoBanco2 = trim($_POST['depositoBanco2']); 
                      $depositoAgencia2 = trim($_POST['depositoAgencia2']); 
                      $depositoConta2 = trim($_POST['depositoConta2']); 
                      
                      $depositoMaisInfos = trim($_POST['depositoMaisInfos']);
                      
                      $enderecoRetirada = trim($_POST['enderecoRetirada']);
                      
                      $chaveCielo = trim($_POST['chaveCielo']);
                      $filiacaoCielo = trim($_POST['filiacaoCielo']);
                      
                      
                      $tipoParcelamentoCielo = trim($_POST['tipoParcelamentoCielo']);
                      $capturarAutomaticamenteCielo  = trim($_POST['capturarAutomaticamenteCielo']);
                      $indicadorAutorizacaoCielo = trim($_POST['indicadorAutorizacaoCielo']);
                      
                      
                      
                 
                             
                             
                  add_option('depositoNomeCnpj',$depositoNomeCnpj,'','yes'); 
                  update_option('depositoNomeCnpj',$depositoNomeCnpj);
                  
                  add_option('depositoBanco1',$depositoBanco1,'','yes'); 
                  update_option('depositoBanco1',$depositoBanco1);
                  
                  add_option('depositoConta1',$depositoConta1,'','yes'); 
                  update_option('depositoConta1',$depositoConta1);
         
                  add_option('depositoAgencia1',$depositoAgencia1,'','yes'); 
                  update_option('depositoAgencia1',$depositoAgencia1);
                 
                 
                  add_option('depositoBanco2',$depositoBanco2,'','yes'); 
                  update_option('depositoBanco2',$depositoBanco2);

                  add_option('depositoConta2',$depositoConta2,'','yes'); 
                  update_option('depositoConta2',$depositoConta2);

                  add_option('depositoAgencia2',$depositoAgencia2,'','yes'); 
                  update_option('depositoAgencia2',$depositoAgencia2);     
                      
                  add_option('depositoMaisInfos',$depositoMaisInfos,'','yes'); 
                  update_option('depositoMaisInfos',$depositoMaisInfos);  
                  
                  add_option('enderecoRetirada',$enderecoRetirada,'','yes'); 
                  update_option('enderecoRetirada',$enderecoRetirada);
                  
                  add_option('filiacaoCielo',$filiacaoCielo,'','yes'); 
                  update_option('filiacaoCielo',$filiacaoCielo); 
                  
                   add_option('chaveCielo',$chaveCielo,'','yes'); 
                    update_option('chaveCielo',$chaveCielo);
                  
                  add_option('tipoParcelamentoCielo',$tipoParcelamentoCielo,'','yes'); 
                    update_option('tipoParcelamentoCielo',$tipoParcelamentoCielo);
                    
                    add_option('capturarAutomaticamenteCielo',$capturarAutomaticamenteCielo,'','yes'); 
                      update_option('capturarAutomaticamenteCielo',$capturarAutomaticamenteCielo);
                      
                      add_option('indicadorAutorizacaoCielo',$indicadorAutorizacaoCielo,'','yes'); 
                        update_option('indicadorAutorizacaoCielo',$indicadorAutorizacaoCielo);
          
   
   
                           $ativaPagseguro = trim($_POST['ativaPagseguro']);
						   
						   $ativaGerencianet = trim($_POST['ativaGerencianet']);
						   
                            $ativaCielo = trim($_POST['ativaCielo']);
							$ativaAmex = trim($_POST['ativaAmex']);
                            $ativaDeposito = trim($_POST['ativaDeposito']);
                            $ativaRetirada = trim($_POST['ativaRetirada']);
							$ativaRetiradaParcial = trim($_POST['ativaRetiradaParcial']);
                            
                            $ativaPaypal = trim($_POST['ativaPaypal']); 
                            $ativaGoogleCk = trim($_POST['ativaGoogleCk']);
                            $emailPaypal = trim($_POST['emailPaypal']);
                            $currentCodePaypal  = trim($_POST['currentCodePaypal']); 
                            
                             $ativaMoip = trim($_POST['ativaMoip']);
                             $emailMoip = trim($_POST['emailMoip']);  
                             
                             $meuPinMoip  = trim($_POST['meuPinMoip']);  


$ativaBoleto = trim($_POST['ativaBoleto']); 
$boletoDesconto  = trim($_POST['boletoDesconto']); 
$boletoMsg = trim($_POST['boletoMsg']); 
							   
							   
$caixaCedenteNome  = trim($_POST['caixaCedenteNome']); 
$caixaCedenteCodigo= trim($_POST['caixaCedenteCodigo']); 
$caixaCedenteAgencia= trim($_POST['caixaCedenteAgencia']);  
$caixaCedenteDigito= trim($_POST['caixaCedenteDigito']);  
$caixaCedenteConta= trim($_POST['caixaCedenteConta']);  $caixaCedenteCNPJ= trim($_POST['caixaCedenteCNPJ']); 																  							 
						 
						 
						 
                             add_option('ativaPagseguro',$ativaPagseguro,'','yes'); 
                             update_option('ativaPagseguro',$ativaPagseguro);

           
		   
                             add_option('ativaGerencianet',$ativaGerencianet,'','yes'); 
                             update_option('ativaGerencianet',$ativaGerencianet);
		   
		   
		   
		                     add_option('ativaCielo',$ativaCielo,'','yes'); 
                             update_option('ativaCielo',$ativaCielo);

	
    							add_option('ativaAmex',$ativaAmex,'','yes'); 
    							update_option('ativaAmex',$ativaAmex);
	
	
                             add_option('ativaDeposito',$ativaDeposito,'','yes'); 
                             update_option('ativaDeposito',$ativaDeposito);

                             add_option('ativaRetirada',$ativaRetirada,'','yes'); 
                             update_option('ativaRetirada',$ativaRetirada);  
                             
                             add_option('ativaRetiradaParcial',$ativaRetiradaParcial,'','yes'); 
                             update_option('ativaRetiradaParcial',$ativaRetiradaParcial);  
							 
                            add_option('ativaMoip',$ativaMoip,'','yes'); 
                            update_option('ativaMoip',$ativaMoip);
                                  
                             
							 
								 
							 
							         add_option('ativaPaypal',$ativaPaypal,'','yes'); 
update_option('ativaPaypal',$ativaPaypal); 
                                       
                                        add_option('emailPaypal',$emailPaypal,'','yes'); 
 update_option('emailPaypal',$emailPaypal);
                                          
                                           add_option('currentCodePaypal',$currentCodePaypal,'','yes'); 
                                             update_option('currentCodePaypal',$currentCodePaypal);  
                                             
                                             
                                             add_option('emailMoip',$emailMoip,'','yes'); 
update_option('emailMoip',$emailMoip); 
                                               
                                               
                                             add_option('meuPinMoip',$meuPinMoip,'','yes'); 
update_option('meuPinMoip',$meuPinMoip);
               
			   
                                             add_option('tivaBoleto',$ativaBoleto,'','yes'); 
update_option('ativaBoleto',$ativaBoleto);

add_option('boletoDesconto',$boletoDesconto ,'','yes'); 
update_option('boletoDesconto',$boletoDesconto);

                                             add_option('boletoMsg',$boletoMsg,'','yes'); 
update_option('boletoMsg',$boletoMsg);
			   
                                             add_option('caixaCedenteNome',$caixaCedenteNome,'','yes'); 
update_option('caixaCedenteNome',$caixaCedenteNome);	

                                             add_option('caixaCedenteCodigo',$caixaCedenteCodigo,'','yes'); 
update_option('caixaCedenteCodigo',$caixaCedenteCodigo);	

                                             add_option('caixaCedenteAgencia',$caixaCedenteAgencia,'','yes'); 
update_option('caixaCedenteAgencia',$caixaCedenteAgencia);		   
											   

                                             add_option('caixaCedenteConta',$caixaCedenteConta,'','yes'); 
update_option('caixaCedenteConta',$caixaCedenteConta);	

                                             add_option('caixaCedenteDigito',$caixaCedenteDigito,'','yes'); 
update_option('caixaCedenteDigito',$caixaCedenteDigito);	
	
	
                                             add_option('caixaCedenteCNPJ',$caixaCedenteCNPJ,'','yes'); 
update_option('caixaCedenteCNPJ',$caixaCedenteCNPJ);	
	
	
	

 $categories  = "";
if(!empty($_POST['post_category'])) {
 foreach($_POST['post_category'] as $check) {
          $categories .=",$check"; 
 }

};
add_option('arrCatRemoveDesconto',$categories,'','yes'); 
update_option('arrCatRemoveDesconto',$categories);




$ativaCybersource = trim($_POST['ativaCybersource']); 
$ativaCybersourceTeste = trim($_POST['ativaCybersourceTeste']); 

$segmentoEmpresaCieloCYB = trim($_POST['segmentoEmpresaCieloCYB']); 
$decisaoAltoRiscoCieloCYB = trim($_POST['decisaoAltoRiscoCieloCYB']); 
$decisaoMedioRiscoCieloCYB = trim($_POST['decisaoMedioRiscoCieloCYB']); 
$decisaoBaixoRiscoCieloCYB = trim($_POST['decisaoBaixoRiscoCieloCYB']); 
$decisaoErroDadosCieloCYB = trim($_POST['decisaoErroDadosCieloCYB']); 
$decisaoErroIndisponivelCieloCYB = trim($_POST['decisaoErroIndisponivelCieloCYB']); 
$valorMinimoConsultaCieloCYB = trim($_POST['valorMinimoConsultaCieloCYB']); 	
    
                                              add_option('ativaCybersource',$ativaCybersource,'','yes'); 
update_option('ativaCybersource',$ativaCybersource);		

                                              add_option('ativaCybersourceTeste',$ativaCybersourceTeste,'','yes'); 
update_option('ativaCybersourceTeste',$ativaCybersourceTeste);

                                             add_option('segmentoEmpresaCieloCYB',$segmentoEmpresaCieloCYB,'','yes'); 
update_option('segmentoEmpresaCieloCYB',$segmentoEmpresaCieloCYB);

                                             add_option('decisaoAltoRiscoCieloCYB',$decisaoAltoRiscoCieloCYB,'','yes'); 
update_option('decisaoAltoRiscoCieloCYB',$decisaoAltoRiscoCieloCYB);
                                              add_option('decisaoMedioRiscoCieloCYB',$decisaoMedioRiscoCieloCYB,'','yes'); 
update_option('decisaoMedioRiscoCieloCYB',$decisaoMedioRiscoCieloCYB);
                                             add_option('decisaoBaixoRiscoCieloCYB',$decisaoBaixoRiscoCieloCYB,'','yes'); 
update_option('decisaoBaixoRiscoCieloCYB',$decisaoBaixoRiscoCieloCYB);

                                             add_option('decisaoErroDadosCieloCYB',$decisaoErroDadosCieloCYB,'','yes'); 
update_option('decisaoErroDadosCieloCYB',$decisaoErroDadosCieloCYB);

                                             add_option('decisaoErroIndisponivelCieloCYB',$decisaoErroIndisponivelCieloCYB,'','yes'); 
update_option('decisaoErroIndisponivelCieloCYB',$decisaoErroIndisponivelCieloCYB);
                                             add_option('valorMinimoConsultaCieloCYB',$valorMinimoConsultaCieloCYB,'','yes'); 
update_option('valorMinimoConsultaCieloCYB',$valorMinimoConsultaCieloCYB);	
                                                                                 
			 
};

};






function saveFreteOptions(){
	 
     if( $_POST['submit']=="Salvar"   || $_POST['submit']== "Salvar e Prosseguir"  ){
	   
	
	  $categories  = "";
	  if(!empty($_POST['post_category'])) {
		 foreach($_POST['post_category'] as $check) {
	              $categories .=",$check"; 
	     }

	  };
        add_option('arrCatRemovePromoFreteWPSHOP',$categories,'','yes'); 
        update_option('arrCatRemovePromoFreteWPSHOP',$categories);
	  
	  
	  
          $tipoFrete = trim($_POST['tipoFrete']);
          add_option('tipoFrete',$tipoFrete,'','yes'); 
          update_option('tipoFrete',$tipoFrete);
	  
         
		
           $retirarLoja= trim($_POST['retirarLoja']);
			if($retirarLoja=='retirarLoja'){
            	add_option('retirarLoja',$retirarLoja,'','yes'); 
            	update_option('retirarLoja',$retirarLoja);
		    }else{
	            add_option('retirarLoja','N','','yes'); 
	            update_option('retirarLoja','N');
		    }
				
			
          $cepOrigemCorreios = trim($_POST['cepOrigemCorreios']);
          add_option('cepOrigemCorreios',$cepOrigemCorreios,'','yes'); 
          update_option('cepOrigemCorreios',$cepOrigemCorreios);
             
             
           $alturaEmbalagemCorreios  = trim($_POST['alturaEmbalagemCorreios']);
           add_option('alturaEmbalagemCorreios',$alturaEmbalagemCorreios ,'','yes'); 
           update_option('alturaEmbalagemCorreios',$alturaEmbalagemCorreios );
                
           $larguraEmbalagemCorreios = trim($_POST['larguraEmbalagemCorreios']);
           add_option('larguraEmbalagemCorreios',$larguraEmbalagemCorreios,'','yes'); 
           update_option('larguraEmbalagemCorreios',$larguraEmbalagemCorreios);
                   
           $comprimentoEmbalagemCorreios = trim($_POST['comprimentoEmbalagemCorreios']);
           add_option('comprimentoEmbalagemCorreios',$comprimentoEmbalagemCorreios,'','yes'); 
           update_option('comprimentoEmbalagemCorreios',$comprimentoEmbalagemCorreios);
           

            
             $valorFreteFixo  = trim($_POST['valorFreteFixo']);   
             add_option('valorFreteFixo',$valorFreteFixo,'','yes'); 
             update_option('valorFreteFixo',$valorFreteFixo);  
             
             
             
             $valorFretePeso1   = trim($_POST['valorFretePeso1']);  
                add_option('valorFretePeso1',$valorFretePeso1,'','yes'); 
                update_option('valorFretePeso1',$valorFretePeso1);
             $valorFretePeso2   = trim($_POST['valorFretePeso2']);  
                add_option('valorFretePeso2',$valorFretePeso2,'','yes'); 
                update_option('valorFretePeso2',$valorFretePeso2);
             $valorFretePeso3   = trim($_POST['valorFretePeso3']);  
                add_option('valorFretePeso3',$valorFretePeso3,'','yes'); 
                update_option('valorFretePeso3',$valorFretePeso3);
             $valorFretePeso4   = trim($_POST['valorFretePeso4']);  
                add_option('valorFretePeso4',$valorFretePeso4,'','yes'); 
                update_option('valorFretePeso4',$valorFretePeso4);
             $valorFretePeso5   = trim($_POST['valorFretePeso5']);    
                add_option('valorFretePeso5',$valorFretePeso5,'','yes'); 
                update_option('valorFretePeso5',$valorFretePeso5);
                $valorFretePeso6   = trim($_POST['valorFretePeso6']);    
                      add_option('valorFretePeso6',$valorFretePeso6,'','yes'); 
                      update_option('valorFretePeso6',$valorFretePeso6); 
             
             
             $valorFreteValor1  = trim($_POST['valorFreteValor1']); 
                add_option('valorFreteValor1',$valorFreteValor1,'','yes'); 
                update_option('valorFreteValor1o',$valorFreteValor1);
             $valorFreteValor2  = trim($_POST['valorFreteValor2']); 
                add_option('valorFreteValor2',$valorFreteValor2,'','yes'); 
                update_option('valorFreteValor2',$valorFreteValor2);
             $valorFreteValor3  = trim($_POST['valorFreteValor3']);
                add_option('valorFreteValor3',$valorFreteValor3,'','yes'); 
                update_option('valorFreteValor3',$valorFreteValor3); 
             $valorFreteValor4  = trim($_POST['valorFreteValor4']);
                add_option('valorFreteValor4',$valorFreteValor4,'','yes'); 
                update_option('valorFreteValor4',$valorFreteValor4); 
             $valorFreteValor5  = trim($_POST['valorFreteValor5']);  
                add_option('valorFreteValor5',$valorFreteValor5,'','yes'); 
                update_option('valorFreteValor5',$valorFreteValor5); 
              
                 $valorFreteValor6  = trim($_POST['valorFreteValor6']);  
                      add_option('valorFreteValor6',$valorFreteValor6,'','yes'); 
                      update_option('valorFreteValor6',$valorFreteValor6);
                      
                        
                $cidadesFreteGratis  = trim($_POST['cidadesFreteGratis']);  
                      add_option('cidadesFreteGratis',$cidadesFreteGratis,'','yes'); 
                      update_option('cidadesFreteGratis',$cidadesFreteGratis); 
                 
                
                      $valorFreteGratis  = trim($_POST['valorFreteGratis']);  
                               add_option('valorFreteGratis',$valorFreteGratis,'','yes'); 
                               update_option('valorFreteGratis',$valorFreteGratis);              
$ctCorreios  = trim($_POST['ctCorreios']);  
add_option('ctCorreios',$ctCorreios,'','yes'); 
update_option('ctCorreios',$ctCorreios);								 

$ctCorreiosReg  = trim($_POST['ctCorreiosReg']);  
add_option('ctCorreiosReg',$ctCorreiosReg,'','yes'); 
update_option('ctCorreiosReg',$ctCorreiosReg);


$ctCorreiosAno  = trim($_POST['ctCorreiosAno']);  
add_option('ctCorreiosAno',$ctCorreiosAno,'','yes'); 
update_option('ctCorreiosAno',$ctCorreiosAno);


$ctCorreiosCod  = trim($_POST['ctCorreiosCod']);  
add_option('ctCorreiosCod',$ctCorreiosCod,'','yes'); 
update_option('ctCorreiosCod',$ctCorreiosCod);

$ctCorreiosPass  = trim($_POST['ctCorreiosPass']);  
add_option('ctCorreiosPass',$ctCorreiosPass,'','yes'); 
update_option('ctCorreiosPass',$ctCorreiosPass); 
								 

     };
	
};





function get_steps_cfg(){

$arrayOpcoes = array();

$arrayOpcoes[1] = array('emailAdminWPSHOP','email' , 'Confirme  o email do administrador . Este email irá receber informações sobre pedidos e dados de sua loja. Certique-se de informar um email válido.' , "Confirme o email do administrador" );

$arrayOpcoes[2] = array('parcelaMinima','number' , 'É o valor mínimo da compra para possibilitar o parcelamento. ' , "Confirme o valor da parcela mínima. Exemplo : R$10,00 " );

$arrayOpcoes[3] = array('totalParcela','number' , 'É o total de parcelas que você deseja habilitar em sua loja. Exemplo : 10', "Confirme o total máximo de parcelas"   );

 
 	$arrayOpcoes[4] = array('configPagto','' , 'Tipos de pagamento disponível', "Escolha as formas de pagamento que  deseja disponibilizar."   );
	
	
		$arrayOpcoes[5] = array('configFrete','' , 'Tipos de frete e entrega', "Escolha as formas de entrega que desejar disponibilizar."   );
		
		
		return $arrayOpcoes;
  
	};
	
	

	 
		
?>