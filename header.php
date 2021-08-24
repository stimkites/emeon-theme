<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="mid">
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

do_action('emeon_before_html');

?><!DOCTYPE html>
<!--[if IE 9]>    <html class="no-js lt-ie10" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<?php do_action('emeon_head_start'); ?>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="profile" href="https://gmpg.org/xfn/11" />
<?php
    wp_head();
?>
</head>

<?php
	global $emeon_a13;
	$slidertype = $emeon_a13->get_option('custom_slider_option'); 
?>

<body id="top" <?php body_class($slidertype); emeon_schema_args('body'); ?>>


<?php
// WordPress 5.2 support
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
//WordPress < 5.2
else {
    do_action( 'wp_body_open' );
}
do_action('emeon_body_start');
?>
<a class="skip-link" href="#content">
<?php esc_html_e( 'Skip to content', 'emeon' ); ?>
</a>
<div class="whole-layout">
<?php
    emeon_page_preloader();
    emeon_page_background();
    if( ! apply_filters('emeon_only_content', false) ) {
        emeon_theme_header();
    }
    ?>
    <div id="mid" class="to-move <?php echo esc_attr( emeon_get_mid_classes() ); ?>">