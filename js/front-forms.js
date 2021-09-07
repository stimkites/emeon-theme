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

  const __reset_photo = function( e ){
    let _i = $( 'img.logo' );
    _i.prop( 'src', _i.data( 'default' ) );
    $( '#photo-file' ).reset();
  };

  const __set_photo = function( e ){
    $( 'img.logo' ).prop( 'src', window.URL.createObjectURL( e.target.files[0] ) ).parent().addClass( 'added' );
  };

  const __assign = function(){
    $( 'img.logo' ).off().click( () => { $( '#photo-file' ).trigger( 'click' ) } );
    $( '#photo-file' ).off().change( __set_photo );
    $( '.logo-remove' ).off().click( __reset_photo );
  };

  return {
    init : function() {
      if( ! document.getElementById( 'form-adedit' ).length ) return;
      $( document ).ready( __assign );
    }
  }

} )( jQuery.noConflict() ).init();
