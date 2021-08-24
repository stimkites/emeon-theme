<?php
if(!function_exists( 'emeon_cpt_meta_fields' )){
	/**
	 * Return internet address and custom fields of post
	 *
	 * @return string
	 */
    function emeon_cpt_meta_fields(){
        $fields = '';
	    $custom_fields_number = apply_filters('emeon_custom_fields_number', 5);

        for($i = 0; $i <= $custom_fields_number; $i++){
	        if( $i === 0 ) {
		        //website link
		        $temp = get_post_meta( get_the_ID(), '_www', true );
		        if ( strlen( $temp ) ) {
			        $temp = esc_html__( 'Website', 'emeon' ).':'.$temp;
		        }
	        }
	        else{
		        //custom fields
                $temp = get_post_meta(get_the_ID(), '_custom_'.$i, true);
	        }

            if(strlen($temp)){
                $pieces = explode(':', $temp, 2);
                if(sizeof($pieces) == 1){
                    $fields .= '<span>'.make_clickable($temp).'</span>';
                }
                else{
                    $fields .= '<span><em>'.$pieces[0].'</em>'.make_clickable($pieces[1]).'</span>';
                }
            }
        }


	    $html = '';
	    //if we have any custom fields filled
		if(strlen($fields)){
			$html =
				'<div class="meta-data">'
			       .'<div class="custom-fields">'.$fields.'</div>'
			       .apply_filters('emeon_after_cpt_meta_fields','').
		        '</div>';
		}

	    return $html;
    }
}


if(!function_exists( 'emeon_cpt_meta_data' )){
	/**
	 * Prints internet address and custom fields of post
	 *
	 * @param string $content current text content from editor
	 *
	 * @return string
	 */
    function emeon_cpt_meta_data( $content ){
	    return $content . emeon_cpt_meta_fields();
    }
}


if(!function_exists( 'emeon_cpt_social' )){
	/**
	 * Returns social components for item list
	 *
	 * @param $link - permalink of item
	 * @param $title - title of item
	 *
	 * @return string
	 *
	 */
    function emeon_cpt_social( $link, $title ){
	    //no socials for protected items
	    if ( post_password_required() ) {
		    return '';
	    }

	    ob_start();
	    echo '<div class="social">'; //by PHP so we could use :empty in CSS
	    //share icons from AddToAny
	    if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) {
		    ADDTOANY_SHARE_SAVE_KIT( array( 'linkname' => $title, 'linkurl' => $link ) );
	    }

	    //like plugin
	    if( function_exists('dot_irecommendthis') ){
		    dot_irecommendthis();
	    };
	    echo '</div>';

		//get output
	    $output = ob_get_contents();
	    ob_end_clean();

	    return $output;
    }
}


/**
 * @param array $item           all raw item settings
 * @param array $collector      item settings useful to generate HTML
 * @param int $columns
 * @param int $bricks_max_width
 * @param int $brick_margin
 * @param int $brick_proportion
 *
 * @return array of all image sizes (poster, brick, thumb)
 */
