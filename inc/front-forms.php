<?php
/**
 * Forms rendering and processing
 */

new class {

    function __construct() {

        // Render forms
        add_shortcode( 'emeon_forms',       [ $this, 'render'   ]    );

        // Process forms
        add_action   ( 'template_redirect', [ $this, 'process'  ]    );

        // Contact fields in admin
        add_action   ( 'add_meta_boxes_post',   [ $this, 'add_fields'  ] );
        add_action   ( 'save_post_post',        [ $this, 'save_fields' ] );
    }

	/**
	 * Add meta box with the contact info to posts
	 */
	function add_fields() {
		add_meta_box(
			'emeon-contact-box',
			'Contact info',
			function( $post ){ include EMEON_TPL . '/forms/contacts.php'; },
			"product",
			"side"
		);
	}

	/**
     * Update emeon contacts
     *
	 * @param WP_Post $post
	 */
    function save_fields( $post ){
	    update_post_meta( $post->ID, 'emeon_contacts', $_POST['emeon_contacts'] ?? [] );
    }

	/**
	 * Process POST request
	 */
    function process(){
    	if( ! ( $action = ( $_POST['emeon_form_action'] ?? false ) ) ) return;
	    if( ! wp_verify_nonce( $_POST['__nonce'] ?? false, EMEON_SLUG ) ) {
		    $_POST['emeon_error'][] = 'Session expired. Please, try again...';
		    return;
	    }
    	if( ! method_exists( $this, $action ) ) {
    		$_POST['emeon_error'][] = '[ERR1586] Action not found!';
    		return;
	    }
		$this->{ $action }();
    }

    /**
     * Safely render Emeon form and errors if any
     *
     * @param array $attributes
     * @return false|string|null
     */
    function render( $attributes = [] ){
        $path = EMEON_TPL . '/forms/' . ( $attributes['form'] ?? 'unknown' ) . '.php';
        if( ! file_exists( $path ) ) return null;
        ob_start();
        include $path;
        if( $errors = ( $_POST['emeon_error'] ?? false ) ) : ?>
        <div class="emeon-error">
	        <div class="error-icon"></div>
	        <div class="error-content">
	            <p>
		        <?=implode( "</p><p>", $errors )?>
	            </p>
	        </div>
	        <button class="error-dismiss"></button>
        </div>
		<?php endif;
        return ob_get_clean();
    }

    /** ------------------------------------------------------------------------------------------------ ACTIONS --- */

	/**
	 * Join action
	 */
    protected function join(){
	    if( ! ( $email = $_POST['email'] ) ||
	        ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		    $_POST['emeon_error'][] = 'The email you entered is invalid. Please, try again.';
		    return;
	    }
	    if( ( $user = get_user_by( 'email', $email ) ) && ! is_wp_error( $user ) ){
		    $_POST['emeon_error'][] = 'User with this email already registered. Please, <a href="/login/">login</a>.';
		    return;
	    }
	    $pass = wp_generate_password( 6 );
	    $UID = wp_create_user( $email, $pass, $email );
	    if( is_wp_error( $UID ) ){
		    $_POST['emeon_error'][] = $UID->get_error_message() . ' Please, try again.';
		    return;
	    }
	    wp_send_new_user_notifications( $UID );
	    wp_safe_redirect( '/login?uid=' . $UID );
	    exit;
    }

    /**
     * Login action
     */
    protected function login(){
	    if( ! ( $email = $_POST['email'] ) ||
	        ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		    $_POST['emeon_error'][] = 'The email you entered is invalid. Please, try again.';
		    return;
	    }
	    if( ! ( $user = get_user_by( 'email', $email ) ) || is_wp_error( $user ) ){
		    $_POST['emeon_error'][] = 'User with email "' . $email . '" is not registered!';
		    return;
	    }
	    $remains = get_user_meta( $user->ID, '_login_remaining_attempts', true );
	    if( false === $remains )
	    	$remains = 5;
	    if( ! $remains ){
		    $_POST['emeon_error'][] = 'Unfortunately you have missed all attempts for login. Please, try to <a href="/recover/">recover</a>.';
		    return;
	    }
	    $auth = wp_authenticate( $user->user_login, $_POST['pass'] );
	    if( ! $auth || is_wp_error( $auth ) ){
	    	--$remains;
	    	update_user_meta( $user->ID, '_login_remaining_attempts', $remains );
		    $_POST['emeon_error'][] = 'Invalid password. Remaining attempts: ' . ( $remains + 1 ) . 'Please, try again.';
		    return;
	    }
	    wp_set_current_user( $auth->ID );
	    wp_set_auth_cookie( $auth->ID, $_POST['remember'] ?? false );
	    wp_safe_redirect( '/account/' );
	    exit;
    }

    protected function captcha(){

    }

};
