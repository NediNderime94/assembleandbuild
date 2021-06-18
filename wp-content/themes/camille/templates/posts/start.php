<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$layout             = camille_get_theme_loop_prop('loop_layout', 'grid');
$style              = camille_get_theme_loop_prop('loop_style', 1);
$responsive_column  = camille_get_theme_loop_prop('responsive_column', array());
$slider_configs     = camille_get_theme_loop_prop('slider_configs', '');
$item_space         = camille_get_theme_loop_prop('item_space', '30');

$is_masonry_mode    = false;

if($layout == 'masonry'){
    $layout = 'grid';
    $is_masonry_mode = true;
    camille_set_theme_loop_prop('loop_layout', $layout);
    camille_set_theme_loop_prop('is_masonry_mode', $is_masonry_mode);
}

$loopCssClass       = array('la-loop','showposts-loop');
$loopCssClass[]     = $layout .'-' . $style;
$loopCssClass[]     = 'showposts-' . $layout;

if($layout == 'grid'){
    $loopCssClass[] = 'grid-items';
    $loopCssClass[] = 'grid-space-'. $item_space;
    if(!empty($slider_configs) && !$is_masonry_mode){
        $loopCssClass[] = 'js-el la-slick-slider';
    }
    else{
        $loopCssClass[] = camille_render_grid_css_class_from_columns($responsive_column);
    }
}
else{
    $slider_configs = '';
}

if($is_masonry_mode){
    $html_att_tag = ' data-la_component="DefaultMasonry" data-item_selector=".blog__item"';
    $loopCssClass[] = 'js-el la-isotope-container';
}
else{
    $html_att_tag = (!empty($slider_configs) ? ' data-la_component="AutoCarousel" ' . $slider_configs : '');
}

printf(
    '<div class="%1$s"%2$s>',
    esc_attr(implode(' ', $loopCssClass)),
    $html_att_tag
);