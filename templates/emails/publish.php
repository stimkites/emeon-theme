<?php
/**
 * Template Name: PUBLISH email action body. Contains password and login.
 */

$title      =
$subject    =   'EMEON - new post added!';
$subtitle   =   'Your brand new We are happy to help you recover your password.';

ob_start();

?>

<p> You (or someone else) has requested a link to restore the password for <a href="<?=site_url()?>" target="_blank">Emeon</a>.</p>
<p> Please <i>note</i>: if this was not you, just ignore this message.</p>

<h4>Please, use <a href="<?=wp_lostpassword_url( '/account/?recover&email=' . $user->user_email )?>" target="_blank">this link to recover.</a></h4>

<p>If you still experience difficulties with your account, please, drop a line to <a href="mailto:support@emeon.io">support@emeon.io</a></p>

<p>Looking forward to see you back online at <a href="<?=site_url()?>" target="_blank">Emeon</a>!</p>

<?php

$content = ob_get_clean();

include "_bones.php";
