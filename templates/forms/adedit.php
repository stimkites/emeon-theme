<?php

/**
 * Template for edit/add ad
 */

defined( 'ABSPATH' ) or exit;

$post       = null;
$pid        = $_GET['ad'] ?? $_POST['ID'] ?? 0; // in case we edit
$def_image  = EMEON_URL . '/img/user-icon.png';
$vacancies_cat_id  = get_term_by( 'slug', 'vacancies',  'category' )->term_id ?? 0;
$candidates_cat_id = get_term_by( 'slug', 'candidates', 'category' )->term_id ?? 0;

/**
 * Advertisement data to fulfill
 */
$article = [ 'type' => 'candidates' ];

/**
 * Prevent unauthorized access
 */
if( ! is_user_logged_in() )
    return $_POST['emeon_erros'][] = 'Unauthorized access is prohibited!';

if( isset( $_POST['article'] ) ) { // we already posted data, but something went wrong and we were not redirected
    $article = $_POST['article'];
} elseif( $pid ) { // we start editing existing post
    $post = get_post( $pid );
    if( ! $post || is_wp_error( $post ) )
        return $_POST['emeon_error'][] = 'Article #' . $pid . ' not found!';
    if( $post->post_author != get_current_user_id() )
        return $_POST['emeon_error'][] = 'Insufficient access level for editing article #' . $pid;
    $post_cats = wp_get_post_categories( $post->ID );
    $post_tags = wp_get_post_tags( $post->ID, [ 'fields' => 'ids' ] );
    $contacts  = get_post_meta( $post->ID, 'emeon_contacts', true );
    $attachment= ( $pdf_id = get_post_meta( $post->ID, 'emeon_attachment', true ) ) ? wp_get_attachment_url( $pdf_id ) : '';
    $article = [
        'type'      => in_array( $vacancies_cat_id, $post_cats ) ? 'vacancies' : 'candidates',
        'title'     => $post->post_title,
        'image'     => ( ( $image = get_the_post_thumbnail_url( $post->ID ) ) ? $image : $def_image ),
        'excerpt'   => $post->post_excerpt,
        'categories'=> $post_cats,
        'tags'      => $post_tags,
        'email'     => $contacts[ 'email' ] ?? '',
        'phone'     => $contacts[ 'phone' ] ?? '',
        'urls'      => $contacts[ 'urls'  ] ?? '',
        'content'   => $post->post_content,
        'attachment'=> $attachment
    ];
}

$tags_args  = [
	'taxonomy'   => 'post_tag',
	'hide_empty' => 0
];

$ex_cats = [ 1 ];
foreach ( EMEON_TYPES as $type )
    if( $term = get_term_by( 'slug', $type, 'category' ) )
        $ex_cats[] = $term->term_id;

$cats_args  = [
	'taxonomy'   => 'category',
    'exclude'    => $ex_cats,
    'hide_empty' => 0
];

?>

