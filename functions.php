<?php
/**
 * Emeon functions and definitions
 *
 * @package emeon
 */

defined( 'ABSPATH' ) or exit;

/**
 * Constants
 */
const
	EMEON_PATH     = __DIR__,
	EMEON_TPL      = EMEON_PATH . '/templates',
	EMEON_SLUG     = 'emeon-theme',
	EMEON_STATUSES = [ 'active', 'moderation', 'archive' ],
	EMEON_TYPES    = [ 'vacancies', 'candidates', 'emeon-team', 'want-join', 'user-stories' ],
	EMEON_AUTHEPS  = [ '/add-edit/', ],
	EMEON_CURRENCY = 'EUR',
	EMEON_LOGINS   = 5, // Login attempts limit
	EMEON_CUR_SYMB = '€',
	EMEON_EXP_LVL  = [ 'Career start', 'A few months', 'Half a year', '1-3 years', '3-5 years', '5+ years' ],
	EMEON_CAPTCHA  = [
		'key'       => '6LfvAwkdAAAAAO7EaIbNO1oQ6ltDXA8zZOC2H1dx',
		'secret'    => '6LfvAwkdAAAAAK5OA8_ZcQ1K-UG8IELZiK1cd1CY'
	];

define( 'EMEON_URL',   get_template_directory_uri() );
define( 'EMEON_DEBUG', 'https://emeon.io/' !== home_url() );

/**
 * Disable wp-admin for subscribers
 */
add_filter( 'show_admin_bar', '__return_false' );
add_action( 'admin_init', function(){
	if( wp_doing_ajax() ) return;
	if( ! current_user_can( 'administrator' ) ){
		wp_redirect( site_url( '/account/' ) );
		die();
	}
} );


/**
 * Send email to a user
 *
 * @param string  $template_name
 * @param WP_User $user
 *
 * @return bool
 */
function emeon_mail( $template_name, $user ){
	$tf = get_stylesheet_directory() . '/templates/emails/' . str_replace( '.php', '', $template_name ) . '.php';
	if( ! file_exists(  $tf ) ) return false;
	return include $tf;
}

/**
 * Replace "https://blabla.com" to '<a href="https://blabla.com" target="_blank">https://blabla.com</a>'
 * in the text
 *
 * @param string $str
 *
 * @return string
 */
function make_hrefs( $str ) {
	$reg_exUrl     = "/(http|https|ftp|ftps)\\:\\/\\/[a-zA-Z0-9\\-\\.]+\\.[a-zA-Z]{2,3}(\\/\\S*)?/";
	$urls          = array();
	$urlsToReplace = array();
	if ( ! preg_match_all( $reg_exUrl, $str, $urls ) ) {
		return $str;
	}
	$numOfMatches = count( $urls[ 0 ] );
	for ( $i = 0; $i < $numOfMatches; $i ++ ) {
		$alreadyAdded       = false;
		$numOfUrlsToReplace = count( $urlsToReplace );
		for ( $j = 0; $j < $numOfUrlsToReplace; $j ++ ) {
			if ( $urlsToReplace[ $j ] == $urls[ 0 ][ $i ] ) {
				$alreadyAdded = true;
			}
		}
		if ( ! $alreadyAdded ) {
			array_push( $urlsToReplace, $urls[ 0 ][ $i ] );
		}
	}
	$numOfUrlsToReplace = count( $urlsToReplace );
	for ( $i = 0; $i < $numOfUrlsToReplace; $i ++ ) {
		$str = str_replace(
			$urlsToReplace[ $i ],
			'<a href="' . $urlsToReplace[ $i ] . '" target="_blank">' . $urlsToReplace[ $i ] . '</a>',
			$str
		);
	}

	return $str;
}


/**
 * Setup
 */
