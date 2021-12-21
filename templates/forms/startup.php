<?php

/**
 * Template for contact us
 */

defined( 'ABSPATH' ) or exit;

$user = new WP_User( get_current_user_id() );

$nonce = wp_create_nonce( EMEON_SLUG );

?>
<form action=" " method="post" class="emeon-form form-startup" data-action="startup"
      enctype="multipart/form-data" name="emeon-form">

	<h4>Start your online business today for FREE!</h4>

	<p class="description image-hero-text">
		<img src="<?=get_template_directory_uri()?>/img/help.svg" alt="New Business with Emeon"/>
        <span class="hero-text">
            To help you starting an IT business we only need a few lines about it. And yes, we will setup <b>a brand new
            web-shop</b> for you completely for free! Just describe it to us!
        </span>
	</p>

	<p class="description image-hero-text">
        <span class="hero-text text-right">
            Wondering how it will look like? - We are using <a href="https://wordpress.org/" target="_blank">WordPress</a>
            and <a href="https://woocommerce.com/" target="_blank">WooCommerce</a> as a platform for your future web-shop!
            It means you will have the freedom to choose
            <a href="https://wordpress.org/themes/search/storefront/" target="_blank">any of themes</a>
            all around the world! Check out our partner's
            <a href="https://wetail.io/e-handelsteman/" target="_blank">featured themes</a>
            explicitly customized for e-Commerce!
        </span>
        <img src="<?=get_template_directory_uri()?>/img/wp-themes.png" alt="Word Press Themes"/>
	</p>

	<fieldset class="emeon-form__fieldset">
		<div class="control-wrap email">
			<input id="domain" name="domain" class="emeon-control"
			       type="text" placeholder="desired.domain.name"
			       value=""/>
			<p class="description">
				Not sure? Leave empty. We will pick the best one for you.
			</p>
		</div>
		<div class="control-wrap subject">
			<input id="project-name" name="project" class="emeon-control"
			       type="text" placeholder="Project name. E.g. My super-shop"
			       value=""/>
		</div>
		<h4>Description</h4>
		<p class="description">
			Note: If you totally not sure on what to start with - just drop us a line with at least a few words.
		</p>
		<div class="control-wrap content">
			<?php
			wp_editor(
				$_POST[ 'startup_content' ] ?? '',
				"startup_content",
				[
					'textarea_name' => "startup_content",
					'media_buttons' => false,
					'quicktags'     => false,
					'editor_height' => 425,
				]
			);
			?>
		</div>

		<div class="form-check form-switch choose-free-plan mb-5">
			<input id="free-plan" class="form-check-input border-secondary bg-secondary btn-secondary text-secondary"
			       type="checkbox"
				   name="plan"
				   value="free"/>
			<label for="free-plan" class="form-check-label">
				Free plan
				<a href="/plans/"
				   class="link-info"
				   target="_blank"
				   title="Find out more about this">Read more</a>
			</label>
		</div>

		<div class="control-wrap startup-cta">
			<button type="submit" class="button emeon-control button-cta">Start my business</button>
		</div>

		<p class="description email-us">
			Or just send us message to <a class="link-info" href="mailto:business@emeon.io">business@emeon.io</a>
		</p>

		<input type="hidden" name="emeon_form_action" value="startup"/>
		<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
	</fieldset>
</form>
<div id="startup-success" class="success-result" style="display: none">
    <h3>Startup application is sent successfully!</h3>
    <p>Your own business project <span id="project-name"></span> is launching now!<span class="icon-rocket"></span></p>
    <p>We will get in touch with you via email <span id="email-sent"><?=$user->user_email?></span> as soon as the launch
	   is done! Usually it takes up to 24 hours.</p>
    <p>Thank you for starting your online business with us!</p>
    <p>Good times!</p>
    <p><a href="/account/" class="button">Ok</a></p>
</div>
