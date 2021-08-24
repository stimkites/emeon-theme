<?php
function emeon_meta_boxes_post() {
	$meta = array(
		/*
		 *
		 * Tab: Posts list
		 *
		 */
		'posts_list' => array(
			array(
				'name' => __('Posts list', 'emeon'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-list'
			),
			array(
				'name'        => __( 'Size of brick', 'emeon' ),
				'description' => __( 'What should be the width of this post on the Posts list?', 'emeon' ),
				'id'          => 'brick_ratio_x',
				'default'     => 1,
				'unit'        => '',
				'min'         => 1,
				'max'         => 4,
				'type'        => 'slider'
			),
		),


		/*
		 *
		 * Tab: Featured media
		 *
		 */
		'featured_media' => array(
			array(
				'name' => __('Featured media', 'emeon'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-star'
			),
			array(
				'name'        => __( 'Post media', 'emeon' ),
				'id'          => 'image_or_video',
				'default'     => 'post_image',
				'options'     => array(
					'post_image'  => __( 'Image', 'emeon' ),
				),
				'type'        => 'radio',
			),
			array(
				'name'        => __( 'Featured Image ', 'emeon' ). ' : ' . __( 'Parallax', 'emeon' ),
				'id'          => 'image_parallax',
				'default'     => 'off',
				'type'        => 'radio',
				'options'     => array(
					'on'  => __( 'Enable', 'emeon' ),
					'off' => __( 'Disable', 'emeon' ),
				),
				'required'    => array( 'image_or_video', '=', 'post_image' ),
			),
			array(
				'name'     => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Area height', 'emeon' ),
				'description' => __( 'This limits the height of the image so that the parallax can work.', 'emeon' ),
				'id'       => 'image_parallax_height',
				'default'  => '260',
				'unit'     => 'px',
				'min'      => 100,
				'max'      => 600,
				'type'     => 'slider',
				'required' => array(
					array( 'image_or_video', '=', 'post_image' ),
					array( 'image_parallax', '=', 'on' ),
				)
			),
		),

		/*
		 *
		 * Tab: Header
		 *
		 */
		'header' => array(
			array(
				'name' => __('Header', 'emeon'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-cogs'
			),
			array(
				'name'          => __( 'Hide content under the header', 'emeon' ),
				'description'   => __( 'Works only with the horizontal header.', 'emeon' ),
				'id'            => 'content_under_header',
				'global_value'  => 'G',
				'default'       => 'G',
				'parent_option' => 'post_content_under_header',
				'type'          => 'select',
				'options'       => array(
					'G'       => __( 'Global settings', 'emeon' ),
					'content' => __( 'Yes, hide the content', 'emeon' ),
					'title'   => __( 'Yes, hide the content and add top padding to the outside title bar.', 'emeon' ),
					'off'     => __( 'Turn it off', 'emeon' ),
				),
			),
		),

		/*
		 *
		 * Tab: Title bar
		 *
		 */
		'title_bar' => array(
			array(
				'name' => __('Title bar', 'emeon'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-text-width'
			),
			array(
				'name'        => __( 'Title bar', 'emeon' ),
				'description' => __( 'You can use global settings or override them here', 'emeon' ),
				'id'          => 'title_bar_settings',
				'default'     => 'global',
				'type'        => 'radio',
				'options'     => array(
					'global' => __( 'Global settings', 'emeon' ),
					'custom' => __( 'Use custom settings', 'emeon' ),
					'off'    => __( 'Turn it off', 'emeon' ),
				),
			),
			array(
				'name'        => __( 'Position', 'emeon' ),
				'id'          => 'title_bar_position',
				'default'     => 'outside',
				'type'        => 'radio',
				'options'     => array(
					'outside' => __( 'Before the content', 'emeon' ),
					'inside'  => __( 'Inside the content', 'emeon' ),
				),
				'description' => __( 'To set the background image for the "Before the content" option, use the <strong>featured image</strong>.', 'emeon' ),
				'required'    => array( 'title_bar_settings', '=', 'custom' ),
			),
			array(
				'name'        => __( 'Variant', 'emeon' ),
				'description' => '',
				'id'          => 'title_bar_variant',
				'default'     => 'classic',
				'options'     => array(
					'classic'  => __( 'Classic(to side)', 'emeon' ),
					'centered' => __( 'Centered', 'emeon' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Width', 'emeon' ),
				'description' => '',
				'id'          => 'title_bar_width',
				'default'     => 'full',
				'options'     => array(
					'full'  => __( 'Full', 'emeon' ),
					'boxed' => __( 'Boxed', 'emeon' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'     => __( 'How to fit the background image', 'emeon' ),
				'id'       => 'title_bar_image_fit',
				'default'  => 'repeat',
				'options'  => array(
					'cover'    => __( 'Cover', 'emeon' ),
					'contain'  => __( 'Contain', 'emeon' ),
					'fitV'     => __( 'Fit Vertically', 'emeon' ),
					'fitH'     => __( 'Fit Horizontally', 'emeon' ),
					'center'   => __( 'Just center', 'emeon' ),
					'repeat'   => __( 'Repeat', 'emeon' ),
					'repeat-x' => __( 'Repeat X', 'emeon' ),
					'repeat-y' => __( 'Repeat Y', 'emeon' ),
				),
				'type'     => 'select',
				'required' => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'emeon' ),
				'description' => '',
				'id'          => 'title_bar_parallax',
				'default'     => 'off',
				'options'     => array(
					'on'  => __( 'Enable', 'emeon' ),
					'off' => __( 'Disable', 'emeon' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'emeon' ). ' : ' . __( 'Type', 'emeon' ),
				'description' => __( 'It defines how the image will scroll in the background while the page is scrolled down.', 'emeon' ),
				'id'          => 'title_bar_parallax_type',
				'default'     => 'tb',
				'options'     => array(
					"tb"   => __( 'top to bottom', 'emeon' ),
					"bt"   => __( 'bottom to top', 'emeon' ),
					"lr"   => __( 'left to right', 'emeon' ),
					"rl"   => __( 'right to left', 'emeon' ),
					"tlbr" => __( 'top-left to bottom-right', 'emeon' ),
					"trbl" => __( 'top-right to bottom-left', 'emeon' ),
					"bltr" => __( 'bottom-left to top-right', 'emeon' ),
					"brtl" => __( 'bottom-right to top-left', 'emeon' ),
				),
				'type'        => 'select',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
					array( 'title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'emeon' ). ' : ' . __( 'Speed', 'emeon' ),
				'description' => __( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'emeon' ),
				'id'          => 'title_bar_parallax_speed',
				'default'     => '1.00',
				'type'        => 'text',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
					array( 'title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'name'        => __( 'Overlay color', 'emeon' ),
				'description' => __( 'Will be placed above the image(if used)', 'emeon' ),
				'id'          => 'title_bar_bg_color',
				'default'     => '',
				'type'        => 'color',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'     => esc_html__( 'Titles', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'id'       => 'title_bar_title_color',
				'default'  => '',
				'type'     => 'color',
				'required' => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Top/bottom padding', 'emeon' ),
				'description' => '',
				'id'          => 'title_bar_space_width',
				'default'     => '40px',
				'unit'        => 'px',
				'min'         => 0,
				'max'         => 600,
				'type'        => 'slider',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
		),

	);

	return apply_filters( 'emeon_meta_boxes_post', $meta );
}



function emeon_meta_boxes_page() {
	$sidebars = array_merge(
		array(
			'default' => __( 'Default for pages', 'emeon' ),
		),
		emeon_meta_get_user_sidebars()
	);

	$meta = array(
		/*
		 *
		 * Tab: Layout &amp; Sidebar
		 *
		 */
		'layout' => array(
			array(
				'name' => __('Layout &amp; Sidebar', 'emeon'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-wrench'
			),
			array(
				'name'          => __( 'Content Layout', 'emeon' ),
				'id'            => 'content_layout',
				'default'       => 'global',
				'global_value'  => 'global',
				'parent_option' => 'page_content_layout',
				'type'          => 'select',
				'options'       => array(
					'global'        => __( 'Global settings', 'emeon' ),
					'center'        => __( 'Center fixed width', 'emeon' ),
					'left'          => __( 'Left fixed width', 'emeon' ),
					'left_padding'  => __( 'Left fixed width + padding', 'emeon' ),
					'right'         => __( 'Right fixed width', 'emeon' ),
					'right_padding' => __( 'Right fixed width + padding', 'emeon' ),
					'full_fixed'    => __( 'Full width + fixed content', 'emeon' ),
					'full_padding'  => __( 'Full width + padding', 'emeon' ),
					'full'          => __( 'Full width', 'emeon' ),
				),
			),
			array(
				'name'        => esc_html__( 'Content', 'emeon' ). ' : ' .esc_html__( 'Top/bottom padding', 'emeon' ),
				'id'          => 'content_padding',
				'default'     => 'both',
				'type'        => 'select',
				'options'     => array(
					'both'   => __( 'Both on', 'emeon' ),
					'top'    => __( 'Only top', 'emeon' ),
					'bottom' => __( 'Only bottom', 'emeon' ),
					'off'    => __( 'Both off', 'emeon' ),
				),
			),
			array(
				'name'        => __( 'Content', 'emeon' ). ' : ' .esc_html__( 'Left/right padding', 'emeon' ),
				'id'          => 'content_side_padding',
				'default'     => 'both',
				'type'        => 'radio',
				'options'     => array(
					'both'   => __( 'Both on', 'emeon' ),
					'off'    => __( 'Both off', 'emeon' ),
				),
			),
			array(
				'name'          => __( 'Sidebar', 'emeon' ),
				'id'            => 'widget_area',
				'global_value'  => 'G',
				'default'       => 'G',
				'parent_option' => 'page_sidebar',
				'options'       => array(
					'G'                     => __( 'Global settings', 'emeon' ),
					'left-sidebar'          => __( 'Sidebar on the left', 'emeon' ),
					'left-sidebar_and_nav'  => __( 'Children Navigation', 'emeon' ) . ' + ' . __( 'Sidebar on the left', 'emeon' ),
					/* translators: %s: Children Navigation */
					'left-nav'             => sprintf( __( 'Only %s on the left', 'emeon' ), __( 'Children Navigation', 'emeon' ) ),
					'right-sidebar'         => __( 'Sidebar on the right', 'emeon' ),
					'right-sidebar_and_nav' => __( 'Children Navigation', 'emeon' ) . ' + ' . __( 'Sidebar on the right', 'emeon' ),
					/* translators: %s: Children Navigation */
					'right-nav'             => sprintf( __( 'Only %s on the right', 'emeon' ), __( 'Children Navigation', 'emeon' ) ),
					'off'                   => __( 'Off', 'emeon' ),
				),
				'type'          => 'select',
			),
			array(
				'name'     => __( 'Sidebar to show', 'emeon' ),
				'id'       => 'sidebar_to_show',
				'default'  => 'default',
				'options'  => $sidebars,
				'type'     => 'select',
				'required' => array( 'widget_area', '!=', 'off' ),
			),
		),

		/*
		 *
		 * Tab: Header
		 *
		 */
		'header' => array(
			array(
				'name' => __('Header', 'emeon'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-cogs'
			),
			array(
				'name'          => __( 'Hide content under the header', 'emeon' ),
				'description'   => __( 'Works only with the horizontal header.', 'emeon' ),
				'id'            => 'content_under_header',
				'global_value'  => 'G',
				'default'       => 'G',
				'parent_option' => 'page_content_under_header',
				'type'          => 'select',
				'options'       => array(
					'G'       => __( 'Global settings', 'emeon' ),
					'content' => __( 'Yes, hide the content', 'emeon' ),
					'title'   => __( 'Yes, hide the content and add top padding to the outside title bar.', 'emeon' ),
					'off'     => __( 'Turn it off', 'emeon' ),
				),
			),
			array(
				'name'          => __( 'Show header from the Nth row', 'emeon' ),
				'description'   => __( 'Works only with the horizontal header.', 'emeon' ). '<br />' . __( 'If you use Elementor or WPBakery Page Builder, then you can decide to show header after the content is scrolled to Nth row. Thanks to that you can have a clean welcome screen.', 'emeon' ),
				'id'            => 'horizontal_header_show_header_at',
				'default'       => '0',
				'type'          => 'select',
				'options'       => array(
					'0' => __( 'Show always', 'emeon' ),
					'1' => __( 'from 1st row', 'emeon' ),
					'2' => __( 'from 2nd row', 'emeon' ),
					'3' => __( 'from 3rd row', 'emeon' ),
					'4' => __( 'from 4th row', 'emeon' ),
					'5' => __( 'from 5th row', 'emeon' ),
				),
			),
		),

		/*
		 *
		 * Tab: Title bar
		 *
		 */
		'title_bar' => array(
			array(
				'name' => __('Title bar', 'emeon'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-text-width'
			),
			array(
				'name'        => __( 'Title bar', 'emeon' ),
				'description' => __( 'You can use global settings or override them here', 'emeon' ),
				'id'          => 'title_bar_settings',
				'default'     => 'global',
				'type'        => 'radio',
				'options'     => array(
					'global' => __( 'Global settings', 'emeon' ),
					'custom' => __( 'Use custom settings', 'emeon' ),
					'off'    => __( 'Turn it off', 'emeon' ),
				),
			),
			array(
				'name'        => __( 'Position', 'emeon' ),
				'id'          => 'title_bar_position',
				'default'     => 'outside',
				'type'        => 'radio',
				'options'     => array(
					'outside' => __( 'Before the content', 'emeon' ),
					'inside'  => __( 'Inside the content', 'emeon' ),
				),
				'description' => __( 'To set the background image for the "Before the content" option, use the <strong>featured image</strong>.', 'emeon' ),
				'required'    => array( 'title_bar_settings', '=', 'custom' ),
			),
			array(
				'name'        => __( 'Variant', 'emeon' ),
				'description' => '',
				'id'          => 'title_bar_variant',
				'default'     => 'classic',
				'options'     => array(
					'classic'  => __( 'Classic(to side)', 'emeon' ),
					'centered' => __( 'Centered', 'emeon' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Width', 'emeon' ),
				'description' => '',
				'id'          => 'title_bar_width',
				'default'     => 'full',
				'options'     => array(
					'full'  => __( 'Full', 'emeon' ),
					'boxed' => __( 'Boxed', 'emeon' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'     => __( 'How to fit the background image', 'emeon' ),
				'id'       => 'title_bar_image_fit',
				'default'  => 'repeat',
				'options'  => array(
					'cover'    => __( 'Cover', 'emeon' ),
					'contain'  => __( 'Contain', 'emeon' ),
					'fitV'     => __( 'Fit Vertically', 'emeon' ),
					'fitH'     => __( 'Fit Horizontally', 'emeon' ),
					'center'   => __( 'Just center', 'emeon' ),
					'repeat'   => __( 'Repeat', 'emeon' ),
					'repeat-x' => __( 'Repeat X', 'emeon' ),
					'repeat-y' => __( 'Repeat Y', 'emeon' ),
				),
				'type'     => 'select',
				'required' => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'emeon' ),
				'description' => '',
				'id'          => 'title_bar_parallax',
				'default'     => 'off',
				'options'     => array(
					'on'  => __( 'Enable', 'emeon' ),
					'off' => __( 'Disable', 'emeon' ),
				),
				'type'        => 'radio',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'emeon' ). ' : ' . __( 'Type', 'emeon' ),
				'description' => __( 'It defines how the image will scroll in the background while the page is scrolled down.', 'emeon' ),
				'id'          => 'title_bar_parallax_type',
				'default'     => 'tb',
				'options'     => array(
					"tb"   => __( 'top to bottom', 'emeon' ),
					"bt"   => __( 'bottom to top', 'emeon' ),
					"lr"   => __( 'left to right', 'emeon' ),
					"rl"   => __( 'right to left', 'emeon' ),
					"tlbr" => __( 'top-left to bottom-right', 'emeon' ),
					"trbl" => __( 'top-right to bottom-left', 'emeon' ),
					"bltr" => __( 'bottom-left to top-right', 'emeon' ),
					"brtl" => __( 'bottom-right to top-left', 'emeon' ),
				),
				'type'        => 'select',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
					array( 'title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'name'        => __( 'Parallax', 'emeon' ). ' : ' . __( 'Speed', 'emeon' ),
				'description' => __( 'It will be only used for the background that is repeated. If the background is set to not repeat this value will be ignored.', 'emeon' ),
				'id'          => 'title_bar_parallax_speed',
				'default'     => '1.00',
				'type'        => 'text',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
					array( 'title_bar_parallax', '=', 'on' ),
				)
			),
			array(
				'name'        => __( 'Overlay color', 'emeon' ),
				'description' => __( 'Will be placed above the image(if used)', 'emeon' ),
				'id'          => 'title_bar_bg_color',
				'default'     => '',
				'type'        => 'color',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'     => esc_html__( 'Titles', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'id'       => 'title_bar_title_color',
				'default'  => '',
				'type'     => 'color',
				'required' => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => esc_html__( 'Other elements', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
				'id'          => 'title_bar_color_1',
				'default'     => '',
				'type'        => 'color',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
			array(
				'name'        => __( 'Top/bottom padding', 'emeon' ),
				'description' => '',
				'id'          => 'title_bar_space_width',
				'default'     => '40px',
				'unit'        => 'px',
				'min'         => 0,
				'max'         => 600,
				'type'        => 'slider',
				'required'    => array(
					array( 'title_bar_settings', '=', 'custom' ),
					array( 'title_bar_position', '!=', 'inside' ),
				)
			),
		),

		/*
		 *
		 * Tab: Featured media
		 *
		 */
		'featured_media' => array(
			array(
				'name' => __('Featured media', 'emeon'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-star'
			),
			array(
				'name'        => __( 'Post media', 'emeon' ),
				'id'          => 'image_or_video',
				'default'     => 'post_image',
				'options'     => array(
					'post_image'  => __( 'Image', 'emeon' ),
				),
				'type'        => 'radio',
			),
			array(
				'name'        => __( 'Featured Image ', 'emeon' ). ' : ' . __( 'Parallax', 'emeon' ),
				'id'          => 'image_parallax',
				'default'     => 'off',
				'type'        => 'radio',
				'options'     => array(
					'on'  => __( 'Enable', 'emeon' ),
					'off' => __( 'Disable', 'emeon' ),
				),
				'required'    => array( 'image_or_video', '=', 'post_image' ),
			),
			array(
				'name'     => esc_html__( 'Parallax', 'emeon' ). ' : ' . esc_html__( 'Area height', 'emeon' ),
				'description' => __( 'This limits the height of the image so that the parallax can work.', 'emeon' ),
				'id'       => 'image_parallax_height',
				'default'  => '260',
				'unit'     => 'px',
				'min'      => 100,
				'max'      => 600,
				'type'     => 'slider',
				'required' => array(
					array( 'image_or_video', '=', 'post_image' ),
					array( 'image_parallax', '=', 'on' ),
				)
			),
		),

		/*
		 *
		 * Tab: Sticky one page mode
		 *
		 */
		'sticky_one_page' => array(
			array(
				'name' => __('Sticky One Page mode', 'emeon'),
				'type' => 'fieldset',
				'tab'   => true,
				'icon'  => 'fa fa-anchor'
			),
			array(
				'name'        => __( 'Sticky One Page mode', 'emeon' ),
				'description' => __( 'This works only when page is designed with WPBakery Page Builder. With this option enabled, the page will turn into a vertical slider to the full height of the browser window, and each row created in the WPBakery Page Builder is a single slide.', 'emeon' ),
				'id'          => 'content_sticky_one_page',
				'default'     => 'off',
				'type'        => 'radio',
				'options'     => array(
					'on'  => __( 'Enable', 'emeon' ),
					'off' => __( 'Disable', 'emeon' ),
				),
			),
			array(
				'name'     => __( 'Color of navigation bullets', 'emeon' ),
				'id'       => 'content_sticky_one_page_bullet_color',
				'default'  => 'rgba(0,0,0,1)',
				'type'     => 'color',
				'required' => array(
					array( 'content_sticky_one_page', '=', 'on' )
				)
			),
			array(
				'name'        => __( 'Default bullets icon', 'emeon' ),
				'id'          => 'content_sticky_one_page_bullet_icon',
				'default'     => '',
				'type'        => 'text',
				'input_class' => 'a13-fa-icon a13-full-class',
				'required'    => array(
					array( 'content_sticky_one_page', '=', 'on' )
				)
			),
		),
	);

	return apply_filters( 'emeon_meta_boxes_page', $meta );
}

function emeon_meta_boxes_images_manager() {
	return apply_filters( 'emeon_meta_boxes_images_manager', array('images_manager' => array()) );
}



function emeon_get_socials_array() {
	global $emeon_a13;

	$tmp_arr = array();
	$socials = $emeon_a13->emeon_get_social_icons_list();
	foreach ( $socials as $id => $social ) {
		array_push( $tmp_arr, array( 'name' => $social, 'id' => $id, 'type' => 'text' ) );
	}
	return $tmp_arr;
}



function emeon_meta_boxes_people() {
	$meta =
		array(
			/*
			 *
			 * Tab: General
			 *
			 */
			'general' => array(
				array(
					'name' => __('General', 'emeon'),
					'type' => 'fieldset',
					'tab'   => true,
					'icon'  => 'fa fa-wrench'
				),
				array(
						'name'        => __( 'Subtitle', 'emeon' ),
						'description' => __( 'You can use HTML here.', 'emeon' ),
						'id'          => 'subtitle',
						'default'     => '',
						'type'        => 'text'
				),
				array(
						'name'    => __( 'Testimonial', 'emeon' ),
						'desc'    => '',
						'id'      => 'testimonial',
						'default' => '',
						'type'    => 'textarea'
				),
				array(
						'name'        => __( 'Overlay color', 'emeon' ),
						'id'          => 'overlay_bg_color',
						'default'     => 'rgba(0,0,0,0.5)',
						'type'        => 'color'
				),
				array(
						'name'        => __( 'Overlay', 'emeon' ). ' : ' .esc_html__( 'Text color', 'emeon' ),
						'id'          => 'overlay_font_color',
						'default'     => 'rgba(255,255,255,1)',
						'type'        => 'color'
				),
			),

			/*
			 *
			 * Tab: Socials
			 *
			 */
			'socials' => array_merge(
				array(
					array(
						'name' => __('Social icons', 'emeon'),
						'type' => 'fieldset',
						'tab'   => true,
						'icon'  => 'fa fa-facebook-official'
					),
				),
				emeon_get_socials_array()
			),
		);

	return $meta;
}