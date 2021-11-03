<?php

/**
 * Template for join form
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST[ 'email' ] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>
<div class="form-join-wrapper bg-white rounded p-4">
	<h2>
		<?= __('Join us', EMEON_SLUG) ?>
	</h2>
	<p>
		<?= __('Please enter your email and we will register you!', EMEON_SLUG) ?>
	</p>
	<form method="post" class="emeon-form form-join d-flex justify-content-between" enctype="multipart/form-data" name="emeon-form" novalidate>

		<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
		<div class="form-group">
			<label for="join_email" data-valid="<?= __('Email is not valid', EMEON_SLUG) ?>" data-empty="<?= __('This field couldn\'t be empty', EMEON_SLUG) ?>" data-success="<?=  __('You are successfully join us!') ?>">
				<input id="join_email" class="form-control email" name="email" type="email" placeholder="Email"/>
			</label>
		</div>
		<button type="submit" class="button button-cta btn btn-primary block">Join</button>
	</form>
</div>

