<?php
function emeon_setup_theme_options() {
	global $emeon_a13;

	//get all cursors
	$cursors = array(
		'christmas.png'         => 'christmas.png',
		'empty_black.png'       => 'empty_black.png',
		'empty_black_white.png' => 'empty_black_white.png',
		'superior_cursor.png'   => 'superior_cursor.png'
	);
	$emeon_a13->emeon_set_settings_set( 'cursors', $cursors );
	
	//get all menu effects
	$menu_effects = array(
		'none'      => esc_html__( 'None', 'emeon' ),
		'ferdinand' => 'ferdinand'
	);
	$emeon_a13->emeon_set_settings_set( 'menu_effects', $menu_effects );

	//get all custom sidebars
	$header_sidebars = $emeon_a13->get_option( 'custom_sidebars' );
	if ( ! is_array( $header_sidebars ) ) {
		$header_sidebars = array();
	}
	//create 2 arrays for different purpose
	$header_sidebars            = array_merge( array( 'off' => esc_html__( 'Off', 'emeon' ) ), $header_sidebars );
	$header_sidebars_off_global = array_merge( array( 'G' => esc_html__( 'Global settings', 'emeon' ) ), $header_sidebars );
	//re-indexing these arrays
	array_unshift( $header_sidebars, null );
	unset( $header_sidebars[0] );
	array_unshift( $header_sidebars_off_global, null );
	unset( $header_sidebars_off_global[0] );
	$emeon_a13->emeon_set_settings_set( 'header_sidebars', $header_sidebars );
	$emeon_a13->emeon_set_settings_set( 'header_sidebars_off_global', $header_sidebars_off_global );

	$on_off = array(
		'on'  => esc_html__( 'Enable', 'emeon' ),
		'off' => esc_html__( 'Disable', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'on_off', $on_off );

	$font_weights = array(
		'100'    => esc_html__( '100', 'emeon' ),
		'200'    => esc_html__( '200', 'emeon' ),
		'300'    => esc_html__( '300', 'emeon' ),
		'normal' => esc_html__( 'Normal 400', 'emeon' ),
		'500'    => esc_html__( '500', 'emeon' ),
		'600'    => esc_html__( '600', 'emeon' ),
		'bold'   => esc_html__( 'Bold 700', 'emeon' ),
		'800'    => esc_html__( '800', 'emeon' ),
		'900'    => esc_html__( '900', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'font_weights', $font_weights );

	$font_transforms = array(
		'none'      => esc_html__( 'None', 'emeon' ),
		'uppercase' => esc_html__( 'Uppercase', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'font_transforms', $font_transforms );

	$text_align = array(
		'left'   => esc_html__( 'Left', 'emeon' ),
		'center' => esc_html__( 'Center', 'emeon' ),
		'right'  => esc_html__( 'Right', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'text_align', $text_align );

	$image_fit = array(
		'cover'    => esc_html__( 'Cover', 'emeon' ),
		'contain'  => esc_html__( 'Contain', 'emeon' ),
		'fitV'     => esc_html__( 'Fit Vertically', 'emeon' ),
		'fitH'     => esc_html__( 'Fit Horizontally', 'emeon' ),
		'center'   => esc_html__( 'Just center', 'emeon' ),
		'repeat'   => esc_html__( 'Repeat', 'emeon' ),
		'repeat-x' => esc_html__( 'Repeat X', 'emeon' ),
		'repeat-y' => esc_html__( 'Repeat Y', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'image_fit', $image_fit );
	
	$slider_type_select = array(
		'default_slider'    => esc_html__( 'Default Slider', 'emeon' ),
		'custom_slider'  	=> esc_html__( 'Custom Slider', 'emeon' ),
		'disable_slider'    => esc_html__( 'Disable Slider', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'slider_type_select', $slider_type_select );		

	$content_layouts = array(
		'center'        => esc_html__( 'Center fixed width', 'emeon' ),
		'left'          => esc_html__( 'Left fixed width', 'emeon' ),
		'left_padding'  => esc_html__( 'Left fixed width + padding', 'emeon' ),
		'right'         => esc_html__( 'Right fixed width', 'emeon' ),
		'right_padding' => esc_html__( 'Right fixed width + padding', 'emeon' ),
		'full_fixed'    => esc_html__( 'Full width + fixed content', 'emeon' ),
		'full_padding'  => esc_html__( 'Full width + padding', 'emeon' ),
		'full'          => esc_html__( 'Full width', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'content_layouts', $content_layouts );

	$parallax_types = array(
		"tb"   => esc_html__( 'top to bottom', 'emeon' ),
		"bt"   => esc_html__( 'bottom to top', 'emeon' ),
		"lr"   => esc_html__( 'left to right', 'emeon' ),
		"rl"   => esc_html__( 'right to left', 'emeon' ),
		"tlbr" => esc_html__( 'top-left to bottom-right', 'emeon' ),
		"trbl" => esc_html__( 'top-right to bottom-left', 'emeon' ),
		"bltr" => esc_html__( 'bottom-left to top-right', 'emeon' ),
		"brtl" => esc_html__( 'bottom-right to top-left', 'emeon' ),
	);

	$content_under_header = array(
		'content' => esc_html__( 'Yes, hide the content', 'emeon' ),
		'title'   => esc_html__( 'Yes, hide the content and add top padding to the outside title bar.', 'emeon' ),
		'off'     => esc_html__( 'Turn it off', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'content_under_header', $content_under_header );

	$social_colors = array(
		'black'            => esc_html__( 'Black', 'emeon' ),
		'color'            => esc_html__( 'Color', 'emeon' ),
		'white'            => esc_html__( 'White', 'emeon' ),
		'semi-transparent' => esc_html__( 'Semi transparent', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'social_colors', $social_colors );

	$bricks_hover = array(
		'cross'      => esc_html__( 'Show cross', 'emeon' ),
		'drop'       => esc_html__( 'Drop', 'emeon' ),
		'shift'      => esc_html__( 'Shift', 'emeon' ),
		'pop'        => esc_html__( 'Pop text', 'emeon' ),
		'border'     => esc_html__( 'Border', 'emeon' ),
		'scale-down' => esc_html__( 'Scale down', 'emeon' ),
		'none'       => esc_html__( 'None', 'emeon' ),
	);
	$emeon_a13->emeon_set_settings_set( 'bricks_hover', $bricks_hover );

	//tags allowed in descriptions
	$valid_tags = array(
		'a'      => array(
			'href' => array(),
		),
		'br'     => array(),
		'code'   => array(),
		'em'     => array(),
		'strong' => array(),
	);
	$emeon_a13->emeon_set_settings_set( 'valid_tags', $valid_tags );
	/*
	 *
	 * ---> START SECTIONS
	 *
	 */

//GENERAL SETTINGS
	$emeon_a13->emeon_set_sections( array(
		'title'    => esc_html__( 'General settings', 'emeon' ),
		'desc'     => '',
		'id'       => 'section_general_settings',
		'icon'     => 'el el-adjust-alt',
		'priority' => 3,
		'fields'   => array()
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Front page', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_general_front_page',
		'icon'       => 'fa fa-home',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'fp_variant',
				'type'        => 'select',
				'title'       => esc_html__( 'What to show on the front page?', 'emeon' ),
				/* translators: %s: URL */
				'description' => sprintf( wp_kses( __( 'If you choose <strong>Page</strong> then make sure that in <a href="%s">WordPress Homepage Settings</a> you have selected <strong>A static page</strong>, that you wish to use as the front page.', 'emeon' ), $valid_tags ), 'javascript:wp.customize.section( \'static_front_page\' ).focus();' ),
				'options'     => array(
					'page'         => esc_html__( 'Page', 'emeon' ),
					'blog'         => esc_html__( 'Blog', 'emeon' ),
				),
				'default'     => 'page',

			),
		)
	) );
	
	/* SLIDER START */
	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Slider', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_slider',
		'icon'       => 'fa fa-wrench',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'custom_slider_option',
				'type'    => 'radio',
				'title'   => esc_html__( 'Slider Type', 'emeon' ),
				'options' => array(
					'defaultslide' => esc_html__( 'Default', 'emeon' ),
					'customslide'  => esc_html__( 'Custom', 'emeon' ),
					'disableslide'  => esc_html__( 'Disable', 'emeon' )
				),
				'default' => 'disableslide',
				'js'      => true,
			),
			array(
				'id'          => 'slide_title_fonts',
				'type'        => 'font',
				'title'       => esc_html__( 'Slide Title Font Family:', 'emeon' ),
				'default'     => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal',
					'font-variant' => '600'
				),
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'          => 'slide_description_fonts',
				'type'        => 'font',
				'title'       => esc_html__( 'Slide Description Font Family:', 'emeon' ),
				'default'     => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),
			array(
				'id'          => 'slide_button_fonts',
				'type'        => 'font',
				'title'       => esc_html__( 'Slide Button Font Family:', 'emeon' ),
				'default'     => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_title_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Slide Title', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ),
				'min'     => 10,
				'step'    => 1,
				'max'     => 100,
				'unit'    => 'px',
				'default' => 42,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),
			array(
				'id'      => 'slide_description_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Slide Description', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ),
				'min'     => 10,
				'step'    => 1,
				'max'     => 100,
				'unit'    => 'px',
				'default' => 18,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_button_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Slide Button', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ),
				'min'     => 10,
				'step'    => 1,
				'max'     => 100,
				'unit'    => 'px',
				'default' => 18,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_title_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Slide Title', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'default' => '#282828',
				'partial' => true,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_description_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Slide Description', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'default' => '#282828',
				'partial' => true,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_button_text_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Slide Button Text', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'default' => '#ffffff',
				'partial' => true,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_button_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Slide Button Background', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'default' => '#fe911c',
				'partial' => true,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_button_hover_text_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Slide Button Hover Text', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'default' => '#282828',
				'partial' => true,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_button_hover_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Slide Button Hover Background', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'default' => '#fd4c1c',
				'partial' => true,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_pager_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Slide Pager', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'default' => '#003de4',
				'partial' => true,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),	
			array(
				'id'      => 'slide_active_pager_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Slide Active Pager', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'default' => '#fd4c1c',
				'partial' => true,
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
			),
			array(
				'id'       => 'slide_image1',
				'type'     => 'image',
				'title'    => esc_html__( 'Slide Image 1', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_title1',
				'type'     => 'text',
				'title'    => esc_html__( 'Slide Title 1', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_description1',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Slide Description 1', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_link1',
				'type'     => 'text',
				'title'    => esc_html__( 'Slide Link 1', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_button1',
				'type'     => 'text',
				'title'    => esc_html__( 'Slide Button 1', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_image2',
				'type'     => 'image',
				'title'    => esc_html__( 'Slide Image 2', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_title2',
				'type'     => 'text',
				'title'    => esc_html__( 'Slide Title 2', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_description2',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Slide Description 2', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_link2',
				'type'     => 'text',
				'title'    => esc_html__( 'Slide Link 2', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_button2',
				'type'     => 'text',
				'title'    => esc_html__( 'Slide Button 2', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_image3',
				'type'     => 'image',
				'title'    => esc_html__( 'Slide Image 3', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_title3',
				'type'     => 'text',
				'title'    => esc_html__( 'Slide Title 3', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_description3',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Slide Description 3', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_link3',
				'type'     => 'text',
				'title'    => esc_html__( 'Slide Link 3', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),
			array(
				'id'       => 'slide_button3',
				'type'     => 'text',
				'title'    => esc_html__( 'Slide Button 3', 'emeon' ),
				'default'  => '',
				'required' => array( 'custom_slider_option', '=', 'defaultslide' ),
				'js'       => true,
			),																												
			array(
				'id'       => 'customslide',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Custom Slider Shortcode', 'emeon' ),
				'required' => array( 'custom_slider_option', '=', 'customslide' ),
				'js'       => true,
			),
		)
	) );
	
	/* SLIDER END */	

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'General layout', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_main_settings',
		'icon'       => 'fa fa-wrench',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'appearance_body_image',
				'type'    => 'image',
				'title'   => esc_html__( 'Background image', 'emeon' ),
				'partial' => array(
					'selector'            => '.page-background',
					'container_inclusive' => true,
					'settings'            => array(
						'appearance_body_image',
						'appearance_body_image_fit',
						'appearance_body_bg_color',
					),
					'render_callback'     => 'emeon_page_background',
				),
			),
			array(
				'id'      => 'appearance_body_image_fit',
				'type'    => 'select',
				'title'   => esc_html__( 'How to fit the background image', 'emeon' ),
				'options' => $image_fit,
				'default' => 'cover',
				'partial' => true,
			),
			array(
				'id'      => 'appearance_body_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'emeon' ),
				'default' => '#ffffff',
				'partial' => true,
			),
			array(
				'id'          => 'layout_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Layout', 'emeon' ),
				'options'     => array(
					'full' => esc_html__( 'Full width', 'emeon' ),
				),
				'default'     => 'full',
			),
			array(
				'id'      => 'custom_cursor',
				'type'    => 'radio',
				'title'   => esc_html__( 'Mouse cursor', 'emeon' ),
				'options' => array(
					'default' => esc_html__( 'Normal', 'emeon' ),
					'select'  => esc_html__( 'Predefined', 'emeon' ),
					'custom'  => esc_html__( 'Custom', 'emeon' ),
				),
				'default' => 'default',
				'js'      => true,
			),
			array(
				'id'       => 'cursor_select',
				'type'     => 'select',
				'title'    => esc_html__( 'Cursor', 'emeon' ),
				'options'  => $cursors,
				'default'  => 'empty_black_white.png',
				'required' => array( 'custom_cursor', '=', 'select' ),
				'js'       => true,
			),
			array(
				'id'       => 'cursor_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Custom cursor image', 'emeon' ),
				'required' => array( 'custom_cursor', '=', 'custom' ),
				'js'       => true,
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Page preloader', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_page_preloader',
		'icon'       => 'fa fa-spinner',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'preloader',
				'type'        => 'radio',
				'title'       => esc_html__( 'Page preloader', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
				'js'          => true,
			),
			array(
				'id'          => 'preloader_hide_event',
				'type'        => 'radio',
				'title'       => esc_html__( 'Hide event', 'emeon' ),
				'description' => wp_kses( __( '<strong>On load</strong> is called when the whole site, with all the images, is loaded, which can take a lot of time on heavier sites, and even more time on mobile devices. Also,  it can sometimes hang and never hide the preloader, when there is a problem with some resource. <br /><strong>On DOM ready</strong> is called when the whole HTML with CSS is loaded, so after the preloader is hidden, you can still see the loading of images. This is a much safer option.', 'emeon' ), $valid_tags ),
				'options'     => array(
					'ready' => esc_html__( 'On DOM ready', 'emeon' ),
					'load'  => esc_html__( 'On load', 'emeon' ),
				),
				'default'     => 'ready',
				'required'    => array( 'preloader', '=', 'on' ),
				'js'          => true,
			),
			array(
				'id'       => 'preloader_bg_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'required' => array( 'preloader', '=', 'on' ),
				'partial'  => array(
					'selector'            => '#preloader',
					'container_inclusive' => true,
					'settings'            => array(
						'preloader_bg_image',
						'preloader_bg_image_fit',
						'preloader_bg_color',
						'preloader_type',
						'preloader_color',
					),
					'render_callback'     => 'emeon_page_preloader',
				),
			),
			array(
				'id'       => 'preloader_bg_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'cover',
				'required' => array( 'preloader', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'preloader_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'emeon' ),
				'default'  => '',
				'required' => array( 'preloader', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'preloader_type',
				'type'     => 'select',
				'title'    => esc_html__( 'Type', 'emeon' ),
				'options'  => array(
					'none'              => esc_html__( 'none', 'emeon' ),
					'atom'              => esc_html__( 'Atom', 'emeon' ),
					'flash'             => esc_html__( 'Flash', 'emeon' ),
					'indicator'         => esc_html__( 'Indicator', 'emeon' ),
					'radar'             => esc_html__( 'Radar', 'emeon' ),
					'circle_illusion'   => esc_html__( 'Circle Illusion', 'emeon' ),
					'square_of_squares' => esc_html__( 'Square of squares', 'emeon' ),
					'plus_minus'        => esc_html__( 'Plus minus', 'emeon' ),
					'hand'              => esc_html__( 'Hand', 'emeon' ),
					'blurry'            => esc_html__( 'Blurry', 'emeon' ),
					'arcs'              => esc_html__( 'Arcs', 'emeon' ),
					'tetromino'         => esc_html__( 'Tetromino', 'emeon' ),
					'infinity'          => esc_html__( 'Infinity', 'emeon' ),
					'cloud_circle'      => esc_html__( 'Cloud circle', 'emeon' ),
					'dots'              => esc_html__( 'Dots', 'emeon' ),
					'jet_pack_man'      => esc_html__( 'Jet-Pack-Man', 'emeon' ),
					'circle'            => 'Circle'
				),
				'default'  => 'flash',
				'required' => array( 'preloader', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'preloader_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Animation color', 'emeon' ),
				'required' => array(
					array( 'preloader', '=', 'on' ),
					array( 'preloader_type', '!=', 'tetromino' ),
					array( 'preloader_type', '!=', 'blurry' ),
					array( 'preloader_type', '!=', 'square_of_squares' ),
					array( 'preloader_type', '!=', 'circle_illusion' ),
				),
				'default'  => '',
				'partial'  => true,
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Theme Header', 'emeon' ),
		'desc'       => esc_html__( 'Theme header is a place where you usually find the logo of your site, main menu, and a few other elements.', 'emeon' ),
		'id'         => 'subsection_header',
		'icon'       => 'fa fa-ellipsis-h',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'header_switch',
				'type'    => 'radio',
				'title'   => esc_html__( 'Theme Header', 'emeon' ),
				'description' => esc_html__( 'If you do not plan to use theme header or want to replace it with something else, just disable it here.', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			)
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Footer', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_footer',
		'icon'       => 'fa fa-ellipsis-h',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'footer_switch',
				'type'    => 'radio',
				'title'   => esc_html__( 'Footer', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
				'partial'     => array(
					'selector'            => '#footer',
					'container_inclusive' => true,
					'settings'            => array(
						'footer_switch',
						'footer_widgets_columns',
						'footer_text',
						'footer_privacy_link',
						'footer_content_width',
						'footer_content_style',
						'footer_bg_color',
						'footer_lower_bg_color',
						'footer_lower_bg_color',
						'footer_widgets_color',
						'footer_font_size',
						'footer_widgets_font_size',
						'footer_font_color',
						'footer_link_color',
						'footer_hover_color',
					),
					'render_callback'     => 'emeon_theme_footer',
				),
			),
			array(
				'id'          => 'footer_logo',
				'type'        => 'image',
				'title'       => esc_html__( 'Footer Logo', 'emeon' ),
				'default'     => '',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_logo_link',
				'type'        => 'text',
				'title'       => esc_html__( 'Footer Logo Link', 'emeon' ),
				'default'     => '',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'       => 'footer_widgets_columns',
				'type'     => 'select',
				'title'    => esc_html__( 'Widgets columns number', 'emeon' ),
				'options'  => array(
					'1' => esc_html__( '1', 'emeon' ),
					'2' => esc_html__( '2', 'emeon' ),
					'3' => esc_html__( '3', 'emeon' ),
					'4' => esc_html__( '4', 'emeon' ),
					'5' => esc_html__( '5', 'emeon' ),
				),
				'default'  => '4',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'          => 'footer_text',
				'type'        => 'textarea',
				'title'       => esc_html__( 'Content', 'emeon' ),
				'description' => esc_html__( 'You can use HTML here.', 'emeon' ),
				'default'     => '',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_privacy_link',
				'type'        => 'radio',
				'title'       => esc_html__( 'Privacy Policy Link', 'emeon' ),
				'description' => esc_html__( 'Since WordPress 4.9.6 there is an option to set Privacy Policy page. If you enable this option it will display a link to it in the footer after footer content.', 'emeon' ).' <a href="'.esc_url( admin_url( 'options-privacy.php' ) ).'">'.esc_html__( 'Here you can set your Privacy Policy page', 'emeon' ).'</a>',
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_socials',
				'type'        => 'radio',
				'title'       => esc_html__( 'Social icons', 'emeon' ),
				/* translators: %s: URL */
				'description' => sprintf( wp_kses( __( 'If you need to edit social links go to <a href="%s">Social icons</a> settings.', 'emeon' ), $valid_tags ), 'javascript:wp.customize.section( \'section_social\' ).focus();' ),
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => array(
					'selector'            => '.f-links',
					'container_inclusive' => true,
					'settings'            => array(
						'footer_socials',
						'footer_socials_color',
						'footer_socials_color_hover',
					),
					'render_callback'     => 'footer_socials'
				),
			),
			array(
				'id'       => 'footer_socials_color',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'options'  => $social_colors,
				'default'  => 'white',
				'required' => array(
					array( 'footer_switch', '=', 'on' ),
					array( 'footer_socials', '=', 'on' ),
				),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_socials_color_hover',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'options'  => $social_colors,
				'default'  => 'semi-transparent',
				'required' => array(
					array( 'footer_switch', '=', 'on' ),
					array( 'footer_socials', '=', 'on' ),
				),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_content_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Content', 'emeon' ). ' : ' .esc_html__( 'Width', 'emeon' ),
				'options'  => array(
					'narrow' => esc_html__( 'Narrow', 'emeon' ),
					'full'   => esc_html__( 'Full width', 'emeon' ),
				),
				'default'  => 'narrow',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_content_style',
				'type'     => 'radio',
				'title'    => esc_html__( 'Content', 'emeon' ). ' : ' .esc_html__( 'Style', 'emeon' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic', 'emeon' ),
					'centered' => esc_html__( 'Centered', 'emeon' ),
				),
				'default'  => 'classic',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_socials_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Footer Social Icon Background color', 'emeon' ),
				'default'  => '#000000',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),			
			array(
				'id'       => 'footer_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'emeon' ),
				'default'  => '#f3f7fc',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_lower_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Lower part', 'emeon' ). ' : ' .esc_html__( 'Background color', 'emeon' ),
				'desc'     => esc_html__( 'If you want to have a different color in the lower part than in the footer widgets.', 'emeon' ),
				'default'  => '#ebf1f8',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_widgets_color',
				'type'     => 'radio',
				'title'    => esc_html__( 'Widgets colors', 'emeon' ),
				'desc'     => esc_html__( 'Depending on what background you have set up, choose proper option.', 'emeon' ),
				'options'  => array(
					'dark-sidebar'  => esc_html__( 'On dark', 'emeon' ),
					'light-sidebar' => esc_html__( 'On light', 'emeon' ),
				),
				'default'  => 'dark-sidebar',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Lower part', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ),
				'default'  => 10,
				'min'      => 10,
				'max'      => 30,
				'step'     => 1,
				'unit'     => 'px',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'       => 'footer_widgets_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Widgets part', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ),
				'default'  => 10,
				'min'      => 10,
				'max'      => 30,
				'step'     => 1,
				'unit'     => 'px',
				'required' => array( 'footer_switch', '=', 'on' ),
				'partial'  => true,
			),
			array(
				'id'          => 'footer_font_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Lower part', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'description' => esc_html__( 'Does not work for footer widgets.', 'emeon' ),
				'default'     => '#282828',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_link_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Lower part', 'emeon' ). ' : ' .esc_html__( 'Links', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'description' => esc_html__( 'Does not work for footer widgets.', 'emeon' ),
				'default'     => '#fe4c1c',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
			array(
				'id'          => 'footer_hover_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Lower part', 'emeon' ). ' : ' .esc_html__( 'Links', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'description' => esc_html__( 'Does not work for footer widgets.', 'emeon' ),
				'default'     => '#ffffff',
				'required'    => array( 'footer_switch', '=', 'on' ),
				'partial'     => true,
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Hidden sidebar', 'emeon' ),
		'desc'       => esc_html__( 'It is active only if it contains active widgets. After activation, displays the opening button in the header.', 'emeon' ),
		'id'         => 'subsection_hidden_sidebar',
		'icon'       => 'fa fa-columns',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'      => 'hidden_sidebar_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'emeon' ),
				'default' => '',
			),
			array(
				'id'      => 'hidden_sidebar_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Font size', 'emeon' ),
				'default' => 10,
				'min'     => 5,
				'max'     => 30,
				'step'    => 1,
				'unit'    => 'px',
			),
			array(
				'id'          => 'hidden_sidebar_widgets_color',
				'type'        => 'radio',
				'title'       => esc_html__( 'Widgets colors', 'emeon' ),
				'description' => esc_html__( 'Depending on what background you have set up, choose proper option.', 'emeon' ),
				'options'     => array(
					'dark-sidebar'  => esc_html__( 'On dark', 'emeon' ),
					'light-sidebar' => esc_html__( 'On light', 'emeon' ),
				),
				'default'     => 'dark-sidebar',
			),
			array(
				'id'      => 'hidden_sidebar_side',
				'type'    => 'radio',
				'title'   => esc_html__( 'Side', 'emeon' ),
				'options' => array(
					'left'  => esc_html__( 'Left', 'emeon' ),
					'right' => esc_html__( 'Right', 'emeon' ),
				),
				'default' => 'left',
			),
			array(
				'id'      => 'hidden_sidebar_effect',
				'type'    => 'select',
				'title'   => esc_html__( 'Opening effect', 'emeon' ),
				'options' => array(
					'1' => esc_html__( 'Slide in on top', 'emeon' ),
					'2' => esc_html__( 'Reveal', 'emeon' ),
					'3' => esc_html__( 'Push', 'emeon' ),
					'4' => esc_html__( 'Slide along', 'emeon' ),
					'5' => esc_html__( 'Reverse slide out', 'emeon' ),
					'6' => esc_html__( 'Fall down', 'emeon' ),
				),
				'default' => '2',
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Fonts settings', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_fonts_settings',
		'icon'       => 'fa fa-font',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'nav_menu_fonts',
				'type'        => 'font',
				'title'       => esc_html__( 'Font for main navigation menu and overlay menu:', 'emeon' ),
				'default'     => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
			),
			array(
				'id'          => 'titles_fonts',
				'type'        => 'font',
				'title'       => esc_html__( 'Font for Titles/Headings:', 'emeon' ),
				'default'     => array(
					'font-family'    => 'Poppins',
					'font-weight'    => '700',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
			),
			array(
				'id'          => 'normal_fonts',
				'type'        => 'font',
				'title'       => esc_html__( 'Font for normal(content) text:', 'emeon' ),
				'default'     => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
			),
			array(
				'id'      => 'logo_fonts',
				'type'    => 'font',
				'title'   => esc_html__( 'Font for text logo:', 'emeon' ),
				'default' => array(
					'font-family'    => 'Poppins',
					'word-spacing'   => 'normal',
					'letter-spacing' => 'normal'
				),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Headings', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_heading_styles',
		'icon'       => 'fa fa-header',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'      => 'headings_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'emeon' ),
				'default' => '',
			),
			array(
				'id'      => 'headings_color_hover',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '',
			),
			array(
				'id'      => 'headings_weight',
				'type'    => 'select',
				'title'   => esc_html__( 'Font weight', 'emeon' ),
				'options' => $font_weights,
				'default' => 'bold',
			),
			array(
				'id'      => 'headings_transform',
				'type'    => 'radio',
				'title'   => esc_html__( 'Text transform', 'emeon' ),
				'options' => $font_transforms,
				'default' => 'none',
			),
			array(
				'id'      => 'page_title_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Main titles', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ),
				'default' => 36,
				'min'     => 10,
				'step'    => 1,
				'max'     => 60,
				'unit'    => 'px',
			),
			array(
				'id'          => 'page_title_font_size_768',
				'type'        => 'slider',
				'title'       => esc_html__( 'Main titles', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ). ' - ' .esc_html__( 'on mobile devices', 'emeon' ),
				'description' => esc_html__( 'It will be used on devices less than 768 pixels wide.', 'emeon' ),
				'min'         => 10,
				'max'         => 60,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 32,
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Content', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_content_styles',
		'icon'       => 'fa fa-align-left',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'content_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Background color', 'emeon' ),
				'description' => esc_html__( 'It will change the default white background color that is set under content on pages, blog, posts', 'emeon' ),
				'default'     => '#f7f7f7',
			),
			array(
				'id'      => 'content_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'emeon' ),
				'default' => '#000000',
			),
			array(
				'id'      => 'content_link_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Links', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default' => '',
			),
			array(
				'id'      => 'content_link_color_hover',
				'type'    => 'color',
				'title'   => esc_html__( 'Links', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '',
			),
			array(
				'id'      => 'content_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Font size', 'emeon' ),
				'default' => 16,
				'min'     => 10,
				'step'    => 1,
				'max'     => 30,
				'unit'    => 'px',
			),
			array(
				'id'          => 'first_paragraph',
				'type'        => 'radio',
				'title'       => esc_html__( 'First paragraph', 'emeon' ). ' : ' .esc_html__( 'Highlight', 'emeon' ),
				'description' => esc_html__( 'If enabled, it highlights(font size and color) the first paragraph in the content(blog, post, page).', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'       => 'first_paragraph_color',
				'type'     => 'color',
				'title'    => esc_html__( 'First paragraph', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'  => '',
				'required' => array( 'first_paragraph', '=', 'on' ),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Social icons', 'emeon' ),
		'desc'       => esc_html__( 'These icons will be used in various places across theme if you decide to activate them.', 'emeon' ),
		'id'         => 'section_social',
		'icon'       => 'fa fa-facebook-official',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'socials_variant',
				'type'    => 'radio',
				'title'   => esc_html__( 'Type of icons', 'emeon' ),
				'options' => array(
					'squares'    => esc_html__( 'Squares', 'emeon' ),
					'circles'    => esc_html__( 'Circles', 'emeon' ),
					'icons-only' => esc_html__( 'Only icons', 'emeon' ),
				),
				'default' => 'squares',
			),
			array(
				'id'          => 'social_services',
				'type'        => 'socials',
				'title'       => esc_html__( 'Links', 'emeon' ),
				'description' => esc_html__( 'Drag and drop to change order of icons. Only filled links will show up as social icons.', 'emeon' ),
				'label'       => false,
				'options'     => $emeon_a13->emeon_get_social_icons_list( 'names' ),
				'default'     => $emeon_a13->emeon_get_social_icons_list( 'empty' )
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Lightbox settings', 'emeon' ),
		'desc'       => esc_html__( 'If you wish to use some other plugin/script for images and items, you can switch off default theme lightbox. If you are planning to use different lightbox script instead, then you will have to do some extra work with scripting to make it work in every theme place.', 'emeon' ),
		'id'         => 'subsection_lightbox',
		'icon'       => 'fa fa-picture-o',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'skt_lightbox',
				'type'        => 'radio',
				'title'       => esc_html__( 'Theme lightbox', 'emeon' ),
				'options'     => array(
					'lightGallery' => esc_html__( 'Light Gallery', 'emeon' ),
					'off'          => esc_html__( 'Disable', 'emeon' ),
				),
				'default'     => 'lightGallery',
			),
			array(
				'id'          => 'lightbox_single_post',
				'type'        => 'radio',
				'title'       => esc_html__( 'Use theme lightbox for images in posts', 'emeon' ),
				'description' => esc_html__( 'If enabled, the theme will use a lightbox to display images in the post content. To work properly, Images should link to "Media File".', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'skt_lightbox', '=', 'lightGallery' ),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Widgets', 'emeon' ),
		'id'         => 'subsection_widgets',
		'icon'       => 'fa fa-puzzle-piece',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'widgets_top_margin',
				'type'        => 'radio',
				'title'       => esc_html__( 'Top margin', 'emeon' ),
				'description' => esc_html__( 'It only affects the widgets in the vertical sidebars.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'      => 'widget_title_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Main titles', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ),
				'min'     => 10,
				'max'     => 60,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 20,
			),
			array(
				'id'          => 'widget_font_size',
				'type'        => 'slider',
				'title'       => esc_html__( 'Content', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ),
				'description' => esc_html__( 'It only affects the widgets in the vertical sidebars.', 'emeon' ),
				'min'         => 5,
				'max'         => 30,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 16,
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'To top button', 'emeon' ),
		'id'         => 'subsection_to_top',
		'icon'       => 'fa fa-chevron-up',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'to_top',
				'type'        => 'radio',
				'title'       => esc_html__( 'To top button', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'      => 'to_top_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'emeon' ),
				'default' => '#524F51',
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'      => 'to_top_bg_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '#fe4c1c',
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'      => 'to_top_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Icon', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'default' => '#cccccc',
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'      => 'to_top_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Icon', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '#ffffff',
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'      => 'to_top_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Icon', 'emeon' ). ' : ' .esc_html__( 'Font size', 'emeon' ),
				'min'     => 10,
				'step'    => 1,
				'max'     => 60,
				'unit'    => 'px',
				'default' => 13,
				'required' => array( 'to_top', '=', 'on' ),
			),
			array(
				'id'          => 'to_top_icon',
				'type'        => 'text',
				'title'       => esc_html__( 'Icon', 'emeon' ),
				'default'     => 'chevron-up',
				'input_attrs' => array(
					'class' => 'a13-fa-icon',
				),
				'required' => array( 'to_top', '=', 'on' ),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Buttons', 'emeon' ),
		'desc'       => esc_html__( 'You can change here colors of buttons that submit forms. For shop buttons, go to the shop settings.', 'emeon' ),
		'id'         => 'subsection_buttons',
		'icon'       => 'fa fa-arrow-down',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'button_submit_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'emeon' ),
				'default' => '#524F51',
			),
			array(
				'id'      => 'button_submit_bg_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '#000000',
			),
			array(
				'id'      => 'button_submit_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'emeon' ),
				'default' => '#cccccc'
			),
			array(
				'id'      => 'button_submit_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '#ffffff'
			),
			array(
				'id'      => 'button_submit_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Font size', 'emeon' ),
				'min'     => 10,
				'max'     => 60,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 13,
			),
			array(
				'id'      => 'button_submit_weight',
				'type'    => 'select',
				'title'   => esc_html__( 'Font weight', 'emeon' ),
				'options' => $font_weights,
				'default' => 'bold',
			),
			array(
				'id'      => 'button_submit_transform',
				'type'    => 'radio',
				'title'   => esc_html__( 'Text transform', 'emeon' ),
				'options' => $font_transforms,
				'default' => 'uppercase',
			),
			array(
				'id'      => 'button_submit_padding',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Padding', 'emeon' ),
				'mode'    => 'padding',
				'sides'   => array( 'left', 'right' ),
				'units'   => array( 'px', 'em' ),
				'default' => array(
					'padding-left'  => '30px',
					'padding-right' => '30px',
					'units'         => 'px'
				),
			),
			array(
				'id'          => 'button_submit_radius',
				'type'        => 'slider',
				'title'       => esc_html__( 'Border radius', 'emeon' ),
				'min'         => 0,
				'max'         => 20,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 20,
			),
		)
	) );

//HEADER SETTINGS
	$emeon_a13->emeon_set_sections( array(
		'title'    => esc_html__( 'Header settings', 'emeon' ),
		'desc'     => '',
		'id'       => 'section_header_settings',
		'icon'     => 'el el-magic',
		'priority' => 6,
		'fields'   => array()
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Type, variant, background', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_header_type',
		'icon'       => 'fa fa-cogs',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'header_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Type', 'emeon' ),
				'options'     => array(
					'horizontal' => esc_html__( 'Horizontal', 'emeon' ),
				),
				'default'     => 'horizontal',
			),
			array(
				'id'       => 'header_horizontal_sticky',
				'type'     => 'select',
				'title'    => esc_html__( 'Header Type', 'emeon' ),
				'options'  => array(
					'no-sticky no-fixed' => esc_html__( 'Disabled, show only default header(not fixed)', 'emeon' ),
					'no-sticky'          => esc_html__( 'Disabled, show only default header fixed', 'emeon' )
				),
				'default'  => 'no-sticky no-fixed',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),
			/* Header Layout */
						array(
				'id'          => 'header_layout',
				'type'        => 'select',
				'title'       => esc_html__( 'Header Layout', 'emeon' ),
				'options'     => array(
					'header_layout_one' => esc_html__( 'Header Layout One', 'emeon' ),
					'header_layout_two' => esc_html__( 'Header Layout Two', 'emeon' ),
				),
				'default'     => 'header_layout_one',
			),
			/* Header Layout */			
			array(
				'id'       => 'header_content_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Content width', 'emeon' ),
				'options'  => array(
					'narrow' => esc_html__( 'Narrow', 'emeon' ),
					'full'   => esc_html__( 'Full width', 'emeon' ),
				),
				'default'  => 'full',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'       => 'header_content_width_narrow_bg',
				'type'     => 'radio',
				'title'    => esc_html__( 'Narrow the entire header as well', 'emeon' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_content_width', '=', 'narrow' )
				),
			),
			array(
				'id'      => 'header_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'emeon' ),
				'default' => '#ffffff',
			),
			array(
				'id'          => 'header_bg_hover_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Background color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'description' => esc_html__( 'Useful in special cases, like when you make a transparent header.', 'emeon' ),
				'default'     => '',
			),
			array(
				'id'       => 'header_social_bgcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Header Social Area Bg Color', 'emeon' ),
				'default'  => '#fe911c',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),		
			array(
				'id'       => 'topbar_bgcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Topbar Bg Color', 'emeon' ),
				'default'  => '#fe911c',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),				
			array(
				'id'       => 'topbar_txt_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Topbar Text Color', 'emeon' ),
				'default'  => '#fe911c',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),							
			array(
				'id'          => 'header_socials',
				'type'        => 'radio',
				'title'       => esc_html__( 'Social icons', 'emeon' ),
				/* translators: %s: URL */
				'description' => sprintf( wp_kses( __( 'If you need to edit social links go to <a href="%s">Social icons</a> settings.', 'emeon' ), $valid_tags ), 'javascript:wp.customize.section( \'section_social\' ).focus();' ),
				'options'     => $on_off,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'       => 'header_socials_color',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ),
				'options'  => $social_colors,
				'default'  => 'white',
				'required' => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_socials', '=', 'on' ),
				)
			),
			array(
				'id'       => 'header_socials_color_hover',
				'type'     => 'select',
				'title'    => esc_html__( 'Social icons', 'emeon' ). ' : ' .esc_html__( 'Color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'options'  => $social_colors,
				'default'  => 'color',
				'required' => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_socials', '=', 'on' ),
				)
			),
			array(
				'id'          => 'header_socials_display_on_mobile',
				'type'        => 'radio',
				'title'       => esc_html__( 'Social icons', 'emeon' ). ' - ' .esc_html__( 'Display it on mobiles', 'emeon' ),
				'description' => esc_html__( 'Should it be displayed on devices less than 600 pixels wide.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
				'required'    => array(
					array( 'header_type', '=', 'horizontal' ),
					array( 'header_socials', '=', 'on' ),
				)
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Logo', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_logo',
		'icon'       => 'fa fa-picture-o',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'logo_type',
				'type'    => 'radio',
				'title'   => esc_html__( 'Type', 'emeon' ),
				'options' => array(
					'image' => esc_html__( 'Image', 'emeon' ),
					'text'  => esc_html__( 'Text', 'emeon' ),
				),
				'default' => 'image',
			),
			array(
				'id'          => 'logo_image',
				'type'        => 'image',
				'title'       => esc_html__( 'Image', 'emeon' ),
				'description' => esc_html__( 'Upload an image for logo.', 'emeon' ),
				'default'     => '',
				'required'    => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'          => 'logo_image_high_dpi',
				'type'        => 'image',
				'title'       => esc_html__( 'Image for HIGH DPI screen', 'emeon' ),
				'description' => esc_html__( 'For example Retina(iPhone/iPad) screen has HIGH DPI screen.', 'emeon' ) . ' ' . esc_html__( 'Upload an image for logo.', 'emeon' ),
				'default'     => '',
				'required'    => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'          => 'logo_image_max_desktop_width',
				'type'        => 'slider',
				'title'       => esc_html__( 'Max width', 'emeon' ). ' - ' .esc_html__( 'on desktop', 'emeon' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'emeon' ) .' '. esc_html__( 'It works only on large screens(1025px wide or more).', 'emeon' ),
				'min'         => 25,
				'step'        => 1,
				'max'         => 400,
				'unit'        => 'px',
				'default'     => 200,
				'required'    => array(
					array( 'logo_type', '=', 'image' ),
					array( 'header_type', '=', 'horizontal' ),
				)
			),
			array(
				'id'          => 'logo_image_max_mobile_width',
				'type'        => 'slider',
				'title'       => esc_html__( 'Max width', 'emeon' ). ' - ' .esc_html__( 'on mobile devices', 'emeon' ),
				'description' => esc_html__( 'It works only on mobile devices(1024px wide or less).', 'emeon' ),
				'min'         => 25,
				'max'         => 250,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 200,
				'required'    => array(
					array( 'logo_type', '=', 'image' ),
				)
			),
			array(
				'id'          => 'logo_image_height',
				'type'        => 'slider',
				'title'       => esc_html__( 'Height', 'emeon' ),
				'description' => esc_html__( 'Leave empty if you do not need anything fancy', 'emeon' ),
				'min'         => 0,
				'max'         => 100,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => '',
				'required'    => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'       => 'logo_image_normal_opacity',
				'type'     => 'slider',
				'title'    => esc_html__( 'Opacity', 'emeon' ),
				'min'      => 0,
				'max'      => 1,
				'step'     => 0.01,
				'default'  => '1.00',
				'required' => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'       => 'logo_image_hover_opacity',
				'type'     => 'slider',
				'title'    => esc_html__( 'Opacity', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'min'      => 0,
				'max'      => 1,
				'step'     => 0.01,
				'default'  => '1.00',
				'required' => array( 'logo_type', '=', 'image' ),
			),
			array(
				'id'          => 'logo_text',
				'type'        => 'text',
				'title'       => esc_html__( 'Text', 'emeon' ),
				'description' => wp_kses( __( 'If you use more than one word in the logo, you can use <code>&amp;nbsp;</code> instead of a white space, so the words will not break into many lines.', 'emeon' ), $valid_tags ).
				                 /* translators: %s: Customizer JS URL */
				                 '<br />'.sprintf( wp_kses( __( 'If you want to change the font for logo go to <a href="%s">Font settings</a>.', 'emeon' ), $valid_tags ), 'javascript:wp.customize.control( \''.EMEON_OPTIONS_NAME.'[logo_fonts]\' ).focus();' ),
				'default'     => get_bloginfo( 'name' ),
				'required'    => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'       => 'logo_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Text color', 'emeon' ),
				'default'  => '',
				'required' => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'       => 'logo_color_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Text color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default'  => '',
				'required' => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'       => 'logo_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Font size', 'emeon' ),
				'min'      => 10,
				'max'      => 60,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => 22,
				'required' => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'       => 'logo_weight',
				'type'     => 'select',
				'title'    => esc_html__( 'Font weight', 'emeon' ),
				'options'  => $font_weights,
				'default'  => 'normal',
				'required' => array( 'logo_type', '=', 'text' ),
			),
			array(
				'id'          => 'logo_padding',
				'type'        => 'spacing',
				'title'       => esc_html__( 'Padding', 'emeon' ). ' - ' .esc_html__( 'on desktop', 'emeon' ),
				'description' => esc_html__( 'It works only on large screens(1025px wide or more).', 'emeon' ),
				'mode'        => 'padding',
				'sides'       => array( 'top', 'bottom' ),
				'units'       => array( 'px', 'em' ),
				'default'     => array(
					'padding-top'    => '30px',
					'padding-bottom' => '20px',
					'units'          => 'px'
				)
			),
			array(
				'id'          => 'logo_padding_mobile',
				'type'        => 'spacing',
				'title'       => esc_html__( 'Padding', 'emeon' ). ' - ' .esc_html__( 'on mobile devices', 'emeon' ),
				'description' => esc_html__( 'It works only on mobile devices(1024px wide or less).', 'emeon' ),
				'mode'        => 'padding',
				'sides'       => array( 'top', 'bottom' ),
				'units'       => array( 'px', 'em' ),
				'default'     => array(
					'padding-top'    => '10px',
					'padding-bottom' => '10px',
					'units'          => 'px'
				)
			),
			array(
				'id'      => 'logo_bg_effect',
				'type'    => 'radio',
				'title'   => esc_html__( 'Logo Background', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),		
           array(
				'id'       => 'logo_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Logo Background Color', 'emeon' ),
				'default'  => '#f4f6fd',
				'required' => array( 'header_type', '=', 'horizontal' ),
			),				
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Main Menu', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_header_menu',
		'icon'       => 'fa fa-bars',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'menu_font_size',
				'type'     => 'slider',
				'title'    => esc_html__( 'Font size', 'emeon' ),
				'min'      => 10,
				'max'      => 30,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => 16,
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'menu_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Links', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'  => '#333333',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'menu_hover_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Links', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ). ' - ' .esc_html__( 'on hover/active', 'emeon' ),
				'default'  => '#fe4c1c',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'menu_weight',
				'type'     => 'select',
				'title'    => esc_html__( 'Font weight', 'emeon' ),
				'options'  => $font_weights,
				'default'  => 'normal',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'menu_transform',
				'type'     => 'radio',
				'title'    => esc_html__( 'Text transform', 'emeon' ),
				'options'  => $font_transforms,
				'default'  => 'uppercase',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'submenu_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Submenu', 'emeon' ). ' : ' .esc_html__( 'Background color', 'emeon' ),
				'default'  => '#ffffff',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),
			array(
				'id'       => 'submenu_hover_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Submenu', 'emeon' ). ' : ' .esc_html__( 'Background Hover color', 'emeon' ),
				'default'  => '#282828',
				'required' => array( 'header_main_menu', '=', 'on' ),
			),						 
		)
	) );

