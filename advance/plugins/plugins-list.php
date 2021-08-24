<?php
/**
 * TGMPA plugin installer config
 */
function emeon_register_required_plugins() {
	/**
	 * Array of configuration settings. Amend each line as needed.
	 */

	tgmpa(
		array(
			array(
				'name'               => esc_html__( 'SKT Templates – Elementor & Gutenberg templates', 'emeon' ),
				'slug'               => 'skt-templates',
				'required'           => false,
				'version'            => EMEON_MIN_COMPANION_VERSION,
				'force_activation'   => false,
				'force_deactivation' => false,
			)
		)
	);
}


add_action('tgmpa_register', 'emeon_register_required_plugins');