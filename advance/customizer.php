<?php

//globals used by these functions
global $emeon_customizer_dependencies;

//here we will collect all dependencies to know where to show hide each control
$emeon_customizer_dependencies = array();


/**
 * Generates input, selects and other form controls
 * @param $option : currently processed option with all attributes
 * @param $args : pre-completed array of params for current control
 * @param $wp_customize : reference to $wp_customize
 * @return mixed : true if only array were completed, object for custom control
 */
function emeon_customizer_controls($option, &$args, &$wp_customize){
	switch( $option['type'] ) {
		/** @noinspection PhpMissingBreakStatementInspection */
		case 'code_editor':
			$args['code_type'] = 'text/css';

			global $wp_version;
			if ( version_compare( $wp_version, '4.9', '>=' ) ) {
				// WordPress version is greater than 4.9
				//this is description from "Additional CSS" section
				$args['input_attrs'] = array(
					'aria-describedby' => 'editor-keyboard-trap-help-1 editor-keyboard-trap-help-2 editor-keyboard-trap-help-3 editor-keyboard-trap-help-4'
				);


				$return = new WP_Customize_Code_Editor_Control( $wp_customize, $args['setting'], $args );

				break;
			}

		case 'textarea':
			$args['type']       = 'textarea';

			$return = true;
			break;

		case 'button-set':
			$args['choices'] = $option['options'];
			$args['multi']   = $option['multi'];

			$return = new Emeon_A13_Customize_Button_Set_Control( $wp_customize, $args['setting'], $args );

			break;

		case 'radio':
			$args['type']       = 'radio';
			$args['choices']    = $option['options'];

			$return = true;

			break;

		case 'select':
			$args['type']       = 'select';
			$args['choices']    = $option['options'];

			$return = true;
			break;

		case 'wp_dropdown_pages':
			$args['type']       = 'dropdown-pages';

			$return = true;
			break;

		case 'wp_dropdown_cpt_terms':
			$args['default']    = isset($option['default']) ? $option['default'] : '';
			$args['type']       = 'select';
			$args['choices']    = emeon_cpt_categories_list($option['for']);

			$return = true;

			break;

		case 'slider':
			$args['min']    = isset($option['min'])? $option['min'] : '';
			$args['max']    = isset($option['max'])? $option['max'] : '';
			$args['step']    = isset($option['step'])? $option['step'] : '';
			$args['unit']   = isset($option['unit'])? $option['unit'] : '';

			$return = new Emeon_A13_Customize_Slider_Control( $wp_customize, $args['setting'], $args);
			break;

		case 'color':
			$args['default']    = isset($option['default']) ? $option['default'] : '';

			$return = new Emeon_A13_Customize_Alpha_Color_Control( $wp_customize, $args['setting'], $args);
			break;

		case 'image':
			$args['default']    = isset($option['default']) ? $option['default'] : '';

			$return = new Emeon_A13_Customize_Image_Control( $wp_customize, $args['setting'], $args);
			break;

		case 'font':
			$args['default']    = isset($option['default']) ? $option['default'] : '';

			$return = new Emeon_A13_Customize_Font_Control( $wp_customize, $args['setting'], $args);
			break;

		case 'spacing':
			$args['default']    = isset($option['default']) ? $option['default'] : '';
			$args['mode']    = isset($option['mode']) ? $option['mode'] : '';
			$args['sides']    = isset($option['sides']) ? $option['sides'] : '';
			$args['units']    = isset($option['units']) ? $option['units'] : '';

			$return = new Emeon_A13_Customize_Spacing_Control( $wp_customize, $args['setting'], $args);
			break;

		case 'socials':
			$args['default'] = isset($option['default']) ? $option['default'] : '';
			$args['choices'] = $option['options'];

			$return = new Emeon_A13_Customize_Socials_Control( $wp_customize, $args['setting'], $args);
			break;

		case 'custom_sidebars':
			$args['default'] = isset($option['default']) ? $option['default'] : '';

			$return = new Emeon_A13_Customize_Sidebars_Control( $wp_customize, $args['setting'], $args);
			break;

		default:
			$args['type'] = $option['type'];
			if(isset($option['input_attrs'])){
				$args['input_attrs'] = $option['input_attrs'];
			}

			$return = true;
			break;
	}

	return $return;
}


/**
 * Registers all settings for customizer
 *
 * @param WP_Customize_Manager $wp_customize customizer object
 */
