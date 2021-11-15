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
		$(
			'form.emeon-form input.invalidate,' +
			'form.emeon-form textarea.invalidate,' +
			'form.emeon-form select.invalidate',
		).each( function() {
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
			return __reset_photo( e );
		}
		if ( f.size > 5 * 1024 * 1024 ) {
			__error( 'Image file size exceeds 5Mb!' );
			return __reset_photo( e );
		}
		let src = URL.createObjectURL( f );
		if ( !src ) return __reset_photo( e );
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
			return __reset_attachment( e );
		}
		if ( f.size > 5 * 1024 * 1024 ) {
			__error( 'PDF file size exceeds 5Mb!' );
			return __reset_attachment( e );
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
			allowClear: true,
			width: '100%',
			multiple: true,
			tags: true,
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
	 * Switch my-account sections
	 *
	 * @param e
	 * @private
	 */
	const __switch_partitions = e => {
		let l = $( $( e.target ).attr( 'href' ) );
		if ( !l.length ) return;
		$( '.account-content' ).removeClass( 'viz' );
		l.addClass( 'viz' );
	};


	/**
	 * Delete post/ad
	 *
	 * @param e
	 * @returns {boolean}
	 * @private
	 */
	const __delete_post = e => {
		if ( !confirm( 'Proceed to delete "' + $( this ).data( 'title' ) + '"?' ) ) {
			e.stopPropagation();
			e.preventDefault();
			return false;
		}
	};


	/**
	 * Toggle password visibility in the inputs
	 *
	 * @private
	 */
	const __toggle_password_visibility = () => {
		$( 'form.form-password input.view-toggle' ).attr( 'type', ( $( this ).prop( 'checked' ) ? 'text' : 'password' ) );
	};


	/**
	 * Close article menu
	 *
	 * @private
	 */
	const __close_post_menu = () => {
		$( '.article-menu' ).removeClass( 'open' );
	};


	/**
	 * Toggle article menu visibility
	 *
	 * @param e
	 * @private
	 */
	const __toggle_post_menu = e => {
		__close_post_menu();
		const parent = $( e.target ).parents( '.article-menu' );

		if ( parent.length > 0 && !parent.hasClass( 'open' ) ) {
			parent.addClass( 'open' );
		}
	};


	/**
	 * Assign all events
	 *
	 * @private
	 */
	const __assign = function() {
		$( '#account-primary-menu li a' ).off().on( 'click', __switch_partitions );
		$( '.delete-item' ).off().on( 'click', __delete_post );
		$( '#view-pass' ).off().on( 'change', __toggle_password_visibility );
		$( document.body ).on( 'click', __toggle_post_menu );
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

const validateEmail = ( email ) => {
		const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test( String( email ).toLowerCase() );
};

/** Join form */
( $ => {

	/**
	 * Assign all events
	 *
	 * @private
	 */

	const __error = function( msg, delay, type ) {
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
		if (type === 'success') {
			$('#emeon-error-popup').addClass('success')
		}else {
			if ($('#emeon-error-popup').hasClass('success')) {
				$('#emeon-error-popup').removeClass('success');
			}
		}
		setTimeout( () => {
			e.html( msg || 'error' ).addClass( 'visible' );
		}, 200 );
		t = setTimeout( () => {
			e.removeClass( 'visible' );
		}, delay || 5000 );
	};

	const __validate_form = async ( event ) => {
		event.preventDefault();
		let _target = $( event.target );
		let errors = 0,
			tokenNum,
			value;

		//key "6LezDgkdAAAAACMpL98U5KbwxcPsyUqpL2BTseE7" is site_key for google captcha
		const getToken = await grecaptcha.execute( '6LfvAwkdAAAAAO7EaIbNO1oQ6ltDXA8zZOC2H1dx', { action: 'submit' } ).then( ( token ) => tokenNum = token );

		if ( getToken ) {
			let err,
				label = _target.find( $( 'label[for="join_email"]' ) ),
				errorElNoValidText = label.data( 'valid' ),
				errorElEmptyText = label.data( 'empty' ),
				nonceVal = _target.find( $( 'input[name="__nonce"]' ) ).val(),
				emailVal = _target.find( $( 'input[type="email"]' ) ).val();

			if ( emailVal && !validateEmail( emailVal ) ) {
				errors++;
				err = 'novalid';
			}

			if ( !emailVal ) {
				errors++;
				err = 'empty';
			}

			value = emailVal;

			if ( err === 'novalid' ) {
				__error(errorElNoValidText)
				label.addClass( 'error' );
			}

			if ( err === 'empty' ) {
				__error(errorElEmptyText)
				label.addClass( 'error' );
			}

			if ( tokenNum && !errors && value && nonceVal ) {
				label.removeClass( 'error' );
				return {
					token: tokenNum,
					errors: false,
					emailVal: value,
					nonceVal: nonceVal,
				};
			}
		} else {
			return false;
		}
	};

	const __submitHandler = ( event ) => {
		event.preventDefault();
		let curTarget = $( event.currentTarget );
		if ( !__validate_form( event ) ) return;
		__validate_form( event ).then( res => {
			if ( !res ) return;
			const { token, errors, emailVal, nonceVal } = res;
			if ( !errors ) {
				let adminUrl = __emeon.ajax_url;

				let data = {
					action: 'ajax_join_form',
					email: emailVal,
					token: token,
					nonce: nonceVal,
				};
				$.ajax( {
					url: adminUrl,
					data: data,
					type: 'POST',
					beforeSend: function( xhr ) {
						curTarget.addClass( 'loading' );
					},
					success: function( data ) {

						let label = curTarget.find( $( 'label[for="join_email"]' ) );
						let newData = $.parseJSON( data );
						if ( newData && newData[ 'message' ] && newData[ 'message' ] === 'success' ) {
							curTarget.removeClass( 'loading' );
							curTarget.find( $( 'input[type="email"]' ) ).val( '' );
							label.removeClass( 'error' );
							__error(label.data('success'), 4000, 'success');

						} else if ( newData && newData[ 'message' ] && newData[ 'message' ] === 'error' ) {
							curTarget.removeClass( 'loading' );
							label.addClass( 'error' );
							__error(newData[ 'error_text' ])
						} else {
							curTarget.removeClass( 'loading' );
							label.addClass( 'error' );
							__error('You are bot sorry, we can\'t register you')
						}
					},
				} );
			}
		} );
	};

	const __assign = function() {
		$( '.emeon-form.form-join' ).off().on( 'submit', __submitHandler );
	};

	return {

		/**
		 * Initialize join form handler
		 */
		init: function() {
			if ( $( '.emeon-form.form-join' ).length === 0 ) return;
			$( document ).ready( __assign );
		},

	};

} )( jQuery.noConflict() ).init(); /** Join form **/

/** Login form */

( $ => {
	const loginForm = $( '.emeon-form.form-login' );

	const __error = function( msg, delay, type ) {
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
		if (type === 'success') {
			$('#emeon-error-popup').addClass('success')
		}else {
			if ($('#emeon-error-popup').hasClass('success')) {
				$('#emeon-error-popup').removeClass('success');
			}
		}
		setTimeout( () => {
			e.html( msg || 'error' ).addClass( 'visible' );
		}, 200 );
		t = setTimeout( () => {
			e.removeClass( 'visible' );
		}, delay || 5000 );
	};

	const getToken = async function() {
		let tokenNum;
		const getToken = await grecaptcha.execute( '6LfvAwkdAAAAAO7EaIbNO1oQ6ltDXA8zZOC2H1dx', { action: 'submit' } )
			.then( ( token ) => tokenNum = token )
			.catch(err => console.error(err));

		if ( getToken ) {
			return tokenNum;
		}
	};

	const __validate = async function(event) {
		let err = 0,
			_target = $(event.target),
			email = _target.find($('input[type="email"]')),
			pass = _target.find($('input[type="password"]')),
			passLabel = pass.parent('label'),
			emailLabel = email.parent('label'),
			passVal = pass.val(),
			emailVal = email.val(),
			emptyText = email.data('empty'),
			result;

		if (!passVal || !emailVal) {
			if (!passVal ) {
				passLabel.addClass('error');
			}

			if (!emailVal) {
				emailLabel.addClass('error');
			}

			err++;
			__error(emptyText)
		}

		if( __emeon.d )
			result = true;
		else
			await getToken().then(res => {
				result = res;
			});

		if (err === 0 && result) {
			passLabel.removeClass('error')
			emailLabel.removeClass('error');
			return {
				token: result,
				email: emailVal,
				pass: passVal
			}
		}
	}

	const __submitHandler = function( event ) {
		event.preventDefault();
		let target = $(event.currentTarget);
			const validate = __validate(event);
			validate.then(res => {
				if (!res) return;
				if ( Object.keys(res).length === 0 ) return;
				const { token, email, pass } = res;
				let adminUrl = __emeon.ajax_url;
				let nonceVal = target.find($('input[name="__nonce"]')).val();
				let remember = target.find($('input[name="remember"]'))[0].checked;

				let data = {
					action: 'ajax_login_form',
					email: email,
					token: token,
					pass: pass,
					nonce: nonceVal,
					remember: remember
				};

				$.ajax( {
					url: adminUrl,
					data: data,
					type: 'POST',
					beforeSend: function( xhr ) {
						target.addClass( 'loading' );
					},
					success: function( data ) {
						let email = target.find($('input[type="email"]')),
							pass = target.find($('input[type="password"]')),
							passLabel = pass.parent('label'),
							emailLabel = email.parent('label');

						let newData = $.parseJSON( data );
						if ( newData && newData[ 'message' ] && newData[ 'message' ] === 'success' ) {
							target.removeClass( 'loading' );
							target.find( $( 'input[type="email"]' ) ).val( '' );
							target.find( $( 'input[type="password"]' ) ).val( '' );
							passLabel.removeClass( 'error' );
							emailLabel.removeClass( 'error' );
							console.log(target.data('success'));
							__error(target.data('success'), 4000, 'success');

						} else if ( newData && newData[ 'message' ] && newData[ 'message' ] === 'error' ) {
							target.removeClass( 'loading' );
							passLabel.addClass( 'error' );
							emailLabel.addClass( 'error' );
							__error(newData[ 'error_text' ])
						} else {
							target.removeClass( 'loading' );
							passLabel.addClass( 'error' );
							emailLabel.addClass( 'error' );
							__error('You are bot sorry, we can\'t register you')
						}
					},
				} );

			})



	};

	const __assign = function() {
		loginForm.off().on( 'submit', __submitHandler );
	};

	return {

		init: function() {
			if ( loginForm.length === 0 ) return;
			$( document ).ready( __assign );
		},
	};

} )( jQuery.noConflict() ).init();

/** Search form */
( $ => {

	/**
	 * Assign all events
	 *
	 * @private
	 */
	const __assign = function() {
		$( '.emeon-search-select' ).each( function( index, element ) {
			const _this = $( element );
			_this.select2( {
				width: '100%',
				multiple: false,
				minimumInputLength: 3,
				tags: true,
				allowClear: true,
				selectionCssClass: ':all:',
			} ).on( 'change', function() {
				if ( _this.val().length > 2 ) {
					_this.parents( 'form' ).trigger( 'submit' );
				}
			} ).on( 'select2:open', function( e ) {
				setTimeout( function() {
					const _input = document.querySelector( '[aria-controls="select2-' + e.currentTarget.id + '-results"]' );
					if ( _input ) {
						_input.focus();
					}
				}, 100 );
			} );
		} );

		$( '#toggle-search' ).off().on( 'click', ( e ) => {
			const form = $( e.currentTarget ).parents( '.site-header' ).find( $( '.search-filters' ) );
			form.toggleClass( 'visible' );
			$( e.currentTarget ).toggleClass( 'visible' );
			e.preventDefault();
			e.stopPropagation();
			return false;
		} );
	};

	return {

		/**
		 * Initialize account menus
		 */
		init: function() {
			if ( $( '.emeon-search-select' ).length === 0 ) return;
			$( document ).ready( __assign );
		},

	};

} )( jQuery.noConflict() ).init(); /** Search form **/


/** Filters form */
( $ => {

	function __toggle_form( e ) {
		const checked = e.target.checked,
			switcher = $( e.target ),
			form_wrapper = switcher.parents( '.form-check' ),
			form = switcher.parents( '.form-filters' );

		if ( checked ) {
			form_wrapper.addClass( 'open' );
			form.addClass( 'shadow' );
		} else {
			form_wrapper.removeClass( 'open' );
			form.removeClass( 'shadow' );
		}
	}

	function __select2_init() {
		$( '#emeon-form-filters .sel2' ).select2( {
			width: '100%',
			multiple: true,
			allowClear: true,
			selectionCssClass: ':all:',
		} );
	}

	/**
	 * Assign all events
	 *
	 * @private
	 */
	function __assign() {
		$( '#toggle_filters' ).on( 'change', __toggle_form );
	}


	function __init() {
		__select2_init();
		__assign();
	}

	return {

		/**
		 * Initialize account menus
		 */
		init: function() {
			if ( !document.getElementById( 'emeon-form-filters' ) ) return;
			$( document ).ready( __init );
		},

	};

} )( jQuery.noConflict() ).init(); /** Filters form **/