<form action=" "
      method="post"
      class="emeon-form form-article-edit"
      id="form-article-edit"
      enctype="multipart/form-data"
      name="emeon-form" >
    <fieldset>

        <div class="article-type">
            <div class="article-type-selectors">

                <input id="type-cv"
                       type="radio" <?=($article['type'] === 'candidates'?'checked':'')?>
                       name="article[type]"
                       value="candidates" />
                <label for="type-cv">Candidate</label>

                <input id="type-vc"
                       type="radio" <?=($article['type'] === 'vacancies' ?'checked':'')?>
                       name="article[type]"
                       value="vacancies" />
                <label for="type-vc">Vacancy</label>

            </div>
        </div>

        <div class="logo-wrap">
            <label for="photo-file" class="logo-area <?=($article['image']?'added':'')?>">
                <span class="remove-icon logo-remove"></span>
                <img class="logo" src="<?=$article['image']??$def_image?>" data-default="<?=$def_image?>" alt="image"/>
            </label>
            <input type="file" id="photo-file" accept="image/*" name="article_image" value="" />
        </div>

        <div class="general-info">
            <div class="no-pads">

                <label class="control-wrap">
                    <input type="text"
                           class="invalidate"
                           name="article[title]"
                           placeholder="Title/name"
                           value="<?=$article['title']??''?>" />
                </label>

                <label class="control-wrap">
                    <textarea name="article[excerpt]"
                              class="article-excerpt invalidate"
                              rows="5"
                              placeholder="A few lines in short..."><?=$article['excerpt']??''?></textarea>
                </label>

            </div>
        </div>

        <div class="categories-tags-select">

            <h3>Categories and tags</h3>
            <p class="description">
                This will help to find your ad. Add new or use existing ones.
            </p>

            <label for="article_categories">Categories</label>
            <div class="control-wrap">
                <select id="article_categories" name="article[categories][]" multiple class="sel2 invalidate">
                    <?php
                    if( $cats = get_terms( $cats_args ) )
                        foreach ( $cats as $cat )
                            echo '<option value="' . $cat->term_id . '" ' .
                                    ( in_array( $cat->term_id, $post_cats ?? [] ) ? 'selected' : '' ) . '>' .
                                        $cat->name .
                                '</option>';
                    else
                        echo '<option value="-1" selected disabled>No categories</option>';
                    ?>
                </select>
            </div>

            <label for="article_tags">Tags</label>
            <div class="control-wrap">
                <select id="article_tags" name="article[tags][]" multiple class="sel2 invalidate">
                    <?php
                    if( $tags = get_terms( $tags_args ) )
                        foreach ( $tags as $tag )
                            echo '<option value="' . $tag->slug . '" ' .
                                ( in_array( $tag->term_id, $post_tags ?? [] ) ? 'selected' : '' ) . '>' .
                                $tag->name .
                                '</option>';
                    else
                        echo '<option value="-1" selected disabled>No tags</option>';
                    ?>
                </select>
            </div>

        </div>

        <div class="contact-info">

            <h3>Contact info</h3>
            <p class="description">This info will be visible to authorized users only</p>

            <div class="no-pads">

                <label class="control-wrap">
                    <input type="email"
                           name="article[email]"
                           class="invalidate"
                           value="<?=$article['email']??''?>"
                           placeholder="your@email.here"
                    />
                </label>

                <label class="control-wrap">
                    <input type="text"
                           name="article[phone]"
                           class="invalidate"
                           placeholder="+1 233 456 789"
                           value="<?=$article['phone']??''?>" />
                </label>

                <label class="control-wrap">
                    <textarea name="article[urls]"
                              rows="4"
                              class="article-urls invalidate"
                              placeholder =
                              " - Website URL <?="\n"?> - Portfolio URL<?="\n"?> - Another phone number<?="\n"?> ..."
                    ><?=$article['urls']??''?></textarea>
                </label>

            </div>
        </div>

        <div class="article-text">

            <h3>
                Content
            </h3>
            <p class="description">
                Use official language communication only here. Any impolite phrases and words will cause moderation
                delay automatically.
            </p>

            <div class="control-wrap">
                <?php
                wp_editor(
                    $article['content'] ?? '',
                    "article_content",
                    [
                        'textarea_name' => "article[content]",
                        'editor_class'  => 'invalidate',
                        'media_buttons' => false,
                        'quicktags'     => false
                    ]
                );
                ?>
            </div>

        </div>
        <div class="attachment-area">

            <h3>
                Attachment PDF
            </h3>
            <p class="description">
                This document will be available for downloading to registered users.<br/>
                Maximum size is 5 mb. Click to add/replace the attachment below:
            </p>

            <label for="attachment-file" id="attachment-info" class="<?=($article['attachment']?'added':'')?>">
                <span class="remove-icon attachment-remove"></span>
                <iframe id="attachment-preview" src="<?=$article['attachment']??''?>"></iframe>
                <span id="no-attachment">No file selected...</span>
            </label>

            <input type="file" id="attachment-file" name="article_attachment" accept=".pdf" />

        </div>

        <div class="cta-controls">
            <button type="submit" class="button button-cta">Save</button>
        </div>


        <input type="hidden" name="emeon_form_action" value="adedit" />
        <input type="hidden" name="article[id]" value="<?=$post->ID??0?>" />

    </fieldset>
</form>
