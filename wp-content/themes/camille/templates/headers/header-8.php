<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$header_layout = Camille()->layout()->get_header_layout();

$header_access_icon = Camille()->settings()->get('header_access_icon_1');
$header_access_icon_2 = Camille()->settings()->get('header_access_icon_2');

$show_header_top        = Camille()->settings()->get('enable_header_top');
$header_top_elements    = Camille()->settings()->get('header_top_elements');
$custom_header_top_html = Camille()->settings()->get('use_custom_header_top');

$aside_sidebar_name = apply_filters('camille/filter/aside_widget_bottom', 'aside-widget');

$enable_header_aside = false;

if(!empty($header_access_icon)){
    foreach($header_access_icon as $component){
        if(isset($component['type']) && $component['type'] == 'aside_header'){
            $enable_header_aside = true;
            break;
        }
    }
}

?>
<?php if($enable_header_aside): ?>
    <aside id="header_aside" class="header--aside">
        <div class="header-aside-wrapper">
            <a class="btn-aside-toggle" href="#"><i class="dl-icon-close"></i></a>
            <div class="header-aside-inner">
                <?php if(is_active_sidebar($aside_sidebar_name)): ?>
                    <div class="header-widget-bottom">
                        <?php
                        dynamic_sidebar($aside_sidebar_name);
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </aside>
<?php endif;?>

<header id="masthead" class="site-header">
    <?php if($show_header_top == 'custom' && !empty($custom_header_top_html) ): ?>
        <div class="site-header-top use-custom-html">
            <div class="container">
                <?php echo Camille_Helper::remove_js_autop($custom_header_top_html); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if($show_header_top == 'yes' && !empty($header_top_elements) ): ?>
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
    <?php endif; ?>

    <div class="site-header-outer">
        <div class="site-header-inner">
            <div class="container">
                <div class="header-main clearfix">
                    <div class="header-component-outer header-left">
                        <div class="header-component-inner clearfix">
                            <?php
                            if(!empty($header_access_icon_2)){
                                foreach($header_access_icon_2 as $component){
                                    if(isset($component['type'])){
                                        echo Camille_Helper::render_access_component($component['type'], $component, 'header_component');
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="header-component-outer header-middle">
                        <div class="site-branding">
                            <a href="<?php echo esc_url( home_url( '/'  ) ); ?>" rel="home">
                                <figure class="logo--normal"><?php Camille()->layout()->render_logo();?></figure>
                                <figure class="logo--transparency"><?php Camille()->layout()->render_transparency_logo();?></figure>
                            </a>
                        </div>
                    </div>
                    <div class="header-component-outer header-right">
                        <div class="header-component-inner clearfix">
                            <?php
                            if(!empty($header_access_icon)){
                                foreach($header_access_icon as $component){
                                    if(isset($component['type'])){
                                        echo Camille_Helper::render_access_component($component['type'], $component, 'header_component');
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-header__nav site-header__nav-primary">
                <div class="container">
                    <div class="header-main clearfix">
                        <nav class="site-main-nav clearfix" data-container="#masthead .site-header__nav-primary .header-main">
                            <?php Camille()->layout()->render_main_nav();?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="la-header-sticky-height"></div>
    </div>
</header>
<!-- #masthead -->