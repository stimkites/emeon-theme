<?php
/**
 * Human detection (AND union):
 *  -   .htaccess bot block to /join endpoint (20%)
 *  -   honeypot link in the top (10%)
 *  -   mouse activity, mouse hover event detection on email entering (20%)
 *  -   if email is typed symbol by symbol (40%)
 *  -   if browser ('USER_AGENT') is familiar (5%)
 *  -   if "JOIN" button is actually pressed (not the submit attempt performed) (5%)
 *
 *  If less than 50% covered, we ask to enter captcha before we send password email (and register)
 */

new class {

    function __construct() {
        add_shortcode( 'emeon_forms', [ $this, 'render' ] );
    }

    /**
     * Safely render Emeon form
     *
     * @param array $attributes
     * @return false|string|null
     */
    function render( $attributes = [] ){
        $path = EMEON_TPL . '/forms/' . $attributes['form'] ?? 'unknown' . '.php';
        if( ! file_exists( $path ) ) return null;
        ob_start();
        include $path;
        return ob_get_clean();
    }

};
