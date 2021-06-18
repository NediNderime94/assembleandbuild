<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$thumbnail_size     = camille_get_theme_loop_prop('image_size', 'full');
$title_tag          = camille_get_theme_loop_prop('title_tag', 'h3');
$excerpt_length     = camille_get_theme_loop_prop('excerpt_length', 0);
$show_excerpt       = absint($excerpt_length) > 0 ? true : false;

$height_mode        = camille_get_theme_loop_prop('height_mode', 'original');
$thumb_custom_height= camille_get_theme_loop_prop('height', '');

$post_class = array('loop__item', 'blog__item', 'grid-item');
$post_class[] = ($show_excerpt ? 'show' : 'hide') . '-excerpt';

$thumb_src = '';
$thumb_css_style = '';
$thumb_css_class = ' gitem-zone-height-mode-' . $height_mode;

if (!has_post_thumbnail()) {
    $post_class[] = 'no-featured-image';
}
else{
    if($thumbnail_obj = Camille()->images()->get_attachment_image_src( get_post_thumbnail_id(), $thumbnail_size )){
        list( $thumb_src, $thumb_width, $thumb_height ) = $thumbnail_obj;
        if( $thumb_width > 0 && $thumb_height > 0 ) {
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
} elseif ( 'original' !== $height_mode ) {
    $thumb_css_class .= ' gitem-hide-img gitem-zone-height-mode-auto' . ( strlen( $height_mode ) > 0 ? ' gitem-zone-height-mode-auto-' . $height_mode : '' );
}

?>
<div <?php post_class($post_class); ?>>
    <div class="loop__item__inner">
        <div class="loop__item__inner2">
            <div class="loop__item__thumbnail">
                <div class="loop__item__thumbnail--bkg la-lazyload-image<?php echo esc_attr($thumb_css_class); ?>"
                     data-background-image="<?php if(!empty($thumb_src)){ echo esc_url($thumb_src); }?>"
                     style="<?php
                        echo esc_attr($thumb_css_style);
                     ?>"
                ><?php
                    if(has_post_thumbnail()){
                        echo sprintf(
                            '<a href="%s" title="%s" class="loop__item__thumbnail--linkoverlay"><span class="pf-icon pf-icon-link"></span><span class="item--overlay"></span></a>',
                            esc_url(get_the_permalink()),
                            the_title_attribute(array('echo'=>false))
                        );
                    }
                ?></div>
            </div>
            <div class="loop__item__info">
                <div class="loop__item__info2">
                    <div class="loop__item__meta">
                        <?php
                        camille_entry_meta_item_postdate();
                        ?>
                    </div>
                    <div class="loop__item__title">
                        <?php the_title(sprintf('<%s class="entry-title"><a href="%s" title="%s">', $title_tag, esc_url(get_the_permalink()), the_title_attribute(array('echo'=>false))), sprintf('</a></%s>', $title_tag)); ?>
                    </div>
                    <div class="loop__item__meta--footer">
                        <?php
                        $readmore_class = 'btn-readmore';
                        printf(
                            '<a class="%3$s" href="%1$s">%2$s</a>',
                            get_the_permalink(),
                            esc_html_x('Read more', 'front-view', 'camille'),
                            esc_attr($readmore_class)
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>