<?php
/**
 * Emeon header
 */

defined( 'ABSPATH' ) or exit;

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


<body id="top" class="<?=apply_filters( 'emeon_body_class', 'main-body emeon-body' )?>" >


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

<div class="header-content">
    <div class="header-content-wrapper">
        <div class="site-branding">
			<?php the_custom_logo() ?>
        </div><!-- .site-branding -->
        <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'header_menu',
            ) );
            ?>
        </nav><!-- #site-navigation -->
    </div><!-- #content -->
</div>
