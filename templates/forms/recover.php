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
    <p>We will send you a new password to login</p>
    <form action=" " method="post" class="emeon-form form-recover" enctype="multipart/form-data" name="emeon-form">
        <fieldset>
            <p>
                <input id="email" name="email" type="email" placeholder="Email" value="<?= $email ?>"/>
            </p>
            <p>
                <button class="button button-cta btn btn-primary">Recover</button>
            </p>
            <input type="hidden" name="emeon_form_action" value="recover"/>
            <input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
        </fieldset>
    </form>
</div>
