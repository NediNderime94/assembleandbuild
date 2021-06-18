<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

$is_main_loop = wc_get_loop_prop('is_main_loop', false);

$active_shop_masonry = Camille()->settings()->get('active_shop_masonry', 'off');
$shop_masonry_column_type = Camille()->settings()->get('shop_masonry_column_type', 'default');
$woocommerce_shop_masonry_columns = Camille()->settings()->get('woocommerce_shop_masonry_columns');

$product_masonry_item_width = Camille()->settings()->get('product_masonry_item_width', 270);
$product_masonry_item_height = Camille()->settings()->get('product_masonry_item_height', 450);
$woocommerce_shop_masonry_custom_columns = Camille()->settings()->get('woocommerce_shop_masonry_custom_columns');
$shop_masonry_item_setting = Camille()->settings()->get('shop_masonry_item_setting');

$item_gap = Camille()->settings()->get('shop_item_space', 'default');

if($item_gap == 'zero'){
    $item_gap = 0;
}

$column_tmp = Camille()->settings()->get('woocommerce_shop_page_columns');

if($is_main_loop && $active_shop_masonry == 'on'){
    $column_tmp = $woocommerce_shop_masonry_columns;
}

?>
<?php
$view_mode = Camille()->settings()->get('shop_catalog_display_type', 'grid');
$columns = shortcode_atts(
    array(
        'xlg'	=> 1,
        'lg' 	=> 1,
        'md' 	=> 1,
        'sm' 	=> 1,
        'xs' 	=> 1,
        'mb' 	=> 1
    ),
    $column_tmp
);
$mb_column = $columns;

if($is_main_loop && $active_shop_masonry == 'on' && $shop_masonry_column_type == 'custom'){
    $mb_column = shortcode_atts(
        array(
            'md' 	=> 1,
            'sm' 	=> 1,
            'xs' 	=> 1,
            'mb' 	=> 1
        ),
        $woocommerce_shop_masonry_custom_columns
    );
}

$view_mode = apply_filters('camille/filter/catalog_view_mode', $view_mode);

if($is_main_loop && $active_shop_masonry == 'on'){
    $view_mode = 'grid';
}

$design = Camille()->settings()->get("shop_catalog_grid_style", '1');

$loopCssClass = array();
$loopCssClass[] = 'products';
$loopCssClass[] = 'products-' . $view_mode;
$loopCssClass[] = 'grid-space-' . $item_gap;
$loopCssClass[] = 'products-grid-' . $design;

$masonry_component_type = '';

if($is_main_loop && $active_shop_masonry == 'on'){
    camille_set_wc_loop_prop('prods_masonry', true);
    $loopCssClass[] = 'prods_masonry';
    $loopCssClass[] = 'js-el la-isotope-container';
    $loopCssClass[] = 'masonry__column-type-' . $shop_masonry_column_type;
    if( $shop_masonry_column_type != 'custom' ){
        $loopCssClass[] = 'grid-items';
        $masonry_component_type = 'DefaultMasonry';
        $loopCssClass[] = camille_render_grid_css_class_from_columns($columns);
    }
    else{
        $__new_item_sizes = array();
        if(!empty($shop_masonry_item_setting) && is_array($shop_masonry_item_setting)){
            foreach($shop_masonry_item_setting as $k => $size){
                $__new_item_sizes[$k] = $size;
                if(!empty($size['image_size'])){
                    $__new_item_sizes[$k]['s'] = Camille_Helper::get_image_size_from_string($size['image_size']);
                }
            }
        }
        camille_set_wc_loop_prop('item_sizes', $__new_item_sizes);
        $masonry_component_type = 'AdvancedMasonry';
    }
    camille_set_wc_loop_prop('image_size', Camille_Helper::get_image_size_from_string(Camille()->settings()->get('product_masonry_image_size', 'shop_catalog')));
    ?>
    <div data-la_component="InsertCustomCSS" class="js-el append-css-to-head hidden">
        .wc-toolbar .wc-toolbar-right{ display:none };
    </div>
<?php
}
else{
    $loopCssClass[] = 'grid-items';
    $loopCssClass[] = camille_render_grid_css_class_from_columns($columns);
}

?>
<div class="row">
    <div class="col-xs-12">
        <ul class="<?php echo esc_attr(implode(' ', $loopCssClass)) ?>"<?php
echo ' data-item_selector=".product_item"';
echo ' data-item_margin="0"';
echo ' data-item-width="'.esc_attr($product_masonry_item_width).'"';
echo ' data-item-height="'.esc_attr($product_masonry_item_height).'"';
echo ' data-md-col="'.esc_attr($mb_column['md']).'"';
echo ' data-sm-col="'.esc_attr($mb_column['sm']).'"';
echo ' data-xs-col="'.esc_attr($mb_column['xs']).'"';
echo ' data-mb-col="'.esc_attr($mb_column['mb']).'"';
echo ' data-la_component="'.esc_attr($masonry_component_type).'"';
echo ' data-la-effect="sequencefade"';
?>>