/* Theme's JS that fires on all pages */

window.onload = ( function( $ ) {

	const _body = $( 'body' ),
		_window = $( window ),
		_header_elem = $( '.site-header' ),
		_sandwich_button_elem = $( '.toggle-mobile-menu' );


	/**
	 * Disable page scroll
	 *
	 * @private
	 */
	function __disable_scroll() {
		let padding_offset = window.innerWidth - document.body.offsetWidth + 'px';
		_body.addClass( 'disable-scroll' ).css( 'padding-right', padding_offset );
		_header_elem.css( 'padding-right', padding_offset );
	}


	/**
	 * Enable page scroll
	 *
	 * @private
	 */
	function __enable_scroll() {
		_body.removeClass( 'disable-scroll' ).removeAttr( 'style' );
		_header_elem.removeAttr( 'style' );
	}


	/**
	 * Add css class on scroll
	 *
	 * @private
	 */
	function __page_scroll_handler() {
		const _target_elems = $( '.site-header, .site-content.page' );
		if ( window.pageYOffset > 50 ) {
			_target_elems.addClass( 'scrolled' );
		} else {
			_target_elems.removeClass( 'scrolled' );
		}
	}


	/**
	 * Window resize handler
	 *
	 * @private
	 */
	function __window_resize_handler() {
		const _target_elems = $( '.main-navigation, .toggle-mobile-menu' );
		if ( window.innerWidth < 768 ) {
			_target_elems.removeClass( 'active' );
			_body.removeClass( 'mobile-menu-opened' );
			__enable_scroll();
		}
	}


	/**
	 * Open/close mobile menu
	 *
	 * @param e
	 * @private
	 */
	function __click_sandwich_button_handler( e ) {
		const _this = $( e.currentTarget ),
			_main_nav_elem = $( '.main-navigation' );
		if ( _this.hasClass( 'active' ) ) {
			_this.removeClass( 'active' );
			_main_nav_elem.removeClass( 'active' );
			_body.removeClass( 'mobile-menu-opened' );
			__enable_scroll();
		} else {
			__disable_scroll();
			_this.addClass( 'active' );
			_main_nav_elem.addClass( 'active' );
			_body.addClass( 'mobile-menu-opened' );
		}
	}


	/**
	 * Initialize Swiper slider
	 *
	 * @private
	 */
	function __swiper_init() {
		const about_swiper = new Swiper( '.about--swiper', {
			loop: true,
			slidesPerView: 1,
			autoHeight: true,
			autoplay: {
				disableOnInteraction: false,
			},
			pagination: {
				el: '.swiper-pagination--about',
				clickable: true,
			},
		} );

		const vacancies_swiper = new Swiper( '.vacancies--swiper', {
			loop: true,
			spaceBetween: 20,
			autoHeight: true,
			autoplay: {
				disableOnInteraction: false,
			},
			pagination: {
				el: '.swiper-pagination--vacancies',
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next--vacancies',
				prevEl: '.swiper-button-prev--vacancies',
			},
			breakpoints: {
				320: {
					slidesPerView: 1,
				},
				575: {
					slidesPerView: 2,
				},
				991: {
					slidesPerView: 4,
				},
			},
		} );

		const candidates_swiper = new Swiper( '.candidates--swiper', {
			loop: true,
			spaceBetween: 20,
			autoHeight: true,
			autoplay: {
				disableOnInteraction: false,
			},
			pagination: {
				el: '.swiper-pagination--candidates',
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next--candidates',
				prevEl: '.swiper-button-prev--candidates',
			},
			breakpoints: {
				320: {
					slidesPerView: 1,
				},
				575: {
					slidesPerView: 2,
				},
				991: {
					slidesPerView: 4,
				},
			},
		} );

		const stories_swiper = new Swiper( '.stories--swiper', {
			loop: true,
			slidesPerView: 1,
			autoHeight: true,
			autoplay: {
				disableOnInteraction: false,
			},
			pagination: {
				el: '.swiper-pagination--stories',
				clickable: true,
			},
		} );
	}


	/**
	 * Assign events handlers
	 *
	 * @private
	 */
	function __assign() {
		_window.on( 'scroll', __page_scroll_handler );
		_window.on( 'resize', __window_resize_handler );
		_sandwich_button_elem.on( 'click', __click_sandwich_button_handler );

		window.onbeforeunload = function() {
			_window.off( 'scroll', __page_scroll_handler );
			_window.off( 'resize', __window_resize_handler );
			_sandwich_button_elem.off( 'click', __click_sandwich_button_handler );
		};
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
		},
	};
} )( jQuery.noConflict() ).init();