function emeon_customizer_settings( $wp_customize ) {
	global $emeon_a13, $emeon_customizer_dependencies;

	//make us some space and change priority from 10 to 30 for Site Identity section
	$title_tagline_section = $wp_customize->get_section( 'title_tagline' );
	$title_tagline_section->priority = 30;

	//include all custom controls
	get_template_part('advance/inc/customizer/controls/emeon-class-a13-customize-image-control');
	get_template_part('advance/inc/customizer/controls/emeon-class-a13-customize-alpha-color-control'); 
 	get_template_part('advance/inc/customizer/controls/emeon-class-a13-customize-button-set-control');
	get_template_part('advance/inc/customizer/controls/emeon-class-a13-customize-slider-control');
	get_template_part('advance/inc/customizer/controls/emeon-class-a13-customize-font-control');
	get_template_part('advance/inc/customizer/controls/emeon-class-a13-customize-spacing-control');	
	get_template_part('advance/inc/customizer/controls/emeon-class-a13-customize-socials-control');
	get_template_part('advance/inc/customizer/controls/emeon-class-a13-customize-sidebars-control');
 
	// Register the class so that JS template of controls is available in the Customizer.
	$wp_customize->register_control_type( 'Emeon_A13_Customize_Image_Control' );
	$wp_customize->register_control_type( 'Emeon_A13_Customize_Button_Set_Control' );
	$wp_customize->register_control_type( 'Emeon_A13_Customize_Slider_Control' );
	$wp_customize->register_control_type( 'Emeon_A13_Customize_Font_Control' );
	$wp_customize->register_control_type( 'Emeon_A13_Customize_Spacing_Control' );
	$wp_customize->register_control_type( 'Emeon_A13_Customize_Socials_Control' );
	$wp_customize->register_control_type( 'Emeon_A13_Customize_Sidebars_Control' );

	//sanitization functions
	get_template_part('advance/inc/customizer/sanitization');

	$customizer_structure = $emeon_a13->emeon_get_sections();
	foreach($customizer_structure as $panel){
		$section_priority = 0;

		if( isset($panel['companion_required']) && $panel['companion_required'] === true){
			if( !$emeon_a13->emeon_is_companion_plugin_ready(false, true) ){
				//we can not display these settings if there is no companion plugin available
				continue;
			}
		}
		if( isset($panel['woocommerce_required']) && $panel['woocommerce_required'] === true){
			if( !emeon_is_woocommerce_activated() ){
				//we can not display these settings if WooCommerce plugin is not available
				continue;
			}
		}

		$without_panel = false;
		//if we want to have section on front of customizer
		if( isset($panel['without_panel']) && $panel['without_panel'] === true){
			$sections = array( $panel );
			$without_panel = true;
		}
		else{
			//we group sections in panels
			$wp_customize->add_panel(
				$panel['id'],
				array(
					'title'         => $panel['title'],
					'description'   => $panel['desc'],
					'priority'      => $panel['priority'],
				)
			);
			$sections = $panel['sections'];
		}


		foreach( $sections as $section) {
			$wp_customize->add_section(
				$section['id'],
				array(
					'panel'         => $without_panel ? null : $panel['id'],
					'title'         => $section['title'],
					'description'   => isset($section['desc']) ? $section['desc'] : '',
					'priority'      => $without_panel ? $panel['priority'] : $section_priority++,
				)
			);

			//reset counter
			$control_priority = 0;
			foreach( $section['fields'] as $field) {

				$post_message = ( isset( $field['partial'] ) && ( $field['partial'] === true || is_array( $field['partial'] ) ) ) ||
				                ( isset( $field['js'] ) && $field['js'] === true );

				//default sanitization
				if($field['type'] === 'select' || $field['type'] === 'radio'){
					$field['sanitize'] = 'options';
				}
				elseif($field['type'] === 'color'){
					$field['sanitize'] = 'color';
				}
				elseif($field['type'] === 'image'){
					$field['sanitize'] = 'image';
				}
				elseif($field['type'] === 'text'){
					$field['sanitize'] = 'esc_html';
				}
				elseif($field['type'] === 'textarea'){
					$field['sanitize'] = 'wp_kses_data';
				}

				//register setting
				$setting_name = EMEON_OPTIONS_NAME.'['.$field['id'].']';
				$wp_customize->add_setting( $setting_name, array(
					'default'           => $emeon_a13->theme_options_defaults[ $field['id'] ],
					'type'              => 'option',
					'sanitize_callback' => isset($field['sanitize']) ? 'emeon_sanitize_'.$field['sanitize'] : '',
					'transport'         => $post_message ? 'postMessage' : 'refresh'
				) );

				$control_args = array(
					'label'       => $field['title'],
					'description' => isset($field['description'])? $field['description'] : '',
					'section'     => $section['id'],
					'setting'     => $setting_name,
					'priority'    => $control_priority++,
					'active_callback' => isset( $field['active_callback'] ) ? $field['active_callback'] : null
				);

				//control needs other controls on particular values?
				if ( isset( $field['required'] ) ) {
					//it checks for dependency on other settings
					$control_args['active_callback'] = 'emeon_customizer_activate_callback';
					$emeon_customizer_dependencies[ $field['id'] ] = $field['required'];
				}

				$control = emeon_customizer_controls( $field, $control_args, $wp_customize );

				if ( $control === true ) {
					$wp_customize->add_control( $setting_name, $control_args );
				}
				elseif ( is_object( $control ) ) {
					$wp_customize->add_control( $control );
				}

				if(isset($field['partial']) && is_array($field['partial'])){
					if(isset($field['partial']['settings'])){
						//make sure we have proper settings names
						foreach($field['partial']['settings'] as &$_setting){
							$_setting = EMEON_OPTIONS_NAME.'['.$_setting.']';
						}
						unset($_setting);
					}

					$wp_customize->selective_refresh->add_partial( $setting_name, $field['partial'] );
				}
			}
		}
	}
}
add_action( 'customize_register', 'emeon_customizer_settings' );



