<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package emeon
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function emeon_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'emeon_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function emeon_woocommerce_scripts() {
// 	wp_enqueue_style( 'emeon-woocommerce-style', get_template_directory_uri() . '/woocommerce.css' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'emeon-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'emeon_woocommerce_scripts' );

// Remove "First" & "last" classes WooCommerce Product listing
add_filter( 'post_class', 'prefix_post_class', 21 );
function prefix_post_class( $classes ) {
    if ( 'product' == get_post_type() ) {
        $classes = array_diff( $classes, array( 'first', 'last' ) );
    }
    return $classes;
}

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function emeon_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'emeon_woocommerce_active_body_class' );

/**
 * Products per page.
 *
 * @return integer number of products.
 */
function emeon_woocommerce_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'emeon_woocommerce_products_per_page' );

/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function emeon_woocommerce_thumbnail_columns() {
	return 4;
}
add_filter( 'woocommerce_product_thumbnails_columns', 'emeon_woocommerce_thumbnail_columns' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function emeon_woocommerce_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'emeon_woocommerce_loop_columns' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function emeon_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'emeon_woocommerce_related_products_args' );

if ( ! function_exists( 'emeon_woocommerce_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper.
	 *
	 * @return  void
	 */
	function emeon_woocommerce_product_columns_wrapper() {
		$columns = emeon_woocommerce_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}
add_action( 'woocommerce_before_shop_loop', 'emeon_woocommerce_product_columns_wrapper', 40 );

if ( ! function_exists( 'emeon_woocommerce_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close.
	 *
	 * @return  void
	 */
	function emeon_woocommerce_product_columns_wrapper_close() {
		echo '</div>';
	}
}
add_action( 'woocommerce_after_shop_loop', 'emeon_woocommerce_product_columns_wrapper_close', 40 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'emeon_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function emeon_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'emeon_woocommerce_wrapper_before' );

if ( ! function_exists( 'emeon_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function emeon_woocommerce_wrapper_after() {
			?>
			</main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'emeon_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'emeon_woocommerce_header_cart' ) ) {
			emeon_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'emeon_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function emeon_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		emeon_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'emeon_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'emeon_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function emeon_woocommerce_cart_link() {
		?><!-- ?php echo esc_url( wc_get_cart_url() ); ? -->
		<a class="cart-contents" title="<?php esc_attr_e( 'View your shopping cart', 'emeon' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
// 				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'emeon' ),
				WC()->cart->get_cart_contents_count()
			);
			?><i class="far fa-shopping-bag"></i>
<!-- 			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> --> 
			<span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'emeon_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function emeon_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php emeon_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}


/************************************************************************/
/************************** THEME FIXES *********************************/
/************************************************************************/

// Remove Add To Cart Button
add_action( 'woocommerce_after_shop_loop_item', 'remove_add_to_cart_buttons', 1 );
function remove_add_to_cart_buttons() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
}

// Remove WooCommerce sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Remove sorting
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Remove result count
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );


// Second product image in shop loop - Hoover and breath
add_action ('woocommerce_before_shop_loop_item','gallery_hover_image');
function gallery_hover_image () {
    /**
     * @var \WC_Product $product
     */
    global $product;
    $id = $product->get_gallery_image_ids();
    $url_attachment = '';
    if( $id )
        $url_attachment = wp_get_attachment_url( $id[0] );
    echo '<img class="hover-image" src="' . $url_attachment . '" >';
}

// Remove gallery images - these has to be removed damn it!
function remove_gallery_and_product_images() {
if ( is_product() ) {
    remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
    }
}
add_action('loop_start', 'remove_gallery_and_product_images');

// Add all gallery images again - This is so much better
add_action ('woocommerce_after_single_product_summary','all_gallery_images' , 0);
function all_gallery_images () {
    /**
     * @var \WC_Product $product
     */
	global $product;
	$attachment_ids = $product->get_gallery_image_ids( );
	echo '<ul class="product-gallery">';
		foreach( $attachment_ids as $attachment_id ) {
		    echo '<li class="gallery-image"><img src="' . $shop_catalog_image_url = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' )[0] . '"></li>';
		}
	echo '</ul>';
}

// Remove the product rating display on product loops
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

// Remove product meta
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// Move Product tabs
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60 );

// Remove Breadcrumbs
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action ('woocommerce_before_shop_loop' ,'emeon_filter_widget' ,10);
function emeon_filter_widget() { ?>
	<div class="sorting-filters">
		<?php woocommerce_breadcrumb(); ?>
		<?php if ( !is_active_sidebar( 'woo-filters' ) ) : ?>
			<?php echo woocommerce_catalog_ordering(); ?>
		<?php elseif ( is_active_sidebar( 'woo-filters' ) ) : ?>
			<div class="filter-and-sorting">
				<?php if(the_widget('WC_Widget_Layered_Nav_Filters')) {
					echo the_widget('WC_Widget_Layered_Nav_Filters');
				} ?>
				<div class="wc-filters">filters</div>
				<?php echo woocommerce_catalog_ordering(); ?>
			</div>
		<?php endif; ?>
	</div>
	<?php if ( is_active_sidebar( 'woo-filters' ) ) : ?>
		<div class="woocommerce-widgets">
			<ul id="woo-filter-widgets">
				<?php dynamic_sidebar( 'woo-filters' ); ?>
			</ul>
		</div>
	<?php endif; ?>
<?php }

// Remove the parentheses from the category widget
add_filter( 'woocommerce_subcategory_count_html', 'wc_filter_woocommerce_subcat_count_html', 10, 2 );
function wc_filter_woocommerce_subcat_count_html( $mark_class_count_category_count_mark, $category ) {
	$mark_class_count_category_count_mark = ' <span class="count">' . $category->count . '</span>';
	return $mark_class_count_category_count_mark;
};


// Append li element in ul.products 
add_action ('wp_head','append_product_list_item');
function append_product_list_item () { 
	if(is_product_category() || is_product_taxonomy()) : ?>
	 
	<script>
		jQuery(document).ready(function($){
 			var newProductItem = $('<li class="product category-box"><?php do_action('cat_box_action') ?></li>'); 
 			$('ul.products').prepend(newProductItem);

		});
	</script>
	
<?php endif; 
}
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_filter('woocommerce_show_page_title', '__return_false');

add_action ('cat_box_action','category_list_item');
function category_list_item() {
	global $wp_query;	
	$cat = $wp_query->get_queried_object();
	$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	$image = wp_get_attachment_url( $thumbnail_id ); 
	
	$term_object = get_queried_object();

	echo '<img class="cat-img" src="' . $image	. '">';	
	echo '<h1 class="woocommerce-products-header__title page-title">'; 
	echo woocommerce_page_title();
	echo '</h1>';
	echo '<div class="term-description">' . $term_object->description; '</div>';
}


// Move upsales on single product
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

add_action( 'woocommerce_single_product_summary', 'emeon_woocommerce_output_upsells', 70 );
 
function emeon_woocommerce_output_upsells() {
	woocommerce_upsell_display( 4,4 ); // Display max 3 products, 3 per row
}
