<?php

namespace Emeon\Theme;

/**
 * Add custom templates to WP
 * Override WC templates
 * Use theme templates if any found
 */
final class Template {

	/**
	 * Templates used for Checkout
	 */
	const templates = [
		TPL . '/front/page/page-checkout.php' => 'Wetail Stripe Checkout'
	];

	/**
	 * WooCommerce templates override
	 *
	 * @var array
	 */
	private static $_tpl = null;

	/**
	 * Initialize
	 */
	public static function init(){
		//Register page template for the checkout
		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) )
			add_filter( 'page_attributes_dropdown_pages_args',  __CLASS__ . '::register'         );   // <= 4.6
		else
			add_filter( 'theme_page_templates',                 __CLASS__ . '::add'              );   // >  4.6
		// Add templates into page cache
		add_filter( 'wp_insert_post_data',                      __CLASS__ . '::register'         );
		// Render own page templates
		add_filter( 'template_include',                         __CLASS__ . '::page'             );
		//Render own wc templates
		add_filter( 'wc_get_template',                          __CLASS__ . '::wc', 999999999, 2 );
		self::collect_woo_tpl();
	}

	/**
	 * Collect WooCommerce templates to override
	 */
	private static function collect_woo_tpl(){
		if( self::$_tpl ) return;
		$prefixes = [
			'plugin' => TPL    . '/front/woocommerce/',
			'theme'  => get_stylesheet_directory(). '/woocommerce/'
		];
		foreach( $prefixes as $type=>$prefix )
			foreach( __Autoloader::scan( $prefix . '*.php' ) as $file )
				self::$_tpl[ $type ][ str_replace( $prefix, '', $file ) ] = $file;
	}


	/**
	 * Add templates to the page dropdown for v4.7+
	 *
	 * @param array $posts_templates
	 * @return array
	 */
	public static function add( $posts_templates ) {
		return array_merge( $posts_templates, self::templates );
	}

	/**
	 * Adds our template to the pages cache in order to trick WordPress
	 * into thinking the template file exists where it doesn't really exist.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public static function register( $args ) {
		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) $templates = [];
		wp_cache_delete( $cache_key , 'themes');
		$templates = array_merge( $templates, self::templates );
		wp_cache_add( $cache_key, $templates, 'themes', 1800 );
		return $args;
	}

	/**
	 * Checks if the template is assigned to the page and renders it
	 *
	 * @param string $location
	 *
	 * @return string
	 */
	public static function page( $location ) {
		global $post;
		if ( ! $post || is_admin() ) return $location;
		$post_template = get_post_meta( $post->ID, '_wp_page_template', true );
		if ( ! isset( self::templates[ $post_template ] ) ) return $location;
		return ( file_exists( $post_template ) ? $post_template : $location );
	}

	/**
	 * Render WooCommerce template
	 *
	 * @param string $location
	 * @param string $template_name
	 *
	 * @return string
	 */
	public static function wc( $location, $template_name ){
		if( ! empty( self::$_tpl[ 'theme' ][ $template_name ] ) ) return self::$_tpl[ 'theme' ][ $template_name ];
		if( ! empty( self::$_tpl[ 'plugin'][ $template_name ] ) ) return self::$_tpl[ 'plugin'][ $template_name ];
		return $location;
	}

}
