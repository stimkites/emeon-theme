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
    <meta name="keywords" content="remote job, online job, online work, emeon job, vacancies, free vacancies, web-development, web-design, web-master, php developer, get job" />
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
				new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-MNS344J');</script>
	<!-- End Google Tag Manager -->

	<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
		(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
			m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
		(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

		ym(86684810, "init", {
			clickmap:true,
			trackLinks:true,
			accurateTrackBounce:true,
			webvisor:true
		});
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/86684810" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->

	<?php wp_head(); ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-213968658-1">
    </script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-213968658-1');
    </script>

</head>

<?php
$theme_uri = get_template_directory_uri();
?>

<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MNS344J"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<div id="page" class="site bg-light">
	<header id="masthead" class="site-header">
		<div class="site-content site-header__content container">

			<div class="site-branding">
				<a class="home-link" href="<?= get_home_url() ?>">
					<span class="logo-wrap">
						<img class="logo-image"
						     src="<?php echo $theme_uri . '/img/emeon-logo-2.svg' ?>" alt="emeon"/>
					</span>
					<span class="slogan">Where the best careers begin...</span>
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
