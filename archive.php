<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package emeon
 */

defined( 'ABSPATH' ) or exit;

$adedit_url = apply_filters( 'emeon_adedit_url', '/add-edit/' );

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
					<?php if( $_SERVER['REQUEST_URI'] === '/category/emeon-team/' ) : ?>
						<div class="emeon-team-desciption">
							<h5>We are ready to provide best services in web-development!</h5>
							<p>Have a thing to do about your site or web-shop? Feel free to add us a task!<br/>We will
								estimate it for you and provide exact info on what and how! Simply describe it!</p>
							<p>If you want to join us and be the part of the team - just add your CV
								<a href="/add-edit/">here</a>!
							</p>
						</div>
					<?php endif; ?>
				</header><!-- .page-header -->

                <?php
                    // Filters
				    echo do_shortcode( '[emeon_forms form=filters]' );
				?>

				<?php if( $_SERVER['REQUEST_URI'] === '/category/vacancies/' ||
						  $_SERVER['REQUEST_URI'] === '/category/candidates/' ) : ?>
						<div class="add-link-wrapper">
							<a href="<?=$adedit_url?>" class="add-link">Add new</a>
						</div>
				<?php endif; ?>

				<?php if( $_SERVER['REQUEST_URI'] === '/category/emeon-team/' ) : ?>
					<div class="add-link-wrapper">
						<a href="/account/#contacts"
						   class="add-link add-task">Add a task</a>
					</div>
				<?php endif; ?>

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
