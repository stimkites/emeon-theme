<?php
/**
 * Template Name: Password change email.
 */

$title      =
$subject    =   'Password update at EMEON';
$subtitle   =   'Your new password is all setup!';

ob_start();

/** @global WP_User $user */

?>

<h4> Your new password details to <a href="<?=site_url() . '/account/'?>" target="_blank">login:</a> </h4>
<p><b style="width:200px; text-align: right; padding-right: 5px;">Login:</b><?=$user->user_login?></p>
<p><b style="width:200px; text-align: right; padding-right: 5px;">Pass:</b><?=$user->unhashed_pass?></p>

<p>Looking forward to see you back online at <a href="<?=site_url()?>" target="_blank">Emeon</a>!</p>

<?php

$content = ob_get_clean();

include "_bones.php";
