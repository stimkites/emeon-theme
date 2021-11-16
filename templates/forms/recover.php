<?php

/**
 * Template for recover password
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST[ 'email' ] ?? $_GET[ 'email' ] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>
<div class="form-login-wrapper bg-white rounded p-5">
    <h2>Recover</h2>
    <p>We will send you a special link to restore your password</p>
    <form action=" "
          method="post"
          class="emeon-form form-recover"
          id="emeon-recover-form"
          enctype="multipart/form-data"
          name="emeon-recover-form">
        <fieldset class="emeon-form__fieldset">
            <p>
                <input id="email"
                       name="email"
                       type="email"
                       style="width: 100%"
                       placeholder="Email"
                       data-invalid="The email address you entered is invalid!"
                       value="<?= $email ?>"/>
            </p>
            <p>
                <button class="button button-cta btn btn-primary">Recover</button>
            </p>
            <input type="hidden" name="emeon_form_action" value="recover"/>
            <input type="hidden" id="__nonce" value="<?= $nonce ?>"/>
        </fieldset>
    </form>
	<div class="recover-success">
		<p class="message">The link to recover your password has been sent to <span id="email-sent"></span>!</p>
		<p class="message">Please, check your inbox (and also spam) messages and proceed to <a href="/account/">login</a>.</p>
	</div>
</div>
