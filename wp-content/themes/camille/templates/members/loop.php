<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$loop_style     = camille_get_theme_loop_prop('loop_style', 1);
$thumbnail_size = camille_get_theme_loop_prop('image_size', 'thumbnail');
$title_tag      = camille_get_theme_loop_prop('title_tag', 'h3');
$role           = Camille()->settings()->get_post_meta(get_the_ID(), 'role');
$post_class     = array('loop__item','grid-item','member__item');


$height_mode        = camille_get_theme_loop_prop('height_mode', 'original');
$thumb_custom_height      = camille_get_theme_loop_prop('height', '');
$thumb_css_style = '';
$thumb_css_class = ' gitem-zone-height-mode-' . $height_mode;
$thumb_src = '';
$thumb_width = $thumb_height = 0;
if(has_post_thumbnail()){
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
        $thumb_css_style .= 'height: ' . $thumb_custom_height . ';';
        $thumb_css_class .= ' gitem-hide-img';
    }
}
elseif ( 'original' !== $height_mode ) {
    $thumb_css_class .= ' gitem-hide-img gitem-zone-height-mode-auto' . ( strlen( $height_mode ) > 0 ? ' gitem-zone-height-mode-auto-' . $height_mode : '' );
}
?>
<div <?php post_class($post_class)?>>
    <div class="loop__item__inner">
        <div class="loop__item__inner2">
            <div class="loop__item__thumbnail">
                <div class="loop__item__thumbnail--bkg la-lazyload-image<?php echo esc_attr($thumb_css_class); ?>"
                     data-background-image="<?php if(!empty($thumb_src)){ echo esc_url($thumb_src); }?>"
                     style="<?php echo esc_attr($thumb_css_style); ?>">
                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="loop__item__thumbnail--linkoverlay"><span class="hidden"><?php the_title(); ?></span></a>
                    <?php echo Camille()->images()->render_image($thumb_src, array('width' => $thumb_width, 'height' => $thumb_height, 'alt' => get_the_title())); ?>
                </div>
                <?php
                if(in_array($loop_style, array(2,4,5,6))){
                    Camille()->layout()->render_member_social_tpl(get_the_ID());
                }
                ?>
            </div>
            <div class="loop__item__info">
                <div class="loop__item__info2">
                    <div class="loop__item__title">
                        <?php the_title(sprintf('<%s class="entry-title"><a href="%s" title="%s">', $title_tag, esc_url(get_the_permalink()), the_title_attribute(array('echo'=>false))), sprintf('</a></%s>', $title_tag)); ?>
                    </div>
                    <div class="loop__item__meta">
                        <?php if(!empty($role)){
                            printf(
                                '<p class="member__item__role">%s</p>',
                                esc_html($role)
                            );
                        } ?>
                    </div>
                    <?php if($loop_style == 3): ?>
                    <div class="loop__item__desc"><?php the_excerpt() ?></div>
                    <?php endif; ?>
                    <?php
                    if(!in_array($loop_style, array(2,4,5,6))){
                        Camille()->layout()->render_member_social_tpl(get_the_ID());
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>