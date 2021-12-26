<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package emeon
 */

defined( 'ABSPATH' ) or exit;

?>

</div><!-- #content -->

<?php if( ! EMEON_PRINTABLE ) :
	$nonce = $nonce = wp_create_nonce( EMEON_SLUG );
	?>


<footer id="colophon" class="site-footer">
	<div class="f-part f-logo-main">
		<a href="<?=site_url()?>">
			<img src="<?=get_template_directory_uri()?>/img/emeon-logo-2-cr.png" alt="EMEON" />
		</a>
		<a class="emeon-info" href="https://emeon.io">
			&copy; <?php echo get_bloginfo(); ?> <?php echo date( 'Y' ); ?>
		</a>
	</div>
	<div class="f-part site-info">
		<div class="footer-socials">
			<a href="https://www.facebook.com/people/Emeon-Webdev/100075559053781/" target="_blank">
				<img src="<?=get_template_directory_uri()?>/img/fb-icon.png" alt="Facebook" />
			</a>
			<a href="https://www.youtube.com/playlist?list=PLGispirKjL_ZsLtR-Fmz7BmrNw9RiloyT" target="_blank">
				<img src="<?=get_template_directory_uri()?>/img/yt-icon.png" alt="Youtube" />
			</a>
		</div>
		<div class="site-info-label">
			<span class="sep">|</span>
			<span>Works on ♥ <a href="https://wordpress.org/" target="_blank">WordPress</a></span>
			<span class="sep">|</span>
		</div>
	</div><!-- .site-info -->
	<div class="f-part footer-register">
		<form method="post" class="emeon-form form-join d-flex justify-content-between"
		      autocomplete="off" enctype="multipart/form-data" name="emeon-form" novalidate>
			<input type="hidden" name="__nonce" value="<?= $nonce ?>"/>
			<input id="fake-email" name="fake-email" type="email" placeholder=""
			       autocomplete="on" hidden style="display: none" />
			<div id="step-1" class="emeon-join step-1">
				<div class="form-group">
					<label for="join_email" data-valid="Email is not valid"
					       data-empty="This field cannot be empty">
						<input id="join_email" class="form-control email" name="email"
						       type="email" placeholder="Email"/>
					</label>
					<button type="submit" disabled id="btn-join"
					        class="button button-cta btn btn-primary block">Join</button>
				</div>
			</div>
		</form>
		<p class="privacy-policy-link form-check form-switch" >
			<input type="checkbox"
			       class="accept-policy form-check-input border-secondary bg-secondary btn-secondary text-secondary"
			       name="accept_policy"
			       id="accept-policy-footer"
			       value="yes" />
			<label class="form-check-label" for="accept-policy-footer">
				By joining you accept our
				<a href="/privacy-policy/" title="Privacy policy">privacy policy.</a>
			</label>
		</p>
	</div>
	<div class="f-part footer-logos">
		<div class="f-logo">
			<a href="https://wetail.io/" target="_blank">
				<img src="<?=get_template_directory_uri()?>/img/wetail_logo_grey.png" alt="Wetail" />
			</a>
			<span>In partnership with</span>
		</div>
	</div>
</footer><!-- #colophon -->

<?php endif ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
