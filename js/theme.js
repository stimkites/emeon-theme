/* Theme's JS that fires on all pages */

window.onload = ( function( $ ) {

	/**
	 * Change logo on scroll
	 *
	 * @private
	 */
	function __page_scroll_handler() {
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
		const about_swiper = new Swiper('.about--swiper', {
			// Optional parameters
			loop: true,
			slidesPerView: 1,
			spaceBetween: 20,
			autoHeight: true,
			// autoplay: {
			// 	disableOnInteraction: false
			// },

			// If we need pagination
			pagination: {
				el: '.swiper-pagination--about',
				clickable: true
			},
		});

		const vacancies_swiper = new Swiper('.vacancies--swiper', {
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
				el: '.swiper-pagination--vacancies',
				clickable: true
			},

			// Navigation arrows
			navigation: {
				nextEl: '.swiper-button-next--vacancies',
				prevEl: '.swiper-button-prev--vacancies',
			},
		});
	}


	/**
	 * Assign events handlers
	 *
	 * @private
	 */
	function __assign() {
		$( window ).on( 'scroll', __page_scroll_handler );
	}


	/**
	 * Initialize
	 *
	 * @private
	 */
	function __init() {
		console.info( '[theme] Theme JS initiated!' );
		__page_scroll_handler();
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
