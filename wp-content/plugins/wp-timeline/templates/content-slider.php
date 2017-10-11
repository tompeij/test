<?php
global $style, $post, $posttype,$show_media, $taxonomy, $show_label, $full_content, $hide_thumb;
$thumb_size = 'wptl-600x450';
if($style=='full-width'){
	$thumb_size = 'full';
}
$custom_link = wpex_custom_link();
?>
<li <?php post_class();?> id="<?php echo get_the_ID();?>!">
    <div class="wpex-timeline-label">
        <?php 
		if($hide_thumb!='1'){
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
            	<?php if($posttype == 'wp-timeline' && $show_label ==1){ 
					echo '<span>'.get_post_meta( get_the_ID(), 'wpex_date', true ).' - </span>';
				}?>
                <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
					<?php the_title()?>
                </a>
            </h2>
            <?php 
			if($posttype == 'wp-timeline'){
				if($show_label==1){
					$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_date', true );
				}else{
					$wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
				}
			}else{
				$date_id = get_the_date( get_option( 'date_format' ) );
				$wpex_sublabel = get_the_date( get_option( 'date_format' ) );
			}
			?>
            <div class="hidden-date"><?php echo $wpex_sublabel;?></div>
            <?php if($posttype != 'wp-timeline'){?>
            <div class="wptl-more-meta">
            	<?php
					$wpex_date = get_the_date( get_option( 'date_format' ) );?>
					<span>
						<i class="fa fa-calendar"></i>
						<time class="wpex-timeline-time" datetime="<?php echo esc_attr($wpex_date);?>">
						<?php echo $wpex_date;?>
						</time>
					</span>
					<?php
					echo wptl_show_cat($posttype, $taxonomy);?>
            </div>
            <?php }?>
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
			}else{
				echo get_the_excerpt();
			}
			?>
            </div>
            <?php //echo wptl_social_share();
			if($full_content!='1'){?>
            <div class="wptl-readmore"><a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><?php echo get_option('wpex_text_conread')!='' ? get_option('wpex_text_conread') : esc_html__('Continue reading','wp-timeline');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i></a></div>
            <?php }?>
        </div>
        <div class="clearfix"></div>
    </div>
</li>