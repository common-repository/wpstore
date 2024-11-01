<?php
 //FACEID:125125670985108
 //SECRET:f6f83da47bfa5b8662682dce314f675b

         function stringSubistitui($sub){
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





function fb_head(){
    
    $facebookAPPID  =  get_option('facebookAPPID'); 
    $facebookSecret  =  get_option('facebookSecret');
    
  if( is_user_logged_in()) return;
  ?>
          
  
  
  
  
  
  
     <script type="text/javascript"> 

      window.fbAsyncInit = function(){
      FB.init({appId:'<?php echo $facebookAPPID; ?>', status:true, cookie:true, xfbml:true, oauth:true});
      };   

      </script>   

      <div id="fb-root"></div>   

      <script type="text/javascript">
      (function() {
      var e = document.createElement('script');
      e.type = 'text/javascript';
      e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
      e.async = true;
      document.getElementById('fb-root').appendChild(e);
      }());
      </script>


       <script type="text/javascript">    
       FB.Event.subscribe('auth.authResponseChange', function(response) {
        // Here we specify what we do with the response anytime this event occurs. 
        if (response.status === 'connected') {
         } else if (response.status === 'not_authorized') {
          } else {   
         }
       });   
       };



      // Load the SDK asynchronously
      (function(d){
       var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement('script'); js.id = id; js.async = true;
       js.src = "//connect.facebook.net/en_US/all.js";
       ref.parentNode.insertBefore(js, ref);
      }(document));




    </script>
    
    
    
    
        <?php /*   
        <script type="text/javascript">
  window.fbAsyncInit = function(){
  FB.init({appId:'<?php echo $facebookAPPID; ?>', status:true, cookie:true, xfbml:true, oauth:true});
  };
  </script>
  <div id="fb-root"></div>
  <script type="text/javascript">
  (function() {
  var e = document.createElement('script');
  e.type = 'text/javascript';
  e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
  e.async = true;
  document.getElementById('fb-root').appendChild(e);
  }());
  </script> 
  
              */ ?>   
              
              
              
<?php };  


  //add_action( 'wp_head', 'fb_head' );
 add_action( 'wp_footer', 'fb_head' );
 
 /*
  function mytheme_enqueue_scripts(){
  	wp_enqueue_script( 'jquery' );
  }
  add_action( 'wp_enqueue_scripts', 'mytheme_enqueue_scripts');
 */
 
 
 
  function fb_footer(){
      
  if( is_user_logged_in()):
  	echo "<script type='text/javascript'> jQuery('.facebook_connect').hide(); </script>";
  return;
  endif;
  
   /*
  ?>
  <script type="text/javascript">
  jQuery('.facebook_connect').click(function(){
  FB.login(function(FB_response){
  if( FB_response.status === 'connected' ){
  	fb_intialize(FB_response);
  }
  },
  {scope: 'email'});
  });

  function fb_intialize(FB_response){
  	FB.api( '/me', 'GET', 
  		{'fields':'id,email,username,verified,name'},
  		function(FB_userdata){
  			jQuery.ajax({
  				type: 'POST',
  				url: 'AJAXURL',
  				data: {"action": "fb_intialize", "FB_userdata": FB_userdata, "FB_response": FB_response},
  				success: function(user){
  				     
  					if( user.error ){
  						alert( user.error );
  					}else if( user.loggedin ){
  						window.location.reload();
  					}
  					window.location.reload();
  				}
  			});
  		}
  	);
  };
  </script>
  <?php   
       */ 
       
       ?>
            
       
       
            <script type="text/javascript">    
         
          function fb_intialize(FB_response){
           	FB.api( '/me', 'GET', 
           		{'fields':'id,email,username,verified,name,birthday,location,gender'},
           		function(FB_userdata){
           			jQuery.ajax({
           				type: 'POST',
           				url: 'AJAXURL',
           				data: {"action": "fb_intialize", "FB_userdata": FB_userdata, "FB_response": FB_response},
           				success: function(user){
           					if( user.error ){
           						alert( user.error );
           					}else if( user.loggedin ){
           						window.location.reload();
           					}
           					window.location.reload();
           				}
           			});
           		}
           	);
           }; 



              function showBigLoad(){
                     var txt  = "<div id='janela'><div class='popup'><div class='loading'><span></span></div></div></div>";
                     jQuery(txt).insertAfter('body');
                     jQuery('#janela').fadeIn();
                };

                  function hideBigLoad(){
                        jQuery('#janela').fadeOut();
                        jQuery('#janela').remove();
                 };


              <?php       $pagePerfil= get_idPaginaPerfil();       ?>

								 jQuery('.facebook_connect2').click(function(){  alert('aaa');
                    FB.login(function(FB_response){
                        if( FB_response.status === 'connected' ){
             	             fb_intialize(FB_response); 
             	             showBigLoad();
             	              setTimeout(function(){ window.location = '<?php echo get_permalink($pagePerfil); ?>'; },5000);  
                        }
                    },
                    {scope: 'email, user_birthday,  user_location '}); 
             });
      

            
         </script>
         
         
       <?php
  
  }    
  
  
  add_action( 'wp_footer', 'fb_footer' );



 
 
 
 
  function wp_ajax_fb_intialize(){
  
  
        @error_reporting( 0 ); // Don't break the JSON result
        header( 'Content-type: application/json' );

        if( !isset( $_REQUEST['FB_response'] ) || !isset( $_REQUEST['FB_userdata'] ))
        die( json_encode( array( 'error' => 'Authonication required.' )));

        $FB_response = $_REQUEST['FB_response'];
        $FB_userdata = $_REQUEST['FB_userdata']; 
                 
           
                 
        $FB_userid = (int) $FB_userdata['id'];     
        
        
        
          $cidadeEstado = $FB_userdata['location']['name'];   
          $arrCE = explode(',', $cidadeEstado); 
          $cidade =$arrCE[0];
          $estado =$arrCE[1];
          $pais =$arrCE[2];  
          
          $user_email = $FB_userdata['name']; 
          $display_name = $FB_userdata['email']; 
          
          $sexo =   $FB_userdata['gender'];  
          if( strtolower($sexo) == "male"){  $sexo = "Masculino"; }else{  $sexo = "Feminino";  }; 
          
          $nascimento =   $FB_userdata['birthday']; 
          $arrNasc = explode('/',$nascimento);
          $nascimento =  $arrNasc[1]."/".$arrNasc[0]."/".$arrNasc[2];
           
        
        if( !$FB_userid )
        die( json_encode( array( 'error' => 'Please connect your facebook account.' )));

        global $wpdb;
        $user_ID = $wpdb->get_var( "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '_fbid' AND meta_value = '$FB_userid'" );

        if( !$user_ID ){
        $user_email = $FB_userdata['email'];
        $user_ID = $wpdb->get_var( "SELECT ID FROM $wpdb->users WHERE user_email = '$user_email'" );

        if( !$user_ID ){
			
        if ( !get_option( 'users_can_register' ))
        die( json_encode( array( 'error' => 'Registration is not open at this time. Please come back later..' )));

        extract( $FB_userdata ); 
        
               
               /*
               Array ( [id] => 710557019 [email] => zezaun@hotmail.com [username] => jmorettoni [verified] => true [name] => José Morettoni [birthday] => 11/02/1985 [location] => Array ( [id] => 111957382157401 [name] => Niterói, Rio de Janeiro, Brazil ) )
               SEUS DADOS
              */

        $display_name = $name;
        $user_login = $username;   
         
        
	    
        if( empty( $verified ) || !$verified )
        die( json_encode( array( 'error' => 'Your facebook account is not verified. You hae to verify your account before proceed login or registering on this site.' )));

        $user_email = $email;
        if ( empty( $user_email ))
        die( json_encode( array( 'error' => 'Please re-connect your facebook account as we couldnt find your email address..' )));

        if( empty( $name ))
        die( json_encode( array( 'error' => 'empty_name', 'We didnt find your name. Please complete your facebook account before proceeding..' )));

        if( empty( $user_login ))
        $user_login = sanitize_title_with_dashes( sanitize_user( $display_name, true ));

        if ( username_exists( $user_login ))
        $user_login = $user_login. time();

        $user_pass = wp_generate_password( 12, false );
        $userdata = compact( 'user_login', 'user_email', 'user_pass', 'display_name' );

        $user_ID = wp_insert_user( $userdata );  
        
        if ( is_wp_error( $user_ID ))
              die( json_encode( array( 'error' => $user_ID->get_error_message())));
            
        } else{
              update_user_meta( $user_ID, '_fbid', (int) $FB_userdata['id'] );   
        }
		
		
		
		
	 //ENVIAR EMAIL BOAS VINDAS ------------------------------------
	 
	   if(trim($user_pass)!='' && $user_pass !=undefined && $user_pass !=null){
	 
        $idLogin = get_idPaginaLogin();
        $pageLogin = get_permalink($idLogin);
       
	 $emailRegistroTexto= get_option('emailRegistroTextoWPSHOP'); 


   
  $akEmail =  wp_generate_password();
  update_user_meta($user_id,'akEmail', $akEmail);
	 
	 
      
         $mensagemEmail = "
             <h1>Olá $display_name,  </h1> 
             <p>Seja Bem vindo ao <strong> ".get_bloginfo('name')." </strong> ! Obrigado por acessar e se inscrever em nosso site.</p>
			 
			  <p> $emailRegistroTexto</p> 
			  
             <p>Para acessar sua conta  siga <a href='".$pageLogin."?akEmail=$akEmail' >".$pageLogin."?akEmail=$akEmail</a> . </p> 
             <p>Você pode continuar a fazer login diretamente pelo botão do FACEBOOK, ou através de sua conta criada em nosso site.</p>
			 <p><strong>Dados para acesso:</strong></p>
             <p>usuario : $user_email <br/>  senha : $user_pass<br/>  </p>
			 <p>Após login, você também poderá modificar sua senha  de acesso em nosso sistema.</p> 
			";
           
			
           
             $mensagemEmail2 = "
                   <h1>Olá Administrador ,  </h1> 
                   <p>Novo usuário cadastrado no <strong>".get_bloginfo('name')."</strong>.</p>
                    <p>usuario : $user_email <br/>  Nome : $nome <br/>  </p>
                   <p>Para administrar faça o login em  <a href='".$pageLogin."' >".$pageLogin."</a> . </p> 
                   ";
                 
       
           $assuntoEmail = "Registro de Usuário : Bem Vindo ao ".get_bloginfo('name')."";
	  
           $assuntoEmail2 = "Registro de Usuário : Nova conta criada no ".get_bloginfo('name')."";
	 
	  
	       send_email($display_name,$user_email,$assuntoEmail,$mensagemEmail);
		 
		   $emailAdmin =  get_option('smtpUserWPSHOP');   
	       send_email('ADMIN',$emailAdmin,$assuntoEmail2,$mensagemEmail2);
          };
		 // FINAL ENVIAR EMAIL BOAS VINDAS ------------------------------------
	 
	  
	  
        };
 
 
 
           wp_set_auth_cookie( $user_ID, false, false );   
    
           update_user_meta( $user_ID,'userCidade', $cidade);   
           update_user_meta( $user_ID,'userEstado', $estado);  
    	   update_user_meta( $user_ID,'userSexo', $sexo); 
    	   
    	   update_user_meta( $user_ID,'userNascimento', $nascimento); 
    	   update_user_meta( $user_ID,'userPais', $pais);  
		   
		   
		
  $infoNome = explode(" ",$FB_userdata['name'] );
  if($infoNome[0] !=''){
  update_user_meta( $user_ID,'first_name',$infoNome[0]);   
}  
	
    if($infoNome[1] !=''){
    update_user_meta( $user_ID ,'last_name',$infoNome[1]);     
  	}
	
    	   
    	   
    	         /*
    	          if($cidade !="" && $cidade !="undefined"){
                      update_user_meta($user_ID,'userCidade',$cidade);
                   };
                   if( $estado !="" &&  $estado!="undefined"){
                      update_user_meta($user_ID,'userEstado',  $estado);
                   }; 
                    
                      if($sexo !="" && $sexo  !="undefined"){
                         update_user_meta($user_ID,'userSexo', $sexo);
                      };  
                      
                      if($nascimento!="" && $nascimento !="undefined"){
                            update_user_meta($user_ID,'userNascimento', $nascimento);
                         };
                         
                            if($pais!="" && $pais !="undefined"){
                                     update_user_meta($user_ID,'userPais', $pais);
                                  };  
                          */
                     
    	      
    	     /*   */    
			 
			 
			
           
           if(function_exists('verificaNomeLista')){
    	     $estadoID = verificaNomeLista(strtoupper(stringSubistitui($estado)));
           if(intval($estadoID)<=0){
              addLista(strtoupper(stringSubistitui($estado)));
              $estadoID = verificaNomeLista(strtoupper(stringSubistitui($estado)));
           };  
           };
           if(function_exists('verificaNomeLista')){ 
           $cidadeID = verificaNomeLista(strtoupper(stringSubistitui($estado.'-'.$cidade)));
           if(intval($cidadeID)<=0){
                addLista(strtoupper(stringSubistitui($estado.'-'.$cidade)));
                $cidadeID = verificaNomeLista(strtoupper(stringSubistitui($estado.'-'.$cidade)));
            };
                  
           };
           if(function_exists('verificaNomeLista')){
           
            $sexoID = verificaNomeLista(strtoupper(stringSubistitui($sexo)));
            if(intval($sexoID)<=0){
                 addLista(strtoupper(stringSubistitui($sexo)));
                 $sexoID = verificaNomeLista(strtoupper(stringSubistitui($sexo)));
            };
                
            };
            
            
            if(function_exists('verificaNomeLista')){    
        
            if($display_name!=""){
                     $arrList  = "1***". $sexoID."***".$estadoID."***". $cidadeID;  
                    registerNewsletterMail($display_name ,$user_email,$arrList);
            };
            
           };  
            
            
            
            
            
  wp_redirect(get_bloginfo('url'));
  die( json_encode( array( 'loggedin' => true )));
  }
  




  function chamaLoginFace(){
    if(isset($_REQUEST['FB_response'])){
    wp_ajax_fb_intialize();
    }
  };
  
  add_action( 'after_setup_theme', 'chamaLoginFace');

 
  add_filter( 'show_admin_bar', '__return_false' ); 
 
  
  
  /////////////////////////////////////////////////////////////
 

  ?>