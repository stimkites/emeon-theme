<?php
/**
 * Template part for displaying posts as swiper slides
 *
 * @package emeon
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'px-2 d-flex mb-4' ); ?>>
	<a href="<?php the_permalink(); ?>" class="p-4 card border-0 hover-shadow mx-auto w-100">

		<span class="post-thumbnail card-img">
			<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'post-thumbnail', array(
					'alt'   => the_title_attribute( array(
						'echo' => false,
					) ),
					'class' => 'h-100 w-100 img-cover rounded-circle',
				) );
			}
			?>
		</span>

		<?php the_title( '<h3 class="entry-title mt-4 mb-1 "><span class="fs-4">', '</span></h3>' ); ?>

		<span class="entry-content text-sm-start">
			<?php the_excerpt(); ?>
		</span><!-- .entry-content -->
	</a>
</article><!-- #post-<?php the_ID(); ?> -->
