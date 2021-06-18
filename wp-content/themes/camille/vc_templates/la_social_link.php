<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$style = $el_class = "";

extract(shortcode_atts(array(
    'style' => 'default',
    'el_class' => ''
), $atts ));


$css_class = implode(' ', array(
    'social-media-link',
    'style-' . $style
))  . LaStudio_Shortcodes_Helper::getExtraClass( $el_class );

$social_links = Camille()->settings()->get('social_links', array());
if(!empty($social_links)){
    echo '<span class="'.esc_attr($css_class).'">';
    foreach($social_links as $item){
        if(!empty($item['link']) && !empty($item['icon'])){
            $title = isset($item['title']) ? $item['title'] : '';
            printf(
                '<a href="%1$s" class="%2$s" title="%3$s" target="_blank" rel="nofollow"><i class="%4$s"></i></a>',
                esc_url($item['link']),
                esc_attr(sanitize_title($title)),
                esc_attr($title),
                esc_attr($item['icon'])
            );
        }
    }
    echo '</span>';
}