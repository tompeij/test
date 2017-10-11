<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class WPEX_Timeline_Settings {
    private $dir;
	private $file;
	private $assets_dir;
	private $assets_url;
	private $settings_base;
	private $settings;
	public function __construct( $file ) {
		$this->file = $file;
		$this->dir = dirname( $this->file );
		$this->assets_dir = trailingslashit( $this->dir ) . 'assets';
		$this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );
		$this->settings_base = '';
		// Initialise settings
		add_action( 'admin_init', array( $this, 'init' ) );
		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );
		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );
		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->file ) , array( $this, 'add_settings_link' ) );
	}
	/**
	 * Initialise settings
	 * @return void
	 */
	public function init() {
		$this->settings = $this->settings_fields();
	}
	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item() {
		$page = add_menu_page( esc_html__( 'Timeline Settings', 'wp-timeline' ) , esc_html__( 'Timeline', 'wp-timeline' ) , 'manage_options' , 'wp-timeline' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}
	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets() {
		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
		wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
    // We're including the WP media scripts here because they're needed for the image upload field
    // If you're not including an image upload then you can leave this function call out
    wp_enqueue_media();
    wp_register_script( 'wpt-admin-js', $this->assets_url . 'js/settings.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
    wp_enqueue_script( 'wpt-admin-js' );
	}
	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=wp-timeline">' . esc_html__( 'Timeline Settings', 'wp-timeline' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}
	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields() {
		$settings['general'] = array(
			'title'					=> esc_html__( 'General', 'wp-timeline' ),
			'description'			=> esc_html__( '', 'wp-timeline' ),
			'fields'				=> array(
				array(
					'id' 			=> 'wptl_main_color',
					'label'			=> esc_html__( 'Main color', 'wp-timeline' ),
					'description'	=> esc_html__( 'Choose main color of Timeline', 'wp-timeline' ),
					'type'			=> 'color',
					'placeholder'			=> '',
					'default'		=> '#00BCD4'
				),
				array(
					'id' 			=> 'wptl_fontfamily',
					'label'			=> esc_html__( 'Main Font Family', 'wp-timeline' ),
					'description'	=> esc_html__( 'Enter Google font-family name here. For example, if you choose "Source Sans Pro" Google Font, enter Source Sans Pro', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wptl_fontsize',
					'label'			=> esc_html__( 'Main Font Size', 'wp-timeline' ),
					'description'	=> esc_html__( 'Enter size of font, Ex: 13px', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_hfont',
					'label'			=> esc_html__( 'Heading Font Family', 'wp-timeline' ),
					'description'	=> esc_html__( 'Enter Google font-family name here. For example, if you choose "Source Sans Pro" Google Font, enter Source Sans Pro', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> '',
				),
				array(
					'id' 			=> 'wpex_hfontsize',
					'label'			=> esc_html__( 'Heading Font Size', 'wp-timeline' ),
					'description'	=> esc_html__( 'Enter size of font, Ex: 20px', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_metafont',
					'label'			=> esc_html__( 'Meta Font Family', 'wp-timeline' ),
					'description'	=> esc_html__( 'Enter Google font-family name here. For example, if you choose "Ubuntu" Google Font, enter Ubuntu', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> '',
				),
				array(
					'id' 			=> 'wpex_matafontsize',
					'label'			=> esc_html__( 'Meta Font Size', 'wp-timeline' ),
					'description'	=> esc_html__( 'Enter size of font, Ex: 12px', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_timeline_slug',
					'label'			=> esc_html__( 'Timeline slug', 'wp-timeline' ),
					'description'	=> esc_html__( 'Remember to save the permalink settings again in Settings > Permalinks', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_fontawesome',
					'label'			=> esc_html__( 'Turn off Font Awesome', 'wp-timeline' ),
					'description'	=> esc_html__( "Turn off loading plugin's Font Awesome. Check if your theme has already loaded this library", 'wp-timeline' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_ggfonts',
					'label'			=> esc_html__( 'Turn off Google Font', 'wp-timeline' ),
					'description'	=> esc_html__( "Turn off loading plugin's Google Font.", 'wp-timeline' ),
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_disable_link',
					'label'			=> esc_html__( 'Disable link & Single timeline page', 'wp-timeline' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'No', 'wp-timeline' ),
						'yes' => esc_html__( 'Yes', 'wp-timeline' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_disable_social',
					'label'			=> esc_html__( 'Disable social share', 'wp-timeline' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'No', 'wp-timeline' ),
						'yes' => esc_html__( 'Yes', 'wp-timeline' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_navi',
					'label'			=> esc_html__( 'Show next & previous link in Single timeline page', 'wp-timeline' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Yes', 'wp-timeline' ),
						'no' => esc_html__( 'No', 'wp-timeline' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_navi_order',
					'label'			=> esc_html__( 'Next & previous link order by', 'wp-timeline' ),
					'description'	=> '',
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Publish date', 'wp-timeline' ),
						'ct_order' => esc_html__( 'Custom order field', 'wp-timeline' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_rtl_mode',
					'label'			=> esc_html__( 'RTL Mode', 'wp-timeline' ),
					'description'	=> esc_html__('Support Right-to-Left language', 'wp-timeline'),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'No', 'wp-timeline' ),
						'yes' => esc_html__( 'Yes', 'wp-timeline' ),
					),
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_year_tax',
					'label'			=> '',
					'description'	=> '',
					'type'			=> 'checkbox',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_load_css',
					'label'			=> esc_html__( 'Loading css file on', 'wp-timeline' ),
					'description'	=> esc_html__('Select "Page with content contain timeline" if you dont use timeline shortcode in sidebar', 'wp-timeline'),
					'type'			=> 'select',
					'options'		=> array( 
						'' => esc_html__( 'Site-wide', 'wp-timeline' ),
						'page' => esc_html__( 'Page with content contain timeline', 'wp-timeline' ),
						'shortcode' => esc_html__( 'Only in timeline shortcode', 'wp-timeline' ),
						
					),
					'default'		=> ''
				),
			)
		);
		$settings['custom-css'] = array(
			'title'					=> esc_html__( 'Custom css', 'wp-timeline' ),
			'description'			=> '',
			'fields'				=> array(
				array(
					'id' 			=> 'wpex_custom_css',
					'label'			=> esc_html__( 'Paste your CSS code' , 'wp-timeline' ),
					'description'	=> esc_html__( 'Add custom CSS code to the plugin without modifying files', 'wp-timeline' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> esc_html__( '', 'wp-timeline' )
				),
				array(
					'id' 			=> 'wpex_custom_code',
					'label'			=> esc_html__( 'Paste your js code' , 'wp-timeline' ),
					'description'	=> esc_html__( 'Add custom js code to the plugin without modifying files', 'wp-timeline' ),
					'type'			=> 'textarea',
					'default'		=> '',
					'placeholder'	=> ''
				),
			)
		);
		$settings['static-text'] = array(
			'title'					=> esc_html__( 'Front end Static Text', 'wp-timeline' ),
			'description'			=> '',
			'fields'				=> array(
				array(
					'id' 			=> 'wpex_text_conread',
					'label'			=> esc_html__( 'Continue reading', 'wp-timeline' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_text_loadm',
					'label'			=> esc_html__( 'Load more', 'wp-timeline' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_text_next',
					'label'			=> esc_html__( 'Next article', 'wp-timeline' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
				array(
					'id' 			=> 'wpex_text_prev',
					'label'			=> esc_html__( 'Previous article', 'wp-timeline' ),
					'description'	=> esc_html__( 'Add your text to replace this static text', 'wp-timeline' ),
					'type'			=> 'text',
					'placeholder'			=> '',
					'default'		=> ''
				),
			)
		);
		$settings = apply_filters( 'wp-timeline_fields', $settings );
		return $settings;
	}
	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings() {
		if( is_array( $this->settings ) ) {
			foreach( $this->settings as $section => $data ) {
				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), 'wp-timeline' );
				foreach( $data['fields'] as $field ) {
					// Validation callback for field
					$validation = '';
					if( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}
					// Register field
					$option_name = $this->settings_base . $field['id'];
					register_setting( 'wp-timeline', $option_name, $validation );
					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this, 'display_field' ), 'wp-timeline', $section, array( 'field' => $field ) );
				}
			}
		}
	}
	public function settings_section( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}
	/**
	 * Generate HTML for displaying fields
	 * @param  array $args Field data
	 * @return void
	 */
	public function display_field( $args ) {
		$field = $args['field'];
		$html = '';
		$option_name = $this->settings_base . $field['id'];
		$option = get_option( $option_name );
		$data = '';
		if( isset( $field['default'] ) ) {
			$data = $field['default'];
			if( $option ) {
				$data = $option;
			}
		}
		switch( $field['type'] ) {
			case 'text':
			case 'password':
			case 'number':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value="' . $data . '"/>' . "\n";
			break;
			case 'text_secret':
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="text" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" value=""/>' . "\n";
			break;
			case 'textarea':
				$html .= '<textarea id="' . esc_attr( $field['id'] ) . '" rows="5" cols="50" name="' . esc_attr( $option_name ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '">' . $data . '</textarea><br/>'. "\n";
			break;
			case 'checkbox':
				$checked = '';
				if( $option && 'on' == $option ){
					$checked = 'checked="checked"';
				}
				$html .= '<input id="' . esc_attr( $field['id'] ) . '" type="' . $field['type'] . '" name="' . esc_attr( $option_name ) . '" ' . $checked . '/>' . "\n";
			break;
			case 'checkbox_multi':
				foreach( $field['options'] as $k => $v ) {
					$checked = false;
					if( in_array( $k, $data ) ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="checkbox" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '[]" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
			break;
			case 'radio':
				foreach( $field['options'] as $k => $v ) {
					$checked = false;
					if( $k == $data ) {
						$checked = true;
					}
					$html .= '<label for="' . esc_attr( $field['id'] . '_' . $k ) . '"><input type="radio" ' . checked( $checked, true, false ) . ' name="' . esc_attr( $option_name ) . '" value="' . esc_attr( $k ) . '" id="' . esc_attr( $field['id'] . '_' . $k ) . '" /> ' . $v . '</label> ';
				}
			break;
			case 'select':
				$html .= '<select name="' . esc_attr( $option_name ) . '" id="' . esc_attr( $field['id'] ) . '">';
				foreach( $field['options'] as $k => $v ) {
					$selected = false;
					if( $k == $data ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '">' . $v . '</option>';
				}
				$html .= '</select> ';
			break;
			case 'select_multi':
				$html .= '<select name="' . esc_attr( $option_name ) . '[]" id="' . esc_attr( $field['id'] ) . '" multiple="multiple">';
				foreach( $field['options'] as $k => $v ) {
					$selected = false;
					if( in_array( $k, $data ) ) {
						$selected = true;
					}
					$html .= '<option ' . selected( $selected, true, false ) . ' value="' . esc_attr( $k ) . '" />' . $v . '</label> ';
				}
				$html .= '</select> ';
			break;
			case 'image':
				$image_thumb = '';
				if( $data ) {
					$image_thumb = wp_get_attachment_thumb_url( $data );
				}
				$html .= '<img id="' . $option_name . '_preview" class="image_preview" src="' . $image_thumb . '" /><br/>' . "\n";
				$html .= '<input id="' . $option_name . '_button" type="button" data-uploader_title="' . esc_html__( 'Upload an image' , 'wp-timeline' ) . '" data-uploader_button_text="' . esc_html__( 'Use image' , 'wp-timeline' ) . '" class="image_upload_button button" value="'. esc_html__( 'Upload new image' , 'wp-timeline' ) . '" />' . "\n";
				$html .= '<input id="' . $option_name . '_delete" type="button" class="image_delete_button button" value="'. esc_html__( 'Remove image' , 'wp-timeline' ) . '" />' . "\n";
				$html .= '<input id="' . $option_name . '" class="image_data_field" type="hidden" name="' . $option_name . '" value="' . $data . '"/><br/>' . "\n";
			break;
			case 'color':
				?><div class="color-picker" style="position:relative;">
			        <input type="text" name="<?php esc_attr_e( $option_name ); ?>" class="color" value="<?php esc_attr_e( $data ); ?>" />
			        <div style="position:absolute;background:#FFF;z-index:99;border-radius:100%;" class="colorpicker"></div>
			    </div>
			    <?php
			break;
		}
		switch( $field['type'] ) {
			case 'checkbox_multi':
			case 'radio':
			case 'select_multi':
				$html .= '<br/><span class="description">' . $field['description'] . '</span>';
			break;
			default:
				$html .= '<label for="' . esc_attr( $field['id'] ) . '"><span class="description">' . $field['description'] . '</span></label>' . "\n";
			break;
		}
		echo $html;
	}
	/**
	 * Validate individual settings field
	 * @param  string $data Inputted value
	 * @return string       Validated value
	 */
	public function validate_field( $data ) {
		if( $data && strlen( $data ) > 0 && $data != '' ) {
			$data = urlencode( strtolower( str_replace( ' ' , '-' , $data ) ) );
		}
		return $data;
	}
	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page() {
		// Build page HTML
		$html = '<div class="wrap" id="wp-timeline">' . "\n";
			$html .= '<h2>' . esc_html__( 'Timeline Settings' , 'wp-timeline' ) . '</h2>' . "\n";
			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";
				// Setup navigation
				$html .= '<ul id="settings-sections" class="subsubsub hide-if-no-js">' . "\n";
					//$html .= '<li><a class="tab all current" href="#standard">' . esc_html__( 'All' , 'wp-timeline' ) . '</a></li>' . "\n";
					foreach( $this->settings as $section => $data ) {
						$html .= '<li><a class="tab" href="#' . $section . '">' . $data['title'] . '</a> <span>|</span></li>' . "\n";
					}
				$html .= '</ul>' . "\n";
				$html .= '<div class="clear"></div>' . "\n";
				// Get settings fields
				ob_start();
				settings_fields( 'wp-timeline' );
				do_settings_sections( 'wp-timeline' );
				$html .= ob_get_clean();
				$html .= '<p class="submit">' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( esc_html__( 'Save Settings' , 'wp-timeline' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
			$html .= '</form>' . "\n";
		$html .= '</div>' . "\n";
		echo $html;
	}
}