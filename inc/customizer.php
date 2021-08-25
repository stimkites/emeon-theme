<?php
/**
 * emeon Theme Customizer
 *
 * @by Stim rework, v.0.0.2
 *
 * @wrike https://www.wrike.com/open.htm?id=361047162
 *
 * @package emeon
 */

namespace Wetail\emeon;

Customizer::load();

if( class_exists( __NAMESPACE__ . '\Customizer' ) ) return;

final class Customizer {

	/**
	 * Initialization for the base class
	 */
	public static function load(){
		add_action( 'customize_register',     __CLASS__ . '::register' );
		add_action( 'customize_preview_init', __CLASS__ . '::enqueue'  );
	}

	/**
	 * Registrations
	 *
	 * @param \WP_Customize_Manager $customizer
	 *
	 */
	public static function register( $customizer ){
		/**
		 * Blog name and description
		 */
		$customizer->get_setting( 'blogname'        )->transport = 'postMessage';
		$customizer->get_setting( 'blogdescription' )->transport = 'postMessage';
		$customizer->get_setting( 'header_textcolor')->transport = 'postMessage';
		if ( isset( $customizer->selective_refresh ) ) {
			$customizer->selective_refresh->add_partial( 'blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => __CLASS__ . '::partial_blogname',
			) );
			$customizer->selective_refresh->add_partial( 'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => __CLASS__ . '::partial_blogdescription',
			) );
		}

	}

	/**
	 * Render the site title for the selective refresh partial.
	 *
	 * @return void
	 */
	function emeon_customize_partial_blogname() {
		bloginfo( 'name' );
	}

	/**
	 * Render the site tagline for the selective refresh partial.
	 *
	 * @return void
	 */
	function emeon_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}

	/**
	 * Enqueue preview JS
	 */
	public static function enqueue(){
		$no_cache = time();
		if( ! defined( 'CUSTOMIZING' ) ) define( 'CUSTOMIZING', 1 );
		$url = get_template_directory_uri();
		wp_register_script( 'emeon_preview',  $url . '/js/customizer.js', ['jquery', 'customize-preview'], $no_cache );
		wp_enqueue_script(  'emeon_preview',  $url . '/js/customizer.js', ['jquery', 'customize-preview'], $no_cache );
	}

}
