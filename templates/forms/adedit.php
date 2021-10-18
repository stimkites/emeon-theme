<?php

/**
 * Template for edit/add ad
 */

defined( 'ABSPATH' ) or exit;

$post              = null;
$pid               = $_GET[ 'ad' ] ?? $_POST[ 'ID' ] ?? 0; // in case we edit
$def_image         = EMEON_URL . '/img/user-icon.png';
$vacancies_cat_id  = get_term_by( 'slug', 'vacancies', 'category' )->term_id ?? 0;
$candidates_cat_id = get_term_by( 'slug', 'candidates', 'category' )->term_id ?? 0;

/**
 * Advertisement data to fulfill
 */
$article = [ 'type' => 'candidates' ];

/**
 * Prevent unauthorized access
 */
if ( ! is_user_logged_in() ) {
	return $_POST[ 'emeon_erros' ][] = 'Unauthorized access is prohibited!';
}

if ( isset( $_POST[ 'article' ] ) ) { // we already posted data, but something went wrong and we were not redirected
	$article = $_POST[ 'article' ];
} elseif ( $pid ) { // we start editing existing post
	$post = get_post( $pid );
	if ( ! $post || is_wp_error( $post ) ) {
		return $_POST[ 'emeon_error' ][] = 'Article #' . $pid . ' not found!';
	}
	if ( $post->post_author != get_current_user_id() ) {
		return $_POST[ 'emeon_error' ][] = 'Insufficient access level for editing article #' . $pid;
	}
	$post_cats  = wp_get_post_categories( $post->ID );
	$post_tags  = wp_get_post_tags( $post->ID, [ 'fields' => 'ids' ] );
	$contacts   = get_post_meta( $post->ID, 'emeon_contacts', true );
	$salary     = get_post_meta( $post->ID, 'emeon_salary', true );
	$experience = get_post_meta( $post->ID, 'emeon_experience', true );
	$attachment = ( $pdf_id = get_post_meta( $post->ID, 'emeon_attachment', true ) ) ? wp_get_attachment_url( $pdf_id ) : '';
	$article    = [
		'type'       => in_array( $vacancies_cat_id, $post_cats ) ? 'vacancies' : 'candidates',
		'title'      => $post->post_title,
		'image'      => ( ( $image = get_the_post_thumbnail_url( $post->ID ) ) ? $image : $def_image ),
		'excerpt'    => $post->post_excerpt,
		'categories' => $post_cats,
		'tags'       => $post_tags,
		'email'      => $contacts[ 'email' ] ?? '',
		'phone'      => $contacts[ 'phone' ] ?? '',
		'urls'       => $contacts[ 'urls' ] ?? '',
		'salary'     => $salary,
		'experience' => $experience,
		'content'    => $post->post_content,
		'attachment' => $attachment
	];
}

$tags_args = [
	'taxonomy'   => 'post_tag',
	'hide_empty' => 0
];

?>

