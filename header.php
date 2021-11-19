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

defined( 'ABSPATH' ) or exit;

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
$theme_uri = get_template_directory_uri();
?>

<body <?php body_class(); ?>>
<div id="page" class="site bg-light">
	<header id="masthead" class="site-header">
		<div class="site-content site-header__content container">

			<div class="site-branding">
				<a class="home-link" href="<?= get_home_url() ?>">
					<span class="logo-wrap">
						<img class="logo-image"
						     src="<?php echo $theme_uri . '/img/emeon-logo-2.svg' ?>" alt="emeon"/>
					</span>
					<span class="slogan">
						<?= get_bloginfo( 'description' ) ?>
					</span>
					<span class="logo-scrolled">
						<img class="logo-image"
						     src="<?php echo $theme_uri . '/img/emeon-logo-2-cr.svg' ?>" alt="emeon"/>
					</span>
				</a>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation <?= ( ! is_user_logged_in() ? 'show-join' : '' ) ?>">
				<button class="toggle-mobile-menu"></button>
				<?php
				wp_nav_menu( [
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				] );
				?>
			</nav><!-- #site-navigation -->

			<nav class="nav-shop">
				<ul class="menu">
					<li class="menu-item search">
						<a href="#" id="toggle-search">
							<i class="far fa-search toggle-search"></i>
							<button class="close-btn"></button>
						</a>
					</li>
					<li class="menu-item account">
						<a href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>">
							<i class="far fa-user"></i>
						</a>
					</li>
				</ul>
			</nav>

            <?php get_search_form(); ?>

		</div><!-- #content -->

	</header><!-- #masthead -->

	<div id="content" class="site-content page container">
