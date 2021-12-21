/**
 * My account JS
 */

'use strict';

( $ => {

	/**
	 * Stop current event
	 *
	 * @param e
	 * @return {boolean}
	 * @private
	 */
	const __noreturn = function( e ) {
		e.stopPropagation();
		e.preventDefault();
		return false;
	};

	const __outsideClickHandler = function( e ) {
		let target = $( e.target );

		if ( !target[ 0 ].closest( '.article-menu__menu' ) ) {
			$( '.article-menu__menu' ).removeClass( 'active' );
		}

		__noreturn( e );
	};

	/**
	 * Article menu item click handler
	 * @param e
	 * @private
	 */

	const __articleMenuHandler = function( e ) {
		let _this = $( this );

		_this.parent( '.account-article' ).siblings( '.account-article' ).find( '.article-menu__menu' ).removeClass( 'active' );
		_this.find( '.article-menu__menu' ).toggleClass( 'active' );

		if ( _this.find( '.article-menu__menu' ).hasClass( 'active' ) ) {
			$( document ).on( 'click', __outsideClickHandler );
		} else {
			$( document ).off( 'click', __outsideClickHandler );
		}

		__noreturn( e );
	};


	const __assign = function() {

		if ( $( window ).width() < 992 ) {
			$( '.emeon-account .account-article .article-menu' ).off().on( 'click', __articleMenuHandler );
		}
	};

	return {
		init: function() {
			$( document ).ready( () => {
				__assign();
			} );
		},
	};

} )(
  jQuery.noConflict(),
).init();
