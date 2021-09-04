<?php

/**
 * Template for join form
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST['email'] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" " method="post" class="emeon-form form-join" enctype="multipart/form-data" name="emeon-form">
    <input type="hidden" name="emeon_form_action" value="join" />
    <input type="hidden" name="__nonce" value="<?=$nonce?>" />
	<fieldset>
        <input id="email" name="email" type="email" placeholder="Email" value="<?=$email?>" />
        <button type="submit" class="button button-cta">Join</button>
	</fieldset>
</form>
