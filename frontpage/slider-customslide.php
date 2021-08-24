<?php global $emeon_a13; ?>
<?php if(!empty($emeon_a13->get_option('customslide')) || is_customize_preview() ) { ?>
<div class="slidercus">
<?php echo do_shortcode($emeon_a13->get_option('customslide')); ?>
</div> 
<?php } ?>