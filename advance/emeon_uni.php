<?php
class Emeon_Skt13Framework_Uni{
	function __construct(){
		add_filter( 'emeon_docs_address', array( $this, 'docs_link' ), 10, 2 );
	}

	function docs_link() {
		return 'https://www.sktthemesdemo.net/documentation/emeon-doc';
	}
}

new Emeon_Skt13Framework_Uni();






