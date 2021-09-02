/* Theme's JS that fires on all pages */

window.onload = ( function( $ ) {

	/**
	 * Change logo on scroll
	 *
	 * @private
	 */
	function __display_logo_handler() {
		if ( window.pageYOffset > 50 ) {
			$( '.site-header, .site-content.page' ).addClass( 'scrolled' );
		} else {
			$( '.site-header, .site-content.page' ).removeClass( 'scrolled' );
		}
	}

	/**
	 * Initialize Swiper slider
	 *
	 * @private
	 */
	function __swiper_init() {
		const swiper = new Swiper('.vacancies--swiper', {
			// Optional parameters
			loop: true,
			slidesPerView: 4,
			spaceBetween: 20,
			autoHeight: true,
			// autoplay: {
			// 	disableOnInteraction: false
			// },

			// If we need pagination
			pagination: {
				el: '.swiper-pagination',
				clickable: true
			},

			// Navigation arrows
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},

			// And if we need scrollbar
			scrollbar: {
				el: '.swiper-scrollbar',
			},
		});
	}


	/**
	 * Assign events handlers
	 *
	 * @private
	 */
	function __assign() {
		$( window ).on( 'scroll', __display_logo_handler );
	}


	/**
	 * Initialize
	 *
	 * @private
	 */
	function __init() {
		console.info( '[theme] Theme JS initiated!' );
		__display_logo_handler();
		__swiper_init();
		__assign();
	}


	return {
		/**
		 * Call to init ourselves only when we are on our archive page
		 */
		init: function() {
			return __init;
		}
	}
} )( jQuery.noConflict() ).init();
