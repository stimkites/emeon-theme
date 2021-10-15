<?php
/**
 * If non-human detected - we ask to enter captcha code in this form
 */

defined( 'ABSPATH' ) or exit;

require_once EMEON_PATH . '/inc/captcha-gen.php';

$captcha = \SVG\Captcha\get( 'hard', $_SESSION[ 'captcha_answer' ] );

?>

<form action=" " method="post" class="emeon-form form-join" enctype="multipart/form-data" name="emeon-form">
	<input type="hidden" name="emeon_form_action" value="captcha"/>
	<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
	<div class="emeon-captcha">
		<?= $captcha ?>
	</div>
	<fieldset>
		<label>
			Please, enter the code
			<input id="captcha" name="captcha" type="text" value=""/>
		</label>
		<button type="submit" class="button button-cta">Validate</button>
	</fieldset>
</form>
