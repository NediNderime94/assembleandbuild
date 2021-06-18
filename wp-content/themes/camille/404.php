<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header(); ?>
<?php do_action( 'camille/action/before_render_main' ); ?>
<?php $content_404 = Camille()->settings()->get('404_page_content'); ?>
    <div id="main" class="site-main<?php echo ($content_404 ? ' has-custom-404-content' : ''); ?>">
        <div class="container">
            <div class="row">
                <main id="site-content" class="<?php echo esc_attr(Camille()->layout()->get_main_content_css_class('col-xs-12 site-content'))?>">
                    <div class="site-content-inner">

                        <?php do_action( 'camille/action/before_render_main_inner' );?>

                        <div class="page-content">
                            <?php
                            if(!empty($content_404)) : ?>
                                <div class="customerdefine-404-content">
                                    <?php echo Camille_Helper::remove_js_autop($content_404); ?>
                                </div>
                            <?php else : ?>
                                <div class="default-404-content">
                                    <div class="col-xs-12">
                                        <h1><?php echo esc_html_x('404', 'front-end', 'camille') ?></h1>
                                        <h5><?php echo esc_html_x('Page cannot be found !', 'front-end', 'camille') ?></h5>
                                        <p class="btn-wrapper"><a class="btn btn-shape-round btn-style-flat btn-color-black" href="<?php echo esc_url(home_url('/')) ?>"><?php echo esc_html_x('Back to homepage', 'front-view','camille')?></a></p>
                                    </div>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>

                        <?php do_action( 'camille/action/after_render_main_inner' );?>
                    </div>
                </main>
                <!-- #site-content -->
                <?php get_sidebar();?>
            </div>
        </div>
    </div>
    <!-- .site-main -->
<?php do_action( 'camille/action/after_render_main' ); ?>
<?php get_footer();?>