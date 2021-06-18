<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_shop_fullwidth()
{
    return array(

        array(
            'key' => 'layout_archive_product',
            'value' => 'col-1c'
        ),

        array(
            'key' => 'active_shop_filter',
            'value' => 'on'
        ),
        array(
            'key' => 'woocommerce_toggle_grid_list',
            'value' => 'no'
        ),

        array(
            'key' => 'main_full_width',
            'value' => 'yes'
        ),
        array(
            'key' => 'product_per_page_default',
            'value' => 12
        ),
        array(
            'key' => 'woocommerce_shop_page_columns',
            'value' => array(
                'xlg' => 4,
                'lg' => 4,
                'md' => 3,
                'sm' => 2,
                'xs' => 1,
                'mb' => 1
            )
        ),

        array(
            'filter_name' => 'camille/setting/option/get_single',
            'filter_func' => function( $value, $key ){
                if( $key == 'la_custom_css'){
                    $value .= '
@media (min-width: 1300px) {
    .site-main > .container{
        padding-left: 40px;
        padding-right: 40px;
    }
}
@media (min-width: 1400px) {
    .site-main > .container{
        padding-left: 60px;
        padding-right: 60px;
    }
}
@media (min-width: 1500px) {
    .site-main > .container{
        padding-left: 80px;
        padding-right: 80px;
    }
}
';
                }
                return $value;
            },
            'filter_priority'  => 10,
            'filter_args'  => 3
        ),

        array(
            'filter_name' => 'camille/filter/page_title',
            'value' => '<header><h1 class="page-title h1">Shop FullWidth</h1></header>'
        ),
    );
}