function emeon_get_gallery_item_images($item, $collector, $columns, $bricks_max_width, $brick_margin, $brick_proportion = 0){
	global $emeon_a13;

	$src = '';
	$type           = $item['type'];
	$is_external    = $collector['attachment_type'] === 'external';

	//prepare vars
	if( $is_external ){
		//video link
		$attachment_id  = $item['videolink_attachment_id'];
		$image          = $item['videolink_poster'];
	}
	//internal
	else{
		if( $type === 'image' ){
			$attachment_id  = $item['id'];
			$image          = $item['url'];
		}
		//video
		else{
			$attachment_id  = get_post_thumbnail_id( $item['id'] );
			$image          = '';
		}
	}


	/* POSTER */
	//try getting attachment
	if( $attachment_id ){
		$attachment = wp_get_attachment_image_src( $attachment_id, 'full' );

		//only if we have attachment
		if( is_array($attachment) ){
			$src = $attachment[0];
		}
	}
	//attachment failed
	if(!strlen($src)){
		if(strlen($image)){
			$poster = $image;
		}
		//$image failed
		else{
			if( $is_external ){
				if( $collector[ 'video_type' ] === 'youtube' ){
					$poster = '//img.youtube.com/vi/'.$collector[ 'video_id' ].'/maxresdefault.jpg';
				}
				//vimeo
				elseif( $collector[ 'video_type' ] === 'vimeo' ){
					$poster = get_theme_file_uri( 'images/holders/vimeo.png' );
				}
				//something else?
				else{
					$poster = get_theme_file_uri( 'images/holders/video.png');
				}
			}
			else{
				if( $type === 'image'){
					$poster = get_theme_file_uri( 'images/holders/photo.png');
				}
				//video
				else{
					$poster = get_theme_file_uri( 'images/holders/video.png');
				}
			}

		}
	}
	//use attachment
	else{
		$poster = $src;
	}


	/* THUMB */
	//try getting attachment
	if( $attachment_id ){
		$attachment = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );

		//only if we have attachment
		if( is_array($attachment) ){
			$src = $attachment[0];
		}
	}
	//attachment failed
	if(!strlen($src)){
		if(strlen($image)){
			$thumb = $image;
		}
		//$image failed
		else{
			if( $is_external ){
				if( $collector[ 'video_type' ] === 'youtube' ){
					$thumb = '//img.youtube.com/vi/'.$collector[ 'video_id' ].'/default.jpg';
				}
				//vimeo
				elseif( $collector[ 'video_type' ] === 'vimeo' ){
					$thumb = get_theme_file_uri( 'images/holders/vimeo_150x100.png');
				}
				//something else?
				else{
					$thumb = get_theme_file_uri( 'images/holders/video_150x100.png');
				}
			}
			else{
				if( $type === 'image'){
					$thumb = get_theme_file_uri( 'images/holders/photo_150x100.png');
				}
				//video
				else{
					$thumb = get_theme_file_uri( 'images/holders/video_150x100.png');
				}
			}
		}
	}
	//use attachment
	else{
		$thumb = $src;
	}

	//reset $src
	$src = '';


	/* BRICK */
	/* brick_size can't be bigger then columns for calculations */
	$brick_size         = $collector['ratio_x'];
	$brick_size         = strlen($brick_size)? min((int)$brick_size, $columns) : 1;
	$ratio              = $brick_size/$columns;

	//many possible sizes, but one RULE to rule them all
	$image_width = ceil($ratio * (int)$bricks_max_width - (1-$ratio) * (int)$brick_margin);

	$height_proportion = 0;

	//prepare proportion from string
	if($brick_proportion !== 0){
		//break string to parts
		$brick_proportion = explode('/', $brick_proportion);
		//check if we have two parts exactly
		if(sizeof($brick_proportion) === 2 && is_numeric($brick_proportion[0]) && is_numeric($brick_proportion[1]) ){
			//make sure second part is not 0
			if((int)$brick_proportion[1]===0){
				$brick_proportion = 0;
			}
			else{
				//calculate proper float
				$brick_proportion = ($brick_proportion[0]/$brick_proportion[1]);
			}
		}
		else{
			$brick_proportion = 0;
		}

		//prepare height proportion
		$height_proportion = $brick_proportion === 0 ? 0 : 1/$brick_proportion;
	}

	$image_height = $image_width*$height_proportion;
	$quality = (int)$emeon_a13->get_option( 'a13ir_image_quality' );
	$quality = ($quality > 0 && $quality <= 100) ? $quality : 90;
	$size = array( $image_width, $image_height, 'sktwb_image' => true, 'crop' => $image_height > 0, 'quality' => $quality );

	//try getting attachment
	if( $attachment_id ){
		$attachment = wp_get_attachment_image_src( $attachment_id, $size );

		//only if we have attachment
		if( is_array($attachment) ){
			$src = $attachment[0];
		}
	}
	//attachment failed
	if(!strlen($src)){
		if(strlen($image)){
			$brick = $image;
		}
		//$image failed
		else{
			if( $is_external ){
				if( $collector[ 'video_type' ] === 'youtube' ){
					$brick = '//img.youtube.com/vi/'.$collector[ 'video_id' ].'/hqdefault.jpg';
				}
				//vimeo
				elseif( $collector[ 'video_type' ] === 'vimeo' ){
					$brick = get_theme_file_uri( 'images/holders/vimeo_640x360.png');
				}
				//something else?
				else{
					$brick = get_theme_file_uri( 'images/holders/video_640x360.png');
				}
			}
			else{
				if( $type === 'image'){
					$brick = get_theme_file_uri( 'images/holders/photo.png');
				}
				//video
				else{
					$brick = get_theme_file_uri( 'images/holders/video_640x360.png');
				}
			}
		}
	}
	//use attachment
	else{
		$brick = $src;
	}

	return array($poster, $brick, $thumb);
}


