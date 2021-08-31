jQuery(document).ready(function($){
	$("li.gallery-image").click(function(){
		$("li.gallery-image").toggleClass("zoom-image");
	});
});
jQuery(document).ready(function($){
	jQuery('.menu-item.cart').click(function () {
    	jQuery('.woocommerce.widget_shopping_cart').toggleClass('open');
// 		jQuery('button.menu-toggle').toggleClass('close');
    });
});

// Toogle WC filters
jQuery(document).ready(function($){
	jQuery('.wc-filters').click(function () {
		jQuery('.wc-filters').toggleClass('active');
    	jQuery('.woocommerce-widgets').toggleClass('active');
// 		jQuery('button.menu-toggle').toggleClass('close');
    });
});

// Remove Parenthasis () from WooCommerce filter count
jQuery( function($) {
$('.woocommerce-widget-layered-nav-list .count').each( function() {
	$(this).html( /(\d+)/g.exec( $(this).html() )[0] );
	} );
} );

// Toogle nav menu
jQuery(document).ready(function($){
	jQuery('button.toggle-mobile-menu').click(function () {
		jQuery('button.toggle-mobile-menu').toggleClass('open');
		jQuery('.menu-header-menu-container').toggleClass('open');
    });
});

// Toogle search
jQuery(document).ready(function($){
	jQuery('.toggle-search').click(function () {
		jQuery('.main-search').toggleClass('open');
    });
});

jQuery(document).ready(function($){
	jQuery( window ).on( 'scroll', function () {
		console.log(window.pageYOffset);
		if ( window.pageYOffset > 0 ) {
			jQuery('.site-branding, .inline-branding .slogan').hide();
			jQuery('.inline-branding .logo-wrap').show();
		} else {
			jQuery('.site-branding, .inline-branding .slogan').show();
			jQuery('.inline-branding .logo-wrap').hide();
		}
	});
});
