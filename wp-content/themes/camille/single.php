<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();
do_action( 'camille/action/before_render_main' );

$enable_related = Camille()->settings()->get('blog_related_posts', 'off');
$related_style = Camille()->settings()->get('blog_related_design', 1);
$max_related = (int) Camille()->settings()->get('blog_related_max_post', 1);
$related_by = Camille()->settings()->get('blog_related_by', 'category');

$single_post_thumbnail_size = Camille_Helper::get_image_size_from_string(Camille()->settings()->get('single_post_thumbnail_size', 'full'), 'full');

$page_title_bar = Camille()->settings()->get('page_title_bar_layout_post_single_global', 'off');
$page_title_bar2 = Camille()->settings()->get_post_meta(get_the_ID(), 'page_title_bar_layout');
$hide_breadcrumb = Camille()->settings()->get_post_meta(get_the_ID(), 'hide_breadcrumb');
?>

<div id="main" class="site-main">
    <div class="container">
        <div class="row">
            <main id="site-content" class="<?php echo esc_attr(Camille()->layout()->get_main_content_css_class('col-xs-12 site-content'))?>">
                <div class="site-content-inner">

                    <?php do_action( 'camille/action/before_render_main_inner' );?>

                    <div class="page-content">

                        <div class="single-post-detail clearfix">
                            <?php

                            do_action( 'camille/action/before_render_main_content' );

                            if( have_posts() ):  the_post(); ?>

                                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-content'); ?>>

                                    <?php
                                    if('above' == Camille()->settings()->get('blog_post_title')){
                                        the_title( '<header class="entry-header entry-header-above single_post_item--title"><h1 class="entry-title h3">', '</h1></header>' );
                                        if($page_title_bar2 != 'hide' && $page_title_bar == 'off' && $hide_breadcrumb != 'yes'){
                                            echo '<div class="la-breadcrumbs text-color-secondary">';
                                            do_action('camille/action/breadcrumbs/render_html');
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                    <?php
                                        if(Camille()->settings()->get('featured_images_single') == 'on'){
                                            camille_single_post_thumbnail($single_post_thumbnail_size);
                                        }
                                    ?>

                                    <?php
                                        if('below' == Camille()->settings()->get('blog_post_title') ){
                                            the_title( '<header class="entry-header entry-header-below entry-header single_post_item--title"><h1 class="entry-title h3">', '</h1></header>' );
                                        }
                                    ?>
                                    <div class="showposts-loop">
                                        <div class="single_post_item--meta loop__item__meta entry-meta clearfix">
                                            <?php
                                            camille_entry_meta_item_author();
                                            camille_entry_meta_item_postdate();
                                            camille_entry_meta_item_category_list('<div class="loop__item__meta--item loop__item__termlink blog_item--category-link">', '</div>', '');
                                            ?>
                                        </div>
                                    </div>

                                    <div class="entry-content">
                                        <?php

                                        the_content();

                                        wp_link_pages( array(
                                            'before'      => '<div class="clearfix"></div><div class="page-links"><span class="page-links-title">' . esc_html_x( 'Pages:', 'front-view', 'camille' ) . '</span>',
                                            'after'       => '</div>',
                                            'link_before' => '<span>',
                                            'link_after'  => '</span>',
                                            'pagelink'    => '<span class="screen-reader-text">' . esc_html_x( 'Page', 'front-view', 'camille' ) . ' </span>%',
                                            'separator'   => '<span class="screen-reader-text">, </span>',
                                        ) );
                                        ?>
                                    </div><!-- .entry-content -->
                                    <div class="clearfix"></div>
                                    <footer class="entry-footer clearfix">
                                        <?php the_tags('<div class="entry-meta-footer"><div class="tags-list"><span><i class="fa fa-tags"></i></span><span class="tags-list-item text-color-secondary">' ,', ','</span></div></div>') ;?>

                                        <?php
                                        if(Camille()->settings()->get('blog_social_sharing_box') == 'on'){
                                            echo '<div class="la-sharing-single-posts">';
                                            echo sprintf('<span>%s <i class="fa fa-share-alt"></i></span>', esc_html_x('Share this post', 'front-view', 'camille') );
                                            camille_social_sharing(get_the_permalink(), get_the_title(), (has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : ''));
                                            echo '</div>';
                                        }
                                        ?>

                                        <?php edit_post_link( null, '<span class="edit-link hidden">', '</span>' ); ?>
                                    </footer><!-- .entry-footer -->

                                </article><!-- #post-## -->

                                <div class="clearfix"></div>

                                <?php

                                if(Camille()->settings()->get('blog_pn_nav') == 'on'){
                                    the_post_navigation( array(
                                        'next_text' => '<span class="post-title">%title</span><span class="meta-nav" aria-hidden="true">' . esc_html_x( 'Next post', 'front-view', 'camille' ) . '</span> ',
                                        'prev_text' => '<span class="post-title">%title</span><span class="meta-nav" aria-hidden="true">' . esc_html_x( 'Previous post', 'front-view', 'camille' ) . '</span>'
                                    ) );
                                    echo '<div class="clearfix"></div>';
                                }


                                if(Camille()->settings()->get('blog_author_info') == 'on'){
                                    get_template_part( 'author-bio' );
                                    echo '<div class="clearfix"></div>';
                                }

                                if(Camille()->settings()->get('blog_comments') == 'on' && ( comments_open() || get_comments_number() ) ){
                                    comments_template();
                                    echo '<div class="clearfix"></div>';
                                }

                                ?>

                        <?php endif; ?>

                            <?php

                            do_action( 'camille/action/after_render_main_content' );

                            wp_reset_postdata();

                            ?>

                        </div>

                    </div>

                    <?php do_action( 'camille/action/after_render_main_inner' );?>
                </div>
            </main>
            <!-- #site-content -->
            <?php get_sidebar();?>

        </div>
    </div>
    <?php
    if($enable_related == 'on') {
        wp_reset_postdata();
        $related_args = array(
            'posts_per_page' => 6,
            'post__not_in' => array(get_the_ID())
        );
        if ($related_by == 'random') {
            $related_args['orderby'] = 'rand';
        }
        if ($related_by == 'category') {
            $cats = wp_get_post_terms(get_the_ID(), 'category');
            if (is_array($cats) && isset($cats[0]) && is_object($cats[0])) {
                $related_args['category__in'] = array($cats[0]->term_id);
            }
        }
        if ($related_by == 'tag') {
            $tags = wp_get_post_terms(get_the_ID(), 'tag');
            if (is_array($tags) && isset($tags[0]) && is_object($tags[0])) {
                $related_args['tag__in'] = array($tags[0]->term_id);
            }
        }
        if ($related_by == 'both') {
            $cats = wp_get_post_terms(get_the_ID(), 'category');
            if (is_array($cats) && isset($cats[0]) && is_object($cats[0])) {
                $related_args['category__in'] = array($cats[0]->term_id);
            }
            $tags = wp_get_post_terms(get_the_ID(), 'tag');
            if (is_array($tags) && isset($tags[0]) && is_object($tags[0])) {
                $related_args['tag__in'] = array($tags[0]->term_id);
            }
        }

        $related_query = new WP_Query($related_args);

        if ($related_query->have_posts()) { ?>
            <div class="row-related-posts">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="clearfix"></div>
                            <div class="la-related-posts">
                                <div class="row block_heading">
                                    <div class="col-xs-12">
                                        <h3 class="block_heading--title"><?php echo esc_html_x('Related Posts', 'front-view', 'camille') ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="la-related-posts">
                                <?php

								$product_cols = array(
                                    'xlg' => 3,
                                    'lg' => 3,
                                    'md' => 3,
                                    'sm' => 2,
                                    'xs' => 2,
                                    'mb' => 1
                                );
								
                                camille_set_theme_loop_prop('loop_name', 'related_posts', true);
                                camille_set_theme_loop_prop('loop_layout', 'grid');
                                camille_set_theme_loop_prop('loop_style', 2);
                                camille_set_theme_loop_prop('excerpt_length', 10);
                                camille_set_theme_loop_prop('title_tag', 'h3');
                                camille_set_theme_loop_prop('responsive_column', $product_cols);
                                camille_set_theme_loop_prop('image_size', '370x240');
                                $slide_configs 	= Camille_Helper::get_slick_slider_config(array_merge(array('arrows' => false, 'dots' => true), $product_cols));
                                $slide_configs = sprintf(' data-slider_config="%s"', esc_attr($slide_configs));

                                camille_set_theme_loop_prop('slider_configs', $slide_configs);

                                get_template_part('templates/posts/start');

                                while ($related_query->have_posts()) {
                                    $related_query->the_post();
                                    get_template_part('templates/posts/loop');
                                }

                                get_template_part('templates/posts/end');

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        wp_reset_postdata();
    }
    ?>
</div>
<!-- .site-main -->
<?php do_action( 'camille/action/after_render_main' ); ?>
<?php get_footer();?>
