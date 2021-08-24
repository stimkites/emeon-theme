<?php
/**
 * Generates user css rule based on settings in admin panel
 *
 * @param                   $property
 * @param                   $value
 * @param string|bool|false $format  is some special format used for value
 * @param string            $special @since Version 1.10, used to inform if background image should be empty or none when no value is provided
 *
 * @return string CSS rule
 */
function emeon_make_css_rule($property, $value, $format = false, $special = ''){
	if ( $value !== '' &&  $value !== 'default' ){
		//format for some properties
		if( $format !== false ){
			return $property . ': ' . sprintf($format, $value) . ';';
		}

		return $property . ': ' . $value . ";";
	}
	else{
		if( $value === '' && $property === 'background-image'  && $special === '' ){
			return $property.': none;';
		}
		return '';
	}
}



/**
 * Converts hex color to rgba
 *
 * @param string    $hex
 * @param int       $opacity
 *
 * @return string
 */
function emeon_hex2rgba( $hex, $opacity = 1 ) {
	list( $r, $g, $b ) = sscanf( $hex, "#%02x%02x%02x" );

	return 'rgba('.$r.','.$g.','.$b.','.$opacity.')';
}


function emeon_is_woocommerce_activated() {
    return class_exists( 'woocommerce' );
}



/**
 * Checking if we are on demo or dev server
 *
 * @return bool
 */
function emeon_is_home_server(){
	return apply_filters('emeon_is_home_server', false);
}



/**
 * Helper function for renaming templates
 *
 * @param $name string name of template to check
 *
 * @return string
 */
function emeon_proper_page_template_name($name){
	$missing_templates = array(
		'archives_template.php',
	);

	//rename old template file name to new if it is missing template
	return in_array( $name, $missing_templates ) ? str_replace('_', '-', $name) : $name;
}

/**
 * Helper function for enabling user-css manipulation
 */
function emeon_enable_user_css_functions(){
	/** @noinspection PhpIncludeInspection */
	get_template_part('advance/user', 'css'); 
}

/**
 * Get user sidebars for usage in meta options
 */
function emeon_meta_get_user_sidebars(){
	global $emeon_a13;

	$user_sidebars = $emeon_a13->get_option( 'custom_sidebars' );
	$user_sidebars = is_array($user_sidebars)? $user_sidebars : array($user_sidebars);
	$sidebars_count  = count( $user_sidebars );

	$sidebars_array = array();
	if ( is_array( $user_sidebars ) && $sidebars_count > 0 ) {
		foreach ( $user_sidebars as $sidebar ) {
			$sidebars_array[ $sidebar['id'] ] = $sidebar['name'];
		}
	}

	return $sidebars_array;
}



/**
 * Translates shortcuts to inline CSS for positioning background
 *
 * @param string $option short name
 *
 * @return string   inline CSS
 */
function emeon_bg_fit_helper($option){
	if($option === ''){
		return '';
	}
    static $options = array(
        'center'     => 'background-size: auto; background-repeat: no-repeat; background-position: 50% 50%;',
        'cover'      => 'background-size: cover; background-repeat: no-repeat; background-position: 50% 50%;',
        'contain'    => 'background-size: contain; background-repeat: no-repeat; background-position: 50% 50%;',
        'fitV'       => 'background-size: 100% auto; background-repeat: no-repeat; background-position: 50% 50%;',
        'fitH'       => 'background-size:  auto 100%; background-repeat: no-repeat; background-position: 50% 50%;',
        'repeat'     => 'background-repeat: repeat; background-size:auto; background-position: 0 0;',
        'repeat-x'   => 'background-repeat: repeat-x; background-size:auto; background-position: 0 0;',
        'repeat-y'   => 'background-repeat: repeat-y; background-size:auto; background-position: 0 0;',
    );

    return $options[$option];
}



/**
 * Credits to https://gist.github.com/webgefrickel/3339063
 *
 * @param string $css css to minify
 *
 * @return string minified CSS
 *
 */
function emeon_minify_css($css){
	// some of the following functions to minimize the css-output are directly taken
	// from the awesome CSS JS Booster: https://github.com/Schepp/CSS-JS-Booster
	// all credits to Christian Schaefer: http://twitter.com/derSchepp
	// remove comments
	$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
	// backup values within single or double quotes
	preg_match_all('/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER);
	for ($i=0; $i < count($hit[1]); $i++) {
		$css = str_replace($hit[1][$i], '##########' . $i . '##########', $css);
	}
	// remove traling semicolon of selector's last property
	$css = preg_replace('/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css);
	// remove any whitespace between semicolon and property-name
	$css = preg_replace('/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css);
	// remove any whitespace surrounding property-colon
	$css = preg_replace('/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css);
	// remove any whitespace surrounding selector-comma
	$css = preg_replace('/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css);
	// remove any whitespace surrounding opening parenthesis
	$css = preg_replace('/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css);
	// remove any whitespace between numbers and units
	$css = preg_replace('/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css);
	// shorten zero-values(but no 0% as it is used in CSS animations)
	$css = preg_replace('/([^\d\.]0)(px|em|pt)/ims', '$1', $css);
	// constrain multiple whitespaces
	$css = preg_replace('/\p{Zs}+/ims',' ', $css);
	// remove newlines
	$css = str_replace(array("\r\n", "\r", "\n"), '', $css);
	// Restore backupped values within single or double quotes
	for ($i=0; $i < count($hit[1]); $i++) {
		$css = str_replace('##########' . $i . '##########', $hit[1][$i], $css);
	}
	return $css;
}



/**
 * @param string $file path to file to read
 *
 * @return string|false contents of file or false if it not exists
 *
 */
function emeon_read_contents($file){
	return file_exists( $file ) ? implode( file( $file ) ) : false;
}