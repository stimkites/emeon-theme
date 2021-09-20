<?php

/**
 * Template for recover password
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST['email'] ?? $_GET['email'] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" " method="post" class="emeon-form form-recover" enctype="multipart/form-data" name="emeon-form">
	<fieldset>
        <p class="description">
            We will send a new password to your account.
        </p>
		<p>
			<input id="email" name="email" type="email" placeholder="Email" value="<?=$email?>" />
		</p>
        <p>
            <button class="button button-cta">Recover</button>
        </p>
		<input type="hidden" name="emeon_form_action" value="recover" />
		<input type="hidden" name="__nonce" value="<?=$nonce?>" />
	</fieldset>
</form>
