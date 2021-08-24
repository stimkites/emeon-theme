<?php
/**
 * Template used for displaying password protected page.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


global $emeon_a13;


//custom template
if($emeon_a13->get_option( 'page_password_template_type' ) === 'custom' ){
	$_page = $emeon_a13->get_option( 'page_password_template' );

	define('EMEON_CUSTOM_PASSWORD_PROTECTED', true );

	//make query
	$query = new WP_Query( array('page_id' => $_page ) );

	//add password form to content
	add_filter( 'the_content', 'emeon_add_password_form_to_template' );

	//show
	emeon_page_like_content($query);

	// Reset Post Data
	wp_reset_postdata();

	return;
}

//default template
else{
	define('EMEON_PASSWORD_PROTECTED', true); //to get proper class in body

	$_title = '<span class="fa fa-lock emblem"></span>' . esc_html__( 'This content is password protected.', 'emeon' )
	         .'<br />'
	         .esc_html__( 'To view it please enter your password below', 'emeon' );

	get_header();

	emeon_title_bar( 'outside', $_title );

	echo wp_kses_post(emeon_password_form()); //escaped on creation

	get_footer();
}