<?php
/**
 * The template for displaying main body
 */

defined( 'ABSPATH' ) or exit;

get_header();

?>

<article id="content" class="clearfix">
    <div class="content-limiter">
        <div id="col-mask">
            <div id="post-<?php the_ID();?>">
                <div class="formatter">
                    <div class="real-content">
                        <?php the_content(); ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</article>

<?php

get_footer();
