<?php
if( !function_exists('wpex_tmbigdate')){
	function wpex_tmbigdate($show_thumb=false,$link_lb=false){
		global $posttype,$show_media;
		if($posttype == 'wp-timeline'){
			$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
			$wpex_date = get_post_meta( get_the_ID(), 'wpex_date', true );
			$sb_dt = explode(" ",$wpex_date);
			if(isset($sb_dt[1])){
				$wpex_first = $sb_dt[0];
				$wpex_last = $sb_dt[1];
				if(isset($sb_dt[2])){
					$wpex_last = $sb_dt[1].' '.$sb_dt[2];
				}
			}else{
				$sb_dt = explode("/",$wpex_date);
				if(isset($sb_dt[1])){
					$wpex_first = $sb_dt[0];
					$wpex_last = $sb_dt[1];
					if(isset($sb_dt[2])){
						$wpex_last = $sb_dt[1].'/'.$sb_dt[2];
					}
				}else{
					$sb_dt = explode(",",$wpex_date);
					if(isset($sb_dt[1])){
						$wpex_first = $sb_dt[0];
						$wpex_last = $sb_dt[1];
						if(isset($sb_dt[2])){
							$wpex_last = $sb_dt[1].','.$sb_dt[2];
						}
					}else{
						$wpex_first = $wpex_date;
						$wpex_last ='';
					}
				}
			}
		}else{
			$wpex_sublabel = get_the_date('l');
			$wpex_first = get_the_date('d');
			$wpex_last = get_the_date( 'F' ).','.get_the_date( 'Y' );
		}
		if($wpex_sublabel==''){ $wpex_sublabel = "&nbsp;";}
		if($wpex_last==''){ $wpex_last = "&nbsp;";}
		$html ='
		<div class="wpex-content-left">
            <div class="wpex-leftdate">
                <span class="tlday">'.$wpex_first.'</span>
                <div>
                    <span>'.$wpex_sublabel.'</span>
                    <span>'.$wpex_last.'</span>
                </div>
            </div>';
			if(isset($link_lb) && $link_lb!=''){
				$url_lb = $link_lb;
			}else{
				$url_lb = get_permalink(get_the_ID());
			}
			if( $show_thumb == true){
				if($show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
					$html .= wptl_audio_video_iframe();
				}elseif(has_post_thumbnail(get_the_ID())){
					$html .='
					<a href="'.$url_lb.'" title="'.the_title_attribute('echo=0').'">
						<span class="info-img">'.get_the_post_thumbnail(get_the_ID(),'wptl-320x220').'</span>
					</a>';
				}
            }
			$html .='
        </div>
		';
		$html = apply_filters( 'wpex_tmbigdate', $html, $show_thumb );
		echo $html;
	}
}
if( !function_exists('wpex_tmfulldate')){
	function wpex_tmfulldate(){
		global $posttype;
		if($posttype == 'wp-timeline'){
			$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
			$wpex_date = get_post_meta( get_the_ID(), 'wpex_date', true );
		}else{
			$wpex_sublabel = get_the_date('l');
			$wpex_date = get_the_date( get_option( 'date_format' ) );
		}
		$html ='
		<span class="info-h">
			'.$wpex_sublabel.'
		</span>
		<span>
			'.$wpex_date.'
		</span>';
		$html = apply_filters( 'wpex_tmfulldate', $html );
		echo $html;
	}
}
// Html cat filter
if( !function_exists('wpex_filterby_cat')){
	function wpex_filterby_cat($tax,$cat,$ID){
		global $posttype;
		if($posttype == 'wp-timeline'){
			$tax = 'wpex_category';
		}elseif($posttype == 'post'){ $tax = 'category';}
		if($tax==''){ return;}
		$args = array(
			'hide_empty'        => true, 
		);
		if($cat!=''){
			$cat = explode(",", $cat);
			if(is_numeric($cat[0])){
				$args['include'] = $cat;
			}else{
				$args['slug'] = $tax;
			}
		}
		$terms = get_terms($tax, $args);
		$html = '';
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ 
			$html .='
			<ul class="wpex-taxonomy-filter">
				<li><a class="active" href="javascript:;" data-id="'.$ID.'" data-tax="'.$tax.'" data-value="">'. esc_html__('ALL','wp-timeline') .'</a></li>';
				foreach ( $terms as $term ) {
					$html .= '<li><a href="javascript:;" data-id="'.$ID.'" data-tax="'.$tax.'" data-value="'. $term->term_id .'">'. $term->name .'</a></li>';
				}
			$html .='</ul>';
		}
		$html = apply_filters( 'wpex_filterby_cat', $html );
		echo $html;
	}
}
if( !function_exists('wpex_filterby_year')){
	function wpex_filterby_year($year,$ID){
		$tax = 'wpex_year';
		$args = array(
			'hide_empty'        => true, 
		);
		if($year!=''){
			$year = explode(",", $year);
			if(is_numeric($year[0])){
				$args['include'] = $year;
			}else{
				$args['slug'] = $tax;
			}
		}
		$terms = get_terms($tax, $args);
		$html = '';
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ 
			$nub_t = count($terms);
				$i=0;
				foreach ( $terms as $term ) {
					$i++;
					$html .='<span data-id="'.$ID.'" id="tl-'.$term->slug.'" data-value="'. $term->term_id .'">'. $term->name .'</span>';
				}
		}
		$html = apply_filters( 'wpex_filterby_year', $html );
		return $html;
	}
}




