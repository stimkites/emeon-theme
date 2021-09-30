<?php

/**
 * Template for contact us
 */

defined( 'ABSPATH' ) or exit;

$email = $_POST['email'] ?? $_GET['email'] ?? '';
$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" " method="post" class="emeon-form form-contactus" enctype="multipart/form-data" name="emeon-form">
	<fieldset>
		<p>
			<input id="email" name="email" type="email" placeholder="your@email.com" value="<?=$email?>" />
		</p>
        <p>
            <input id="subject" name="subject" type="text" placeholder="Subject" value="<?=$_POST['subject']??''?>" />
        </p>
        <p>
            <textarea class="emeon-textarea"
                      id="content"
                      name="content"
                      type="text"
                      placeholder="Your message"
            ><?=$_POST['content']??''?></textarea>
        </p>
		<p>
			<button type="submit" class="button button-cta">Send</button>
		</p>
		<input type="hidden" name="emeon_form_action" value="contactus" />
		<input type="hidden" name="__nonce" value="<?=$nonce?>" />
	</fieldset>
</form>
