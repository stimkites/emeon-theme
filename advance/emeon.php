<?php

class Emeon_Main_Framework{

	function __construct(){
		//get Emeon Universal first so it could fire its actions first
		/** @noinspection PhpIncludeInspection */
 		get_template_part('advance/emeon_uni');


		if(is_admin()){
			//check on what page we are
			$current_page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

			//always registered in admin
			add_action( 'init', array( $this, 'import_notice_check' ), 9 );
		}
	}

	function import_notice_check(){
		$plugin_path = 'skt-templates/skt-templates.php';
		include_once ABSPATH . 'wp-admin/includes/plugin.php';// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		if ( is_plugin_active( $plugin_path ) ){
			return;
		}

		if( !emeon_is_admin_notice_active( 'fresh_import' ) ){
			return;
		}

		remove_action('tgmpa_register', 'emeon_register_required_plugins');
		add_action( 'admin_notices', array( $this, 'import_notice' ) );
 	}

	function import_notice(){
		echo '<div class="a13fe-admin-notice notice notice-info is-dismissible" data-notice_id="fresh_import">';
		echo '<h3>'.sprintf( esc_html__( 'Welcome to EmeonWP Theme', 'emeon' ), esc_html(EMEON_OPTIONS_NAME_PART )).'</h3>';
		echo '<p>'.esc_html__( 'Click on the button below to complete theme installation process..', 'emeon' ).'</p>';
		echo '<p><a class="button button-primary" href="'.esc_url( admin_url( 'themes.php?page=emeoninfopage&amp;subpage=info' ) ).'">'.esc_html__( 'Complete Installation', 'emeon').'</a></p>';
		echo '</div>';
	}
}

//run
new Emeon_Main_Framework();