if(!function_exists('wptl_social_share')){
	function wptl_social_share( $id = false){
		$id = get_the_ID();
		$tl_share_button = array('fb','tw','li','tb','gg','pin','vk','em',);
		ob_start();
		if(is_array($tl_share_button) && !empty($tl_share_button)){
			?>
			<div class="wptl-social-share">
				<?php if(in_array('fb', $tl_share_button)){ ?>
					<span class="facebook">
						<a class="trasition-all" title="<?php esc_html_e('Share on Facebook','exthemes');?>" href="#" target="_blank" rel="nofollow" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+'<?php echo urlencode(get_permalink($id)); ?>','facebook-share-dialog','width=626,height=436');return false;"><i class="fa fa-facebook"></i><?php esc_html_e('Share on Facebook','exthemes');?>
						</a>
					</span>
				<?php }
	
				if(in_array('tw', $tl_share_button)){ ?>
					<span class="twitter">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Share on Twitter','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://twitter.com/share?text=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>&amp;url=<?php echo urlencode(get_permalink($id)); ?>','twitter-share-dialog','width=626,height=436');return false;"><i class="fa fa-twitter"></i>
                        <?php esc_html_e('Share on Twitter','exthemes');?>
						</a>
					</span>
				<?php }
	
				if(in_array('li', $tl_share_button)){ ?>
						<span class="linkedin">
							<a class="trasition-all" href="#" title="<?php esc_html_e('Share on LinkedIn','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink($id)); ?>&amp;title=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>&amp;source=<?php echo urlencode(get_bloginfo('name')); ?>','linkedin-share-dialog','width=626,height=436');return false;"><i class="fa fa-linkedin"></i>
                            <?php esc_html_e('Share on LinkedIn','exthemes');?>
							</a>
						</span>
				<?php }
	
				if(in_array('tb', $tl_share_button)){ ?>
					<span class="tumblr">
					   <a class="trasition-all" href="#" title="<?php esc_html_e('Share on Tumblr','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('http://www.tumblr.com/share/link?url=<?php echo urlencode(get_permalink($id)); ?>&amp;name=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>','tumblr-share-dialog','width=626,height=436');return false;"><i class="fa fa-tumblr"></i>
                       <?php esc_html_e('Share on Tumblr','exthemes');?>
					   </a>
					</span>
				<?php }
	
				if(in_array('gg', $tl_share_button)){ ?>
					 <span class="google-plus">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Share on Google Plus','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('https://plus.google.com/share?url=<?php echo urlencode(get_permalink($id)); ?>','googleplus-share-dialog','width=626,height=436');return false;"><i class="fa fa-google-plus"></i>
                        <?php esc_html_e('Share on Google Plus','exthemes');?>
						</a>
					 </span>
				 <?php }
	
				 if(in_array('pin', $tl_share_button)){ ?>
					 <span class="pinterest">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Pin this','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('//pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($id)) ?>&amp;media=<?php echo urlencode(wp_get_attachment_url( get_post_thumbnail_id($id))); ?>&amp;description=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>','pin-share-dialog','width=626,height=436');return false;"><i class="fa fa-pinterest"></i>
                        <?php esc_html_e('Pin this','exthemes');?>
						</a>
					 </span>
				 <?php }
				 
				 if(in_array('vk', $tl_share_button)){ ?>
					 <span class="vk">
						<a class="trasition-all" href="#" title="<?php esc_html_e('Share on VK','exthemes');?>" rel="nofollow" target="_blank" onclick="window.open('//vkontakte.ru/share.php?url=<?php echo urlencode(get_permalink(get_the_ID())); ?>','vk-share-dialog','width=626,height=436');return false;"><i class="fa fa-vk"></i>
                        <?php esc_html_e('Share on VK','exthemes');?>
						</a>
					 </span>
				 <?php }
	
				 if(in_array('em', $tl_share_button)){ ?>
					<span class="email">
						<a class="trasition-all" href="mailto:?subject=<?php echo urlencode(html_entity_decode(get_the_title($id), ENT_COMPAT, 'UTF-8')); ?>&amp;body=<?php echo urlencode(get_permalink($id)) ?>" title="<?php esc_html_e('Email this','exthemes');?>"><i class="fa fa-envelope"></i>
                        <?php esc_html_e('Email this','exthemes');?>
						</a>
					</span>
				<?php }?>
			</div>
			<?php
		}
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}

