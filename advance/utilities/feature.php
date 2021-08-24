<?php
/* protects from undefined functions used in framework */
if(!function_exists('emeon_horizontal_header_color_variant')){
	function emeon_horizontal_header_color_variant() {
		return 'normal';
	}
}


/* protects from undefined functions used in framework */
if(!function_exists('emeon_cookie_message')){
	function emeon_cookie_message() {
		return '';
	}
}

if(!function_exists('emeon_cookie_message_css')){
	function emeon_cookie_message_css() {
		return '';
	}
}
