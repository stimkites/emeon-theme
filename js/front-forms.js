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
   * Validate email on the fly
   *
   * @param e
   * @return {boolean}
   * @private
   */
  const __validate_email = function( e ){
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test( e.target.value );
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
    if( ! ( e.length ) )
      e = $( '<div id="emeon-error-popup"></div>' ).prependTo( 'body' );
    e.html( msg || 'error' ).addClass( 'visible' );
    setTimeout( () => { e.removeClass( 'visible' ) }, delay || 5000 );
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
    e.stopPropagation();
    e.preventDefault();
    return false;
  };

  /**
   * Reset attachment and PDF preview
   *
   * @param e
   * @return {boolean}
   * @private
   */
  const __reset_attachment = function( e ){
    e.stopPropagation();
    e.preventDefault();
    let _i = $( '#attachment-preview' );
    _i.prop( 'src', '' ).hide().parent().removeClass( 'added' );
    $( '#attachment-file' ).val( '' );
    return false;
  };

  /**
   * Set photo/logo
   *
   * @param e
   * @private
   */
  const __set_photo = function( e ){
    let f = e.target.files[0];
    if( -1 === [ '.png', '.jpg', '.gif', 'jpeg', '.bmp' ].indexOf( f.name.substr( -4 ) ) ) {
      __error( 'Improper image format!' );
      return;
    }
    if( f.size > 5*1024*1024 ) {
      __error( 'Image file size exceeds 5Mb!' );
      return;
    }
    let src = URL.createObjectURL( f );
    if( ! src ) return;
    console.log( src );
    $( 'img.logo' ).prop( 'src', src ).parent().addClass( 'added' );
    URL.revokeObjectURL( src );
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
    $( '#attachment-preview' ).prop( 'src', obj_url ).show().parent().addClass( 'added' );
    URL.revokeObjectURL(obj_url);
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
