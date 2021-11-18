<?php

/**
 * Template for contact us
 */

defined( 'ABSPATH' ) or exit;

$user = new WP_User( get_current_user_id() );

$email = $_POST[ 'email' ] ?? $_GET[ 'email' ] ?? $user->user_email;
$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" " method="post" class="emeon-form form-contactus" data-action="contactus"
      enctype="multipart/form-data" name="emeon-form">
	<fieldset>
		<div class="control-wrap">
			<input id="email" name="email" class="emeon-control" type="email" placeholder="your@email.com"
			       value="<?= $email ?>"/>
		</div>
		<div class="control-wrap">
			<input id="subject" name="subject" class="emeon-control" type="text" placeholder="Subject"
			       value="<?= $_POST[ 'subject' ] ?? '' ?>"/>
		</div>
		<div class="control-wrap">
			<?php
			wp_editor(
				$_POST[ 'content' ] ?? '',
				"article_content",
				[
					'textarea_name' => "content",
					'media_buttons' => false,
					'quicktags'     => false
				]
			);
			?>
		</div>
		<div class="control-wrap">
			<button type="submit" class="button emeon-control button-cta">Send</button>
		</div>

		<p class="description">
			Or just send us message to <a class="link-info" href="mailto:support@emeon.io">support@emeon.io</a>
		</p>

		<input type="hidden" name="emeon_form_action" value="contactus"/>
		<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
	</fieldset>
</form>