if(!function_exists('emeon_cpt_list_navigation')){
	/**
	 * Displays page navigation for custom post types
	 *
	 * @param bool|WP_Query $query
	 */
	function emeon_cpt_list_navigation( $query = false ){
		if($query === false){
			global $wp_query;
			$query = $wp_query;
		}

		// Set up paginated links.
		$links = paginate_links( apply_filters( 'emeon_pagination_args', array(
			'add_args'     => '',
			//try to get "paged" for subpages, and page for front page
			'current'      => get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : ( get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1 ),
			'total'        => $query->max_num_pages,
			'prev_text'    => '&larr;',
			'next_text'    => '&rarr;',
			'type'         => 'list',
			'end_size'     => 3,
			'mid_size'     => 3
		) ) );

		if ( $links ) {
			echo wp_kses_post( _navigation_markup( $links, 'posts-navigation' ) );
		}
	}
}



if(!function_exists('emeon_loop_pagination')){
	/**
	 * change pagination to default WordPress style
	 *
	 * @param array $args arguments for pagination
	 *
	 * @return array
	 */
	function emeon_loop_pagination($args){
		$args['type'] = 'plain';
		$args['prev_text'] = _x( 'Previous', 'previous product', 'emeon' );
		$args['next_text'] = _x( 'Next', 'next product', 'emeon' );

		return $args;
	}
}
add_filter('emeon_pagination_args', 'emeon_loop_pagination' );


if(!function_exists('emeon_make_media_collection')){
	/**
	 * Collection of gallery items. Used to print all media used in album or work
	 * JS can feed on it to create custom layouts
	 *
	 * @param null|int $id post ID
	 * @param array    $args gallery arguments
	 */
    function emeon_make_media_collection($id = null, $args = array()){
	    if(is_null($id)){
	        $id = get_the_ID();
	    }
	    $value = get_post_meta( $id, '_images_n_videos' , true);
	    $order = get_post_meta( $id, '_order', true);
	    ?>
	    <ul class="gallery-media-collection screen-reader-text">
			<?php echo wp_kses_post(emeon_prepare_frontend_gallery_html( emeon_prepare_gallery_attachments( $value, $id ), $order, $id, $args )); ?>
		</ul>
	    <?php
    }
}


/**
 * Prepares attachments so they can be used in admin and front end to show all media from gallery
 *
 * @param string $value json encoded string with list of all attachments
 * @param null|int $post_id post ID
 *
 * @return array
 */
