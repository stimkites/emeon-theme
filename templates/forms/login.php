<?php

/**
 * Template for simple login form
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST['email'] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" " method="post" class="emeon-form form-login" enctype="multipart/form-data" name="emeon-form">
	<fieldset>
		<p>
			<input id="email" name="email" type="email" placeholder="Email" value="<?=$email?>" />
		</p>
		<p>
			<input id="pass" name="pass" type="password" value="" placeholder="Pass" />
		</p>
		<p>
			<label>
				<input type="checkbox" value="yes" name="remember" checked />
				Remember
			</label> |
			<a href="/recover/" target="_self">Recover</a>
		</p>
		<p>
			<button class="button button-cta">Login</button>
		</p>
		<input type="hidden" name="emeon_form_action" value="login" />
		<input type="hidden" name="__nonce" value="<?=$nonce?>" />
	</fieldset>
</form>
