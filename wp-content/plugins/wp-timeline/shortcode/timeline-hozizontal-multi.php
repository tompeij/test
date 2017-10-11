<?php
function parse_wpex_timeline_horizontal_multi_func($atts, $content){
	global $style,$posttype,$show_media,$show_label,$taxonomy,$full_content,$hide_thumb,$number_excerpt;
	$ID = isset($atts['ID']) ? $atts['ID'] : rand(10,9999);
	$style = isset($atts['style']) && $atts['style']!='' ? $atts['style'] : '';
	$posttype 		= isset($atts['posttype']) && $atts['posttype']!='' ? $atts['posttype'] : 'post';
	$cat 		=isset($atts['cat']) ? $atts['cat'] : '';
	$tag 	= isset($atts['tag']) ? $atts['tag'] : '';
	$taxonomy 		=isset($atts['taxonomy']) ? $atts['taxonomy'] : '';
	$ids 		= isset($atts['ids']) ? $atts['ids'] : '';
	$count 		= isset($atts['count']) ? $atts['count'] : '6';
	$order 	= isset($atts['order']) ? $atts['order'] : '';
	$orderby 	= isset($atts['orderby']) ? $atts['orderby'] : '';
	$meta_key 	= isset($atts['meta_key']) ? $atts['meta_key'] : '';
	$slidesshow = isset($atts['slidesshow']) ? $atts['slidesshow'] : '4';
	$number_excerpt =  isset($atts['number_excerpt'])&& $atts['number_excerpt']!='' ? $atts['number_excerpt'] : '10';
	$autoplay 		= isset($atts['autoplay']) && $atts['autoplay'] == 1 ? 1 : 0;
	$class 		= isset($atts['class']) && $atts['class'] !='' ? $atts['class'] : '';
	$show_media 		= isset($atts['show_media']) ? $atts['show_media'] : '1';
	$show_label 		= isset($atts['show_label']) ? $atts['show_label'] : '0';
	$full_content 		= isset($atts['full_content']) ? $atts['full_content'] : '0';
	$hide_thumb 		= isset($atts['hide_thumb']) ? $atts['hide_thumb'] : '0';
	$autoplayspeed 		= isset($atts['autoplayspeed']) && is_numeric($atts['autoplayspeed']) ? $atts['autoplayspeed'] : '';
	$start_on 		= isset($atts['start_on']) ? $atts['start_on'] : '';
	if($start_on=='' && isset($atts['strart_on']) && isset($atts['strart_on'])!=''){
		$start_on = $atts['strart_on'];
	}
	$args = wpex_timeline_query($posttype, $count, $order, $orderby, $cat, $tag, $taxonomy, $meta_key, $ids);
	ob_start();
	$the_query = new WP_Query( $args );
	$it = $the_query->post_count;
	$class = 'ex-multi-item '.$class;
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
	//
	wp_enqueue_script( 'wpex-ex_s_lick', WPEX_TIMELINE.'js/ex_s_lick/ex_s_lick.js', array( 'jquery' ) );
	wp_enqueue_script( 'wpex-timeline', WPEX_TIMELINE.'js/template.min.js', array( 'jquery' ) );
	if($the_query->have_posts()){?>
        <div class="wpex horizontal-timeline wpex-horizontal-<?php echo esc_attr($style);?> <?php echo esc_attr($class);?>" data-autoplay="<?php echo esc_attr($autoplay)?>" data-speed="<?php echo esc_attr($autoplayspeed)?>" data-rtl="<?php echo esc_attr($wpex_rtl_mode)?>" id="horizontal-tl-<?php echo esc_attr($ID)?>" data-id="horizontal-tl-<?php echo esc_attr($ID)?>" data-slidesshow="<?php echo esc_attr($slidesshow)?>"  data-start_on="<?php echo esc_attr($start_on)?>">
            <div class="hor-container">
            <span class="timeline-hr"></span>
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
                        $wpex_sublabel = get_the_date( get_option( 'date_format' ) );
                    }
                    if($wpex_sublabel==''){ $wpex_sublabel = "&nbsp;";}
					$icon = get_post_meta( get_the_ID(), 'wpex_icon', true ) !='' ? get_post_meta( get_the_ID(), 'wpex_icon', true ) : 'fa-circle no-icon';
					?>
                    <li class="<?php echo 'ictl-'.get_the_ID();?>">
                        <a class="wpex_point"  href="javascript:;">
                            <i class="fa <?php echo esc_attr($icon);?>"></i>
                            <?php echo $wpex_sublabel;?>
                        </a>
                        <div class="wpextt_templates">
                            <?php wpex_template_plugin('content-multi');?>
                        </div>
                    	<?php 
						$we_eventcolor = get_post_meta( get_the_ID(), 'we_eventcolor', true );
						$wpex_icon_img = get_post_meta( get_the_ID(), 'wpex_icon_img', true );
						if(($we_eventcolor!='' || $wpex_icon_img!='')){?>
						<style type="text/css">
							<?php 
							if($wpex_icon_img!=''){?>
							.wpex.horizontal-timeline.ex-multi-item ul.horizontal-nav li.ictl-<?php echo get_the_ID();?> > a > .fa.no-icon{ 
								background-image:url(<?php echo esc_url(wp_get_attachment_thumb_url( $wpex_icon_img ));?>); 
								background-repeat: no-repeat; width:50px; visibility:visible;
								background-size: 100% auto; 
								background-position: center;
								color:transparent;
							}
							<?php } ?>
							.wpex.wpex-horizontal-3.ex-multi-item .horizontal-nav li.ictl-<?php echo get_the_ID();?> h2 a,
							.wpex.horizontal-timeline.ex-multi-item .horizontal-nav li.ictl-<?php echo get_the_ID();?> a:before, .wpex.horizontal-timeline.ex-multi-item .horizontal-nav li.ex_s_lick-current.ictl-<?php echo get_the_ID();?> a:before,
							.wpex.horizontal-timeline.ex-multi-item:not(.wpex-horizontal-4) .horizontal-nav li.ictl-<?php echo get_the_ID();?> a.wpex_point{ background:<?php echo esc_attr($we_eventcolor);?>;}
							.wpex.horizontal-timeline.ex-multi-item ul.horizontal-nav li.ictl-<?php echo get_the_ID();?> > a > i{
								color:<?php echo esc_attr($we_eventcolor);?>;
								border-color:<?php echo esc_attr($we_eventcolor);?>;
							}
							.wpex.wpex-horizontal-3.ex-multi-item li.ictl-<?php echo get_the_ID();?> .wpextt_templates .wptl-readmore a,
							.wpex.horizontal-timeline.ex-multi-item.wpex-horizontal-4 li.ictl-<?php echo get_the_ID();?> .wpextt_templates .wptl-readmore a{border-color:<?php echo esc_attr($we_eventcolor);?>;}
							.wpex.horizontal-timeline.ex-multi-item:not(.wpex-horizontal-4) .horizontal-nav li.ictl-<?php echo get_the_ID();?> a.wpex_point:after{border-top-color:<?php echo esc_attr($we_eventcolor);?>;}
							.wpex.wpex-horizontal-3.ex-multi-item li.ictl-<?php echo get_the_ID();?> .wpex-timeline-label .timeline-details:after{border-bottom-color:<?php echo esc_attr($we_eventcolor);?>;}
						</style>
						<?php }?>
                    </li>
                <?php }?>
            </ul>
            </div>
        </div>
        <?php 
		
	}
	wp_reset_postdata();
	$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;

}
add_shortcode( 'timeline_horizontal_multi', 'parse_wpex_timeline_horizontal_multi_func' );

