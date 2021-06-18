<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$loop_style     = camille_get_theme_loop_prop('loop_style', 1);
$title_tag      = camille_get_theme_loop_prop('title_tag', 'h3');

$role           = Camille()->settings()->get_post_meta(get_the_ID(),'role');
$content        = Camille()->settings()->get_post_meta(get_the_ID(),'content');
$avatar         = Camille()->settings()->get_post_meta(get_the_ID(),'avatar');
$rating         = Camille()->settings()->get_post_meta(get_the_ID(),'rating');
$post_class     = array('loop__item', 'grid-item', 'testimonial_item');

?>
<div <?php post_class($post_class)?>>
    <div class="loop__item__inner">
        <div class="loop__item__inner2">
            <div class="loop__item__thumbnail"><?php if($avatar): ?><div class="loop__item__thumbnail--bkg la-lazyload-image" data-background-image="<?php echo esc_url(wp_get_attachment_image_url($avatar, 'full')); ?>"></div><?php endif; ?></div>
            <div class="loop__item__info">
                <div class="loop__item__desc"><?php echo esc_html($content);?></div>
                <div class="loop__item__info2">
                    <div class="loop__item__title">
                        <?php printf(
                            '<%1$s class="%4$s">%3$s</%1$s>',
                            esc_attr($title_tag),
                            'javascript:;',
                            get_the_title(),
                            'entry-title'
                        ); ?>
                    </div>
                    <div class="loop__item__meta">
                        <?php
                        if(!empty($role)){
                            printf(
                                '<p class="testimonial_item--role">%s</p>',
                                esc_html($role)
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>