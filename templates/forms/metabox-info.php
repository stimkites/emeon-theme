<?php
/**
 * Template for admin custom contact fields metabox
 */

/**
 * @global WP_Post $post
 */

defined( 'ABSPATH' ) or exit;

$info = get_post_meta( $post->ID, 'emeon_contacts', true );
$pdf  = ( $pdf_id = get_post_meta( $post->ID, 'emeon_attachment', true ) ) ? wp_get_attachment_url( $pdf_id ) : '';

// Salary and experience
$salary     = get_post_meta( $post->ID, 'emeon_salary', true );
$experience = get_post_meta( $post->ID, 'emeon_experience', true );

?>
<div class="admin-info info-box emeon-box-contacts">
	<p class="description">
		This info will be hidden to non-registered users.
	</p>
	<h4>Contacts</h4>
	<fieldset>
		<p>
			<label>
				Email:
				<input type="email" name="emeon_contacts[email]" value="<?= $info[ 'email' ] ?? '' ?>"/>
			</label>
		</p>
		<p>
			<label>
				Phone:
				<input type="text" name="emeon_contacts[phone]" value="<?= $info[ 'phone' ] ?? '' ?>"/>
			</label>
		</p>
		<p>
			<label>
				Additional contacts:
				<textarea name="emeon_contacts[urls]" rows="4"><?= $info[ 'urls' ] ?? '' ?></textarea>
			</label>
		</p>
	</fieldset>
	<hr/>
	<h4>Salary and experience</h4>
	<fieldset>
		<p>
			<label>
				Salary, from (<?= EMEON_CURRENCY ?>):
				<input type="number" pattern="[0-9]" name="emeon_salary" value="<?= $salary ?? '' ?>"/>
			</label>
		</p>
		<p>
			<label>
				Experience:
				<select name="emeon_experience">
					<?php
					foreach ( EMEON_EXP_LVL as $index => $lvl ) {
						echo '<option ' .
						     ( (int) $experience === $index ? 'selected' : '' ) . '
                                value="' . $index . '">' . $lvl .
						     '</option>';
					}
					?>
				</select>
			</label>
		</p>
	</fieldset>
	<hr/>
	<h4>Attachment</h4>
	<fieldset>
		<p class="attachment-area">
			<label for="attachment-file" id="attachment-info" class="<?= ( $pdf ? 'added' : '' ) ?>">
				<span class="remove-icon attachment-remove"></span>
				<iframe id="attachment-preview" src="<?= $pdf ?>"></iframe>
				<span id="no-attachment">No file selected...</span>
				<input type="hidden" id="attachment-file" name="emeon_attachment" value="<?= $pdf_id ?? '' ?>"/>
			</label>
		</p>
	</fieldset>
</div>

