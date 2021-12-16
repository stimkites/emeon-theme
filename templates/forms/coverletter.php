<?php

/**
 * Template for cover letter form
 */

defined( 'ABSPATH' ) or exit;

$user = new WP_User( get_current_user_id() );

$nonce = wp_create_nonce( EMEON_SLUG );

$example = get_page_by_title( 'prefilled-coverletter', OBJECT, 'post' );

if( ! (
	$content = $_POST[ 'coverletter_content' ] ?? get_user_meta( $user->ID, '_cover_letter', true )
) )
	$content = $example->post_content ?? '';

?>

<form action=" " method="post" class="emeon-form form-coverletter" data-action="coverletter"
      enctype="multipart/form-data" name="emeon-form">
    <p class="description">
	    Cover letter will help you to compose an email message to your potential employer/employee.
        The content is saved automatically when changed.
    </p>
	<fieldset class="emeon-form__fieldset">
		<div class="control-wrap content">
			<?php
			wp_editor(
				$content,
				"coverletter_content",
				[
					'textarea_name' => "coverletter_content",
					'media_buttons' => false,
					'quicktags'     => false,
					'editor_height' => 425,
				]
			);
			?>
		</div>
		<input type="hidden" name="emeon_form_action" value="coverletter"/>
		<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
	</fieldset>
</form>
