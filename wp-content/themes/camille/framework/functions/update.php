<?php

/**
 * This function allow get property of `woocommerce_loop` inside the loop
 * @since 1.0.0
 * @param string $prop Prop to get.
 * @param string $default Default if the prop does not exist.
 * @return mixed
 */

if(!function_exists('camille_get_wc_loop_prop')){
    function camille_get_wc_loop_prop( $prop, $default = ''){
        return isset( $GLOBALS['woocommerce_loop'], $GLOBALS['woocommerce_loop'][ $prop ] ) ? $GLOBALS['woocommerce_loop'][ $prop ] : $default;
    }
}

/**
 * This function allow set property of `woocommerce_loop`
 * @since 1.0.0
 * @param string $prop Prop to set.
 * @param string $value Value to set.
 */

if(!function_exists('camille_set_wc_loop_prop')){
    function camille_set_wc_loop_prop( $prop, $value = ''){
        if(isset($GLOBALS['woocommerce_loop'])){
            $GLOBALS['woocommerce_loop'][ $prop ] = $value;
        }
    }
}

/**
 * This function allow get property of `camille_loop` inside the loop
 * @since 1.0.0
 * @param string $prop Prop to get.
 * @param string $default Default if the prop does not exist.
 * @return mixed
 */

if(!function_exists('camille_get_theme_loop_prop')){
    function camille_get_theme_loop_prop( $prop, $default = ''){
        return isset( $GLOBALS['camille_loop'], $GLOBALS['camille_loop'][ $prop ] ) ? $GLOBALS['camille_loop'][ $prop ] : $default;
    }
}

if(!function_exists('camille_set_theme_loop_prop')){
    function camille_set_theme_loop_prop( $prop, $value = '', $force = false){
        if($force && !isset($GLOBALS['camille_loop'])){
            $GLOBALS['camille_loop'] = array();
        }
        if(isset($GLOBALS['camille_loop'])){
            $GLOBALS['camille_loop'][ $prop ] = $value;
        }
    }
}


if(!function_exists('camille_override_yikes_mailchimp_page_data')){
    function camille_override_yikes_mailchimp_page_data($page_data, $form_id){
        $new_data = new stdClass();
        if(isset($page_data->ID)){
            $new_data->ID = $page_data->ID;
        }
        return $new_data;
    }
    add_filter('yikes-mailchimp-page-data', 'camille_override_yikes_mailchimp_page_data', 10, 2);
}

if(!function_exists('camille_convert_legacy_responsive_column')){
    function camille_convert_legacy_responsive_column( $columns = array() ) {
        $legacy = array(
            'xlg'	=> '',
            'lg' 	=> '',
            'md' 	=> '',
            'sm' 	=> '',
            'xs' 	=> '',
            'mb' 	=> 1
        );
        $new_key = array(
            'mb'    =>  'xs',
            'xs'    =>  'sm',
            'sm'    =>  'md',
            'md'    =>  'lg',
            'lg'    =>  'xl',
            'xlg'   =>  'xxl'
        );
        if(empty($columns)){
            $columns = $legacy;
        }
        $new_columns = array();
        foreach($columns as $k => $v){
            if(isset($new_key[$k])){
                $new_columns[$new_key[$k]] = $v;
            }
        }
        if(empty($new_columns['xs'])){
            $new_columns['xs'] = 1;
        }
        return $new_columns;
    }
}

if(!function_exists('camille_render_grid_css_class_from_columns')){
    function camille_render_grid_css_class_from_columns( $columns, $merge = true ) {
        if($merge){
            $columns = camille_convert_legacy_responsive_column( $columns );
        }
        $classes = array();
        foreach($columns as $k => $v){
            if(empty($v)){
                continue;
            }
            if($k == 'xs'){
                $classes[] = 'block-grid-' . $v;
            }
            else{
                $classes[] = $k . '-block-grid-' . $v;
            }
        }
        return join(' ', $classes);
    }
}

if(!function_exists('camille_add_ajax_cart_btn_into_single_product')){
    function camille_add_ajax_cart_btn_into_single_product(){
        global $product;
        if($product->is_type('simple')){
            echo '<div class="wrap-single-addcart hidden">';
            woocommerce_template_loop_add_to_cart();
            echo '</div>';
        }
    }
    add_action('woocommerce_after_add_to_cart_button', 'camille_add_ajax_cart_btn_into_single_product');
}

