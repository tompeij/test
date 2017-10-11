<?php
function parse_wpex_timeline_horizontal_func($atts, $content){
	global $style,$posttype,$show_media,$show_label,$taxonomy,$full_content,$hide_thumb;
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$style = isset($atts['style']) && $atts['style']!='' ? $atts['style'] : 'left';
	if($style=='left-side'){ $style = 'left';}
	$layout 		= isset($atts['layout']) && $atts['layout']!='' ? $atts['layout'] : 'horizontal';
	$posttype 		= isset($atts['posttype']) && $atts['posttype']!='' ? $atts['posttype'] : 'post';
	$cat 		=isset($atts['cat']) ? $atts['cat'] : '';
	$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
	$taxonomy 		=isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
	$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
	$count 		= isset($atts['count']) ? $atts['count'] : '6';
	$order 	= isset($atts['order']) ? $atts['order'] : '';
	$orderby 	= isset($atts['orderby']) ? $atts['orderby'] : '';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$slidesshow = isset($atts['slidesshow']) && $atts['slidesshow']!='' ? $atts['slidesshow'] : 5;
	$autoplay 		= isset($atts['autoplay']) && $atts['autoplay'] == 1 ? 1 : 0;
	$class 		= isset($atts['class']) && $atts['class'] !='' ? $atts['class'] : '';
	$show_media 		= isset($atts['show_media']) ? $atts['show_media'] : '1';
	$show_label 		= isset($atts['show_label']) ? $atts['show_label'] : '0';
	$show_all 		= isset($atts['show_all']) ? $atts['show_all'] : '0';
	$header_align 		= isset($atts['header_align']) ? $atts['header_align'] : '';
	$content_align 		= isset($atts['content_align']) ? $atts['content_align'] : '1';
	$full_content 		= isset($atts['full_content']) ? $atts['full_content'] : '0';
	$hide_thumb 		= isset($atts['hide_thumb']) ? $atts['hide_thumb'] : '0';
	$arrow_position 		= isset($atts['arrow_position']) ? $atts['arrow_position'] : '';
	$toolbar_position 		= isset($atts['toolbar_position']) ? $atts['toolbar_position'] : 'top';
	$autoplayspeed 		= isset($atts['autoplayspeed']) && is_numeric($atts['autoplayspeed']) ? $atts['autoplayspeed'] : '';
	$start_on 		= isset($atts['start_on']) ? $atts['start_on'] : '';
	if($arrow_position=='top'){
		$class = $class.' arrow-top';
	}
	if($layout=='hozsteps'){
		$class = $class.' tl-hozsteps';
		if($header_align==''){ $header_align = 'left';}
	}
	if($content_align=='left'){
		$class = $class.' tl-ct-left';
	}
	$args = wpex_timeline_query($posttype, $count, $order, $orderby, $cat, $tag, $taxonomy, $meta_key, $ids);
	ob_start();
	$the_query = new WP_Query( $args );
	$it = $the_query->post_count;
	/*if($it <= $slidesshow){
		//$slidesshow = 1;
	}else if($it == 4 || $it == 5){
		//$slidesshow = 3;
	}else*/
	if($it < ($start_on + 1)){ $start_on = 0;}
	if($it <= $slidesshow){
		$slidesshow = $it;
		$class = $class.' tlhl-full';
	}
	if($arrow_position != 'top'){
		$class = $class.' no-arr-top';
	}
	if($show_all==1){
		$slidesshow = $it;
		$header_align = 'left';
		$class = $class.' show-all-items';
	}
	$wpex_load_css = get_option('wpex_load_css');
	$wpex_rtl_mode = get_option('wpex_rtl_mode');
	if($wpex_load_css =='shortcode'){
		wp_enqueue_style( 'wpex-ex_s_lick', WPEX_TIMELINE .'js/ex_s_lick/ex_s_lick.css');
		wp_enqueue_style( 'wpex-ex_s_lick-theme', WPEX_TIMELINE .'js/ex_s_lick/ex_s_lick-theme.css');
		wp_enqueue_style('wpex-timeline-css');
		wp_enqueue_style('wpex-timeline-dark-css');
		if($wpex_rtl_mode=='yes'){
			wp_enqueue_style('wpex-timeline-rtl-css', WPEX_TIMELINE.'css/rtl.css');
		}
	}
	
	wp_enqueue_script( 'wpex-ex_s_lick', WPEX_TIMELINE.'js/ex_s_lick/ex_s_lick.js', array( 'jquery' ) );
	wp_enqueue_script( 'wpex-timeline', WPEX_TIMELINE.'js/template.min.js', array( 'jquery' ) );
	if($the_query->have_posts()){?>
        <div class="wpex horizontal-timeline wpex-horizontal-<?php echo esc_attr($style);?> <?php echo esc_attr($class);?>" data-layout="<?php echo esc_attr($layout);?>" data-autoplay="<?php echo esc_attr($autoplay)?>" data-speed="<?php echo esc_attr($autoplayspeed)?>" data-rtl="<?php echo esc_attr($wpex_rtl_mode)?>" id="horizontal-tl-<?php echo esc_attr($ID)?>" data-id="horizontal-tl-<?php echo esc_attr($ID)?>" data-slidesshow="<?php echo esc_attr($slidesshow)?>" data-arrowpos="<?php echo esc_attr($arrow_position)?>" data-center="<?php echo esc_attr($header_align)?>" data-start_on="<?php echo esc_attr($start_on)?>">
        	<?php if($toolbar_position=='bottom'){?>
            <ul class="horizontal-content">
                    <?php while($the_query->have_posts()){ $the_query->the_post(); 
                        wpex_template_plugin('content-slider');?>
                    <?php }?>
            </ul>
            <?php }?>
            <div class="hor-container">
            <span class="timeline-hr"></span>
            <span class="timeline-pos-select"></span>
            <ul class="horizontal-nav">
				<?php while($the_query->have_posts()){ $the_query->the_post();
                    if($posttype == 'wp-timeline'){
                        if($show_label==1){
                            $wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_sublabel', true );
                        }else{
                            $wpex_sublabel = get_post_meta( get_the_ID(), 'wpex_date', true );
                        }
                    }else{
                        $date_id = get_the_date( get_option( 'date_format' ) );
                        $wpex_sublabel = date_i18n( 'd', strtotime( $date_id ) ).' - '.date_i18n( 'M', strtotime( $date_id ) );
                    }
                    if($wpex_sublabel==''){ $wpex_sublabel = "&nbsp;";}
					$icon = get_post_meta( get_the_ID(), 'wpex_icon', true ) !='' ? get_post_meta( get_the_ID(), 'wpex_icon', true ) : 'fa-circle no-icon';
					?>
                    <li class="<?php echo 'ictl-'.get_the_ID();?>">
                    	<a href="javascript:;"><?php echo $wpex_sublabel;?><i class="fa <?php echo esc_attr($icon);?>"></i></a>
                    	<?php 
						$we_eventcolor = get_post_meta( get_the_ID(), 'we_eventcolor', true );
						$wpex_icon_img = get_post_meta( get_the_ID(), 'wpex_icon_img', true );
						if(($we_eventcolor!='' || $wpex_icon_img!='') && $layout=='hozsteps'){?>
						<style type="text/css">
							<?php if($wpex_icon_img!=''){?>
							.wpex.horizontal-timeline.tl-hozsteps ul.horizontal-nav li.ictl-<?php echo get_the_ID();?> > a > i.no-icon:before{ background:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); background-repeat: no-repeat; background-size: 100% auto; background-position: center;color: transparent;}
							<?php }
							if($we_eventcolor!=''){?>
							.wpex.horizontal-timeline.tl-hozsteps ul.horizontal-nav li.ictl-<?php echo get_the_ID();?> > a > i{
								color:<?php echo esc_attr($we_eventcolor);?>;
							}
							<?php }?>
						</style>
						<?php }?>
                    </li>
                <?php }?>
            </ul>
            </div>
            <?php if($toolbar_position!='bottom'){?>
            <ul class="horizontal-content">
                    <?php while($the_query->have_posts()){ $the_query->the_post(); 
                        wpex_template_plugin('content-slider');?>
                    <?php }?>
            </ul>
            <?php }?>
        </div>
        <?php 
		
	}
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'wpex_timeline_horizontal', 'parse_wpex_timeline_horizontal_func' );