add_action( 'after_setup_theme', 'wpex_timeline_horizontal_multi_vc' );
function wpex_timeline_horizontal_multi_vc(){
	if(function_exists('vc_map')){
	vc_map( array(
	   "name" => esc_html__("WP Hoz Timeline Multi items", "wp-timeline"),
	   "base" => "timeline_horizontal_multi",
	   "class" => "",
	   "icon" => "icon-timeline-slider",
	   "controls" => "full",
	   "category" => esc_html__('content','wp-timeline'),
	   "params" => array(
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Style", 'wp-timeline'),
			 "param_name" => "style",
			 "value" => array(
			 	esc_html__('Style 1', 'wp-timeline') => '',
				esc_html__('Style 2', 'wp-timeline') => '2',
				esc_html__('Style 3', 'wp-timeline') => '3',
				esc_html__('Style 4', 'wp-timeline') => '4',
			 ),
			 "description" => ''
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "posttypes",
			 "class" => "",
			 "heading" => esc_html__("Post types", 'wp-timeline'),
			 "param_name" => "posttype",
			 "value" => array(),
			 "description" => ''
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("IDs", "wp-timeline"),
			"param_name" => "ids",
			"value" => "",
			"description" => esc_html__("Specify post IDs to retrieve", "wp-timeline"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Count", "wp-timeline"),
			"param_name" => "count",
			"value" => "",
			"description" => esc_html__("Number of posts", 'wp-timeline'),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Number item visible", "wp-timeline"),
			"param_name" => "slidesshow",
			"value" => "",
			"description" => "",
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Category", "wp-timeline"),
			"param_name" => "cat",
			"value" => "",
			"description" => esc_html__("List of cat ID (or slug), separated by a comma", "wp-timeline"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Tags", "wp-timeline"),
			"param_name" => "tag",
			"value" => "",
			"description" => esc_html__("List of tags, separated by a comma", "wp-timeline"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Custom Taxonomy", "wp-timeline"),
			"param_name" => "taxonomy",
			"value" => "",
			"description" => esc_html__("Name of custom taxonomy", "wp-timeline"),
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Order", 'wp-timeline'),
			 "param_name" => "order",
			 "value" => array(
			 	esc_html__('DESC', 'wp-timeline') => 'DESC',
				esc_html__('ASC', 'wp-timeline') => 'ASC',
			 ),
			 "description" => ''
		  ),
		  array(
		  	 "admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Order by", 'wp-timeline'),
			 "param_name" => "orderby",
			 "value" => array(
			 	esc_html__('Date', 'wp-timeline') => 'date',
				esc_html__('ID', 'wp-timeline') => 'ID',
				esc_html__('Author', 'wp-timeline') => 'author',
			 	esc_html__('Title', 'wp-timeline') => 'title',
				esc_html__('Name', 'wp-timeline') => 'name',
				esc_html__('Modified', 'wp-timeline') => 'modified',
			 	esc_html__('Parent', 'wp-timeline') => 'parent',
				esc_html__('Random', 'wp-timeline') => 'rand',
				esc_html__('Comment count', 'wp-timeline') => 'comment_count',
				esc_html__('Menu order', 'wp-timeline') => 'menu_order',
				esc_html__('Meta value', 'wp-timeline') => 'meta_value',
				esc_html__('Meta value num', 'wp-timeline') => 'meta_value_num',
				esc_html__('Post__in', 'wp-timeline') => 'post__in',
				esc_html__('None', 'wp-timeline') => 'none',
			 ),
			 "description" => ''
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Meta key", "wp-timeline"),
			"param_name" => "meta_key",
			"value" => "",
			"description" => esc_html__("Enter meta key to query", "wp-timeline"),
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Autoplay", 'wp-timeline'),
			 "param_name" => "autoplay",
			 "value" => array(
			 	esc_html__('No', 'wp-timeline') => '',
				esc_html__('Yes', 'wp-timeline') => '1',
			 ),
			 "description" => ''
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "textfield",
			 "class" => "",
			 "heading" => esc_html__("Autoplay Speed", "wp-timeline"),
			 "param_name" => "autoplayspeed",
			 "value" => "",
			 "dependency" 	=> array(
				'element' => 'autoplay',
				'value'   => array('1'),
			 ),
			 "description" => esc_html__("Autoplay Speed in milliseconds. Default:3000", "wp-timeline"),
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Show media", "wp-timeline"),
			 "param_name" => "show_media",
			 "value" => array(
			 	esc_html__('Yes', 'wp-timeline') => '1',
				esc_html__('No', 'wp-timeline') => '0',
			 ),
			 "description" => ''
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Show label", "wp-timeline"),
			 "param_name" => "show_label",
			 "value" => array(
			 	esc_html__('No', 'wp-timeline') => '',
			 	esc_html__('Yes', 'wp-timeline') => '1',
			 ),
			 "description" => esc_html__("Show label instead of date on timeline bar", "wp-timeline")
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Show full Content", "wp-timeline"),
			 "param_name" => "full_content",
			 "value" => array(
			 	esc_html__('No', 'wp-timeline') => '',
			 	esc_html__('Yes', 'wp-timeline') => '1',
			 ),
			 "description" => esc_html__("Show full Content instead of Excerpt", "wp-timeline")
		  ),
		  array(
		  	"admin_label" => true,
			 "type" => "dropdown",
			 "class" => "",
			 "heading" => esc_html__("Hide thubnails", "wp-timeline"),
			 "param_name" => "hide_thumb",
			 "value" => array(
			 	esc_html__('No', 'wp-timeline') => '',
			 	esc_html__('Yes', 'wp-timeline') => '1',
			 ),
			 "description" => ""
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Slide to start on", "wp-timeline"),
			"param_name" => "start_on",
			"value" => "",
			"description" => esc_html__("Enter number, Default:0", "wp-timeline"),
		  ),
		  array(
		  	"admin_label" => true,
			"type" => "textfield",
			"heading" => esc_html__("Number of Excerpt", "wp-timeline"),
			"param_name" => "number_excerpt",
			"value" => "",
			"description" => esc_html__("Enter number", "wp-timeline"),
		  ),
		  array(
		  	"admin_label" => false,
			"type" => "textfield",
			"heading" => esc_html__("Css Class", "wp-timeline"),
			"param_name" => "class",
			"value" => "",
			"description" => esc_html__("Add a class name and refer to it in custom CSS", "wp-timeline"),
		  ),
	   )
	));
	}
}