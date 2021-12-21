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
				<div class="row">
					<div class="col col--text">
						<h1 class="h1 my-4">Employ Me Online!</h1>
						<h3 class="h3 my-4">Vacancies, support, startups</h3>
						<ul class="list-group list-group-flush mb-4 p-0 ms-0">
							<li class="list-group-item bg-transparent border-0 p-0">Job in IT?</li>
							<li class="list-group-item bg-transparent border-0 p-0">Publish vacancy?</li>
							<li class="list-group-item bg-transparent border-0 p-0">Help about web-site?</li>
							<li class="list-group-item bg-transparent border-0 p-0">Start new IT business?</li>
						</ul>
						<p class="text fw-bold mb-4">What you want - today in minutes!</p>
						<div class="hero__buttons">
							<a href="/category/vacancies/"
							   type="button"
							   data-action="job"
							   class="hero__button shadow-sm btn btn-primary rounded-pill text-uppercase px-5 me-3 mb-3">Find a job</a>
							<a href="/category/candidates/"
							   type="button"
							   data-action="vacancy"
							   class="hero__button shadow-sm btn btn-outline-primary rounded-pill text-uppercase px-5 mb-3">Find a specialist</a>
						</div>
						<a href="/account/#contacts"
						   type="button"
						   data-action="help"
						   class="hero__button btn btn-link p-0 text-primary">Get help about a web-site</a>
					</div>
					<div class="col col--image">
						<div class="image-wrapper position-relative h-100 w-100">
							<img class="hero__image position-absolute w-100"
								 src="<?php echo get_template_directory_uri() . '/img/hero.svg' ?>"
								 data-action="vacancy"
								 alt="vacancy">
							<img class="hero__image position-absolute w-100 hidden"
								 src="<?php echo get_template_directory_uri() . '/img/hire.svg' ?>"
								 data-action="job"
								 alt="job">
							<img class="hero__image position-absolute w-100 hidden"
								 src="<?php echo get_template_directory_uri() . '/img/help.svg' ?>"
								 data-action="help"
								 alt="help">
						</div>
					</div>
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
