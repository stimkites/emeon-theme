<?php

/**
 * Template for edit/add ad
 */

defined( 'ABSPATH' ) or exit;

$post = null;
$contacts = $_POST['contacts'] ?? [];
$uimage = $defimage = EMEON_URL . '/img/user-icon.png';

if( ! is_user_logged_in() ) {
    ?>
    <div class="error">Unauthorized access is prohibited!</div>
    <?php
    return;
}

if( isset( $_GET['edit'] ) ) {
    $post = get_post( $_GET['edit'] );
    if( ! $post || is_wp_error( $post ) )
        return '<p class="error">Ad not found!</p>';
    if( $post->post_author !== get_current_user_id() )
        return '<p class="error">Insufficient access level!</p>';
    $contacts = $_POST['contacts'] ?? get_post_meta( $post->ID, 'emeon_contacts', true );
    $uimage   = ( ( $image = wp_get_attachment_image_src( $post->ID ) ) ? $image : $uimage );
}

$nonce = wp_create_nonce( EMEON_SLUG );

$tags  = wp_dropdown_categories( [
	'taxonomy'   => 'post_tag',
	'id'         => 'ad_tags',
	'class'      => 'sel2',
	'hide_empty' => 0,
    'echo'       => false
] );

$cats  = wp_dropdown_categories( [
	'taxonomy'   => 'category',
    'id'         => 'ad_categories',
	'exclude'    => [ 1, 17, 18 ],
    'class'      => 'sel2',
	'hide_empty' => 0,
	'echo'       => false
] );

?>

<form action=" " method="post" class="emeon-form form-adedit" id="form-adedit" enctype="multipart/form-data" name="emeon-form">
    <fieldset>
        <div class="ad-type">
            <div class="ad-type-selectors">
                <input id="type-cv" type="radio" checked name="ad[type]" value="candidates" />
                <label for="type-cv">Candidate</label>
                <input id="type-vc" type="radio" name="ad[type]" value="vacancies" />
                <label for="type-vc">Vacancy</label>
            </div>
        </div>
        <div class="logo-wrap">
            <div class="logo-area">
                <span class="remove-icon logo-remove"></span>
                <img class="logo" src="<?=$uimage?>" data-default="<?=$defimage?>" alt="image"/>
            </div>
            <input type="file" id="photo-file" accept="image/*" name="adimage" value="" />
        </div>
        <div class="general-info">
            <div class="no-pads">
                <label>
                    <input type="text" name="ad[title]" placeholder="Title/name" value="<?=$post->post_title??''?>" />
                </label>
                <label>
                    <textarea name="ad[excerpt]"
                              class="ad-excerpt"
                              rows="5"
                              placeholder="A few lines in short..."><?=$post->post_excerpt??''?></textarea>
                </label>
            </div>
        </div>
        <div class="categories-tags-select">
            <h3>Categories and tags</h3>
            <p class="description">
                These are very important things on how ad will be found on site. Add new or use existing ones.
            </p>
            <label for="ad_categories">Categories</label>
            <?=$cats?>
            <label for="ad_tags">Tags</label>
            <?=$tags?>
        </div>
        <div class="contact-info">
            <h3>Contact info</h3>
            <p class="description">This info will be hidden to bots and non-registered visitors</p>
            <div class="no-pads">
                <label>
                    <input type="email"
                           name="contacts[email]"
                           value="<?=$contacts['email']??''?>"
                           placeholder="your@email.here"
                    />
                </label>
                <label>
                    <input type="text"
                           name="contacts[phone]"
                           placeholder="+1 233 456 789"
                           value="<?=$contacts['phone']??''?>" />
                </label>
                <label>
                    <textarea name="contacts[urls]"
                              rows="4"
                              class="ad-urls"
                              placeholder=" - Website URL <?="\n"?> - Portfolio URL<?="\n"?> - Another phone number<?="\n"?> ..."><?=$contacts['urls']??''?></textarea>
                </label>
            </div>
        </div>
        <div class="ad-text">
            <h3>
                Content
            </h3>
            <p class="description">
                Use official language communication only here. Any impolite phrases and words will cause moderation
                delay automatically.
            </p>
            <?php
			wp_editor( $post->post_content ?? '', "ad_content", [ 'media_buttons' => false, 'quicktags' => false ] );
			?>
        </div>
        <div class="attachment-area">
            <h3>
                Attachment PDF
            </h3>
            <p class="description">
                This document will be available for downloading to registered users.<br/>
                Maximum size is 5 mb. Click to add/replace the attachment below:
            </p>
            <div id="attachment-info">
                <span class="remove-icon attachment-remove"></span>
                <iframe id="attachment-preview" src=""></iframe>
                <span id="no-attachment">No file selected...</span>
            </div>
            <input type="file" id="attachment-file" name="ad[attachment]" accept=".pdf" />
        </div>

        <div class="cta-controls">
            <button type="submit" class="button button-cta">Save</button>
        </div>


        <input type="hidden" name="emeon_form_action" value="adedit" />
        <input type="hidden" name="__nonce" value="<?=$nonce?>" />
    </fieldset>
</form>