function emeon_prepare_gallery_attachments( $value, $post_id = null ){
	global $emeon_a13;

	if(is_null($post_id)){
		$post_id = get_the_ID();
	}

	$attachments = array();
	if ( ! empty( $value ) ) {
		$images_videos_array = json_decode( $value, true );
		$media_count         = count( $images_videos_array );

		$proofing_enabled = $emeon_a13->emeon_get_meta( '_proofing', $post_id ) === 'on';

		if($proofing_enabled){
			$proofing_meta  = get_post_meta( $post_id, '_images_n_videos_proofing', true );
			$proofing_array = strlen( $proofing_meta ) === 0 ? array() : json_decode( $proofing_meta, true );
		}

		if ( $media_count ) {
			//collect all ids
			//and filter out external media(video links, audio links)
			$ids       = array();
			$externals = array();
			for ( $i = 0; $i < $media_count; $i ++ ) {
				$item_id = $images_videos_array[ $i ]['id'];
				if ( $item_id === 'external' ) {
					$externals[] = $images_videos_array[ $i ];
				}

				//in case of WPML make sure to get localized version
				$ids[] = apply_filters( 'wpml_object_id', $images_videos_array[ $i ]['id'], 'post', true );

			}

			//process items from media library
			$args = array(
				'post_type'      => 'attachment',
				'posts_per_page' => PHP_INT_MAX,
				'post_status'    => 'any',
				'post_parent'    => null,
				'post__in'       => $ids,
				'orderby'        => 'post__in'
			);
			$attachments = get_posts( $args );
			$attachments = array_map( 'wp_prepare_attachment_for_js', $attachments );
			//remove any empty, false elements
			$attachments = array_filter( $attachments );
			wp_reset_postdata();

			//process items from external links
			emeon_prepare_external_media( $externals );

			//combine internal and external media back again
			//also check for deleted items
			for ( $i = 0; $i < $media_count; $i ++ ) {
				//in case of WPML make sure to get localized version
				$item_id = apply_filters( 'wpml_object_id', $images_videos_array[ $i ]['id'], 'post', true );

				if ( $item_id === 'external' ) {
					//first we push around to make space for us
					array_splice( $attachments, $i, 0, 'whatever' );
					//and now we push our thing
					$attachments[ $i ] = array_shift( $externals );
				} elseif ( ! isset( $attachments[ $i ] ) || ( (int) $item_id !== (int) $attachments[ $i ]['id'] ) ) {
					//there is something wrong, probably media was deleted
					array_splice( $attachments, $i, 0, 'deleted' );
				} else{
					//we push additional info to real attachments
					//These are options from theme
					$type = $images_videos_array[ $i ][ 'type' ];
					if( $type === 'image' ){
						$attachments[ $i ][ 'bg_color' ] = $images_videos_array[ $i ][ 'image_bg_color' ];
						$attachments[ $i ][ 'ratio_x' ] = $images_videos_array[ $i ][ 'image_ratio_x' ];
						$attachments[ $i ][ 'alt_link' ] = $images_videos_array[ $i ][ 'image_link' ];
						$attachments[ $i ][ 'alt_link_target' ] = isset($images_videos_array[ $i ][ 'image_link_target' ])? $images_videos_array[ $i ][ 'image_link_target' ] : '';
						$attachments[ $i ][ 'product_id' ] = isset($images_videos_array[ $i ][ 'image_product_id' ])? $images_videos_array[ $i ][ 'image_product_id' ] : '';
						$attachments[ $i ][ 'filter_tags' ] = isset($images_videos_array[ $i ][ 'image_tags' ])? $images_videos_array[ $i ][ 'image_tags' ] : '';
					} elseif( $type === 'video' ){
						$attachments[ $i ][ 'autoplay' ] = $images_videos_array[ $i ][ 'video_autoplay' ];
						$attachments[ $i ][ 'ratio_x' ] = $images_videos_array[ $i ][ 'video_ratio_x' ];
						$attachments[ $i ][ 'filter_tags' ] = isset($images_videos_array[ $i ][ 'video_tags' ])? $images_videos_array[ $i ][ 'video_tags' ] : '';
					}

					if($proofing_enabled) {
						//settings from admin settings
						$attachments[ $i ]['proofing_id']      = isset( $images_videos_array[ $i ][$type.'_proofing_id'] ) ? $images_videos_array[ $i ][$type.'_proofing_id'] : '';
						//settings provided by user
						$proofing_record                       = isset( $proofing_array[ $images_videos_array[ $i ]['id'] ] ) ? $proofing_array[ $images_videos_array[ $i ]['id'] ] : null;
						$attachments[ $i ]['proofing_checked'] = ( isset( $proofing_record ) && array_key_exists( 'approved', $proofing_record ) ) ? $proofing_record['approved'] : 0;
						$attachments[ $i ]['proofing_comment'] = ( isset( $proofing_record ) && array_key_exists( 'comment', $proofing_record ) ) ? $proofing_record['comment'] : '';
					}
				}
			}
		}
	}

	return $attachments;
}



/**
 * Prepares external attachments
 *
 * @param array $items external items list
 */
