<?php

/**
 * Template for single card in carousel for our projects
 *
 * @global $args
 */

?>

<article class="swiper-slide card border-0 rounded hover-shadow"
         style="box-sizing: content-box">
	<div class="card-body p-4">
		<a class="post-thumbnail card-img"
		   href="<?=$args['url']?>" aria-hidden="true" tabindex="-1">
			<img width="300"
			     height="125"
			     src="<?=$args['src']?>"
			     class="h-100 w-100 img-cover rounded-pill wp-post-image"
			     alt="<?=$args['title']?>" loading="lazy">
		</a>

		<h3 class="entry-title mt-4 mb-1 ">
			<a class="fs-4" href="<?=$args['url']?>" rel="bookmark"><?=$args['title']?></a>
		</h3>
	</div>
</article>
