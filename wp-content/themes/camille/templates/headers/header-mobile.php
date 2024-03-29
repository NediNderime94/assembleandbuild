<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$header_mobile_layout = Camille()->settings()->get('header_mb_layout', '1');
$header_component_1 = Camille()->settings()->get('header_mb_component_1');
$header_component_2 = Camille()->settings()->get('header_mb_component_2');

$show_cart      = (Camille_Helper::is_active_woocommerce() && (Camille()->settings()->get('header_show_cart', 'no') == 'yes')) ? true : false;
$show_wishlist  = (Camille_Helper::is_active_woocommerce() && Camille()->settings()->get('header_show_wishlist') == 'yes' && function_exists('yith_wcwl_object_id'));
$show_account_menu      = (Camille()->settings()->get('header_show_menu_account') == 'yes') ? true : false;
$show_search    = (Camille()->settings()->get('header_show_search', 'no') == 'yes') ? true : false;
?>
<div class="site-header-mobile">
    <div class="site-header-outer">
        <div class="site-header-inner">
            <div class="container">
                <div class="header-main clearfix">
                    <div class="header-component-outer header-component-outer_logo">
                        <div class="site-branding">
                            <a href="<?php echo esc_url( home_url( '/'  ) ); ?>" rel="home">
                                <figure class="logo--normal"><?php Camille()->layout()->render_mobile_logo();?></figure>
                                <figure class="logo--transparency"><?php Camille()->layout()->render_mobile_transparency_logo();?></figure>
                            </a>
                        </div>
                    </div>
                    <div class="header-component-outer header-component-outer_1">
                        <div class="header-component-inner clearfix">
                            <?php
                            if(!empty($header_component_1)){
                                foreach($header_component_1 as $component){
                                    if(isset($component['type'])){
                                        echo Camille_Helper::render_access_component($component['type'], $component, 'header_component');
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php if( ($header_mobile_layout == 1 || $header_mobile_layout == 4 ) && !empty($header_component_2) ) : ?>
                    <div class="header-component-outer header-component-outer_2">
                        <div class="header-component-inner clearfix">
                            <?php
                            foreach($header_component_2 as $component){
                                if(isset($component['type'])){
                                    echo Camille_Helper::render_access_component($component['type'], $component, 'header_component');
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mobile-menu-wrap">
                <?php

                if(has_nav_menu('mobile-nav')){
                    $menu_args = array(
                        'container'         => false,
                        'theme_location'    => 'mobile-nav',
                        'items_wrap'        => '<div id="la_mobile_nav" class="dl-menuwrapper"><ul class="dl-menu dl-menuopen">%3$s</ul></div>'
                    );
                    wp_nav_menu($menu_args);
                }
                else{
                    wp_page_menu(array(
                        'menu_class' => 'dl-menuwrapper',
                        'menu_id' => 'la_mobile_nav',
                        'before' => '<ul class="dl-menu dl-menuopen">',
                        'after' => '</ul>'
                    ));
                }
                ?>
            </div>
        </div>
        <div class="la-header-sticky-height-mb"></div>
    </div>
</div>
<!-- .site-header-mobile -->