function emeon_prepare_external_media(&$items){
	global $emeon_a13;

	$proofing_enabled = $emeon_a13->emeon_get_meta( '_proofing' ) === 'on';
	$proofing_array = array();

	if($proofing_enabled){
		$proofing_meta  = get_post_meta( get_the_ID(), '_images_n_videos_proofing', true );
		$proofing_array = strlen( $proofing_meta ) === 0 ? array() : json_decode( $proofing_meta, true );
	}


	/** @noinspection PhpUnusedLocalVariableInspection */
	$audio_icon = wp_mime_type_icon('audio');
	/** @noinspection PhpUnusedLocalVariableInspection */
	$video_icon = wp_mime_type_icon('video');

	foreach($items as &$item){
		$type   = $item['type'];
		$mime   = substr($type, 0, -4); //-'link', result in "video" or "audio"
		$title  = $item[$type.'_title'];
		$link   = $item[$type.'_link'];
		$id     = $item[$type.'_attachment_id'];

		//prepare args that will be used to generate gallery HTML
		$item['filename']   = (empty($title)? $link : $title); //title is more favorable
		//CAUTION! overwrite of type here!
		$item['type']       = $mime; //type and subtype are switched kind of in compare to default WP Media library
		$item['subtype']    = $type;
		$item['icon']       = ${$mime.'_icon'};

		//thumb of item
		if(!empty($id)){
			list( $src, $width, $height ) = wp_get_attachment_image_src( $id, 'thumbnail' );
			$item['thumb'] = compact( 'src', 'width', 'height' );
		}
		else{
			$width = 48;
			$height = 64;
			$src = $item['icon'];
			$item['thumb'] = compact( 'src', 'width', 'height' );
		}

		if($proofing_enabled) {
			//settings provided by user
			$proofing_record          = isset( $proofing_array[ $link ] ) ? $proofing_array[ $link ] : null;
			$item['proofing_checked'] = ( isset( $proofing_record ) && array_key_exists( 'approved', $proofing_record ) ) ? $proofing_record['approved'] : 0;
			$item['proofing_comment'] = ( isset( $proofing_record ) && array_key_exists( 'comment', $proofing_record ) ) ? $proofing_record['comment'] : '';
		}
	}
	unset($item);
}



/**
 * Prepares front-end gallery ready to display
 *
 * @param array  $attachments all items with settings
 * @param string $order       order of items
 * @param int    $id          post ID
 *
 * @param array  $args        gallery arguments
 *
 * @return string HTML of gallery
 */