//BLOG SETTINGS
	$emeon_a13->emeon_set_sections( array(
		'title'    => esc_html__( 'Blog settings', 'emeon' ),
		'desc'     => esc_html__( 'Posts list refers to Blog, Search and Archives pages', 'emeon' ),
		'id'       => 'section_blog_layout',
		'icon'     => 'fa fa-pencil',
		'priority' => 9,
		'fields'   => array()
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Background', 'emeon' ),
		'id'         => 'subsection_blog_bg',
		'desc'       => esc_html__( 'This will be the default background for pages related to the blog.', 'emeon' ),
		'icon'       => 'fa fa-picture-o',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'blog_custom_background',
				'type'    => 'radio',
				'title'   => esc_html__( 'Custom background', 'emeon' ),
				'options' => $on_off,
				'default' => 'off',
			),
			array(
				'id'       => 'blog_body_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'required' => array( 'blog_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'blog_body_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'cover',
				'required' => array( 'blog_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'blog_body_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'emeon' ),
				'default'  => '',
				'required' => array( 'blog_custom_background', '=', 'on' ),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Posts list', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_blog',
		'icon'       => 'fa fa-list',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'blog_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'emeon' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'emeon' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'blog_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'emeon' ),
				'options' => $content_layouts,
				'default' => 'center',
			),
			array(
				'id'      => 'blog_content_padding',
				'type'    => 'select',
				'title'   => esc_html__( 'Content', 'emeon' ). ' : ' .esc_html__( 'Top/bottom padding', 'emeon' ),
				'options' => array(
					'both'   => esc_html__( 'Both on', 'emeon' ),
					'top'    => esc_html__( 'Only top', 'emeon' ),
					'bottom' => esc_html__( 'Only bottom', 'emeon' ),
					'off'    => esc_html__( 'Both off', 'emeon' ),
				),
				'default' => 'off',
			),
			array(
				'id'      => 'blog_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar', 'emeon' ),
				'options' => array(
					'left-sidebar'  => esc_html__( 'Left', 'emeon' ),
					'right-sidebar' => esc_html__( 'Right', 'emeon' ),
					'off'           => esc_html__( 'Off', 'emeon' ),
				),
				'default' => 'off',
			),
			array(
				'id'      => 'blog_post_look',
				'type'    => 'select',
				'title'   => esc_html__( 'Post look', 'emeon' ),
				'options' => array(
					'vertical_no_padding' => esc_html__( 'Vertical no padding', 'emeon' ),
					'vertical_padding'    => esc_html__( 'Vertical with padding', 'emeon' ),
					'vertical_centered'   => esc_html__( 'Vertical centered', 'emeon' ),
					'horizontal'          => esc_html__( 'Horizontal', 'emeon' ),
				),
				'default' => 'vertical_padding',
			),
			array(
				'id'          => 'blog_layout_mode',
				'type'        => 'radio',
				'title'       => esc_html__( 'How to place items in rows', 'emeon' ),
				'description' => esc_html__( 'If your items have different heights, you can start each row of items from a new line instead of the masonry style.', 'emeon' ),
				'options'     => array(
					'packery' => esc_html__( 'Masonry', 'emeon' ),
					'fitRows' => esc_html__( 'Each row from new line', 'emeon' ),
				),
				'default'     => 'packery',
			),
			array(
				'id'          => 'blog_brick_columns',
				'type'        => 'slider',
				'title'       => esc_html__( 'Bricks columns', 'emeon' ),
				'description' => esc_html__( 'It is a maximum number of columns displayed on larger devices. On smaller devices, it can be a lower number of columns.', 'emeon' ),
				'min'         => 1,
				'max'         => 4,
				'step'        => 1,
				'unit'        => '',
				'default'     => 2,
				'required'    => array( 'blog_post_look', '!=', 'horizontal' ),
			),
			array(
				'id'          => 'blog_bricks_max_width',
				'type'        => 'slider',
				'title'       => esc_html__( 'The maximum width of the brick layout', 'emeon' ),
				'description' => esc_html__( 'Depending on the actual width of the screen, the available space for bricks may be smaller, but never greater than this number.', 'emeon' ),
				'min'         => 200,
				'max'         => 2500,
				'step'        => 1,
				'unit'        => 'px',
				'default'     => 1920,
				'required'    => array( 'blog_post_look', '!=', 'horizontal' ),
			),
			array(
				'id'      => 'blog_brick_margin',
				'type'    => 'slider',
				'title'   => esc_html__( 'Brick margin', 'emeon' ),
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 10,
			),
			array(
				'id'      => 'blog_lazy_load',
				'type'    => 'radio',
				'title'   => esc_html__( 'Lazy load', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'blog_lazy_load_mode',
				'type'     => 'radio',
				'title'    => esc_html__( 'Lazy load', 'emeon' ). ' : ' . esc_html__( 'Type', 'emeon' ),
				'options'  => array(
					'button' => esc_html__( 'By clicking button', 'emeon' ),
					'auto'   => esc_html__( 'On scroll', 'emeon' ),
				),
				'default'  => 'button',
				'required' => array( 'blog_lazy_load', '=', 'on' ),
			),
			array(
				'id'          => 'blog_read_more',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display "Read more" link', 'emeon' ),
				'description' => esc_html__( 'Should "Read more" link be displayed after excerpts on blog list/search results.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'blog_excerpt_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Type of post excerpts', 'emeon' ),
				'description' => wp_kses( __(
					'In the Manual mode, excerpts are used only if you add the "Read More Tag" (&lt;!--more--&gt;).<br /> In the Automatic mode, if you will not provide the "Read More Tag" or explicit excerpt, the content of the post will be truncated automatically.<br /> This setting only concerns blog list, archive list, search results.', 'emeon' ), $valid_tags ),
				'options'     => array(
					'auto'   => esc_html__( 'Automatic', 'emeon' ),
					'manual' => esc_html__( 'Manual', 'emeon' ),
				),
				'default'     => 'auto',
			),
			array(
				'id'          => 'blog_excerpt_length',
				'type'        => 'slider',
				'title'       => esc_html__( 'Number of words to cut post', 'emeon' ),
				'description' => esc_html__( 'After this many words post will be cut in the automatic mode.', 'emeon' ),
				'min'         => 3,
				'max'         => 200,
				'step'        => 1,
				'unit'        => '',
				'default'     => 40,
				'required'    => array( 'blog_excerpt_type', '=', 'auto' ),
			),
			array(
				'id'          => 'blog_media',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display post Media', 'emeon' ),
				'description' => esc_html__( 'You can set to not display post media(featured image/video/slider) inside of the post brick.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'blog_videos',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display of posts video', 'emeon' ),
				'description' => esc_html__( 'You can set to display videos as featured image on posts list. This can speed up loading of pages with many posts(blog, archive, search results) when the videos are used.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'blog_date',
				'type'        => 'radio',
				'title'       => esc_html__( 'Post info', 'emeon' ). ' : ' .esc_html__( 'Date of publish or last update', 'emeon' ),
				'description' => esc_html__( 'You can\'t use both dates, because the Search Engine will not know which date is correct.', 'emeon' ),
				'options'     => array(
					'on'      => esc_html__( 'Published', 'emeon' ),
					'updated' => esc_html__( 'Updated', 'emeon' ),
					'off'     => esc_html__( 'Disable', 'emeon' ),
				),
				'default'     => 'on',
			),
			array(
				'id'      => 'blog_author',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'emeon' ). ' : ' .esc_html__( 'Author', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'      => 'blog_comments',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'emeon' ). ' : ' .esc_html__( 'Comments number', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'      => 'blog_cats',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'emeon' ). ' : ' .esc_html__( 'Categories', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'          => 'blog_tags',
				'type'        => 'radio',
				'title'       => esc_html__( 'Tags', 'emeon' ),
				'description' => esc_html__( 'Displays list of post tags under a post content.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'off',
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Posts list', 'emeon' ). ' - ' .esc_html__( 'Title bar', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_blog_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'blog_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'blog_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'emeon' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'emeon' ),
					'centered' => esc_html__( 'Centered', 'emeon' ),
				),
				'default'  => 'centered',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Width', 'emeon' ),
				'options'  => array(
					'full'  => esc_html__( 'Full', 'emeon' ),
					'boxed' => esc_html__( 'Boxed', 'emeon' ),
				),
				'default'  => 'full',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'default'  => '',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'emeon' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'          => 'blog_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Type', 'emeon' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'emeon' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'blog_title', '=', 'on' ),
					array( 'blog_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'blog_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Speed', 'emeon' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'emeon' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'blog_title', '=', 'on' ),
					array( 'blog_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'blog_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'emeon' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'emeon' ),
				'default'     => '#ffffff',
				'required'    => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'  => '',
				'required' => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'          => 'blog_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'     => '',
				'required'    => array( 'blog_title', '=', 'on' ),
			),
			array(
				'id'       => 'blog_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'emeon' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '210',
				'required' => array( 'blog_title', '=', 'on' ),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Single post', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_post',
		'icon'       => 'fa fa-pencil-square',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'post_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'emeon' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'emeon' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'post_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'emeon' ),
				'options' => $content_layouts,
				'default' => 'center',
			),
			array(
				'id'      => 'post_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar', 'emeon' ),
				'options' => array(
					'left-sidebar'  => esc_html__( 'Left', 'emeon' ),
					'right-sidebar' => esc_html__( 'Right', 'emeon' ),
					'off'           => esc_html__( 'Off', 'emeon' ),
				),
				'default' => 'right-sidebar',
			),
			array(
				'id'          => 'post_media',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display post Media', 'emeon' ),
				'description' => esc_html__( 'You can set to not display post media(featured image/video/slider) inside of the post.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'post_author_info',
				'type'        => 'radio',
				'title'       => esc_html__( 'Author info', 'emeon' ),
				'description' => esc_html__( 'Will show information about author below post content.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'off',
			),
			array(
				'id'          => 'post_date',
				'type'        => 'radio',
				'title'       => esc_html__( 'Post info', 'emeon' ). ' : ' .esc_html__( 'Date of publish or last update', 'emeon' ),
				'description' => esc_html__( 'You can\'t use both dates, because the Search Engine will not know which date is correct.', 'emeon' ),
				'options'     => array(
					'on'      => esc_html__( 'Published', 'emeon' ),
					'updated' => esc_html__( 'Updated', 'emeon' ),
					'off'     => esc_html__( 'Disable', 'emeon' ),
				),
				'default'     => 'on',
			),
			array(
				'id'      => 'post_author',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'emeon' ). ' : ' .esc_html__( 'Author', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'      => 'post_comments',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'emeon' ). ' : ' .esc_html__( 'Comments number', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'      => 'post_cats',
				'type'    => 'radio',
				'title'   => esc_html__( 'Post info', 'emeon' ). ' : ' .esc_html__( 'Categories', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'          => 'post_tags',
				'type'        => 'radio',
				'title'       => esc_html__( 'Tags', 'emeon' ),
				'description' => esc_html__( 'Displays list of post tags under a post content.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'post_navigation',
				'type'        => 'radio',
				'title'       => esc_html__( 'Posts navigation', 'emeon' ),
				'description' => esc_html__( 'Links to next and prev post.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),

		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Single post', 'emeon' ). ' - ' .esc_html__( 'Title bar', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_post_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'post_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'post_title_bar_position',
				'type'     => 'radio',
				'title'    => esc_html__( 'Title position', 'emeon' ),
				'options'  => array(
					'outside' => esc_html__( 'Before the content', 'emeon' ),
					'inside'  => esc_html__( 'Inside the content', 'emeon' ),
				),
				'default'  => 'inside',
				'required' => array( 'post_title', '=', 'on' ),
			),
			array(
				'id'       => 'post_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'emeon' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'emeon' ),
					'centered' => esc_html__( 'Centered', 'emeon' ),
				),
				'default'  => 'classic',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Width', 'emeon' ),
				'options'  => array(
					'full'  => esc_html__( 'Full', 'emeon' ),
					'boxed' => esc_html__( 'Boxed', 'emeon' ),
				),
				'default'  => 'full',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'default'  => '',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'emeon' ),
				'default'  => 'off',
				'options'  => $on_off,
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'post_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Type', 'emeon' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'emeon' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
					array( 'post_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'post_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Speed', 'emeon' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'emeon' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
					array( 'post_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'post_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'emeon' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'emeon' ),
				'default'     => '',
				'required'    => array( 'post_title', '=', 'on' ),
			),
			array(
				'id'       => 'post_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'  => '',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'post_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'     => '',
				'required'    => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'post_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'emeon' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '250',
				'required' => array(
					array( 'post_title', '=', 'on' ),
					array( 'post_title_bar_position', '!=', 'inside' ),
				)
			),
		)
	) );

//SHOP SETTINGS
	$emeon_a13->emeon_set_sections( array(
		'title'    => esc_html__( 'Shop(WooCommerce) settings', 'emeon' ),
		'desc'     => '',
		'id'       => 'section_shop_general',
		'icon'     => 'fa fa-shopping-cart',
		'priority' => 12,
		'woocommerce_required' => true,//only visible with WooCommerce plugin being available
		'fields'   => array()
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Background', 'emeon' ),
		'desc'       => esc_html__( 'These options will work for all shop pages - product list, single product and other.', 'emeon' ),
		'id'         => 'subsection_shop_general',
		'icon'       => 'fa fa-picture-o',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'shop_custom_background',
				'type'    => 'radio',
				'title'   => esc_html__( 'Custom background', 'emeon' ),
				'options' => $on_off,
				'default' => 'off',
			),
			array(
				'id'       => 'shop_body_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'required' => array( 'shop_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'shop_body_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'cover',
				'required' => array( 'shop_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'shop_body_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'emeon' ),
				'required' => array( 'shop_custom_background', '=', 'on' ),
				'default'  => '',
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Products list', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_shop',
		'icon'       => 'fa fa-list',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'shop_search',
				'type'        => 'radio',
				'title'       => esc_html__( 'Search in products instead of pages', 'emeon' ),
				'description' => esc_html__( 'It will change WordPress default search function to make shop search. So when this is activated search function in header or search widget will act as WooCommerece search widget.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'shop_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'emeon' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'emeon' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'shop_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'emeon' ),
				'options' => $content_layouts,
				'default' => 'center',
			),
			array(
				'id'      => 'shop_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar', 'emeon' ),
				'options' => array(
					'left-sidebar'  => esc_html__( 'Left', 'emeon' ),
					'right-sidebar' => esc_html__( 'Right', 'emeon' ),
					'off'           => esc_html__( 'Off', 'emeon' ),
				),
				'default' => 'right-sidebar',
			),
			array(
				'id'      => 'shop_products_variant',
				'type'    => 'radio',
				'title'   => esc_html__( 'Look of products on list', 'emeon' ),
				'options' => array(
					'overlay' => esc_html__( 'Text as overlay', 'emeon' ),
					'under'   => esc_html__( 'Text under photo', 'emeon' ),
				),
				'default' => 'overlay',
			),
			array(
				'id'       => 'shop_products_subvariant',
				'type'     => 'select',
				'title'    => esc_html__( 'Look of products on list', 'emeon' ),
				'options'  => array(
					'left'   => esc_html__( 'Texts to left', 'emeon' ),
					'center' => esc_html__( 'Texts to center', 'emeon' ),
					'right'  => esc_html__( 'Texts to right', 'emeon' ),
				),
				'default'  => 'center',
				'required' => array( 'shop_products_variant', '=', 'under' ),
			),
			array(
				'id'      => 'shop_products_second_image',
				'type'    => 'radio',
				'title'   => esc_html__( 'Show second image of product on hover', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'          => 'shop_products_layout_mode',
				'type'        => 'radio',
				'title'       => esc_html__( 'How to place items in rows', 'emeon' ),
				'description' => esc_html__( 'If your items have different heights, you can start each row of items from a new line instead of the masonry style.', 'emeon' ),
				'options'     => array(
					'packery' => esc_html__( 'Masonry', 'emeon' ),
					'fitRows' => esc_html__( 'Each row from new line', 'emeon' ),
				),
				'default'     => 'packery',
			),
			array(
				'id'          => 'shop_products_columns',
				'type'        => 'slider',
				'title'       => esc_html__( 'Bricks columns', 'emeon' ),
				'description' => esc_html__( 'It is a maximum number of columns displayed on larger devices. On smaller devices, it can be a lower number of columns.', 'emeon' ),
				'min'         => 1,
				'max'         => 4,
				'step'        => 1,
				'unit'        => '',
				'default'     => 4,
			),
			array(
				'id'      => 'shop_products_per_page',
				'type'    => 'slider',
				'title'   => esc_html__( 'Items per page', 'emeon' ),
				'min'     => 1,
				'max'     => 30,
				'step'    => 1,
				'unit'    => 'products',
				'default' => 12,
			),
			array(
				'id'      => 'shop_brick_margin',
				'type'    => 'slider',
				'title'   => esc_html__( 'Brick margin', 'emeon' ),
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 20,
			),
			array(
				'id'      => 'shop_lazy_load',
				'type'    => 'radio',
				'title'   => esc_html__( 'Lazy load', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'shop_lazy_load_mode',
				'type'     => 'radio',
				'title'    => esc_html__( 'Lazy load', 'emeon' ). ' : ' . esc_html__( 'Type', 'emeon' ),
				'options'  => array(
					'button' => esc_html__( 'By clicking button', 'emeon' ),
					'auto'   => esc_html__( 'On scroll', 'emeon' ),
				),
				'default'  => 'auto',
				'required' => array( 'shop_lazy_load', '=', 'on' ),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Products list', 'emeon' ). ' - ' .esc_html__( 'Title bar', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_shop_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'shop_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'shop_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'emeon' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'emeon' ),
					'centered' => esc_html__( 'Centered', 'emeon' ),
				),
				'default'  => 'classic',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Width', 'emeon' ),
				'options'  => array(
					'full'  => esc_html__( 'Full', 'emeon' ),
					'boxed' => esc_html__( 'Boxed', 'emeon' ),
				),
				'default'  => 'full',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'default'  => '',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'emeon' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'          => 'shop_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Type', 'emeon' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'emeon' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'shop_title', '=', 'on' ),
					array( 'shop_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'shop_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Speed', 'emeon' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'emeon' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'shop_title', '=', 'on' ),
					array( 'shop_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'shop_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'emeon' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'emeon' ),
				'default'     => '',
				'required'    => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'  => '',
				'required' => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'          => 'shop_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'     => '',
				'required'    => array( 'shop_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'emeon' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '250',
				'required' => array( 'shop_title', '=', 'on' ),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Single product', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_product',
		'icon'       => 'fa fa-pencil-square',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'product_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'emeon' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'emeon' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'product_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'emeon' ),
				'options' => $content_layouts,
				'default' => 'full_fixed',
			),
			array(
				'id'      => 'product_sidebar',
				'type'    => 'select',
				'title'   => esc_html__( 'Sidebar', 'emeon' ),
				'options' => array(
					'left-sidebar'  => esc_html__( 'Left', 'emeon' ),
					'right-sidebar' => esc_html__( 'Right', 'emeon' ),
					'off'           => esc_html__( 'Off', 'emeon' ),
				),
				'default' => 'left-sidebar',
			),
			array(
				'id'          => 'product_custom_thumbs',
				'type'        => 'radio',
				'title'       => esc_html__( 'Theme thumbnails', 'emeon' ),
				'description' => esc_html__( 'If disabled it will display standard WooCommerce thumbnails.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
			array(
				'id'          => 'product_related_products',
				'type'        => 'radio',
				'title'       => esc_html__( 'Related products', 'emeon' ),
				'description' => esc_html__( 'Should related products be displayed on single product page.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Single product', 'emeon' ). ' - ' .esc_html__( 'Title bar', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_product_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'product_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'product_title_bar_position',
				'type'     => 'radio',
				'title'    => esc_html__( 'Title position', 'emeon' ),
				'options'  => array(
					'outside' => esc_html__( 'Before the content', 'emeon' ),
					'inside'  => esc_html__( 'Inside the content', 'emeon' ),
				),
				'default'  => 'inside',
				'required' => array( 'product_title', '=', 'on' ),
			),
			array(
				'id'       => 'product_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'emeon' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'emeon' ),
					'centered' => esc_html__( 'Centered', 'emeon' ),
				),
				'default'  => 'classic',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'default'  => '',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'emeon' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'product_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Type', 'emeon' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'emeon' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
					array( 'product_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'product_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Speed', 'emeon' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'emeon' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
					array( 'product_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'product_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'emeon' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'emeon' ),
				'default'     => '',
				'required'    => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'  => '',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'product_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'     => '',
				'required'    => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'product_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'emeon' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '40',
				'required' => array(
					array( 'product_title', '=', 'on' ),
					array( 'product_title_bar_position', '!=', 'inside' ),
				)
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Other shop pages', 'emeon' ),
		'desc'       => esc_html__( 'Settings for cart, checkout, order received and my account pages.', 'emeon' ),
		'id'         => 'subsection_shop_no_major_pages',
		'icon'       => 'fa fa-cog',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'shop_no_major_pages_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'emeon' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'emeon' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'shop_no_major_pages_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'emeon' ),
				'options' => $content_layouts,
				'default' => 'full_fixed',
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'desc'       => esc_html__( 'Settings for cart, checkout, order received and my account pages.', 'emeon' ),
		'title'      => esc_html__( 'Other shop pages', 'emeon' ). ' - ' .esc_html__( 'Title bar', 'emeon' ),
		'id'         => 'subsection_shop_no_major_pages_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'shop_no_major_pages_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'emeon' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'emeon' ),
					'centered' => esc_html__( 'Centered', 'emeon' ),
				),
				'default'  => 'classic',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_width',
				'type'     => 'radio',
				'title'    => esc_html__( 'Width', 'emeon' ),
				'options'  => array(
					'full'  => esc_html__( 'Full', 'emeon' ),
					'boxed' => esc_html__( 'Boxed', 'emeon' ),
				),
				'default'  => 'full',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'default'  => '',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'emeon' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'          => 'shop_no_major_pages_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Type', 'emeon' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'emeon' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'shop_no_major_pages_title', '=', 'on' ),
					array( 'shop_no_major_pages_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'shop_no_major_pages_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Speed', 'emeon' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'emeon' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'shop_no_major_pages_title', '=', 'on' ),
					array( 'shop_no_major_pages_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'shop_no_major_pages_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'emeon' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'emeon' ),
				'default'     => '',
				'required'    => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'  => '',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'          => 'shop_no_major_pages_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'     => '',
				'required'    => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
			array(
				'id'       => 'shop_no_major_pages_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'emeon' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '250',
				'required' => array( 'shop_no_major_pages_title', '=', 'on' ),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Buttons', 'emeon' ),
		'desc'       => esc_html__( 'You can change here the colors of buttons used in the shop. Alternative buttons colors are used in various places in the shop.', 'emeon' ),
		'id'         => 'subsection_buttons_shop',
		'icon'       => 'fa fa-arrow-down',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'button_shop_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'emeon' ),
				'default' => '#524F51',
			),
			array(
				'id'      => 'button_shop_bg_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Background color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '#000000',
			),
			array(
				'id'      => 'button_shop_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'emeon' ),
				'default' => '#cccccc'
			),
			array(
				'id'      => 'button_shop_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Text color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '#ffffff'
			),
			array(
				'id'      => 'button_shop_alt_bg_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Alternative button', 'emeon' ). ' : ' .esc_html__( 'Background color', 'emeon' ),
				'default' => '#524F51',
			),
			array(
				'id'      => 'button_shop_alt_bg_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Alternative button', 'emeon' ). ' : ' .esc_html__( 'Background color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '#000000',
			),
			array(
				'id'      => 'button_shop_alt_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Alternative button', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default' => '#cccccc'
			),
			array(
				'id'      => 'button_shop_alt_hover_color',
				'type'    => 'color',
				'title'   => esc_html__( 'Alternative button', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ). ' - ' .esc_html__( 'on hover', 'emeon' ),
				'default' => '#ffffff'
			),
			array(
				'id'      => 'button_shop_font_size',
				'type'    => 'slider',
				'title'   => esc_html__( 'Font size', 'emeon' ),
				'min'     => 10,
				'max'     => 60,
				'step'    => 1,
				'unit'    => 'px',
				'default' => 13,
			),
			array(
				'id'      => 'button_shop_weight',
				'type'    => 'select',
				'title'   => esc_html__( 'Font weight', 'emeon' ),
				'options' => $font_weights,
				'default' => 'bold',
			),
			array(
				'id'      => 'button_shop_transform',
				'type'    => 'radio',
				'title'   => esc_html__( 'Text transform', 'emeon' ),
				'options' => $font_transforms,
				'default' => 'uppercase',
			),
			array(
				'id'      => 'button_shop_padding',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Padding', 'emeon' ),
				'mode'    => 'padding',
				'sides'   => array( 'left', 'right' ),
				'units'   => array( 'px', 'em' ),
				'default' => array(
					'padding-left'  => '30px',
					'padding-right' => '30px',
					'units'         => 'px'
				),
			),
		)
	) );

//PAGE SETTINGS
	$emeon_a13->emeon_set_sections( array(
		'title'    => esc_html__( 'Page settings', 'emeon' ),
		'desc'     => '',
		'id'       => 'section_page',
		'icon'     => 'el el-file-edit',
		'priority' => 15,
		'fields'   => array()
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Single page', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_page',
		'icon'       => 'el el-file-edit',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'page_comments',
				'type'    => 'radio',
				'title'   => esc_html__( 'Comments', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'          => 'page_content_under_header',
				'type'        => 'select',
				'title'       => esc_html__( 'Hide content under the header', 'emeon' ),
				'description' => esc_html__( 'Works only with the horizontal header.', 'emeon' ),
				'options'     => $content_under_header,
				'default'     => 'off',
				'required'    => array( 'header_type', '=', 'horizontal' ),
			),
			array(
				'id'      => 'page_content_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Content Layout', 'emeon' ),
				'options' => $content_layouts,
				'default' => 'center',
			),
			array(
				'id'          => 'page_sidebar',
				'type'        => 'select',
				'title'       => esc_html__( 'Sidebar', 'emeon' ),
				'description' => esc_html__( 'You can change it in each page settings.', 'emeon' ),
				'options'     => array(
					'left-sidebar'          => esc_html__( 'Sidebar on the left', 'emeon' ),
					'left-sidebar_and_nav'  => esc_html__( 'Children Navigation + sidebar on the left', 'emeon' ),
					'left-nav'              => esc_html__( 'Only children Navigation on the left', 'emeon' ),
					'right-sidebar'         => esc_html__( 'Sidebar on the right', 'emeon' ),
					'right-sidebar_and_nav' => esc_html__( 'Children Navigation + sidebar on the right', 'emeon' ),
					'right-nav'             => esc_html__( 'Only children Navigation on the right', 'emeon' ),
					'off'                   => esc_html__( 'Off', 'emeon' ),
				),
				'default'     => 'off',
			),
			array(
				'id'      => 'page_custom_background',
				'type'    => 'radio',
				'title'   => esc_html__( 'Custom background', 'emeon' ),
				'options' => $on_off,
				'default' => 'off',
			),
			array(
				'id'       => 'page_body_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'required' => array( 'page_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'page_body_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'cover',
				'required' => array( 'page_custom_background', '=', 'on' ),
			),
			array(
				'id'       => 'page_body_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Background color', 'emeon' ),
				'required' => array( 'page_custom_background', '=', 'on' ),
				'default'  => '',
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Single page', 'emeon' ). ' - ' .esc_html__( 'Title bar', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_page_title',
		'icon'       => 'fa fa-text-width',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'      => 'page_title',
				'type'    => 'radio',
				'title'   => esc_html__( 'Title', 'emeon' ),
				'options' => $on_off,
				'default' => 'on',
			),
			array(
				'id'       => 'page_title_bar_position',
				'type'     => 'radio',
				'title'    => esc_html__( 'Title position', 'emeon' ),
				'options'  => array(
					'outside' => esc_html__( 'Before the content', 'emeon' ),
					'inside'  => esc_html__( 'Inside the content', 'emeon' ),
				),
				'default'  => 'outside',
				'required' => array( 'page_title', '=', 'on' ),
			),
			array(
				'id'       => 'page_title_bar_variant',
				'type'     => 'radio',
				'title'    => esc_html__( 'Variant', 'emeon' ),
				'options'  => array(
					'classic'  => esc_html__( 'Classic(to side)', 'emeon' ),
					'centered' => esc_html__( 'Centered', 'emeon' ),
				),
				'default'  => 'classic',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'page_title_bar_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Background image', 'emeon' ),
				'default'  => '',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'page_title_bar_image_fit',
				'type'     => 'select',
				'title'    => esc_html__( 'How to fit the background image', 'emeon' ),
				'options'  => $image_fit,
				'default'  => 'repeat',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'page_title_bar_parallax',
				'type'     => 'radio',
				'title'    => esc_html__( 'Parallax', 'emeon' ),
				'options'  => $on_off,
				'default'  => 'off',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'page_title_bar_parallax_type',
				'type'        => 'select',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Type', 'emeon' ),
				'description' => esc_html__( 'It defines how the image will scroll in the background while the page is scrolled down.', 'emeon' ),
				'options'     => $parallax_types,
				'default'     => 'tb',
				'required'    => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
					array( 'page_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'page_title_bar_parallax_speed',
				'type'        => 'slider',
				'title'       => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Speed', 'emeon' ),
				'description' => esc_html__( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'emeon' ),
				'min'         => 0,
				'max'         => 1,
				'step'        => 0.01,
				'default'     => '1.00',
				'required'    => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
					array( 'page_title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'id'          => 'page_title_bar_bg_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Overlay color', 'emeon' ),
				'description' => esc_html__( 'Will be placed above the image(if used)', 'emeon' ),
				'default'     => '',
				'required'    => array( 'page_title', '=', 'on' ),
			),
			array(
				'id'       => 'page_title_bar_title_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Titles', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'default'  => '',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'          => 'page_title_bar_color_1',
				'type'        => 'color',
				'title'       => esc_html__( 'Other elements', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'description' => esc_html__( 'Used in breadcrumbs.', 'emeon' ),
				'default'     => '',
				'required'    => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'id'       => 'page_title_bar_space_width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Top/bottom padding', 'emeon' ),
				'min'      => 0,
				'max'      => 600,
				'step'     => 1,
				'unit'     => 'px',
				'default'  => '150',
				'required' => array(
					array( 'page_title', '=', 'on' ),
					array( 'page_title_bar_position', '!=', 'inside' ),
				)
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( '404 page template', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_404_page',
		'icon'       => 'fa fa-exclamation-triangle',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'page_404_template_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Type', 'emeon' ),
				'options'     => array(
					'default' => esc_html__( 'Default', 'emeon' ),
				),
				'default'     => 'default',
			),
			array(
				'id'       => 'page_404_bg_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Default but I want to change the background image', 'emeon' ),
				'required' => array( 'page_404_template_type', '=', 'default' ),
			),
		)
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Password protected page template', 'emeon' ),
		'id'         => 'subsection_password_page',
		'icon'       => 'fa fa-lock',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'page_password_template_type',
				'type'        => 'radio',
				'title'       => esc_html__( 'Type', 'emeon' ),
				'options'     => array(
					'default' => esc_html__( 'Default', 'emeon' ),
				),
				'default'     => 'default',
			),
			array(
				'id'       => 'page_password_bg_image',
				'type'     => 'image',
				'title'    => esc_html__( 'Default but I want to change the background image', 'emeon' ),
				'required' => array( 'page_password_template_type', '=', 'default' ),
			),
		)
	) );

