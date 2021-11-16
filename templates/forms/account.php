<?php

/**
 * Template for account page ad
 */

defined( 'ABSPATH' ) or exit;

if ( ! ( $uid = get_current_user_id() ) ) {
	echo do_shortcode( '[emeon_forms form=login]' );

	return;
}

$vid = get_term_by( 'slug', 'vacancies', 'category' )->term_id ?? '0';
$cid = get_term_by( 'slug', 'candidates', 'category' )->term_id ?? '0';

$acted = false;
if ( isset( $_GET[ 'trash' ] ) ) {
	$acted = wp_delete_post( $_GET[ 'trash' ] );
}
if ( isset( $_GET[ 'archive' ] ) ) {
	$acted = wp_update_post( [ 'ID' => $_GET[ 'archive' ], 'post_status' => 'archive' ] );
}

$uposts = get_posts(
	[
		'post_author'    => $uid,
		'posts_per_page' => - 1,
		'post_status'    => 'any',
		'category'       => get_terms(
			[
				'slug'     => [ 'vacancies', 'candidates' ],
				'taxonomy' => 'category',
				'fields'   => 'ids'
			]
		)
	]
);

$adedit_url = apply_filters( 'emeon_adedit_url', '/add-edit/' );
?>

<div class="emeon-account" id="emeon-account">
	<div class="emeon-account-menu">
		<ul id="account-primary-menu">
			<li><a href="#my-articles" class="my-pass">My ads</a></li>
			<li><a href="#pass" class="my-pass">My password</a></li>
			<li><a href="#contacts" class="contacts">Contact us</a></li>
			<li><a href="<?= wp_logout_url( home_url() ) ?>" class="logout">Log out</a></li>
		</ul>
	</div>
	<div class="emeon-account-content">
		<div class="account-content viz" id="my-articles">
			<h2>
				My ads
			</h2>
			<div class="add-link-wrapper">
                <a href="<?= $adedit_url ?>" class="add-link" title="Add new">Add new</a>
            </div>
			<div class="my-articles">
				<?php
				global $post;
				$a = $post;
				foreach ( $uposts as $post ) {
					get_template_part( 'template-parts/content', 'account-ad' );
				}
				$post = $a;
				?>
			</div>
		</div>
		<div class="emeon-pass-change account-content" id="pass">
			<h2>Password change</h2>
			<?= do_shortcode( '[emeon_forms form=password]' ) ?>
		</div>
		<div class="emeon-contacts account-content" id="contacts">
			<h2>Contact us</h2>
			<?= do_shortcode( '[emeon_forms form=contactus]' ) ?>
		</div>
	</div>
</div>
