<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * In this theme we use it as home.php, archive.php and search.php to reduce number of templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

global $emeon_a13;

$ajax_call = false;
if(isset( $_REQUEST['a13-ajax-get']) ){
	$ajax_call = true;
}

if($ajax_call) {
	emeon_display_items_from_query_post_list();
	//send also current pagination when ajax call
	the_posts_pagination();
	emeon_result_count();
}
else{

	$_title = '';

//Lets decide what is the title
	if ( is_search() ) {
		/* Search Count */
		$all_search = new WP_Query( "s=$s&showposts=-1" );
		$count      = $all_search->post_count;

		/* translators: %1$d number of results, %2$s search query   */
		$_title = sprintf( esc_html( _n( '%1$d search result for "%2$s"', '%1$d search results for "%2$s"', $count, 'emeon' ) ), $count, get_search_query() );
	} elseif ( is_archive() ) {
		if ( is_author() ) {
			/* translators: %s - author name */
			$_title = sprintf( esc_html__( 'Author Archives: %s', 'emeon' ), "<span class='vcard'>" . get_the_author() . "</span>" );
		} elseif ( is_category() ) {
			/* translators: %s - category name */
			$_title = sprintf( esc_html__( 'Category Archives: %s', 'emeon' ), '<span>' . single_cat_title( '', false ) . '</span>' );
		} elseif ( is_tag() ) {
			/* translators: %s - tag name */
			$_title = sprintf( esc_html__( 'Tag Archives: %s', 'emeon' ), '<span>' . single_tag_title( '', false ) . '</span>' );
		} elseif ( is_day() ) {
			/* translators: %s - day */
			$_title = sprintf( esc_html__( 'Daily Archives: %s', 'emeon' ), '<span>' . get_the_date() . '</span>' );
		} elseif ( is_month() ) {
			/* translators: %s - month */
			$_title = sprintf( esc_html__( 'Monthly Archives: %s', 'emeon' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
		} elseif ( is_year() ) {
			/* translators: %s - year */
			$_title = sprintf( esc_html__( 'Yearly Archives: %s', 'emeon' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
		} else {
			$_title = esc_html__( 'Blog Archives', 'emeon' );
		}
	}

	$lazy_load          = $emeon_a13->get_option('blog_lazy_load') === 'on';
	$pagination_class   = $lazy_load? ' lazy-load-on' : '';

	get_header();

	// Elementor `archive` location
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ){

		emeon_title_bar( 'outside', $_title );
		?>
		<article id="content" class="clearfix">
			<div class="content-limiter">
				<div id="col-mask">
					<div class="content-box<?php echo esc_attr( $pagination_class ); ?>">
						<?php
						emeon_display_items_from_query_post_list();
						?>
						<div class="clear"></div>

						<?php the_posts_pagination();
						emeon_result_count(); ?>

					</div>
					<?php get_sidebar(); ?>
				</div>
			</div>
		</article>
		<?php
	}
	get_footer();
}