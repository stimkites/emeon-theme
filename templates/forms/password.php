<?php

/**
 * Template for changing password
 */

defined( 'ABSPATH' ) or exit;

$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" " data-action="passchange"
      autocomplete="off" method="post"
      class="emeon-form form-password"
      enctype="multipart/form-data"
      name="emeon-form">
	<input type="hidden" name="emeon_form_action" value="password"/>
	<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
	<input type="password" name="fake" autocomplete="false" value="" style="display:none;"/>
	<fieldset>
		<input type="checkbox" id="view-pass"/>
		<label for="view-pass"></label>

        <?php if( 'recover' === ( $_GET['mode'] ?? '' ) ) : ?>
            <input name="current"
                   class="change-pass"
                   type="hidden"
                   autocomplete="false"
                   value="<?=wp_create_nonce( 'EMEON_RECOVER_PASS' . strtotime( 'today' ) )?>" />
        <?php else : ?>
		<input id="current-pass"
               class="change-pass view-toggle"
               name="current"
               type="password"
               autocomplete="false"
		       placeholder="Current"
               value="" />
        <?php endif; ?>
		<input id="new-pass"
               class="change-pass view-toggle"
               name="new"
               type="password"
               autocomplete="false"
               placeholder="New"
		       value="" />
		<input id="confirm-pass"
               class="view-toggle"
               name="confirm"
               type="password"
               autocomplete="false"
		       placeholder="Confirm"
               value="" />

		<button type="submit" class="button button-cta">Set</button>

	</fieldset>
</form>
