<?php
/**
 * Template for admin custom contact fields metabox
 */

/**
 * @global WP_Post $post
 */

$info = get_post_meta( $post->ID, 'emeon_contacts', true );

?>
<p class="description">
	This info will be hidden to non-registered users.
</p>
<fieldset>
	<p>
		<label>
			Email:
			<input type="email" name="emeon_contacts[email]" value="<?=$info['email']??''?>" />
		</label>
	</p>
	<p>
		<label>
			Phone:
			<input type="text" name="emeon_contacts[phone]" value="<?=$info['phone']??''?>" />
		</label>
	</p>
	<p>
		<label>
			Additional contacts:
			<textarea name="emeon_contacts[urls]" rows="4"><?=$info['urls']??''?></textarea>
		</label>
	</p>
</fieldset>
