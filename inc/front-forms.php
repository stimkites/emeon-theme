<?php
/**
 * Forms rendering and processing
 */

new class {

	/**
     * HTML we have already built (RAM optimizations)
     *
	 * @var array
	 */
    private static $html = [];

	function __construct() {

		// Register custom post statuses and primary categories
		add_action( 'init',                 __CLASS__ . '::register'    );

		// Render forms
		add_shortcode( 'emeon_forms',       __CLASS__ . '::render'      );

		// Process forms
		add_action( 'template_redirect',    __CLASS__ . '::process'     );

		// Contact fields in admin
		add_action( 'add_meta_boxes_post',  __CLASS__ . '::add_fields'  );
		add_action( 'save_post',            __CLASS__ . '::save_fields' );

		// Enqueue form scripts
		add_action( 'wp_enqueue_scripts',   __CLASS__ . '::enqueue'     );

		// Admin scripts and styles
		add_action( 'admin_enqueue_scripts', __CLASS__ . '::enqueue_admin' );

		// Adedit form permalink
		add_filter( 'emeon_adedit_url',     __CLASS__ . '::get_adedit_url' );

		// All categories/tags selectors
		add_filter( 'emeon_cats',       __CLASS__ . '::fetch_cats',     10, 2 );
		add_filter( 'emeon_tags',       __CLASS__ . '::fetch_tags',     10, 2 );
		add_filter( 'emeon_search',     __CLASS__ . '::search_terms',   10, 2 );

		// Apply filters on search/filter
		add_filter( 'pre_get_posts', __CLASS__ . '::apply_filters' );

	}

	/**
	 * Apply filtering
	 *
	 * @param WP_Query $search
     *
     * @return WP_Query
	 */
	static function apply_filters( $search ){
		if( ! isset( $_GET['f'] ) ) return $search;
		if( ! empty( $_GET['f']['cats'] ) )
			$search->set( 'tax_query', [
				[
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $_GET['f']['cats'],
					'operator'=> 'IN'
				]
			] );
		$meta_query = [];
		if( isset( $_GET['f']['sal'] ) )
			$meta_query[] = [
				'meta_key'      => 'emeon_salary',
				'meta_value'    => $_GET['f']['sal'],
				'operator'      => '>='
			];
		if( isset( $_GET['f']['exp'] ) )
			$meta_query[] = [
				'meta_key'      => 'emeon_experience',
				'meta_value'    => $_GET['f']['exp'],
				'operator'      => '>='
			];
		if( ! empty( $meta_query ) )
			$search->set( 'meta_query', $meta_query );

		return $search;
	}

	/**
	 * Make unique terms by slug
	 *
	 * @param array $terms
	 *
	 * @return array
	 */
	private static function unique_terms( $terms = [] ){
		$filtered = [];
		foreach( $terms as $term )
			if( ! isset( $filtered[ $term->slug ] ) )
				$filtered[ $term->slug ] = $term;
		return $filtered;
	}

	/**
	 * Re-sort an array of terms
	 *
	 * @param $terms
	 *
	 * @return mixed
	 */
	private static function resort( $terms = [] ){
		$terms = self::unique_terms( $terms );
		uasort( $terms, function( $a, $b ){ return strcmp( $a->slug, $b->slug ); } );
		return $terms;
	}

	/**
	 * Fetch all possible terms for Emeon
	 *
	 * @param string $html
	 * @param string $search
	 *
	 * @return mixed|string|null
	 */
	static function search_terms( $html = '', $search = '' ){
		if( null !== ( self::$html['all'] ?? null ) )
			return self::$html['all'];
		$all = self::resort( array_merge(
			self::fetch_cats( '', [ 1 ], true ),
			self::fetch_tags( '', [ 1 ], true )
		) );

		$selected = self::$html['all'] = '';

		foreach ( $all as $cat )
			self::$html['all'] .=
				'<option value="' . $cat->name . '" ' .
					( ( $selected = $cat->name == $search ) ? 'selected' : '' ) . '>' .
					$cat->name .
				'</option>';
		if( ! $selected && $search )
			self::$html['all'] .= '<option value="' . $search . '" selected>' . $search . '</option>';
		elseif( ! $search )
			self::$html['all'] .= '<option value="" selected></option>';
		return $html . self::$html['all'];
	}


	/**
	 * Render all categories for front-end selectors as options
	 *
	 * @param string $html
	 * @param null | array $post_cats
	 * @param bool $raw Whenever we return HTML or array of items
	 *
	 * @return array | string
	 */
	static function fetch_cats( $html = '', $post_cats = null, $raw = false ){
		if( ! empty( self::$html['cats'] ) && ! $raw )
			return self::$html['cats']; // Already in Ram

		self::$html['cats'] = '';

		if( empty( $post_cats ) ) {
			global $post;
			if( ! empty( $post ) )
				$post_cats  = wp_get_post_categories( $post->ID );
			else
				$post_cats = $_POST['s'] ?? [];
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
			'hide_empty' => false
		];

		$terms = get_terms( $cats_args );

		if( $raw )
			return $terms;

		foreach ( self::resort( $terms ) as $cat )
			self::$html['cats'] .=
				'<option value="' . $cat->term_id . '" ' .
		            ( in_array( $cat->term_id, $post_cats ?? [] ) ? 'selected' : '' ) . '>' .
		            $cat->name .
	            '</option>';

		return $html . self::$html['cats'];
	}

	/**
	 * Collect all tags/post tags for the front-end
	 *
	 * @param string $html
	 * @param null $post_tags
	 * @param bool $raw
	 *
	 * @return mixed|string
	 */
	static function fetch_tags( $html = '', $post_tags = null, $raw = false ){
		if( ! empty( self::$html['tags'] ) && ! $raw )
			return self::$html['tags']; // Already in Ram

		self::$html['tags'] = '';

		if( empty( $post_tags ) ) {
			global $post;
			if( ! empty( $post ) )
				$post_tags  = wp_get_post_tags( $post->ID, [ 'fields' => 'ids' ] );
			else
				$post_tags = $_POST['s'] ?? [];
		}
		$tags_args = [
			'taxonomy'   => 'post_tag',
			'hide_empty' => false
		];

		$terms = get_terms( $tags_args );

		if( $raw )
			return $terms;

		foreach ( self::resort( $terms ) as $tag )
			self::$html['tags'] .= '<option value="' . $tag->slug . '" ' .
			     ( in_array( $tag->term_id, $post_tags ?? [] ) ? 'selected' : '' ) . '>' .
			     $tag->name .
			     '</option>';

		return $html . self::$html['tags'];
	}

	/**
	 * Permalink to the adedit form
	 *
	 * @param string $value
	 *
	 * @return false|string
	 */
	static function get_adedit_url( $value = '' ) {
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
	static function register() {
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
	static function enqueue_admin() {
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
	static function enqueue() {
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
			[ 'jquery-core', 'select2' ],
			filemtime( EMEON_PATH . '/js/front-forms.js' ),
			true
		);
		wp_localize_script( $slug, '__emeon', ['ajax_url' => admin_url( 'admin-ajax.php' ), 'n' => wp_create_nonce( EMEON_SLUG ) ] );
		wp_enqueue_script( $slug );
	}

	/**
	 * Add meta box with the contact info to posts
	 */
	static function add_fields() {
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
	static function save_fields( $post_id ) {
		if ( ! isset( $_POST[ 'emeon_contacts' ] ) ) {
			return;
		}
		update_post_meta( $post_id, 'emeon_contacts',   $_POST[ 'emeon_contacts' ]   ?? [] );
		update_post_meta( $post_id, 'emeon_attachment', $_POST[ 'emeon_attachment' ] ?? '' );
		update_post_meta( $post_id, 'emeon_salary',     $_POST[ 'emeon_salary' ]     ?? '' );
		update_post_meta( $post_id, 'emeon_experience', $_POST[ 'emeon_experience' ] ?? '' );
	}

	/**
	 * Process POST request
	 */
	static function process() {
		if ( ! ( $action = ( $_POST[ 'emeon_form_action' ] ?? false ) ) ) {
			return;
		}
		if ( ! wp_verify_nonce( $_POST[ '__nonce' ] ?? false, EMEON_SLUG ) ) {
			$_POST[ 'emeon_error' ][] = 'Session expired. Please, try again...';

			return;
		}
		if ( ! method_exists( __CLASS__, $action ) ) {
			$_POST[ 'emeon_error' ][] = '[ERR1586] Action not found!';

			return;
		}
		self::{$action}();
	}

	/**
	 * Safely render Emeon form and errors if any
	 *
	 * @param array $attributes
	 *
	 * @return false|string|null
	 */
	static function render( $attributes = [] ) {
		$path = EMEON_TPL . '/forms/' . ( $attributes[ 'form' ] ?? 'unknown' ) . '.php';
		if ( ! file_exists( $path ) ) {
			return null;
		}
		ob_start();
		include $path;
		if ( $errors = ( $_POST[ 'emeon_error' ] ?? [] ) ) : ?>
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
	protected static function join() {
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
	protected static function login() {
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

	/**
	 * Adedit action
	 */
	protected static function adedit() {
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
			'post_title'   => esc_html( $_POST[ 'article' ][ 'title' ] ),
			'post_excerpt' => esc_html( $_POST[ 'article' ][ 'excerpt' ] ),
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
		$salary = sanitize_key( $_POST[ 'article' ][ 'salary' ] );
		$experience = sanitize_key( $_POST[ 'article' ][ 'experience' ] );
		update_post_meta( $post_id, 'emeon_salary', $salary );
		update_post_meta( $post_id, 'emeon_experience', $experience );

		// Notify admin
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'From: Emeon <info@emeon.io>' . "\r\n";
		$post_data[] = $cats;
		$post_data[] = $tags;
		$post_data[] = $contacts;
		$post_data[] = $salary;
		$post_data[] = $experience;
 		wp_mail(
			get_option( 'admin_email' ),
			'New entry: ' . $post_data['post_title'] . ' ' . $post_id,
			implode( "<br><br>", $post_data ),
			$headers
		);

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
