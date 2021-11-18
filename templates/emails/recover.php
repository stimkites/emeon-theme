<?php
/**
 * Template Name: JOIN email action body. Contains password and login.
 */

$title      =
$subject    =   'EMEON password recover';
$subtitle   =   'We are happy to help you recover your password.';

$hash       = wp_generate_password( 24 );
update_user_meta( $user->ID, 'emeon_recovery_pass_hash', $hash );

ob_start();

?>

<p> You (or someone else) has requested a link to restore the password for <a href="<?=site_url()?>" target="_blank">Emeon</a>.</p>
<p> Please <i>note</i>: if this was not you, just ignore this message.</p>
<br/>
<p><b>Do not</b> send this link to anyone else, this is your automatic login link!</p>

<h4>Click <a href="<?=site_url(
        '/account/?recover&email=' . urlencode( $user->user_email ) . '&checksum=' . md5( base64_encode( $hash ) )
    )?>" target="_blank">here to login and set your new password.</a></h4>

<p>The login link can be used <b>only once.</b></p>

<p>If you still experience difficulties with your account, please, drop a line to <a href="mailto:support@emeon.io">support@emeon.io</a></p>

<p>Looking forward to see you back online at <a href="<?=site_url()?>" target="_blank">Emeon</a>!</p>

<?php

$content = ob_get_clean();

include "_bones.php";
