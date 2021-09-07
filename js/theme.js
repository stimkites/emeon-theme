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
			loop: true,
			slidesPerView: 1,
			autoHeight: true,
			// autoplay: {
			// 	disableOnInteraction: false
			// },
			pagination: {
				el: '.swiper-pagination--about',
				clickable: true
			},
		});

		const vacancies_swiper = new Swiper('.vacancies--swiper', {
			loop: true,
			slidesPerView: 4,
			spaceBetween: 20,
			autoHeight: true,
			// autoplay: {
			// 	disableOnInteraction: false
			// },
			pagination: {
				el: '.swiper-pagination--vacancies',
				clickable: true
			},
			navigation: {
				nextEl: '.swiper-button-next--vacancies',
				prevEl: '.swiper-button-prev--vacancies',
			},
		});

		const candidates_swiper = new Swiper('.candidates--swiper', {
			loop: true,
			slidesPerView: 4,
			spaceBetween: 20,
			autoHeight: true,
			// autoplay: {
			// 	disableOnInteraction: false
			// },
			pagination: {
				el: '.swiper-pagination--candidates',
				clickable: true
			},
			navigation: {
				nextEl: '.swiper-button-next--candidates',
				prevEl: '.swiper-button-prev--candidates',
			},
		});

		const stories_swiper = new Swiper('.stories--swiper', {
			loop: true,
			slidesPerView: 1,
			autoHeight: true,
			// autoplay: {
			// 	disableOnInteraction: false
			// },
			pagination: {
				el: '.swiper-pagination--stories',
				clickable: true
			}
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
