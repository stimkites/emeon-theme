<?php
/**
 * Functions that prints various elements across layout
 */


if(!function_exists('emeon_page_preloader')){
	/**
	 * Prints page preloader screen
	 */
	function emeon_page_preloader(){
        global $emeon_a13;

        if($emeon_a13->get_option( 'preloader' ) === 'on'){
	        $preloader_type = $emeon_a13->get_option(  'preloader_type' );
	        $class_attr = $preloader_type;
	        if($emeon_a13->get_option( 'preloader_hide_event' )==='ready'){
		        $class_attr .= ' onReady';
	        }
        ?>
<div id="preloader" class="<?php echo esc_attr($class_attr); ?>">
    <div class="preload-content">
        <div class="preloader-animation"><?php emeon_preloader_animation_html($preloader_type); ?></div>
        <a class="skip-preloader a13icon-cross" href="#"></a>
    </div>
</div>
        <?php
        }
    }
}


function emeon_page_preloader_css() {
	global $emeon_a13;

	$css = '';

	//prelaoder
	if ( $emeon_a13->get_option( 'preloader' ) === 'on' ) {
		$prelaoder_bg_color     = emeon_make_css_rule( 'background-color', $emeon_a13->get_option_color_rgba( 'preloader_bg_color' ) );
		$prelaoder_bg_image     = emeon_make_css_rule( 'background-image', $emeon_a13->get_option_media_url( 'preloader_bg_image' ), 'url(%s)' );
		$prelaoder_bg_image_fit = emeon_bg_fit_helper( $emeon_a13->get_option( 'preloader_bg_image_fit' ) );

		$css .= "
#preloader{
    $prelaoder_bg_color
    $prelaoder_bg_image
    $prelaoder_bg_image_fit
}";

		$prelaoder_type  = $emeon_a13->get_option( 'preloader_type' );
		if ( $prelaoder_type !== 'none' ) {
			$preloader_css_file = get_theme_file_path( 'css/preloaders/' . $prelaoder_type . '.css' );
			$content = emeon_read_contents( $preloader_css_file );

			if( $content !== false ){
				$prelaoder_color = $emeon_a13->get_option_color_rgba( 'preloader_color' );
				$string_to_replace = '#fff/*$color*/';

				$css .= str_replace( $string_to_replace, $prelaoder_color, $content );
			}
		}
	}

	return $css;
}

function emeon_page_preloader_partial_css($response) {
	return emeon_prepare_partial_css($response, 'preloader_bg_image', 'emeon_page_preloader_css');
}
add_filter( 'customize_render_partials_response', 'emeon_page_preloader_partial_css' );




