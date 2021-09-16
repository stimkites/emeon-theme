<?php
/**
 * Template part for displaying posts as ad cards in my-account
 *
 * @package emeon
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'account-ad' ); ?>>

	<?php emeon_post_thumbnail(); ?>

	<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

	<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			emeon_posted_on();
			emeon_posted_by();
			?>
		</div><!-- .entry-meta -->
	<?php endif; ?>

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
