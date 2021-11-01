<?php

/**
 * Template for join form
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST[ 'email' ] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" " method="post" class="emeon-form form-join" enctype="multipart/form-data" name="emeon-form" novalidate>
	<input type="hidden" name="emeon_form_action" value="join"/>
	<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
	<fieldset>
		<input id="email" name="email" type="email" placeholder="Email"/>
		<button type="submit" class="button button-cta">Join</button>
		<span class="error email" data-valid="<?= __('Email is not valid', EMEON_SLUG) ?>" data-empty="<?= __('This field couldn\'t be empty', EMEON_SLUG) ?>"><?= __('Email is not valid', EMEON_SLUG) ?></span>
		<span class="success"><?= __('You are successfully join us!') ?></span>
	</fieldset>
</form>
