<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #mid div and all content after.
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly


global $emeon_a13;
?>
	</div><!-- #mid -->

<?php
//in case of maintenance mode - we don't print HTML footer
if( ! apply_filters('emeon_only_content', false) ){
	emeon_theme_footer();
	emeon_footer_for_header_modules();
}
emeon_footer_for_site_modules();
?>

	</div><!-- .whole-layout -->
<?php
    /* Always have wp_footer() just before the closing </body>
         * tag of your theme, or you will break many plugins, which
         * generally use this hook to reference JavaScript files.
         */
    wp_footer();
?>
</body>
</html>