<?php
/**
 * Template Name: JOIN email action body. Contains password and login.
 */

$title      = 'Hello and welcome to EMEON!';
$subtitle   = 'Best careers start here! Best online vacancies!';

ob_start()

?>

<p> We are happy to welcome you onboard! </p>
<p> Publish your resumes or vacancies in an unlimited way! </p>

<h4> Your credentials to <a href="<?=site_url() . '/account/'?>" target="_blank">login:</a> </h4>
<p> Publish your resumes or vacancies in an unlimited way! </p>

<?php

$content = ob_get_clean();

include "_bones.php";

?>
