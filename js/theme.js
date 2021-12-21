/* Theme's JS that fires on all pages */

window.onload = ( function( $ ) {

	const _body = $( 'body' ),
		_window = $( window ),
		_header_elem = $( '.site-header' ),
		_sandwich_button_elem = $( '.toggle-mobile-menu' ),
		_searchBtnFilter = $( '.search-mobile-bar .btn' ),
		_closeFilterBtn = $( '.search-content .emeon-form .btn-close' ),
		_emeonCookieButtons = $( '.emeon-cookies .emeon-cookies__btn-wrapper .btn' ),
		_hero_button = $( '.hero__button' ),
		_hero_images = $( '.hero__image' );


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
		const vacancies_swiper = new Swiper( '.vacancies--swiper', {
			loop: true,
			spaceBetween: 20,
			autoHeight: true,
			// autoplay: {
			// 	disableOnInteraction: false,
			// },
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

		const projects = new Swiper( '.projects--swiper', {
			loop: true,
			spaceBetween: 15,
			autoHeight: true,
			autoplay: {
			 	disableOnInteraction: false,
        delay: 600,
			},
      navigation: {
        nextEl: '.swiper-button-next--projects',
        prevEl: '.swiper-button-prev--projects',
      },
			breakpoints: {
				320: {
					slidesPerView: 2,
				},
				575: {
					slidesPerView: 3,
				},
				991: {
					slidesPerView: 5,
				},
			},
		} );

    const themes = new Swiper( '.themes--swiper', {
      loop: true,
      spaceBetween: 20,
      autoHeight: true,
      autoplay: {
        disableOnInteraction: false,
        delay: 3000,
      },
      pagination: {
        el: '.swiper-pagination--themes',
        clickable: true,
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
			// autoplay: {
			// 	disableOnInteraction: false,
			// },
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
			autoHeight: false,
			height: '584px',
			autoplay: {
				delay: 12000,
			},
			pagination: {
				el: '.swiper-pagination--stories',
				clickable: true,
			},
		} );
	}

	/**
	 * Range slider in search results
	 * @private
	 */

	function __rangeSlider_init() {
		const salary = $( '.emeon-form .emeon-salary' );
		const curSymb = salary.siblings( '.cur-symbol' ).text();
		const minSalary = +salary.attr( 'min' );
		const stepSalary = +salary.attr( 'step' );
		salary.ionRangeSlider( {
			skin: 'round',
			min: minSalary,
			step: stepSalary,
			max: 20000,
			postfix: ` ${ curSymb }`,
			from: salary.val(),
		} );
	}

	/**
	 * Toggle class for mobile filtering
	 * @private
	 */

	function __clickSearchFilterHandler() {
		$( '.search-content .emeon-form' ).toggleClass( 'open' );
	}

	/**
	 * Close filters
	 * @private
	 */

	function __closeFiltersMobile() {
		$( '.search-content .emeon-form' ).removeClass( 'open' );
	}

	/**
	 * Cookie concern handler
	 * @param event
	 * @private
	 */

	function __cookieConcernHandler( event ) {
		localStorage.setItem( 'emeon-cookie', 'accept' );
		$( '.emeon-cookies' ).addClass( 'done' );
	}

	function __checkCookieConcern() {
		if ( !localStorage.getItem( 'emeon-cookie' ) ) {
			$( '.emeon-cookies' ).removeClass( 'done' );
		}
	}



	function __change_image( e ) {
		const _action = e.currentTarget.dataset.action;
		console.log(_action);
		_hero_images.addClass( 'hidden' );
		$( '.hero__image[data-action="' + _action + '"]' ).removeClass( 'hidden' );
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
		_searchBtnFilter.on( 'click', __clickSearchFilterHandler );
		_closeFilterBtn.on( 'click', __closeFiltersMobile );
		_emeonCookieButtons.on( 'click', __cookieConcernHandler );
		_hero_button.on( 'mouseenter', __change_image )

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

		__checkCookieConcern();
		__page_scroll_handler();
		__swiper_init();
		__rangeSlider_init();
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
