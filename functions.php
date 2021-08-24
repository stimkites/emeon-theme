<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/* Here you can insert your functions, filters and actions. */

/* That's all, stop editing! Make a great website!. */

/* Init of the framework */

/* This function exist in WP 4.7 and above.
 * Theme has protection from runing it on version below 4.7
 * However, it has to at least run, to give user info about having not compatible WP version :-)
 */
if( function_exists('get_theme_file_path') ){
	/** @noinspection PhpIncludeInspection */
	require_once( get_theme_file_path( '/advance/class-emeon-framework.php' ) );
}
else{
	/** @noinspection PhpIncludeInspection */
	require_once( get_template_directory() . '/advance/class-emeon-framework.php' );
}

global $emeon_a13;
$emeon_a13 = new Emeon_Framework();
$emeon_a13->emeon_start();

function emeon_scripts() {
	wp_enqueue_script( 'emeon-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20190715', true );
	wp_enqueue_script( 'emeon-customscripts', get_template_directory_uri() . '/js/custom.js', array('jquery') );
	wp_localize_script( 'emeon-navigation', 'NavigationScreenReaderText', array() );
}
add_action( 'wp_enqueue_scripts', 'emeon_scripts' );