/**
 * Forms JS
 *
 * Adding/editing/joining/logging in and other forms javascript
 */

'use strict';

/**
 * Add/edit form JS
 */
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

	/**
	 * Validate form fields
	 *
	 * @param name
	 * @param value
	 * @return {boolean | string}
	 * @private
	 */
	const __invalid = function( name, value ) {
		if ( /[^0-9a-zA-Z ,.&<>?^%$#@!~="\n\t/{}()+*_\-:;\[\]\|\\]$/gim.test( value ) )
			return 'Invalid characters!';
		switch ( name ) {
			case 'article[title]' :
				return ( value.length > 3 ? false : 'Invalid title/name' );
			case 'article[excerpt]' :
				return ( value.length < 4 ? 'Too short excerpt' : /<\/?[a-z][\s\S]*>/i.test( value ) ? 'Excerpt contains HTML tags' : false );
			case 'article[categories]' :
				console.log( value );
				return ( value.length ? false : 'Categories undefined' );
			case 'article[tags]' :
				return ( value.length ? false : 'No tags? Please add at least one' );
			case 'article[email]' :
				return ( /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test( value ) ? false : 'Invalid email address' );
			case 'article[phone]' :
				return ( /^[\d +()]+$/im.test( value ) ? false : 'Invalid phone number' );
			case 'article[urls]' :
				return ( /<\/?[a-z][\s\S]*>/i.test( value ) ? 'Additional contacts should not contain any HTML tags' : false );
			case 'article[content]' :
				return ( value.length < 4 ? 'No content at all? What do we publish then?' : false );
			default :
				return ( value.length > 0 ? false : 'Empty value is not allowed.' );
		}
	};

	/**
	 * Validate all form fields before sending it to the server
	 *
	 * @param e
	 * @return {*}
	 * @private
	 */
	const __validate_form = function( e ) {
		let errors = [];
		$( '.error-field' ).removeClass( 'error-field' );
		if ( 'undefined' !== typeof tinyMCE ) tinyMCE.get( 'article_content' ).save();
		$( 'form.emeon-form .invalidate' ).each( function() {
			let current_error = __invalid( this.name, $( this ).val() );
			if ( current_error ) {
				errors.push( current_error );
				$( this ).parents( '.control-wrap' ).addClass( 'error-field' );
			}
		} );
		if ( errors.length ) {
			__error( errors[ 0 ] );
			return __noreturn( e );
		}
		$( 'body' ).addClass( 'loading' );
		$( '<input type="hidden" name="__nonce" value="' + __emeon.n + '" />' ).appendTo( 'form.emeon-form' );
		return e;
	};

	/**
	 * Show error
	 *
	 * @param msg
	 * @param delay
	 * @private
	 */
	const __error = function( msg, delay ) {
		let e = $( '#emeon-error-popup' );
		let t;
		if ( !( e.length ) )
			e = $( '<div id="emeon-error-popup"></div>' )
				.prependTo( 'body' )
				.on( 'mouseenter', () => {
					clearTimeout( t );
				} )
				.on( 'mouseleave', () => {
					t = setTimeout( () => {
						e.removeClass( 'visible' );
					}, 1000 );
				} )
				.on(
					'click',
					( e ) => {
						$( e.target ).removeClass( 'visible' );
					},
				);
		setTimeout( () => {
			e.html( msg || 'error' ).addClass( 'visible' );
		}, 200 );
		t = setTimeout( () => {
			e.removeClass( 'visible' );
		}, delay || 5000 );
	};

	/**
	 * Reset photo/logo image
	 *
	 * @param e
	 * @return {boolean}
	 * @private
	 */
	const __reset_photo = function( e ) {
		let _i = $( 'img.logo' );
		_i.prop( 'src', _i.data( 'default' ) ).parent().removeClass( 'added' );
		$( '#photo-file' ).val( '' );
		return __noreturn( e );
	};

	/**
	 * Reset attachment and PDF preview
	 *
	 * @param e
	 * @return {boolean}
	 * @private
	 */
	const __reset_attachment = function( e ) {
		let _i = $( '#attachment-preview' );
		_i.prop( 'src', '' ).parent().removeClass( 'added' );
		$( '#attachment-file' ).val( '' );
		return __noreturn( e );
	};

	/**
	 * Set photo/logo
	 *
	 * @param e
	 * @private
	 */
	const __set_photo = function( e ) {
		let f = e.target.files[ 0 ];
		let allowed_images = [ '.png', '.jpg', '.gif', 'jpeg', '.bmp' ];
		if ( -1 === allowed_images.indexOf( f.name.substr( -4 ) ) ) {
			__error( 'Improper image format!' );
			return;
		}
		if ( f.size > 5 * 1024 * 1024 ) {
			__error( 'Image file size exceeds 5Mb!' );
			return;
		}
		let src = URL.createObjectURL( f );
		if ( !src ) return;
		$( 'img.logo' )
			.prop( 'src', src )
			.parent()
			.addClass( 'added' )
			.on(
				'load',
				() => {
					URL.revokeObjectURL( src );
				},
			);
	};

	/**
	 * Set attachment info and display PDF preview
	 *
	 * @param e
	 * @private
	 */
	const __set_attachment_info = function( e ) {
		let f = e.target.files[ 0 ];
		if ( '.pdf' !== f.name.substr( -4 ) ) {
			__error( 'Improper PDF file format!' );
			return;
		}
		if ( f.size > 5 * 1024 * 1024 ) {
			__error( 'PDF file size exceeds 5Mb!' );
			return;
		}
		const obj_url = URL.createObjectURL( f );
		$( '#attachment-preview' )
			.prop( 'src', obj_url )
			.parent()
			.addClass( 'added' )
			.on(
				'load',
				() => {
					URL.revokeObjectURL( obj_url );
				},
			);
	};

	/**
	 * Initialize select2
	 *
	 * @private
	 */
	const __init_selects = function() {
		$( '.sel2[multiple]' ).select2( {
			width: '100%',
			multiple: true,
			selectionCssClass: ':all:',
		} );
		//
		// $( 'select.sel2:not(.select2-offscreen)' ).select2( {
		// 	width: '100%',
		// 	tags: true,
		// 	containerCssClass: 'form-control',
		// } );
	};

	const __error_flush = function() {
		$( document ).on( // remove "error" icon on elements
			'mousedown click blur enter focus', '.error-field',
			( e ) => {
				$( e.target ).removeClass( 'error-field' ).parents().removeClass( 'error-field' );
			},
		);
		setTimeout( () => {
			tinymce.activeEditor.on(
				'keydown mousedown paste enter focus',
				() => {
					$( '#article_content' ).parents().removeClass( 'error-field' );
				},
			);
		}, 100 );
	};

	/**
	 * Assign all events
	 *
	 * @private
	 */
	const __assign = function() {
		$( '#photo-file' ).off().change( __set_photo );
		$( '.logo-remove' ).off().click( __reset_photo );
		$( '#attachment-file' ).off().change( __set_attachment_info );
		$( '.attachment-remove' ).off().click( __reset_attachment );
		$( 'form.emeon-form' ).off().submit( __validate_form );
		__error_flush();
		__init_selects();
	};

	return {

		/**
		 * Initialize ad editor
		 */
		init: function() {
			if ( !document.getElementById( 'form-article-edit' ) ) return;
			$( document ).ready( __assign );
		},

	};

} )( jQuery.noConflict() ).init(); /** Ad edit form **/

