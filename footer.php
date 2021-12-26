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
	<div class="basic-info">
		<div class="footer-logo">
			<img width=100 height=100 src="<?=get_template_directory_uri()?>/img/emeon-logo.svg" alt="" />
		</div>
		<div class="footer-general-info">

		</div>
		<div class="footer-register">
			<?=do_shortcode( '[emeon_forms form="join"]' )?>
		</div>
		<div class="footer-socials">

		</div>
	</div>
	<div class="site-info">
		<a href="https://emeon.io">
			&copy; <?php echo get_bloginfo(); ?> 2020 - <?php echo date( 'Y' ); ?>
		</a>
		<span class="sep"> | </span>
		<div class="half">
			Works ♥ on WordPress
		</div>
		<a href="https://www.facebook.com/people/Emeon-Webdev/100075559053781/" target="_blank">
			Facebook
		</a>
		<span class="sep"> | </span>
		<a href="https://www.youtube.com/playlist?list=PLGispirKjL_ZsLtR-Fmz7BmrNw9RiloyT" target="_blank">
			YouTube
		</a>
	</div><!-- .site-info -->
</footer><!-- #colophon -->

<?php endif ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
