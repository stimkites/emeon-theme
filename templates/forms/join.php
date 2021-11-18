<?php

/**
 * Template for join form
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST[ 'email' ] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>
<div class="form-join-wrapper bg-white rounded p-5">
	<h2>Join us</h2>
	<form method="post" class="emeon-form form-join d-flex justify-content-between" enctype="multipart/form-data" name="emeon-form" novalidate>
		<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
		<div id="step-1" class="emeon-join step-1">
			<p class="hint">We will send you a password to <a href="/account/">login</a></p>
			<div class="form-group">
				<label for="join_email" data-valid="Email is not valid" data-empty="This field couldn't be empty">
					<input id="join_email" class="form-control email" name="email" type="email" placeholder="Email"/>
				</label>
				<button type="submit" id="btn-join" class="button button-cta btn btn-primary block">Join</button>
			</div>
		</div>
	</form>
	<p class="privacy-policy-link">
		By joining us you accept and agree to our <a href="/privacy-policy/" target="_blank" title="Privacy policy">privacy policy rules.</a>
	</p>
</div>

