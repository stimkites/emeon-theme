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

?>
<style>
    .emeon-box-contacts {
        width: 100%;
    }
    .emeon-box-contacts h4 {
        font-weight: normal;
        font-size: 14px;
    }
    .emeon-box-contacts input,
    .emeon-box-contacts textarea {
        width: 100%;
    }
    #attachment-info {
        margin: 20px auto;
        padding: 0;
        text-align: center;
        border: 3px dotted #ccc;
        cursor: pointer;
        display: flex;
        justify-content: center;
        position: relative;
    }
    #attachment-info.added {
        border: 1px solid #000;
    }
    #attachment-info .remove-icon {
        top: -30px;
    }
    #attachment-info #attachment-preview {
        border: none;
        width: 100%;
        height: 500px;
        cursor: pointer;
        display: none;
        margin: 0;
        padding: 0;
    }
    #attachment-info #no-attachment {
        padding: 20px;
        display: block;
        font-size: 11px;
    }
    #attachment-info.added #no-attachment {
        display: none;
    }
</style>
<div class="admin-info info-box emeon-box-contacts">
    <h4>Contacts</h4>
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
    <hr/>
    <h4>Attachment</h4>
    <p class="description">
        This is an attachment to the advertisement (PDF)
    </p>
    <fieldset>
        <p class="attachment-area">
            <label for="attachment-file" id="attachment-info" class="<?=($pdf?'added':'')?>">
                <span class="remove-icon attachment-remove"></span>
                <iframe id="attachment-preview" src="<?=$pdf?>"></iframe>
                <span id="no-attachment">No file selected...</span>
            </label>
        </p>
    </fieldset>
</div>

