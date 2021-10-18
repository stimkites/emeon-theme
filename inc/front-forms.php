<?php
/**
 * Forms rendering and processing
 */

new class {

	function __construct() {

		// Register custom post statuses and primary categories
		add_action( 'init', [ $this, 'register' ] );

		// Render forms
		add_shortcode( 'emeon_forms', [ $this, 'render' ] );

		// Process forms
		add_action( 'template_redirect', [ $this, 'process' ] );

		// Contact fields in admin
		add_action( 'add_meta_boxes_post', [ $this, 'add_fields' ] );
		add_action( 'save_post', [ $this, 'save_fields' ] );

		// Enqueue form scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );

		// Admin scripts and styles
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin' ] );

		// Adedit form permalink
		add_filter( 'emeon_adedit_url', [ $this, 'get_adedit_url' ] );

		// All categories selectors
		add_filter( 'emeon_cats', [ $this, 'fetch_cats' ], 10, 2 );
	}

	/**
	 * Render all categories for front-end selectors as options
	 *
	 * @param string $html
	 * @param null | array $post_cats
	 *
	 * @return string
	 */
	static function fetch_cats( $html = '', $post_cats = null ){
		if( ! empty( $html ) )
			return $html; //already collected

		static $emeon_cats_html;
		if( null !== $emeon_cats_html )
			return $emeon_cats_html; // Already in Ram

		if( empty( $post_cats ) ) {
			global $post;
			if( ! empty( $post ) )
				$post_cats  = wp_get_post_categories( $post->ID );
			else
				$post_cats = $_POST['f'] ?? [];
		}
		$ex_cats = [ 1 ];
		foreach ( EMEON_TYPES as $type ) {
			if ( $term = get_term_by( 'slug', $type, 'category' ) ) {
				$ex_cats[] = $term->term_id;
			}
		}

		$cats_args = [
			'taxonomy'   => 'category',
			'exclude'    => $ex_cats,
			'hide_empty' => 0
		];

		foreach ( get_terms( $cats_args ) as $cat )
			$emeon_cats_html .=
				'<option value="' . $cat->term_id . '" ' .
		            ( in_array( $cat->term_id, $post_cats ?? [] ) ? 'selected' : '' ) . '>' .
		            $cat->name .
	            '</option>';

		return $emeon_cats_html;
	}

	/**
	 * Permalink to the adedit form
	 *
	 * @param string $value
	 *
	 * @return false|string
	 */
	function get_adedit_url( $value = '' ) {
		global $wpdb;
		if ( ! ( $post_id = $wpdb->get_var(
			"SELECT ID FROM {$wpdb->posts} " .
			"WHERE post_type = 'page' " .
			"AND post_content LIKE '%[emeon_forms%form=%adedit%]%'"
		) ) ) {
			return $value;
		}

		return get_permalink( $post_id );
	}

	/**
	 * Our custom post statuses and primary categories
	 */
	function register() {
		foreach ( EMEON_STATUSES as $status ) {
			register_post_status(
				$status,
				[
					'label'                     => ucfirst( $status ),
					'internal'                  => true,
					'protected'                 => true,
					'label_count'               => _n_noop(
						ucfirst( $status ) . ' <span class="count">(%s)</span>',
						ucfirst( $status ) . ' <span class="count">(%s)</span>'
					),
					'show_in_admin_status_list' => true,
				]
			);
		}
		foreach ( EMEON_TYPES as $type ) {
			if ( ! term_exists( $type, 'category' ) ) {
				wp_insert_term( ucfirst( str_replace( '-', ' ', $type ) ), 'category' );
			}
		}
	}

	/**
	 * Enqueue custom admin styles and scripts for POST edit pages
	 */
	function enqueue_admin() {
		if ( false === strpos( $_SERVER[ 'REQUEST_URI' ], '/post.php?post=' ) &&
		     false === strpos( $_SERVER[ 'REQUEST_URI' ], '/post-new.php' ) ) {
			return;
		}
		wp_enqueue_style( EMEON_SLUG, EMEON_URL . '/css/admin/admin.css', [], time() );
		wp_enqueue_script( EMEON_SLUG, EMEON_URL . '/js/admin.js', [ 'jquery' ], time() );
	}

	/**
	 * Forms JS
	 */
	function enqueue() {
		global $post;
		if ( false === strpos( $post->post_content ?? '', '[emeon_forms' ) ) {
			return;
		}
		if ( ! wp_script_is( 'jquery-core' ) ) {
			wp_enqueue_script( 'jquery-core', "/wp-includes/js/jquery/jquery.min.js", [], '3.6.0' );
		}
		if ( ! wp_script_is( 'select2' ) ) {
			wp_enqueue_style( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' );
			wp_enqueue_script( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', [ 'jquery' ], '1.0', true );
		}
		$slug = EMEON_SLUG . '-form-scripts';
		wp_register_script(
			$slug,
			EMEON_URL . '/js/front-forms.js',
			[ 'jquery-core' ],
			filemtime( EMEON_PATH . '/js/front-forms.js' ),
			true
		);
		wp_localize_script( $slug, '__emeon', [ 'n' => wp_create_nonce( EMEON_SLUG ) ] );
		wp_enqueue_script( $slug );
	}

	/**
	 * Add meta box with the contact info to posts
	 */
	function add_fields() {
		add_meta_box(
			'emeon-contact-box',
			'Contacts and attachment',
			function ( $post ) {
				include EMEON_TPL . '/forms/metabox-info.php';
			},
			"post",
			"side"
		);
	}

	/**
	 * Update emeon contacts and attachment
	 *
	 * @param int $post_id
	 */
	function save_fields( $post_id ) {
		if ( ! isset( $_POST[ 'emeon_contacts' ] ) ) {
			return;
		}
		update_post_meta( $post_id, 'emeon_contacts', $_POST[ 'emeon_contacts' ] ?? [] );
		update_post_meta( $post_id, 'emeon_attachment', $_POST[ 'ad_attachment' ] ?? '' );
		update_post_meta( $post_id, 'emeon_salary', $_POST[ 'emeon_salary' ] ?? '' );
		update_post_meta( $post_id, 'emeon_experience', $_POST[ 'emeon_experience' ] ?? '' );
	}

	/**
	 * Process POST request
	 */
	function process() {
		if ( ! ( $action = ( $_POST[ 'emeon_form_action' ] ?? false ) ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST[ '__nonce' ] ?? false, EMEON_SLUG ) ) {
			$_POST[ 'emeon_error' ][] = 'Session expired. Please, try again...';

			return;
		}
		if ( ! method_exists( $this, $action ) ) {
			$_POST[ 'emeon_error' ][] = '[ERR1586] Action not found!';

			return;
		}
		$this->{$action}();
	}

	/**
	 * Safely render Emeon form and errors if any
	 *
	 * @param array $attributes
	 *
	 * @return false|string|null
	 */
	function render( $attributes = [] ) {
		$path = EMEON_TPL . '/forms/' . ( $attributes[ 'form' ] ?? 'unknown' ) . '.php';
		if ( ! file_exists( $path ) ) {
			return null;
		}
		ob_start();
		include $path;
		if ( $errors = ( $_POST[ 'emeon_error' ] ?? false ) ) : ?>
			<div class="emeon-error">
				<div class="error-icon"></div>
				<div class="error-content">
					<p>
						<?= implode( "</p><p>", $errors ) ?>
					</p>
				</div>
				<button class="error-dismiss"></button>
			</div>
			<?php emeon_log( implode( PHP_EOL, $errors ) ); endif;

		return ob_get_clean();
	}

	/** ------------------------------------------------------------------------------------------------ ACTIONS --- */

	/**
	 * Join action
	 */
	protected function join() {
		if ( ! ( $email = $_POST[ 'email' ] ) ||
		     ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$_POST[ 'emeon_error' ][] = 'The email you entered is invalid. Please, try again.';

			return;
		}
		if ( ( $user = get_user_by( 'email', $email ) ) && ! is_wp_error( $user ) ) {
			$_POST[ 'emeon_error' ][] = 'User with this email already registered. Please, <a href="/login/">login</a>.';

			return;
		}
		$pass = wp_generate_password( 6 );
		$UID  = wp_create_user( $email, $pass, $email );
		if ( is_wp_error( $UID ) ) {
			$_POST[ 'emeon_error' ][] = $UID->get_error_message() . ' Please, try again.';

			return;
		}
		wp_send_new_user_notifications( $UID );
		wp_safe_redirect( '/login?uid=' . $UID );
		exit;
	}

	/**
	 * Login action
	 */
	protected function login() {
		if ( ! ( $email = $_POST[ 'email' ] ) ||
		     ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$_POST[ 'emeon_error' ][] = 'The email you entered is invalid. Please, try again.';

			return;
		}
		if ( ! ( $user = get_user_by( 'email', $email ) ) || is_wp_error( $user ) ) {
			$_POST[ 'emeon_error' ][] = 'User with email "' . $email . '" is not registered!';

			return;
		}
		$remains = get_user_meta( $user->ID, '_login_remaining_attempts', true );
		if ( false === $remains ) {
			$remains = 5;
		}
		if ( ! $remains ) {
			$_POST[ 'emeon_error' ][] = 'Unfortunately you have missed all attempts for login. Please, try to ' .
			                            '<a href="/recover/">recover</a>. If you still experience troubles with login in, drop us a ' .
			                            'line to <a href="mailto:info@emeon.io">info@emeon.io</a>';

			return;
		}
		$auth = wp_authenticate( $user->user_login, $_POST[ 'pass' ] );
		if ( ! $auth || is_wp_error( $auth ) ) {
			-- $remains;
			update_user_meta( $user->ID, '_login_remaining_attempts', $remains );
			$_POST[ 'emeon_error' ][] = 'Invalid password. Remaining attempts: ' . ( $remains + 1 ) . 'Please, try again.';

			return;
		}
		wp_set_current_user( $auth->ID );
		wp_set_auth_cookie( $auth->ID, $_POST[ 'remember' ] ?? false );
		wp_safe_redirect( '/account/' );
		exit;
	}

	protected function captcha() {

	}

	/**
	 * Adedit action
	 */
	protected function adedit() {
		$text_to_analyze =
			$_POST[ 'article' ][ 'title' ] . ' ' . $_POST[ 'article' ][ 'excerpt' ] . ' ' . $_POST[ 'article' ][ 'content' ] . ' ' .
			implode( " ", $_POST[ 'article' ][ 'tags' ] ) . ' ' . implode( " ", $_POST[ 'article' ][ 'categories' ] );
		$user            = get_user_by( 'ID', get_current_user_id() );
		$post_status     = wp_check_comment_disallowed_list(
			$user->display_name, $user->user_email, '', $text_to_analyze, '', ''
		) ? 'moderation' : 'publish';
		$tags            = $_POST[ 'article' ][ 'tags' ];
		$cats            = $_POST[ 'article' ][ 'categories' ];
		$post_id         = (int) $_POST[ 'article' ][ 'id' ];
		$post_data       = [
			'post_title'   => $_POST[ 'article' ][ 'title' ],
			'post_excerpt' => $_POST[ 'article' ][ 'excerpt' ],
			'post_content' => $_POST[ 'article' ][ 'content' ],
			'post_status'  => $post_status,
			'post_author'  => $user->ID
		];
		if ( $post_id ) {
			$post_data[ 'ID' ] = $post_id;
			wp_update_post( $post_data );
		} else {
			$post_id = wp_insert_post( $post_data );
		}
		if ( ! $post_id || is_wp_error( $post_id ) ) {
			$error = ( is_wp_error( $post_id ) ? $post_id->get_error_message() : 'Unknown error occurred.' );

			return $_POST[ 'emeon_error' ][] =
				$error . ' Please, contact us asap: <a href="mailto:admin@emeon.io">admin@emeon.io</a>';
		}

		// Cats and tags
		$_POST[ 'ID' ] = $post_id;
		wp_set_post_tags( $post_id, $tags, 'post_tag' );
		wp_set_post_categories( $post_id, $cats );

		// Contacts
		$contacts = [];
		foreach ( [ 'email', 'phone', 'urls' ] as $contact ) {
			$contacts[ $contact ] = $_POST[ 'article' ][ $contact ] ?? '';
		}
		update_post_meta( $post_id, 'emeon_contacts', $contacts );

		// Salary and experience
		update_post_meta( $post_id, 'emeon_salary', $_POST[ 'article' ][ 'salary' ] );
		update_post_meta( $post_id, 'emeon_experience', $_POST[ 'article' ][ 'experience' ] );

		// Image and attachment
		foreach ( [ 'article_image', 'article_attachment' ] as $file_id ) {
			if ( is_uploaded_file( $_FILES[ $file_id ][ 'tmp_name' ] ) ) {
				if ( ! function_exists( 'wp_handle_upload' ) ) {
					include ABSPATH . '/wp-admin/includes/file.php';
					include ABSPATH . '/wp-admin/includes/image.php';
				}
				$file = wp_handle_upload( $_FILES[ $file_id ], [ 'test_form' => false ] );
				if ( isset( $file[ 'error' ] ) ) {
					return $_POST[ 'emeon_error' ][] = $file[ 'error' ];
				}
				$name       = $_FILES[ $file_id ][ 'name' ];
				$ext        = pathinfo( $name, PATHINFO_EXTENSION );
				$name       = wp_basename( $name, ".$ext" );
				$url        = $file[ 'url' ];
				$type       = $file[ 'type' ];
				$file       = $file[ 'file' ];
				$title      = sanitize_text_field( $name );
				$attachment = [
					'post_mime_type' => $type,
					'guid'           => $url,
					'post_parent'    => $post_id,
					'post_title'     => $title,
					'post_content'   => '',
				];
				// Save the attachment metadata.
				$attachment_id = wp_insert_attachment( $attachment, $file, $post_id, true );
				if ( ! is_wp_error( $attachment_id ) ) {
					wp_update_attachment_metadata(
						$attachment_id, wp_generate_attachment_metadata( $attachment_id, $file )
					);
					if ( 'article_image' === $file_id ) {
						set_post_thumbnail( $post_id, $attachment_id );
					} else {
						update_post_meta( $post_id, 'emeon_attachment', $attachment_id );
					}
				}
			}
		}


		wp_safe_redirect( '/account/' );
		exit;
	}

};
