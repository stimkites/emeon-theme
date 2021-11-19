<?php

/**
 * Template for simple login form
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST[ 'email' ] ?? $_GET[ 'email' ] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>

<div class="form-login-wrapper bg-white rounded p-5">
	<h2>Login</h2>
    <?php if( $_GET['joined'] ?? false ) : ?>
    <p>We have sent you a password to login, please check your mail.</p>
    <?php else : ?>
	<p>Access your posts and account</p>
    <?php endif; ?>
	<form action=" "
          method="post"
          class="emeon-form form-login"
          enctype="multipart/form-data"
          name="emeon-form"
          novalidate data-success="You are logged in successfully!">
		<fieldset class="emeon-form__fieldset">
			<label class="d-block mb-2">
				<input id="email"
                       name="email"
                       class="form-control"
                       type="text"
                       placeholder="Email/Login"
				       value="<?=$email?>"
                       data-empty="This field couldn't be empty!"
                       />
			</label>
			<label class="d-block mb-2">
				<input id="pass" class="form-control" name="pass" type="password" value="" placeholder="Pass"/>
			</label>
			<div class="form-check d-block mb-2">
				<input class="form-check-input" type="checkbox" name="remember" value="yes" id="flexCheckDefault">
				<label class="form-check-label" for="flexCheckDefault">
					Remember
				</label> |
				<a href="/recover/">Recover</a> |
                <a href="/join/">Register</a>
			</div>
			<button class="button button-cta btn btn-primary">Login</button>
			<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
		</fieldset>
	</form>
</div>

