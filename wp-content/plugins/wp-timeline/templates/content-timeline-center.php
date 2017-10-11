<?php
global $style, $post, $ajax_load, $ID, $animations,$posttype,$show_media, $taxonomy,$full_content,$feature_label,$lightbox;
$class = 'filter-'.$ID.'_'.get_the_ID();
if($animations!=''){
	$animations = ' scroll-effect';
}
if($ajax_load==1){ $class .=' de-active';}
$icon = get_post_meta( $post->ID, 'wpex_icon', true ) !='' ? get_post_meta( $post->ID, 'wpex_icon', true ) : 'fa-square no-icon';
$wpex_icon_img = get_post_meta( $post->ID, 'wpex_icon_img', true );
$we_eventcolor = get_post_meta( $post->ID, 'we_eventcolor', true );
$custom_link = wpex_custom_link();
$wpex_felabel ='';
if($feature_label==1){
	$wpex_felabel = get_post_meta( $post->ID, 'wpex_felabel', true );
	if($posttype!='wp-timeline' && $wpex_felabel==''){
		global $year_post;
		if(!isset($year_post) || $year_post==''){
			$wpex_felabel = $year_post = get_the_date('Y');
		}elseif($year_post!= get_the_date('Y')){
			$wpex_felabel = $year_post = get_the_date('Y');
		}
	}
	if($wpex_felabel!=''){
		$class .=' wptl-feature';
	}
}
?>
<li <?php post_class($class);?> <?php echo 'data-id="filter-'.$ID.'_'.get_the_ID().'"';?>>
	<div class="<?php echo esc_attr($animations);?>">
        <time class="wpex-timeline-time" datetime="<?php echo esc_attr(get_the_date( get_option( 'time_format' ) ).' '.get_the_date( get_option( 'date_format' ) ));?>">
            <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                <?php if(has_post_thumbnail(get_the_ID())){?><span class="info-img"><?php the_post_thumbnail('wptl-100x100');?></span><?php }?>
            </a>
            <span class="clearfix"></span>
            <?php 
            if($style!='icon'){ wpex_tmfulldate();}?>
        </time>
        <div class="wpex-timeline-label">
            <?php 
            if($style=='icon'){
                wpex_tmbigdate();
            }?>
            <div class="timeline-details">
                <?php
				$link_lb = '';
				if($lightbox==1){
					$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(),'full' );
					$link_lb  = isset($image_src[0]) ? $image_src[0] : '';
				}
				if($show_media=='1' && wptl_audio_video_iframe()!='<div class="wptl-embed"></div>'){
					echo wptl_audio_video_iframe();
				}elseif($style=='icon' && has_post_thumbnail(get_the_ID())){?>
                    <a class="img-left" href="<?php echo $link_lb!='' ? $link_lb : $custom_link;?>" title="<?php the_title_attribute();?>">
                        <span class="info-img"><?php the_post_thumbnail('wptl-320x220');?></span>
                    </a>
                <?php }elseif(has_post_thumbnail(get_the_ID())){?>
                	<a class="img-left tlmobile-visible" href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                        <span class="info-img"><?php the_post_thumbnail('wptl-320x220');?></span>
                    </a>
                <?php }?>
                <h2 style=" display:inline;">
                    <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                        <?php echo '<span class="tlmobile-visible">'.get_post_meta( get_the_ID(), 'wpex_date', true ).'&nbsp;-&nbsp;</span>'; the_title()?>
                    </a>
                </h2>
                <p><?php 
					if($full_content=='1' && $show_media=='1'){
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
					}?>
                </p>
                <?php 
				$cat_html = wptl_show_cat($posttype, $taxonomy);
				if($cat_html!=''){?>
                <div class="wptl-more-meta">
                    <?php echo $cat_html;?>
                </div>
                <?php }?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="wptl-readmore-center">
            <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>">
                <?php echo get_option('wpex_text_conread')!='' ? get_option('wpex_text_conread') : esc_html__('Continue reading','wp-timeline');?> <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <div class="wpex-timeline-icon">
        <a href="<?php echo $custom_link;?>" title="<?php the_title_attribute();?>"><i class="fa <?php echo esc_attr($icon);?>"></i></a>
    </div>
    <?php if($we_eventcolor!=''|| $wpex_icon_img!=''){?>
	<style type="text/css">
		<?php if($wpex_icon_img!=''){?>
		.wpex-timeline-list li.post-<?php the_ID();?> .wpex-timeline-icon .fa.no-icon:before{ background:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); background-repeat: no-repeat; background-size: 100% auto; background-position: center;}
		<?php }
		if($we_eventcolor!=''){?>
		.wpex-timeline-list li.post-<?php the_ID();?> .wpex-timeline-icon .fa,
        .wpex-timeline-list.show-icon .wpex-timeline.style-center > li.post-<?php the_ID();?> .wpex-content-left .wpex-leftdate{ background:<?php echo esc_attr($we_eventcolor);?>}
		.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label:before,
		.wpex-timeline-list.show-icon .wpex-timeline.style-center > li.post-<?php the_ID();?> .wpex-timeline-label:after{border-right-color:<?php echo esc_attr($we_eventcolor);?>}
		.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-label{ border-left-color:<?php echo esc_attr($we_eventcolor);?>;}
		@media(min-width:768px){
			.wpex-timeline-list:not(.show-icon) .wpex-timeline.style-center > li.post-<?php the_ID();?>:nth-child(odd) .wpex-timeline-label{border-right-color:<?php echo esc_attr($we_eventcolor);?>}
			.wpex-timeline-list .wpex-timeline.style-center > li.post-<?php the_ID();?>:nth-child(odd) .wpex-timeline-label:before,
			.wpex-timeline-list.show-icon .wpex-timeline.style-center > li.post-<?php the_ID();?>:nth-child(odd) .wpex-timeline-label:after{ border-left-color:<?php echo esc_attr($we_eventcolor);?>;}
		}
		.wpex-timeline > li.post-<?php the_ID();?> .wpex-timeline-time span:last-child,
		.wpex-timeline-list.show-icon li.post-<?php the_ID();?> .wpex-timeline-icon .fa:not(.no-icon):before{color:<?php echo esc_attr($we_eventcolor);?>;}
		<?php }?>
    </style>
    <?php } ?>
    <?php if($wpex_felabel!=''){
		echo '<div class="wptl-feature-name"><span>'.$wpex_felabel.'</span></div>';
	}?>
    <?php echo isset($year_post) && $year_post!='' ? '<input type="hidden" class="crr-year" value="'.$year_post.'">' : ''; ?>
</li>