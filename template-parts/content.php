<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package emeon
 */

$contact_info = '';

$post_id = get_the_ID();
$post = get_post( $post_id );

$cats = '<ul class="emeon-cats-tags"><li>' .
			implode( '</li><li>',
				array_filter(
					array_map(
						function( $a ){
							$term = get_term( $a );
							if ( in_array( $term->slug, EMEON_TYPES ) ) return null;
							return $term->name;
						},
						array_merge(
							wp_get_post_categories( $post_id ),
							wp_get_post_tags( $post_id, [ 'fields' => 'ids' ] )
						)
					)
				)
			) .
        '</li></ul>';

if ( $contacts = get_post_meta( $post_id, 'emeon_contacts', true ) ) {
	if( is_user_logged_in() ){
		$pdf  = ( ( $pdf_id = get_post_meta( $post_id, 'emeon_attachment', true ) ) ? wp_get_attachment_url( $pdf_id ) : '' );
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
		if( $pdf )
			$contact_info .= '<p class="attachment">' .
			                    '<a href="' . $pdf . '" download="">' .
			                        '<img src="' . get_stylesheet_directory_uri() . '/img/pdf-icon.png" alt="PDF" />' .
			                    '</a>' .
			                 '</p>';
		$contact_info .= '</div>';
	} else {
		$contact_info =
			'<div class="emeon-contact-info no-login">' .
				'<a href="/join/">Join us</a> to see the contacts and additional information!</div>';
	}

}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if( $post->post_author == get_current_user_id() ): ?>
	<span class="emeon-edit-post-link">
		<a href="<?=apply_filters( 'emeon_adedit_url', '/add-edit/' )?>?ad=<?=$post_id?>">Edit</a>
	</span>
	<?php endif ?>

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
			<div class="excerpt">
				<?php the_excerpt() ?>
			</div>
			<div class="categories-tags">
				<?=$cats?>
			</div>
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

		?>
		<div class="additional-info">
			<div class="salary-experience">
				<?php if( $salary = get_post_meta( $post_id, 'emeon_salary', true ) ): ?>
				<p class="salary">
					<span class="info-label">
						Salary
					</span>
					From <?=EMEON_CUR_SYMB.$salary?>
				</p>
				<?php endif ?>

				<?php if( $exp = get_post_meta( $post_id, 'emeon_experience', true ) ) : ?>
				<p class="experience">
					<span class="info-label">
						Experience
					</span>
					<?=EMEON_EXP_LVL[ $exp ]?>
				</p>
				<?php endif ?>

			</div>
			<?=$contact_info?>
		</div>
		<?php

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'emeon' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
