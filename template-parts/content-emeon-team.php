<?php

/**
 * Emeon team page template
 *
 */
?>
<div class="emeon-team-desciption">

    <h5>In partnership with <a href="https://wetail.io/" target="_blank">Wetail AB, Sweden</a></h5>

    <p class="image-hero-text">
        <img src="<?=get_template_directory_uri()?>/img/help.svg" />
        <span class="hero-text">
            Have a thing to do about your site or web-shop? Something broken? New feature needed? Easily! Just register
            and describe your issue! Registration is as fast as typing your email!
            <a class="button shadow-sm btn btn-primary rounded-pill text-uppercase px-5 me-3 mb-3 "
               href="/account/#contacts">Share it with us!</a><br/>
        </span>
    </p>

    <p class="image-hero-text">
        <span class="hero-text">
            Want to join us and get your tasks in minutes? It is possible! Just publish your resume or CV and dont
            forget to enable "Join Emeon" feature! We will get in touch asap!
            <a class="button shadow-sm btn btn-outline-secondary rounded-pill text-uppercase px-5 me-3 mb-3"
               href="/add-edit/">Add your resume</a>
        </span>
        <img src="<?=get_template_directory_uri()?>/img/hero.svg" />
    </p>

	<p class="image-hero-text">
        <img src="<?=get_template_directory_uri()?>/img/hire.svg" />
        <span class="hero-text">
            Want to publish vacancy and hire a candidate for full hours, but not sure? We will help! Tick "Join Emeon"
            while publishing your vacancy! Even more! We can hire a candidate for you so you wont need any accountancy
            or tax-related things to care about! Just Work!
            <a class="button shadow-sm btn btn-outline-secondary rounded-pill text-uppercase px-5 me-3 mb-3"
               href="/add-edit/?type=vacancies">Go ahead!</a>
        </span>
    </p>

	<p class="image-hero-text">
        <span class="hero-text">
            Need a brand new web-shop or a web-site? Easily! A few lines to describe what you want and thats it!
            No credit card needed! Absolutely free to try it as long as you want!
            <a  class="button shadow-sm btn btn-primary btn-outline-secondary rounded-pill text-uppercase px-5 me-3 mb-3"
                href="/account/#my-startup">Launch!</a>
        </span>
        <img src="<?=get_template_directory_uri()?>/img/emeon-logo-2.svg" />
    </p>

	<div class="emeon-projects-description">

		<h4>Our partner's best eCommerce themes for your web-shop</h4>

        <p><a href="https://wetail.io/e-handelsteman/" target="_blank">Check all of them!</a></p>

        <section class="section section--slider section--themes">
            <div class="projects themes--swiper swiper-slider" width="600" height="150">
                <div class="swiper-wrapper align-items-stretch">
					<?php
					foreach( glob( EMEON_PATH . '/img/themes-gallery/*' ) as $file )
						if( is_file( $file ) ){
							$fn    = basename( $file );
							$src   = get_template_directory_uri() . '/img/themes-gallery/' . $fn;
							get_template_part( 'template-parts/content', 'emeon-project-card', [
								'url' => 'https://wetail.io/e-handelsteman/',
								'src' => $src
							] );
						}
					?>
                </div>
            </div>
            <div class="swiper-pagination swiper-pagination--themes"></div>
        </section>



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
            <div class="swiper-button-prev swiper-button-prev--projects"></div>
            <div class="swiper-button-next swiper-button-next--projects"></div>
		</section>

	</div>

</div>

<h3>Our team</h3>
