<?php
//tags allowed in descriptions
function emeon__no_meta_posts_page_notice() {
    echo '<div class="notice notice-warning inline"><p>' .
         sprintf(
             wp_kses(
                 /* translators: %1$s: link to customizer, %2$s section name */
                 __( 'Theme options for this page can be found in <a href="%1$s">Appearance -&gt; Customize -&gt; %2$s</a>.', 'emeon' ),
                 array(
                     'a'      => array(
                         'href' => array()
                     )
                 )
             ),
             esc_url( admin_url( '/customize.php?autofocus[panel]=section_blog_layout' ) ),
             esc_html__( 'Blog settings', 'emeon' )
         ) . '</p></div>';
}

function emeon__no_meta_shop_page_notice() {
    echo '<div class="notice notice-warning inline"><p>' .
         sprintf(
             wp_kses(
                /* translators: %1$s: link to customizer, %2$s section name */
                 __( 'Theme options for this page can be found in <a href="%1$s">Appearance -&gt; Customize -&gt; %2$s</a>.', 'emeon' ),
                 array(
                     'a'      => array(
                         'href' => array()
                     )
                 )
             ),
             esc_url( admin_url( '/customize.php?autofocus[panel]=section_shop_general' ) ),
             esc_html__( 'Shop(WooCommerce) settings', 'emeon' )
         ) . '</p></div>';
}

/**
 * Meta boxes in different post types
 */
function emeon_admin_meta_boxes(){
    global $emeon_a13;

    if(current_user_can( 'edit_posts' )){
        add_meta_box(
            'sktwb_theme_options',
             __( 'Blog post details', 'emeon' ),
            'emeon_meta_main_opts',
            'post',
            'normal',
            'default',
            array('func' => 'emeon_meta_boxes_post')//callback
        );
    }

    if(current_user_can( 'edit_pages' )){
        //don't display page metaboxes on special pages
        $current_page_id = get_the_ID();
        //blog page
        if($current_page_id == get_option( 'page_for_posts' )){
            add_meta_box(
                'sktwb_theme_options_notice',
                __( 'Page details', 'emeon' ),
                'emeon__no_meta_posts_page_notice',
                'page',
                'normal',
                'default'
            );
        }
        //shop page
        elseif(emeon_is_woocommerce_activated() &&( $current_page_id == wc_get_page_id( 'shop' ) )){
            add_meta_box(
                'sktwb_theme_options_notice',
                __( 'Page details', 'emeon' ),
                'emeon__no_meta_shop_page_notice',
                'page',
                'normal',
                'default'
            );
        }
        else{
            add_meta_box(
                'sktwb_theme_options',
                 __( 'Page details', 'emeon' ),
                'emeon_meta_main_opts',
                'page',
                'normal',
                'default',
                array('func' => 'emeon_meta_boxes_page')//callback
            );
        }
    }

}
add_action( 'add_meta_boxes', 'emeon_admin_meta_boxes');


/**
 * Generates inputs in meta boxes
 *
 * @param object    $post
 * @param array     $meta_box
 */
