<?php
/**
 * Home page template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package emeon
 */

get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<h1>HOME</h1>

			<section class="section section--slider section--vacancies">
				<h2>VACANCIES</h2>
				<div class="vacancies vacancies--swiper" width="600" height="300">
					<div class="swiper-wrapper">
						<?php
						global $post;

						$vacancies = get_posts( [
							'numberposts'   => 8,
							'category_name' => 'vacancies',
							'orderby'       => 'modified',
							'post_status'   => 'publish'
						] );

						if ( !empty( $vacancies ) ) :

							foreach ( $vacancies as $post ) {
								setup_postdata( $post );
								get_template_part( 'template-parts/content', 'swiper-slide' );
							}

							wp_reset_postdata();

						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
						?>
					</div>
				</div>
				<!-- If we need pagination -->
				<div class="swiper-pagination"></div>

				<!-- If we need navigation buttons -->
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>

				<!-- If we need scrollbar -->
				<div class="swiper-scrollbar"></div>
			</section>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
