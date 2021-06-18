<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$loop_id            = camille_get_theme_loop_prop('loop_id', uniqid('la_pf_'));
$layout             = camille_get_theme_loop_prop('loop_layout', 'grid');
$style              = camille_get_theme_loop_prop('loop_style', 1);
$item_space         = camille_get_theme_loop_prop('item_space', 0);
$responsive_column  = camille_get_theme_loop_prop('responsive_column', array());
$slider_configs     = camille_get_theme_loop_prop('slider_configs', '');


$loopCssClass = array('la-loop','portfolios-loop');
$loopCssClass[] = 'pf-style-' . $style;
$loopCssClass[] = 'pf-' . $layout;

if($layout != 'special'){
    $loopCssClass[] = 'pf-default';
    $loopCssClass[] = 'grid-space-'. $item_space;
}

if($layout == 'masonry'){
    $column_type            = camille_get_theme_loop_prop('column_type', 'default');
    $base_container_w       = camille_get_theme_loop_prop('base_container_w', 1170);
    $item_width             = camille_get_theme_loop_prop('base_item_w', 400);
    $item_height            = camille_get_theme_loop_prop('base_item_h', 400);
    $mb_column              = camille_get_theme_loop_prop('mb_column', array('md'=> 1,'sm'=> 1,'xs'=> 1, 'mb' => 1));
    $enable_skill_filter    = la_string_to_bool(camille_get_theme_loop_prop('enable_skill_filter', false));
    $filter_style           = camille_get_theme_loop_prop('filter_style', 1);
    $filters                = camille_get_theme_loop_prop('filters', '');

    $loopCssClass[]         = 'js-el';
    $loopCssClass[]         = 'la-isotope-container';
    $loopCssClass[]         = 'masonry__column-type-'. $column_type;

    $custom_isotope_configs = array();

    if($column_type != 'custom'){
        $loopCssClass[] = 'grid-items';
        $loopCssClass[] = camille_render_grid_css_class_from_columns($responsive_column);
    }

    if($enable_skill_filter){
        $filter_html = '';
        if(!empty($filters)){
            $filters = explode(',', $filters);
            foreach($filters as $filter){
                $category = get_term($filter, 'la_portfolio_skill');
                if(!is_wp_error($category) && $category){
                    $filter_html .= sprintf('<li data-filter="la_portfolio_skill-%s"><a href="#">%s</a></li>',
                        esc_attr($category->slug),
                        esc_html($category->name)
                    );
                }
            }
        }
        echo sprintf(
            '<div data-la_component="MasonryFilter" class="js-el la-isotope-filter-container filter-style-%1$s" data-isotope_container="#%2$s .la-isotope-container"><div class="la-toggle-filter">%3$s</div><ul><li class="active" data-filter="*"><a href="#">%3$s</a></li>%4$s</ul></div>',
            esc_attr($filter_style),
            esc_html($loop_id),
            esc_html_x('All', 'front-view', 'camille'),
            $filter_html
        );
    }

    ?>
<div class="<?php echo esc_attr(implode(' ', $loopCssClass)) ?>"<?php
echo ' data-item_selector=".portfolio__item"';
echo ' data-item_margin="0"';
echo ' data-config_isotope="'.esc_attr(json_encode($custom_isotope_configs)).'"';
echo ' data-container-width="'.esc_attr($base_container_w).'"';
echo ' data-item-width="'.esc_attr($item_width).'"';
echo ' data-item-height="'.esc_attr($item_height).'"';
echo ' data-md-col="'.esc_attr($mb_column['md']).'"';
echo ' data-sm-col="'.esc_attr($mb_column['sm']).'"';
echo ' data-xs-col="'.esc_attr($mb_column['xs']).'"';
echo ' data-mb-col="'.esc_attr($mb_column['mb']).'"';
echo ' data-la_component="' . ( $column_type != 'custom' ? 'DefaultMasonry' : 'AdvancedMasonry'). '"';
?>>
<?php

}
else{
    if(!empty($slider_configs)){
        $loopCssClass[] = 'js-el la-slick-slider';
    }
    else{
        if( $layout != 'special' ) {
            $loopCssClass[] = 'grid-items';
            $loopCssClass[] = camille_render_grid_css_class_from_columns($responsive_column);
        }
    }
    echo sprintf(
        '<div class="%1$s"%2$s>',
        esc_attr(implode(' ', $loopCssClass)),
        (!empty($slider_configs) ? ' data-la_component="AutoCarousel" ' . $slider_configs : '')
    );
}