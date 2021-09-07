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

			<section class="section section--slider section--about">

				<div class="about about--swiper swiper-slider" width="600" height="300">
					<div class="swiper-wrapper">
						<?php
						global $post;

						$vacancies = get_posts( [
							'numberposts'   => 8,
							'category_name' => 'vacancies',
							'orderby'       => 'modified',
							'post_status'   => 'publish'
						] );

						if ( ! empty( $vacancies ) ) :

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
				<div class="swiper-pagination swiper-pagination--about"></div>
			</section>

			<section class="section section--slider section--vacancies">
				<h2 class="section__header">VACANCIES</h2>
				<div class="vacancies vacancies--swiper swiper-slider" width="600" height="300">
					<div class="swiper-wrapper">
						<?php
						global $post;

						$vacancies = get_posts( [
							'numberposts'   => 8,
							'category_name' => 'vacancies',
							'orderby'       => 'modified',
							'post_status'   => 'publish'
						] );

						if ( ! empty( $vacancies ) ) :

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
				<div class="swiper-pagination swiper-pagination--vacancies"></div>

				<!-- If we need navigation buttons -->
				<div class="swiper-button-prev swiper-button-prev--vacancies"></div>
				<div class="swiper-button-next swiper-button-next--vacancies"></div>
			</section>

			<section class="section section--slider section--candidates">
				<h2 class="section__header">CANDIDATES</h2>
				<div class="candidates candidates--swiper swiper-slider" width="600" height="300">
					<div class="swiper-wrapper">
						<?php
						global $post;

						$candidates_categories = [
							'candidates',
							'emeon-team'
						];

						function get_categories_ids( $arr ) {
							$result = [];
							foreach ( $arr as $item ) {
								$result[] = get_category_by_slug( $item )->term_id;
							}

							return $result;
						}

						$candidates = get_posts( [
							'numberposts' => 8,
							'category'    => get_categories_ids( $candidates_categories ),
							'orderby'     => 'modified',
							'post_status' => 'publish'
						] );

						if ( ! empty( $candidates ) ) :

							foreach ( $candidates as $post ) {
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
				<div class="swiper-pagination swiper-pagination--candidates"></div>

				<!-- If we need navigation buttons -->
				<div class="swiper-button-prev swiper-button-prev--candidates"></div>
				<div class="swiper-button-next swiper-button-next--candidates"></div>
			</section>

			<section class="section section--slider section--stories">
				<h2 class="section__header">STORIES</h2>
				<div class="stories stories--swiper swiper-slider" width="600" height="300">
					<div class="swiper-wrapper">
						<?php
						global $post;

						$stories = get_posts( [
							'numberposts' => 8,
							'category'    => 'user-stories',
							'orderby'     => 'modified',
							'post_status' => 'publish'
						] );

						if ( ! empty( $stories ) ) :

							foreach ( $stories as $post ) {
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
				<div class="swiper-pagination swiper-pagination--stories"></div>

			</section>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