if ( ! function_exists( 'emeon_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function emeon_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on emeon, use a find and replace
		 * to change 'emeon' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'emeon', EMEON_PATH . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'emeon' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'emeon_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'emeon_setup' );


/**
 * Add svg support
 *
 * @param $mimes
 *
 * @return mixed
 */
function emeon_mime_types( $mimes ) {
	$mimes[ 'svg' ] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'emeon_mime_types' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function emeon_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS[ 'content_width' ] = apply_filters( 'emeon_content_width', 640 );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\emeon_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function emeon_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'emeon' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'emeon' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'emeon' ),
		'id'            => 'footer-sidebar-1',
		'description'   => __( 'Add widgets here for your footer.', 'emeon' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'emeon' ),
		'id'            => 'footer-sidebar-2',
		'description'   => __( 'Add widgets here for your footer.', 'emeon' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'emeon' ),
		'id'            => 'footer-sidebar-3',
		'description'   => __( 'Add widgets here for your footer.', 'emeon' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 4', 'emeon' ),
		'id'            => 'footer-sidebar-4',
		'description'   => __( 'Add widgets here for your footer.', 'emeon' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 5', 'emeon' ),
		'id'            => 'footer-sidebar-5',
		'description'   => __( 'Add widgets here for your footer.', 'emeon' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'emeon_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function emeon_scripts() {
	wp_enqueue_style( 'emeon-style', get_stylesheet_uri() );

	// Swiper slider
	wp_enqueue_style( 'swiper', EMEON_URL . '/css/swiper-bundle.min.css' );
	wp_enqueue_script( 'swiper', EMEON_URL . '/js/libs/swiper-bundle.min.js', [], '7.0.2', true );

	// Range slider
	wp_enqueue_style( 'range-slider', EMEON_URL . '/css/ion.rangeSlider.min.css' );
	wp_enqueue_script( 'range-slider', EMEON_URL . '/js/libs/ion.rangeSlider.min.js', [], '2.3.1', true );

	// Bootstrap
	wp_enqueue_style( 'bootstrap', EMEON_URL . '/css/bootstrap.min.css', [], '5.3.1' );
	wp_enqueue_script( 'bootstrap', EMEON_URL . '/js/libs/bootstrap.bundle.min.js', [], '5.3.1', true );

	wp_enqueue_style( 'theme-style', EMEON_URL . '/sass/style.css', [ 'bootstrap', 'swiper' ], filemtime( EMEON_PATH . '/sass/style.css' ) );

	wp_enqueue_style( 'emeon-font-awesome', EMEON_URL . '/fonts/fontawesome-pro/css/all.min.css' );

	wp_enqueue_style( 'emeon-icons', EMEON_URL . '/fonts/emeon/styles.css' );

	wp_enqueue_script( 'emeon-theme', EMEON_URL . '/js/theme.js', [
		'jquery',
		'bootstrap',
		'swiper'
	], filemtime( EMEON_PATH . '/js/theme.js' ), true );

	wp_enqueue_script( 'emeon-account', EMEON_URL . '/js/account.js', array(), filemtime( EMEON_PATH . '/js/account.js' ), true  );

	wp_enqueue_script( 'emeon-skip-link-focus-fix', EMEON_URL . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script(
		'google-captcha',
		'https://www.google.com/recaptcha/api.js?render=' . EMEON_CAPTCHA['key'],
		[ 'jquery' ],
		'1.0',
		true
	);

	// Dashicons
	wp_enqueue_style( 'dashicons' );
}

add_action( 'wp_enqueue_scripts', 'emeon_scripts' );

/**
 * Implement the Custom Header feature.
 */
require_once "inc/custom-header.php";

/**
 * Custom template tags for this theme.
 */
require_once "inc/template-tags.php";

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once "inc/template-functions.php";

/**
 * Customizer additions.
 */
require_once "inc/customizer.php";

/**
 * Widgets.
 */
require_once "inc/widgets.php";

/**
 * Shortcodes in widgets.
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Front-forms
 */
require_once "inc/front-forms.php";


/**
 * Get the categories ids
 *
 * @param $arr Array of categories slugs
 *
 * @return array Array of categories ids
 */
function emeon_get_categories_ids( array $arr ): array {
	$result = [];
	foreach ( $arr as $item ) {
		$result[] = get_category_by_slug( $item )->term_id;
	}

	return $result;
}

/**
 * Custom logging
 *
 * @param $data
 *
 * @return mixed
 */
function emeon_log( $data ) {
	if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG ) {
		return $data;
	}
	$mem = memory_get_usage( true ) / 1024 / 1024 . 'MB';
	error_log( "[$mem][EMEON] " . var_export( $data, true ) . PHP_EOL );

	return $data;
}

/**
 * Force all urls to be HTTPS if active
 */
add_filter( 'wp_get_attachment_url', function ( $url ) {
	if ( is_ssl() ) {
		return str_replace( 'http:', 'https:', $url );
	}

	return $url;
}, 999 );


/**
 * Clean up page titles
 */
add_filter( 'get_the_archive_title', function ($title) {
	if ( is_category() ) {
		$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
		$title = '<span class="vcard">' . get_the_author() . '</span>' ;
	}
	return $title;
});


/**
 * Adding classes to comment form elements
 */
add_filter( 'comment_form_defaults', function ( $defaults ) {
	$defaults['submit_button' ] = '<input name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-outline-secondary" value="%4$s" />';
	$defaults['comment_field' ] = sprintf(
		'<p class="comment-form-comment">%s %s</p>',
		sprintf(
			'<label class="form-label" for="comment">%s</label>',
			_x( 'Comment', 'noun' )
		),
		'<textarea id="comment" class="form-control btn-outline-secondary bg-body text-black" name="comment" rows="8" maxlength="65525" required="required"></textarea>'
	);

	return $defaults;
} );


/**
 * Fix nav menus on search page
 */
add_filter( 'pre_get_posts', function ( $query ) {
	if ( is_search() )
		$query->set( 'post_type', [ 'post', 'nav_menu_item' ] );
	return $query;
} );

/**
 * Login always via front-end form only (no wp-admin login!)
 */
//add_action( 'init', function(){
//	if( wp_doing_ajax() ) return;
//	if ( ! is_user_logged_in() &&
//	     (  strpos( $_SERVER['REQUEST_URI'], 'wp-admin' ) !== false ||
//	        strpos( $_SERVER['REQUEST_URI'], 'wp-login' ) !== false ) ) {
//		wp_redirect( site_url( '/account/' ) );
//		exit;
//	}
//}, -999 );