if(!function_exists('emeon_preloader_animation_html')){
	/**
	 * Prints one of few animations for preloader screen
	 *
	 * @param string $animation name of animation
	 */
	function emeon_preloader_animation_html($animation) {
		switch($animation){
			case $animation === 'circle_illusion':
				?>
				<div class='blob-wrap'>
					<div class='translate'>
						<div class='scale'></div>
					</div>
				</div>
				<div class='blob-wrap'>
					<div class='translate'>
						<div class='scale'></div>
					</div>
				</div>
				<div class='blob-wrap'>
					<div class='translate'>
						<div class='scale'></div>
					</div>
				</div>
				<div class='blob-wrap'>
					<div class='translate'>
						<div class='scale'></div>
					</div>
				</div>
				<div class='blob-wrap'>
					<div class='translate'>
						<div class='scale'></div>
					</div>
				</div>
				<div class='blob-wrap'>
					<div class='translate'>
						<div class='scale'></div>
					</div>
				</div>
				<div class='blob-wrap'>
					<div class='translate'>
						<div class='scale'></div>
					</div>
				</div>
				<div class='blob-wrap'>
					<div class='translate'>
						<div class='scale'></div>
					</div>
				</div>
				<div class='blob-wrap'>
					<div class='translate'>
						<div class='scale'></div>
					</div>
				</div>
				<?php
				break;

			case $animation === 'square_of_squares':
				?>
				<div class="sos-load">
					<div class="blockcont">
						<div class="sos-block"></div>
						<div class="sos-block"></div>
						<div class="sos-block"></div>

						<div class="sos-block"></div>
						<div class="sos-block"></div>
						<div class="sos-block"></div>

						<div class="sos-block"></div>
						<div class="sos-block"></div>
						<div class="sos-block"></div>

					</div>
				</div>
				<?php
				break;

			case $animation === 'plus_minus':
				?>
				<div class="pm-top">
					<div class="square">
						<div class="square">
							<div class="square">
								<div class="square">
									<div class="square"><div class="square">

										</div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pm-bottom">
					<div class="square">
						<div class="square">
							<div class="square">
								<div class="square">
									<div class="square"><div class="square">
										</div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pm-left">
					<div class="square">
						<div class="square">
							<div class="square">
								<div class="square">
									<div class="square"><div class="square">
										</div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pm-right">
					<div class="square">
						<div class="square">
							<div class="square">
								<div class="square">
									<div class="square"><div class="square">
										</div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
				break;

			case $animation === 'hand':
				?>
				<div class="hand-loading">
					<div class="finger finger-1">
						<div class="finger-item">
							<span></span><i></i>
						</div>
					</div>
					<div class="finger finger-2">
						<div class="finger-item">
							<span></span><i></i>
						</div>
					</div>
					<div class="finger finger-3">
						<div class="finger-item">
							<span></span><i></i>
						</div>
					</div>
					<div class="finger finger-4">
						<div class="finger-item">
							<span></span><i></i>
						</div>
					</div>
					<div class="last-finger">
						<div class="last-finger-item"><i></i></div>
					</div>
				</div>
				<?php
				break;

			case $animation === 'blurry':
				?>
				<div class="blurry-box"></div>
				<?php
				break;

			case $animation === 'arcs':
				?>
				<div class="arc">
					<div class="arc-cube"></div>
				</div>
				<?php
				break;

			case $animation === 'tetromino':
				?>
				<div class='tetrominos'>
					<div class='tetromino-box box1'></div>
					<div class='tetromino-box box2'></div>
					<div class='tetromino-box box3'></div>
					<div class='tetromino-box box4'></div>
				</div>
				<?php
				break;

			case $animation === 'infinity':
				?>
				<div class='infinity-container'>
					<div class='inf-lt'></div>
					<div class='inf-rt'></div>
					<div class='inf-lb'></div>
					<div class='inf-rb'></div>
				</div>
				<?php
				break;

			case $animation === 'cloud_circle':
				?>
				<div class='cloud-circle-container'>
					<div class='cloud-circle'>
						<div class='inner'></div>
					</div>
					<div class='cloud-circle'>
						<div class='inner'></div>
					</div>
					<div class='cloud-circle'>
						<div class='inner'></div>
					</div>
					<div class='cloud-circle'>
						<div class='inner'></div>
					</div>
					<div class='cloud-circle'>
						<div class='inner'></div>
					</div>
				</div>
				<?php
				break;

			case $animation === 'dots':
				?>
				<div class='dots-loading'>
					<div class='bullet'></div>
					<div class='bullet'></div>
					<div class='bullet'></div>
					<div class='bullet'></div>
				</div>
				<?php
				break;

			case $animation === 'jet_pack_man':
				?>
				<div class="jet-pack-man-body">
				    <span>
				        <span></span>
				        <span></span>
				        <span></span>
				        <span></span>
				    </span>
					<div class="jet-pack-man-base">
						<span></span>
						<div class="jet-pack-man-face"></div>
					</div>
				</div>
				<div class="longfazers">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
				<?php
				break;

			case $animation === 'circle':
				?>
				<div class="circle-loader"></div>
				<?php
				break;

			default:
				?>
				<div class="pace-progress"><div class="pace-progress-inner"></div ></div>
		        <div class="pace-activity"></div>
				<?php
		}
	}
}



if(!function_exists('emeon_page_background')){
	/**
	 * Prints page background element
	 */
	function emeon_page_background(){
        ?>
        <div class="page-background to-move"></div>
        <?php
    }
}