if(!function_exists('camille_get_the_excerpt')){
    function camille_get_the_excerpt($length = null){
        ob_start();
        if(!empty($length)){
            add_filter('excerpt_length', function() use ($length) {
                return $length;
            }, 1012);
        }
        the_excerpt();
        if(!empty($length)) {
            remove_all_filters('excerpt_length', 1012);
        }
        $patterns = "/\[[\/]?vc_[^\]]*\]/";
        $replacements = "";
        return preg_replace($patterns, $replacements, ob_get_clean());
    }
}


if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
    function woocommerce_template_loop_product_title() {
        the_title( sprintf( '<h3 class="product_item--title"><a href="%s">', esc_url( get_the_permalink() ) ), '</a></h3>' );
    }
}

if( !function_exists('camille_allow_shortcode_text_in_component_text') ) {
    function camille_allow_shortcode_text_in_component_text( $text ){
        return do_shortcode($text);
    }
    add_filter('camille/filter/component/text', 'camille_allow_shortcode_text_in_component_text');
}

if(!function_exists('camille_override_woothumbnail_size')){
    function camille_override_woothumbnail_size( $size ) {
        if(!function_exists('wc_get_theme_support')){
            return $size;
        }
        $size['width'] = absint( wc_get_theme_support( 'gallery_thumbnail_image_width', 100 ) );
        $cropping      = get_option( 'woocommerce_thumbnail_cropping', '1:1' );

        if ( 'uncropped' === $cropping ) {
            $size['height'] = '';
            $size['crop']   = 0;
        }
        elseif ( 'custom' === $cropping ) {
            $width          = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_width', '4' ) );
            $height         = max( 1, get_option( 'woocommerce_thumbnail_cropping_custom_height', '3' ) );
            $size['height'] = absint( round( ( $size['width'] / $width ) * $height ) );
            $size['crop']   = 1;
        }
        else {
            $cropping_split = explode( ':', $cropping );
            $width          = max( 1, current( $cropping_split ) );
            $height         = max( 1, end( $cropping_split ) );
            $size['height'] = absint( round( ( $size['width'] / $width ) * $height ) );
            $size['crop']   = 1;
        }

        return $size;
    }
    add_filter('woocommerce_get_image_size_gallery_thumbnail', 'camille_override_woothumbnail_size');
}


if(!function_exists('camille_override_theme_default')){
    function camille_override_theme_default(){
    	
        $title_layout = Camille()->layout()->get_page_title_bar_layout();
        if( Camille()->layout()->get_header_layout() == 11 && (empty($title_layout) || $title_layout == 'hide') ):
        ?>
        <div class="page-title-section">
            <?php
                echo Camille()->breadcrumbs()->get_title();
                do_action('camille/action/breadcrumbs/render_html');
            ?>
        </div>
<?php
        endif;
    }
    add_action('camille/action/before_render_main_inner', 'camille_override_theme_default');
}

if(!function_exists('camille_override_filter_woocommerce_format_content')){
    function camille_override_filter_woocommerce_format_content( $format, $raw_string ){
        $format = preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $raw_string);
        return apply_filters( 'woocommerce_short_description', $format );
    }
}

if(!function_exists('camille_wc_product_loop')){
    function camille_wc_product_loop(){
        if(!function_exists('WC')){
            return false;
        }
        return have_posts() || 'products' !== woocommerce_get_loop_display_mode();
    }
}

add_action('woocommerce_product_meta_start', function(){
    add_filter('wc_product_sku_enabled', '__return_false', 100);
});

add_action('woocommerce_product_meta_end', function(){
    add_filter('wc_product_sku_enabled', '__return_true', 100);
});

if(!function_exists('camille_override_wc_format_content_in_terms')){
    function camille_override_wc_format_content_in_terms(){
        add_filter('woocommerce_format_content', 'camille_override_filter_woocommerce_format_content', 99, 2);
    }
}

if(!function_exists('camille_remove_override_wc_format_content_in_terms')){
    function camille_remove_override_wc_format_content_in_terms(){
        remove_filter('woocommerce_format_content', 'camille_override_filter_woocommerce_format_content', 99);
    }
}

add_action('woocommerce_checkout_terms_and_conditions', 'camille_override_wc_format_content_in_terms', 1);
add_action('woocommerce_checkout_terms_and_conditions', 'camille_remove_override_wc_format_content_in_terms', 999);


/**
 * This function allow override the api
 * @since 1.0.4
 */
add_filter('LaStudio/core/instagram_api_token', 'camille_add_instagram_api_token');
if(!function_exists('camille_add_instagram_api_token')){
    function camille_add_instagram_api_token( $key = '' ){
        return Camille()->settings()->get('instagram_token', $key);
    }
}