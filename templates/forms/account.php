<?php

/**
 * Template for account page ad
 */

defined( 'ABSPATH' ) or exit;

$uid = get_current_user_id();
$vid = get_term_by( 'slug', 'vacancies',  'category'  )->term_id ?? '0';
$cid = get_term_by( 'slug', 'candidates', 'category'  )->term_id ?? '0';

$acted = false;
if( isset( $_GET['trash'] ) )
	$acted = wp_delete_post( $_GET['trash'] );
if( isset( $_GET['archive'] ) )
	$acted = wp_update_post( [ 'ID' => $_GET['archive'], 'post_status' => 'archive' ] );

$uposts = get_posts( [
    'post_author' => $uid,
    'category' => [ $cid, $vid ]
] );

$adedit_url = apply_filters( 'emeon_adedit_url', '/add-edit/' );
?>

<div class="emeon-account" id="emeon-account">
    <div class="emeon-account-menu">
        <ul id="account-primary-menu">
            <li><a href="#my-ads" class="my-pass">My ads</a></li>
            <li><a href="#pass" class="my-pass">My password</a></li>
            <li><a href="#contacts" class="contacts">Contact us</a></li>
        </ul>
    </div>
    <div class="emeon-account-content">
        <div class="account-content viz" id="my-ads">
            <h2>My ads</h2>
            <div class="add-link">
                <a href="<?=$adedit_url?>" class="add-edit-link"></a>
            </div>
            <div class="my-articles">
	            <?php
	            global $post;
	            $a = $post;
	            foreach ( $uposts as $post )
		            get_template_part( 'template-parts/content', 'account-ad' );
	            $post = $a;
	            ?>
            </div>
        </div>
        <div class="emeon-pass-change account-content" id="pass">
            <h2>Password change</h2>
            <?=do_shortcode('[emeon_forms form=password]' )?>
        </div>
        <div class="emeon-contacts account-content" id="contacts">
            <h2>Contact us</h2>
	        <?=do_shortcode('[emeon_forms form=contactus]' )?>
        </div>
    </div>
</div>
