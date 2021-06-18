<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}


add_filter('woocommerce_product_related_posts_relate_by_category', '__return_false');
add_filter('woocommerce_product_related_posts_relate_by_tag', '__return_false');
add_filter('woocommerce_product_related_posts_force_display', '__return_true');


add_filter('body_class', 'camille_preset_add_body_classes');

function camille_preset_add_body_classes( $class ){
    $class[] = 'isLaWebRoot';
    return $class;
}


add_action( 'woocommerce_product_query', 'camille_demo_product_query', 20);
function camille_demo_product_query( $q ){
    if(is_shop()){
        if(!isset($_GET['orderby']) || ( isset($_GET['orderby']) && $_GET['orderby'] != 'date' )){
            $q->set( 'orderby', 'date' );
            $q->set( 'order', 'ASC' );
        }
        if(isset($_GET['la_preset']) && ($_GET['la_preset'] == 'shop-02-columns' || $_GET['la_preset'] == 'shop-sidebar')){
            $q->set( 'posts_per_page', 8 );
        }
        if(isset($_GET['la_preset']) && ($_GET['la_preset'] == 'shop-fullwidth')){
            $q->set( 'posts_per_page', 12 );
        }
    }
}

add_filter( 'camille/filter/page_title', 'camille_demo_modify_product_page_title', 10, 1 );
function camille_demo_modify_product_page_title( $title ) {
    if(is_singular('product')){
        global $product;
        return sprintf( '<header><div class="text-capitalize page-title h1">%s</div></header>', $product->get_type() . ' Product' );
    }
    return $title;
}