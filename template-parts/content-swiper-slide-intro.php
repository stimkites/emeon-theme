<?php
/**
 * Template part for displaying posts as swiper slides
 *
 * @package emeon
 */

global $post;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'swiper-slide swiper-intro' ); ?>>

	<div class="entry-content">
		<?php emeon_post_thumbnail( true ); ?>
		<h3 class="entry-title intro-title"><?=$post->post_title?></h3>
		<h4 class="intro-subtitle"><?=$post->post_excerpt?></h4>
		<div class="intro-content"><?php the_content(); ?></div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
