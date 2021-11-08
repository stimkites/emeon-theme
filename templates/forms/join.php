<?php

/**
 * Template for join form
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST[ 'email' ] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>
<div class="form-join-wrapper bg-white rounded p-4">
	<h2>Join us</h2>
	<form method="post" class="emeon-form form-join d-flex justify-content-between" enctype="multipart/form-data" name="emeon-form" novalidate>
		<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>

		<div id="step-1" class="emeon-join step-1">
			<p>Step 1: your email, please.</p>
			<p class="hint">We will send you a password to login</p>
			<div class="form-group">
				<label for="join_email" data-valid="Email is not valid" data-empty="This field couldn't be empty" data-success="Password is sent!">
					<input id="join_email" class="form-control email" name="email" type="email" placeholder="Email"/>
				</label>
				<button type="button" id="btn-join" class="button button-cta btn btn-primary block">Join</button>
			</div>
		</div>
		<div id="step-2" class="emeon-join step-2" style="display: none">
			<p>Step 2: the password you received, please</p>
			<p class="hint">Enter the password we sent (check "spam")</p>
			<div class="form-group">
				<label for="join_pass" data-valid="Password is not valid" data-empty="This field couldn't be empty" data-success="Welcome aboard!">
					<input id="join_pass" class="form-control email" name="pass" type="password" placeholder="Password"/>
				</label>
				<button type="button" id="btn-login" class="button button-cta btn btn-primary block">Login</button>
			</div>
		</div>
	</form>
</div>

