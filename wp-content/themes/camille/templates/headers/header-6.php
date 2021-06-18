<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$header_layout = Camille()->layout()->get_header_layout();

$show_header_top        = Camille()->settings()->get('enable_header_top');
$header_top_elements    = Camille()->settings()->get('header_top_elements');
$custom_header_top_html = Camille()->settings()->get('use_custom_header_top');

$header_sidebar_widget_bottom = apply_filters('camille/filter/header_sidebar_widget_bottom', 'header-sidebar-bottom');

$enable_header_aside = true

?>

<?php if($enable_header_aside): ?>
    <aside id="header_aside" class="header--aside">
        <div class="header-aside-wrapper">
            <div class="header-aside-inner">
                <nav class="nav-menu-burger accordion-menu"><?php
                    Camille()->layout()->render_main_nav(array(
                        'menu_class'    => 'menu',
                        'link_before'   => '',
                        'link_after'    => '',
                        'fallback_cb'   => 'wp_page_menu',
                        'walker'        => ''
                    ));
                ?></nav>
                <?php if(is_active_sidebar($header_sidebar_widget_bottom)): ?>
                    <div class="header-widget-bottom">
                        <?php
                        dynamic_sidebar($header_sidebar_widget_bottom);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </aside>
<?php endif;?>


<?php if($show_header_top == 'custom' && !empty($custom_header_top_html) ): ?>
<header id="masthead" class="site-header">
    <div class="site-header-top use-custom-html">
        <div class="container">
            <?php echo Camille_Helper::remove_js_autop($custom_header_top_html); ?>
        </div>
    </div>
</header>
<?php endif; ?>
<?php if($show_header_top == 'yes' && !empty($header_top_elements) ): ?>
<header id="masthead" class="site-header">
    <div class="site-header-top use-default">
        <div class="container">
            <div class="header-top-elements">
                <?php
                foreach($header_top_elements as $component){
                    if(isset($component['type'])){
                        echo Camille_Helper::render_access_component($component['type'], $component, 'header_component');
                    }
                }
                ?>
            </div>
        </div>
    </div>
</header>
<?php endif; ?>
<header id="masthead_aside" class="header--aside">
    <div class="site-header-inner">
        <div class="container">
            <div class="header-main clearfix">
                <div class="header-component-outer header-left">
                    <div class="site-branding">
                        <a href="<?php echo esc_url( home_url( '/'  ) ); ?>" rel="home">
                            <figure class="logo--normal"><?php Camille()->layout()->render_logo();?></figure>
                            <figure class="logo--transparency"><?php Camille()->layout()->render_transparency_logo();?></figure>
                        </a>
                    </div>
                </div>
                <div class="header-component-outer header-right">
                    <div class="header_component header_component--link la_compt_iem la_com_action--aside_header"><a rel="nofollow" class="component-target" href="javascript:;"><span class="laicon-three-dots"><span></span></span></a></div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- #masthead -->