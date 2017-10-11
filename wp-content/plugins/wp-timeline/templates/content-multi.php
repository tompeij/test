<?php
global $style, $post, $posttype,$show_media ,$show_label , $taxonomy, $number_excerpt, $full_content, $hide_thumb;
$thumb_size = 'wptl-600x450';
if($style=='full-width'){
	$thumb_size = 'full';
}
$custom_link = wpex_custom_link();
$bg_style = '';
if($style=='3'){
	$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
	$bg_style = isset($image_src[0]) ? ' background-image:url('.$image_src[0].');' :'';
}
$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
?>
<div <?php post_class();?> id="wpextt_content-<?php echo get_the_ID();?>" style=" <?php echo $bg_style;?>">
    <div class="wpex-timeline-label">
        <?php 
		if($hide_thumb!='1' && $style!='3'){
			if($show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
					echo '<div class="timeline-media">'.wptl_audio_video_iframe().'</div>';
				}elseif(has_post_thumbnail(get_the_ID())){?>
				<div class="timeline-media">
					<a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
					<?php the_post_thumbnail($thumb_size);?>
					<span class="bg-opacity"></span>
					</a>
				</div>
			<?php }
		}
		?>
        <div class="timeline-details">
        	<h2>
                <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
					<?php the_title()?>
                </a>
            </h2>
            <?php 
			if($style=='3' && $show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
				echo '<div class="timeline-media">'.wptl_audio_video_iframe().'</div>';
			}
			if($posttype != 'wp-timeline'){?>
            <div class="wptl-more-meta">
            	<?php echo wptl_show_cat($posttype, $taxonomy);?>
            </div>
            <?php }else{
				if($show_label==1){
					$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_date', true );
					$wpex_sublabel = $wpex_sublabel !='' ? '<i class="fa fa-calendar"></i>'.$wpex_sublabel : '';
				}else{
					$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
				}if($wpex_sublabel!=''){?>
            		<div class="wptl-more-meta"><span><?php echo $wpex_sublabel;?></span></div>
            <?php }
			}?>
            <div class="wptl-excerpt">
				<?php 
				if($full_content=='1' && $hide_thumb!='1' && $show_media=='1'){
					$content =  preg_replace ('#<embed(.*?)>(.*)#is', ' ', get_the_content(),1);
					$content =  preg_replace ('@<iframe[^>]*?>.*?</iframe>@siu', ' ', $content,1);
					$content =  preg_replace ('/<source\s+(.+?)>/i', ' ', $content,1);
					$content =  preg_replace ('/\<object(.*)\<\/object\>/is', ' ', $content,1);
					$content =  preg_replace ('#\[video\s*.*?\]#s', ' ', $content,1);
					$content =  preg_replace ('#\[audio\s*.*?\]#s', ' ', $content,1);
					$content =  preg_replace ('#\[/audio]#s', ' ', $content,1);
					preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $content, $match);
					foreach ($match[0] as $amatch) {
						if(strpos($amatch,'soundcloud.com') !== false){
							$content = str_replace($amatch, '', $content);
						}elseif(strpos($amatch,'youtube.com') !== false){
							$content = str_replace($amatch, '', $content);
						}
					}
					$content = preg_replace('%<object.+?</object>%is', '', $content,1);
					echo apply_filters('the_content',$content);
				}elseif($full_content=='1'){
					echo apply_filters('the_content', get_the_content());
				}else if($number_excerpt!='0'){
					echo wp_trim_words(get_the_excerpt(),$number_excerpt,$more = '...');
				}?>
            </div>
            <?php 
			if($full_content!='1'){?>
            <div class="wptl-readmore"><a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><?php echo get_option('wpex_text_conread')!='' ? get_option('wpex_text_conread') : esc_html__('Continue reading','wp-timeline');?></a></div>
            <?php }?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>