if(!function_exists('wptl_show_cat')){
	function wptl_show_cat($post_type, $tax=false, $show_once= false){
		if($post_type == 'wp-timeline'){
			return;
		}
		ob_start();
		if(isset($post_type) && $post_type!='post'){
			if($post_type == 'product' && class_exists('Woocommerce')){
				$tax = 'product_cat';
			}
			if(isset($tax) && $tax!=''){
				$args = array(
					'hide_empty'        => false, 
				);
				$terms = get_terms($tax, $args);
				if(!empty($terms)){
					$c_tax = count($terms);
					?>
					<span class="info-cat">
						<i class="fa fa-folder-open-o" aria-hidden="true"></i>
						<?php
						$i=0;
						foreach ( $terms as $term ) {
							$i++;
							echo '<a href="'.get_term_link( $term ).'" title="' . esc_html__('View all posts in ') . $term->name . '">'. $term->name .'</a>';
							if($i != $c_tax){ echo ', ';}
						}
						?>
                    </span>
                    <?php
				}
			}
		}else{
			$category = get_the_category();
			if(!isset($show_once) || $show_once!='1'){
				if(!empty($category)){
					?>
					<span class="info-cat">
						<i class="fa fa-folder-open-o" aria-hidden="true"></i>
						<?php the_category(', '); ?>
					</span>
					<?php  
				}
			}else{
				if(!empty($category)){
					?>
					<span class="info-cat">
						<i class="fa fa-folder-open-o" aria-hidden="true"></i>
						<?php
						foreach($category as $cat_item){
							if(is_array($cat_item) && isset($cat_item[0]))
								$cat_item = $cat_item[0];
								echo '
									<a href="' . esc_url(get_category_link( $cat_item->term_id )) . '" title="' . esc_html__('View all posts in ') . $cat_item->name . '">' . $cat_item->name . '</a>';
								if($show_once==1){
									break;
								}
							}
							?>
                    </span>
                    <?php
				}
			}
		}
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}
if(!function_exists('wptl_audio_video_iframe')){
	function wptl_audio_video_iframe(){
		ob_start();
		echo '<div class="wptl-embed">';
		global $post;
		preg_match("/<embed\s+(.+?)>/i", $post->post_content, $matches_emb); if(isset($matches_emb[0])){ echo $matches_emb[0];}
		preg_match("/<source\s+(.+?)>/i", $post->post_content, $matches_sou) ;
		preg_match('/\<object(.*)\<\/object\>/is', $post->post_content, $matches_oj); 
		preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $post->post_content, $matches);
		preg_match( '#\[audio\s*.*?\]#s', $post->post_content, $matches_sc );
		preg_match( '#\[video\s*.*?\]#s', $post->post_content, $matches_scvd );
		preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $post->post_content, $match);
		if(!isset($matches_emb[0]) && isset($matches_sou[0])){
			echo $matches_sou[0];
		}else if(!isset($matches_sou[0]) && isset($matches_oj[0])){
			echo $matches_oj[0];
		}else if( !isset($matches_oj[0]) && isset($matches[0])){
			echo $matches[0];
		}else if( !isset($matches[0]) && isset($matches_sc[0])){
			 echo do_shortcode($matches_sc[0]);
		}else if( !isset($matches_sc[0]) && isset($matches_scvd[0])){
			 echo do_shortcode($matches_scvd[0]);
		}else if( !isset($matches_scvd[0]) && isset($match[0])){
			foreach ($match[0] as $matc) {
				if(strpos($matc,'soundcloud.com') !== false || strpos($matc,'youtube.com') !== false){
					echo wp_oembed_get($matc);
					break;
				}
			}
		}
		echo '</div>';
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
	}
}
