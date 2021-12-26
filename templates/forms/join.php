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
	<form method="post" class="emeon-form form-join d-flex justify-content-between"
	      autocomplete="off" enctype="multipart/form-data" name="emeon-form" novalidate >
		<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
		<input id="fake-email" name="fake-email" type="email" placeholder="" autocomplete="on" hidden style="display: none" />
		<div id="step-1" class="emeon-join step-1">
			<p class="hint">We will send you a password to <a href="/account/">login</a></p>
			<div class="form-group">
				<label for="join_email" data-valid="Email is not valid" data-empty="This field cannot be empty">
					<input id="join_email" class="form-control email" name="email" type="email"
					       placeholder="Email" value="<?=$email?>"/>
				</label>
				<button type="submit" disabled id="btn-join" class="button button-cta btn btn-primary block">Join</button>
			</div>
		</div>
	</form>
	<p class="privacy-policy-link">
        <label>
            <input class="accept-policy" type="checkbox" name="accept_policy" id="accept-policy" value="yes" />
		    By joining us you accept and agree to our
            <a href="/privacy-policy/" title="Privacy policy">privacy policy rules.</a>
        </label>
	</p>
</div>