/**
 *
 * Checks if single dependency is met
 * @param array $requirement dependency
 *
 * @return bool result
 */
function emeon_customizer_compare_dependency($requirement){
	global $emeon_a13;

	$id = $requirement[0];
    $operator = $requirement[1];
    $value    = $requirement[2];
	$field_value = $emeon_a13->get_option($id,'',false);

    //check operators
    if($operator === '='){
        return $value === $field_value;
    }
    else if($operator === '!='){
        return $value !== $field_value;
    }

    //for all other operators
    return false;
}



/**
 * checks if control should be visible on page load
 * @param $control
 *
 * @return bool
 */
function emeon_customizer_activate_callback($control) {
	global $emeon_customizer_dependencies;

	//lets get field ID
	$matches = array();
	preg_match('/'.EMEON_OPTIONS_NAME.'\[([a-z0-9_]+)\]/', $control->id, $matches);

	if(strlen($matches[0])){
		//get requirements from global table
		$requirement = $emeon_customizer_dependencies[ $matches[1] ];

		//control have many requirements
		if ( is_array( $requirement[0] ) ) {
			for ( $i = 0; $i < sizeof( $requirement ); $i ++ ) {
				if ( ! emeon_customizer_compare_dependency( $requirement[ $i ] ) ) {
					return false; //some dependency were not met
				}
			}
		}
		//single requirement
		else {
			return emeon_customizer_compare_dependency( $requirement );
		}
	}

	//let field be visible in any other case
	return true;
}



/**
 * adds JS file to run in customizer for controls
 */