<form action=" "
      method="post"
      class="emeon-form form-article-edit mx-auto col-lg-9 col-xl-8 col-xxl-7"
      id="form-article-edit"
      enctype="multipart/form-data"
      name="emeon-form">
	<fieldset class="emeon-form__fieldset">

		<div class="article-type mb-4">
			<div class="btn-group w-100">

				<input id="type-cv"
				       class="btn-check"
				       type="radio" <?= ( $article[ 'type' ] === 'candidates' ? 'checked' : '' ) ?>
				       name="article[type]"
				       value="candidates"/>
				<label class="btn btn-outline-dark" for="type-cv">Candidate</label>

				<input id="type-vc"
				       class="btn-check"
				       type="radio" <?= ( $article[ 'type' ] === 'vacancies' ? 'checked' : '' ) ?>
				       name="article[type]"
				       value="vacancies"/>
				<label class="btn btn-outline-dark" for="type-vc">Vacancy</label>

			</div>
		</div>

		<div class="row mb-4">
			<div class="logo-wrap col">
				<label for="photo-file" class="logo-area <?= ( isset( $article[ 'image' ] ) ? 'added' : '' ) ?>">
					<button class="remove-icon logo-remove"></button>
					<img class="logo" src="<?= $article[ 'image' ] ?? $def_image ?>" data-default="<?= $def_image ?>"
					     alt="image"/>
				</label>
				<input type="file"
				       id="photo-file"
				       class="visually-hidden"
				       accept="image/*"
				       name="article_image"
				       value=""/>
			</div>

			<div class="general-info col-12 col-md-6">
				<div class="list-group">
					<label class="control-wrap list-group-item p-0">
						<input type="text"
						       class="form-control border-0 invalidate"
						       name="article[title]"
						       placeholder="Title/name"
						       value="<?= $article[ 'title' ] ?? '' ?>"/>
					</label>

					<label class="control-wrap list-group-item p-0">
					<textarea name="article[excerpt]"
					          class="form-control border-0 article-excerpt invalidate"
					          rows="5"
					          placeholder="A few lines in short..."><?= $article[ 'excerpt' ] ?? '' ?></textarea>
					</label>
				</div>
			</div>
		</div>

		<div class="categories-tags-select basic-info mb-4">

			<h3 class="text-center">Categories, tags, salary and experience</h3>
			<p class="text-center description">
				Select/add categories, tags and set the minimum salary level and experience.
			</p>
			<div class="list-group">

				<label class="control-wrap list-group-item p-0" for="article_categories">

					<select id="article_categories"
					        class="sel2 invalidate form-select border-0"
					        name="article[categories][]"
					        data-placeholder="Categories"
					        multiple>
						<?=apply_filters( 'emeon_cats', '', $post_cats??[] )?>
					</select>
				</label>

				<label class="control-wrap list-group-item p-0" for="article_tags">

					<select id="article_tags"
					        class="sel2 invalidate form-select border-0"
					        name="article[tags][]"
					        data-placeholder="Tags"
					        multiple>
						<?php foreach ( get_terms( $tags_args ) as $tag )
							echo '<option value="' . $tag->slug . '" ' .
								     ( in_array( $tag->term_id, $post_tags ?? [] ) ? 'selected' : '' ) . '>' .
								     $tag->name .
							     '</option>';
						?>
					</select>
				</label>

				<label class="control-wrap input-group list-group-item p-0 d-flex">
					<input type="number" class="invalidate form-control border-0 emeon-salary"
					       name="article[salary]"
					       pattern="[0-9]" step="50" min="0"
					       value="<?= $article[ 'salary' ] ?? '' ?>"
					       placeholder="Salary from (EUR)"/>
					<span class="input-group-text border-0 rounded-0"><?= EMEON_CUR_SYMB ?></span>
				</label>

				<label class="control-wrap list-group-item w-100 p-0">
					<select name="article[experience]" class="invalidate form-select border-0">
						<?php
						foreach ( EMEON_EXP_LVL as $index => $lvl ) {
							echo '<option ' .
							     ( isset ( $article[ 'experience' ] ) && ( (int) $article[ 'experience' ] === $index ) ? 'selected' : '' ) . '
                            value="' . $index . '">' . $lvl .
							     '</option>';
						}
						?>
					</select>
				</label>
			</div>
		</div>

		<div class="article-text mb-4">

			<h3 class="text-center">
				Content
			</h3>
			<p class="text-center description">
				Use official language communication only here. Any impolite phrases and words will cause moderation
				delay automatically.
			</p>

			<div class="control-wrap">
				<?php
				wp_editor(
					$article[ 'content' ] ?? '',
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

		<div class="contact-info mb-5">

			<h3 class="text-center">Contacts and attachment</h3>

			<p class="text-center description">Info below will be visible to authorized users only</p>

			<div class="list-group">
				<label class="control-wrap list-group-item p-0">
					<input type="email"
					       name="article[email]"
					       class="form-control border-0 invalidate"
					       value="<?= $article[ 'email' ] ?? '' ?>"
					       placeholder="your@email.here"
					/>
				</label>

				<label class="control-wrap list-group-item p-0">
					<input type="text"
					       name="article[phone]"
					       class="form-control border-0 invalidate"
					       placeholder="+1 233 456 789"
					       value="<?= $article[ 'phone' ] ?? '' ?>"/>
				</label>

				<label class="control-wrap list-group-item p-0">
                    <textarea name="article[urls]"
                              rows="4"
                              class="form-control border-0 article-urls invalidate"
                              placeholder=
                              " - Website URL <?= "\n" ?> - Portfolio URL<?= "\n" ?> - Another phone number<?= "\n" ?> ..."
                    ><?= $article[ 'urls' ] ?? '' ?></textarea>
				</label>
			</div>
		</div>

		<div class="attachment-area mb-4">

			<label for="attachment-file" id="attachment-info"
			       class="<?= ( isset( $article[ 'attachment' ] ) ? 'added' : '' ) ?>">
				<span class="remove-icon attachment-remove"></span>
				<iframe id="attachment-preview" src="<?= $article[ 'attachment' ] ?? '' ?>"></iframe>
				<span id="no-attachment">PDF for downloading. Max size is 5 mb.</span>
			</label>

			<input type="file" id="attachment-file" class="visually-hidden" name="article_attachment" accept=".pdf"/>

		</div>

		<div class="form-check form-switch join-emeon-prompt mb-5">
			<input id="want_join" class="form-check-input" type="checkbox" name="article[want_join]" value="yes"/>
			<label for="want_join" class="form-check-label">
				Join Emeon team.
				<a href="/join-info/"
				   class="link-info"
				   target="_blank"
				   title="Find out more about this offer">Read more</a>
			</label>
		</div>

		<div class="cta-controls d-flex justify-content-between align-items-center">
			<button type="submit" class="button cta-button btn btn-primary px-5">Save</button>
			<br/>
			<a href="/account/" class="cta-cancel btn btn-outline-danger">Cancel</a>
		</div>

		<input type="hidden" name="emeon_form_action" value="adedit"/>
		<input type="hidden" name="article[id]" value="<?= $post->ID ?? 0 ?>"/>

	</fieldset>
</form>
