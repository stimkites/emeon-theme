<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package emeon
 */

defined( 'ABSPATH' ) or exit;

?>

</div><!-- #content -->

<?php if( ! EMEON_PRINTABLE ) :?>

<footer id="colophon" class="site-footer">
	<div class="site-info">
		<a href="https://emeon.io">
			&copy; <?php echo get_bloginfo(); ?> 2020 - <?php echo date( 'Y' ); ?>
		</a>
		<span class="sep"> | </span>
		<a href="https://www.facebook.com/people/Emeon-Webdev/100075559053781/" target="_blank">
			Facebook
		</a>
	</div><!-- .site-info -->
</footer><!-- #colophon -->

<?php endif ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
