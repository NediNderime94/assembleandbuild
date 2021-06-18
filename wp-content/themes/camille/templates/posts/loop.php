<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
$is_main_loop       = camille_get_theme_loop_prop('is_main_loop', false);
$loop_name          = camille_get_theme_loop_prop('loop_name', false);
$show_thumbnail     = camille_get_theme_loop_prop('show_thumbnail', true);
$layout             = camille_get_theme_loop_prop('loop_layout', 'grid');
$style              = camille_get_theme_loop_prop('loop_style', 1);
$thumbnail_size     = camille_get_theme_loop_prop('image_size', 'thumbnail');
$title_tag          = camille_get_theme_loop_prop('title_tag', 'h3');
$excerpt_length     = camille_get_theme_loop_prop('excerpt_length', 0);
$show_excerpt       = absint($excerpt_length) > 0 ? true : false;

$height_mode        = camille_get_theme_loop_prop('height_mode', 'original');
$thumb_custom_height= camille_get_theme_loop_prop('height', '');

if($layout == 'grid' && ($style == 6 || $style == 8) ){
    $show_excerpt = false;
}

$post_class = array('loop__item', 'blog__item', 'grid-item');
$post_class[] = ($show_excerpt ? 'show' : 'hide') . '-excerpt';

$thumb_css_style = '';
$thumb_css_class = ' gitem-zone-height-mode-' . $height_mode;
$thumb_src = '';
$thumb_width = $thumb_height = 0;
if (!has_post_thumbnail() || ($is_main_loop && !$show_thumbnail)) {
    $post_class[] = 'no-featured-image';
}
else{
    if($thumbnail_obj = Camille()->images()->get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size )){
        list( $thumb_src, $thumb_width, $thumb_height ) = $thumbnail_obj;
        if( $thumb_width > 0 && $thumb_height > 0 ) {
            $thumb_css_style .= 'padding-bottom:' . round( ($thumb_height/$thumb_width) * 100, 2 ) . '%;';

            if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'photon' ) ) {
                $photon_args = array(
                    'resize' => $thumb_width . ',' . $thumb_height
                );
                $thumb_src = wp_get_attachment_url( get_post_thumbnail_id() );
                $thumb_src = jetpack_photon_url( $thumb_src, $photon_args );
            }
        }
    }
}

if ( 'custom' === $height_mode ) {
    if ( strlen( $thumb_custom_height ) > 0 ) {
        if ( preg_match( '/^\d+$/', $thumb_custom_height ) ) {
            $thumb_custom_height .= 'px';
        }
        $thumb_css_style .= 'padding-bottom: ' . $thumb_custom_height . ';';
        $thumb_css_class .= ' gitem-hide-img';
    }
}
elseif ( 'original' !== $height_mode ) {
	$thumb_css_style = '';
    $thumb_css_class .= ' gitem-hide-img gitem-zone-height-mode-auto' . ( strlen( $height_mode ) > 0 ? ' gitem-zone-height-mode-auto-' . $height_mode : '' );
}

$allow_featured_image = true;
if($is_main_loop && !$show_thumbnail){
    $allow_featured_image = false;
}

?>
<div <?php post_class($post_class); ?>>
    <div class="loop__item__inner">
        <div class="loop__item__inner2">
            <?php if( $allow_featured_image ) : ?>
            <div class="loop__item__thumbnail">
                <div class="loop__item__thumbnail--bkg la-lazyload-image<?php echo esc_attr($thumb_css_class); ?>"
                     data-background-image="<?php if(!empty($thumb_src)){ echo esc_url($thumb_src); }?>"
                     style="<?php
                        echo esc_attr($thumb_css_style);
                     ?>"
                ><?php
                    if(has_post_thumbnail()){
                        echo Camille()->images()->render_image($thumb_src, array('width' => $thumb_width, 'height' => $thumb_height, 'alt' => get_the_title()));
                        echo sprintf(
                            '<a href="%s" title="%s" class="loop__item__thumbnail--linkoverlay"><span class="pf-icon pf-icon-link"></span><span class="item--overlay"></span></a>',
                            esc_url(get_the_permalink()),
                            the_title_attribute(array('echo'=>false))
                        );
                    }
                ?></div><?php
                if(has_post_thumbnail()){
                    echo sprintf(
                        '<a href="%s" title="%s" class="loop__item__thumbnail--linkoverlay2"><span class="pf-icon pf-icon-link"></span></a>',
                        esc_url(get_the_permalink()),
                        the_title_attribute(array('echo'=>false))
                    );
                }
                ?>
                <?php
                if($layout == 'grid' && $style == 6 ){
                    camille_entry_meta_item_category_list('<div class="loop__item__termlink blog_item--category-link">', '</div>', '');
                }
                ?>
            </div>
            <?php endif; ?>
            <div class="loop__item__info">
                <?php if($layout == 'grid' && ($style == 7) ){
                    camille_entry_meta_item_category_list('<div class="loop__item__termlink blog_item--category-link">', '</div>', '');
                }?>
                <div class="loop__item__info2">
                    <?php
                    if($layout == 'grid' && ($style == 3 ) ){
                        camille_entry_meta_item_category_list('<div class="loop__item__termlink blog_item--category-link">', '</div>', '');
                    }
                    ?>
                    <?php if($layout == 'grid' && ($style == 4 || $style == 5) ){
                        echo '<div class="loop__item__meta">';
                        camille_entry_meta_item_author(false);
                        camille_entry_meta_item_postdate();
                        echo '</div>';
                    }
                    ?>
                    <div class="loop__item__title">
                        <?php the_title(sprintf('<%s class="entry-title"><a href="%s" title="%s">', $title_tag, esc_url(get_the_permalink()), the_title_attribute(array('echo'=>false))), sprintf('</a></%s>', $title_tag)); ?>
                    </div>
                    <?php if ($show_excerpt): ?>
                    <div class="loop__item__desc">
                        <?php
                        echo camille_get_the_excerpt( $loop_name == 'related_posts' ? $excerpt_length : null);
                        ?>
                    </div>
                    <?php endif; ?>
                    <?php if ( $layout != 'grid' || ( $layout == 'grid' && $style != 4 && $style != 5 ) ): ?>
                    <div class="loop__item__meta">
                        <?php
                        camille_entry_meta_item_author($layout == 'grid' && $style == 3 ? true : false);
                        camille_entry_meta_item_postdate();
                        if($layout != 'grid' || ( $layout == 'grid' && !in_array($style, array(3,6,7))) ){
                            camille_entry_meta_item_category_list('<div class="loop__item__meta--item loop__item__termlink blog_item--category-link">', '</div>', '');
                        }
                        ?>
                    </div>
                    <?php endif; ?>
                    <?php
                    if( $layout == 'list' || ($layout == 'grid' && ($style == 4 || $style == 5)) ) {
                        $readmore_class = 'btn-readmore';
                        printf(
                            '<div class="loop__item__meta--footer"><a class="%3$s" href="%1$s">%2$s</a></div>',
                            get_the_permalink(),
                            esc_html_x('Read more', 'front-view', 'camille'),
                            esc_attr($readmore_class)
                        );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>