add_action( 'customize_controls_enqueue_scripts', 'emeon_customizer_controls_js');
function emeon_customizer_controls_js(){
	global $emeon_a13, $emeon_customizer_dependencies;

	wp_enqueue_script('emeon-a13-customize-controls', get_theme_file_uri( 'js/customize-controls.js' ),
		array( 'jquery', 'emeon-admin' ),
		EMEON_THEME_VERSION,
		true
	);

	//prepare JS dependencies
	$js_dependencies = array(
		'switches' => array(),
		'dependencies' => $emeon_customizer_dependencies
	);
	foreach($emeon_customizer_dependencies as $field => $dependency){
		//control have many requirements
		if ( is_array( $dependency[0] ) ) {
			for ( $i = 0; $i < sizeof( $dependency ); $i ++ ) {
				$js_dependencies['switches'][$dependency[$i][0]][] = $field;
			}
		}
		//single requirement
		else {
			$js_dependencies['switches'][$dependency[0]][] = $field;
		}
	}

	wp_add_inline_script( 'emeon-a13-customize-controls', 'A13_CUSTOMIZER_DEPENDENCIES = '.wp_json_encode($js_dependencies));

	$google_fonts_file = get_template_directory().'/advance/inc/google-fonts-json.php';
	$n_google_fonts_file = get_theme_file_path( 'advance/inc/google-fonts-json.php');

	$human_variants = array(
		'100' => esc_html__( 'thin', 'emeon' ),
		'200' => esc_html__( 'extra-light', 'emeon' ),
		'300' => esc_html__( 'light', 'emeon' ),
		'400' => esc_html__( 'regular', 'emeon' ),
		'500' => esc_html__( 'medium', 'emeon' ),
		'600' => esc_html__( 'semi-bold', 'emeon' ),
		'700' => esc_html__( 'bold', 'emeon' ),
		'800' => esc_html__( 'extra-bold', 'emeon' ),
		'900' => esc_html__( 'black', 'emeon' ),
	);

	$skt_params = array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'options_name' => EMEON_OPTIONS_NAME,
		'standard_fonts' => wp_json_encode($emeon_a13->emeon_get_standard_fonts_list()),		
		'google_fonts' => require get_template_directory() . '/advance/inc/google-fonts-json.php', //phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		'human_font_variants' => wp_json_encode($human_variants)
	);
	
	wp_localize_script( 'emeon-a13-customize-controls', 'EmeonA13FECustomizerControls', apply_filters( 'emeon_customizer_script_params', $skt_params ) );
}



/**
 * adds JS file to run in customizer for preview
 */
add_action( 'customize_preview_init', 'emeon_customizer_preview_js');
function emeon_customizer_preview_js(){
	wp_enqueue_script('emeon-a13-customize-preview', get_theme_file_uri( 'js/customize-preview.js' ),
		array( 'customize-preview', 'jquery' ),
		EMEON_THEME_VERSION,
		true
	);

	$skt_params = array(
		'options_name' => EMEON_OPTIONS_NAME,
		'cursors'    => get_theme_file_uri( 'images/cursors/')
	);
	wp_localize_script( 'emeon-a13-customize-preview', 'A13FECustomizerPreview', $skt_params );

	wp_enqueue_style( 'emeon-a13-customize-preview', get_theme_file_uri( 'css/customize-preview.css'), false, EMEON_THEME_VERSION);
}



/**
 * Prints user.css plus its inline styles in footer as inline styles
 */
add_action( 'wp_footer', 'emeon_customizer_preview_css', 21);
function emeon_customizer_preview_css(){
	global $wp_styles;
	//CSS
	emeon_enable_user_css_functions();
	$css = emeon_get_user_css(false);
	//all the settings from theme options that generates CSS
	echo '<style type="text/css" media="all" id="user-css-inlined">'.wp_kses_post($css).'</style>';
	//only custom CSS - so we can update it live
	echo '<style type="text/css" media="all" id="user-custom-css">'.wp_kses_post(emeon_user_custom_css()).'</style>';

	//print inline styles
	$wp_styles->print_inline_style('emeon-a13-user-css');
}



/**
 * Prints user.css dependencies in customizer
 */
add_action( 'wp_enqueue_scripts', 'emeon_customizer_user_css_dependencies', 100);
function emeon_customizer_user_css_dependencies(){
	global $wp_styles;
	$user_css_deps = $wp_styles->registered['emeon-a13-user-css']->deps;
	foreach($user_css_deps as $style){
		wp_enqueue_style($style);
	}
}



/**
 * prints icons selector
 */
add_action( 'customize_controls_print_footer_scripts', 'emeon_admin_footer' );
function emeon_customizer_footer() {
	echo '<div id="a13-fa-icons">';
	/** @noinspection PhpIncludeInspection */
	$classes = get_template_part( 'advance/inc/font-awesome-icons' );
	foreach($classes as $name){
		$name = trim($name);
		echo '<span class="a13-font-icon fa fa-'.esc_attr( $name ).'" title="'.esc_attr( $name ).'"></span>'."\n";
	}
	echo '</div>';
}


function emeon_prepare_partial_css($response, $option, $function) {
	$partial_name = EMEON_OPTIONS_NAME.'['.$option.']';
	if(isset($response['contents'][$partial_name])){
		$css_option_id = EMEON_OPTIONS_NAME.'-'.$option;
		$response['contents'][$partial_name][] = '<style id="'.$css_option_id.'" type="text/css">'.$function().'</style>';
	}

	return $response;
}