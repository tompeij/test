<?php
/*
Plugin Name: WP Timeline
Plugin URI: http://exthemes.net
Description: Responsive Vertical and horizontal timeline plugin
Version: 2.3
Package: Ex 1.0
Author: ExThemes
Author URI: http://exthemes.net
License: Commercial
*/

define( 'WPEX_TIMELINE', plugin_dir_url( __FILE__ ) );

// Make sure we don't expose any info if called directly
if ( !defined('WPEX_TIMELINE') ){
	die('-1');
}
if(!function_exists('wpex_get_plugin_url')){
	function wpex_get_plugin_url(){
		return plugin_dir_path(__FILE__);
	}
}
class WPEX_Timeline{
	public $template_url;
	public $plugin_path;
	public function __construct()
    {
		$this->includes();
		if(is_admin()){
			$this->register_plugin_settings();
		}
		add_action( 'after_setup_theme', array(&$this, 'calthumb_register') );
		add_action( 'after_setup_theme', array(&$this, 'register_bt') );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_css') );
		add_action( 'wp_enqueue_scripts', array($this, 'frontend_scripts') );
		add_filter( 'template_include', array( $this, 'template_loader' ),999 );
		add_action( 'wp_footer', array( $this,'custom_code'),99 );
		add_action( 'widgets_init', array( &$this,'widgets_init') );
    }
	function widgets_init() {
		register_sidebar( array(
			'name' => esc_html__('WP Timeline','wp-timeline'),
			'id' => 'wptimeline-sidebar',
			'description' => esc_html__('Sidebar for single timeline','wp-timeline'),
			'before_widget' => '<div id="%1$s" class="wptimeline-sidebar widget %2$s">',
			'after_widget' => '<div class="clear"></div></div></div></div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3><div class="t;-sidebar"><div class="tl-wrapper">',
		) );
	}
	function register_bt(){
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
	    	return;
		}
		if ( get_user_option('rich_editing') == 'true' ) {
			add_filter( 'mce_external_plugins', array(&$this, 'reg_plugin'));
			add_filter( 'mce_buttons', array(&$this, 'reg_btn') );
		}
	}
	function reg_btn($buttons)
	{
		array_push($buttons, 'wpex_timeline');
		array_push($buttons, 'wpex_timeline_slider');
		return $buttons;
	}

	function reg_plugin($plgs)
	{
		$plgs['wpex_timeline'] 		= WPEX_TIMELINE . 'js/classic-button-timeline.js';
		$plgs['wpex_timeline_slider'] 		= WPEX_TIMELINE . 'js/classic-button-slider.js';
		return $plgs;
	}
	function template_loader($template){
		$find = array('single-timeline.php');
		if(is_singular('wp-timeline')){
			$wpex_disable_link = get_option('wpex_disable_link');
			if($wpex_disable_link=='yes'){
				wp_redirect( get_template_part( '404' ) ); exit;
			}
			$file = 'wp-timeline/single-timeline.php';
			$find[] = $file;
			$find[] = $this->template_url . $file;
			if ( $file ) {
				$template = locate_template( $find );
				
				if ( ! $template ) $template = wpex_get_plugin_url() . '/templates/single-timeline.php';
			}
		}
		if(is_post_type_archive( 'wp-timeline' ) || is_tax('wpex_category')){
			wp_redirect( get_template_part( '404' ) ); exit;
		}
		return $template;		
	}
	

	function register_plugin_settings(){
		global $settings;
		$settings = new WPEX_Timeline_Settings(__FILE__);
		return $settings;
	}
	//thumbnails register
	function calthumb_register(){
		add_image_size('wptl-600x450',600,450, true);
		add_image_size('wptl-320x220',320,220, true);
		add_image_size('wptl-100x100',100,100, true);
	}
	//inculde
	function includes(){
		if(is_admin()){
			require_once  wpex_get_plugin_url().'inc/admin/class-plugin-settings.php';
			include_once wpex_get_plugin_url().'inc/admin/functions.php';
			if(!function_exists('exc_mb_init')){
				if(!class_exists('EXC_MB_Meta_Box')){
					include_once wpex_get_plugin_url().'inc/admin/Meta-Boxes/custom-meta-boxes.php';
				}
			}
		}
		include_once wpex_get_plugin_url().'inc/class-timeline-post-type.php';
		include_once wpex_get_plugin_url().'inc/functions.php';
		include_once wpex_get_plugin_url().'inc/functions-tag.php';
		include wpex_get_plugin_url().'shortcode/timeline.php';
		include wpex_get_plugin_url().'shortcode/timeline-slider.php';
		include wpex_get_plugin_url().'shortcode/timeline-hozizontal.php';
		include wpex_get_plugin_url().'shortcode/timeline-hozizontal-multi.php';
	}
	/*
	 * Load js and css
	 */
	function admin_css(){
		$js_params = array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) );
		wp_localize_script( 'jquery', 'wpex_timeline', $js_params  );
		// CSS for button styling
		wp_enqueue_style("wpex-admin", WPEX_TIMELINE . 'assets/css/style.css');
		wp_enqueue_script( 'wpex-admin', WPEX_TIMELINE . 'assets/js/admin.js', array( 'jquery' ) );
	}
	function frontend_scripts(){
		$wpex_fontawesome = get_option('wpex_fontawesome');
		if($wpex_fontawesome!='on'){
			wp_enqueue_style('wpex-font-awesome', WPEX_TIMELINE.'css/font-awesome/css/font-awesome.min.css');
		}
		
		$main_font_default='Source Sans Pro';
		$g_fonts = array($main_font_default);
		$wptl_fontfamily = get_option('wptl_fontfamily');
		if($wptl_fontfamily!=''){
			$wptl_fontfamily = wpex_get_google_font_name($wptl_fontfamily);
			array_push($g_fonts, $wptl_fontfamily);
		}
		$wpex_hfont = get_option('wpex_hfont');
		if($wpex_hfont!=''){
			$wpex_hfont = wpex_get_google_font_name($wpex_hfont);
			array_push($g_fonts, $wpex_hfont);
		}
		$wpex_ggfonts = get_option('wpex_ggfonts');
		if($wpex_ggfonts!='on'){
			wp_enqueue_style( 'wpex-google-fonts', wpex_get_google_fonts_url($g_fonts), array(), '1.0.0' );
		}
		wp_register_style('wpex-timeline-css', WPEX_TIMELINE.'css/style.css');
		wp_register_style('wpex-timeline-dark-css', WPEX_TIMELINE.'css/dark.css');
		ob_start();
		require wpex_get_plugin_url(). '/css/custom.css.php';
		$custom_css = ob_get_contents();
		ob_end_clean();
		wp_add_inline_style( 'wpex-timeline-dark-css', $custom_css );
		
		$wpex_load_css = get_option('wpex_load_css','');
		$wpex_rtl_mode = get_option('wpex_rtl_mode');
		if($wpex_load_css =='page'){
			global $post;
			if(has_shortcode( $post->post_content, 'wpex_timeline')){
				wp_enqueue_style('wpex-timeline-animate', WPEX_TIMELINE.'css/animate.css');
				wp_enqueue_style('wpex-timeline-css');
				wp_enqueue_style('wpex-timeline-dark-css');
				if($wpex_rtl_mode=='yes'){
					wp_enqueue_style('wpex-timeline-rtl-css', WPEX_TIMELINE.'css/rtl.css');
				}
			}
			if(has_shortcode( $post->post_content, 'wpex_timeline_horizontal')){
				wp_enqueue_style( 'wpex-ex_s_lick', WPEX_TIMELINE .'js/ex_s_lick/ex_s_lick.css');
				wp_enqueue_style( 'wpex-ex_s_lick-theme', WPEX_TIMELINE .'js/ex_s_lick/ex_s_lick-theme.css');
				wp_enqueue_style('wpex-timeline-css');
				wp_enqueue_style('wpex-timeline-dark-css');
				if($wpex_rtl_mode=='yes'){
					wp_enqueue_style('wpex-timeline-rtl-css', WPEX_TIMELINE.'css/rtl.css');
				}
			}
		}elseif($wpex_load_css ==''){
			wp_enqueue_style( 'wpex-ex_s_lick', WPEX_TIMELINE .'js/ex_s_lick/ex_s_lick.css');
			wp_enqueue_style( 'wpex-ex_s_lick-theme', WPEX_TIMELINE .'js/ex_s_lick/ex_s_lick-theme.css');
			wp_enqueue_style('wpex-timeline-animate', WPEX_TIMELINE.'css/animate.css');
			wp_enqueue_style('wpex-timeline-css');
			wp_enqueue_style('wpex-timeline-dark-css');
			if($wpex_rtl_mode=='yes'){
				wp_enqueue_style('wpex-timeline-rtl-css', WPEX_TIMELINE.'css/rtl.css');
			}
		}
		
		if(is_singular('wp-timeline') && $wpex_load_css!=''){
			wp_add_inline_style( 'wpex-timeline-css', $custom_css );
			wp_enqueue_style('wpex-timeline-css');
			if($wpex_rtl_mode=='yes'){
				wp_enqueue_style('wpex-timeline-rtl-css', WPEX_TIMELINE.'css/rtl.css');
			}
		}
	}
	function custom_code() {
		$wpex_custom_code = get_option('wpex_custom_code');
		if($wpex_custom_code!=''){
			echo '<script>'.$wpex_custom_code.'</script>';
		}
	}
}

$WPEX_Timeline = new WPEX_Timeline();