function emeon_prepare_frontend_gallery_html( $attachments, $order, $id, $args ){
	if( $order === 'DESC' ){
		$attachments = array_reverse( $attachments );
	}
	elseif( $order === 'random' ){
		shuffle( $attachments );
	}

	//for galleries that are not bricks
	$default_args = array(
		'show_desc'  => 'on',
		'proofing'   => 'off',
		'socials'    => 'off',
		'proportion' => '0',
		'margin'     => '5px',
		'max_width'  => '1920px',
		'columns'    => '3',
	);

	$args = wp_parse_args($args, $default_args);

	ob_start();
	if ( $attachments ) {
		$columns            = $args['columns'];
		$bricks_max_width   = $args['max_width'];
		$brick_margin       = $args['margin'];
		$brick_proportion   = $args['proportion'];
		$proofing_enabled   = $args['proofing'] === 'on';

		foreach ( $attachments as $item ) {
			//skip deleted items
			if( !is_array($item) && $item === 'deleted' ){
				continue;
			}
			//audio type currently not fully supported, so we skip
			elseif( is_array($item) && $item['type'] === 'audio' ){
				continue;
			}
			else{
				$type           = $item['type'];
				$is_link        = false;

				$collector['type']  = $item[ 'type' ];
				// external video like YT, Vimeo
				if ( $item['id'] === 'external' ) {
					$collector[ 'attachment_type' ]= 'external';
					$collector[ 'id' ]             = $item['videolink_attachment_id'];
					$collector[ 'src' ]            = $item['videolink_link'];           //link to video that will open normally in browser
					$collector[ 'title' ]          = $item['videolink_title'];          //easy
					$collector[ 'description' ]    = $item['videolink_desc'];           //easy
					$collector[ 'ratio_x' ]        = $item['videolink_ratio_x'];        //for bricks theme
					$collector[ 'autoplay' ]       = $item['videolink_autoplay'];       //easy
					$collector[ 'filter_tags' ]    = isset($item['videolink_tags'])? $item['videolink_tags'] : '';           //easy

					//video details
					$temp =  emeon_detect_movie( $item['videolink_link'] );
					$collector[ 'video_type' ]     = $temp[ 'type' ];                   //vimeo/youtube
					$collector[ 'video_id' ]       = $temp[ 'id' ];                     //id of movie. Number of vimeo and alpha-num string for YouTube
					$collector[ 'video_player' ]   = emeon_get_movie_link( $temp );       //Video API address

					//prepare images
					list(
						$collector[ 'main-image' ],
						$collector[ 'brick_image' ],
						$collector[ 'thumb' ]
						) = emeon_get_gallery_item_images($item, $collector, $columns, $bricks_max_width, $brick_margin, $brick_proportion);
					$collector['alt_attr']   = esc_attr(get_post_meta( $item['id'], '_wp_attachment_image_alt', true));

					if($proofing_enabled) {
						$collector['proofing_id']      = isset( $item['videolink_proofing_id'] ) ? $item['videolink_proofing_id'] : '';
						$collector['proofing_checked'] = $item['proofing_checked'];
						$collector['proofing_comment'] = $item['proofing_comment'];
					}
				}

				//from media library
				else{
					$collector[ 'attachment_type' ]= 'internal';
					$collector[ 'id' ]             = $item['id']; //attachment id
					$collector[ 'src' ]            = $item['url'];
					$collector[ 'title' ]          = $item['title'];
					$collector[ 'description' ]    = $item['description'];
					$collector[ 'ratio_x' ]        = $item['ratio_x'];
					$collector[ 'filter_tags' ]    = $item['filter_tags'];

					if($proofing_enabled) {
						$collector['proofing_id']      = $item['proofing_id'];
						$collector['proofing_checked'] = $item['proofing_checked'];
						$collector['proofing_comment'] = $item['proofing_comment'];
					}

					//get type sensitive values
					if( $type === 'image' ){
						$collector['bg_color']   = $item['bg_color'];
						$collector['product_id'] = $item['product_id'];
						$collector['alt_attr']   = esc_attr(get_post_meta( $item['id'], '_wp_attachment_image_alt', true));


						//prepare images
						list(
							$collector[ 'main-image' ],
							$collector[ 'brick_image' ],
							$collector[ 'thumb' ]
							) = emeon_get_gallery_item_images($item, $collector, $columns, $bricks_max_width, $brick_margin, $brick_proportion);

						//if there is alternative link
						if( strlen( $item['alt_link'] ) ){
							$collector[ 'src' ]     = $item['alt_link'];
							$is_link                = true;
						}
						$collector['link_target']   = $item['alt_link_target'];

					}
					elseif( $type === 'video' ){
						$collector[ 'autoplay' ] = $item['autoplay'];
						$collector[ 'video_type' ]     = 'html5';
						$collector[ 'video_id' ]       = $collector[ 'src' ];
						$collector[ 'video_player' ]   = $collector[ 'src' ];

						//prepare images
						list(
							$collector[ 'main-image' ],
							$collector[ 'brick_image' ],
							$collector[ 'thumb' ]
							) = emeon_get_gallery_item_images($item, $collector, $columns, $bricks_max_width, $brick_margin, $brick_proportion);
						$collector['alt_attr']   = esc_attr(get_post_meta( $item['id'], '_wp_attachment_image_alt', true));

						//poster for lightbox to use
						$collector[ 'poster' ] = $collector['main-image'];
					}
				}

				//classes of item
				$collector[ 'item_class' ] = 'gallery-item'
	              .' type-'.$type
	              .' subtype-'.$item['subtype']
	              .($is_link? ' link' : '')
				;
			}

			//check for animated gifs
			$file_type = wp_check_filetype( $collector[ 'main-image' ] );
			//if it is gif then it is probably animated gif, so lets use original file
			if( $file_type['type'] === 'image/gif'){
				$collector[ 'brick_image' ] = $collector[ 'main-image' ];
			}

			emeon_frontend_gallery_item_html( $collector, $id, $args );

			//be safe
			unset($collector);
		}
	}

	$output = ob_get_contents();
	ob_end_clean();

	return $output;
}


/**
 * Helper to prepare each gallery item to display in front-end
 *
 * @param array $collector item settings useful to generate HTML
 * @param int   $post_id ID of post that items are added to
 * @param array $args gallery arguments
 */
