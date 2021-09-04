<?php

/**
 * Template for edit/add ad
 */

defined( 'ABSPATH' ) or exit;

$post = null;

if( ! is_user_logged_in() ) return;

if( isset( $_GET['edit'] ) ) {
    $post = get_post( $_GET['edit'] );
    if( ! $post || is_wp_error( $post ) )
        return '<p class="error">Ad not found!</p>';
    if( $post->post_author !== get_current_user_id() )
        return '<p class="error">Insufficient access level!</p>';
    $contacts = get_post_meta( $post->ID, 'emeon_contacts', true );
}

$nonce = wp_create_nonce( EMEON_SLUG );

?>

<form action=" " method="post" class="emeon-form form-adedit" enctype="multipart/form-data" name="emeon-form">
    <fieldset>
        <div class="logo-wrap">
            <div class="logo-area">
                <span class="logo-remove"></span>
                <img class="logo" src="" alt="image"/>
            </div>
            <input type="file" accept="image/*" name="adimage" value="" />
        </div>
        <div class="general-info">
            <p class="ad-type">
                Ad type
                <span class="type">
                    <label for="type-cv">Candidate</label>
                    <input id="type-cv" type="radio" checked name="ad[type]" value="candidates" />
                </span>
                <span class="type">
                    <label for="type-vc">Vacancy</label>
                    <input id="type-vc" type="radio" checked name="ad[type]" value="vacancies" />
                </span>
            </p>
            <p>
                <label>
                    Name<br/>
                    <input type="text" name="ad[title]" value="<?=$post->post_title??''?>" />
                </label>
            </p>
            <p>
                <label>
                    Excerpt<br/>
                    <textarea name="ad[excerpt]" rows="5" placeholder="A few lines in short...">
                        <?=$post->post_excerpt??''?>
                    </textarea>
                </label>
            </p>
        </div>
        <div class="contact-info">
            <h4>This info will be hidden to bots and non-registered visitors</h4>
            <p>
                <label>
                    Email<br/>
                    <input type="email" name="contacts[email]" value="<?=$contacts['email']??''?>" />
                </label>
            </p>
            <p>
                <label>
                    Phone<br/>
                    <input type="text" name="contacts[phone]" value="<?=$contacts['phone']??''?>" />
                </label>
            </p>
            <p>
                <label>
                    Additional<br/>
                    <textarea name="contacts[urls]" rows="5" placeholder="Website, portfolio etc.">
                        <?=$contacts['urls']??''?>
                    </textarea>
                </label>
            </p>
        </div>
        <div class="ad-text">
            <label>
                Content
                <textarea name="ad[content]" rows="50">
                    <?=$post->post_content??''?>
                </textarea>
            </label>
        </div>
        <p>
            <button type="submit" class="button button-cta">Save</button>
        </p>
        <input type="hidden" name="emeon_form_action" value="adedit" />
        <input type="hidden" name="__nonce" value="<?=$nonce?>" />
    </fieldset>
</form>