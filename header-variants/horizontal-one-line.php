<?php
global $emeon_a13;

$variant         = $emeon_a13->get_option( 'header_horizontal_variant' );
$header_layout   = $emeon_a13->get_option( 'header_layout' );
$header_content_width = $emeon_a13->get_option( 'header_content_width' );
$header_width = ' ' . $header_content_width;
if($header_content_width === 'narrow' && $emeon_a13->get_option( 'header_content_width_narrow_bg') === 'on' ){
	$header_width .= ' narrow-header';
}

$header_classes = 'to-move a13-horizontal header-type-one_line a13-'.emeon_horizontal_header_color_variant().'-variant header-variant-' . $variant . $header_width;
$menu_on        = $emeon_a13->get_option( 'header_main_menu' ) === 'on';
$socials        = $emeon_a13->get_option( 'header_socials' ) === 'on';

$icons_no     = 0;
$header_tools = emeon_get_header_toolbar( $icons_no );
if ( ! $icons_no ) {
	$header_classes .= ' no-tools';
} else {
	$header_classes .= ' tools-icons-' . $icons_no; //number of icons
}

//how sticky version will behave
$header_classes .= ' '.$emeon_a13->get_option( 'header_horizontal_sticky' );

//hide until it is scrolled to
$show_header_at = $emeon_a13->emeon_get_meta('_horizontal_header_show_header_at' );
if(strlen($show_header_at) && $show_header_at > 0){
	$header_classes .= ' hide-until-scrolled-to';
}
?>

<header id="header" class="<?php echo esc_attr( $header_classes ); ?>  <?php if($header_layout == 'header_layout_two'){echo 'header_lay_two_head';}?>"<?php emeon_schema_args( 'header' ); ?>>
    <?php if($header_layout == 'header_layout_two'){?>
    <div class="header-lay-two">
        <div class="header-lay-two-center">
            <?php 
			if ( is_active_sidebar( 'top-left-widget-area' ) ) {
			?>
            <div class="left-topbar">
                <?php dynamic_sidebar( 'top-left-widget-area' ); ?>
            </div>
            <?php } ?>
            <?php 
			if ( is_active_sidebar( 'top-right-widget-area' ) ) {
			?>
            <div class="right-topbar">
                <?php dynamic_sidebar( 'top-right-widget-area' ); ?>
            </div>
            <?php } ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
    <?php } ?>
    <div class="head">
        <div class="logo-container"<?php emeon_schema_args('logo'); ?>>
            <?php emeon_header_logo(); ?>
        </div>
        <?php if ( $menu_on ): ?>
        <div id="navigation">
            <nav id="site-navigation" class="main-navigation">
                <button type="button" class="menu-toggle"> <span></span> <span></span> <span></span> </button>
                <?php
				wp_nav_menu(
					array(
						'theme_location' => 'header-menu'
					)
				);
				?>
            </nav>
        </div>
        <?php endif; ?>
        <!-- navigation --> 
        <!-- #access --> 
        <?php echo wp_kses_post($header_tools ); //escaped layout part ?>
        <?php if ( $socials ) {
			//check what color variant we use
			$color_variant = emeon_horizontal_header_color_variant();
			$color_variant = $color_variant === 'normal' ? '' : '_'.$color_variant;

			//escaped on creation
			echo wp_kses_post('<div class="topsoc">'.emeon_social_icons(
				$emeon_a13->get_option( 'header'.$color_variant.'_socials_color' ),
				$emeon_a13->get_option( 'header'.$color_variant.'_socials_color_hover' ),
				$emeon_a13->get_option( 'header_socials_display_on_mobile' ) === 'off'
			).'</div>');
		} ?>
    </div>
    <div class="clear"></div>
</header>
<!--Slider START-->
<?php
	$slidertype = $emeon_a13->get_option('custom_slider_option'); 
	if($slidertype !='disableslide'){
	if (is_front_page()) {
	?>
<?php get_template_part('frontpage/slider',''.$slidertype.''); ?>
<?php } ?>
<?php } ?>
<!--Slider END-->