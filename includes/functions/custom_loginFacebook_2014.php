<?php
 
function fb_head(){
 
    $facebookAPPID  =  get_option('facebookAPPID'); 
    $facebookSecret  =  get_option('facebookSecret');
 
  
    ########## app ID and app SECRET (Replace with yours) #############
    $appId =  $facebookAPPID; //Facebook App ID
    $appSecret =  $facebookSecret; // Facebook App Secret
    $return_url = get_bloginfo('url');  //path to script folder
    $fbPermissions = 'user_friends,email'; // more permissions : https://developers.facebook.com/docs/authentication/permissions/
 
    
   if( is_user_logged_in()) return;


 };
 
 
  add_action( 'wp_head', 'fb_head' );
 
 
 
  function fb_footer(){
      
 
      $facebookAPPID  =  get_option('facebookAPPID'); 
      $facebookSecret  =  get_option('facebookSecret');
 
  
      ########## app ID and app SECRET (Replace with yours) #############
      $appId =  $facebookAPPID; //Facebook App ID
      $appSecret =  $facebookSecret; // Facebook App Secret
    
	  $return_url = get_bloginfo('url');  //path to script folder
	  $fbPermissions = 'email'; // more  
 
	   
  ?>
<div id="fb-root"></div>
<script type="text/javascript">
 
 var baseUrl = ""+jQuery('meta[name=metaurl]').attr("content");
   
window.fbAsyncInit = function() {
	FB.init({
		appId: '<?php echo  $appId; ?>',
		cookie: true,
		xfbml: true,
		channelUrl: baseUrl+'/includes/ajax-facebook/channel.php',
		oauth: true
		});
	};
	
(function() {
	var e = document.createElement('script');
	e.async = true;e.src = document.location.protocol +'//connect.facebook.net/pt_BR/all.js';
	document.getElementById('fb-root').appendChild(e);}());

function CallAfterLogin(){
	FB.login(function(response) {		

		
		if (response.status === "connected") 
		{
			LodingAnimate(); //Animate login
			FB.api('/me', {fields:'email,name,first_name,last_name'} ,function(data) {
		 
				//alert(JSON.stringify(data));
	 
			  if(data.email == null)
			  {
					//Facbeook user email is empty, you can check something like this.
					alert("Não conseguimos localizar seu email."); 
					ResetAnimate();

			  }else{
				
				  // custom titulo post ----
				  //titulo = jQuery('#tituloProduto').val();
				  //data.tituloProduto =  titulo;
				  //custom titulo post ----
				 AjaxResponse(data);
			  }
			  
		  });
		 }
	},
	{scope:'<?php echo $fbPermissions; ?>' , auth_type: 'rerequest' });
}

//functions
function AjaxResponse(data){
 
	  arr = JSON.stringify(data);

	 <?php  $rand = rand();  ?>
	 urlF = baseUrl+"/includes/ajax-facebook/process_facebook.php?che=<?php echo $rand; ?>";
	 
	 // alert(urlF);
	 
      jQuery.post(urlF, {arru:arr } ,
                function(data) { 
					 alert(data);
					arrData = data.split('***');
					if(arrData[0]=='1'){
						window.location = arrData[1];
				    }else{
				    	//alert(data);
				    }
      });
}





function getCurrentUserInfo(userInfo) {
     FB.api('/me', function(userInfo) {
       alert(userInfo.name + ': ' + userInfo.email);
     });
   }
	 
	 
	 
//Show loading Image
function LodingAnimate() 
{
	jQuery(".loginButton").hide(); //hide login button once user authorize the application
	
 
	jQuery(".msgFacebook").html('<img src="'+baseUrl+'/includes/ajax-facebook/img/loading.gif"  width="20"/> Iniciando Conexão...'); //show loading image while we process user
 
	
}

//Reset User button
function ResetAnimate() 
{
	//jQuery(".loginButton").show(); //Show login button 
	 //jQuery(".msgFacebook").html(''); //reset element html
}

</script>
  <?php
  }
  add_action( 'wp_footer', 'fb_footer' );

 ?>