//MISCELLANEOUS
	$emeon_a13->emeon_set_sections( array(
		'title'    => esc_html__( 'Miscellaneous', 'emeon' ),
		'desc'     => '',
		'id'       => 'section_miscellaneous',
		'icon'     => 'fa fa-question',
		'priority' => 24,
		'fields'   => array(),
	) );

	$emeon_a13->emeon_set_sections( array(
		'title'      => esc_html__( 'Anchors', 'emeon' ),
		'desc'       => '',
		'id'         => 'subsection_anchors',
		'icon'       => 'fa fa-external-link',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'anchors_in_bar',
				'type'        => 'radio',
				'title'       => esc_html__( 'Display anchors in address bar', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'off',
			),
			array(
				'id'          => 'scroll_to_anchor',
				'type'        => 'radio',
				'title'       => esc_html__( 'Scroll to anchor handling', 'emeon' ),
				'description' => esc_html__( 'If enabled it will scroll to anchor after it is clicked on the same page. It can, however, conflict with plugins that uses the same mechanism, and the page can scroll in a weird way. In such case disable this feature.', 'emeon' ),
				'options'     => $on_off,
				'default'     => 'on',
			),
		)
	) );

	/*
 * <--- END SECTIONS
 */

	do_action( 'emeon_additional_theme_options' );
}

emeon_setup_theme_options();