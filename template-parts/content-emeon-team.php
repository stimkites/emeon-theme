<?php

/**
 * Emeon team page template
 *
 */
?>
<div class="emeon-team-desciption">
	<h5>Emeon team. In partnership with Wetail AB, Sweden</h5><br/>
	<p>Have a thing to do about your site or web-shop? Feel free to <a href="/account/#contacts">share it with us!</a><br/></p>
	<p>If you want to join us and be the part of the team - simply <a href="/add-edit/">add your CV</a></p>
	<p>Want to publish vacancy and hire a Russian candidate for full hours? <a href="/add-edit/?type=vacancies">Go ahead!</a></p>
	<p>Need a brand new web-shop or a web-site? <a href="/account/#my-startup">TOTALLY FREE!</a></p>

	<div class="emeon-projects-description">

		<h4>Our partner's best eCommerce themes for your web-shop</h4>
		<p><a href="https://wetail.io/e-handelsteman/" target="_blank">Check here!</a></p>

		<h4>Web-sites, plugins and integrations we were working on</h4>

		<section class="section section--slider section--projects">
			<div class="projects projects--swiper swiper-slider" width="600" height="150">
				<div class="swiper-wrapper align-items-stretch">
					<?php
					foreach( glob( EMEON_PATH . '/img/projects-gallery/*' ) as $file )
						if( is_file( $file ) ){
							$fn    = basename( $file );
							$parts = explode( "=", $fn );
							$title = $parts[0];
							$url   = 'https://' . str_replace( '_', '/', substr( $parts[1],0, strlen( $parts[1] ) - 4 ) );
							$src   = get_template_directory_uri() . '/img/projects-gallery/' . $fn;
							get_template_part( 'template-parts/content', 'emeon-project-card', [
								'title' => $title,
								'url' => $url,
								'src' => $src
							] );
						}
					?>
				</div>
			</div>
			<div class="swiper-pagination swiper-pagination--projects"></div>
		</section>

	</div>

</div>

<h3>Our team</h3>
