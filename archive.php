<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package emeon
 */

defined( 'ABSPATH' ) or exit;

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="container px-0">
			<?php if ( have_posts() ) : ?>

				<header class="page-header text-center mb-5">
					<?php
					the_archive_title( '<h1 class="page-title display-1 h1">', '</h1>' );
					the_archive_description( '<div class="archive-description lead">', '</div>' );
					?>
				</header><!-- .page-header -->

				<div class="d-flex flex-wrap row-cols-1 row-cols-md-2 row-cols-lg-4 align-items-stretch mx-n2">
					<?php
					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'card' );

					endwhile;

					the_posts_navigation(); ?>

				</div>
			<?php else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
// get_sidebar();
get_footer();