function emeon_page_background_css() {
	global $emeon_a13;

	$global_bg_color   = emeon_make_css_rule( 'background-color', $emeon_a13->get_option_color_rgba( 'appearance_body_bg_color' ) );
	$global_image      = emeon_make_css_rule( 'background-image', $emeon_a13->get_option_media_url( 'appearance_body_image' ), 'url(%s)' );
	$global_image_fit  = emeon_bg_fit_helper( $emeon_a13->get_option( 'appearance_body_image_fit' ) );
	$error404_bg_image = emeon_make_css_rule( 'background-image', $emeon_a13->get_option_media_url( 'page_404_bg_image' ), 'url(%s)' );
	$password_bg_image = emeon_make_css_rule( 'background-image', $emeon_a13->get_option_media_url( 'page_password_bg_image' ), 'url(%s)' );

	$css = "
/* backgrounds */
.page-background{
    $global_bg_color
    $global_image
    $global_image_fit
}
.default404 .page-background{
	$error404_bg_image
}
";

//single pages
if ( $emeon_a13->get_option( 'page_custom_background' ) === 'on' ) {
	$page_bg_color  = emeon_make_css_rule( 'background-color', $emeon_a13->get_option_color_rgba( 'page_body_bg_color' ) );
	$page_image     = emeon_make_css_rule( 'background-image', $emeon_a13->get_option_media_url( 'page_body_image' ), 'url(%s)' );
	$page_image_fit = emeon_bg_fit_helper( $emeon_a13->get_option( 'page_body_image_fit' ) );

	$css .= "
.page .page-background{
    $page_bg_color
    $page_image
    $page_image_fit
}";
}

//blog
if ( $emeon_a13->get_option( 'blog_custom_background' ) === 'on' ) {
	$blog_bg_color  = emeon_make_css_rule( 'background-color', $emeon_a13->get_option_color_rgba( 'blog_body_bg_color' ) );
	$blog_image     = emeon_make_css_rule( 'background-image', $emeon_a13->get_option_media_url( 'blog_body_image' ), 'url(%s)' );
	$blog_image_fit = emeon_bg_fit_helper( $emeon_a13->get_option( 'blog_body_image_fit' ) );

	$css .= "
.single-post .page-background,
.posts-list .page-background{
    $blog_bg_color
    $blog_image
    $blog_image_fit
}";
}

//shop
if ( $emeon_a13->get_option( 'shop_custom_background' ) === 'on' ) {
	$shop_bg_color  = emeon_make_css_rule( 'background-color', $emeon_a13->get_option_color_rgba( 'shop_body_bg_color' ) );
	$shop_image     = emeon_make_css_rule( 'background-image', $emeon_a13->get_option_media_url( 'shop_body_image' ), 'url(%s)' );
	$shop_image_fit = emeon_bg_fit_helper( $emeon_a13->get_option( 'shop_body_image_fit' ) );

	$css .= "
.woocommerce-page .page-background{
    $shop_bg_color
    $shop_image
    $shop_image_fit
}";
}

	$css .= "
.password-protected .page-background{
	$password_bg_image
}";


	return $css;
}

function emeon_page_background_partial_css($response) {
	return emeon_prepare_partial_css($response, 'appearance_body_image', 'emeon_page_background_css');
}
add_filter( 'customize_render_partials_response', 'emeon_page_background_partial_css' );




if(!function_exists('emeon_theme_borders')){
	/**
	 * Prints theme border if enabled
	 */
	function emeon_theme_borders(){
		global $emeon_a13;

		if($emeon_a13->get_option( 'layout_type' ) === 'bordered') {
			?>
			<div class="theme-borders">
				<div class="top-border"></div>
				<div class="right-border"></div>
				<div class="bottom-border"></div>
				<div class="left-border"></div>
			</div>
			<?php
		}
    }
}

