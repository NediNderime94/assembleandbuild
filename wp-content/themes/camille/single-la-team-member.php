<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

do_action( 'camille/action/before_render_main' );
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

                                <?php
                                $role           =  Camille()->settings()->get_post_meta(get_the_ID(), 'role');
                                ?>

                                <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-content'); ?>>
                                    <?php
                                        the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header>' );
                                    ?>
                                    <?php if(has_post_thumbnail()): ?>
                                    <div class="item--image">
                                        <div class="entry-thumbnail not-full"><?php the_post_thumbnail('full');?></div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="entry-content">
                                        <?php
                                        the_content();
                                        ?>
                                    </div><!-- .entry-content -->

                                    <footer class="entry-footer">
                                        <div class="entry-meta-footer clearfix">
                                            <?php the_tags('<span class="tags-list"><i class="fa fa-tags"></i>',', ','</span>') ;?>
                                            <?php
                                            if(Camille()->settings()->get('blog_social_sharing_box') == 'on'){
                                                echo '<div class="la-sharing-posts"><span class="m-sharing-box"><i class="fa fa-share-alt"></i></span>';
                                                camille_social_sharing(get_the_permalink(), get_the_title(), (has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : ''));
                                                echo '</div>';
                                            }
                                            ?>
                                        </div>

                                        <?php edit_post_link( null, '<span class="edit-link hidden">', '</span>' ); ?>

                                    </footer><!-- .entry-footer -->

                                </article><!-- #post-## -->

                            <?php

                            endif;

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
</div>

<!-- .site-main -->
<?php do_action( 'camille/action/after_render_main' ); ?>
<?php get_footer();?>
