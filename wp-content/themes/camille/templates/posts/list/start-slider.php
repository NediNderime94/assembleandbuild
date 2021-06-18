<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$loopCssClass       = array('la-loop','showposts-loop', 'list-slider', 'showposts-list', 'js-el');
$slider_configs     = array(
    'dots'              => true,
    'infinite'          => true,
    'arrows'            => true,
    'swipe'             => true,
    'draggable'         => true,
    'touchMove'         => true,
    'rtl'               => is_rtl() ? true : false,
    'autoplay'          => false,
    'speed'             => 1000,
    'autoplaySpeed'     => 9000
);

printf(
    '<div class="%1$s" data-la_component="AutoCarousel" data-slider_config="%2$s">',
    esc_attr(implode(' ', $loopCssClass)),
    esc_attr(wp_json_encode($slider_configs))
);