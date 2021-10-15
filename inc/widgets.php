<?php

add_action( 'widgets_init', 'emeon_woocommerce_widgets_init' );

function emeon_woocommerce_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'WooCommerce product filters', 'emeon' ),
		'id'            => 'woo-filters',
		'description'   => __( 'Widgets in this area will be shown in shop archive.', 'emeon' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}