/**
 * My account
 */
( $ => {

	/**
	 * Assign all events
	 *
	 * @private
	 */
	const __assign = function() {
		$( '#account-primary-menu li a' ).off().click( ( e ) => {
			let l = $( $( e.target ).attr( 'href' ) );
			if ( !l.length ) return;
			$( '.account-content' ).removeClass( 'viz' );
			l.addClass( 'viz' );
		} );
		$( '.delete-item' ).off().on( 'click', function( e ) {
			if ( !confirm( 'Proceed to delete "' + $( this ).data( 'title' ) + '"?' ) ) {
				e.stopPropagation();
				e.preventDefault();
				return false;
			}
		} );
		$( '#view-pass' ).off().on( 'change', function() {
			$( 'form.form-password input.view-toggle' ).attr( 'type', ( $( this ).prop( 'checked' ) ? 'text' : 'password' ) );
		} );
	};

	return {

		/**
		 * Initialize account menus
		 */
		init: function() {
			if ( !document.getElementById( 'account-primary-menu' ) ) return;
			$( document ).ready( __assign );
		},

	};

} )( jQuery.noConflict() ).init(); /** My account **/

/** Search form */
( $ => {

	/**
	 * Assign all events
	 *
	 * @private
	 */
	const __assign = function() {

		$( '#toggle-search' ).off().on( 'click', () => {
			$( '#search-form' ).toggleClass( 'visible', '' );
		} );
	};

	return {

		/**
		 * Initialize account menus
		 */
		init: function() {
			if ( !document.getElementById( 'search-form' ) ) return;
			$( document ).ready( __assign );
		},

	};

} )( jQuery.noConflict() ).init(); /** Search form **/


