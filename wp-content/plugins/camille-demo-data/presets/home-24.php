<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function la_camille_preset_home_24()
{
    return array(
        array(
            'key' => 'header_transparency',
            'value' => 'yes'
        ),

        array(
            'key' => 'primary_color|header_link_hover_color|mm_lv_1_hover_color|header_top_link_hover_color|offcanvas_link_hover_color|mb_lv_1_hover_color|mb_lv_2_hover_bg_color|page_title_bar_link_hover_color|transparency_header_link_hover_color',
            'value' => '#e74371'
        ),

        array(
            'key'   => 'transparency_mm_lv_1_hover_color',
            'value' => '#fff'
        ),

        array(
            'key' => 'footer_layout',
            'value' => '4col3333'
        ),

        array(
            'key' => 'footer_background',
            'value' => array(
                'color' => 'transparent'
            )
        ),
        array(
            'key' => 'footer_copyright_background_color',
            'value' => '#212121'
        ),

        array(
            'key' => 'footer_copyright',
            'value' => '<div class="text-center">© Camille Theme by LaStudio. All Right Reserved 2018.</div>'
        ),

        array(
            'key' => 'social_links',
            'value' => array(
                array(
                    'title' => 'Facebook',
                    'link'  => '#',
                    'icon'  => 'fa fa-facebook'
                ),
                array(
                    'title' => 'Twitter',
                    'link'  => '#',
                    'icon'  => 'fa fa-twitter'
                ),
                array(
                    'title' => 'soundcloud',
                    'link'  => '#',
                    'icon'  => 'fa fa-soundcloud'
                ),
                array(
                    'title' => 'youtube',
                    'link'  => '#',
                    'icon'  => 'fa fa-youtube-play'
                ),
                array(
                    'title' => 'vimeo',
                    'link'  => '#',
                    'icon'  => 'fa fa-vimeo'
                )
            )
        ),

        array(
            'key' => 'footer_space',
            'value' => array(
                'padding_top'       => '40px',
                'padding_bottom'    => '20px'
            )
        ),

        array(
            'key' => 'la_custom_css',
            'value' => '
.site-footer {
    background-image: url(//camille.la-studioweb.com/wp-content/uploads/2018/05/m24-bg-4.jpg);
    background-size: cover;
}
.footer-top .footer-column {
    width: 33.33333%;
}
.footer-top .footer-column-1 {
    width: 100%;
    margin-bottom: 30px;
}
.footer-top .footer-column-2 .widget-title {
    font-size: 24px;
    margin-bottom: 10px;
}
.footer-bottom{
    background: none;
}
.footer-column-inner {
    max-width: 270px;
}
.footer-top .footer-column-1 .widget-title {
    font-size: 36px;
    text-transform: uppercase;
    letter-spacing: 5px;
    margin-bottom: 10px;
}

.footer-top .footer-column-1 .footer-column-inner {
    max-width: 100%;
    text-align: center;
}

.footer-top .footer-column-1 .social-media-link {
    font-size: 46px;
}

.footer-top .footer-column-1 .social-media-link a {
    margin: 0 30px;
    color: #2e66ff;
}
.footer-top .footer-column-1 .social-media-link a i{
    background: -webkit-gradient(linear, left top, right top, from(#2e66ff), to(#907bfc));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
'
        ),

        array(
            'filter_name' => 'camille/filter/footer_column_1',
            'value' => 'home-24-footer-1'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_2',
            'value' => 'home-24-footer-2'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_3',
            'value' => 'home-15-footer-2'
        ),
        array(
            'filter_name' => 'camille/filter/footer_column_4',
            'value' => 'home-15-footer-3'
        )
    );
}