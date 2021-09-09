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
  const __noreturn = function( e ){
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
  const __invalid = function( name, value ){
    switch ( name ) {
      case 'ad[title]' :
        return ( value.length > 3 ? false : 'Invalid title/name' );
      case 'ad[excerpt]' :
        return ( value.length < 4 ? 'Too short excerpt' : /<\/?[a-z][\s\S]*>/i.test( value ) ? 'Excerpt contains HTML tags' : false );
      case 'ad_categories' :
        return ( value.length ? false : 'Categories undefined' );
      case 'ad_tags' :
        return ( value.length ? false : 'No tags? Please add at least one' );
      case 'contacts[email]' :
        return ( /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test( value ) ? false : 'Invalid email address' );
      case 'contacts[phone]' :
        return ( /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im.test( value ) ? false : 'Invalid phone number' );
      case 'contacts[urls]' :
        return ( /<\/?[a-z][\s\S]*>/i.test( value ) ? 'Additional contacts should not contain any HTML tags' : false );
      case 'ad_content' :
        return ( value.length < 4 ? 'No content at all? What do we publish then?' : false );
      default :
        return false;
    }
  };

  /**
   * Validate all form fields before sending it to the server
   *
   * @param e
   * @return {*}
   * @private
   */
  const __validate_form = function( e ){
    let errors = [];
    $( '.error-field' ).removeClass( 'error-field' );
    if( 'undefined' !== typeof tinyMCE ) tinyMCE.get('ad_content').save();
    $( 'form.emeon-form .invalidate' ).each( function(){
      let current_error = __invalid( this.name, $( this ).val() );
      if( current_error ){
        errors.push( current_error );
        $( this ).parents( '.control-wrap' ).addClass( 'error-field' );
      }
    } );
    if( errors.length ) {
      __error(errors.join("<br/>"), 10000);
      return __noreturn( e );
    }
    return e;
  };

  /**
   * Show error
   *
   * @param msg
   * @param delay
   * @private
   */
  const __error = function( msg, delay ){
    let e = $( '#emeon-error-popup' );
    let t;
    if( ! ( e.length ) )
      e = $( '<div id="emeon-error-popup"></div>' )
            .prependTo( 'body' )
            .on( 'mouseenter', () => { clearTimeout( t ) } )
            .on( 'mouseleave', () => { t = setTimeout( () => { e.removeClass( 'visible' ) }, 1000 ) } )
            .on(
                'click',
                ( e ) => { $( e.target ).removeClass( 'visible' ) }
            );
    setTimeout( () => { e.html( msg || 'error' ).addClass( 'visible' ) }, 200 );
    t = setTimeout( () => { e.removeClass( 'visible' ) }, delay || 5000 );
  };

  /**
   * Reset photo/logo image
   *
   * @param e
   * @return {boolean}
   * @private
   */
  const __reset_photo = function( e ){
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
  const __reset_attachment = function( e ){
    let _i = $( '#attachment-preview' );
    _i.prop( 'src', '' ).hide().parent().removeClass( 'added' );
    $( '#attachment-file' ).val( '' );
    return __noreturn( e );
  };

  /**
   * Set photo/logo
   *
   * @param e
   * @private
   */
  const __set_photo = function( e ){
    let f = e.target.files[0];
    let allowed_images = [ '.png', '.jpg', '.gif', 'jpeg', '.bmp' ];
    if( -1 === allowed_images.indexOf( f.name.substr( -4 ) ) ) {
      __error( 'Improper image format!' );
      return;
    }
    if( f.size > 5*1024*1024 ) {
      __error( 'Image file size exceeds 5Mb!' );
      return;
    }
    let src = URL.createObjectURL( f );
    if( ! src ) return;
    $( 'img.logo' )
        .prop( 'src', src )
        .parent()
        .addClass( 'added' )
        .on(
            'load',
            () => { URL.revokeObjectURL( src ) }
        );
  };

  /**
   * Set attachment info and display PDF preview
   *
   * @param e
   * @private
   */
  const __set_attachment_info = function( e ){
    let f = e.target.files[0];
    if( '.pdf' !== f.name.substr( -4 ) ) {
      __error( 'Improper PDF file format!' );
      return;
    }
    if( f.size > 5*1024*1024 ) {
      __error( 'PDF file size exceeds 5Mb!' );
      return;
    }
    const obj_url = URL.createObjectURL( f );
    $( '#attachment-preview' )
        .prop( 'src', obj_url )
        .show()
        .parent()
        .addClass( 'added' )
        .on(
            'load',
            () => { URL.revokeObjectURL( obj_url ) }
        );
  };

  /**
   * Initialize select2
   *
   * @private
   */
  const __init_selects = function(){
    $( 'select.sel2:not(.select2-offscreen)' ).attr( 'multiple', true ).select2({
      width: '100%',
      tags: true
    });
  };

  const __error_flush = function(){
    $( document ).on( // remove "error" icon on elements
      'mousedown click blur enter focus', '.error-field',
      ( e ) => {
        $( e.target ).removeClass( 'error-field' ).parents().removeClass( 'error-field' );
      }
    );
    setTimeout( () => {
      tinymce.activeEditor.on(
          'keydown mousedown paste enter focus',
          () => { $( '#ad_content' ).parents().removeClass( 'error-field' ) }
      )
    }, 100 );
  };

  /**
   * Assign all events
   *
   * @private
   */
  const __assign = function(){
    $( 'img.logo' ).off().click( () => { $( '#photo-file' ).trigger( 'click' ) } );
    $( '#attachment-info' ).off().click( () => { $( '#attachment-file' ).trigger( 'click' ) } );
    $( '#photo-file' ).off().change( __set_photo );
    $( '.logo-remove' ).off().click( __reset_photo );
    $( '#attachment-file' ).off().change( __set_attachment_info );
    $( '.attachment-remove' ).off().click( __reset_attachment );
    $( 'button[type=submit]' ).off().click( __validate_form );
    __error_flush();
    __init_selects();
  };

  return {

    /**
     * Initialize ad editor
     */
    init : function() {
      if( ! document.getElementById( 'form-adedit' ).length ) return;
      $( document ).ready( __assign );
    }

  }

} )( jQuery.noConflict() ).init(); /** Ad edit form **/