function emeon_frontend_gallery_item_html( $collector, $post_id, $args ){
	global $emeon_a13;
	static $id = 0;
	$id++;
	$proofing_enabled = $args['proofing'] === 'on';
	$not_needed = array( 'src', 'title', 'description', 'attachment_type', 'item_class', 'type', 'video_id', 'filter_tags', 'product_id', 'proofing_comment' );
	//no need for some attributes in case of html
	if( $collector[ 'type' ] === 'image' ){
		$not_needed[] = 'autoplay';
	}

	$data_attr_list = array_diff_key($collector, array_flip($not_needed) );
	//add comment for proofing
	if($proofing_enabled){
		$data_attr_list['proofing_comment'] = strlen($collector[ 'proofing_comment' ])? 1 : 0;
	}

	//construct data attributes
	$data_attr = '';
	foreach( $data_attr_list as $attr => $val ){
		$data_attr .= ' data-'.$attr.'="'.esc_attr($val).'"';
	}

	//prepare filter attribute
	if(strlen($collector[ 'filter_tags' ])){
		$album_filters = emeon_get_media_filters($post_id);
		$item_filters = array();
		$data_filter = '';
		$tags = explode(',', $collector[ 'filter_tags' ]);

		//collect tags for this item
		foreach($tags as $tag){
			if(strlen($tag)){
				$item_filters[] = trim($tag);
			}
		}

		//look for tags in album filters
		foreach($item_filters as $filter){
			if( ( $index = array_search($filter, $album_filters, true) ) !== NULL ){
				$data_filter .= $index.',';
				$data_attr .= ' data-category-'.$index.'="1"';
			}
		}

		//helps recreate filter in bricks
		if(strlen($data_filter)){
			$data_attr .= ' data-filter="'.esc_attr( $data_filter ).'"';
		}
	}

	?>
	<li class="<?php echo esc_attr($collector[ 'item_class' ]); ?>"<?php echo esc_attr($data_attr); ?>>
		<a class="item__link" href="<?php echo esc_url($collector[ 'src' ]); ?>"><?php echo esc_html($collector[ 'title' ]); ?></a>
		<?php

		if( $args['show_desc'] === 'on' ){ ?>
			<div id="item-desc-<?php echo esc_attr($id); ?>" class="item-desc"><?php echo wp_kses_post( $collector[ 'description' ] ); ?></div>
		<?php
		}
		if($proofing_enabled){
			echo '<div class="proofing_comment">'.esc_html( $collector[ 'proofing_comment' ] ).'</div>';
		}

		//print internal video so lightbox can use it
		if( $collector[ 'attachment_type' ] === 'internal' && $collector[ 'type' ] === 'video' ){
			$video_attr = array(
				'src'      => $collector[ 'src' ],
				'loop'     => false,
				//we don't use it now, but good to know how easily do it
				//'autoplay' => (bool)$collector[ 'autoplay' ],
				'poster'   => $collector[ 'main-image' ],
				'width'    => 480,//ratio 16:9
				'height'   => 270
			);
			//emeon_video() produces escaped content
			echo wp_kses_post('<div class="album-video" id="album-video-'.esc_attr( $id ).'">'.emeon_video( $video_attr ).'</div>');
		}

		if ( !$proofing_enabled ) {
			if(function_exists( 'ADDTOANY_SHARE_SAVE_KIT' )){
				//check if social icons are enabled
				$sharing_enabled =  $args['socials'] === 'on';
				if ( $emeon_a13->get_option( 'album_social_icons' ) === 'on' && $sharing_enabled ){

					$back_to_post = $emeon_a13->get_option( 'album_share_type' ) === 'album';
					//share link will link to album and open image in lightbox
					if($back_to_post){
						$album_url = emeon_current_url();
						$link_url = add_query_arg( 'gallery_item', basename( $collector['src'] ), $album_url );
						ADDTOANY_SHARE_SAVE_KIT( array( 'linkname' => $collector['title'], 'linkurl' => $link_url ) );
					}
					//share link will link to attachment page
					else{
						ADDTOANY_SHARE_SAVE_KIT( array( 'linkname' => $collector['title'], 'linkurl' => get_attachment_link($collector['id']) ) );
					}
					//alternative is sharing photo src
//				    ADDTOANY_SHARE_SAVE_KIT( array( 'linkname' => $collector['title'], 'linkurl' => $collector['src'] ) );
				}
			}

			//like plugin
			if( function_exists('dot_irecommendthis') && strlen( $collector['id'] ) > 0 ){
				dot_irecommendthis( $collector['id'] );
			}
		}


		//add to cart button
		if( emeon_is_woocommerce_activated() && isset( $collector['product_id'] ) && $collector[ 'product_id' ]){
			echo wp_kses_post(WC_Shortcodes::product_add_to_cart(array('id'=> $collector[ 'product_id' ], 'style' => '')));
		}
		?>
	</li>
<?php
}

