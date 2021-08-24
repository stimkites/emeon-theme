<?php
/**
 * Functions that operates in themes header element
 */


if ( ! function_exists( 'emeon_header_logo' ) ) {
	/**
	 * Prints logo of site
	 */
	function emeon_header_logo() {
		global $emeon_a13;
		$logo_sources = array();
		$logo_sizes = array();
		$logos_name_map = array(
			'normal' => 'logo_image',
			'sticky' => 'header_sticky_logo_image',
		);
		//fill sources & sizes
		foreach( $logos_name_map as $variant => $name ) {
			$logo_sources[ $variant ]         = $emeon_a13->get_option_media_url( $name );
			$temp                             = $emeon_a13->get_option( $name );
			$logo_sizes[ $variant ]['width']  = isset( $temp['width'] ) ? $temp['width'] : '';
			$logo_sizes[ $variant ]['height'] = isset( $temp['height'] ) ? $temp['height'] : '';
			$logo_sizes[ $variant ]['id']     = isset( $temp['id'] ) ? $temp['id'] : '';
		}

		//check for WordPress feature logo if theme logo is not present
		if( strlen( $logo_sources['normal'] ) === 0 && has_custom_logo() ){
			$logo_sizes['normal']['id']     = get_theme_mod( 'custom_logo' );
			$logo_sizes['normal']['width']  = '';
			$logo_sizes['normal']['height'] = '';
			$logo_sources['normal']         = wp_get_attachment_image_src( $logo_sizes['normal']['id'], 'full' );
			$logo_sources['normal']         = $logo_sources['normal'][0];//support for PHP 5.3 or lower
		}

		$img_logo            = $emeon_a13->get_option( 'logo_type' ) === 'image' && strlen( $logo_sources['normal'] );
		$color_variant       = emeon_horizontal_header_color_variant();
		$normal_logo_classes = array('logo', 'normal-logo');

		$normal_logo_classes[] = $img_logo ? 'image-logo' : 'text-logo';

		$html = '<a class="'. esc_attr( implode(' ', $normal_logo_classes  ) ) .'" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home"'.emeon_get_schema_args('url').'>';

		if ( $img_logo ) {
			$html .= '<img src="' . esc_url( $logo_sources['normal'] ) . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" width="' . esc_attr( $logo_sizes['normal']['width'] ) . '" height="' . esc_attr( $logo_sizes['normal']['height'] ) . '"'.emeon_get_schema_args('logo_image').' />';
		}
		else {
			$logo_text = esc_html( $emeon_a13->get_option( 'logo_text' ) );
			//try site name if no text
			$logo_text = strlen($logo_text) > 0 ? $logo_text : get_bloginfo('name');

			$html .= $logo_text;
		}

		$html .= '</a>';

		//everything is escaped on creation
		echo wp_kses_post($html);
	}
}

if ( ! function_exists( 'emeon_header_menu' ) ) {
	/**
	 * Prints main menu usually located in header
	 *
	 * @param string $walker type of walker we should run this menu with
	 */
	function emeon_header_menu( $walker = '' ) {
		/* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.
		 * The menu assigned to the primary position is the one used.
		 * If none is assigned, the menu with the lowest ID is used.
		 */

		global $emeon_a13;

		$menu_hover_effect = $emeon_a13->get_option('menu_hover_effect');
		$menu_classes = 'top-menu';
		$menu_classes .= (strlen($menu_hover_effect) && $menu_hover_effect !== 'none') ? ' with-effect menu--'.$menu_hover_effect : '';
		$menu_classes .= $emeon_a13->get_option('submenu_open_icons') === 'on' ? ' opener-icons-on' : ' opener-icons-off';
		$is_menu = has_nav_menu( 'header-menu' );

		$no_menu_args = array(
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'container'   => 'ul',
			'before'      => '',
			'after'       => '',
			'menu_class'  => $menu_classes
		);

		if($is_menu){
			/** @noinspection PhpIncludeInspection */
			get_template_part('advance/walkers/classic');
			$menu_args = array(
				'container'       => 'div',
				'container_class' => 'menu-container',
				'link_before'     => '<span>',
				'link_after'      => '</span>',
				'menu_class'      => $menu_classes,
				'theme_location'  => 'header-menu',
				'walker'  => new EMEON_menu_walker,
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			);
		}

		if ( $is_menu ){
			wp_nav_menu( array(
				'container'       => 'div',
				'container_class' => 'menu-container',
				'link_before'     => '<span>',
				'link_after'      => '</span>',
				'menu_class'      => $menu_classes,
				'theme_location'  => 'header-menu',
				'walker'  => new EMEON_menu_walker,
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			) );
		}
		else{
			//no walker
			if($walker === ''){
				echo '<div class="menu-container">';
			}

			if( ! isset( $no_menu_args['walker'] ) ){
				/** @noinspection PhpIncludeInspection */
				get_template_part('advance/walkers/menu', 'pages');
				$no_menu_args['walker'] = new EMEON_pages_menu_walker;
			}

			wp_page_menu( $no_menu_args );

			//no walker
			if($walker === ''){
				echo '</div>';
			}
		}
	}
}


