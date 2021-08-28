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
if( ( $custom_logo_id = get_theme_mod( 'custom_logo' ) ) &&
    ( $_logo = wp_get_attachment_image_src( $custom_logo_id , 'full' ) ) )
        $logo = '<a href="'. get_home_url() .'"><img src="'. esc_url( $_logo[0] ) .'"></a>';
?>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<header id="masthead" class="site-header">
        <div class="site-branding">
            <div class="logo-wrap">
				<?=$logo?>
            </div>
        </div><!-- .site-branding -->
		<div class="site-content">
            <div class="inline-branding">
                <div class="slogan">
                    <?=get_bloginfo( 'description' )?>
                </div>
                <div class="logo-wrap">
		            <?=$logo?>
                </div>
            </div>
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
			<div class="nav-shop">
				<ul>
					<li class="menu-item search desktop">
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
			</div>
		</div><!-- #content -->
		<div class="main-search">
			<div id="content">
				<?php get_search_form(); ?>
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content page">
