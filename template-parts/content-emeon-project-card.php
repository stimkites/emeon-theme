<?php

/**
 * Template for single card in carousel for our projects
 *
 * @global $args
 */

?>

<div class="swiper-slide card border-0 rounded hover-shadow"
         style="box-sizing: content-box">
	<div class="card-body p-4">
		<a class="post-thumbnail card-img"
		   href="<?=$args['url']?>" aria-hidden="true" target="_blank" tabindex="-1">
			<img width="300"
			     height="125"
			     src="<?=$args['src']?>"
			     class="h-100 w-100 img-contain wp-post-image"
			     alt="<?=$args['title']??''?>" loading="lazy" />
		</a>

        <?php if( ! empty( $args['title'] ) ) : ?>
            <h3 class="entry-title mt-4 mb-1 ">
                <a class="fs-4" href="<?=$args['url']?>" target="_blank" rel="bookmark"><?=$args['title']?></a>
            </h3>
        <?php endif; ?>

	</div>
</div>