if ( ! function_exists( 'emeon_get_header_toolbar' ) ) {
	/**
	 * Prints out header tools
	 *
	 * @param int $icons taken by reference so it can be used back in place of call
	 *
	 * @return string   HTML
	 */
	function emeon_get_header_toolbar( &$icons ) {
		global $emeon_a13, $woocommerce;

		$hidden_sidebar    = is_active_sidebar( 'side-widget-area' );
		$basket_sidebar    = emeon_is_woocommerce_activated() && is_active_sidebar( 'basket-widget-area' );
		$header_search     = $emeon_a13->get_option( 'header_search' ) === 'on';
		$allow_mobile_menu = $emeon_a13->get_option( 'header_main_menu' ) === 'on' && $emeon_a13->get_option( 'menu_allow_mobile_menu' ) !== 'off';
		$button            = $emeon_a13->get_option( 'header_button' );
		$button_link       = $emeon_a13->get_option( 'header_button_link' );
		$button_new_tab    = $emeon_a13->get_option( 'header_button_link_target' ) === 'on' ? ' target="_blank"' : '';
		$button_on_mobile  = $emeon_a13->get_option( 'header_button_display_on_mobile' ) === 'off' ? ' hide_on_mobile' : '';
		$is_button         = strlen( $button );
		$icons             = 3;

		//default or custom icons
		$mm_type    = $emeon_a13->get_option( 'header_tools_mobile_menu_icon_type' );
		$hs_type    = $emeon_a13->get_option( 'header_tools_hidden_sidebar_icon_type' );
		$bs_type    = $emeon_a13->get_option( 'header_tools_basket_sidebar_icon_type' );
		$hsrch_type = $emeon_a13->get_option( 'header_tools_header_search_icon_type' );

		//mobile menu icon
		$mobile_menu_icon = $mm_type === 'custom' ?  'fa fa-'.$emeon_a13->get_option( 'header_tools_mobile_menu_icon' ) : 'a13icon-menu';

		//hidden sidebar icon
		$hidden_sidebar_icon = $hs_type === 'custom' ?  'fa fa-'.$emeon_a13->get_option( 'header_tools_hidden_sidebar_icon' ) : 'a13icon-add-to-list';

		//icons with no option for animation
		$basket_sidebar_icon = $bs_type === 'custom' ?  'fa fa-'.$emeon_a13->get_option( 'header_tools_basket_sidebar_icon' ) : 'fa fa-shopping-bag';
		$header_search_icon = $hsrch_type === 'custom' ?  'fa fa-'.$emeon_a13->get_option( 'header_tools_header_search_icon' ) : 'a13icon-search';

		//count how many icons are used
		if ( ! $hidden_sidebar ) {
			$icons --;
		}
		if ( ! $basket_sidebar ) {
			$icons --;
		}
		if ( ! $header_search ) {
			$icons --;
		}

		$classes = ' icons-' . $icons;

		//check if only mobile menu is used
		if($icons === 0 && !$is_button && $allow_mobile_menu){
			$classes .= ' only-menu';
		}

		//prepare icons HTML
		
		$tools_html =		        
		        ( $hidden_sidebar ? '<button id="side-menu-switch" class="'.esc_attr($hidden_sidebar_icon).' tool" title="' . esc_attr__( 'More info', 'emeon' ) . '">'.($hs_type === 'animated'? '<i></i>' : '').'<span class="screen-reader-text">' . esc_attr__( 'More info', 'emeon' ) . '</span></button>' : '' ) ;

		$tools_html = trim( apply_filters( 'emeon_header_tools', $tools_html) );

		if(strlen($tools_html)){//$icons > 0 || $allow_mobile_menu || $is_button
			return '<div id="header-tools" class="' . esc_attr( $classes ) . '">'.$tools_html.'</div>';
		}

		return '';
	}
}

if ( ! function_exists( 'emeon_content_under_header' ) ) {
	/**
	 * Checks if for current page content should be hidden under header
	 */
	function emeon_content_under_header() {
		global $emeon_a13;

		$page_type = emeon_what_page_type_is_it();
		$value = 'off';

		if($page_type['product']){
			$value = $emeon_a13->get_option( 'product_content_under_header', 'off' );
		}
		//cart and others not sidebar/title pages of woocommerce
		elseif( ( $page_type['shop'] && !emeon_is_woocommerce_sidebar_page() ) ||
		        //wish list
		        ( class_exists( 'YITH_WCWL' ) && (get_the_ID() === (int)yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) ) ) ) ){
			$value = $emeon_a13->get_option( 'shop_no_major_pages_content_under_header', 'off' );
		}
		//shop
		elseif ( $page_type['shop'] ) {
			$value = $emeon_a13->get_option( 'shop_content_under_header' );
		}
		//pages, posts
		elseif ( $page_type['page'] || $page_type['post'] ) {
			$value = $emeon_a13->emeon_get_meta('_content_under_header', get_the_ID() );
		}
		//blog
		elseif ( $page_type['blog_type'] ) {
			$value = $emeon_a13->get_option( 'blog_content_under_header' );
		}

		return $value;
	}
}

if ( ! function_exists( 'emeon_theme_header' ) ) {
	/**
	 * Print whole header
	 */
	function emeon_theme_header() {
		global $emeon_a13;

		//Header Footer Elementor Plugin support
		if ( function_exists( 'hfe_render_header' ) ) {
			hfe_render_header();
		}

		if( $emeon_a13->get_option( 'header_switch', 'on' ) === 'off' ){
			//no theme header
			return;
		}

		if ( function_exists( 'elementor_location_exits' ) && elementor_location_exits( 'header', true ) ) {
			echo '<div class="container-elementor-header">';
		}

		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {

			$header_type    = $emeon_a13->get_option( 'header_type' );
			$header_variant = $emeon_a13->get_option( 'header_horizontal_variant' );

			if(strpos($header_variant, 'one_line') !== false){
				$header_subtype = 'one-line';
			}
			else{
				$header_subtype = 'multi-line';
			}
			get_template_part( 'header-variants/' . $header_type, $header_subtype );
		}

		if ( function_exists( 'elementor_location_exits' ) && elementor_location_exits( 'header', true ) ) {
			echo '</div>';//.container-elementor-header
		}
	}
}