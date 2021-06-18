<?php

$store_user   = get_userdata( get_query_var( 'author' ) );
$store_info   = dokan_get_store_info( $store_user->ID );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';

$enable_theme_store_sidebar = dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' );

$main_css_class = 'col-md-12 col-xs-12 site-content';
if($enable_theme_store_sidebar == 'on'){
    $main_css_class = 'col-md-9 col-md-push-3 col-xs-12 site-content';
}

get_header();

?>
<?php do_action( 'camille/action/before_render_main' ); ?>
    <div id="main" class="site-main">
        <div class="container">
            <div class="row">
                <main id="site-content" class="<?php echo esc_attr($main_css_class)?>">
                    <div class="site-content-inner">

                        <?php do_action( 'camille/action/before_render_main_inner' );?>

                        <div class="page-content">
                            <?php

                            do_action( 'camille/action/before_render_main_content' );


                            ?>

                            <div id="dokan-primary" class="dokan-single-store">

                                <div id="dokan-content" class="store-page-wrap">

                                <?php dokan_get_template_part( 'store-header' ); ?>

                                <?php do_action( 'dokan_store_profile_frame_after', $store_user, $store_info ); ?>

                                </div>
                            </div>


                            <?php if ( have_posts() ) : ?>

                                <?php do_action('woocommerce_before_shop_loop'); ?>

                                <div id="la_shop_products" class="la-shop-products">

                                    <div class="la-ajax-shop-loading"><div class="la-ajax-loading-outer"><div class="la-loader spinner3"><div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div><div class="cube1"></div><div class="cube2"></div><div class="cube3"></div><div class="cube4"></div></div></div></div>

                                    <?php woocommerce_product_loop_start(); ?>

                                    <?php while ( have_posts() ) : the_post(); ?>

                                        <?php wc_get_template_part( 'content', 'product' ); ?>

                                    <?php endwhile; // end of the loop. ?>

                                    <?php woocommerce_product_loop_end(); ?>

                                    <?php do_action('woocommerce_after_shop_loop'); ?>

                                </div>

                            <?php else : ?>

                                <div id="la_shop_products" class="la-shop-products no-products-found">
                                    <div class="la-ajax-shop-loading"><div class="la-ajax-loading-outer"><div class="la-loader spinner3"><div class="dot1"></div><div class="dot2"></div><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div><div class="cube1"></div><div class="cube2"></div><div class="cube3"></div><div class="cube4"></div></div></div></div>
                                    <?php wc_get_template( 'loop/no-products-found.php' ); ?>
                                </div>

                            <?php endif;

                            do_action( 'camille/action/after_render_main_content' );

                            ?>
                        </div>

                        <?php do_action( 'camille/action/after_render_main_inner' );?>
                    </div>
                </main>
                <!-- #site-content -->
                <?php if($enable_theme_store_sidebar == 'on'): ?>
                    <aside id="sidebar_primary" class="dokan-store-sidebar col-md-3 col-md-pull-9 col-xs-12">
                        <div class="dokan-widget-area widget-collapse sidebar-inner">
                            <?php do_action( 'dokan_sidebar_store_before', $store_user, $store_info ); ?>
                            <?php
                            if ( ! dynamic_sidebar( 'sidebar-store' ) ) {

                                $args = array(
                                    'before_widget' => '<div class="widget">',
                                    'after_widget'  => '</div>',
                                    'before_title'  => '<h4 class="widget-title">',
                                    'after_title'   => '</h4>',
                                );

                                if ( class_exists( 'Dokan_Store_Location' ) ) {
                                    the_widget( 'Dokan_Store_Category_Menu', array( 'title' => __( 'Store Category', 'camille' ) ), $args );

                                    if ( dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on'  && !empty( $map_location ) ) {
                                        the_widget( 'Dokan_Store_Location', array( 'title' => __( 'Store Location', 'camille' ) ), $args );
                                    }

                                    if ( dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
                                        the_widget( 'Dokan_Store_Contact_Form', array( 'title' => __( 'Contact Vendor', 'camille' ) ), $args );
                                    }
                                }

                            }
                            ?>
                            <?php do_action( 'dokan_sidebar_store_after', $store_user, $store_info ); ?>
                        </div>
                    </aside>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- .site-main -->
<?php do_action( 'camille/action/after_render_main' ); ?>
<?php get_footer();?>