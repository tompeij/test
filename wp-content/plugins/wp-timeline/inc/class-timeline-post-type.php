<?php
class WPEX_TL_Posttype {
	public function __construct()
    {
        add_action( 'init', array( &$this, 'register_post_type' ) );
		add_action( 'init', array( &$this, 'register_category_taxonomies' ) );
		add_filter( 'exc_mb_meta_boxes', array($this,'register_metadata') );
    }

	function register_post_type(){
		$labels = array(
			'name'               => esc_html__('Timeline','wp-timeline'),
			'singular_name'      => esc_html__('Timeline','wp-timeline'),
			'add_new'            => esc_html__('Add New Timeline','wp-timeline'),
			'add_new_item'       => esc_html__('Add New Timeline','wp-timeline'),
			'edit_item'          => esc_html__('Edit Timeline','wp-timeline'),
			'new_item'           => esc_html__('New Timeline','wp-timeline'),
			'all_items'          => esc_html__('All Timelines','wp-timeline'),
			'view_item'          => esc_html__('View Timeline','wp-timeline'),
			'search_items'       => esc_html__('Search Timeline','wp-timeline'),
			'not_found'          => esc_html__('No Timeline found','wp-timeline'),
			'not_found_in_trash' => esc_html__('No Timeline found in Trash','wp-timeline'),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html__('Timeline','wp-timeline')
		);
		$wpex_timeline_slug = get_option('wpex_timeline_slug');
		if($wpex_timeline_slug==''){
			$wpex_timeline_slug = 'timeline';
		}
		if ( $wpex_timeline_slug ){
			$rewrite =  array( 'slug' => untrailingslashit( $wpex_timeline_slug ), 'with_front' => false, 'feeds' => true );
		}else{
			$rewrite = false;
		}
		$args = array(  
			'labels' => $labels,  
			'menu_position' => 8, 
			'supports' => array('title','editor','thumbnail', 'excerpt','custom-fields'),
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon' =>  'dashicons-editor-ul',
			'query_var'          => true,
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'rewrite' => $rewrite,
		);  
		register_post_type('wp-timeline',$args);  
	}
	function register_category_taxonomies(){
		$labels = array(
			'name'              => esc_html__( 'Category', 'wp-timeline' ),
			'singular_name'     => esc_html__( 'Category', 'wp-timeline' ),
			'search_items'      => esc_html__( 'Search','wp-timeline' ),
			'all_items'         => esc_html__( 'All category','wp-timeline' ),
			'parent_item'       => esc_html__( 'Parent category' ,'wp-timeline'),
			'parent_item_colon' => esc_html__( 'Parent category:','wp-timeline' ),
			'edit_item'         => esc_html__( 'Edit category' ,'wp-timeline'),
			'update_item'       => esc_html__( 'Update category','wp-timeline' ),
			'add_new_item'      => esc_html__( 'Add New category' ,'wp-timeline'),
			'menu_name'         => esc_html__( 'Categories','wp-timeline' ),
		);			
		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'timeline-category' ),
		);
		
		$labels = array(
			'name'              => esc_html__( 'Year', 'wp-timeline' ),
			'singular_name'     => esc_html__( 'Year', 'wp-timeline' ),
			'search_items'      => esc_html__( 'Search','wp-timeline' ),
			'all_items'         => esc_html__( 'All Year','wp-timeline' ),
			'parent_item'       => esc_html__( 'Parent Year' ,'wp-timeline'),
			'parent_item_colon' => esc_html__( 'Parent Year:','wp-timeline' ),
			'edit_item'         => esc_html__( 'Edit Year' ,'wp-timeline'),
			'update_item'       => esc_html__( 'Update Year','wp-timeline' ),
			'add_new_item'      => esc_html__( 'Add New Year' ,'wp-timeline'),
			'menu_name'         => esc_html__( 'Year','wp-timeline' ),
		);			
		$args_tl = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'wpex_timeline' ),
		);
		
		register_taxonomy('wpex_category', 'wp-timeline', $args);
		if(get_option('wpex_year_tax')=='on'){
			register_taxonomy('wpex_year', 'wp-timeline', $args_tl);
		}
	}
	function register_metadata(array $meta_boxes){
		// register timeline meta
		
		$custom_date = array(
			array( 'id' => 'wpex_sublabel',  'name' => esc_html__('Sub label','wp-timeline'), 'cols' => 4, 'type' => 'text','allow_none' => true, 'desc' => esc_html__('Enter Sub label', 'exthemes'), 'sortable' => false, 'repeatable' => false ),
			array( 'id' => 'wpex_date',  'name' => esc_html__('Custom Date','wp-timeline'), 'cols' => 4, 'type' => 'text','allow_none' => true, 'desc' => esc_html__('Ex: 19 02 1945 or 19/02/1945', 'wp-timeline'), 'sortable' => false, 'repeatable' => false ),
			array( 'id' => 'wpex_felabel',  'name' => esc_html__('Feature label','wp-timeline'), 'cols' => 4, 'type' => 'text','allow_none' => true, 'desc' => esc_html__('Only used for Timeline Listing shortcode', 'wp-timeline'), 'sortable' => false, 'repeatable' => false ),
		);
		
		$speaker_settings = array(	
				array( 'id' => 'wpex_order', 'name' => esc_html__('Order in Timeline', 'wp-timeline'), 'default'=> '0', 'type' => 'text','desc' => esc_html__('Enter number', 'wp-timeline') , 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'wpex_icon', 'name' => esc_html__('Icon', 'wp-timeline'), 'default'=> '', 'type' => 'text','desc' => esc_html__('Enter Font Awesome icon class (Ex: fa-star) (Only used for Timeline Listing shortcode)', 'wp-timeline') , 'repeatable' => false, 'multiple' => false ),
				array( 'id' => 'wpex_icon_img', 'name' => esc_html__('Image Icon', 'wp-timeline'), 'type' => 'image', 'desc' => esc_html__('Use image icon instead of Font Awesome', 'wp-timeline'), 'repeatable' => false, 'show_size' => true ),
				array( 'id' => 'we_eventcolor', 'name' => esc_html__('Color', 'wp-timeline'), 'type' => 'colorpicker', 'repeatable' => false, 'multiple' => true ),
				array( 'id' => 'wpex_custom_metadata',  'name' => esc_html__('Custom metadata', 'wp-timeline'), 'type' => 'text', 'repeatable' => true, 'multiple' => true ),
				array( 'id' => 'wpex_link',  'name' => esc_html__('External/ Custom link','wp-timeline'), 'type' => 'text','allow_none' => true, 'desc' => esc_html__('Enter custom link to replace single timeline link', 'wp-timeline'), 'sortable' => false, 'repeatable' => false ),
			);

		$meta_boxes[] = array(
			'title' => __('Timeline info','wp-timeline'),
			'pages' => 'wp-timeline',
			'fields' => $speaker_settings,
			'priority' => 'high'
		);
		$meta_boxes[] = array(
			'title' => __('Timeline custom date','wp-timeline'),
			'pages' => 'wp-timeline',
			'fields' => $custom_date,
			'priority' => 'high'
		);
		return $meta_boxes;
	}
	
}
$WPEX_TL_Posttype = new WPEX_TL_Posttype();