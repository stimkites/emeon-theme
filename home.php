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

			<div class="section hero">
				<div class="row row-cols-1 row-cols-md-3">
					<a href="<?php echo get_bloginfo( 'url' ) . '/join'; ?>" class="col d-flex flex-column justify-content-between mb-5 mb-md-0">
						<h2 class="h3 text-uppercase text-center">looking for a lob?</h2>
						<div class="d-flex align-items-center justify-content-center flex-grow-1 mb-4">
							<img class="rounded mx-auto d-block" src="<?php echo get_template_directory_uri() . '/img/cropped-emeon-logo-2-1.png'?>" alt="emeon job offers">
						</div>
						<button class="btn btn-primary btn-lg d-block mx-auto text-uppercase rounded-pill py-3 w-100">get a job</button>
					</a>
					<a href="<?php echo get_bloginfo( 'url' ) . '/join>'; ?>" class="col d-flex flex-column justify-content-between mb-5 mb-md-0">
						<h2 class="h3 text-uppercase text-center">want to publish a vacancy?</h2>
						<div class="d-flex align-items-center justify-content-center flex-grow-1 mb-4">
							<img class="rounded mx-auto d-block" src="<?php echo get_template_directory_uri() . '/img/work_together.jpg'?>" alt="emeon vacancies">
						</div>
						<button class="btn btn-primary btn-lg d-block mx-auto text-uppercase rounded-pill py-3 w-100">publish vacancy</button>
					</a>
					<a href="<?php echo get_bloginfo( 'url' ) . '/join'; ?>" class="col d-flex flex-column justify-content-between mb-5 mb-md-0">
						<h2 class="h3 text-uppercase text-center">need help on website?</h2>
						<div class="d-flex align-items-center justify-content-center flex-grow-1 mb-4">
							<img class="rounded mx-auto d-block" src="<?php echo get_template_directory_uri() . '/img/remote-support.png'?>" alt="emeon support">
						</div>
						<button class="btn btn-primary btn-lg d-block mx-auto text-uppercase rounded-pill py-3 w-100">get help</button>
					</a>
				</div>
			</div>

			<section class="section section--slider section--vacancies">
				<h2 class="section__header text-center h1 mb-5 pt-5">VACANCIES</h2>
				<div class="vacancies vacancies--swiper swiper-slider" width="600" height="300">
					<div class="swiper-wrapper align-items-stretch">
						<?php
						global $post;

						$vacancies = get_posts( [
							'numberposts'   => 24,
							'category_name' => 'vacancies',
							'orderby'       => 'modified',
							'post_status'   => 'publish'
						] );

						if ( ! empty( $vacancies ) ) :

							foreach ( $vacancies as $post ) {
								setup_postdata( $post );
								get_template_part( 'template-parts/content', 'swiper-slide-card' );
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
				<h2 class="section__header text-center h1 pt-5 mb-5">CANDIDATES</h2>
				<div class="candidates candidates--swiper swiper-slider" width="600" height="300">
					<div class="swiper-wrapper align-items-stretch">
						<?php
						global $post;

						$candidates_categories = [
							'candidates',
							'emeon-team'
						];

						$candidates = get_posts( [
							'numberposts' => 24,
							'category'    => emeon_get_categories_ids( $candidates_categories ),
							'orderby'     => 'modified',
							'post_status' => 'publish'
						] );

						if ( ! empty( $candidates ) ) :

							foreach ( $candidates as $post ) {
								setup_postdata( $post );
								get_template_part( 'template-parts/content', 'swiper-slide-card' );
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
				<div class="swiper-button-prev swiper-button-prev--candidates "></div>
				<div class="swiper-button-next swiper-button-next--candidates"></div>
			</section>

			<section class="section section--slider section--stories">
				<h2 class="section__header text-center h1 pt-5 mb-5">STORIES</h2>
				<div class="stories stories--swiper swiper-slider" width="600" height="300">
					<div class="swiper-wrapper">
						<?php
						global $post;

						$stories = get_posts( [
							'numberposts'   => 8,
							'category_name' => 'user-stories',
							'orderby'       => 'modified',
							'post_status'   => 'private'
						] );

						if ( ! empty( $stories ) ) :

							foreach ( $stories as $post ) {
								setup_postdata( $post );
								get_template_part( 'template-parts/content', 'swiper-slide-story' );
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
