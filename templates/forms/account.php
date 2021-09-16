<?php

/**
 * Template for account page ad
 */

defined( 'ABSPATH' ) or exit;

$uid = get_current_user_id();
$vid = get_term_by( 'slug', 'vacancies'  )->term_id ?? '0';
$cid = get_term_by( 'slug', 'candidates' )->term_id ?? '0';
$dat = [];

foreach( EMEON_STATUSES as $status )
    foreach( EMEON_TYPES as $type )
        $dat[ $status ][ $type ] = get_posts( [
            'post_author' => $uid,
            'post_status' => $status,
            'tax_query' => [
                [
                    'taxonomy' => 'category',
                    'terms' => get_term_by( 'slug', $type, 'category' )->term_id ?? 0
                ]
            ]
        ] );


$def_image  = EMEON_URL . '/img/user-icon.png';

$adedit_url = apply_filters( 'emeon_adedit_url', site_url() );

?>

<div class="emeon-account">
    <div class="emeon-account-menu">
        <ul class="main-list">
            <h4>My Ads</h4>
            <?php
                foreach( EMEON_TYPES as $type ) {
                    echo '<h5>' . ucfirst( $type ) . '</h5>';
	                foreach ( EMEON_STATUSES as $status ) {
		                echo '<li><a class="ad-link" href="#' . $type . '-' . $status . '">' .
                                ucfirst( $status ) .
                             '</a></li>';
	                }
                }
            ?>
            <br/>
            <li><a href="<?=$adedit_url?>" class="new-ad"></a></li>
            <hr/>
            <h4>Account</h4>
            <li><a href="#pass" class="my-pass">My password</a></li>
            <li><a href="#contacts" class="contacts">Contact us</a></li>
        </ul>
    </div>
    <div class="emeon-account-content">
        <?php
            foreach( EMEON_STATUSES as $status )
                foreach( EMEON_TYPES as $type ) {
                    $none = true;
	                echo '<div id="' . $type . '-' . $status . '" class="content-area">';
	                foreach ( $dat[ $status ][ $type ] as $post ){
	                    $none = false;
		                setup_postdata( $post );
		                get_template_part( 'template-parts/content', 'account-ad' );
                    }
                }

        ?>
        <div class="emeon-pass-change" id="pass">
            <form >Pass edit form</form>
        </div>
        <div class="emeon-contacts" id="contacts">
            <form >Contacts form</form>
        </div>
    </div>
</div>
