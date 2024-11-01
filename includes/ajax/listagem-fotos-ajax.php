<?php 
              require("../../../../../wp-load.php");

					
					$postId = addslashes($_POST['ID']);
					
					
					//$postId = $post->ID;
					
					if($postId  >  0 ){
						
						
						
						$widthImgListagem =  get_option('widthImgListagem');  
						$heightImgListagem = get_option('heightImgListagem');  

						
						if($widthImgListagem==''){
							$widthImgListagem = "265";
						}
						
						if($heightImgListagem==''){
							$heightImgListagem = "265";
						}
				 
     					$args = array(
         				'post_type' => 'attachment',
         			    'numberposts' => -1,
         				'post_status' => null,
         				'orderby'         => 'menu_order',
         			    'order'           => 'ASC',
         			    'post_parent' => $postId);



     				$attachments = get_posts($args);
     				$count  = 0;

     				$totalGaleria = 0;
                       $contag =1;
     					if ($attachments) {
     						foreach ($attachments as $attachment) {
     							//echo apply_filters('the_title', $attachment->post_title);
     							   $image_id = $attachment->ID;  
     							   $legenda = $attachment->post_excerpt;  
     							   $image_url = wp_get_attachment_image_src($image_id,'large');  
     							   $image_url = verifyURL($image_url[0]);
     							   $totalGaleria  +=1;

								 if(get_post_thumbnail_id($postId) !=  $image_id){

     					?>
                    <img width="<?php echo $widthImgListagem; ?>" alt="<?php the_title(); ?>" src="<?php echo verifyURL(bloginfo('template_url')); ?>/timthumb.php?src=<?php echo $image_url; ?>&w=<?php echo $widthImgListagem; ?>&h=<?php echo $heightImgListagem; ?>&zc=1"   id='thumbSlideItem<?php echo $postId; ?><?php echo $contag; ?>' class='thumbSlideItem thumbSlideItem<?php echo $postId; ?>  hide'  rev='' />

                        <?php   };
     						$count +=1;
                             $contag +=1;
     				    			}
     							}

                             // wp_reset_query();
                      }; 
					  
					  ?>