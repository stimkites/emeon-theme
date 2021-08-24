<?php

/**
 * Framework class, to keep all settings encapsulated
 * Access to this singleton is via global $emeon_a13
 */
class Emeon_Framework
{

    /**
     * current theme settings
     * @var array
     */
    private $theme_options = array();

    /**
     * Array of meta fields that depends on global settings
     * @var array
     */
    private $parents_of_meta = array();

    /**
     * sets of settings to be used across theme & plugins
     * @since 2.3.0
     * @var array
     */
    private $settings_set = array();

    /**
     * structure of customizer panels, sections & fields
     * @var array
     */
    private $customizer_sections = array();

    /**
     * all default values for theme options
     * @var array
     */
    public $theme_options_defaults = array();

    /**
     * Array of default values of meta fields on current screen
     * @var array
     */
    public $defaults_of_meta = array();

    /**
     * Switch if CSS from theme options should be rebuild
     * @var bool
     */
    private $reset_user_css = false;

    /**
     * Used while saving options to compare CPT rewrites slugs
     * @var array
     */
    private $pre_save_slugs = array();


    /**
     * kind of constructor
     */
    function emeon_start()
    {
        /**
         * Define bunch of helpful paths and settings
         */
        define('EMEON_TPL_SLUG', 'emeon');//it is not always same as directory of theme
        define('EMEON_OPTIONS_NAME_PART', 'emeon');
        define('EMEON_THEME_ID_NUMBER', '66');
        define('EMEON_OPTIONS_NAME', 'skt13_option_emeon');
        define('EMEON_CACHE', 'skt13_emeon_cache');
        define('EMEON_THEME_VERSION', '1.0');
        define('EMEON_THEME_VER', EMEON_THEME_VERSION ); //legacy - do not use
        define('EMEON_MIN_COMPANION_VERSION', '1.0');
        define('EMEON_MIN_PHP_VERSION', '5.6');
        define('EMEON_MIN_WP_VERSION', '5.0');

        //theme root
        define('EMEON_TPL_URI', get_template_directory_uri());

        //plugins recommended by theme
        define('EMEON_TPL_PLUGINS', EMEON_TPL_URI . '/advance/plugins');
        define('EMEON_TPL_PLUGINS_DIR', get_template_directory() . '/advance/plugins');

        //misc theme globals
        define('EMEON_INPUT_PREFIX', 'a13_');
        define('EMEON_CONTENT_WIDTH', 800);

        //check minimal requirements for WordPress and PHP
        if (
            version_compare( $GLOBALS['wp_version'], EMEON_MIN_WP_VERSION, '<' )
            ||
            version_compare( PHP_VERSION, EMEON_MIN_PHP_VERSION, '<' )
        ) {
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/compatibility');
            //no further processing
            return;
        }


        // ADD CUSTOMIZER SUPPORT
        if( is_customize_preview() ){
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/customizer');
            add_action( 'wp_loaded', array( $this, 'emeon_customizer_wp_loaded' ) );
            //before save
            add_action('customize_save', array($this, 'emeon_customizer_customize_save_before'));
            //perform option save while using customizer
            add_action('customize_save_after', array($this, 'emeon_customizer_customize_save_after'));
        }


        // ADMIN PART
        if ( is_admin() ) {
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/admin/admin');
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/admin/metaboxes');
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/meta');
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/admin/print', 'options'); 

            // ADD ADMIN THEME PAGES
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/admin/emeoninfo', 'pages');
            /** @noinspection PhpIncludeInspection */
			
			get_template_part('advance/admin/emeoninfo-pages-functions');

            //ADD EXTERNAL PLUGINS
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/inc/class-tgm-plugin-activation');
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/plugins/plugins', 'list');
			

            // Warnings and notices that only admin should handle
            if (current_user_can('update_core')) {
                add_action( 'admin_notices', array(&$this, 'emeon_check_for_warnings') );
            }
        }

        // THEME FRONT-END SCRIPTS & STYLES
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/head-scripts-styles');

        //special files depending on framework generator needs
        get_template_part('advance/emeon');  

        // UTILITIES
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/core');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/core_fe');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/menu');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/media');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/posts');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/layout', 'parts'); 
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/header');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/footer');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/password');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/feature');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/cpt');
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/utilities/deprecated');

        //WPML
        if(defined( 'ICL_SITEPRESS_VERSION')){
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/utilities/wpml');
        }
        //WOOCOMMERCE
        if(emeon_is_woocommerce_activated()){
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/utilities/woocommerce');
        }

        $this->prepare_theme_vars();

        // ADD WPBakery Page Builder ADDONS
        if ( defined( 'WPB_VC_VERSION' ) ){
            //since VC 5.5.2 it should be load always
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/vc', 'extend');
        }

        //support for Elementor Pro locations
        if ( defined( 'ELEMENTOR_PRO_VERSION' ) ){
            /** @noinspection PhpIncludeInspection */
			get_template_part('advance/elementor', 'pro');
        }

        // ADD SIDEBARS
        /** @noinspection PhpIncludeInspection */
		get_template_part('advance/sidebars');

        // AFTER SETUP(supports for thumbnails, menus, languages, RSS etc.)
        add_action('after_setup_theme', array(&$this, 'emeon_setup'));
    }

    /**
     * registers panels, sections & fields for customizer. Prepares default values for theme options
     *
     * @param $section array of panel details OR section details & fields
     */
    function emeon_set_sections($section){
        /**
         * @since 2.3.0
         */
        do_action( 'emeon_options_before_'.$section['id'] );

        //we need whole structure only when customizer is used
        if(is_customize_preview()){
            //section
            if(isset($section['subsection'])){
                end($this->customizer_sections);
                $key = key($this->customizer_sections);
                $this->customizer_sections[$key]['sections'][] = $section;
            }
            //panel
            else{
                $this->customizer_sections[] = $section;
            }
        }

        //collect default values
        if(isset($section['fields']) && is_array($section['fields']) && ! empty( $section['fields'] )){
            foreach($section['fields'] as $params ){
                //if we don't have such default yet, use default defined in framework
                if( !array_key_exists($params['id'], $this->theme_options_defaults) ){
                    $this->theme_options_defaults[$params['id']] = isset($params['default'])? $params['default'] : '';
                }
            }
        }

        /**
         * @since 2.3.0
         */
        do_action( 'emeon_options_after_'.$section['id'] );
    }


    /**
     * returns panels, sections & fields for customizer
     */
    function emeon_get_sections(){
        return $this->customizer_sections;
    }


    /**
     * Set predefined set of settings for later use
     *
     * @param $set string set name
     * @param $values array array of set values
     *
     * @return array
     */
    function emeon_set_settings_set($set, $values){
        return $this->settings_set[$set] = $values;
    }

    /**
     * Returns predefined set of settings
     * @since 2.3.0
     */
    function emeon_get_settings_set($set){
        return $this->settings_set[$set];
    }


    /**
     * used in customizer to prepare settings after refresh in customizer
     */
    function emeon_customizer_wp_loaded() {
        $this->theme_options = get_option(EMEON_OPTIONS_NAME);
        $this->load_options();
    }

    /**
     * What to do before saving in customizer
     */
    function emeon_customizer_customize_save_before()
    {
        //get old set of options
        $this->theme_options = get_option(EMEON_OPTIONS_NAME);
        $this->load_options();
    }

    /**
     * Refresh options and generate user.css file after save in customizer
     */
    function emeon_customizer_customize_save_after()
    {
        //get new set of options
        $this->theme_options = get_option(EMEON_OPTIONS_NAME);
        $this->load_options();

        do_action( 'emeon_generate_user_css' );

        //refresh cache
        delete_option(EMEON_CACHE);
    }

    /**
     * Various setup actions for setting up theme for WordPress
     */
    function emeon_setup()
    {
        global $content_width;
        //content width
        if (!isset($content_width)) {
            $content_width = EMEON_CONTENT_WIDTH;
        }


        if (
            //forced refresh
            $this->reset_user_css ||
            //on fresh theme install
            ( function_exists('emeon-a13fe_user_css_name') && ! file_exists( emeon-a13fe_user_css_name() ) ) ||
            //or customizer update after giving creds to FTP
             (is_admin() && get_option('a13_user_css_update') === 'on')
        ) {
            do_action( 'emeon_generate_user_css' );
        }



        //LANGUAGE
        load_theme_textdomain( 'emeon', get_theme_file_path( 'languages' ) );

        //remove admin bar bump
        add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );

        // Featured image support
        add_theme_support('post-thumbnails');

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        //Let WordPress manage the document title.
        add_theme_support('title-tag');
        // Switches default core markup for search form, comment form, and comments
        // to output valid HTML5.
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

        // WooCommerce support
        add_theme_support('woocommerce');
        //new thumbs in WooCommerce 3.0.0
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        // Indicate widget sidebars can use selective refresh in the Customizer.
        add_theme_support( 'customize-selective-refresh-widgets' );

        //below thing doesn't exist, it is left here for reference
        //our menu are NOT reloaded partially cause we use custom Walker, and then Customizer uses full refresh

        add_theme_support( 'custom-logo', array(
            'height'      => 75,
            'width'       => 200,
            'flex-height' => true,
            'flex-width'  => true
        ) );

        //Header Footer Elementor Plugin support
        add_theme_support( 'header-footer-elementor' );

        // Register custom menu positions
        register_nav_menus(array(
            'header-menu' => __( 'Site Navigation', 'emeon' ),
        ));
    }

    /**
     * Function for warnings that should be displayed in admin area
     */
    function emeon_check_for_warnings()
    {
        $notices = array();
        $valid_tags = array(
            'a' => array(
                'href' => array(),
            ),
        );
        // Notice if dir for user settings is no writable

        wp_reset_postdata();

        // Display all error notices
        foreach ($notices as $id => $notice) {
            //show notice only if it wasn't dismissed by user
            if( !emeon_is_admin_notice_active($id) ){
                continue;
            }
            echo '<div class="a13fe-admin-notice notice notice-error is-dismissible" data-notice_id="'.esc_attr($id).'"><p>' . wp_kses( $notice, $valid_tags ) . '</p></div>';
        }

        do_action( 'emeon_theme_notices' );
    }

    /**
     * Prepare all theme settings to be ready for read
     */
    public function load_options()
    {
        //prepare custom sidebars
        if ( isset($this->theme_options['custom_sidebars']) && is_array($this->theme_options['custom_sidebars'])) {
            $tmp = array();
            foreach ($this->theme_options['custom_sidebars'] as $id => $sidebar) {
                //skip if left empty or not set name
                if($sidebar === NULL || strlen($sidebar) === 0){
                    continue;
                }
                array_push($tmp, array('id' => 'sktwb-sidebar_' . (1 + $id), 'name' => $sidebar));
            }
            $this->theme_options['custom_sidebars'] = $tmp;
        }
        else{
            $this->theme_options['custom_sidebars'] = array();
        }

        //fill missing options with defaults
        foreach($this->theme_options_defaults as $id => $value ){
            if(!array_key_exists($id, $this->theme_options)){
                $this->theme_options[$id] = $value;
            }
        }

        //in customizer or importer we need defaults for longer
        if( !is_admin() && !is_customize_preview() ){
            //save memory
            unset($this->theme_options_defaults );
        }

        //finally loaded options
    }

    /**
     * Overwrite current theme settings
     *
     * @param array $overload_options options we want to set
     */
    public function set_options( $overload_options = array() )
    {
        if( is_array($overload_options) && count($overload_options) > 0){
            update_option(EMEON_OPTIONS_NAME, $overload_options);

            $this->theme_options = $overload_options;

            //refresh
            $this->load_options();

            //refresh cache
            delete_option(EMEON_CACHE);
        }
    }

    /**
     * Get one of theme settings
     *
     * @param string $index   setting id
     *
     * @param string $default default setting when option is not present
     *
     * @param bool   $filter should filter be used
     *
     * @return mixed
     */
    public function get_option($index, $default = '', $filter = true)
    {
        $option_to_return = $default;
        if ($index != '' && isset($this->theme_options[$index])) {
            $option_to_return = $this->theme_options[$index];
        }

        //for customizer we don't use filters as it mess controls behaviour.
        //JavaScript can't know about changes in filters, so it hides/shows options, and PHP then reverts this cause of filter actions
        //good and only example is vertical header in boxed layout
        if(!$filter){
            return $option_to_return;
        }
        //apply filters to returned value if some special treating is needed
        return apply_filters('emeon_a13_options_'.$index, $option_to_return );
    }

    /**
     * Get url only from media type theme setting
     *
     * @param string $index setting id
     *
     * @return string URL
     */
    public function get_option_media_url($index)
    {
        $option = $this->get_option($index);
        if (is_array($option)) {
            if (isset($option['url'])) {
                return $option['url']; //we got URL
            } else {
                return ''; //empty string as it is probably not set yet
            }
        }
        elseif( is_string($option) && ( strlen($option) > 0 ) ){
            if(strncmp($option, "http", 4) !== 0){
                //make absolute path of possibly relative path(used for starer data)
                $option = EMEON_TPL_URI . $option;
            }
        }

        return $option;//not an array? then probably it is saved as string
    }


    /**
     * Get rgba only from color type theme setting
     *
     * @param string $index setting_id
     *
     * @return string URL
     */
    public function get_option_color_rgba( $index )
    {
        $option = $this->get_option( $index );
        if ( is_array( $option ) ) {
            if ( isset( $option['rgba'] ) ) {
                return $option['rgba']; //we got RGBA
            } elseif ( isset( $option['color'] ) && isset( $option['alpha'] ) ) {
                return emeon_hex2rgba( $option['color'], $option['alpha'] ); //we got RGBA
            } else {
                return ''; //empty string as it is probably not set yet
            }
        }

        return $option;//not an array? then probably it is saved as string
    }

    /**
     * Get all settings. Used for exporting theme options
     *
     * @return array
     */
    public function get_options_array()
    {
        return $this->theme_options;
    }



    /**
     * Get all settings. Used for exporting theme options
     *
     * @return array
     */
    public function prepare_options_array()
    {
        //set defaults values for all fields from theme specific defaults
        $file = get_theme_file_path( 'default-settings/default.php');
        if(file_exists($file)){
            /** @noinspection PhpIncludeInspection */
            $file_contents = include $file; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
            $options = json_decode($file_contents, true);

            //SET THEME OPTIONS without saving to database
            $this->theme_options_defaults = $options;
        }

        //collect sections & framework defaults
        /** @noinspection PhpIncludeInspection */
        get_template_part('advance/theme', 'options'); 

        //set default setting if there is none(fresh install)
        if($this->theme_options === false){
            $this->theme_options = $this->theme_options_defaults;
            $this->load_options();
            $this->reset_user_css = true;
        }
        //normal flow, setup options
        else{
            $this->load_options();
        }
    }

    /**
     * Prepares var $parents_of_meta
     */
    private function collect_meta_parents()
    {
        /** @noinspection PhpIncludeInspection */
        require_once get_template_directory() . '/advance/meta.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

        $option_func = array(
            'post',
            'page',
//            'images_manager' //no parent options here
        );

        foreach ($option_func as $function) {
            $function_to_call = 'emeon_meta_boxes_' . $function;
            $family = str_replace('_layout', '', $function); //for consistent families

            if(function_exists($function_to_call)){
                foreach ( $function_to_call() as $meta_tab ) {
                    foreach( $meta_tab as $meta ) {
                        if (isset($meta['global_value'])) {
                            $this->parents_of_meta[$family][$meta['id']]['global_value'] = $meta['global_value'];
                        }
                        if (isset($meta['parent_option'])) {
                            $this->parents_of_meta[$family][$meta['id']]['parent_option'] = $meta['parent_option'];
                        }
                    }
                }
            }
        }
    }

    /**
     * Prepares list off all meta fields that have visibility dependencies and second list of possible switches with dependent fields
     */
    public function get_meta_required_array() {
        global $pagenow;
        $list_of_requirements = array();
        $list_of_dependent    = array();
        $meta_boxes           = array();


        $post_type = '';
        if ('post.php' == $pagenow && isset($_GET['post']) ) {
            // Will occur only in this kind of screen: /wp-admin/post.php?post=285&action=edit
            // and it can be a Post, a Page or a CPT
            $post_type = get_post_type( sanitize_text_field( wp_unslash( $_GET['post'] ) ) );
        }
        //if it is "new post" page
        elseif('post-new.php' == $pagenow ) {
            $post_type = isset($_GET['post_type']) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : 'post';
        }

        if(strlen($post_type)){
            switch ( $post_type ) {
                case 'post':
                    $meta_boxes = emeon_meta_boxes_post();
                    break;
                case 'page':
                    $meta_boxes = emeon_meta_boxes_page();
                    break;
            }

            foreach ( $meta_boxes as $meta_tab ) {
                foreach( $meta_tab as $meta ) {
                    //check is it prototype
                    if ( isset( $meta['required'] ) ) {
                        $required = $meta['required'];

                        //fill list of required condition for each control
                        $list_of_requirements[ $meta['id'] ] = $required;

                        //fill list of controls that activate/deactivate other
                        //we have more then one required condition
                        if(is_array($required[0]) ){
                            foreach($required as $dependency){
                                $list_of_dependent[$dependency[0]][] = $meta['id'];
                            }
                        }
                        //we have only one required condition
                        else{
                            $list_of_dependent[$required[0]][] = $meta['id'];
                        }
                    }
                }
            }
        }

        return array($list_of_requirements, $list_of_dependent);
    }

    public function prepare_theme_vars(){
        $cache = get_option( EMEON_CACHE );

        if( is_customize_preview() ){
            //load textdomain early as we optimize reading of options file
            load_theme_textdomain( 'emeon', get_theme_file_path( 'languages' ) );

            $this->prepare_options_array();
            $this->collect_meta_parents();
        }
        //cache miss or translation plugin is active(WPML or Polylang)
        elseif( $cache === false || $cache['version'] !== EMEON_THEME_VERSION || defined( 'ICL_SITEPRESS_VERSION') || defined( 'POLYLANG_BASENAME' ) ){
            //get theme options from database
            $this->theme_options = get_option(EMEON_OPTIONS_NAME);

            //fresh install
            if($this->theme_options === false ){
                $this->prepare_options_array();
                $this->collect_meta_parents();
            }
            //normal flow
            else{
                $this->prepare_options_array();
                $this->collect_meta_parents();

                //cache collected values
                $cache = array(
                    'options' => $this->theme_options,
                    'meta'    => $this->parents_of_meta,
                    'version' => EMEON_THEME_VERSION
                );

                //save cache
                update_option( EMEON_CACHE, $cache );
            }
        }
        //cache hit
        else{
            $this->theme_options = $cache['options'];
            $this->parents_of_meta = $cache['meta'];
        }
    }

    /**
     * Retrieves meta setting with checking for parent settings, and global settings
     *
     * @param string $field name of meta setting
     * @param bool|false $id ID of post. If not passed it will try to get one for current loop
     *
     * @return bool|mixed|null|string field value
     */
    function emeon_get_meta($field, $id = false)
    {
        $family = '';

        if (!$id && emeon_is_no_property_page()) {
            return null; //we can't get meta field for that page
        } else {
            if (!$id) {
                $id = get_the_ID();
            }

            $meta = trim(get_post_meta($id, $field, true));
        }

        if ($id) {
            $post_type = get_post_type($id);
            //get family to check for parent option
            if ($post_type === 'page' ) {
                $family = 'page';
            } elseif (is_single($id)) {
                $family = 'post';
            }

            $field = substr($field, 1); //remove '_'

            //if has any parent
            if (isset($this->parents_of_meta[$family][$field])) {
                $parent = $this->parents_of_meta[$family][$field];

                //meta points to global setting
                if (isset($parent['global_value']) && ($meta == $parent['global_value'] || strlen($meta) == 0)) {
                    if (isset($parent['parent_option'])) {
                        $meta = $this->get_option($parent['parent_option']);
                    }
                }
            }

            return $meta;
        }

        return false;
    }

    /**
     * Returns list of all available in theme social icons with need additional info
     *
     * @param string $what - what should array consist of:
     *                     names    : Readable names
     *                     classes  : CSS classes used on front-end
     *                     empty    : only IDs are returned
     *
     * @return array requested list of social icons
     */
    function emeon_get_social_icons_list($what = 'names'){
        $icons = array(
            /* id         => array(class, label)*/
            '500px'       => array( 'fa fa-500px', '500px' ),
            'behance'     => array( 'fa fa-behance', 'Behance' ),
            'bitbucket'   => array( 'fa fa-bitbucket', 'Bitbucket' ),
            'codepen'     => array( 'fa fa-codepen', 'CodePen' ),
            'delicious'   => array( 'fa fa-delicious', 'Delicious' ),
            'deviantart'  => array( 'fa fa-deviantart', 'Deviantart' ),
            'digg'        => array( 'fa fa-digg', 'Digg' ),
            'dribbble'    => array( 'fa fa-dribbble', 'Dribbble' ),
            'dropbox'     => array( 'fa fa-dropbox', 'Dropbox' ),
            'mailto'      => array( 'fa fa-envelope-o', 'E-mail' ),
            'facebook'    => array( 'fa fa-facebook', 'Facebook' ),
            'flickr'      => array( 'fa fa-flickr', 'Flickr' ),
            'foursquare'  => array( 'fa fa-foursquare', 'Foursquare' ),
            'github'      => array( 'fa fa-git', 'Github' ),
            'googleplus'  => array( 'fa fa-google-plus', 'Google Plus' ),
            'instagram'   => array( 'fa fa-instagram', 'Instagram' ),
            'lastfm'      => array( 'fa fa-lastfm', 'Lastfm' ),
            'linkedin'    => array( 'fa fa-linkedin', 'Linkedin' ),
            'messenger'   => array( 'fab fa-facebook-messenger', 'Facebook Messenger' ),
            'paypal'      => array( 'fa fa-paypal', 'Paypal' ),
            'pinterest'   => array( 'fa fa-pinterest-p', 'Pinterest' ),
            'reddit'      => array( 'fa fa-reddit-alien', 'Reddit' ),
            'rss'         => array( 'fa fa-rss', 'RSS' ),
            'sharethis'   => array( 'fa fa-share-alt', 'Sharethis' ),
            'skype'       => array( 'fa fa-skype', 'Skype' ),
            'slack'       => array( 'fa fa-slack', 'Slack' ),
            'snapchat'    => array( 'fa fa-snapchat-ghost', 'Snapchat' ),
            'spotify'     => array( 'fa fa-spotify', 'Spotify' ),
            'steam'       => array( 'fa fa-steam', 'Steam' ),
            'stumbleupon' => array( 'fa fa-stumbleupon', 'Stumbleupon' ),
            'tripadvisor' => array( 'fa fa-tripadvisor', 'TripAdvisor' ),
            'tumblr'      => array( 'fa fa-tumblr', 'Tumblr' ),
            'twitter'     => array( 'fa fa-twitter', 'Twitter' ),
            'viadeo'      => array( 'fa fa-viadeo', 'Viadeo' ),
            'vimeo'       => array( 'fa fa-vimeo', 'Vimeo' ),
            'vine'        => array( 'fa fa-vine', 'Vine' ),
            'vkontakte'   => array( 'fa fa-vk', 'VKontakte' ),
            'whatsapp'    => array( 'fa fa-whatsapp', 'Whatsapp' ),
            'wordpress'   => array( 'fa fa-wordpress', 'WordPress' ),
            'xing'        => array( 'fa fa-xing', 'Xing' ),
            'yahoo'       => array( 'fa fa-yahoo', 'Yahoo' ),
            'yelp'        => array( 'fa fa-yelp', 'Yelp' ),
            'youtube'     => array( 'fa fa-youtube', 'YouTube' ),
        );

        $icons = apply_filters('emeon_social_icons_list', $icons );
        $result = array();

        //return classes
        if($what === 'classes'){
            foreach( $icons as $id => $icon ){
                $result[$id] = $icon[0];
            }
        }

        //empty values
        elseif($what === 'empty'){
            foreach( $icons as $id => $icon ){
                $result[$id] = '';
            }
        }

        //return names
        else{
            foreach( $icons as $id => $icon ){
                $result[$id] = $icon[1];
            }
        }

        return $result;
    }


    function emeon_get_standard_fonts_list(){
        return array(
            "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif" => "System Font(Native)",
            "Arial, Helvetica, sans-serif"                                                        => "Arial",
            "'Arial Black', Gadget, sans-serif"                                                   => "Arial Black",
            "'Bookman Old Style', serif"                                                          => "Bookman Old Style",
            "'Comic Sans MS', cursive"                                                            => "Comic Sans MS",
            "Courier, monospace"                                                                  => "Courier",
            "Garamond, serif"                                                                     => "Garamond",
            "Georgia, serif"                                                                      => "Georgia",
            "Impact, Charcoal, sans-serif"                                                        => "Impact",
            "'Lucida Console', Monaco, monospace"                                                 => "Lucida Console",
            "'Lucida Sans Unicode', 'Lucida Grande', sans-serif"                                  => "Lucida Sans Unicode",
            "'MS Sans Serif', Geneva, sans-serif"                                                 => "MS Sans Serif",
            "'MS Serif', 'New York', sans-serif"                                                  => "MS Serif",
            "'Palatino Linotype', 'Book Antiqua', Palatino, serif"                                => "Palatino Linotype",
            "Tahoma,Geneva, sans-serif"                                                           => "Tahoma",
            "'Times New Roman', Times,serif"                                                      => "Times New Roman",
            "'Trebuchet MS', Helvetica, sans-serif"                                               => "Trebuchet MS",
            "Verdana, Geneva, sans-serif"                                                         => "Verdana",
        );
    }

    function emeon_is_companion_plugin_ready($fail_message = false, $silent = false){
        include_once ABSPATH . 'wp-admin/includes/plugin.php';// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
        //just in case have these files included
		require_once ABSPATH . 'wp-admin/includes/file.php';// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		require_once ABSPATH . 'wp-admin/includes/template.php';// phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound

        $plugin_slug = 'skt-templates';
        $plugin_file = 'skt-templates.php';
        $plugin_path = $plugin_slug.'/'.$plugin_file;
        $plugins = get_plugins('/'.$plugin_slug);
        $ready = true;

        //not installed yet plugin
        if ( empty( $plugins[$plugin_file] ) ) {
            $ready = false;

            //we can install it normally
            if ( get_filesystem_method( array(), WP_PLUGIN_DIR ) === 'direct' ) {
                wp_enqueue_script( 'updates' );
                $classes =  ' install-now';
                $href = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin='.esc_attr($plugin_slug) ), 'install-plugin_'.esc_attr($plugin_slug) );
            }
            //we need data from user to install plugin
            else{
                $tgm = TGM_Plugin_Activation::get_instance();
                $href = $tgm->get_tgmpa_url();
            }
            $label = __( 'Install', 'emeon' ) . ' : ' . __( 'SKT Templates – Elementor & Gutenberg templates', 'emeon' );
        }

        //not active
        elseif ( is_plugin_inactive( $plugin_path ) ){
            $ready = false;

            wp_enqueue_script( 'updates' );
            $classes =  ' activate-now';
            $href = wp_nonce_url( self_admin_url( 'plugins.php?action=activate&plugin='.esc_attr($plugin_path) ), 'activate-plugin_'.esc_attr($plugin_path) );
            $label = __( 'Activate', 'emeon' ) . ' : ' . __( 'SKT Templates – Elementor & Gutenberg templates', 'emeon' );
        }

        //not up to date
        elseif( version_compare( $plugins[$plugin_file]['Version'], EMEON_MIN_COMPANION_VERSION, '<'  ) ){
            $ready = false;
            wp_enqueue_script( 'updates' );
            $classes =  ' update-now';
            $href = wp_nonce_url( self_admin_url( 'update.php?action=upgrade-plugin&plugin='.esc_attr($plugin_path) ), 'upgrade-plugin_'.esc_attr($plugin_path) );
            $label = __( 'Update', 'emeon' ) . ' : ' . __( 'SKT Templates – Elementor & Gutenberg templates', 'emeon' );
        }

        if(!$ready && !$silent){
            $message = $fail_message ? $fail_message : __( 'This feature requires SKT Templates plugin to be active and in the proper version.', 'emeon' );

            echo '<p class="center">'.esc_html($message).'</p>';
            /** @noinspection PhpUndefinedVariableInspection */
            echo '
    <div class="plugin-card-skt-templates center">
        <a class="button button-primary button-hero'.esc_attr($classes).'" '.
                 'href="'.esc_url( $href ).'" '.
                 'data-slug="'.esc_attr($plugin_slug).'" '.
                 'data-plugin="'.esc_attr($plugin_path).'" '.
                 '>'.
                 esc_html($label).
         '</a></div>';
        }

        return $ready;
    }
}