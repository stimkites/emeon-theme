<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package emeon
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<?php
$logo = '';
if ( ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) &&
	 ( $_logo = wp_get_attachment_image_src( $custom_logo_id, 'full' ) ) ) {
	$logo = '<img class="logo-image" src="' . esc_url( $_logo[ 0 ] ) . '" alt="emeon" />';
}
?>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<header id="masthead" class="site-header">
		<div class="site-content site-header__content">

			<div class="site-branding">
				<a class="home-link" href="<?= get_home_url() ?>">
					<span class="logo-wrap">
						<?= $logo ?>
					</span>
					<span class="slogan">
						<?= get_bloginfo( 'description' ) ?>
					</span>
				</a>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
				<div class="mobile nav">
					<button class="toggle-mobile-menu"></button>
					<i class="far fa-search toggle-search mobile"></i>
				</div>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
				?>
			</nav><!-- #site-navigation -->

			<nav class="nav-shop">
				<ul class="menu">
					<li class="menu-item search">
						<a href="#">
							<i class="far fa-search toggle-search"></i>
						</a>
					</li>
					<li class="menu-item account">
						<a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>">
							<i class="far fa-user"></i>
						</a>
					</li>
				</ul>
			</nav>

		</div><!-- #content -->

	</header><!-- #masthead -->

	<div id="content" class="site-content page">
