<?php
/**
 * Template part for displaying posts as swiper slides
 *
 * @package emeon
 */

global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'swiper-slide story-slide' ); ?>>

	<?php emeon_post_thumbnail( true ); ?>

	<h3 class="entry-title"><?=$post->post_title?></h3>

	<div class="entry-content">
		<div class="story-subtitle"><?php the_excerpt(); ?> </div>
		<div class="story-content"><?php the_content(); ?></div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
