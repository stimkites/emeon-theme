<?php
/**
 * Template part for displaying posts as swiper slides
 *
 * @package emeon
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'swiper-slide card border-0 rounded hover-shadow' ); ?> style="box-sizing: content-box ">
	<div class="card-body p-4">


	<?php emeon_post_thumbnail(); ?>

	<?php the_title( '<h3 class="entry-title mt-4 mb-1 "><a class="fs-4" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

	<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta text-secondary opacity-80 mb-3">
			<?php
			emeon_posted_on();
			emeon_posted_by();
			?>
		</div><!-- .entry-meta -->
	<?php endif; ?>

	<div class="entry-content text-sm-start">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->