function emeon_meta_main_opts( $post, $meta_box ){

    // Use nonce for verification
    wp_nonce_field( 'sktwb_customization' , 'sktwb_noncename' );

    $input_prefix = EMEON_INPUT_PREFIX;

    /** @noinspection PhpIncludeInspection */
	get_template_part( 'meta' );
    $callback_name = $meta_box['args']['func'];
    $meta_boxes = $callback_name();

    //collect defaults if it is "new post" page
    global $pagenow, $emeon_a13;
    if('post-new.php' == $pagenow ) {
        foreach ( $meta_boxes as $meta_tab ) {
            foreach( $meta_tab as $meta ) {
                if( isset( $meta['id'] ) ){
                    $emeon_a13->defaults_of_meta[ $meta['id'] ] = isset( $meta['default'] ) ? $meta['default'] : '';
                }
            }
        }
        unset($meta);// be safe, don't loose your hair :-)
    }


    $fieldset_open = false;
    $tabs_to_create = array();

    echo '<div class="sktwb-settings sktwb-metas">';

    foreach ( $meta_boxes as $meta_tab ) {
        foreach( $meta_tab as $meta ) {
            //ASSIGNING VALUE
            $value = '';
            if ( isset( $meta['id'] ) ){
                //get value
                $value = get_post_meta($post->ID, '_'.$meta['id'] , true);

                //use default if no value
                if( !strlen($value) ){
                    $value = ( isset( $meta['default'] )? $meta['default'] : '' );
                }
            }

            $params = array(
                'style' => '',
                'value' => $value
            );

            /*
            * print tag according to type
            */

            if ( $meta['type'] === 'fieldset' ) {
                if ( $fieldset_open ) {
                    echo '</div>';
                }

                $class = 'fieldset static';
                if( isset( $meta['is_prototype'] ) ){
                    $class .= ' prototype';
                }

                if( isset( $meta['tab'] ) && $meta['tab'] === true ){
                    $class .= ' fieldset_tab';
                    $tabs_to_create[] = $meta;
                }

                echo '<div class="'.esc_attr( $class ).'"'.( isset($meta['id'] )? ' id="'.esc_attr( $meta['id'] ).'"' : '' ).'>';

                if( isset( $meta['notice'] ) && strlen($meta['notice']) ){
                    echo '<p class="fieldset_notice">'.wp_kses_data($meta['notice']).'</p>';
                }

                //companion plugin is needed
                if( isset( $meta['companion_required'] ) && $meta['companion_required'] === true ){
                    emeon_is_companion_plugin_ready();
                }

                $fieldset_open = true;
            }

            //checks for all normal options
            elseif( emeon_print_form_controls($meta, $params, true ) ){
                continue;
            }

            /***********************************************
             * SPECIAL field types
             ************************************************/
            elseif ( $meta['type'] === 'multi-upload' ) { ?>

                <div class="a13-mu-container">
                    <input id="a13-multi-upload" class="button button-large button-primary" type="button" value="<?php
                    echo esc_attr( __( 'Select/Upload images and videos', 'emeon' ) );
                    ?>"<?php echo ( isset( $meta['media_type'] ) && strlen( $meta['media_type'] ) ) ?
                        ' data-media-type="'.esc_attr($meta['media_type']) . '"' : ''; ?> />
                    <span class="button button-large add-link-media"><?php esc_html_e( 'Add Video from Youtube/Vimeo', 'emeon' ); ?></span>
                    <label class="button button-large"><input type="checkbox" id="mu-prepend" value="1" /><?php esc_html_e( 'Add items at beginning of the list', 'emeon' ); ?>
                    </label>
                    <input id="a13-multi-remove" class="button button-large" type="button" value="<?php echo esc_attr( __( 'Remove selected', 'emeon' ) ); ?>" disabled="disabled" />
                    <?php

                    do_action('emeon_a13_multi_upload_tools');

                    emeon_input_help_tip( __( 'To mark more items in Media Library and in below list, you can use <code>Ctrl</code>(<code>Cmd</code>) or <code>Shift</code> key while selecting them with mouse.', 'emeon' ));
                    ?>
                    <div id="a13-mu-notice"></div>
                </div>


                <?php
                //hidden textarea with JSON of all images
                echo '<textarea id="' . esc_attr( $input_prefix . $meta['id'] ) . '" name="' . esc_attr( $input_prefix . $meta['id'] ) . '">' . esc_textarea( $value ) . '</textarea>';
                //prototype of single linked item
                echo '<div id="mu-single-item" class="fieldset prototype">'; //hide item
                emeon_admin_gallery_item_html( 'attachment-preview image', 'thumbnail', get_theme_file_uri( 'images/holders/video_150x100.png') );
                echo '</div>';
                ?>
                <ul id="mu-media" class="media-frame-content" data-columns="5">
                    <?php emeon_prepare_admin_gallery_html( emeon_prepare_gallery_attachments( $value ) ); ?>
                </ul><?php
            }
        } //end foreach
    } //end foreach


    unset($meta);// be safe, don't loose your hair :-)

    //close fieldset
    if ( $fieldset_open ) {
	    echo '</div>';
    }

    echo '</div>';//.sktwb-settings .sktwb-metas

    if(count($tabs_to_create)){

        echo '<ul class="meta-tabs">';
        foreach($tabs_to_create as $tab){
            echo '<li><span class="icon '.esc_attr($tab['icon']).'" title="'.esc_attr($tab['name']).'"></span><span class="tab-name">'.esc_html( $tab['name'] ).'</span></li>';
        }
        echo '</ul>';
    }

    echo '<br class="clear" />';
}


/**
 * Saving meta's in post
 *
 * @param int $post_id
 */
function emeon_save_post($post_id){
    static $done = 0;
    $done++;
    if( $done > 1 ){
        return;//no double saving same things
    }

    $input_prefix = EMEON_INPUT_PREFIX;

    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we do not want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if( ! isset( $_POST['sktwb_noncename'] ) )
        return;

    if ( !wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sktwb_noncename'] ) ), 'sktwb_customization' ) )
        return;

	//lets get all fields that need to be saved
    /** @noinspection PhpIncludeInspection */
	get_template_part( 'meta' );

    $meta_boxes = array();
    if( isset( $_POST['post_type'] ) ){
        switch( sanitize_text_field( wp_unslash( $_POST['post_type'] ) ) ){
            case 'post':
                $meta_boxes = emeon_meta_boxes_post();
                break;
            case 'page':
                $meta_boxes = emeon_meta_boxes_page();
                break;
        }

        //saving meta
        $is_prototype = false;
        foreach ( $meta_boxes as $meta_tab ) {
            foreach( $meta_tab as $meta ) {
                //check is it prototype
                if ( $meta['type'] === 'fieldset' ) {
                    if( isset( $meta['is_prototype'] ) ){
                        $is_prototype = true;
                    }
                    else{
                        $is_prototype = false;
                    }
                    continue;
                }

                //don't save fields of prototype
                if($is_prototype){
                    continue;
                }

                if( isset( $meta['id'] ) && isset( $_POST[ $input_prefix . $meta['id'] ] ) ){
                    $val = sanitize_text_field( wp_unslash( $_POST[ $input_prefix . $meta['id'] ] ) );

                    update_post_meta( $post_id, '_' . $meta['id'], apply_filters( 'emeon_save_post_meta', $val, $meta['id'] ) );
                }
            }
        }
    }
}
add_action( 'save_post', 'emeon_save_post' );