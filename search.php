<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package emeon
 */

defined( 'ABSPATH' ) or exit;

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( 'Search Results for: %s', 'emeon' ), '<span>' . get_search_query() . '</span>' );
						?>
					</h1>
				</header><!-- .page-header -->

				<?php
				// Filters
				echo do_shortcode( '[emeon_forms form=filters]' );
				?>

				<div class="search-content">
				<div class="search-mobile-bar">
					<button class="btn btn-primary">
	               <i class="fal fa-filter"></i>
						Filters</button>
				</div>
				<?php
				/* Start the Loop */
				?>
				<div class="search-posts w-100 d-flex flex-wrap row-cols-1 row-cols-md-2 row-cols-lg-4 align-items-stretch mx-n2">
				<?php
				while ( have_posts() ) :
					the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part( 'template-parts/content', 'card' );

				endwhile;
				?>

				</div>
					<?php

		the_posts_navigation();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>
			</div>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
// get_sidebar();
get_footer();
