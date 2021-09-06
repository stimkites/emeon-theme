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
    let f = e.target.filename;
    console.log( f );
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
