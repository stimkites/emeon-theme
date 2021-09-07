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



  const __photo = function( e ){
    $( 'img.logo' ).prop( 'src', window.URL.createObjectURL( e.target.files[0] ) ).parent().addClass( 'added' );
  };

  const __assign = function(){
    $( 'img.logo' ).off().click( () => { $( '#photo-file' ).trigger( 'click' ) } );
    $( '#photo-file' ).off().change( __photo )
  };

  return {
    init : function() {
      $( document ).ready( __assign );
    }
  }

} )( jQuery.noConflict() ).init();