/**
 * Prepares proportion from string
 *
 * @param string $brick_proportion     proportion width/height
 *
 * @return float fraction of width that height has to have
 */
function emeon_calculate_height_proportion($brick_proportion){
	$height_proportion = 0;
	//prepare proportion from string
	if($brick_proportion !== '0' && $brick_proportion !== ''){
		//break string to parts
		$brick_proportion = explode('/', $brick_proportion);
		//check if we have two part exactly
		if(sizeof($brick_proportion) === 2){
			//make sure second part is not 0
			if((int)$brick_proportion[1]===0){
				$brick_proportion = 0;
			}
			else{
				//calculate proper float
				$brick_proportion = ($brick_proportion[0]/$brick_proportion[1]);
			}
		}
		else{
			$brick_proportion = 0;
		}

		//prepare height proportion
		$height_proportion = $brick_proportion === 0 ? 0 : 1/$brick_proportion;
	}

	return $height_proportion;
}

/**
 * Prepares filters for media in single album
 *
 * @param int $id ID of album/work
 *
 * @return array filters that are available for current post
 */
function emeon_get_media_filters($id = null){
	static $indexed_filters = array();
	if(is_null($id)){
		$id = get_the_ID();
	}

	//cache once collected filters
	if( !isset( $indexed_filters[$id] ) ){
		$value = get_post_meta( $id, '_images_n_videos' , true);
		$indexed_filters[$id] = array();
	
		if ( ! empty( $value ) ) {
			$images_videos_array = json_decode( $value, true );
			$media_count         = count( $images_videos_array );
	
			if ( $media_count ) {
				$filters = array();
				for ( $i = 0; $i < $media_count; $i ++ ) {
					$type = $images_videos_array[ $i ]['type'];
					$tags = isset($images_videos_array[ $i ][$type.'_tags']) ? $images_videos_array[ $i ][$type.'_tags'] : '';
					$tags = explode(',', $tags);
	
					//collect tags for this item
					foreach($tags as $tag){
						if(strlen($tag)){
							$filters[] = trim($tag);
						}
					}
				}
	
				//found any filters?
				if(count($filters)){
					//get final list of filters
					$filters = array_unique($filters);
	
					//reindex filters to have slug for each
					foreach($filters as $key => $filter){
						$indexed_filters[$id]['filter_'.$key] = $filter;
					}
				}
			}
		}
	}

	return $indexed_filters[$id];
}

if ( ! function_exists( 'emeon_cpt_as_frontpage_title_fix' ) ) {
	/**
	 * Fixes title using settings for front_page from general-template.php ver 4.4.1
	 *
	 * @param $title array actual title parts
	 *
	 * @return array of title parts
	 */
	function emeon_cpt_as_frontpage_title_fix( $title ) {
		$title['title']   = get_bloginfo( 'name', 'display' );
		$title['tagline'] = get_bloginfo( 'description', 'display' );
		$title['site']    = '';

		return $title;
	}
}



if ( ! function_exists( 'emeon_cpt_as_frontpage_menu_fix' ) ) {
	/**
	 * Fixes highlighting homepage menu link when custom post type is set as homepage
	 *
	 * @param $classes array actual CSS classes for menu item
	 *
	 * @param $item object menu item
	 *
	 * @return array of CSS classes
	 */
	function emeon_cpt_as_frontpage_menu_fix( $classes, $item ) {
		if(get_option( 'show_on_front' ) === 'page'){
			$which_page = get_option( 'page_on_front' );
			//link for homepage
			if($item->object_id == $which_page){
				$classes[] = 'current-menu-item';
			}
		}

		// Return the corrected set of classes to be added to the menu item
		return $classes;
	}
}

