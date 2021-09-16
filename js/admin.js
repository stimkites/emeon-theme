/**
 * Admin JS for metaboxes controls
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
  const __noreturn = function( e ){
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
    $( '#attachment-preview' ).prop( 'src', '' ).hide().parent().removeClass( 'added' );
    $( '#attachment-file' ).val( '' );
    return __noreturn( e );
  };

  /**
   * Set attachment info and display PDF preview
   *
   * @param e
   * @private
   */
  const __set_attachment_info = function( e ){
    let _media = wp.media({
      title : 'Select PDF',
      multiple: false,
      library: {
        type: ['application/pdf']
      }
    }).on('select', () => {
      let attachment = _media.state().get('selection').first().toJSON();
      $( '#attachment-file' ).val( attachment.id );
      $( '#attachment-preview' )
        .prop( 'src', attachment.url )
        .show()
        .parent()
        .addClass( 'added' );
    }).open();
  };

  return {
    init : function () {
      $( document ).ready( () => {
        $( '#attachment-info'   ).off().click( __set_attachment_info );
        $( '.attachment-remove' ).off().click( __reset_attachment    );
      } );
    }
  }

} )(
  jQuery.noConflict()
).init();
