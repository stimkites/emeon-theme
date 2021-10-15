<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package emeon
 */

$contact_info = '';
if ( $contacts = get_post_meta( get_the_ID(), 'emeon_contacts', true ) ) {
	$contact_info = '<div class="emeon-contact-info">';
	foreach ( $contacts as $key => $value ) {
		if ( $key === 'email' ) {
			$contact_info .= '<p class="contact-email"><a href="mailto:' . $value . '">' . $value . '</a></p>';
		} elseif ( $key === 'phone' ) {
			$contact_info .= '<p class="contact-phone"><a href="tel:' . $value . '">' . $value . '</a></p>';
		} else {
			$contact_info .= '<div class="contact-additional">' . make_hrefs( $value ) . '</div>';
		}
	}
	$contact_info .= '</div>';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php emeon_post_thumbnail(); ?>

	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				emeon_posted_on();
				emeon_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<!--Contact info-->


	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
			/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'emeon' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'emeon' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
