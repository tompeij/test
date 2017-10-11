<?php
// edit column admin 
add_filter( 'manage_wp-timeline_posts_columns', 'wpex_edit_columns',99 );
function wpex_edit_columns( $columns ) {
	global $wpdb;
	$columns['wpex_date'] = esc_html__( 'Custom Date' , 'wp-timeline' );
	$columns['wpex_order'] = esc_html__( 'Order' , 'wp-timeline' );
			
	return $columns;
}
add_action( 'manage_wp-timeline_posts_custom_column', 'wpex_custom_columns',12);
function wpex_custom_columns( $column ) {
	global $post;
	switch ( $column ) {
		case 'wpex_date':
			$wpex_customdate = get_post_meta($post->ID, 'wpex_date', true);
			echo '<input type="text" data-id="' . $post->ID . '" name="wpex_timeline_date" value="'.esc_attr($wpex_customdate).'">';
			break;
		case 'wpex_order':
			$wpex_order = get_post_meta($post->ID, 'wpex_order', true);
			echo '<input type="text" data-id="' . $post->ID . '" name="wpex_timeline_sort" value="'.esc_attr($wpex_order).'">';
			break;	
	}
}
add_action('wp_ajax_wpex_change_timeline_sort', 'wpex_change_timeline_func' );
function wpex_change_timeline_func(){
	$post_id = $_POST['post_id'];
	$value = $_POST['value'];
	if(isset($post_id) && $post_id != 0)
	{
		update_post_meta($post_id, 'wpex_order', esc_attr(str_replace(' ', '', $value)));
	}
	die;
}
add_action('wp_ajax_wpex_change_timeline_date', 'wpex_change_date_timeline_func' );
function wpex_change_date_timeline_func(){
	$post_id = $_POST['post_id'];
	$value = $_POST['value'];
	if(isset($post_id) && $post_id != 0)
	{
		update_post_meta($post_id, 'wpex_date', $value);
	}
	die;
}