if(!function_exists('emeon_get_title_bar')){
	/**
	 * Prints Page title bar
	 *
	 * @param string $called_position   position of title bar in page
	 * @param string $title             title of page
	 * @param string $subtitle          subtitle of page
	 *
	 * @return string|void
	 */
	function emeon_get_title_bar( $called_position = 'outside', $title = '', $subtitle = '') {
        global $emeon_a13;

        $page_type = emeon_what_page_type_is_it();
        $home = $page_type['home'];
		$title_bar_option = 'on';
		$tb_classes = '';
		$data_attr = '';
        $position = 'outside';
		$title_bar_variant = 'classic';
		$title_bar_width = 'full';
        $_subtitle = '';
		$has_effect = true;
	    $is_password_protected = post_password_required();

 
        //shop product
        if($page_type['product']){
	        $title_bar_option = $emeon_a13->get_option( 'product_title', 'on' );
	        $position         = $emeon_a13->get_option( 'product_title_bar_position', 'inside' );
	        $title_bar_variant = $emeon_a13->get_option( 'product_title_bar_variant' );
	        $title_bar_width = $emeon_a13->get_option( 'product_title_bar_width' );

	        //parallax
	        $parallax = $emeon_a13->get_option( 'product_title_bar_parallax' ) === 'on';

	        if ( $parallax ) {
		        $parallax_type = $emeon_a13->get_option( 'product_title_bar_parallax_type' );
		        $parallax_speed = $emeon_a13->get_option( 'shop_title_bar_parallax_speed' );
		        $tb_classes .= ' a13-parallax';
		        $data_attr .= ' data-a13-parallax-type="'.esc_attr($parallax_type).'" data-a13-parallax-speed="'.esc_attr((float)$parallax_speed).'"';
	        }

	        if($title_bar_option === 'off' || $position === 'outside' ){
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	        }
        }
        //cart and others not sidebar/title pages of woocommerce
        elseif( ( $page_type['shop'] && !emeon_is_woocommerce_sidebar_page() ) ||
                //wish list
                ( class_exists( 'YITH_WCWL' ) && (get_the_ID() === (int)yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) ) ) ) ){

	        $title_bar_option = $emeon_a13->get_option( 'shop_no_major_pages_title' );
	        //position is not overwritten
	        $title_bar_variant = $emeon_a13->get_option( 'shop_no_major_pages_title_bar_variant' );
	        $title_bar_width = $emeon_a13->get_option( 'shop_no_major_pages_title_bar_width' );

	        //parallax
	        $parallax = $emeon_a13->get_option( 'shop_no_major_pages_title_bar_parallax' ) === 'on';

	        if ( $parallax ) {
		        $parallax_type = $emeon_a13->get_option( 'shop_no_major_pages_title_bar_parallax_type' );
		        $parallax_speed = $emeon_a13->get_option( 'shop_title_bar_parallax_speed' );
		        $tb_classes .= ' a13-parallax';
		        $data_attr .= ' data-a13-parallax-type="'.esc_attr($parallax_type).'" data-a13-parallax-speed="'.esc_attr((float)$parallax_speed).'"';
	        }
        }
        //shop
        elseif($page_type['shop']){
	        $title_bar_option = $emeon_a13->get_option( 'shop_title' );
	        //position is not overwritten
	        $title_bar_variant = $emeon_a13->get_option( 'shop_title_bar_variant' );
	        $title_bar_width = $emeon_a13->get_option( 'shop_title_bar_width' );

	        //parallax
	        $parallax = $emeon_a13->get_option( 'shop_title_bar_parallax' ) === 'on';

	        if ( $parallax ) {
		        $parallax_type = $emeon_a13->get_option( 'shop_title_bar_parallax_type' );
		        $parallax_speed = $emeon_a13->get_option( 'shop_title_bar_parallax_speed' );
		        $tb_classes .= ' a13-parallax';
		        $data_attr .= ' data-a13-parallax-type="'.esc_attr($parallax_type).'" data-a13-parallax-speed="'.esc_attr((float)$parallax_speed).'"';
	        }
        }
        //blog type
        elseif($page_type['blog_type']){
	        $title_bar_option = $emeon_a13->get_option( 'blog_title' );
	        //position is not overwritten
	        $title_bar_variant = $emeon_a13->get_option( 'blog_title_bar_variant' );
	        $title_bar_width = $emeon_a13->get_option( 'blog_title_bar_width' );

	        //parallax
	        $parallax = $emeon_a13->get_option( 'blog_title_bar_parallax' ) === 'on';

	        if ( $parallax ) {
		        $parallax_type = $emeon_a13->get_option( 'blog_title_bar_parallax_type' );
		        $parallax_speed = $emeon_a13->get_option( 'blog_title_bar_parallax_speed' );
		        $tb_classes .= ' a13-parallax';
		        $data_attr .= ' data-a13-parallax-type="'.esc_attr($parallax_type).'" data-a13-parallax-speed="'.esc_attr((float)$parallax_speed).'"';
	        }
        }
        elseif($is_password_protected){
	        $position = 'outside';
	        $title_bar_variant = 'centered';
	        $has_effect = false;
        }
        //attachments page
        elseif($page_type['attachment']){
	        $position = 'inside';
        }
        //pages, posts, works
        elseif($page_type['page'] || $page_type['post']){
            $meta_id = get_the_ID();
            $_subtitle = $emeon_a13->emeon_get_meta('_subtitle', $meta_id);
            $title_bar_option = $emeon_a13->emeon_get_meta('_title_bar_settings', $meta_id);
			//if post was not "edited" yet, then use default settings
	        if($title_bar_option === ''){
		        $title_bar_option = 'global';
	        }

            //three way check which options to apply to title bar
            if( $title_bar_option === 'global' ){
	            if( $page_type['page'] ){
		            $post_type = 'page';
	            }
	            elseif( $page_type['post'] ){
		            $post_type = 'post';
	            }

	            $title_bar_option    = $emeon_a13->get_option( $post_type . '_title' );
	            $position            = $emeon_a13->get_option( $post_type . '_title_bar_position' );
	            $title_bar_variant   = $emeon_a13->get_option( $post_type . '_title_bar_variant' );
	            $title_bar_width     = $emeon_a13->get_option( $post_type . '_title_bar_width' );

	            //parallax
	            $parallax = $emeon_a13->get_option( $post_type.'_title_bar_parallax' ) === 'on';

	            if ( $parallax ) {
		            $parallax_type = $emeon_a13->get_option( $post_type.'_title_bar_parallax_type' );
		            $parallax_speed = $emeon_a13->get_option( $post_type.'_title_bar_parallax_speed' );
		            $tb_classes .= ' a13-parallax';
		            $data_attr .= ' data-a13-parallax-type="'.esc_attr($parallax_type).'" data-a13-parallax-speed="'.esc_attr((float)$parallax_speed).'"';
	            }
            }
            else{
                //use settings from this page
                $position = $emeon_a13->emeon_get_meta('_title_bar_position', $meta_id);
	            $title_bar_variant = $emeon_a13->emeon_get_meta('_title_bar_variant', $meta_id);
	            $title_bar_width = $emeon_a13->emeon_get_meta('_title_bar_width', $meta_id);
	            $display_breadcrumbs = $emeon_a13->emeon_get_meta('_breadcrumbs', $meta_id) === 'on';

	            //parallax
		        $parallax = $emeon_a13->emeon_get_meta('_title_bar_parallax', $meta_id) === 'on';

		        if ( $parallax ) {
			        $parallax_type = $emeon_a13->emeon_get_meta('_title_bar_parallax_type', $meta_id);
			        $parallax_speed = $emeon_a13->emeon_get_meta('_title_bar_parallax_speed', $meta_id);
			        $tb_classes .= ' a13-parallax';
			        $data_attr .= ' data-a13-parallax-type="'.esc_attr($parallax_type).'" data-a13-parallax-speed="'.esc_attr((float)$parallax_speed).'"';
		        }
            }
        }
		elseif($page_type['404']){
			$position = 'outside';
			$display_breadcrumbs = false;
			$title_bar_variant = 'centered';
		}


        //is it OFF?
        if(!emeon_is_no_property_page() && !$is_password_protected){ //checks if page can have meta fields
            if($title_bar_option === 'off'){
	            return '';
            }
        }


        //check in which place we called for title bar(inside/outside content)
		if ( $position !== $called_position ) {
			if( $called_position === 'outside' ){
				return '';
			}
			else{
				if($page_type['post']){
					//when outside title bar is used, hentry data is outside of container, so we have to provide it other way
					return '<div class="post-hatom-fix">
								<span class="entry-title">'.get_the_title().'</span>
								'.emeon_get_post_meta_data().'
							</div>';

				}
				else{
					return '';
				}
			}
		}


        //subtitle
        $subtitle    = empty($subtitle)? $_subtitle : $subtitle;
        $subtitle_on = strlen($subtitle);

        //title bar classes
		$tb_classes .= $subtitle_on? ' subtitle' : '';
		$tb_classes .= ' '.$position;
		$tb_classes .= $called_position === 'inside' ? '' : ' title_bar_variant_'.$title_bar_variant;
		$tb_classes .= $called_position === 'inside' ? '' : ' title_bar_width_'.$title_bar_width;
		$tb_classes .= $has_effect ? ' has-effect' : '';


		//if title was not provided
		if(strlen($title) === 0){
			//WooCommerce shop page
			if(emeon_is_woocommerce_activated() && emeon_is_woocommerce_products_list_page()){
				if(is_product_category()){
					$title = woocommerce_page_title(false);
				}
				else{
					$title = get_the_title(wc_get_page_id( 'shop' ));
				}
			}
			//blog
			elseif ( $home ){
				if(get_option('page_for_posts') === '0'){
					$title =  esc_html__( 'Blog', 'emeon' );
				}
				else{
					$title = get_the_title(get_option('page_for_posts'));
				}
			}
			//pages, blog post, etc.
			else{
				$title = get_the_title();
			}
		}

		$html = '';

		if($position === 'inside'){
			$html .= emeon_get_top_image_video(false, array('full_size' => true)); //so small images will look good instead of being stretched
		}

	    $html .= '<header class="title-bar'. esc_attr($tb_classes).'"'.$data_attr.'><div class="overlay-color"><div class="in">';

		$post_meta = '';
		if($page_type['post'] && !$is_password_protected){
			$post_meta = emeon_get_post_meta_data();
		}

		if($title_bar_variant === 'classic' && $called_position === 'outside'){
			$html .= '<div class="titles">';
			$html .= $post_meta;
		}
		else{
			$html .= $post_meta;
			$html .= '<div class="titles">';
		}

        //subtitle
        if($subtitle_on){
            $html .= '<h2>'.$subtitle.'</h2>';
        }

		//main title
		$html .= '<h1 class="page-title entry-title"'.emeon_get_schema_args('headline').'>'.$title.'</h1>';//sometimes we add html here, so don't escape!

		$html .='</div>';//.titles

	    $html .='</div></div></header>';

		return $html;
    }
}

