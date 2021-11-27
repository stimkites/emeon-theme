<?php
/**
 * Template Name: JOIN email action body. Contains password and login.
 */

$title      =
$subject    =   'Hello and welcome to EMEON!';
$subtitle   =   'Best careers start here! Best online vacancies!';

ob_start();

/** @global WP_User $user */

?>

<p> We are happy to welcome you onboard! </p>
<p> Publish your resumes or vacancies in an unlimited way! </p>

<h4> Your credentials to <a href="<?=site_url() . '/account/'?>" target="_blank">login:</a> </h4>
<p><b style="width:200px; text-align: right; padding-right: 5px;">Login:</b><?=$user->user_login?></p>
<p><b style="width:200px; text-align: right; padding-right: 5px;">Pass:</b><?=$user->unhashed_pass?></p>

<p>Looking forward to see you online at <a href="<?=site_url()?>" target="_blank">Emeon</a>!</p>

<?php

$content = ob_get_clean();

include "_bones.php";
