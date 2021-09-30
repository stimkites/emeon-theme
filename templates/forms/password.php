<?php

/**
 * Template for changing password
 */

defined( 'ABSPATH' ) or exit;

$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" " method="post" class="emeon-form form-password" enctype="multipart/form-data" name="emeon-form">
    <input type="hidden" name="emeon_form_action" value="password" />
    <input type="hidden" name="__nonce" value="<?=$nonce?>" />
	<fieldset>
        <label>
            <input type="checkbox" id="view-pass" />
            View
        </label>
        <input id="current-pass" name="current" type="password" placeholder="Current" value="" />
        <input id="new-pass" name="new" type="password" placeholder="New" value="" />
        <input id="current-pass" name="confirm" type="password" placeholder="Confirm" value="" />
        <button type="submit" class="button button-cta">Set</button>
	</fieldset>
</form>