if(!function_exists('emeon_title_bar')){
	/**
	 * Prints Page title bar
	 *
	 * @param string $called_position position of title bar in page
	 * @param string $title    title of page
	 * @param string $subtitle subtitle of page
	 *
	 */
	function emeon_title_bar( $called_position = 'outside', $title = '', $subtitle = '') {
		//emeon_get_title_bar() produces escaped content
		echo wp_kses_post(emeon_get_title_bar( $called_position, $title, $subtitle));
	}
}



if(!function_exists('emeon_page_individual_look')){
	/**
	 * Prints CSS for title bar
	 */
	function emeon_page_individual_look(){
        global $emeon_a13;

        //checks if page can have meta fields
        //if not page will use styles defined in user.css
        if(!emeon_is_no_property_page()){
            $css = '';
            $page_type = emeon_what_page_type_is_it();
            $body_class = '.page';

	        //if this is not page, post or work, then have nothing to do here
            if(!($page_type['post'] || $page_type['page'])){
                return;
            }

	        //we set style for these in customizer, so we don't use settings from "Page details"
	        if($page_type['shop'] || $page_type['blog_type']){
		        return;
	        }

            //id from where
            $meta_id = false;

            if($page_type['page']){
                $meta_id = get_the_ID();
            }
            elseif($page_type['post']){
                $meta_id = get_the_ID();
                $body_class = '.single-post';
            }
	        //even if it is static currently, let's be safe for future
	        $body_class = wp_strip_all_tags( $body_class );


	        /***************************************/
            /* PAGE BACKGROUND */
            /***************************************/
            $page_bg_option = $emeon_a13->emeon_get_meta('_page_bg_settings', $meta_id);

            if($page_bg_option === 'custom'){
                $bg_color       = wp_strip_all_tags( get_post_meta($meta_id, '_page_bg_color', true) );
                $bg_image       = wp_strip_all_tags( get_post_meta($meta_id, '_page_image', true) );
                $bg_image_fit   = wp_strip_all_tags( emeon_bg_fit_helper(get_post_meta($meta_id, '_page_image_fit', true)) );

                $css .= '
                    '.$body_class.' .page-background{
                        background-color:'.$bg_color.';
                        background-image: url('.$bg_image.');
                        '.$bg_image_fit.'
                    }
                ';
            }



            /***************************************/
            /* TITLE BAR */
            /***************************************/
            $title_bar_option = $emeon_a13->emeon_get_meta( '_title_bar_settings', $meta_id );

	        //change everything
            if ( $title_bar_option === 'custom' ) {
                //where title bar should be displayed
                $position = $emeon_a13->emeon_get_meta( '_title_bar_position', $meta_id );

                //we don't style "inside" title bars
	            if ( $position !== 'inside' ) {
		            $bg_color     = wp_strip_all_tags( get_post_meta( $meta_id, '_title_bar_bg_color', true ) );
		            $bg_image     = wp_strip_all_tags( emeon_get_top_image_video(false, array('return_src' =>  true, 'force_image' => true, 'full_size' => true)) );
		            $bg_fit       = wp_strip_all_tags( emeon_bg_fit_helper( get_post_meta( $meta_id, '_title_bar_image_fit', true ) ) );
		            $title_color  = wp_strip_all_tags( get_post_meta( $meta_id, '_title_bar_title_color', true ) );
		            $second_color = wp_strip_all_tags( get_post_meta( $meta_id, '_title_bar_color_1', true ) );
		            $space        = wp_strip_all_tags( get_post_meta( $meta_id, '_title_bar_space_width', true ) );

		            $css .= '
                        ' . $body_class . ' .title-bar.outside{
                            background-image:url(' . esc_url( $bg_image ) . ');
                            '.$bg_fit.'
                        }
                        ' . $body_class . ' .title-bar.outside .overlay-color{
                            background-color:' . $bg_color . ';
                            padding-top:' . $space . ';
                            padding-bottom:' . $space . ';
                        }
                        ' . $body_class . ' .title-bar.outside .page-title,
                        ' . $body_class . ' .title-bar.outside h2{
                            color:' . $title_color . ';
                        }
                        ' . $body_class . ' .title-bar.outside .post-meta,
			            ' . $body_class . ' .title-bar.outside .post-meta a,
			            ' . $body_class . ' .title-bar.outside .post-meta a:hover{
			                color:' . $second_color . ';
			            }
                    ';
                }
            }
            //change only post thumbnail
	        elseif(($title_bar_option === 'global' || $title_bar_option === '') && has_post_thumbnail()){
				//where title bar should be displayed
		        if( $page_type['page'] ){
		            $post_type = 'page';
	            }
	            elseif( $page_type['post'] ){
		            $post_type = 'post';
	            }

	            $position = $emeon_a13->get_option( $post_type . '_title_bar_position' );

		        if ( $position !== 'inside' ){
			        $bg_image     = wp_strip_all_tags( emeon_get_top_image_video(false, array('return_src' =>  true, 'force_image' => true, 'full_size' => true)) );

			        $css .= '
                        ' . $body_class . ' .title-bar.outside{
                            background-image:url(' . esc_url( $bg_image ) . ');
                        }
                    ';
		        }
	        }

            //if we have some CSS then add it
            if(strlen($css)){
	            wp_add_inline_style( 'emeon-a13-user-css', emeon_minify_css($css) );
            }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'emeon_page_individual_look', 27 );



if(!function_exists('emeon_social_icons')){
	/**
	 * HTML for social icons
	 *
	 * @param string $normal         - color of icons for normal state
	 * @param string $hover          - color of icons for hover state
	 * @param string $socials_array  - array of social icons
	 * @param bool   $hide_on_mobile - should icons be hidden on small devices
	 *
	 * @return string HTML
	 *
	 */
	function emeon_social_icons($normal, $hover, $socials_array = '', $hide_on_mobile = false ){
        global $emeon_a13;

		//did we send social icons set
		if( is_array($socials_array) ){
			$socials = $socials_array;
		}
		//we use socials from theme settings
		else{
			$socials = $emeon_a13->get_option( 'social_services' );
		}

		$classes = 'socials '.$emeon_a13->get_option( 'socials_variant' );
		$classes .= ' '.$normal;
		$classes .= ' '.$hover.'_hover';
		$classes .= $hide_on_mobile ? ' hide_on_mobile': '';
		$icons_classes = $emeon_a13->emeon_get_social_icons_list('classes');
		$icons_names = $emeon_a13->emeon_get_social_icons_list();

		$soc_html = '';
        $has_active = false;
        $protocols = wp_allowed_protocols();
        $protocols[] = 'skype';

        foreach( $socials as $service_id => $service_link ){
            if( ! empty($service_link) && $service_id !== '__last_edit' ){
	            $icon_class = 'a13_soc-'.$service_id.' '.$icons_classes[$service_id];
                $soc_html .= '<a target="_blank" title="'.esc_attr($icons_names[$service_id]).'" href="' . esc_url($service_link, $protocols) . '" class="'.esc_attr($icon_class).'" rel="noopener"></a>';
                $has_active = true;
            }
        }

        if($has_active){
            $soc_html = '<div class="'.esc_attr($classes).'">'.$soc_html.'</div>';
        }

        return $soc_html;
    }
}



if(!function_exists('emeon_page_like_content')){
	/**
	 * prints HTML for some special templates, that use static pages for layout
	 *
	 * @param WP_Query $query
	 */
	function emeon_page_like_content($query){
		// almost copy of page.php
		$query->the_post(); //before header to get proper classes of custom template!

		get_header();

		emeon_title_bar();
		?>

		<article id="content" class="clearfix">
			<div class="content-limiter">
			    <div id="col-mask">

			        <div id="post-<?php the_ID(); ?>" <?php post_class('content-box'); ?>>
				        <div class="formatter">
					        <?php emeon_title_bar( 'inside' ); ?>
				            <div class="real-content">
				                <?php the_content(); ?>
					            <div class="clear"></div>

				                <?php
				                wp_link_pages( array(
				                        'before' => '<div id="page-links">'.esc_html__( 'Pages: ', 'emeon' ),
				                        'after'  => '</div>')
				                );
				                ?>
				            </div>
			            </div>
			        </div>
			        <?php get_sidebar(); ?>
			    </div>
			</div>
		</article>

		<?php get_footer();
	}
}



if(!function_exists('emeon_result_count')){
	/**
	 * returns number of post displayed on page from total number of posts
	 * @param bool|WP_Query $query
	 */
	function emeon_result_count( $query = false ){
		if($query === false){
			global $wp_query;
			$query = $wp_query;
		}
		?>
		<span class="result-count">
	<?php
	$paged    = max( 1, $query->get( 'paged' ) );
	$total    = $query->found_posts;
	$last     = min( $total, $query->get( 'posts_per_page' ) * $paged );

	if ( 1 == $total ) {
		echo '1/1';
	} else {
		printf( '%1$d/%2$d', esc_html($last), esc_html($total) );
	}
	?>
</span>
		<?php
	}
}


//only if plugin "SearchWP Live Ajax Search" is activated
if(class_exists('SearchWP_Live_Search')){

	if(!function_exists('emeon_searchwp_live_search_posts_per_page')) {
		/**
		 *  Control how many results are returned
		 */
		function emeon_searchwp_live_search_posts_per_page() {
			return 6;
		}
	}
	add_filter( 'searchwp_live_search_posts_per_page', 'emeon_searchwp_live_search_posts_per_page' );



	if(!function_exists('emeon_searchwp_live_search_configs')) {
		/**
		 *  change default configuration of Live Search plugin
		 *
		 * @param $configs - config which will edit
		 *
		 * @return
		 */
		function emeon_searchwp_live_search_configs( $configs ) {
			// override some defaults
			$configs['default'] = array(
				'engine'                  => 'default',
				// search engine to use (if SearchWP is available)
				'input'                   => array(
					'delay'     => 500,                 // wait 500ms before triggering a search
					'min_chars' => 3,                   // wait for at least 3 characters before triggering a search
				),
				'results'                 => array(
					'position' => 'bottom',            // where to position the results (bottom|top)
					'width'    => 'css',              // whether the width should automatically match the input (auto|css)
					'offset'   => array(
						'x' => 0,                   // x offset (in pixels)
						'y' => 0                    // y offset (in pixels)
					),
				),
				'spinner'                 => array(                         // powered by http://fgnass.github.io/spin.js/
					'lines'     => 10,              // number of lines in the spinner
					'length'    => 8,               // length of each line
					'width'     => 4,               // line thickness
					'radius'    => 8,               // radius of inner circle
					'corners'   => 1,               // corner roundness (0..1)
					'rotate'    => 0,               // rotation offset
					'direction' => 1,               // 1: clockwise, -1: counterclockwise
					'color'     => '#000',          // #rgb or #rrggbb or array of colors
					'speed'     => 1,               // rounds per second
					'trail'     => 60,              // afterglow percentage
					'shadow'    => false,           // whether to render a shadow
					'hwaccel'   => false,           // whether to use hardware acceleration
					'className' => 'spinner',       // CSS class assigned to spinner
					'zIndex'    => 2000000000,      // z-index of spinner
					'top'       => '50%',           // top position (relative to parent)
					'left'      => '50%',           // left position (relative to parent)
				),
				'results_destroy_on_blur' => false,
				'parent_el'               => '#search-results-header'
			);

			return $configs;
		}
	}
	add_filter( 'searchwp_live_search_configs', 'emeon_searchwp_live_search_configs' );

	if(!function_exists('emeon_remove_searchwp_live_search_theme_css')) {
		/**
		 *  remove the default visual styling of Live Search plugin
		 */
		function emeon_remove_searchwp_live_search_theme_css() {
			wp_dequeue_style( 'searchwp-live-search' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'emeon_remove_searchwp_live_search_theme_css', 20 );


	//disable default results pane positioning CSS
	add_filter( 'searchwp_live_search_base_styles', '__return_false' );
	//prevent SearchWP from automatically enabling live search on forms generated with get_search_form(),
	add_filter( 'searchwp_live_search_hijack_get_search_form', '__return_false' );
}




if(!function_exists('emeon_make_post_grid_filter')) {
	function emeon_make_post_grid_filter( $terms, $filter_class = '', $selected_term = '__all', $show_all = true ) {
		if( count( $terms ) ){
			echo '<ul class="category-filter clearfix ' . esc_attr( $filter_class ) . '">';

			if( $selected_term === '__all' || $show_all ){
				echo '<li '.( $selected_term === '__all' ? ' class="selected"' : '' ).' data-filter="__all"><a href="' . esc_url( emeon_current_url() ) . '">' . esc_html__( 'All', 'emeon' ) . '</a></li>';
			}
			foreach( $terms as $term ) {
				echo '<li data-filter="' . esc_attr( $term->term_id ) . '"'.( $selected_term == $term->term_id ? ' class="selected"' : '' ).'><a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></li>';
			}

			echo '</ul>';
		}
	}
}