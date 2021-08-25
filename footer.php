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

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			&copy; <?php echo get_bloginfo(); ?>, 2016 - <?php echo date('Y'); ?>
			<span class="sep"> | </span>
			By Emeon partner, <a href="https://wetail.io">Wetail AB, Sweden</a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
